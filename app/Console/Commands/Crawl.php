<?php

namespace App\Console\Commands;

use App\Url;
use Illuminate\Console\Command;
use JC\HttpClient\JCRequest;
use PHPHtmlParser\Dom;
use Purl\Url as UrlParser;

class Crawl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawl:url {url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawl url';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
//       Resque::setBackend('localhost:3306');
//       $args = ['name' => 'This is an arg'];
//       Resque::enqueue('default', 'Crawl', $args);
       $url = $this->argument('url');

        // create data for main url
        $this->info("Crawl the main url");
        if($data = $this->loadUrl($url)){
            Url::createUrl($url, $data['title'], $data['description']);
        }

        // create data for sub urls
        $this->info("Crawl the sub urls");
        $urls = $this->getUrlsFromUrl($url);
        foreach ($urls as $url) {
            if($data = $this->loadUrl($url)){
                Url::createUrl($url, $data['title'], $data['description']);
            }
        }

        $this->info("The operation is done");

        return 0;
    }

    public function loadUrl($url)
    {
        $response = JCRequest::get($url, [], [], [
            'connect_timeout' => 2,
            'timeout' => 2
        ]);

        if($response->success() && $dom = $this->loadHTML($response->body())){
            try{
                $title = $dom->find('title')->innerHtml;
                $description = '';

                foreach ($dom->find('meta') as $des) {
                    if (trim($des->getAttribute('name')) == 'description') {
                        $description = $des->getAttribute('content');
                        break;
                    }
                }

                $this->info("Load url with title $title and description $description");
                return ['title' => $title, 'description' => $description];
            }
            catch (\Exception $exception){
                $this->warn($exception->getMessage());
            }
        }

        return false;
    }

    public function getUrlsFromUrl($url)
    {
        $response = JCRequest::get($url, [], [], [
            'connect_timeout' => 2,
            'timeout' => 2
        ]);
        $urls = [];

        if($response->success() && $dom = $this->loadHTML($response->body())){
            $anchors = $dom->find('a');

            foreach ($anchors as $anchor) {
                $href = $anchor->getAttribute('href');
                if (strpos($href, 'http') !== false) {
                    $urls[] = $href;
                } else {
                    if($fixedUrl = $this->fixURLScheme($url, $anchor)){
                        $urls[] = $fixedUrl;
                    }
                }
            }
        }

        $this->warn("Found " . count($urls) . " sub urls");
        return $urls;
    }

    /**
     * return Dom|bool
     */
    public function loadHTML($html){
        $dom = new Dom;
        try{
            $dom->load($html);
        }
        catch (\Exception $exception){
            $this->warn($exception->getMessage());
            return false;
        }

        return $dom;
    }

    public function fixURLScheme($url, $anchor){
        try{
            if(strpos($url,'/') == 0){
                $pUrl = new UrlParser($url);
                return $pUrl->scheme . '://' . $pUrl->host . $anchor->getAttribute('href');
            }
        }
        catch (\Exception $exception){
            $this->warn($exception->getMessage());
        }

        return false;
    }
}

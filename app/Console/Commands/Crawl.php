<?php

namespace App\Console\Commands;

use App\Url;
use Illuminate\Console\Command;
use JC\HttpClient\JCRequest;
use PHPHtmlParser\Dom;

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
        $url = $this->argument('url');

        // create data for main url
        $data = $this->loadUrl($url);
        Url::createUrl($url, $data['title'], $data['description']);

        // create data for sub urls
        $urls = $this->getUrlsFromUrl($url);
        foreach ($urls as $url) {
            $data = $this->loadUrl($url);
            Url::createUrl($url, $data['title'], $data['description']);
        }

        return 0;
    }

    public function loadUrl($url)
    {
        $response = JCRequest::get($url);

        $dom = new Dom;
        $dom->load($response->body());

        $title = $dom->find('title')->innerHtml;
        $description = '';

        foreach ($dom->find('meta') as $des) {
            if (trim($des->getAttribute('name')) == 'description') {
                $description = $des->getAttribute('content');
                break;
            }
        }

        return ['title' => $title, 'description' => $description];
    }

    public function getUrlsFromUrl($url)
    {
        $pUrl = new \Purl\Url($url);

        $response = JCRequest::get($url);
        $dom = new Dom;
        $dom->load($response->body());

        $anchors = $dom->find('a');
        $urls = [];

        foreach ($anchors as $anchor) {
            $href = $anchor->getAttribute('href');
            if (strpos($href, 'http') !== false) {
                $urls[] = $href;
            } else {
                $urls[] = $pUrl->scheme . '://' . $pUrl->host . $anchor->getAttribute('href');
            }
        }

        return $urls;
    }
}

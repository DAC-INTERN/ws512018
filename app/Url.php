<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;

class Url extends Model
{
    protected $table = 'url';

    public static function createUrl($url, $title, $description,$nonAccentTitle,$nonAccentDescription)
    {
        $urlModel = self::on()->where('hash', md5($url))->first();
        if(!$urlModel){
            $urlModel = new self();
        }

        $urlModel->url = $url;
        $urlModel->title = $title;
        $urlModel->description = $description;
        $urlModel->nonAccentTitle = $nonAccentTitle;
        $urlModel->nonAccentDescription = $nonAccentDescription;
        $urlModel->hash = md5($url);
        $urlModel->save();
    }

    public static function Url_query($search,$nonAccentSearch){

        $urls = Url::on()->where('title', 'LIKE', "%$search%")
            ->orWhere('description', 'LIKE', "%$search%")
            ->orWhere('nonAccentTitle', 'LIKE', "%$nonAccentSearch%")
            ->orWhere('nonAccentDescription', 'LIKE', "%$nonAccentSearch%")
            ->paginate(10)->appends(Input::except(['page', '_token']));
        return $urls;
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    protected $table = 'url';

    public static function createUrl($url, $title, $description)
    {
        $urlModel = self::on()->where('hash', md5($url))->first();
        if(!$urlModel){
            $urlModel = new self();
        }

        $urlModel->url = $url;
        $urlModel->title = $title;
        $urlModel->description = $description;
        $urlModel->hash = md5($url);
        $urlModel->save();
    }
}

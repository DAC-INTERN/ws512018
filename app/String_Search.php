<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class String_Search extends Model
{
    protected $table = 'StringSearch';

    public static function create_table($search,$duplicate)
    {
        $Model = new self();
        $Model->Search_String = $search;
        $Model->duplicate = $duplicate;
        $Model->save();
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class String_Search extends Model
{
    protected $table = 'StringSearch';

    public static function create_table($search, $duplicate)
    {
        $Model = new self();
        $Model->Search_String = $search;
        $Model->duplicate = $duplicate;
        $Model->save();
    }

    public static function String_Search_query()
    {
        $predictString = DB::table('StringSearch')->select('Search_String')->get();
        return $predictString;
    }
}

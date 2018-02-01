<?php
/**
 * Created by PhpStorm.
 * User: wolf
 * Date: 30/01/2018
 * Time: 10:45
 */

namespace App\Http\Middleware;
use App\String_Search;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;


class String_Middleware
{
    public static function Save_String_search($request, $search)
    {

        if (isset($request->query()['page'])) {
            $duplicate = true;
            String_Search::create_table($search, $duplicate);
            DB::table('StringSearch')
                ->where('Search_String', $search)
                ->where('duplicate', true)
                ->delete();
        } else {
            $duplicate = false;
            String_Search::create_table($search, $duplicate);
        }
    }

    public static function timeQuery($timeStart)
    {
        $diff = microtime(true) - $timeStart;
        $sec = intval($diff);
        $micro = round(($diff - $sec), 4);
        return $micro;
    }

    public static function utf8convert($str)
    {

        if (!$str) return false;

        $utf8 = array(

            'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',

            'd' => 'đ|Đ',

            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',

            'i' => 'í|ì|ỉ|ĩ|ị|Í|Ì|Ỉ|Ĩ|Ị',

            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',

            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',

            'y' => 'ý|ỳ|ỷ|ỹ|ỵ|Ý|Ỳ|Ỷ|Ỹ|Ỵ',

        );

        foreach ($utf8 as $ascii => $uni) $str = preg_replace("/($uni)/i", $ascii, $str);

        return $str;

    }

    public static function Save_Cache ($search,$urls,$count){

        $data = [
            'string' => $search,
            'result' => $urls,
            'count' => $count,
        ];
        Cache::putMany($data, 1440);
    }

}
<?php

namespace App\Http\Controllers;

use App\Console\Commands\Crawl;
use App\String_Search;
use App\Url;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Input;
use Excel;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index');
    }

    public function search(Request $request)
    {
        $search = $request->input('s');
        $nonAccentSearch = $this->utf8convert($search);
        $timeStart = microtime(true);

        if (empty($search) && !isset($request->query()['page'])) {
            return view('home.search_result')->with('search', $search);
        }

        if (Cache::has('result')) {
            if ($search == Cache::get('string')) {
                $this->Save_String_search($request, $search);

                $urls = Url::on()->where('title', 'LIKE', "%$search%")
                    ->orWhere('description', 'LIKE', "%$search%")
                    ->orWhere('nonAccentTitle', 'LIKE', "%$nonAccentSearch%")
                    ->orWhere('nonAccentDescription', 'LIKE', "%$nonAccentSearch%")
                    ->paginate(10)->appends(Input::except(['page', '_token']));

                return view('home.search_result')->with('urls', $urls)
                    ->with('search', $search)->with('count', Cache::get('count'))
                    ->with('time', Cache::get('time'));
            } else {

                $urls = Url::on()->where('title', 'LIKE', "%$search%")
                    ->orWhere('description', 'LIKE', "%$search%")
                    ->orWhere('nonAccentTitle', 'LIKE', "%$nonAccentSearch%")
                    ->orWhere('nonAccentDescription', 'LIKE', "%$nonAccentSearch%")
                    ->paginate(10)->appends(Input::except(['page', '_token']));

                $count = DB::table('Url')->select(DB::raw('count(*) as count'))
                    ->where('title', 'LIKE', "%$search%")
                    ->orWhere('description', 'LIKE', "%$search%")
                    ->orWhere('nonAccentTitle', 'LIKE', "%$nonAccentSearch%")
                    ->orWhere('nonAccentDescription', 'LIKE', "%$nonAccentSearch%")
                    ->count();

                $diff = microtime(true) - $timeStart;
                $sec = intval($diff);
                $micro = round(($diff - $sec), 4);

                $data = [
                    'string' => $search,
                    'result' => $urls,
                    'count' => $count,
                    'time' => $micro,
                ];
                Cache::putMany($data, 1440);

                $this->Save_String_search($request, $search);

                return view('home.search_result')->with('urls', $urls)
                    ->with('search', $search)->with('count', $count)->with('time', $micro);

            }
        }

    }

    public function Save_String_search($request, $search)
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

    public function utf8convert($str)
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

    public function exportExcel($type)
    {
        $data = DB::table('StringSearch')->where('created_at', '>', date('Y-m-d'))
            ->get()->toArray();
        $data = json_decode(json_encode($data), true);
        return Excel::create('file_String_Search' . '_' . date('Y-m-d'), function ($excel) use ($data) {
            $excel->sheet('mySheet', function ($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        })->download($type);
//        Queue::push(new Crawl('http://vietnamnet.vn/'));
    }
}
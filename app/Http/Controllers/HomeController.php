<?php
namespace App\Http\Controllers;
use App\Http\Middleware\String_Middleware;
use App\Url;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
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
        $nonAccentSearch = String_Middleware::utf8convert($search);
        $timeStart = microtime(true);
        if (empty($search) && !isset($request->query()['page'])) {
            return view('home.search_result')->with('search', $search);
        }
        $urls = Url::Url_query($search,$nonAccentSearch);
        if (Cache::has('result') && $search == Cache::get('string')) {
            $micro = String_Middleware::timeQuery($timeStart);
            String_Middleware::Save_String_search($request, $search);
        } else {
            $count = $urls->total();
            String_Middleware::Save_Cache($search,$urls,$count);
            $micro = String_Middleware::timeQuery($timeStart);
            String_Middleware::Save_String_search($request, $search);
        }
        return view('home.search_result')->with('urls', $urls)
            ->with('search', Cache::get('string'))
            ->with('count', Cache::get('count'))
            ->with('time', $micro);
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
    }
}
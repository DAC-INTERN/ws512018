<?php

namespace App\Http\Controllers;

use App\String_Search;
use App\Url;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Input;


class HomeController extends Controller
{
    public function index()
    {
        return view('home.index');
    }

    public function search(Request $request)
    {
        $search = $request->input('s');

        if (empty($search) && !isset($request->query()['page'])) {
            return view('home.search_result')->with('search', $search);
        }

        $urls = Url::on()->where('title', 'LIKE', "%$search%")
            ->orWhere('description', 'LIKE', "%$search%")
            ->paginate(10)->appends(Input::except(['page','_token']));

        $count = DB::table('Url')->select(DB::raw('count(*) as count'))
            ->where('title', 'LIKE', "%$search%")
            ->orWhere('description', 'LIKE', "%$search%")
            ->count();


        if(isset($request->query()['page'])){
            $duplicate = true;
            String_Search::create_table($search,$duplicate);
            DB::table('StringSearch')
                ->where('Search_String', $search)
                ->where('duplicate', true)
                ->delete();
        }
        else {
            $duplicate = false;
            String_Search::create_table($search,$duplicate);
        }

        return view('home.search_result')->with('urls', $urls)->with('search', $search)->with('count', $count);
    }
}




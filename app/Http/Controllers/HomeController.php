<?php

namespace App\Http\Controllers;

use App\Url;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;

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
            ->paginate(10);

        $count =Url::on()->where('title', 'LIKE', "%$search%")
            ->orWhere('description', 'LIKE', "%$search%")
            ->count();

        return view('home.search_result')->with('urls', $urls)->with('search', $search)->with('count',$count);
    }
}




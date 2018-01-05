<?php

namespace App\Http\Controllers;

use App\Url;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index');
    }

    public function search(Request $request)
    {
        $search = $request->input('s');
        $urls = Url::on()->where('title', 'LIKE', "%$search%")
            ->orWhere('description', 'LIKE', "%$search%")
            ->get();
        return view('home.index')->with('urls', $urls);
    }
}

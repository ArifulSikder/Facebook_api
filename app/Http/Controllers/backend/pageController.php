<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class pageController extends Controller
{
    public function index()
    {
        $pages = Page::all();
        return view('backend.pages.page.index',compact('pages'));
    }
}

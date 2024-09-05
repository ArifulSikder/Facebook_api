<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Statistic;
use Illuminate\Http\Request;

class statisticController extends Controller
{
    public function index()
    {
        $statistics = Statistic::all();
        return view('backend.pages.statistic.index',compact('statistics'));
    }
}

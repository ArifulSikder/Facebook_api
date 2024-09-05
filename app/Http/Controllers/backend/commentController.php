<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class commentController extends Controller
{
    public function index()
    {
        $comments = Comment::all();
        return view('backend.pages.comment.index',compact('comments'));
    }
}

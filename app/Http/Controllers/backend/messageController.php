<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class messageController extends Controller
{
    public function index()
    {
        $messages = Message::all();
        return view('backend.pages.message.index', compact('messages'));
    }
}

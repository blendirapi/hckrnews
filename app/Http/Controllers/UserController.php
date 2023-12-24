<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller {
    public function index($userId) {    
        $user = Http::get("https://hacker-news.firebaseio.com/v0/user/{$userId}.json")->json();
        
        return view('user', ['user' => $user, 'userItems' => $user['submitted']]);
    }    
}

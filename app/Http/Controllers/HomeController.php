<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller {
    public function index() {    
        $stories = Http::get('https://hacker-news.firebaseio.com/v0/topstories.json')->json();
        array_splice($stories, 20);

        return view('home', ['stories' => $stories, 'title' => 'Top Stories']);
    }

    public function new() {    
        $stories = Http::get('https://hacker-news.firebaseio.com/v0/newstories.json')->json();
        array_splice($stories, 20);

        return view('home', ['stories' => $stories, 'title' => 'New Stories']);
    }

    public function best() {
        $stories = Http::get('https://hacker-news.firebaseio.com/v0/beststories.json')->json();
        array_splice($stories, 20);

        return view('home', ['stories' => $stories, 'title' => 'Best Stories']);
    }
}

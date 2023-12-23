<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class StoryController extends Controller {
    public function index($id) {
        $story = Http::get("https://hacker-news.firebaseio.com/v0/item/{$id}.json")->json();

        return view('story', ['story' => $story]);
    }
}

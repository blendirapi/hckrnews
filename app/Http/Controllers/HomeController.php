<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller {
    public static function getFormatedTime($seconds) {
        $measures = array(
            'day' => 24*60*60,
            'hour' => 60*60,
            'minute' => 60,
            'second' => 1,
        );

        foreach ($measures as $label=>$amount) {
            if ($seconds >= $amount) {  
                $howMany = floor($seconds / $amount);
                return $howMany." ".$label.($howMany > 1 ? "s" : "");
            }
        } 

        return "now";
    }   
    
    public function index() {    
        $data = Http::get('https://hacker-news.firebaseio.com/v0/topstories.json')->json();
        array_splice($data, 15);
        
        $stories = [];
        foreach ($data as $storyId) {
            $storyResponse = Http::get("https://hacker-news.firebaseio.com/v0/item/{$storyId}.json");
            $stories[] = $storyResponse->json();
        }

        return view('home', ['stories' => $stories, 'title' => 'Top Stories']);
    }

    public function new() {    
        $data = Http::get('https://hacker-news.firebaseio.com/v0/newstories.json')->json();
        array_splice($data, 15);
        
        $stories = [];
        foreach ($data as $storyId) {
            $storyResponse = Http::get("https://hacker-news.firebaseio.com/v0/item/{$storyId}.json");
            $stories[] = $storyResponse->json();
        }

        return view('home', ['stories' => $stories, 'title' => 'New Stories']);
    }

    public function best() {
        $data = Http::get('https://hacker-news.firebaseio.com/v0/beststories.json')->json();
        array_splice($data, 15);
        
        $stories = [];
        foreach ($data as $storyId) {
            $storyResponse = Http::get("https://hacker-news.firebaseio.com/v0/item/{$storyId}.json");
            $stories[] = $storyResponse->json();
        }

        return view('home', ['stories' => $stories, 'title' => 'Best Stories']);
    }
}

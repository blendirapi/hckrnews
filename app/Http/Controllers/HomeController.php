<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /* public static function getFormatedTime($seconds) {
        // Split the formatted time string into components
        $components = explode(':', $seconds);
    
        // Convert each component to an integer

        dd($components);

        $days = (int)$components[0];
        $hours = (int)$components[1];
        $minutes = (int)$components[2];
        $seconds = (int)$components[3];
    
        // Create an associative array with component names and values
        $timeComponents = [
            'days' => $days,
            'hours' => $hours,
            'minutes' => $minutes,
            'seconds' => $seconds,
        ];
    
        // Find the maximum value among the components
        $maxComponentValue = max($timeComponents);
    
        // Get the name of the maximum component
        $maxComponentName = array_search($maxComponentValue, $timeComponents);
    
        // Format the result
        $result = "$maxComponentValue $maxComponentName";
    
        return $result;
    } */

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
        $response = Http::get('https://hacker-news.firebaseio.com/v0/topstories.json');
    
        $data = $response->json();
        array_splice($data, 20);
        
        $stories = [];
        foreach ($data as $storyId) {
            $storyResponse = Http::get("https://hacker-news.firebaseio.com/v0/item/{$storyId}.json");
            $stories[] = $storyResponse->json();
        }

        return view('home', ['stories' => $stories]);
    }

    public function new() {
        $response = Http::get('https://hacker-news.firebaseio.com/v0/newstories.json');
    
        $data = $response->json();
        array_splice($data, 20);
        
        $stories = [];
        foreach ($data as $storyId) {
            $storyResponse = Http::get("https://hacker-news.firebaseio.com/v0/item/{$storyId}.json");
            $stories[] = $storyResponse->json();
        }

        return view('home', ['stories' => $stories]);
    }

    public function best() {
        $response = Http::get('https://hacker-news.firebaseio.com/v0/beststories.json');
    
        $data = $response->json();
        array_splice($data, 20);
        
        $stories = [];
        foreach ($data as $storyId) {
            $storyResponse = Http::get("https://hacker-news.firebaseio.com/v0/item/{$storyId}.json");
            $stories[] = $storyResponse->json();
        }

        return view('home', ['stories' => $stories]);
    }
}

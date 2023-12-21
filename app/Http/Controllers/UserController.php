<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function index(Request $request) {
        $userId = $request->query('id');
        $response = Http::get("https://hacker-news.firebaseio.com/v0/user/{$userId}.json");
    
        $user = $response->json();

        $items = [];
        foreach ($user['submitted'] as $item) {
            $itemResponse = Http::get("https://hacker-news.firebaseio.com/v0/item/{$item}.json");
            $tempItem[] = $itemResponse->json();

            if ($tempItem[0]['type'] == 'story' && !isset($tempItem[0]['dead'])) {
                $items[] = $itemResponse->json();

                if(count($items) == 10) {
                    break;
                }
            }

            unset($tempItem);
        }
        
        return view('user', ['user' => $user, 'items' => $items]);
    }    
}

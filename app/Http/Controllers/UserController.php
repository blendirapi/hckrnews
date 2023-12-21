<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function index(Request $request) {
        $userId = $request->query('id');
        $response = Http::get("https://hacker-news.firebaseio.com/v0/user/{$userId}.json");
    
        $data = $response->json();

        array_splice($data['submitted'], 10);

        $items = [];
        foreach ($data['submitted'] as $item) {
            $itemResponse = Http::get("https://hacker-news.firebaseio.com/v0/item/{$item}.json");

            //if($itemResponse['submitted'] == 0)
            $items[] = $itemResponse->json();
        }

        dd($items);
        
        return view('user', $data);

        //submitted

    }    
}

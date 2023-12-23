<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>{{ $story['title'] }} | HCKRNEWS</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-neutral-100">
        @include('layouts.header')
        <div class="mx-80 mt-5">
            @if(isset($story['url']))
                <span class="text-2xl">{{ $story['title'] }}</span>
                <span class="hover:underline text-slate-600 text-md italic">
                    <a href="{{ $story['url'] }}" target="_blank">({{ parse_url($story['url'], PHP_URL_HOST) }})</a>
                </span>
            @else
                <span class="text-2xl">{{ $story['title'] }}</span>
            @endif
            <br>
            <span class="inline-flex">
                <a href="user/{{ $story['by'] }}">
                    <span class="text-sm ml-0.5">by  <span class="hover:underline font-semibold">{{ $story['by'] }}</span></span>
                </a>
            </span>

            <div class="flex items-center text-sm">
                <span class="inline-flex mr-1 my-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-zinc-600 w-5 h-5">
                        <path fill-rule="evenodd" d="M10 15a.75.75 0 01-.75-.75V7.612L7.29 9.77a.75.75 0 01-1.08-1.04l3.25-3.5a.75.75 0 011.08 0l3.25 3.5a.75.75 0 11-1.08 1.04l-1.96-2.158v6.638A.75.75 0 0110 15z" clip-rule="evenodd"/>
                    </svg>
                    @if($story['score'] != 1)
                        <span>{{ $story['score'] }} points</span>
                    @else
                        <span>1 point</span>
                    @endif
                </span>
                <span class="inline-flex items-center mx-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-zinc-600 w-4 h-4">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd"/>
                    </svg>
                    <span class="ml-0.5">{{ $story['time'] }} ago</span>
                </span>
                <span class="inline-flex mx-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-zinc-600 w-4 h-4">
                        <path fill-rule="evenodd" d="M10 2c-2.236 0-4.43.18-6.57.524C1.993 2.755 1 4.014 1 5.426v5.148c0 1.413.993 2.67 2.43 2.902 1.168.188 2.352.327 3.55.414.28.02.521.18.642.413l1.713 3.293a.75.75 0 001.33 0l1.713-3.293a.783.783 0 01.642-.413 41.102 41.102 0 003.55-.414c1.437-.231 2.43-1.49 2.43-2.902V5.426c0-1.413-.993-2.67-2.43-2.902A41.289 41.289 0 0010 2zM6.75 6a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5zm0 2.5a.75.75 0 000 1.5h3.5a.75.75 0 000-1.5h-3.5z" clip-rule="evenodd"/>
                    </svg>
                    @if($story['descendants'] == 1)
                        <span class="ml-0.5">1 comment</span>
                    @else
                        <span class="ml-0.5">{{ $story['descendants'] }} comments</span>
                    @endif
                </span>
            </div>

            @if(isset($story['text']))
                <div class="text-md text-slate-700">
                    <span class="mt-2">{!! html_entity_decode($story['text']) !!}</span>
                </div>  
            @endif
        </div>
        {{ dd($story) }}
        @include('layouts.footer')
    </body>
</html>

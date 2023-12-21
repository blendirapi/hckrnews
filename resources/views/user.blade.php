@php
    use App\Http\Controllers\HomeController;
@endphp

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>{{ $id }} | HCKRNEWS</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-100">
        <div class="mx-96 mt-5">
            <div class="flex items-center justify-center text-zinc-800">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-32 h-32"><path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" clip-rule="evenodd" /></svg>
                </div>
            </div>

            <div class="flex items-center justify-center text-zinc-800">
                <div>
                    <p class="text-4xl">{{ $id }}</p>
                </div>
            </div>

            <div class="border-b border-zinc-400 flex items-center justify-center text-zinc-800 pb-2">
                <div>
                    <p class="text-lg">Since: {{ gmdate("Y-m-d", $created) }} | Karma: {{ $karma }}</p>
                </div>
            </div>

            @if(isset($about))
                <div class="border-b border-zinc-400 text-center mx-auto text-zinc-800 pb-2">
                    <p>{!! html_entity_decode($about) !!}</p>
                </div>
            @endif

        </div>
    </body>
</html>

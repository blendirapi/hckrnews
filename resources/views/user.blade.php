<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>{{ $user['id'] }} | HCKRNEWS</title>
        <script src="https://cdn.tailwindcss.com"></script>

        <script>
            const storiesOlElement = document.getElementById("storiesList");

            const userItems = @json($userItems);
            
            userItems.forEach(id => {
                fetch('https://hacker-news.firebaseio.com/v0/item/' + id +'.json')
                    .then(response => response.json())
                    .then(storyData => {
                        if(storyData.type == 'story' && !storyData.dead && !storyData.deleted && Object.keys(storyData).length > 2) {
                            if(storyData.url){
                                var storyUrl = new URL(storyData.url);
                                var storyUrl = storyUrl.hostname;
                            }

                            var template = document.getElementById("storyTemplate");
                            var newStory = document.importNode(template.content, true);

                            newStory.getElementById("title").innerHTML = storyData.title;
                            newStory.getElementById("title").setAttribute("href", "/story/" + storyData.id);

                            if (storyData.url) {
                                newStory.getElementById("external_link").innerHTML =  "(" + storyUrl + ")";
                                newStory.getElementById("external_link").setAttribute("href", storyData.url);
                            }

                            if(storyData.score == 1){
                                newStory.getElementById("points").innerHTML = storyData.score + " point";
                            } else {
                                newStory.getElementById("points").innerHTML = storyData.score + " points";
                            }

                            newStory.getElementById("author").innerHTML = storyData.by;
                            newStory.getElementById("author").setAttribute("href", "/user/" + storyData.by);

                            newStory.getElementById("time").innerHTML = getFormattedTime(storyData.time) + " ago";

                            if(storyData.descendants == 1){
                                newStory.getElementById("comments").innerHTML = storyData.descendants + " comment";
                                newStory.getElementById("comments").setAttribute("href", "/story/" + storyData.id);
                            } else {
                                newStory.getElementById("comments").innerHTML = storyData.descendants + " comments"
                                newStory.getElementById("comments").setAttribute("href", "/story/" + storyData.id);
                            }
                            
                            storiesList.appendChild(newStory);
                        }
                    })
                    .catch(error => console.error('Error fetching data:', error));
            });

            function getFormattedTime(seconds) {
                seconds = (Date.now() / 1000) - seconds;
                const measures = {
                    day: 24 * 60 * 60,
                    hour: 60 * 60,
                    minute: 60,
                    second: 1,
                };
            
                for (const [label, amount] of Object.entries(measures)) {
                    if (seconds >= amount) {
                        const howMany = Math.floor(seconds / amount);
                        return `${howMany} ${label}${howMany > 1 ? 's' : ''}`;
                    }
                }
            
                return 'now';
            }
        </script>
    </head>
    <body class="bg-neutral-100">
        @include('layouts.header')
        <div class="mx-80 mt-5">
            <div class="flex items-center justify-center text-zinc-700">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-32 h-32"><path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" clip-rule="evenodd" /></svg>
                </div>
            </div>

            <div class="flex items-center justify-center text-zinc-800">
                <div>
                    <span class="text-4xl">{{ $user['id'] }}</span>
                </div>
            </div>

            <div class="flex items-center justify-center text-zinc-800 my-2">
                <div>
                    <span class="text-lg">Since: {{ gmdate("Y-m-d", $user['created']) }} | Karma: {{ $user['karma'] }}</span>
                </div>
            </div>

            @if(isset($user['about']))
                <div class="text-center mx-auto text-zinc-800 mb-2">
                    <span>{!! html_entity_decode($user['about']) !!}</span>
                </div>
            @endif

            <ol id="storiesList">
                
            </ol>
        </div>

        @include('layouts.footer')

        <template id="storyTemplate">
            <li class="rounded-lg hover:bg-neutral-200 hover:scale-105 hover:shadow-md transform-gpu duration-150 p-3">
                <div class="mb-1">
                    <span class="text-lg">
                        <a id="title" href="" target="_blank"></a>
                    </span>
                    <br>
                    <span class="hover:underline text-slate-600 text-md italic">
                        <a id="external_link" href="" target="_blank"></a>
                    </span>
                </div>
                <div class="flex items-center text-sm">
                    <span class="inline-flex mx-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-zinc-600 w-5 h-5">
                            <path fill-rule="evenodd" d="M10 15a.75.75 0 01-.75-.75V7.612L7.29 9.77a.75.75 0 01-1.08-1.04l3.25-3.5a.75.75 0 011.08 0l3.25 3.5a.75.75 0 11-1.08 1.04l-1.96-2.158v6.638A.75.75 0 0110 15z" clip-rule="evenodd"/>
                        </svg>
                        <span id="points"></span>
                    </span>
                    <span class="inline-flex hover:bg-neutral-300 rounded-lg mx-1">
                        <a class="inline-flex items-center pl-0.5 pr-1" href="">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-zinc-600 w-4 h-full">
                                <path d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 00-13.074.003"/>
                            </svg>
                            <span class="ml-0.5">
                                <a id="author" href="" target="_blank"></a>
                            </span>
                        </a>
                    </span>
                    <span class="inline-flex items-center mx-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-zinc-600 w-4 h-4">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd"/>
                        </svg>
                        <span id="time" class="ml-0.5"></span>
                    </span>
                    <span class="inline-flex hover:bg-neutral-300 rounded-lg mx-1">
                        <a class="inline-flex items-center pl-0.5 pr-1" href="">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-zinc-600 w-4 h-4">
                                <path fill-rule="evenodd" d="M10 2c-2.236 0-4.43.18-6.57.524C1.993 2.755 1 4.014 1 5.426v5.148c0 1.413.993 2.67 2.43 2.902 1.168.188 2.352.327 3.55.414.28.02.521.18.642.413l1.713 3.293a.75.75 0 001.33 0l1.713-3.293a.783.783 0 01.642-.413 41.102 41.102 0 003.55-.414c1.437-.231 2.43-1.49 2.43-2.902V5.426c0-1.413-.993-2.67-2.43-2.902A41.289 41.289 0 0010 2zM6.75 6a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5zm0 2.5a.75.75 0 000 1.5h3.5a.75.75 0 000-1.5h-3.5z" clip-rule="evenodd"/>
                            </svg>
                            <span class="ml-0.5">
                                <a id="comments" href="" target="_blank"></a>
                            </span>
                        </a>
                    </span>
                </div>
            </li>
        </template>
    </body>
</html>

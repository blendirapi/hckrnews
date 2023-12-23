@php
    use App\Http\Controllers\HomeController;
@endphp

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>{{ $title }} | HCKRNEWS</title>
        <script src="https://cdn.tailwindcss.com"></script>

        <script>
            const storiesOlElement = document.getElementById("storiesList");

            const storiesIds = @json($stories);
            storiesIds.forEach(getStories);

            function getStories(id) {
                fetch('https://hacker-news.firebaseio.com/v0/item/' + id +'.json')
                    .then(response => response.json())
                    .then(storyData => {
                        if(storyData.url){
                            var storyUrl = new URL(storyData.url);
                            var storyUrl = storyUrl.hostname;
                        }
                        var newStoryListItem = document.createElement('li');
                        newStoryListItem.className = 'border-b border-zinc-300 hover:border-zinc-500 p-3';
                        
                        newStoryListItem.innerHTML = `
                            <div class="mb-1">
                                ${(() => {
                                    if (storyData.url) {
                                        return `
                                            <span class="text-lg">
                                                <a href="story/${storyData.id}" target="_blank">${storyData.title}</a>
                                            </span>
                                            <br>
                                            <span class="hover:underline text-slate-600 text-md">
                                                <a href="${storyData.url}" target="_blank">(${storyUrl})</a>
                                            </span>`;
                                    } else {
                                        return `<a class="text-lg" href="google.com">${storyData.title}</a>`;
                                    }
                                })()}
                            </div>
                            <div class="flex items-center text-sm">
                                <span class="inline-flex mx-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-zinc-600 w-5 h-5"><path fill-rule="evenodd" d="M10 15a.75.75 0 01-.75-.75V7.612L7.29 9.77a.75.75 0 01-1.08-1.04l3.25-3.5a.75.75 0 011.08 0l3.25 3.5a.75.75 0 11-1.08 1.04l-1.96-2.158v6.638A.75.75 0 0110 15z" clip-rule="evenodd"/></svg>
                                    ${(() => {
                                        if (storyData.score != 1) {
                                            return `<p>${storyData.score} points</p>`;
                                        } else {
                                            return `<p>1 point</p>`;
                                        }
                                    })()}
                                </span>
                                <span class="inline-flex hover:bg-neutral-200 rounded-lg mx-1">
                                    <a class="inline-flex items-center pl-0.5 pr-1" href="user/${storyData.by}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-zinc-600 w-4 h-full">
                                            <path d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 00-13.074.003"/>
                                        </svg>
                                        <p class="ml-0.5">${storyData.by}</p>
                                    </a>
                                </span>
                                <span class="inline-flex items-center mx-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-zinc-600 w-4 h-4"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd"/></svg>
                                    <p class="ml-0.5">${getFormattedTime(storyData.time)} ago</p>
                                </span>
                                <span class="inline-flex hover:bg-neutral-200 rounded-lg mx-1">
                                    <a class="inline-flex items-center pl-0.5 pr-1" href="story/${storyData.id}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="text-zinc-600 w-4 h-4"><path fill-rule="evenodd" d="M10 2c-2.236 0-4.43.18-6.57.524C1.993 2.755 1 4.014 1 5.426v5.148c0 1.413.993 2.67 2.43 2.902 1.168.188 2.352.327 3.55.414.28.02.521.18.642.413l1.713 3.293a.75.75 0 001.33 0l1.713-3.293a.783.783 0 01.642-.413 41.102 41.102 0 003.55-.414c1.437-.231 2.43-1.49 2.43-2.902V5.426c0-1.413-.993-2.67-2.43-2.902A41.289 41.289 0 0010 2zM6.75 6a.75.75 0 000 1.5h6.5a.75.75 0 000-1.5h-6.5zm0 2.5a.75.75 0 000 1.5h3.5a.75.75 0 000-1.5h-3.5z" clip-rule="evenodd"/></svg>
                                        ${(() => {
                                            if (storyData.descendants == 1) {
                                                return `<p class="ml-0.5">1 comment</p>`;
                                            } else {
                                                return `<p class="ml-0.5">${storyData.descendants} comments</p>`;
                                            }
                                        })()}
                                    </a>
                                </span>
                            </div>`;
                                    
                        storiesList.appendChild(newStoryListItem);
                    })
                    .catch(error => console.error('Error fetching data:', error));
                }

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
    <body>
        <div class="mx-96 mt-5">
            <div class="flex items-center justify-evenly mb-4 text-lg">

                <div class="inline-flex items-center hover:bg-neutral-200 rounded-lg px-2 py-1">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" data-slot="icon" class="w-6 h-6 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
                        </svg>
                        <p class="m-0">Top</p>
                    </a>
                </div>

                <div class="inline-flex items-center hover:bg-neutral-200 rounded-lg px-2 py-1">
                    <a href="{{ route('new') }}" class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <p class="m-0">New</p>
                    </a>
                </div>

                <div class="inline-flex items-center hover:bg-neutral-200 rounded-lg px-2 py-1">
                    <a href="{{ route('best') }}" class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" data-slot="icon" class="w-6 h-6 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z" />
                        </svg>
                        <p class="m-0">Best</p>
                    </a>
                </div>
            </div>

            <ol id="storiesList">
                
            </ol>
        </div>
    </body>
</html>

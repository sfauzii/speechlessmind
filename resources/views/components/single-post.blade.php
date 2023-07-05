<div>
    <div class="relative">
        <object data="{{ $post->banner_url }}" class="w-full rounded-lg">
            <img class="object-cover object-center w-full h-64 rounded-lg lg:h-80" src="/images/404-image.jpg"
                alt="{{ $post->title }}">
        </object>

        <div class="absolute bottom-0 flex p-3 bg-white dark:bg-gray-900 rounded-tr-lg">
            <img class="object-cover object-center w-10 h-10 rounded-full"src="{{ $post->author->photo_url }}"
                alt="{{ $post->author->name }}">

            <div class="mx-4">
                <h1 class="text-sm text-gray-700 dark:text-gray-200">
                    {{ $post->author->name }}
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $post->created_at->diffForHumans() }}
                </p>
            </div>
        </div>
    </div>

    <h1 class="mt-6 text-xl font-semibold text-gray-800 dark:text-white">
        {{ $post->title }}
    </h1>

    <hr class="w-32 my-6 text-blue-500">

    <span class="px-2 py-1 rounded-full bg-blue-600/20 text-blue-500 text-sm">{{ $post->category->name }}</span>

    <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-3 mt-2">
        {{ $post->excerpt }}
    </p>

    <a href="{{ route('posts.show', $post->slug) }}"
        class="inline-block mt-4 text-blue-500 underline hover:text-blue-400">Read
        more</a>
</div>

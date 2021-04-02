<x-app-layout>
    <div class="w-screen md:w-2/4 md:mx-auto p-4">
        <h1 class="font-sans text-lg font-bold mb-4">{{ $article->title }}</h1>
        <p class="text-grey text-sm mb-3">Written by {{ $article->author->name }} on {{ $article->created_at }}.</p>
        <p class="text-grey text-md mb-3">{{ $article->contents }}</p>
        @can('update', $article)
        <div class="text-right">
            <a class="text-indigo-500 px-2 border border-indigo-500" href="/articles/{{ $article->id }}/edit">Edit</a>
        </div>
        @endcan
    </div>
</x-app-layout>

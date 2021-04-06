<x-app-layout>
    <div class="container my-10 sm:px-20">
      <livewire:category-search-bar/>
        <div class="grid grid-cols-3">
            @forelse ($articles as $article)
             <x-article-card :article="$article"></x-article-card>
            @empty
              <div><h3>No results</h3></div>
            @endforelse
        </div>
        <div>{{ $articles->links() }}</div>
    </div>
</x-app-layout>

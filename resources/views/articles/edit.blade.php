<x-app-layout>
    <div class="w-screen md:w-2/4 md:mx-auto p-4">
      <livewire:article-form :type="'update'" :articleId="$article->id" />
    </div>
</x-app-layout>

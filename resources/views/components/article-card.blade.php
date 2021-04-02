<div class="flex flex-col justify-center p-5">
	<div class='max-w-lg bg-white shadow-md rounded-lg overflow-hidden mx-auto'>
		<div class="py-4 px-8 mt-3">
			<div class="flex flex-col mb-8">
				<h2 class="text-gray-700 font-semibold text-2xl tracking-wide mb-2">{{ $article->title }}</h2>
				<p class="text-gray-500 text-base">{{ $article->abstract }}</p>
			</div>
			<div class="py-4">
				<a href="/articles/{{ $article->id }}" class="block tracking-widest uppercase text-center shadow bg-indigo-500 hover:bg-indigo-700 focus:shadow-outline focus:outline-none text-white text-xs py-3 px-10 rounded">Read</a>
			</div>
		</div>
	</div>
</div>

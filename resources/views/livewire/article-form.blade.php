<form wire:submit.prevent="submit">
    <div class="mb-4">
        <label class="text-xl text-gray-600">Title </label></br>
        <input wire:model.lazy="title" type="text" class="border-2 p-2 w-full @error('title') border-red-500 @enderror"
            name="title" id="title" value="{{ $title }}"></input>
        @error('title')
          <span class="text-red-500">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-4">
        <label class="text-xl text-gray-600">Abstract</label></br>
        <textarea wire:model.lazy="abstract" name="abstract" rows="3"
            class="border-2 w-full @error('abstract') border-red-500 @enderror">{{ $abstract }}</textarea>
        @error('abstract')
          <span class="text-red-500">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-8">
        <label class="text-xl text-gray-600">Contents </label></br>
        <textarea wire:model.lazy="contents" name="contents" rows="10"
            class="border-2 w-full @error('contents') border-red-500 @enderror">{{ $contents }}</textarea>
        @error('contents')
          <span class="text-red-500">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-8">
        <label class="text-xl text-gray-600">Category </label></br>
        <select wire:model.lazy="category_id" class="border-2 border-gray-300 border-r mr-2 p-2" name="category_id">
            <option value="">-- Select category --</option>
            @foreach($categories as $category)
              <option {{ ($category_id === $category->id) ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>


    <div class="mb-8">
        <p>The article is currently {{ $status == 1 ? "published" : "unpublished"}}</p>
    </div>

    <div class="flex p-1">
        @if(Auth::user()->isEditor)
          <select class="border-2 border-gray-300 border-r mr-2 p-2" name="status">
              <option value="0">Save Draft</option>
              <option value="1">Save and Publish</option>
          </select>
        @endif
        <button role="submit" class="p-3 bg-blue-500 text-white hover:bg-blue-400" required>Submit</button>
    </div>
    @if ($errors->any())
      <p class="text-red-500">Something went wrong, check the errors above</p>
    @endif
</form>

<div>
    <form action="/" method="get">
        <div class="relative">
            <!-- <input wire:model="query" type="text" id="category" name="category" class="w-full pl-3 pr-10 py-2 border-2 border-gray-200 rounded-xl hover:border-gray-300 focus:outline-none focus:border-blue-500 transition-colors" placeholder="Search by category..."> -->
            <input wire:model="query" type="text" id="category" name="category" class="form-input w-full" autocomplete="off" placeholder="Search by category...">
            <div class="absolute z-10 list-group bg-white w-full rounded-t-none shadow-lg">
              @if(!empty($categories))
                  @foreach($categories as $category)
                      <a class="p-3" href="/?category={{ $category }}" class="list-item">{{ $category }}</a><br>
                  @endforeach
              @endif
            </div>
            <!-- <button type="submit" class="block w-7 h-7 text-center text-xl leading-0 absolute top-2 right-2 text-gray-400 focus:outline-none hover:text-gray-900 transition-colors"><i class="mdi mdi-magnify">go</i></button> -->

        </div>
    </form>
</div>

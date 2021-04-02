<div>
    <form action="/" method="get">
        <div class="relative">
            <input wire:model="query" type="text" id="category" name="category" class="form-input w-full" autocomplete="off" placeholder="Search by category...">
            <div class="absolute z-10 list-group bg-white w-full rounded-t-none shadow-lg">
              @if(!empty($categories))
                  @foreach($categories as $category)
                      <a class="p-3" href="/?category={{ $category }}" class="list-item">{{ $category }}</a><br>
                  @endforeach
              @endif
            </div>
        </div>
    </form>
</div>

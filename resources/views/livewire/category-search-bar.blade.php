<div>
    <form action="/" method="get">
        <div class="relative">
            <input
              wire:model="query"
              wire:keydown.escape="restore"
              wire:keydown.tab="restore"
              wire:keydown.arrow-up="decrementHighlight"
              wire:keydown.arrow-down="incrementHighlight"
              wire:keydown.enter="selectCategory"
              type="text"
              id="category"
              name="category"
              class="form-input w-full"
              autocomplete="off"
              placeholder="Search by category..."
            />
              <div wire:loading class="absolute z-10 list-group bg-white w-full rounded-t-none shadow-lg">
                <div class="list-item">Searching...</div>
              </div>
              @if(!empty($query))
                <div class="fixed top-0 right-0 bottom-0 left-0" wire:click="restore"></div>
                <div class="absolute z-10 list-group bg-white w-full rounded-t-none shadow-lg">
                  @if(!empty($categories))
                      @foreach($categories as $i => $category)
                        <div class="list-group-item">
                          <a href="/?category={{ $category }}" class="{{ $highlightIndex === $i ? 'bg-blue-100' : '' }}">{{ $category }}</a>
                        </div>
                      @endforeach
                  @else
                      <div class="list-item">No results!</div>
                  @endif
               </div>
             @endif
        </div>
    </form>
</div>

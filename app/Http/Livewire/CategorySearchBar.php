<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;

class CategorySearchBar extends Component
{
    public $query;
    public $categories;

    public function updatedQuery()
    {
        $this->categories = Category::where('name', 'LIKE', '%' . $this->query . '%')
          ->pluck('name')
          ->toArray();
    }

    public function mount()
    {
        $this->query = "";
        $this->categories = [];
    }

    public function render()
    {
        return view('livewire.category-search-bar');
    }
}

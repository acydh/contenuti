<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;

class CategorySearchBar extends Component
{
    public $query;
    public $categories;
    public $highlightIndex;

    public function updatedQuery()
    {
        $this->categories = Category::where('name', 'LIKE', '%' . $this->query . '%')
          ->pluck('name')
          ->toArray();
    }

    public function incrementHighlight()
    {
        if ($this->highlightIndex === count($this->categories) - 1) {
            $this->highlightIndex = 0;
            return;
        }
        $this->highlightIndex++;
    }

    public function decrementHighlight()
    {
        if ($this->highlightIndex === 0) {
            $this->highlightIndex = count($this->categories) - 1;
            return;
        }
        $this->highlightIndex--;
    }

    public function selectCategory()
    {
        $category = $this->categories[$this->highlightIndex] ?? null;
        if ($category) {
            $this->redirect("/?category={$category}");
        }
    }

    public function mount()
    {
        $this->restore();
    }

    public function restore()
    {
        $this->query = "";
        $this->categories = [];
        $this->highlightIndex = 0;
    }

    public function render()
    {
        return view('livewire.category-search-bar');
    }
}

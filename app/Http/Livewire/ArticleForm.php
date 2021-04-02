<?php

namespace App\Http\Livewire;

use Illuminate\Validation\Rule;
use Livewire\Component;
use App\Models\Article;
use App\Models\Category;

class ArticleForm extends Component
{
    public $articleId;
    public $category_id;
    public $title;
    public $type;
    public $abstract;
    public $contents;
    public $status;
    public $categories;

    protected $rules = [
      'title' => 'required|string|max:100',
      'abstract' => 'required|string|max:255',
      'contents' => 'required|string|min:100|max:500',
      'category_id' => 'required|exists:categories,id',
      'status' => 'nullable|sometimes|boolean'
    ];

    public function mount()
    {
        $this->categories = Category::all();

        if ($this->type === "create") {
            $article = new Article();
        } else {
            $article = Article::findOrFail($this->articleId);
            $this->title = $article->title;
            $this->abstract = $article->abstract;
            $this->contents = $article->contents;
            $this->status = $article->status;
            $this->category_id = $article->category_id;
        }
    }

    public function render()
    {
        return view('livewire.article-form');
    }

    public function submit()
    {
        return $this->validate();
    }
}

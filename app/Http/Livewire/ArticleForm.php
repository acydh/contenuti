<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Article;
use App\Models\Category;
use App\Http\Services\ArticleService;
use Illuminate\Support\Facades\Auth;

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
    public $article;
    protected $author_id;
    protected $service;


    protected $rules = [
      'title' => 'required|string|max:100',
      'abstract' => 'required|string|max:255',
      'contents' => 'required|string|min:100|max:500',
      'category_id' => 'required|exists:categories,id',
      'status' => 'nullable|sometimes|boolean'
    ];

    public function __construct()
    {
        $this->service = new ArticleService();
    }
    public function mount()
    {
        $this->categories = Category::all();

        if ($this->type === "create") {
            $this->article = new Article();
        } else {
            $this->article = Article::findOrFail($this->articleId);
            $this->title = $this->article->title;
            $this->abstract = $this->article->abstract;
            $this->contents = $this->article->contents;
            $this->status = $this->article->status;
            $this->category_id = $this->article->category_id;
            $this->author_id = $this->article->author_id;
        }
    }

    public function render()
    {
        return view('livewire.article-form');
    }

    public function submit()
    {
        $this->validate();

        if ($this->type === "create") {
            $this->article = $this->service->save([
              'author_id' => Auth::user()->id,
              'title' => $this->title,
              'abstract' => $this->abstract,
              'contents' => $this->contents,
              'category_id' => $this->category_id,
              'status' => $this->status ?? 0,
            ]);
        }

        if ($this->type === "update") {
            $this->service->update($this->article, [
              'title' => $this->title,
              'abstract' => $this->abstract,
              'contents' => $this->contents,
              'category_id' => $this->category_id,
              'status' => $this->status ?? 0,
            ]);
        }

        return redirect("/articles/{$this->article->id}");
    }
}

<?php

namespace App\Http\Controllers\Views;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Http\Requests\Article\Update as UpdateRequest;
use App\Http\Requests\Article\Create as CreateRequest;
use Illuminate\Support\Arr;
use App\Http\Services\ArticleService;

class ArticleController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new ArticleService();
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $articles = Auth::check() ? Article::everything() : Article::published();
        return view('home', compact('articles'));
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Article $article)
    {
        if (!Auth::check() && !$article->isPublished) {
            return abort(403, 'Unauthorized action.');
        }
        return view('articles.show', compact('article'));
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Article $article)
    {
        return view('articles.edit', compact('article'));
    }

    /**
     * @param  App\Http\Requests\Article\Update  $request
     * @param  \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Article $article)
    {
        $data = $request->validated();

        $isPublishRequest = Arr::exists($data, 'status');

        $this->authorize('update', [$article, $isPublishRequest]);

        $article->title    = ($data['title'] ?? $article->title);
        $article->contents = ($data['contents'] ?? $article->contents);
        $article->status   = ($data['status'] ?? $article->status);

        $article->save();

        return view('articles.show', compact('article'));
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('articles.create');
    }

    /**
     * @param  App\Http\Requests\Article\Create  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $data    = $request->validated();
        $data['author_id'] = $request->user()->id;
        $article = Article::make($data);

        $article->save();
        return view('articles.show', compact('article'));
    }
}

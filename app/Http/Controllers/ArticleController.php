<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Http\Requests\Article\Update as UpdateRequest;
use App\Http\Requests\Article\Create as CreateRequest;
use App\Http\Resources\ArticleResource;
use Illuminate\Support\Arr;
class ArticleController extends Controller
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $categoryId = $request->input('categoryId');
        $articles   = Article::when(
            $categoryId,
            function ($query, $categoryId) {
                return $query->where('categoryId', $categoryId);
            }
        )->paginate();
        return ArticleResource::collection($articles);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function indexGuest(Request $request) {
        $categoryId = $request->input('categoryId');

        $articles = Article::with(['author', 'category'])->where('status', 1)->when(
            $categoryId,
            function ($query, $categoryId) {
                return $query->where('categoryId', $categoryId);
            }
        )->paginate();
        return ArticleResource::collection($articles);
    }

    /**
     * @param  App\Http\Requests\Article\Create  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request) {
        $data    = $request->validated();
        $article = Article::make($data);

        $article->save();
        return new ArticleResource($article);
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        return new ArticleResource(Article::findOrFail($id));
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showGuest($id) {
        $article = Article::findOrFail($id);

        if ($article->isPublished === false) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        return new ArticleResource($article);
    }

    /**
     * @param  App\Http\Requests\Article\Update  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id) {
        $data = $request->validated();

        $isPublishRequest = Arr::exists($data, 'status');

        $article = Article::findOrFail($id);

        $this->authorize('update', [$article, $isPublishRequest]);

        $article->title    = ($data['title'] ?? $article->title);
        $article->contents = ($data['contents'] ?? $article->contents);
        $article->status   = ($data['status'] ?? $article->status);

        $article->save();

        return new ArticleResource($article);
    }

    /** §
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
    }
}

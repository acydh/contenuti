<?php

namespace App\Http\Services;

use App\Models\Article;

class ArticleService
{
    public function save($data)
    {
        $article = Article::make($data);
        $article->save();
        return $article;
    }

    public function update(Article $article, $data)
    {
        $article->update($data);
        return $article;
    }
}

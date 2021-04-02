<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Article extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'author_id',
        'title',
        'abstract',
        'contents',
        'category_id',
        'status'
    ];

    protected $appends = [
      'category_name'
    ];

    /**
     * Relationships
     */

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Model accessors
     */

    public function getIsPublishedAttribute()
    {
        return $this->status == 1;
    }

    public function getCategoryNameAttribute()
    {
        return $this->category->name;
    }

    public function scopePublished($query, $category_search)
    {
        return $query
          ->join('categories', 'articles.category_id', '=', 'categories.id')
          ->where('status', 1)
          ->where("categories.name", "LIKE", "%{$category_search}%")
          ->select("articles.*", "categories.name")
          ->orderBy("created_at", "desc")
          ->paginate(6)
          ->withQueryString();
    }

    public function scopeEverything($query, $category_search)
    {
        return $query
          ->join('categories', 'articles.category_id', '=', 'categories.id')
          ->where("categories.name", "LIKE", "%{$category_search}%")
          ->select("articles.*", "categories.name")
          ->orderBy("created_at", "desc")
          ->paginate(6)
          ->withQueryString();
    }
}

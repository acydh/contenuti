<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function scopePublished($query)
    {
        return $query->where('status', 1)->orderBy("created_at", "desc")->paginate(6);
    }

    public function scopeEverything($query)
    {
        return $query->orderBy("created_at", "desc")->paginate(6);
    }
}

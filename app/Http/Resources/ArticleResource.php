<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'       => $this->id,
            'title'    => $this->title,
            'contents' => $this->contents,
            'abstract' => $this->abstract,
            'author'   => [
                'id'   => $this->author->id,
                'name' => $this->author->name,
            ],
            'category' => $this->category->name,
        ];
    }
}

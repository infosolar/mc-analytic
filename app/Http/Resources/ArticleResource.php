<?php

namespace App\Http\Resources;

use App\Models\Article;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ArticleResource
 * @package App\Http\Resources
 */
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
        /** @var Article $this */
        return [
            'url' => $this->url,
            'name' => $this->name,
            'views' => $this->views,
        ];
    }
}

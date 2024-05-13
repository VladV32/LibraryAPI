<?php

namespace App\Http\Resources;

use App\Models\Book;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'publisher' => $this->resource->publisher,
            'author' => $this->resource->author,
            'genre' => $this->resource->genre,
            'publication_date' => $this->resource->publication_date,
            'word_count' => $this->resource->word_count,
            'price' => $this->resource->price,
        ];
    }
}

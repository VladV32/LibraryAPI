<?php

namespace App\Services;

use App\Filters\BookFilter;
use App\Models\Book;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class BookService
{
    public function getBooks(Request $request): Builder
    {
        return Book::filter(new BookFilter($request))
            ->orderByDesc('created_at')
            ->orderByDesc('id');
    }
}

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

    public function createBook(array $attributesOfBook): Book
    {
        return Book::create($attributesOfBook);
    }

    public function showBook(int $idOfBook): Book
    {
        return Book::findOrFail($idOfBook);
    }

    public function updateBook(int $bookId, array $attributesOfBook): Book
    {
        $book = Book::findOrFail($bookId);

        $book->update($attributesOfBook);

        return $book;
    }

    public function deleteBook(int $idBook): bool
    {
        $book = Book::findOrFail($idBook);

        return $book->delete();
    }
}

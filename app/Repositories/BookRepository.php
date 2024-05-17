<?php

namespace App\Repositories;

use App\Filters\QueryFilter;
use App\Models\Book;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class BookRepository
 * @package App\Repositories
 */
class BookRepository extends BaseRepository
{
    /**
     * @param  int  $bookId
     * @return Book
     */
    public function getBook(int $bookId): Book
    {
        return Book::findOrFail($bookId);
    }

    public function getBooks(QueryFilter $queryFilter, int $perPage): LengthAwarePaginator
    {
        return Book::filter($queryFilter)
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate($perPage);
    }

    public function createBook(array $attributesOfBook): Book
    {
        return Book::create($attributesOfBook);
    }

    public function updateBook(int $bookId, array $attributesOfBook): Book
    {
        $book = Book::findOrFail($bookId);

        $book->update($attributesOfBook);

        return $book;
    }

    public function deleteBook(int $bookId): bool
    {
        $book = Book::findOrFail($bookId);

        return $book->delete();
    }
}

<?php

namespace App\Services;

use App\Filters\QueryFilter;
use App\Models\Book;
use App\Repositories\BookRepository;
use Illuminate\Pagination\LengthAwarePaginator;

readonly class BookService
{
    /**
     * BookService constructor.
     * @param  BookRepository  $bookRepository
     */
    public function __construct(private BookRepository $bookRepository)
    {
        //
    }

    public function getBooks(QueryFilter $queryFilter, int $perPage): LengthAwarePaginator
    {
        return $this->bookRepository->getBooks($queryFilter, $perPage);
    }

    public function createBook(array $attributesOfBook): Book
    {
        return $this->bookRepository->createBook($attributesOfBook);
    }

    public function showBook(int $idOfBook): Book
    {
        return $this->bookRepository->getBook($idOfBook);
    }

    public function updateBook(int $idOfBook, array $attributesOfBook): Book
    {
        return $this->bookRepository->updateBook($idOfBook, $attributesOfBook);
    }

    public function deleteBook(int $idOfBook): bool
    {
        return $this->bookRepository->deleteBook($idOfBook);
    }
}

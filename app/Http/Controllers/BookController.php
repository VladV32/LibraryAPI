<?php

namespace App\Http\Controllers;

use App\Http\Responses\BaseApiResponse;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{

    public function index(): BaseApiResponse
    {
        $books = Book::all();
        return $this->response->data($books);
    }

    public function store(Request $request): BaseApiResponse
    {
        $book = Book::create($request->all());
        return $this->response->data($book)->setStatusCode(201);
    }

    public function show(string $id): BaseApiResponse
    {
        $book = Book::findOrFail($id);
        return $this->response->data($book);
    }

    public function update(Request $request, string $id): BaseApiResponse
    {
        $book = Book::findOrFail($id);
        $book->update($request->all());
        return $this->response->data($book);
    }

    public function destroy(string $id): BaseApiResponse
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return $this->response->data(null)->setStatusCode(204);
    }
}

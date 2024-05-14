<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Http\Resources\BookResource;
use App\Http\Responses\BaseApiResponse;
use App\Models\Book;
use OpenApi\Annotations as OA;

class BookController extends Controller
{
    /**
     * Get a list of all books.
     *
     * @return BaseApiResponse
     *
     * @OA\Get(
     *      path="/api/books",
     *      operationId="getBooksList",
     *      tags={"Books"},
     *      summary="Get list of books",
     *      @OA\Response(
     *          response=200,
     *          description="List of books",
     *          @OA\JsonContent(ref="#/components/schemas/BookResource")
     *      )
     * )
     */
    public function index(): BaseApiResponse
    {
        $books = Book::all();
        return $this->response->data(BookResource::collection($books));
    }

    /**
     * Create a new book.
     *
     * @param  BookStoreRequest  $request
     * @return BaseApiResponse
     *
     * @OA\Post(
     *      path="/api/books",
     *      operationId="createBook",
     *      tags={"Books"},
     *      summary="Create a new book",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/BookStoreRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Book created successfully",
     *          @OA\JsonContent(ref="#/components/schemas/BookResource")
     *      )
     * )
     */
    public function store(BookStoreRequest $request): BaseApiResponse
    {
        $book = Book::create($request->all());
        return $this->response->data(new BookResource($book))->setStatusCode(201);
    }

    /**
     * Get a specific book by ID.
     *
     * @param  int  $id
     * @return BaseApiResponse
     *
     * @OA\Get(
     *      path="/api/books/{id}",
     *      operationId="getBookById",
     *      tags={"Books"},
     *      summary="Get a book by ID",
     *      @OA\Parameter(
     *          name="id",
     *          description="Book ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Book details",
     *          @OA\JsonContent(ref="#/components/schemas/BookResource")
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Book not found"
     *      )
     * )
     */
    public function show(int $id): BaseApiResponse
    {
        $book = Book::findOrFail($id);
        return $this->response->data(new BookResource($book));
    }

    /**
     * Update a specific book by ID.
     *
     * @param  BookUpdateRequest  $request
     * @param  int  $id
     * @return BaseApiResponse
     *
     * @OA\Put(
     *      path="/api/books/{id}",
     *      operationId="updateBook",
     *      tags={"Books"},
     *      summary="Update a book by ID",
     *      @OA\Parameter(
     *          name="id",
     *          description="Book ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/BookUpdateRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Book details",
     *          @OA\JsonContent(ref="#/components/schemas/BookResource")
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Book not found"
     *      )
     * )
     */
    public function update(BookUpdateRequest $request, int $id): BaseApiResponse
    {
        $book = Book::findOrFail($id);
        $book->update($request->all());
        return $this->response->data(new BookResource($book));
    }

    /**
     * Delete a specific book by ID.
     *
     * @param  int  $id
     * @return BaseApiResponse
     *
     * @OA\Delete(
     *      path="/api/books/{id}",
     *      operationId="deleteBook",
     *      tags={"Books"},
     *      summary="Delete a book by ID",
     *      @OA\Parameter(
     *          name="id",
     *          description="Book ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Book deleted successfully"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Book not found"
     *      )
     * )
     */
    public function destroy(int $id): BaseApiResponse
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return $this->response->data(null)->setStatusCode(204);
    }
}

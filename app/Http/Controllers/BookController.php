<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Http\Resources\BookResource;
use App\Http\Resources\BookResourceCollection;
use App\Http\Responses\BaseApiResponse;
use App\Models\Book;
use App\Services\BookService;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class BookController extends BaseController
{
    /**
     * Get a list of all books.
     *
     * @param  Request  $request
     * @param  BookService  $bookService
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
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", description="Bolean status value", example=true),
     *              @OA\Property(property="data", type="object", ref="#/components/schemas/BookResourceCollection"),
     *              @OA\Property(property="errors", type="string", description="String or array of data of response errors", example=null),
     *              @OA\Property(property="notify", type="string", description="String or array of notificaions", example=null)
     *          )
     *      )
     * )
     */
    public function index(Request $request, BookService $bookService): BaseApiResponse
    {
        $books = $bookService->getBooks($request)->paginate(self::DEFAULT_API_PAGINATION);

        return $this->response->data(BookResourceCollection::make($books));
    }

    /**
     * Create a new book.
     *
     * @param  BookStoreRequest  $request
     * @param  BookService  $bookService
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
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", description="Bolean status value", example=true),
     *              @OA\Property(property="data", type="object", ref="#/components/schemas/BookResource"),
     *              @OA\Property(property="errors", type="string", description="String or array of data of response errors", example=null),
     *              @OA\Property(property="notify", type="string", description="String or array of notificaions", example=null)
     *           )
     *      )
     * )
     */
    public function store(BookStoreRequest $request, BookService $bookService): BaseApiResponse
    {
        return $this->response->data(
            BookResource::make($bookService->createBook($request->validated()))
        )->setStatusCode(201);
    }

    /**
     * Get a specific book by ID.
     *
     * @param  int  $id
     * @param  BookService  $bookService
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
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", description="Bolean status value", example=true),
     *              @OA\Property(property="data", type="object", ref="#/components/schemas/BookResource"),
     *              @OA\Property(property="errors", type="string", description="String or array of data of response errors", example=null),
     *              @OA\Property(property="notify", type="string", description="String or array of notificaions", example=null)
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Book not found"
     *      )
     * )
     */
    public function show(int $id, BookService $bookService): BaseApiResponse
    {
        return $this->response->data(BookResource::make($bookService->showBook($id)));
    }

    /**
     * Update a specific book by ID.
     *
     * @param  BookUpdateRequest  $request
     * @param  int  $id
     * @param  BookService  $bookService
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
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", description="Bolean status value", example=true),
     *              @OA\Property(property="data", type="object", ref="#/components/schemas/BookResource"),
     *              @OA\Property(property="errors", type="string", description="String or array of data of response errors", example=null),
     *              @OA\Property(property="notify", type="string", description="String or array of notificaions", example=null)
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Book not found"
     *      )
     * )
     */
    public function update(BookUpdateRequest $request, int $id, BookService $bookService): BaseApiResponse
    {
        return $this->response->data(BookResource::make($bookService->updateBook($id, $request->validated())));
    }

    /**
     * Delete a specific book by ID.
     *
     * @param  int  $id
     * @param  BookService  $bookService
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
    public function destroy(int $id, BookService $bookService): BaseApiResponse
    {
        $bookService->deleteBook($id);

        return $this->response->data(null)->setStatusCode(204);
    }
}

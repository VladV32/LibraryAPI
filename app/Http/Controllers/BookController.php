<?php

namespace App\Http\Controllers;

use App\Filters\BookFilter;
use App\Http\Requests\DestroyBookRequest;
use App\Http\Requests\IndexBookRequest;
use App\Http\Requests\ShowBookRequest;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Http\Resources\BookResourceCollection;
use App\Http\Responses\BaseApiResponse;
use App\Services\BookService;
use OpenApi\Annotations as OA;

class BookController extends BaseController
{
    /**
     * Get a list of all books.
     *
     * @param  IndexBookRequest  $indexBookRequest
     * @param  BookService  $bookService
     * @return BaseApiResponse
     *
     * @OA\Get(
     *      path="/api/books",
     *      operationId="getBooksList",
     *      tags={"Books"},
     *      summary="Get list of books",
     *      @OA\Parameter(
     *          name="Authorization",
     *          in="header",
     *          description="Bearer token",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="List of books",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", description="Boolean status value", example=true),
     *              @OA\Property(property="data", type="object", ref="#/components/schemas/BookResourceCollection"),
     *              @OA\Property(property="errors", type="string", description="String or array of data of response errors", example=null),
     *              @OA\Property(property="notify", type="string", description="String or array of notifications", example=null)
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(ref="#/components/schemas/UnauthenticatedResponce")
     *      )
     * )
     */
    public function index(IndexBookRequest $indexBookRequest, BookService $bookService): BaseApiResponse
    {
        $books = $bookService->getBooks(new BookFilter($indexBookRequest), self::DEFAULT_API_PAGINATION);

        return $this->respondWithCollection(BookResourceCollection::make($books));
    }

    /**
     * Create a new book.
     *
     * @param  StoreBookRequest  $storeBookRequest
     * @param  BookService  $bookService
     * @return BaseApiResponse
     *
     * @OA\Post(
     *      path="/api/books",
     *      operationId="createBook",
     *      tags={"Books"},
     *      summary="Create a new book",
     *      @OA\Parameter(
     *          name="Authorization",
     *          in="header",
     *          description="Bearer token",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreBookRequest")
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
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(ref="#/components/schemas/UnauthenticatedResponce")
     *      )
     * )
     */
    public function store(StoreBookRequest $storeBookRequest, BookService $bookService): BaseApiResponse
    {
        $book = $bookService->createBook($storeBookRequest->validated());

        return $this->respondWithResource(BookResource::make($book), BaseApiResponse::HTTP_CREATED);
    }

    /**
     * Get a specific book by ID.
     *
     * @param  int  $book
     * @param  ShowBookRequest  $showBookRequest
     * @param  BookService  $bookService
     * @return BaseApiResponse
     *
     * @OA\Get(
     *      path="/api/books/{book}",
     *      operationId="getBookById",
     *      tags={"Books"},
     *      summary="Get a book by ID",
     *      @OA\Parameter(
     *          name="Authorization",
     *          in="header",
     *          description="Bearer token",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="book",
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
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(ref="#/components/schemas/UnauthenticatedResponce")
     *      )
     * )
     */
    public function show(int $book, ShowBookRequest $showBookRequest, BookService $bookService): BaseApiResponse
    {
        $showBookRequest->validated();

        $book = $bookService->showBook($book);

        return $this->respondWithResource(BookResource::make($book));
    }

    /**
     * Update a specific book by ID.
     *
     * @param  int  $book
     * @param  UpdateBookRequest  $request
     * @param  BookService  $bookService
     * @return BaseApiResponse
     *
     * @OA\Put(
     *      path="/api/books/{book}",
     *      operationId="updateBook",
     *      tags={"Books"},
     *      summary="Update a book by ID",
     *      @OA\Parameter(
     *          name="Authorization",
     *          in="header",
     *          description="Bearer token",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="book",
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
     *          @OA\JsonContent(ref="#/components/schemas/UpdateBookRequest")
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
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(ref="#/components/schemas/UnauthenticatedResponce")
     *      )
     * )
     */
    public function update(int $book, UpdateBookRequest $request, BookService $bookService): BaseApiResponse
    {
        $book = $bookService->updateBook($book, $request->validated());

        return $this->respondWithResource(BookResource::make($book));
    }

    /**
     * Delete a specific book by ID.
     *
     * @param  int  $book
     * @param  DestroyBookRequest  $destroyBookRequest
     * @param  BookService  $bookService
     * @return BaseApiResponse
     *
     * @OA\Delete(
     *      path="/api/books/{book}",
     *      operationId="deleteBook",
     *      tags={"Books"},
     *      summary="Delete a book by ID",
     *      @OA\Parameter(
     *          name="Authorization",
     *          in="header",
     *          description="Bearer token",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="book",
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
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(ref="#/components/schemas/UnauthenticatedResponce")
     *      )
     * )
     */
    public function destroy(
        int $book,
        DestroyBookRequest $destroyBookRequest,
        BookService $bookService
    ): BaseApiResponse {
        $destroyBookRequest->validated();

        $bookService->deleteBook($book);

        return $this->respondWithNoContent();
    }
}

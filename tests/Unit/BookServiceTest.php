<?php

namespace Tests\Unit;

use App\Filters\BookFilter;
use App\Models\Book;
use App\Repositories\BookRepository;
use App\Services\BookService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class BookServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Drop the fulltext index if it exists
        if (Schema::hasColumn('books', 'title')) {
            Schema::table('books', function (Blueprint $table) {
                $table->dropIndex('books_title_fulltext');
            });
        }

        // Add fulltext index for testing
        Schema::table('books', function (Blueprint $table) {
            $table->fulltext('title');
        });
    }

    public function test_it_can_get_books()
    {
        // Arrange
        $book = Book::factory()->create(['title' => fake()->title]);
        $bookService = new BookService(new BookRepository());
        $perPage = 10;

        // Act
        $result = $bookService->getBooks(new BookFilter(request()), $perPage);

        // Assert
        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertCount(1, $result->items());
        $this->assertTrue($result->contains($book));
    }

    public function test_it_can_filter_books_by_title()
    {
        // Arrange
        $book1 = Book::factory()->create(['title' => 'Book 1']);
        $book2 = Book::factory()->create(['title' => 'Book 2']);
        $book3 = Book::factory()->create(['title' => 'Another']);

        $bookService = new BookService(new BookRepository());
        $request = Request::create('/', 'GET', ['title' => 'Book']);
        $bookFilter = new BookFilter($request);

        // Act
        $filteredBooks = $bookService->getBooks($bookFilter, 10);

        // Assert
        $this->assertCount(2, $filteredBooks->items());
        $this->assertTrue($filteredBooks->contains($book1));
        $this->assertTrue($filteredBooks->contains($book2));
        $this->assertFalse($filteredBooks->contains($book3));
    }

    public function test_it_can_create_book()
    {
        // Arrange
        $bookService = new BookService(new BookRepository());
        $attributesOfBook = [
            'title' => 'Sample Book',
            'publisher' => 'Publisher Name',
            'author' => 'Author Name',
            'genre' => 'Fiction',
            'publication_date' => '2022-01-01',
            'word_count' => 50000,
            'price' => 25.99,
        ];

        // Act
        $result = $bookService->createBook($attributesOfBook);

        // Assert
        $this->assertInstanceOf(Book::class, $result);
        $this->assertDatabaseHas('books', $attributesOfBook);
    }

    public function test_it_can_show_book()
    {
        // Arrange
        $book = Book::factory()->create();
        $bookService = new BookService(new BookRepository());

        // Act
        $result = $bookService->showBook($book->id);

        // Assert
        $this->assertInstanceOf(Book::class, $result);
        $this->assertEquals($book->id, $result->id);
    }

    public function test_it_can_update_book()
    {
        // Arrange
        $book = Book::factory()->create();
        $bookService = new BookService(new BookRepository());
        $newAttributesOfBook = [
            'title' => 'Updated Title',
        ];

        // Act
        $result = $bookService->updateBook($book->id, $newAttributesOfBook);

        // Assert
        $this->assertInstanceOf(Book::class, $result);
        $this->assertEquals($newAttributesOfBook['title'], $result->title);
    }

    public function test_it_can_delete_book()
    {
        // Arrange
        $book = Book::factory()->create();
        $bookService = new BookService(new BookRepository());

        // Act
        $result = $bookService->deleteBook($book->id);

        // Assert
        $this->assertTrue($result);
        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }

    public function test_it_throws_exception_if_book_not_found()
    {
        // Arrange
        $bookService = new BookService(new BookRepository());
        $nonExistentBookId = 999;

        // Assert
        $this->expectException(ModelNotFoundException::class);

        // Act
        $bookService->showBook($nonExistentBookId);
    }
}

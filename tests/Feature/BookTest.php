<?php

namespace Tests\Feature;

use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware();
    }

    public function test_get_list_of_books()
    {
        Book::factory()->count(3)->create();

        $response = $this->get('/api/books');

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
    }

    public function test_create_new_book()
    {
        $bookData = [
            'title' => 'Sample Book',
            'publisher' => 'Publisher Name',
            'author' => 'Author Name',
            'genre' => 'Fiction',
            'publication_date' => '2022-01-01',
            'word_count' => 50000,
            'price' => 25.99,
        ];

        $response = $this->post('/api/books', $bookData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('books', $bookData);
    }

    public function test_show_book()
    {
        /**
         * @var Book $book
         */
        $book = Book::factory()->create();
        $bookResource = new BookResource($book);
        $response = $this->get('/api/books/'.$book->id);

        $response->assertStatus(200);
        $response->assertJson(['data' => $bookResource->resolve()]);
    }

    public function test_update_book()
    {
        /**
         * @var Book $book
         */
        $book = Book::factory()->create();

        $updatedBookData = [
            'title' => 'Updated Book Title',
            'publisher' => 'Updated Publisher Name',
        ];

        $response = $this->put('/api/books/'.$book->id, $updatedBookData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('books', $updatedBookData);
    }

    public function test_delete_book()
    {
        /**
         * @var Book $book
         */
        $book = Book::factory()->create();

        $response = $this->delete('/api/books/'.$book->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }

}

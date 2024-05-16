<?php

namespace Tests\Feature;

use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
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

        $response->assertOk();
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

        $response->assertCreated();
        $response->assertJsonIsObject('data');
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

        $response->assertOk();
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

        $response->assertOk();
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

    public function test_create_new_book_with_invalid_data()
    {
        $invalidBookData = [
            'title' => '',
            'publisher' => 'Publisher Name',
            'author' => 'Author Name',
            'genre' => 'Fiction',
            'publication_date' => 'invalid_date_format',
            'word_count' => 'not_an_integer',
            'price' => 'not_a_number',
        ];

        $response = $this->post('/api/books', $invalidBookData);

        $response->assertStatus(422);

        $response->assertJson(function (AssertableJson $json) {
            $json->where('status', false)
                ->where('data', null)
                ->where('notify', null)
                ->has('errors', function ($errors) {
                    $errors->has('title');
                    $errors->has('publication_date');
                    $errors->has('word_count');
                    $errors->has('price');
                });
        });
    }

    public function test_get_details_of_nonexistent_book()
    {
        $response = $this->get('/api/books/9999');

        $response->assertStatus(404);
    }

    public function test_update_book_with_invalid_data()
    {
        /**
         * @var Book $book
         */
        $book = Book::factory()->create();

        $invalidUpdateData = [
            'title' => '',
            'publisher' => 'Updated Publisher Name',
            'publication_date' => 'invalid_date_format',
        ];

        $response = $this->put('/api/books/'.$book->id, $invalidUpdateData);

        $response->assertStatus(422);
        $response->assertJson(function (AssertableJson $json) {
            $json->where('status', false)
                ->where('data', null)
                ->where('notify', null)
                ->has('errors', function ($errors) {
                    $errors->has('title');
                    $errors->has('publication_date');
                });
        });
    }

    public function test_delete_nonexistent_book()
    {
        $response = $this->delete('/api/books/9999');

        $response->assertStatus(404);
    }
}

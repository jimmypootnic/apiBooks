<?php

namespace Tests\Feature;

use App\Models\Books;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Throwable;

class BooksApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function can_get_all_books(){
        $books = Books::factory(4)->create();

        $response = $this->getJson(route('books.index'));

        $response->assertJsonFragment([
           'title' => $books[0]->title
        ])->assertJsonFragment([
            'title' => $books[1]->title
        ]);
    }

    /** @test */
    function can_get_one_book(){
        $book = Books::factory()->create();

        $response = $this->getJson(route('books.show', $book));

        $response->assertJsonFragment([
            'title' => $book->title
        ]);
    }

    /** @test */
    function can_create_book(){
        $this->postJson(route('books.store'), [] )
        ->assertJsonValidationErrorFor('title');

        $response = $this->postJson(route('books.store'), [
            'title' => 'xxxxxxxxx'
        ]);

        $response->assertJsonFragment([
            'title' => 'xxxxxxxxx'
        ]);

        //nombre de la tabla / datos a verificar
        $this->assertDatabaseHas('books', [
            'title' => 'xxxxxxxxx'
        ]);
    }

    /** @test */
    function can_update_book(){
        $book = Books::factory()->create();

        $this->patchJson(route('books.update', $book), [] )
            ->assertJsonValidationErrorFor('title');

        $response = $this->patchJson(route('books.update', $book), [
            'title' => 'Edited book'
        ]);
        $response->assertJsonFragment([
            'title' => 'Edited book'
        ]);

        $this->assertDatabaseHas('books', [
            'title' => 'Edited book'
        ]);
    }

    /** @test */
    function can_delete_book(){
        $book = Books::factory()->create();

        $this->deleteJson(route('books.destroy', $book))
        ->assertNoContent();

        $this->assertDatabaseCount('books', 0);
    }

}

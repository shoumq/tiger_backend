<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookResource;
use App\Models\Author;
use App\Models\Book;
use App\Models\Cover;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function getBooks(): JsonResponse
    {
        $book = Book::all();
        $book = BookResource::collection($book)->resolve();
        return response()->json($book);
    }

    public function getBookById($book_id): JsonResponse
    {
        $book = Book::where('id', $book_id)->get();
        $book = BookResource::collection($book)->resolve();
        return response()->json($book);
    }

    public function createBook(Request $request): JsonResponse
    {
        $request->validate([
            'title' => ['string', 'min:1', 'max:50'],
            'description' => ['string', 'min:1', 'max:500'],
            'first_name' => ['string', 'min:1'],
            'last_name' => ['string', 'min:1'],
            'second_name' => ['string', 'min:1'],
        ]);

        // Книга
        $book = new Book();
        $book->title = $request->title;
        $book->description = $request->description;
        $book->price = $request->price;
        $book->published_at = $request->published_at;
        $book->save();

        // Обложка
        $cover = new Cover();
        $cover->book_id = $book->id;
        $cover->src = $request->src;
        $cover->save();

        // Автор
        $author = new Author();
        $author->book_id = $book->id;
        $author->first_name = $request->first_name;
        $author->last_name = $request->last_name;
        $author->second_name = $request->second_name;
        $author->save();

        $result = Book::where('id', $book->id)->get();
        $result = BookResource::collection($result)->resolve();

        return response()->json($result);
    }

    public function editBook(Request $request): JsonResponse
    {
        $request->validate([
            'title' => ['string', 'min:1', 'max:50'],
            'description' => ['string', 'min:1', 'max:500'],
            'first_name' => ['string', 'min:1'],
            'last_name' => ['string', 'min:1'],
            'second_name' => ['string', 'min:1'],
        ]);

        // Книга
        $book = Book::where('id', $request->id)->first();
        $book->title = $request->title;
        $book->description = $request->description;
        $book->price = $request->price;
        $book->published_at = $request->published_at;
        $book->save();

        // Обложка
        $cover = Cover::where('book_id', $request->id)->first();
        $cover->src = $request->src;
        $cover->save();

        // Автор
        $author = Author::where('book_id', $request->id)->first();
        $author->first_name = $request->first_name;
        $author->last_name = $request->last_name;
        $author->second_name = $request->second_name;
        $author->save();

        $result = Book::where('id', $request->id)->get();
        $result = BookResource::collection($result)->resolve();

        return response()->json($result);
    }
}

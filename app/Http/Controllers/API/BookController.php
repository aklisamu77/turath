<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // List all books
    public function index()
    {
        return Book::with('meta')->get();
    }

    // Show single book
    public function show($id)
    {
        return Book::with('meta')->findOrFail($id);
    }

    // Create book
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'author' => 'nullable|string',
            'isbn' => 'nullable|string|unique:books',
            'publisher' => 'nullable|string',
            'published_at' => 'nullable|date',
            'summary' => 'nullable|string',
            'meta' => 'nullable|array'
        ]);

        $book = Book::create($request->only('title','author','isbn','publisher','published_at','summary'));

        // Save meta if exists
        if($request->has('meta')){
            foreach($request->meta as $key => $value){
                $book->meta()->create([
                    'meta_key' => $key,
                    'meta_value' => $value
                ]);
            }
        }

        return response()->json($book->load('meta'), 201);
    }

    // Update book
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $request->validate([
            'title' => 'sometimes|required|string',
            'author' => 'nullable|string',
            'isbn' => 'nullable|string|unique:books,isbn,'.$book->id,
            'publisher' => 'nullable|string',
            'published_at' => 'nullable|date',
            'summary' => 'nullable|string',
            'meta' => 'nullable|array'
        ]);

        $book->update($request->only('title','author','isbn','publisher','published_at','summary'));

        if($request->has('meta')){
            foreach($request->meta as $key => $value){
                $book->meta()->updateOrCreate(
                    ['meta_key' => $key],
                    ['meta_value' => $value]
                );
            }
        }

        return response()->json($book->load('meta'));
    }

    // Delete book
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return response()->json(null, 204);
    }
}

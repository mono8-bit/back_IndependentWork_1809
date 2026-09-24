<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookController extends Controller
{

    public function index(): JsonResponse
    {
        $books = Book::all();
        return response()->json($books, 200, [], JSON_PRETTY_PRINT);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'author'       => 'required|string|max:255',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'published_at' => 'nullable|date',
        ]);

        $book = Book::create($validated);

        return response()->json($book, 201, [], JSON_PRETTY_PRINT);
    }


    public function show(int $id): JsonResponse
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'message' => "Книга с ID {$id} не найдена",
            ], 404, [], JSON_PRETTY_PRINT);
        }

        return response()->json($book, 200, [], JSON_PRETTY_PRINT);
    }


    public function update(Request $request, int $id): JsonResponse
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'message' => "Книга с ID {$id} не найдена",
            ], 404, [], JSON_PRETTY_PRINT);
        }

        $validated = $request->validate([
            'title'        => 'sometimes|required|string|max:255',
            'author'       => 'sometimes|required|string|max:255',
            'description'  => 'nullable|string',
            'price'        => 'sometimes|required|numeric|min:0',
            'published_at' => 'nullable|date',
        ]);

        $book->update($validated);

        return response()->json($book, 200, [], JSON_PRETTY_PRINT);
    }

    public function destroy(int $id): JsonResponse
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'message' => "Книга с ID {$id} не найдена",
            ], 404, [], JSON_PRETTY_PRINT);
        }

        $book->delete();

        return response()->json([
            'message' => "Book deleted successfully",
        ], 200, [], JSON_PRETTY_PRINT);
    }
}

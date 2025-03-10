<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookType;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class BookTypeController extends Controller
{    
    public function index()
    {
        return response()->json(BookType::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'inventory_number_base' => 'required|string',
            'title' => 'required|string|unique:book_types,title',
            'author' => 'required|string',
            'price' => 'required|numeric',
            'copies' => 'required|integer|min:0'
        ]);

        $bookType = BookType::create($request->all());

        $this->updateJsonFile();

        return response()->json([
            'message' => 'Book type added successfully',
            'book_type' => $bookType
        ], 201);
    }

    public function show($id)
    {
        $bookType = BookType::find($id);
        if (!$bookType) {
            return response()->json(['message' => 'Book type not found'], 404);
        }
        return response()->json($bookType, 200);
    }

    public function update(Request $request, $id)
    {
        $bookType = BookType::find($id);
        if (!$bookType) {
            return response()->json(['message' => 'Book type not found'], 404);
        }

        $request->validate([
            'inventory_number_base' => 'sometimes|required|string',
            'title' => 'sometimes|required|string|unique:book_types,title,' . $id,
            'author' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric',
            'copies' => 'sometimes|required|integer|min:0'
        ]);

        $bookType->update($request->all());
        $this->updateJsonFile();

        return response()->json(['message' => 'Book type updated successfully', 'book_type' => $bookType], 200);
    }

    public function destroy(Request $request, $id)
    {
        $bookType = BookType::find($id);
        if (!$bookType) {
            return response()->json(['message' => 'Book type not found'], 404);
        }

        $bookType->delete();
        $this->updateJsonFile();

        return response()->json(['message' => 'Book type deleted successfully'], 200);
    }

    private function updateJsonFile()
    {
        $filePath = storage_path('app/book.json');

        $books = BookType::orderBy('inventory_number_base', 'asc')->get()->map(function ($bookType) {
            return [
                "id" => $bookType->id,
                "inventory_number_base" => $bookType->inventory_number_base,
                "title" => $bookType->title,
                "author" => $bookType->author,
                "price" => $bookType->price,
                "copies" => $bookType->copies
            ];
        })->toArray();

        File::put($filePath, json_encode($books, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}

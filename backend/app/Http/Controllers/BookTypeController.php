<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookType;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use League\Csv\Writer;
use Illuminate\Support\Facades\Artisan;

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

        $this->updateCsvFile();

        return response()->json([
            'message' => __('messages.book_type_added'),
            'book_type' => $bookType
        ], 201);
    }

    public function show($id)
    {
        $bookType = BookType::find($id);
        if (!$bookType) {
            return response()->json(['message' => __('messages.book_type_not_found')], 404);
        }
        return response()->json($bookType, 200);
    }

    public function update(Request $request, $id)
    {
        $bookType = BookType::find($id);
        if (!$bookType) {
            return response()->json(['message' => __('messages.book_type_not_found')], 404);
        }

        $request->validate([
            'inventory_number_base' => 'sometimes|required|string',
            'title' => 'sometimes|required|string|unique:book_types,title,' . $id,
            'author' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric',
            'copies' => 'sometimes|required|integer|min:0'
        ]);

        $bookType->update($request->all());
        $this->updateCsvFile();

        return response()->json(['message' => __('messages.book_type_updated'), 'book_type' => $bookType], 200);
    }

    public function destroy(Request $request, $id)
    {
        $bookType = BookType::find($id);
        if (!$bookType) {
            return response()->json(['message' => __('messages.book_type_not_found')], 404);
        }

        $bookType->delete();
        $this->updateCsvFile();

        return response()->json(['message' => __('messages.book_type_deleted')], 200);
    }

    private function updateCsvFile()
    {
        $csvFile = 'public/booktypes.csv';
        $csvPath = Storage::path($csvFile);

        $books = BookType::orderBy('id', 'asc')->get()->map(function ($bookType) {
            return [
                "id" => $bookType->id,
                "inventory_number_base" => $bookType->inventory_number_base,
                "title" => $bookType->title,
                "author" => $bookType->author,
                "price" => $bookType->price,
                "copies" => $bookType->copies
            ];
        });

        $csv = Writer::createFromPath($csvPath, 'w');

        $csv->insertOne(['id', 'inventory_number_base', 'title', 'author', 'price', 'copies']);

        foreach ($books as $book) {
            $csv->insertOne([
                $book['id'],
                $book['inventory_number_base'],
                $book['title'],
                $book['author'],
                $book['price'],
                $book['copies']
            ]);
        }

        Artisan::call('db:seed', [
            '--class' => 'BookSeeder'
        ]);
    }
}

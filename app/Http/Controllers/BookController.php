<?php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function getBooks()
    {
        $books = Book::with('category')->get();
        return response()->json($books);
    }

    public function createBook(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);

        $book = Book::create($request->all());

        return response()->json($book);
    }

    public function updateBook(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        $book->update($request->all());

        return response()->json($book);
    }

    public function deleteBook($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return response()->json(['message' => 'Book deleted successfully']);
    }

    public function searchBooks($query)
    {
        try {
            $books = Book::where('title', 'like', "%$query%")->get();
            return response()->json($books);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while searching for books'], 500);
        }
    }
    public function getBook($id)
    {
        $book = Book::with('category')->findOrFail($id);
        return response()->json($book);
    }
    public function getBooksByCategory($id)
    {
        if ($id == 'all') {
            $books = Book::with('category')->get(); // Eager-load the category relationship
        } else {
            $books = Book::with('category')->where('category_id', $id)->get();
        }
        return response()->json(['books' => $books]); // Return books in a standard format
    }

    public function index2()
    {
        $categoryId = $request->get('category');
        $books = $categoryId === 'all' 
            ? Book::all() 
            : Book::where('category_id', $categoryId)->get();
        return response()->json(['books' => $books]);
    }
}



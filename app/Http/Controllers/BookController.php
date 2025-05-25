<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookController extends Controller
{
    //Book page
    public function book(Request $request) {
        $data = $request->all();

        $books = Book::query();

        // Optional filters (add more as needed)
        if (!empty($data['title'])) {
            $books->where('title', 'like', '%' . $data['title'] . '%');
        }

        if (!empty($data['author'])) {
            $books->where('author', 'like', '%' . $data['author'] . '%');
        }
        $books = $books->paginate(5);
        return view('Book.book', [
            'books' => $books,
        ]);
    }
    // Add a new book page
    public function book_add() {
        return view('Book.book_add');
    }
    // Book insert
    public function book_store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|min:5|max:13|unique:books,isbn',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0|max:999999.99',
        ]);
        Book::insert([
            'title' => $request->title,
            'author' => $request->author,
            'isbn' => $request->isbn,
            'stock' => $request->stock,
            'price' => $request->price,
            'created_at' => Carbon::now(),
        ]);
        return redirect('/')->withSuccess('Book added successfully');
    } 
    // Book edit
    public function book_edit($book_id) {
        $books = Book::find($book_id);
        return view('Book.book_edit', [
            'book' => $books,
        ]);
    }
    // Book update
    public function book_update(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|min:5|max:13',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0|max:999999.99',
        ]);
        Book::find($request->book_id)->update([
            'title' => $request->title,
            'author' => $request->author,
            'isbn' => $request->isbn,
            'stock' => $request->stock,
            'price' => $request->price,
            'updated_at' => Carbon::now(),
        ]);
        return redirect('/')->withSuccess("Book information updated successfully");
    }
    // Book delete
    public function book_delete($book_id) {
        Book::find($book_id)->delete();
        return back()->withSuccess('Book deleted successfully');
    }
    // Book information 
    public function book_info($book_id) { 
        $book = Book::find($book_id);
        return view('Book.book_info', [
            'book' => $book,
        ]);
    }
}

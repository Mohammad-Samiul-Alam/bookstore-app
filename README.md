# Book Store Laravel Application

A simple Book Store web application built with Laravel and Bootstrap. This project allows users to manage a collection of books, including features for listing, searching, creating, updating, viewing, and deleting books. The UI is styled with Bootstrap 5 for a modern and responsive experience.

---

## 📺 Demo Video
https://github.com/user-attachments/assets/89eecca9-9e54-49c9-84ec-c3dc03c60bfd
## Features

- List all books with pagination
- Search books by title or author
- Add new books (with title, author, ISBN, stock, and price)
- Edit existing book details
- View detailed information for each book
- Delete books
- Responsive and clean Bootstrap 5 UI

## Implementation Details

### Book Model
Located at `app/Models/Book.php`:
```php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
}

```
### Book Database
Located at `database/migrations/2025_05_23_011756_create_books_table.php`:
```php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('author', 255);
            $table->string('isbn', 13)->unique();
            $table->smallInteger('stock')->default(0);
            $table->float('price', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
```

### Book Routes
Located at `routes/web.php` (example methods):

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

Route::get('/', [BookController::class, 'book'])->name('book');
Route::get('/book/add', [BookController::class, 'book_add'])->name('book.add');
Route::post('/book/store', [BookController::class, 'book_store'])->name('book.store');
Route::get('/book/edit/{book_id}', [BookController::class, 'book_edit'])->name('book.edit');
Route::post('/book/update', [BookController::class, 'book_update'])->name('book.update');
Route::get('/book/delete/{book_id}', [BookController::class, 'book_delete'])->name('book.delete');
Route::get('/book/info/{book_id}', [BookController::class, 'book_info'])->name('book.info');
```
### Book Controller
Located at `app/Http/Controllers/BookController.php` (example methods):

```php
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
        $books = $books->paginate(15);
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

```
### BookStore Blade View:-
### Dashboard Blade
Located at `resources/views/layout/dashboard.blade.php`:
```blade
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Bookstore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-bottom: 50px;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }

        a {
            text-decoration: none;
        }

        .hidden.space-x-8.sm\:-my-px.sm\:ms-10.sm\:flex {
            margin-left: 2px !important;
        }

        svg.w-5.h-5 {
            width: 15px;
        }

        nav.flex.items-center.justify-between {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .hidden.sm\:flex-1.sm\:flex.sm\:items-center.sm\:justify-between {
            display: flex;
            align-items: center;
            justify-content: space-around;
        }

        p {
            margin-top: 0;
            margin-bottom: 0;
            margin-left: 10px;
        }

        nav.flex.items-center.justify-between {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 20px;
        }

        span.relative.z-0.inline-flex.rtl\:flex-row-reverse.shadow-sm.rounded-md {
            margin-left: 10px;
        }

        .btn-custom {
            margin: 2px 0;
        }

        .flex.justify-between.flex-1.sm\:hidden {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .flex.justify-between.flex-1 span {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        span.relative.z-0.inline-flex.rtl\:flex-row-reverse.shadow-sm.rounded-md {
            margin-left: 11px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }



        @media (max-width: 576px) {
            .action-buttons {
                display: flex;
                flex-direction: column;
                gap: 0.3rem;
            }

            nav.flex.items-center.justify-between {
                overflow-x: scroll;
            }
        }
    </style>
</head>

<body class="bg-light">

    <!-- Header -->
    <div class="bg-dark py-3 text-center text-white mb-4">
        <h2 class="mb-0"><a href="{{ route('book') }}" class="text-white">Bookstore</a></h2>
    </div>

    <div class="container">
        @yield('content')
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
    < /body>
</html>
```
### Book Blade
Located at `resources/views/book/book.blade.php`:
```blade
@extends('layout.dashboard')
@section('content')
    <!-- Search and New Book -->
    <form method="GET" action="{{ route('book') }}">
        <div class="row g-2 mb-3">
            <div class="col-12 col-md-9">
                <input type="text" name="title" class="form-control" placeholder="Search books">
            </div>
            <div class="col-6 col-md-1">
                <button class="btn btn-primary w-100" type="submit">Search</button>
            </div>
            <div class="col-6 col-md-2">
                <a href="{{ route('book.add') }}" class="btn btn-success w-100">New Book</a>
            </div>
        </div>
    </form>

    <!-- Table -->
    <h2>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    </h2>
    <div class="table-responsive shadow-sm bg-white rounded">
        <table class="table align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>ISBN</th>
                    <th>Author</th>
                    <th>Stock</th>
                    <th>Price (TK)</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($books as $sl => $book)
                    <tr>
                        <td>{{ $books->firstItem() + $sl }}</td>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->isbn }}</td>
                        <td>{{ $book->author }}</td>
                        <td>{{ $book->stock }}</td>
                        <td>{{ $book->price }}</td>
                        <td class="text-center">
                            <a href="{{ route('book.info', $book->id) }}"
                                class="btn btn-info btn-sm text-white btn-custom">Details</a>
                            <a href="{{ route('book.edit', $book->id) }}"
                                class="btn btn-warning btn-sm text-white btn-custom">Update</a>
                            <a href="{{ route('book.delete', $book->id) }}"
                                class="btn btn-danger btn-sm text-white btn-custom"
                                onclick="return confirm('Are you sure you want to delete this book?');">
                                Delete
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="row">
        <div class="col-12">
            {{ $books->links() }}
        </div>
    </div>
@endsection

```
### Book Add Blade
Located at `resources/views/book/book_add.blade.php`:
```blade
@extends('layout.dashboard')
@section('content')
    <div class="container">
        <h2 class="mt-4 f-20 mx-4 mb-2">New Book</h2>
        <form method="POST" action="{{ route('book.store') }}">
            @csrf
            <div class="mx-4 mt-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" class="form-control" id="title">
                @error('title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mx-4 mt-3">
                <label for="author" class="form-label">Author</label>
                <input type="text" name="author" class="form-control">
                @error('author')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mx-4 mt-3">
                <label for="isbn" class="form-label">ISBN</label>
                <input type="text" name="isbn" class="form-control" id="isbn">
                @error('isbn')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mx-4 mt-3">
                <label for="stock" class="form-label">Stock</label>
                <input type="number" name="stock" class="form-control" id="stock">
                @error('stock')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mx-4 mt-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" step="0.01" name="price" class="form-control" id="price">
                @error('price')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mx-4 mt-4">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('book') }}" class="btn btn-danger ms-2">Back</a>
                {{-- <button type="button" class="btn btn-danger ms-2">Back</button> --}}
            </div>
        </form>
    </div>
    {{-- <div class="container">book add</div> --}}
@endsection
```
### Book Information Blade
Located at `resources/views/book/book_info.blade.php`:
```blade
@extends('layout.dashboard')
@section('content')
    <div class="mx-4">
        <a href="{{ route('book', $book->id) }}" class="btn btn-secondary">Back</a>
        <a href="{{ route('book.edit', $book->id) }}" class="btn btn-danger">Edit</a>
    </div>
    <div class="card mx-4 mt-4">
        <div class="card-header">
            <h5 class="pb-2 pt-2 display-6">Book Details</h5>
        </div>
        <div class="card-body">
            <div class="row pb-2">
                <div class="col-md-4"><strong>ID</strong></div>
                <div class="col-md-8">{{ $book->id }}</div>
            </div>
            <hr>
            <div class="row pb-2 pt-2">
                <div class="col-md-4"><strong>Title</strong></div>
                <div class="col-md-8">{{ $book->title }}</div>
            </div>
            <hr>
            <div class="row pb-2 pt-2">
                <div class="col-md-4"><strong>Author</strong></div>
                <div class="col-md-8">{{ $book->author }}</div>
            </div>
            <hr>
            <div class="row pb-2 pt-2">
                <div class="col-md-4"><strong>ISBN</strong></div>
                <div class="col-md-8">{{ $book->isbn }}</div>
            </div>
            <hr>
            <div class="row pb-2 pt-2">
                <div class="col-md-4"><strong>Price</strong></div>
                <div class="col-md-8">{{ $book->price }}</div>
            </div>
            <hr>
            <div class="row pt-2">
                <div class="col-md-4"><strong>Stock</strong></div>
                <div class="col-md-8">{{ $book->stock }}</div>
            </div>
        </div>
    </div>
@endsection
```
### Book Edit Blade
Located at `resources/views/book/book_edit.blade.php`:
```blade
@extends('layout.dashboard')
@section('content')
    <h2 class="mt-4 f-20 mx-4 mb-2">Edit Book</h2>
    <form method="POST" action="{{ route('book.update') }}">
        @csrf
        <div class="mx-4 mt-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="{{ $book->title }}">
            <input type="hidden" name="book_id" class="form-control" value="{{ $book->id }}">
            @error('title')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mx-4 mt-3">
            <label for="author" class="form-label">Author</label>
            <input type="text" name="author" class="form-control" value="{{ $book->author }}">
            @error('author')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mx-4 mt-3">
            <label for="isbn" class="form-label">ISBN</label>
            <input type="text" name="isbn" class="form-control" id="isbn" value="{{ $book->isbn }}">
            @error('isbn')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mx-4 mt-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" name="stock" class="form-control" id="stock" value="{{ $book->stock }}">
            @error('stock')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mx-4 mt-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" step="0.01" name="price" class="form-control" id="price"
                value="{{ $book->price }}">
            @error('price')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mx-4 mt-4">
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="{{ route('book') }}" class="btn btn-danger ms-2">Back</a>
        </div>
    </form>
@endsection
```
![image alt](https://github.com/Mohammad-Samiul-Alam/bookstore-app/blob/a01e69ad8f2c05e2a2b63cf3b81833214e9c6fcd/Screenshot_7.jpg)

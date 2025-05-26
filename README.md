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
### Migration Example
Located at `database/migrations/2025_05_12_114522_create_books_table.php`:
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

![image alt](https://github.com/Mohammad-Samiul-Alam/bookstore-app/blob/a01e69ad8f2c05e2a2b63cf3b81833214e9c6fcd/Screenshot_7.jpg)

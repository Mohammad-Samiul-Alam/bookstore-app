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

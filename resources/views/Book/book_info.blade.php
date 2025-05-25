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
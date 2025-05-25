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
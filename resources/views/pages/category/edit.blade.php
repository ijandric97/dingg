@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Breadcrumb --}}
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('category.index')}}">Categories</a></li>
            <li class="breadcrumb-item"><a href="{{route('category.show', $category->id)}}">{{$category->name}}</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>

    {{-- Title --}}
    <h1>Update Category</h1>

    {{-- Actual Edit Form --}}
    <form method="POST" action="{{route('category.update', $category->id)}}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{old('name', $category->name)}}" required>
            @error('name')
                <small class="form-text text-danger">{{$message}}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description" value="{{old('description', $category->description)}}" required>
            @error('description')
                <small class="form-text text-danger">{{$message}}</small>
            @enderror
        </div>
        <div class="form-group">
            <label class="d-block" for="file">Image</label>
            <img src="{{asset('storage/images/' . $category->image_path)}}" class="d-block rounded dingg-border mb-2" alt="Category picture">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="delete_image" id="delete_image" value="1"> {{-- "1" will be converted to true in backend --}}
                <label class="form-check-label" for="delete_image">Delete Image</label>
            </div>
            <input type="file" class="form-control-file" name="file" id="file">
            <small class="form-text">NOTE: Image will be resized to 320x240.</small>
            @error('file')
                <small class="form-text text-danger">{{$message}}</small>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">✉ Submit</button>
    </form>
</div>
@endsection

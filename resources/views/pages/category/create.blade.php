@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Breadcrumb --}}
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('category.index')}}">Categories</a></li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </nav>

    {{-- Title --}}
    <h1>Create Category</h1>

    {{-- Actual Edit Form --}}
    <form method="POST" action="{{route('category.store')}}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{old('name')}}" required>
            @error('name')
                <small class="form-text text-danger">{{$message}}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description" value="{{old('description')}}" required>
            @error('description')
                <small class="form-text text-danger">{{$message}}</small>
            @enderror
        </div>
        <div class="form-group">
            <label class="d-block" for="file">Image</label>
            <input type="file" class="form-control-file" name="file" id="file">
            <small class="form-text">NOTE: Image will be resized to 320x240.</small>
            @error('file')
                <small class="form-text text-danger">{{$message}}</small>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">✉️ Submit</button>
    </form>
</div>
@endsection

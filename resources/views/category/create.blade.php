@extends('layouts.app')

@section('content')
<div class="container">
    @can('is-admin', Auth::user())
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

    @error('delete_image')
        {{dd($message)}}
    @enderror

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
            <img src="{{asset('storage/images/category/placeholder.png')}}" class="d-block rounded dingg-border mb-2" alt="Category picture">
            <input type="file" class="form-control-file" name="file" id="file">
            <small class="form-text">NOTE: Image will be resized to 320x240.</small>
            @error('file')
            <small class="form-text text-danger">{{$message}}</small>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">✉ Submit</button>
    </form>

    {{-- IF NON ADMIN SOMEHOW GETS TO THE VIEW --}}
    @else
    <div class="alert alert-danger" role="alert">
        ERROR: You are not authorized to view this page!
    </div>
    @endcan
</div>
@endsection

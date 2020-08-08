@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- Breadcrumb --}}
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item">
                    @can('is-admin')
                        <a href="{{route('user.index')}}">Users</a>
                    @else
                        Users
                    @endcan
                </li>
                <li class="breadcrumb-item"><a href="{{route('user.show', $user)}}">{{$user->name}}</a></li>
                <li class="breadcrumb-item"><a href="{{route('user.request.index', $user)}}">Requests</a></li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </nav>

        {{-- Title --}}
        <h1>Create Request</h1>
        <p class="lead">
            In the name put explicitly what you want. (e.g. Create Restaurant Request). <br>
            In the description be as descriptive as possible. (e.g. Restaurant name should be "My Restaurant" etc.).
        </p>

        {{-- Actual Edit Form --}}
        <form method="POST" action="{{route('user.request.store', $user)}}">
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
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" required>
                    <label class="form-check-label" for="available">I agree to the terms and conditions.</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">✉ Submit</button>
        </form>

    </div>
@endsection

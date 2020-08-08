@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- Breadcrumb --}}
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Users</a></li>
                <li class="breadcrumb-item"><a href="{{ route('user.show', $user) }}">{{ $user->name }}</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>

        {{-- Control Panel --}}
        @can('is-admin')
            <div class="card border-primary mb-3">
                <div class="card-header d-flex align-items-center">
                    {{-- Title --}}
                    <p class="lead m-0 align-self-center">Control Panel</p>

                    {{-- Edit Role --}}
                    <form class="ml-auto d-flex" method="POST" action="{{route('user.role', $user)}}">
                        @csrf
                        @method('PUT')

                        <select name="role" class="custom-select w-25 flex-fill mx-2">
                            <option value="user">User</option>
                            <option value="restaurant">Restaurant</option>
                        </select>
                        <button type="submit" class="btn btn-primary ml-auto">📄 Change Role</button>
                    </form>

                    {{-- Create Button --}}

                </div>
            </div>
        @endcan

        {{-- Title --}}
        <h1>Edit User</h1>

        {{-- Actual Edit Form --}}
        <form method="POST" action="{{route('user.update', $user)}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group"> {{-- Phone --}}
                <label for="phone">Phone Number</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone"
                       placeholder="+385 12 3456789" pattern="(\+385)[ ][0-9]{2}[ ][0-9]{6}[0-9]?"
                       value="{{old('phone', $user->phone)}}" required>
                <small class="form-text text-muted">FORMAT: +385 12 3456789</small>
                @error('phone')
                <small class="form-text text-danger">{{$message}}</small>
                @enderror
            </div>
            <div class="form-group"> {{-- Image --}}
                <label class="d-block" for="file">Image</label>
                <img src="{{asset('storage/images/' . $user->image_path)}}" class="d-block rounded dingg-border mb-2"
                     alt="User picture">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="delete_image" id="delete_image"
                           value="1"> {{-- "1" will be converted to true in backend --}}
                    <label class="form-check-label" for="delete_image">Delete Image</label>
                </div>
                <input type="file" class="form-control-file" name="file" id="file">
                <small class="form-text text-muted">NOTE: Image will be resized to 320x240.</small>
                @error('file')
                    <small class="form-text text-danger">{{$message}}</small>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">✉ Submit</button>
        </form>
    </div>
    </div>
@endsection

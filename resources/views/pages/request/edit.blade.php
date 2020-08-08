@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- Breadcrumb --}}
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('request.index')}}">Requests</a></li>
                <li class="breadcrumb-item active">#{{$request->id}}</li>
            </ol>
        </nav>

        {{-- Title --}}
        <h1>Respond to request</h1>
        <br>

        {{-- Actual Edit Form --}}
        <form method="POST" action="{{route('request.update', $request)}}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" value="{{$request->name}}" disabled>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" class="form-control" value="{{$request->description}}" disabled>
            </div>
            <div class="form-group">
                <label for="role">Status</label>
                @if($request->status > 1)
                    <select name="status" class="custom-select" required>
                        <option value=""></option>
                        <option value="1">Approve</option>
                        <option value="0">Decline</option>
                    </select>
                @else
                    <input type="text" class="form-control text-white {{$colors[$request->status]}}" value="{{$request->getStatus()}}" disabled>
                @endif
            </div>
            <button type="submit" class="btn btn-primary">📧 Submit</button>
        </form>

    </div>
@endsection

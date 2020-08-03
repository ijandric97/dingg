@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- Breadcrumb --}}
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('category.index')}}">Categories</a></li>
                <li class="breadcrumb-item active">{{$category->name}}</li>
            </ol>
        </nav>

        {{-- Control Panel --}}
        @can('is-admin')
            <div class="card border-primary mb-3">
                <div class="card-header d-flex">
                    {{-- Title --}}
                    <p class="lead m-0 align-self-center">Control Panel</p>

                    <a class="btn btn-warning ml-auto" href="{{route('category.edit', $category)}}" role="button">✏️
                        Edit</a>

                    {{-- Delete Button --}}
                    <form method="POST" action="{{route('category.destroy', $category)}}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn ml-2 btn-danger" onclick="deleteConfirm(event)">🗑️ Delete
                        </button>
                    </form>
                </div>
            </div>
        @endcan

        {{-- Title and description --}}
        <h1 class="d-inline-block mr-2 mb-3">{{$category->name}}</h1>
        <p class="lead">{{$category->description}}</p>

        {{-- Restaurants --}}
        <x-RestaurantCards :restaurants="$restaurants"></x-RestaurantCards>
    </div>
@endsection

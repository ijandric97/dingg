@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- Breadcrumb --}}
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item active">Search</li>
            </ol>
        </nav>

        {{-- Restaurants --}}
        <h1 class="d-inline-block mr-2 mb-3">Restaurants for
            <span clasS="text-primary">"{{$query}}"</span>
        </h1>
        <x-RestaurantCards :restaurants="$restaurants"></x-RestaurantCards>

        {{-- Pagination --}}
        <div class="mt-2">
            {{$restaurants->links()}}
        </div>
    </div>
@endsection

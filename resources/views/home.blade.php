@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- Message for visitor --}}
        @guest
            <div class="jumbotron dingg-border">
                <h1 class="display-4">Hello, stranger!</h1>
                <p class="lead">Dingg is even better when you register!<br>
                    Place orders, rate and comment on your favourite restaurants.<br>
                    Dingg also offers a user-tailored restaurant recommendation system based on your past orders.<br>
                    {{-- What are you waiting? become a part of Dingg community now. --}}
                </p>

                <hr class="my-4">
                <p>Registration is completely free of charge.</p>
                <a class="btn btn-primary btn-lg" href="{{route('register')}}" role="button">Take me to registration</a>
            </div>
        @else
            {{-- Favorites --}}
            <h1 class="d-inline-block mr-2 mb-3">Favorites ❤️</h1>
            <a class="btn btn-primary align-super" role="button"
               href="{{route('user.show', Auth::user())}}">View All ↗</a> {{-- TODO: user favorites index route --}}
            <x-RestaurantCards :restaurants="$favorites"></x-RestaurantCards> {{-- 3 Random Favorites --}}
            {{--
                User Section
                TODO: we put recommended restaurants for user stuff
            --}}
        @endguest

        {{-- Category --}}
        <h1 class="d-inline-block mr-2 mb-3">Categories</h1> {{-- Categories --}}
        <a class="btn btn-primary align-super" role="button"
           href="{{route('category.index')}}">View All ↗</a>
        <x-CategoryCards :categories="$categories"></x-CategoryCards> {{-- 3 Random Categories --}}

        {{-- Restaurants --}}
        <h1 class="d-inline-block mr-2 mb-3">Restaurants</h1> {{-- Title --}}
        <a class="btn btn-primary align-super" role="button"
           href="{{route('restaurant.index')}}">View All ↗</a>
        <x-RestaurantCards :restaurants="$restaurants"></x-RestaurantCards> {{-- 3 Random Restaurants --}}
    </div>
@endsection

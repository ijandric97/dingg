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
            <!--What are you waiting? become a part of Dingg community now.-->
        </p>

        <hr class="my-4">
        <p>Registration is completely free of charge.</p>
        <a class="btn btn-primary btn-lg" href="{{route('register')}}" role="button">Take me to registration</a>
    </div>
    @else
    {{--
        User Section
        TODO: we put reccomended restaurants for user stuff
    --}}
    @endguest

    {{-- Category --}}
    <h1 class="d-inline-block mr-2 mb-3">Categories</h1> {{-- Categories Title --}}
    @include('includes.category.create-viewall-button')  {{-- Create / View All --}}
    @include('includes.category.cards')                  {{-- 3 Random Categories --}}

    {{-- TODO: Create actual all restaurants list? --}}
    <h1 class="d-inline mr-2">Restaurants</h1> {{-- Restaurants Title --}}
    <a class="btn btn-outline-primary mb-3" href="{{route('category.index')}}" role="button">View all</a>
</div>
@endsection

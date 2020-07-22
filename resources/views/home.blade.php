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

    {{-- Categories Title --}}
    <h1 class="d-inline-block mr-2 mb-3">Categories</h1>
    {{-- Categories Buttons --}}
    @can('is-admin', Auth::user())
    <div class="btn-group" role="group" style="vertical-align: super;">
        <a class="btn btn-success" href="{{route('category.create')}}" role="button">+ Create</a>
        <a class="btn btn-primary" href="{{route('category.index')}}" role="button">View All ↗</a>
    </div>
    @else
        <a class="btn btn-primary" style="vertical-align: super;" href="{{route('category.index')}}" role="button">View all ↗</a>
    @endcan
    {{-- Categories list --}}
    <x-category-cards :categories="$categories"/>

    {{--
        Restaurants
        TODO: Create actual all restaurants list?
    --}}
    <h1 class="d-inline mr-2">Restaurants</h1>
    <a class="btn btn-outline-primary mb-3" href="{{route('category.index')}}" role="button">View all</a>

    {{--
        Restaurant sections
        TODO: change from categories to restaurants
    --}}
    <div class="row justify-content-center mb-5">
        @forelse ($categories as $category)
            <div class="card card-hover-blur bg-dark text-white border-0 m-1 text-right" style="width: 18rem;">
                <div class="border-top border-2 border-orange">
                    <img src="{{asset('storage/images/category/' . $category->image_path)}}" class="card-img-top fb-50" alt="...">
                    <div class="card-img-overlay border-bottom border-2 border-success">
                        <h5 class="card-title text-left" style="margin-bottom:100px;">{{$category->name}}</h5>
                        <span class="badge badge-primary">7 Restaurants</span>
                        <p class="card-text">{{$category->description}}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-danger" role="alert">
                ERROR: No categories found!
            </div>
        @endforelse
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Categories</li>
        </ol>
    </nav>

    <!-- Title -->
    <h1 class="">Categories</h1>

    <!-- Description -->
    @if (count($categories) > 0)
        <p class="lead">Pick restaurants from one of the  {{count($categories)}} delicious categories!</p>
    @endif

    <!-- Categories sections -->
    <div class="row justify-content-center mx-0">

        @forelse ($categories as $category)
            <div class="col-4 p-0">
                <div class="card card-hover-gray bg-dark text-white border-0 m-1">
                    <div class="border-top border-2 border-orange">
                        <img src="{{asset('storage/images/category/' . $category->image_path)}}" class="card-img-top fb-50" alt="...">
                        <div class="card-img-overlay border-bottom border-2 border-success">
                            <h3 class="card-title mb-0 font-weight-bold ">{{$category->name}}</h3>
                            <p class="card-text mb-0 font-weight-bold">{{$category->description}}</p>
                            <span class="badge badge-primary">{{$category->count}} Restaurants</span>
                            <a href="{{route('category.show', $category->id)}}" class="stretched-link"></a>
                        </div>
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
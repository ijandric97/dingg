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

    <h1 class="d-inline-block mr-2 mb-3">{{$category->name}}</h1> {{-- Title --}}
    @include('includes.category.edit-delete-button')              {{-- Edit / Delete --}}
    <p class="lead">{{$category->description}}</p>                {{-- Description --}}

    <!-- Restaurants -->
    <div class="row justify-content-start" style="margin: 0px -3px;">
        @forelse ($category->restaurants as $restaurant)
            <div class="col-md-4 col-sm-6 p-0">
                <div class="card card-hover-blur bg-gradient-dark text-white border-0 m-1">
                    <div class="border-top border-2 border-orange">
                        <img src="{{asset('storage/images/category/' . $category->image_path)}}" class="card-img-top fb-50" alt="...">
                        <div class="card-img-overlay border-bottom border-2 border-success">
                            <h3 class="card-title mb-0 font-weight-bold ">{{$restaurant->name}}</h3>
                            <p class="card-text mb-0 font-weight-bold">{{$restaurant->description}}</p>
                            <h3 class="mt-2" style="margin-left: -20px;">
                                <span class="badge badge-dark font-weight-bold mt-1">{{'⭐  4.6'}}</span>
                            </h3>
                            <a href="{{route('restaurant.show', $restaurant->id)}}" class="stretched-link"></a>
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
@include('includes.category.delete-modal')
@endsection

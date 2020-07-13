@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Page text -->
    <h1>Categories</h1>

    <!-- Categories sections -->
    <div class="row justify-content-center">

        @forelse ($categories as $category)
            <div class="card card-hover-gray bg-dark text-white border-0 m-1 text-right" style="width: 18rem;">
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
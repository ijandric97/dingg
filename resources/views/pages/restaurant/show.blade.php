@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Breadcrumb --}}
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('restaurant.index')}}">Restaurant</a></li>
            <li class="breadcrumb-item active">{{$restaurant->name}}</li>
        </ol>
    </nav>

    <div class="row mb-2"> {{-- Basic Info --}}
        <div class="col-md-4 mb-3">
            <img src="{{asset('storage/images/restaurant/' . $restaurant->image_path)}}" onerror="this.onerror=null; this.src='{{asset('storage/images/restaurant/placeholder.png')}}'" class="d-block m-auto w-100 img-fluid dingg-border rounded" alt="{{$restaurant->name}} picture">
            @auth
                <a href="#" class="btn btn-info btn-lg d-block mx-auto mt-2">Create an order 🍕</a> {{-- Order Button --}}
            @else
                <a href="{{route('register')}}" class="btn btn-secondary btn-lg d-block mx-auto mt-2">Register to order 😊</a>
            @endauth
        </div>
        <div class="col-md-8 text-center text-md-left">
            <h1 class="d-inline-block mr-2 mb-2">{{$restaurant->name}}</h1> {{-- Title --}}
            @include('includes.restaurant.edit-delete-button')              {{-- Edit / Delete --}}
            <p class="lead mb-2">{{$restaurant->description}}</p>           {{-- Description --}}


            <div class="d-inline-block"> {{-- Categories --}}
                @foreach ($restaurant->categories()->get() as $category)
                    <a href="{{route('category.show', $category->id)}}" class="btn btn-dark btn-secondary active mb-2" style="vertical-align: super;" role="button">{{$category->name}}</a>
                @endforeach
            </div>

            <div class="d-inline-block mb-3"> {{-- Rating / Favorite --}}
                <button class="btn btn-danger font-weight-bold disabled" style="opacity: 1; vertical-align: super;">{{'⭐  4.6'}} / 5</button>
                @include('includes.restaurant.favorite-button')
            </div>

            <table class="table table-sm"> {{-- Info --}}
                <tbody>
                    <tr>
                        <th scope="row">Address</th>
                        <td>{{$restaurant->address}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Phone</th>
                        <td><a href="tel:{{$restaurant->phone}}">{{$restaurant->phone}}</a></td>
                    </tr>
                    <tr>
                        <th scope="row">Website</th>
                        <td><a href="{{$restaurant->website}}">{{$restaurant->website}}</></td>
                    </tr>
                </tbody>
            </table>
            <div class="alert alert-primary" role="alert">
                If you have allergies or other dietary restrictions, please contact the restaurant.<br/>
                The restaurant will provide food-specific information upon request.
            </div>
        </div>
    </div>

    {{-- Define days array so we can elegantly for loop this section --}}
    @php ($days = [0 => 'Monday', 1 => 'Tuesday', 2 => 'Wednesday', 3 => 'Thursday', 4 => 'Friday', 5 => 'Saturday', 6 => 'Sunday'])
    <table class="table table-sm">
        <tbody>
            @for ($i = 0; $i < 7; $i++)
            <tr>
                <th scope="row">{{$days[$i]}}</th>
                <td>{{$workhours[$i]['open_time']}} - {{$workhours[$i]['open_time']}}</td>
            </tr>
            @endfor
        </tbody>
    </table>


</div>
@include('includes.category.delete-modal')
@endsection


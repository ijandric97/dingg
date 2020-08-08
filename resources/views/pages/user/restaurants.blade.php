@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- Breadcrumb --}}
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item">
                    @can('is-admin')
                        <a href="{{route('user.index')}}">Users</a>
                    @else
                        Users
                    @endcan
                </li>
                <li class="breadcrumb-item"><a href="{{route('user.show', $user)}}">{{$user->name}}</a></li>
                <li class="breadcrumb-item active">Owned</li>
            </ol>
        </nav>

        {{-- Owned Restaurants --}}
        <h1 class="mr-2 mb-3">Owned Restaurants</h1>
        <x-RestaurantCards :restaurants="$restaurants"></x-RestaurantCards>

        {{-- Pagination --}}
        <div class="mt-2">
            {{$restaurants->links()}}
        </div>
    </div>
@endsection

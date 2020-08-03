@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- Breadcrumb --}}
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item active">Restaurants</li>
            </ol>
        </nav>

        {{-- Control Panel --}}
        @can('is-admin')
            <div class="card border-primary mb-3">
                <div class="card-header d-flex">
                    {{-- Title --}}
                    <p class="lead m-0 align-self-center">Control Panel</p>

                    {{-- Create Button --}}
                    <a class="btn btn-success ml-auto" href="{{route('restaurant.create')}}" role="button">📄 Create</a>
                </div>
            </div>
        @endcan

        {{-- Title --}}
        <h1 class="d-inline-block mr-2 mb-3">Restaurants</h1>

        {{-- Description --}}
        <p class="lead">Find your right food spot!</p>

        {{-- TODO: Add different styles? Perhaps like cards and stuff? --}}
        {{-- Restaurant cards --}}
        <x-RestaurantCards :restaurants="$restaurants"></x-RestaurantCards>

        {{-- Pagination --}}
        <div class="mt-2">
            {{$restaurants->links()}}
        </div>

    </div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Categories</li>
        </ol>
    </nav>

    {{-- Title --}}
    <h1 class="d-inline-block mr-2">Categories</h1>

    {{-- Admin Create Category Button --}}
    @can('is-admin', Auth::user())
        <a class="btn btn-success" style="vertical-align: super;" href="{{route('category.create')}}" role="button">+ Create</a>
    @endcan

    {{-- Description --}}
    @if (count($categories) > 0)
        <p class="lead">Pick restaurants from one of the  {{count($categories)}} delicious categories!</p>
    @endif

    {{--
        Categories Component
        TODO: Add different styles? Perhaps like cards and stuff?
    --}}
    <x-category-cards :categories="$categories"/>

</div>
@endsection

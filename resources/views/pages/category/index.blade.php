@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Breadcrumb --}}
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item active">Categories</li>
        </ol>
    </nav>

    <h1 class="d-inline-block mr-2 mb-3">Categories</h1> {{-- Title --}}
    @include('includes.category.create-button')          {{-- Create --}}

    {{-- Description --}}
    @if (count($categories) > 0)
        <p class="lead">Pick restaurants from one of the  {{count($categories)}} delicious categories!</p>
    @endif

    {{-- TODO: Add different styles? Perhaps like cards and stuff? --}}
    @include('includes.category.cards') {{-- Cards --}}

</div>
@endsection

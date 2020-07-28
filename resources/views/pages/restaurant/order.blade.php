@extends('layouts.app')

@section('content')
    <div class="container">
    {{-- Breadcrumb --}}
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('restaurant.index')}}">Restaurant</a></li>
            <li class="breadcrumb-item active"><a href="{{route('restaurant.show', $restaurant->id)}}">{{$restaurant->name}}</a></li>
            <li class="breadcrumb-item active">Order</li>
        </ol>
    </nav>

@endsection

@push('scripts')
@endpush

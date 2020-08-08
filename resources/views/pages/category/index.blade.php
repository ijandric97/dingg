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

    {{-- Control Panel --}}
    @can('is-admin')
        <div class="card border-primary mb-3">
            <div class="card-header d-flex">
                {{-- Title --}}
                <p class="lead m-0 align-self-center">Control Panel</p>

                {{-- Create Button --}}
                <a class="btn btn-success ml-auto" href="{{route('category.create')}}" role="button">📄 Create</a>
            </div>
        </div>
    @endcan

    {{-- Title --}}
    <h1 class="d-inline-block mr-2 mb-3">Categories</h1>

    {{-- Description --}}
    @if (count($categories) > 0)
        <p class="lead">Pick restaurants from one of the  {{count($categories)}} delicious categories!</p>
    @endif

    <x-CategoryCards :categories="$categories"></x-CategoryCards> {{-- Cards --}}

</div>
@endsection

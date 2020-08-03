@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- Breadcrumb --}}
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('restaurant.index') }}">Restaurant</a></li>
                <li class="breadcrumb-item"><a
                        href="{{ route('restaurant.show', $restaurant->id) }}">{{ $restaurant->name }}</a></li>
                <li class="breadcrumb-item active">Products</li>
            </ol>
        </nav>

        {{-- Title --}}
        <h1>Products</h1>
        <p>You can add/edit/remove products. Products without group will not be available to the user.
            Products that are dimmed are set to not available.
        </p>

        {{-- Product list --}}
        <div class="list-group">

            {{-- Create / Submit --}}
            <div class="mb-2">
                <a href="{{route('restaurant.product.create', $restaurant)}}"class="btn btn-success">📄 Create</a>
            </div>

            <div id="listItems">
                @foreach ($products as $product)
                    <div class="list-group-item border mb-2 d-flex @if ($product->available == false) bg-light"
                    style="filter: grayscale(1)" @else " @endif>
                        <img src=" {{ asset('storage/images/' . $product->image_path) }}"
                    alt="{{ $product->name }} image" class="img-thumbnail mr-2" style="width: 80px; height: 60px;"
                    onerror="imgError(event)">
                    <div class="flex-fill">
                        <b><span class="text-primary">@if ($product->group) {{ $product->group->name }}
                            @else No Category @endif</span> {{ $product->name }}</b>
                    <p class="mb-0">{{ $product->description }}</p>
                    <p class="mb-0">💰 {{ $product->price }}
                        <span class="badge badge-pill badge-danger">
                            {{ $product->discount <= 0 ? 'No Discount' : $product->discount * 100 . '%' }}</span>
                    </p>
                </div>
                <div class="text-right">
                    <a class="btn btn-warning d-flex text-center"
                        href="{{ route('restaurant.product.edit', [$restaurant, $product]) }}">✏️ Edit</a>
                    <form method="POST" action="{{ route('restaurant.product.destroy', [$restaurant, $product]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="deleteConfirm(event)">🗑️
                            Delete</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

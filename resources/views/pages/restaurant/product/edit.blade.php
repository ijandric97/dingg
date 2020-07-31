@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- Breadcrumb --}}
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('restaurant.index') }}">Restaurant</a></li>
                <li class="breadcrumb-item"><a href="{{ route('restaurant.show', $restaurant) }}">{{ $restaurant->name }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('restaurant.product.index', $restaurant) }}">Products</a></li>
                <li class="breadcrumb-item active">{{$product->name}}</li>
            </ol>
        </nav>

        {{-- Title --}}
        <h1>Create Product</h1>

        {{-- Actual Edit Form --}}
        <form method="POST" action="{{route('restaurant.product.update', [$restaurant, $product])}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{old('name', $product->name)}}" required>
                @error('name')
                    <small class="form-text text-danger">{{$message}}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description" value="{{old('description', $product->description)}}" required>
                @error('description')
                    <small class="form-text text-danger">{{$message}}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" id="price" value="{{old('price', $product->price)}}" min="0" required>
                @error('price')
                    <small class="form-text text-danger">{{$message}}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="discount">Discount</label>
                <p id="discountLabel">Discount</p>
                <input type="range" class="form-control-range @error('discount') is-invalid @enderror" id="discountRange" name="discount" value="{{old('discount', $product->discount)}}" min="0" max="100" required>
                @error('discount')
                    <small class="form-text text-danger">{{$message}}</small>
                @enderror
            </div>
            <div class="form-group"> {{-- Products --}}
                <label for="group">Group</label>
                <select name="group" class="custom-select">
                    <option value="" selected></option> {{-- Default blank --}}
                    @foreach ($groups as $group)
                        <option value="{{$group->name}}" @if(old('group', $product->group ? $product->group->name : '') == $group->name){{"selected"}}@endif>{{$group->name}}</option>
                    @endforeach
                </select>
                @error('group')
                    <small class="form-text text-danger">{{$message}}</small>
                @enderror
                <small class="form-text text-muted">NOTE: Select blank if you wish to hide your product</small>
            </div>
            <div class="form-group">
                <label class="d-block" for="file">Image</label>
                <img src="{{asset('storage/images/product/' . $product->image_path)}}" class="d-block rounded dingg-border mb-2" alt="Product picture">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="delete_image" id="delete_image" value="1"> {{-- "1" will be converted to true in backend --}}
                    <label class="form-check-label" for="delete_image">Delete Image</label>
                </div>
                <input type="file" class="form-control-file" name="file" id="file">
                <small class="form-text">NOTE: Image will be resized to 320x240.</small>
                @error('file')
                    <small class="form-text text-danger">{{$message}}</small>
                @enderror
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="available" value="1" @if(old('checked', $product->available)) checked @endif)> {{-- "1" will be converted to true in backend --}}
                <label class="form-check-label" for="available">Available</label>
            </div>
            <button type="submit" class="btn btn-primary">✉ Submit</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    var price = document.getElementById("price");
    var range = document.getElementById("discountRange");
    var label = document.getElementById("discountLabel");
    label.innerHTML = 'Final Price: ' + price.value + ' HRK - ' + range.value + '% = ' + (price.value - price.value*range.value/100) + ' HRK';

    price.oninput = calcPrice;
    range.oninput = calcPrice;

    function calcPrice() {
        label.innerHTML = 'Final Price: ' + price.value + ' HRK - ' + range.value + '% = ' + (price.value - price.value*range.value/100) + ' HRK';
    }
</script>
@endpush

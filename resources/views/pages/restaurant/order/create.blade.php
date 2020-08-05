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
                <li class="breadcrumb-item"><a href="{{ route('restaurant.order.index', $restaurant) }}">Orders</a></li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </nav>

        {{-- Title --}}
        <h1>Create Order</h1>
        <br>

        {{-- Actual Edit Form --}}
        <form id="orderForm" method="POST" action="{{route('restaurant.order.store', $restaurant)}}" enctype="multipart/form-data">
            @csrf
            {{-- Table --}}
            <div class="form-group">
                <h3><label for="name">Table</label></h3>
                <select name="table" class="custom-select" required>
                    <option value=""></option> {{-- Default blank --}}
                    @foreach ($tables as $table)
                        <option value="{{$table->id}}" @if(old('table') == $table->id){{"selected"}}@endif>
                            Table No.{{$table->id}} for {{$table->seat_count}} people {{'-' . $table->description }}
                        </option>
                    @endforeach
                </select>
                @error('table')
                    <small class="form-text text-danger">{{$message}}</small>
                @enderror
            </div>

            {{-- Datetime --}}
            <div class="form-group">
                <h3><label for="time">Date and time</label></h3>
                <input type="datetime-local" name="datetime" class="form-control @error('time') is-invalid @enderror"
                       value="{{old('datetime', $now)}}" required>
                @error('datetime')
                    <small class="form-text text-danger">{{$message}}</small>
                @enderror
            </div>

            {{-- Products --}}
            <h3>Products</h3>
            @php($i = 0)
            @foreach($groups as $group)
                <h5 class="text-primary">{{$group->name}}</h5>

                {{-- Products for that category --}}
                <div id="listItems">
                @foreach ($group->products()->get() as $product)
                    <div class="list-group-item border mb-2 d-flex @if ($product->available == false) grayscale bg-light @endif">
                        <img src=" {{ asset('storage/images/' . $product->image_path) }}"
                             alt="{{ $product->name }} image" class="img-thumbnail mr-2"
                             style="width: 80px; height: 60px;"
                             onerror="imgError(event)">
                        {{-- Info --}}
                        <div class="flex-fill">
                            <b>{{ $product->name }}</b>
                            <p class="mb-0">{{ $product->description }}</p>
                            @if ($product->discount)
                                <p class="mb-0">💰 <del>{{ $product->price }}</del>
                                    <span class="text-danger"><b>{{$product->getCurrentPrice()}}</b> HRK</span>
                                </p>
                            @else
                                <p class="mb-0">💰 {{ $product->price }} HRK</p>
                            @endif
                        </div>
                        {{-- Order product count --}}
                        <div class="ml-2 text-center">
                            @if ($product->available)
                                <div class="form-group">
                                    <label for="price">Count</label>
                                    <input name="id[]" type="number" value="{{$product->id}}" hidden required>
                                    <input name="count[]" type="number" value="{{old('count.'.$i, 0)}}" min="0" max="10"
                                           class="form-control @error('price') is-invalid @enderror" required>
                                </div>
                            @else
                                <p class="my-3 lead text-danger">OUT OF STOCK</p>
                            @endif
                        </div>
                    </div>
                    @php($i = ($i < $restaurant->products()->count()) ? $i + 1 : $i)
                @endforeach
                </div>

            @endforeach
            <h3>Submit order</h3>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="agree" required>
                <label class="form-check-label" for="agree">I agree with the terms and the conditions</label>
            </div>
            <button type="submit" class="btn btn-primary">✉️ Submit</button>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        // IF count is more than 0 paint it blue to make it distinct
        $(window).on('load', function() {
            $('input[name^="count"]').each(function(){
                if ($(this).val() > 0) {
                    $(this).addClass( "border-primary" );
                } else {
                    $(this).removeClass( "border-primary" );
                }
            })
        });

        // same as upper but on input change instead of document load
        $('input[name^="count"]').change(function(){
            if ($(this).val() > 0) {
                $(this).addClass( "border-primary" );
            } else {
                $(this).removeClass( "border-primary" );
            }
        })

        //When the form is submitted...
        $("#orderForm").submit(function() {
            var atleastOneFilled = false;

            $('input[name^="count"]').each(function(){
                console.log($(this).val());
                if ($(this).val() > 0) {
                    atleastOneFilled = true;
                }
            })

            //If both of them are empty...
            if(atleastOneFilled == false) {
                //Notify the user. And do not submit the form.
                alert("You need to order at least 1 item!");
                event.preventDefault();
            }
        });
    </script>
@endpush

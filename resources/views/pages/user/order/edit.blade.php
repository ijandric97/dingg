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
                <li class="breadcrumb-item"><a href="{{route('user.order.index', $user)}}">Orders</a></li>
                <li class="breadcrumb-item active">#{{$order->id}}</li>
            </ol>
        </nav>

        {{-- Title --}}
        <h1>Order #{{$order->id}}</h1>

        {{-- Control Panel --}}
        @if ($order->status > 1)
            <div class="card border-primary mb-3">
                <div class="card-header d-flex">
                    {{-- Title --}}
                    <p class="lead m-0 align-self-center">Control Panel</p>

                    {{-- Delete Button --}}
                    <form class="ml-auto" method="POST" action="{{route('user.order.update', [$user, $order])}}">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn ml-2 btn-danger" onclick="deleteConfirm(event)">🗑️
                            Cancel Order
                        </button>
                    </form>
                </div>
            </div>
        @endif

        {{-- Info about the order --}}
        {{-- Status --}}
        <div class="form-group">
            <h4>Status</h4>
            <input type="text" class="form-control text-white {{$colors[$order->status]}}"  disabled
                   value="{{$order->getStatus()}}">
        </div>

        {{-- Restaurant --}}
        <div class="form-group">
            <h4>Restaurant</h4>
            <input type="text" class="form-control"  disabled
                   value="{{$order->restaurant->name}}">
        </div>

        {{-- Table --}}
        <div class="form-group">
            <h4>Table</h4>
            <input type="text" class="form-control"  disabled
                   value="Table No.{{$table->id}} for {{$table->seat_count}} people {{'-' . $table->description }}">
        </div>

        {{-- Datetime --}}
        <div class="form-group">
            <h4>Date and Time</h4>
            <input type="text" class="form-control" value="{{$order->reservation_time}}" disabled>
        </div>

        {{-- Products --}}
        <div class="form-group">
            <h4>Products</h4>

            <table class="table table-sm-responsive table-bordered table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Count</th>
                    <th scope="col">Price</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <th scope="row">{{$product->id}}</th>
                        <td>{{$product->name}}</td>
                        <td>{{$product->pivot->count}}</td>
                        <td>{{$product->getCurrentPrice() * $product->pivot->count}} HRK</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <p class="lead">Total Price: {{$order->getTotalPrice()}} HRK</p>

        </div>
    </div>
@endsection

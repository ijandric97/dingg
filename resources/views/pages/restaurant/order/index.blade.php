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
                <li class="breadcrumb-item active">Orders</li>
            </ol>
        </nav>

        {{-- Title --}}
        <h1>Orders</h1>
        <p>You can view/"edit" orders.</p>

        {{-- Product list --}}
        <div class="list-group">

            <table class="table table-bordered table-responsive-sm table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Date</th>
                        <th scope="col">Status</th>
                        <th scope="col">Table</th>
                        <th scope="col">User</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr onclick="window.location='{{route('restaurant.order.show', [$restaurant, $order])}}';"
                            style="cursor: pointer;">
                            <th scope="row">{{$order->id}}</th>
                            <td>{{$order->reservation_time}}</td>
                            <th class="text-success {{$colors[$order->status]}}">{{$order->getStatus()}}</th>
                            <td>{{$order->table_id}}</td>
                            <td>{{$order->user->name}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

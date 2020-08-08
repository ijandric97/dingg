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
                    <th scope="col">Restaurant</th>
                    <th scope="col">Table</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr onclick="window.location='{{route('user.order.edit', [$user, $order])}}';"
                        style="cursor: pointer;">
                        <th scope="row">{{$order->id}}</th>
                        <td>{{$order->reservation_time}}</td>
                        <th class="text-success {{$colors[$order->status]}}">{{$order->getStatus()}}</th>
                        <td>{{$order->restaurant->name}}</td>
                        <td>{{$order->table_id}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-2">
            {{$orders->links()}}
        </div>
    </div>
@endsection

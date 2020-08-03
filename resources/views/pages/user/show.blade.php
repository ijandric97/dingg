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
                <li class="breadcrumb-item active">{{$user->name}}</li>
            </ol>
        </nav>

        {{-- Control Panel --}}
        @can('edit-user', $user)
            <div class="card border-primary mb-3">
                <div class="card-header d-flex">
                    {{-- Title --}}
                    <p class="lead m-0 align-self-center">Control Panel</p>

                    <a class="btn btn-warning ml-auto" href="{{route('user.edit', $user)}}" role="button">✏️ Edit</a>

                    {{-- Delete Button --}}
                    @can('is-admin')
                        <form method="POST" action="{{route('user.destroy', $user)}}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn ml-2 btn-danger" onclick="deleteConfirm(event)">🗑️ Delete
                            </button>
                        </form>
                    @endcan
                </div>
            </div>
        @endcan

        {{-- 2-Column Information --}}
        <div class="row mb-2">

            {{-- Left Column --}}
            <div class="col-md-4 mb-3">
                {{-- Image --}}
                <img src="{{asset('storage/images/' . $user->image_path)}}" onerror="imgError(event)"
                     class="d-block m-auto w-100 img-fluid dingg-border rounded" alt="{{$user->name}} picture">
            </div>

            {{-- Right Column --}}
            <div class="col-md-8 text-center text-md-left">
                {{-- Title --}}
                <h1 class="mr-2 mb-2">{{$user->name}}</h1>

                {{-- Role Badge --}}
                <h3 class="d-inline-block">
                    @php($badge = $user->role == 'admin' ? 'badge-danger' : ($user->role == 'user' ? 'badge-primary' : 'badge-warning'))
                    <span class="align-super badge {{$badge}} mb-2">{{strtoupper($user->role)}}</span>
                </h3>

                {{-- Info --}}
                <table class="table table-sm">
                    <tbody>
                    <tr>
                        <th scope="row">E-mail</th>
                        <td><a href="mailto:{{$user->email}}}">{{$user->email}}</a></td>
                    </tr>
                    <tr>
                        <th scope="row">Phone</th>
                        <td><a href="tel:{{$user->phone}}">{{$user->phone}}</a></td>
                    </tr>
                    <tr>
                        <th scope="row">Registered</th>
                        <td>{{$user->created_at}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Favorites --}}
        <h1 class="d-inline-block mr-2 mb-3">Favorites ❤️</h1>
        <x-RestaurantCards :restaurants="$favorites"></x-RestaurantCards>

        {{-- Pagination --}}
        <div class="mt-2">
            {{$favorites->links()}}
        </div>
    </div>
@endsection

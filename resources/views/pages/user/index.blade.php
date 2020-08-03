@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- Breadcrumb --}}
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item active">Users</li>
            </ol>
        </nav>

        {{-- Title --}}
        <h1 class="d-inline-block mr-2 mb-3">Users</h1>

        {{-- Description --}}
        <p class="lead">Find your right food spot!</p>

        {{-- Search --}}
        <form method="GET" action="{{ route('user.index') }}">
            <div class="card border-primary mb-3">
                <div class="card-header d-flex align-items-center">
                    {{-- Title --}}
                    <label class="lead m-0 align-self-center" for="user">Search</label>

                    {{-- Search input --}}
                    <div class="flex-fill mx-2">
                        <input class="form-control" type="text" name="user" value="{{$name}}">
                    </div>

                    {{-- Search button --}}
                    <button type="submit" class="btn btn-primary ml-auto">🔍 Search</button>
                </div>
            </div>
        </form>

        {{-- User list --}}
        <div class="list-group">
            <div id="listItems">
                @forelse($users as $user)
                    <div class="list-group-item list-group-item-action border mb-2 d-flex"
                         style="cursor: pointer;"
                         onclick="window.location='{{route('user.show', $user)}}';">
                        <img src=" {{ asset('storage/images/' . $user->image_path) }}"
                             alt="{{ $user->name }} image" class="img-thumbnail mr-2" style="width: 80px; height: 60px;"
                             onerror="imgError(event)">
                        <div class="flex-fill">
                            <b><span class="text-primary">{{ $user->role }} </span>{{ $user->name }}</b>
                            <p class="mb-0">📆 {{ $user->created_at }}</p>
                        </div>
                        <div class="text-right">
                            <a class="btn btn-warning d-flex text-center"
                               href="{{ route('user.edit', $user) }}">✏️ Edit</a>
                            <form method="POST" action="{{ route('user.destroy', $user) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="deleteConfirm(event)">🔨 Ban
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-danger" role="alert">No users found!</div>
                @endforelse
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-2">
            {{$users->links()}}
        </div>
    </div>
@endsection

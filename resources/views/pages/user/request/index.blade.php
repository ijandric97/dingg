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
                <li class="breadcrumb-item active">Requests</li>
            </ol>
        </nav>

        {{-- Title --}}
        <h1>Requests</h1>
        <p>You can add requests to contact the admin.<br>
            You can create a maximum of 30 request so be careful how you use them.
        </p>

        {{-- Create / Submit --}}
        <div class="mb-2">
            @if ($too_many)
                <p class)="lead">You made more than 30 requests! They have been disabled to prevent spam.</p>
            @else
                <a href="{{route('user.request.create', $user)}}" class="btn btn-success">📄 Create</a>
            @endif
        </div>

        {{-- Request list --}}
        <div class="table-responsive">
            <table class="table table-sm table-sm-responsive table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requests as $request)
                        <tr>
                            <th scope="row">{{$request->created_at}}</th>
                            <td>{{$request->name}}</td>
                            <td>{{$request->description}}</td>
                            <th>{{$request->getStatus()}}</th>
                            <td>
                                <form class="text-center" method="POST" action="{{ route('user.request.destroy', [$user, $request]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="deleteConfirm(event)">🗑️
                                        Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

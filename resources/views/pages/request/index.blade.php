@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- Breadcrumb --}}
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item active">Requests</li>
            </ol>
        </nav>

        {{-- Title --}}
        <h1>Requests</h1>

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
                        <th class="{{$colors[$request->status]}}">{{$request->getStatus()}}</th>
                        <td class="text-center">
                            <a class="btn btn-warning" href="{{route('request.edit', $request)}}">✏️ Respond</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

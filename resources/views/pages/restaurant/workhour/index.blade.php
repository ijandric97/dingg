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
                <li class="breadcrumb-item active">Workhours</li>
            </ol>
        </nav>

        {{-- Title --}}
        <h1>Workhours</h1>
        <br>

        {{-- Workhours --}}
        <form method="POST" action="{{ route('restaurant.workhour.store', [$restaurant->id]) }}">
            @csrf

            {{-- Submit --}}
            <div class="mb-2">
                <button type="submit" class="btn btn-primary">✉️ Submit</button>
            </div>

            {{-- Workhours --}}
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Day</th>
                        <th scope="col">Start</th>
                        <th scope="col">End</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < count($workhours); $i++)
                        <tr>
                            <th>{{ $workhours[$i]['day'] }}</th>
                            <td>
                                <input type="time" class="form-control @error('open_time.'.$i) is-invalid @enderror"
                                    name="open_time[]" value="{{ old('open_time.' . $i, $workhours[$i]['open_time']) }}">
                                @error('open_time.'.$i)
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </td>
                            <td>
                                <input type="time" class="form-control @error('close_time.'.$i) is-invalid @enderror"
                                    name="close_time[]" value="{{ old('close_time.' . $i, $workhours[$i]['close_time']) }}">
                                @error('close_time.'.$i)
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
            <small class="form-text text-muted">NOTE: Delete time if you are closed that day.</small>
        </form>
    </div>
@endsection

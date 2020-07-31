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
                <li class="breadcrumb-item active">Groups</li>
            </ol>
        </nav>

        {{-- Title --}}
        <h1>Product Groups</h1>
        <p>Products are organised into groups. You can add/edit/remove groups. To put products into a created group go to
            the Products page.</p>

        <form class="list-group" method="POST" action="{{ route('restaurant.group.store', [$restaurant->id]) }}">
            @csrf

            {{-- Create / Submit --}}
            <div class="mb-2">
                <button type="button" class="btn btn-success" onclick="create()">📄 Create</button>
                <button type="submit" class="btn btn-primary">✉️ Submit</button>
            </div>

            <div id="listItems">
                @for ($i = 0; $i < count(old('id', $groups)); $i++)
                    <div class="list-group-item border mb-2">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control @error('name.'.$i) is-invalid @enderror" name="name[]"
                                value="{{ old('name.' . $i, $i < count($groups) ? $groups[$i]->name : '') }}" required>
                            @error('name.'.$i)
                            <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" class="form-control @error('description.'.$i) is-invalid @enderror"
                                name="description[]"
                                value="{{ old('description.' . $i, $i < count($groups) ? $groups[$i]->description : '') }}">
                            @error('description.'.$i)
                            <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <button type="button" class="btn btn-secondary" onclick="moveUp(event)">↑ Move Up</button>
                        <button type="button" class="btn btn-secondary" onclick="moveDown(event)">↓ Move Down</button>
                        <button type="button" class="btn btn-danger" onclick="deleteGroup(event)">🗑️ Delete</button>
                        {{-- We need these for existing ones --}}
                        <input type="number" name="id[]"
                            value="{{ old('id.' . $i, $i < count($groups) ? $groups[$i]->id : '') }}" hidden>
                    </div>
                @endfor
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        function create(event) {
            $('#listItems').prepend('<div class="list-group-item border mb-2"><div class="form-group"><label>Name</label> \
                <input type="text" class="form-control" name="name[]" value="" required></div><div class="form-group"> \
                <label>Description</label><input type="text" class="form-control" name="description[]" value=""> \
                </div><button type="button" class="btn btn-secondary" onclick="moveUp(event)">↑ Move Up</button> \
                <button type="button" class="btn btn-secondary" onclick="moveDown(event)">↓ Move Down</button> \
                <button type="button" class="btn btn-danger" onclick="deleteGroup(event)">🗑 Delete</button> \
                <input type="number" name="id[]" value="" hidden></div>');
        }

        function moveUp(event) {
            var btn = event.target;
            $(btn).parent().insertBefore($(btn).parent().prev());
        }

        function moveDown(event) {
            var btn = event.target;
            $(btn).parent().insertAfter($(btn).parent().next());
        }

        function deleteGroup(event) {
            var btn = event.target;
            $(btn).parent().remove();
        }

    </script>
@endpush

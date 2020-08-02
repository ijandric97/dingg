@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Breadcrumb --}}
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('restaurant.index')}}">Restaurant</a></li>
            <li class="breadcrumb-item"><a href="{{route('restaurant.show', $restaurant->id)}}">{{$restaurant->name}}</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>

    {{-- Title --}}
    <h1>Update Restaurant</h1>

    {{-- Actual Edit Form --}}
    <form method="POST" action="{{route('restaurant.update', $restaurant->id)}}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group"> {{-- Name --}}
            <label for="name">Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{old('name', $restaurant->name)}}" required>
            @error('name')
                <small class="form-text text-danger">{{$message}}</small>
            @enderror
        </div>
        <div class="form-group"> {{-- Description --}}
            <label for="description">Description</label>
            <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description" value="{{old('description', $restaurant->description)}}" required>
            @error('description')
                <small class="form-text text-danger">{{$message}}</small>
            @enderror
        </div>
        <div class="form-group"> {{-- Address --}}
            <label for="address">Address</label>
            <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" id="address" value="{{old('address', $restaurant->address)}}" required>
            @error('address')
                <small class="form-text text-danger">{{$message}}</small>
            @enderror
        </div>
        <div class="form-group"> {{-- Phone --}}
            <label for="phone">Phone Number</label>
            <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" placeholder="+385 12 3456789" pattern="(\+385)[ ][0-9]{2}[ ][0-9]{6}[0-9]?" value="{{old('phone', $restaurant->phone)}}" required>
            <small class="form-text text-muted">FORMAT: +385 12 3456789</small>
            @error('phone')
                <small class="form-text text-danger">{{$message}}</small>
            @enderror
        </div>
        <div class="form-group"> {{-- Website --}}
            <label for="website">Website</label>
            <input type="text" class="form-control @error('website') is-invalid @enderror" name="website" placeholder="https://example.com" pattern="http[s]?://.*" id="website" value="{{old('website', $restaurant->website)}}" required>
            <small class="form-text text-muted">FORMAT: https://www.example.com</small>
            @error('website')
                <small class="form-text text-danger">{{$message}}</small>
            @enderror
        </div>
        <div class="form-group"> {{-- Categories --}}
            <label for="categories">Categories</label>
            {{-- Define days array so we can elegantly for loop this section --}}
            <div class="table-responsive">
                <table class="table table-striped border">
                    <thead>
                        <tr>
                            <th scope="col">Category 1</th>
                            <th scope="col">Category 2</th>
                            <th scope="col">Category 3</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @for ($i = 0; $i < 3; $i++)
                                <td>
                                    <select name="category[]" class="custom-select">
                                        <option value=""></option> {{-- Default blank --}}
                                        @foreach ($categories as $category)
                                            <option value="{{$category->name}}" @if(old('category.'.$i, $rest_cats[$i]['name']) == $category->name){{"selected"}}@endif>{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('category.'.$i)
                                        <small class="form-text text-danger">{{$message}}</small>
                                    @enderror
                                </td>
                            @endfor
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="form-group"> {{-- Image --}}
            <label class="d-block" for="file">Image</label>
            <img src="{{asset('storage/images/restaurant/' . $restaurant->image_path)}}" class="d-block rounded dingg-border mb-2" alt="Restaurant picture">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="delete_image" id="delete_image" value="1"> {{-- "1" will be converted to true in backend --}}
                <label class="form-check-label" for="delete_image">Delete Image</label>
            </div>
            <input type="file" class="form-control-file" name="file" id="file">
            <small class="form-text text-muted">NOTE: Image will be resized to 320x240.</small>
            @error('file')
                <small class="form-text text-danger">{{$message}}</small>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">✉ Submit</button>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function deleteTableRow($id) {
        $('#tr_'+$id).remove();
    }

    var tablesMaxId = {{$tables->max('id')}};

    function addTableRow() {
        var rowCount = $('#tables tr').length - 2; // Because header and 0 based
        var insertString = ' \
            <tr id="tr_' + rowCount + '"> \
                <td><input type="number" class="form-control" name="t_seat[]" value="1" min="1" max="99" required></td> \
                <td><input type="text" class="form-control" name="t_desc[]" value=""></td> \
                <td> \
                    <input type="number" name="t_id[]" value="" hidden> \
                    <button type="button" class="btn btn-danger on-top" onclick="deleteTableRow(' + rowCount + ')">🗑️ Delete</button> \
                </td> \
            </tr> \
        ';

        $('#tables').append(insertString);

        console.log(rowCount);
    }
</script>
@endpush

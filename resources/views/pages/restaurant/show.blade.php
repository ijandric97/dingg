@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Breadcrumb --}}
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('restaurant.index')}}">Restaurant</a></li>
            <li class="breadcrumb-item active">{{$restaurant->name}}</li>
        </ol>
    </nav>

    <div class="row mb-2"> {{-- Basic Info --}}
        <div class="col-md-4 mb-3">
            <img src="{{asset('storage/images/restaurant/' . $restaurant->image_path)}}" onerror="this.onerror=null; this.src='{{asset('storage/images/restaurant/placeholder.png')}}'" class="d-block m-auto w-100 img-fluid dingg-border rounded" alt="{{$restaurant->name}} picture">
            @auth
                <a href="{{route('restaurant.order', $restaurant->id)}}" class="btn btn-primary btn-lg d-block mx-auto mt-2">Create an order 🍕</a> {{-- Order Button --}}
            @else
                <a href="{{route('register')}}" class="btn btn-secondary btn-lg d-block mx-auto mt-2">Register to order 😊</a>
            @endauth
        </div>
        <div class="col-md-8 text-center text-md-left">
            <h1 class="d-inline-block mr-2 mb-2">{{$restaurant->name}}</h1> {{-- Title --}}
            @include('includes.restaurant.edit-delete-button')              {{-- Edit / Delete --}}
            <p class="lead mb-2">{{$restaurant->description}}</p>           {{-- Description --}}


            <div class="d-inline-block"> {{-- Categories --}}
                @foreach ($restaurant->categories()->get() as $category)
                    <a href="{{route('category.show', $category->id)}}" class="btn btn-dark btn-secondary active mb-2" style="vertical-align: super;" role="button">{{$category->name}}</a>
                @endforeach
            </div>

            <div class="d-inline-block mb-3"> {{-- Rating / Favorite --}}
                @php
                    $rating = $restaurant->rating();
                    $color = $rating >= 4 ? 'btn-success' : ($rating < 2.5 ? 'btn-danger' : 'btn-warning');
                @endphp
                <button class="btn {{$color}} font-weight-bold disabled" style="opacity: 1; vertical-align: super;">{{'⭐ '.$rating}} / 5</button>
                @include('includes.restaurant.favorite-button')
            </div>

            <table class="table table-sm"> {{-- Info --}}
                <tbody>
                    <tr>
                        <th scope="row">Address</th>
                        <td>{{$restaurant->address}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Phone</th>
                        <td><a href="tel:{{$restaurant->phone}}">{{$restaurant->phone}}</a></td>
                    </tr>
                    <tr>
                        <th scope="row">Website</th>
                        <td><a href="{{$restaurant->website}}">{{$restaurant->website}}</></td>
                    </tr>
                </tbody>
            </table>
            <div class="alert alert-primary" role="alert">
                If you have allergies or other dietary restrictions, please contact the restaurant.<br/>
                The restaurant will provide food-specific information upon request.
            </div>
        </div>
    </div>

    {{-- Define days array so we can elegantly for loop this section --}}
    @php ($days = [0 => 'Monday', 1 => 'Tuesday', 2 => 'Wednesday', 3 => 'Thursday', 4 => 'Friday', 5 => 'Saturday', 6 => 'Sunday'])
    <div class="row mb-2"> {{-- Basic Info --}}
        <div class="col-md-4 mb-3">
            {{-- Workhours --}}
            <h3 class="text-center text-md-left">Workhours</h3>
            <table class="table table-sm dingg-border">
                <tbody>
                    @for ($i = 0; $i < 7; $i++)
                        @if($workhours[$i]['open_time'])
                            <tr>
                                <th scope="row">{{$days[$i]}}</th>
                                <td>{{$workhours[$i]['open_time']}} - {{$workhours[$i]['close_time']}}</td>
                            </tr>
                        @endif
                    @endfor
                </tbody>
            </table>

            {{-- Menu items --}}
            <div class="d-flex justify-content-between btn-group" role="group">
                <button type="button" class="btn btn-primary" onclick="cycleGroup(false)" style="border-radius: 0.25rem 0px 0px 0px;">←</button>
                <button type="button" class="btn btn-primary disabled" style="opacity: 1;"><h3 class="d-inline">Menu</h3></button>
                <button type="button" class="btn btn-primary" onclick="cycleGroup(true)" style="border-radius: 0px 0.25rem 0px 0px;">→</button>
            </div>
            @php($i = 0) {{-- For the hide functionality --}}
            @foreach ($restaurant->groups()->get() as $group)
            <table id="group_{{$i}}"class="table table-sm table-striped" style="display: {{$i == 0 ? 'table' : 'none'}};">
                <tbody class="dingg-border">
                    <tr>
                        <th scope="row" colspan="2" class="bg-primary text-center text-white">{{$group->name}}</th>
                    </tr>
                    @foreach ($group->products()->get() as $product)
                        <tr>
                            <th scope="row">{{$product->name}}</th>
                            <td>{{$product->getCurrentPrice()}} HRK</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @php($i = $i + 1)
            @endforeach
        </div>
        <div class="col-md-8">
            <h3 class="d-inline-block mr-2 mb-2">Comments
                @auth
                    <button id="addCommentBtn" class="ml-2 btn btn-success" onClick="toggleCommentForm()" role="button">✎ Add</button>
                @endauth
            </h3>
            <form id="addCommentForm" method="POST" action="{{route('restaurant.comment.store', $restaurant->id)}}" style="display: none;"> {{-- Add comment form --}}
                @csrf
                <div class="card mb-2">
                    <div class="card-header">
                        <div class="form-group"> {{-- Title --}}
                            <label for="name">Title</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Title of your comment" name="title" value="{{old('title')}}" required>
                            @error('name')
                                <small class="form-text text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group"> {{-- Body --}}
                            <label for="exampleFormControlTextarea1">Body</label>
                            <textarea class="form-control" name="body" placeholder="Type your experience here." rows="3"></textarea>
                        </div>
                        <div class="form-group"> {{-- Rating --}}
                            <label for="addCommentRange" id="addCommentRangeLabel">Rating</label>
                            <input type="range" class="form-control-range bg-warning" name="rating" id="addCommentRange" min="1" max="5" value="{{old('rating')}}" step="1" required>
                        </div>
                        <button type="submit" class="btn btn-primary">✉ Submit</button>
                    </div>
                </div>
            </form>

            @forelse ($comments as $comment) {{-- Existing comments --}}
                <div class="card mb-2">
                    <div class="card-body">
                        <img src="{{asset('storage/images/restaurant/' . $restaurant->image_path)}}" alt="..." width=64 height=64 class="d-inline-block mb-2 mr-2 img-thumbnail">
                        <div class="d-inline-block" style="vertical-align: middle;">
                            <h5 class="card-title">{{str_repeat('⭐', $comment->rating)}} {{$comment->title}}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">by {{$comment->user()->get()[0]->name}} at {{$comment->updated_at}}</h6>
                        </div>
                        <p class="card-text">{{$comment->body}}</p>
                        @can('delete-comment', $comment)
                            <form method="POST" action="{{route('restaurant.comment.destroy', [$restaurant->id, $comment->id])}}"> {{-- Add comment form --}}
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete 🗑</button> {{-- Delete comment Button --}}
                            </form>
                        @endcan
                    </div>
                </div>
            @empty
                <div class="alert alert-danger" role="alert">No comments found! Feel free to break the ice 🤠.</div>
            @endforelse
            {{$comments->links()}}
        </div>
    </div>


</div>
@include('includes.restaurant.delete-modal') {{-- Delete Modal --}}
@endsection

@push('scripts')
<script>
    @auth
        var range = document.getElementById("addCommentRange");
        var label = document.getElementById("addCommentRangeLabel");
        label.innerHTML = "Rating: " + "⭐".repeat(range.value);

        range.oninput = function() {
            label.innerHTML = "Rating: " + "⭐".repeat(range.value);
        }

        function toggleCommentForm() {
            document.getElementById("addCommentForm").style.display = "block";
            document.getElementById("addCommentBtn").style.display = "none";
        }
    @endauth

    var selectedGroup = 0;
    function cycleGroup(isRight) {
        var size = {{$restaurant->groups()->count()-1}};

        if (isRight) {
            if (selectedGroup >= size) {
                selectedGroup = 0;
            } else {
                selectedGroup++;
            }
        } else {
            if (selectedGroup <= 0) {
                selectedGroup = size;
            } else {
                selectedGroup--;
            }
        }

        for (let i = 0; i <= size; i++) {
            if (i === selectedGroup) {
                document.getElementById("group_"+i).style.display = "table";
            } else {
                document.getElementById("group_"+i).style.display = "none";
            }
        }
    }
</script>
@endpush

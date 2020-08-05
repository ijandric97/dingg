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

        {{-- Control Panel --}}
        @can('edit-restaurant', $restaurant)
            <div class="card border-primary mb-3">
                <div class="card-header d-flex">
                    {{-- Title --}}
                    <p class="lead m-0 align-self-center">Control Panel</p>

                    {{-- Orders Button --}}
                    <a class="btn btn-primary ml-auto" href="{{route('restaurant.order.index', $restaurant)}}" role="button">🧾
                        Orders</a>

                    {{-- Edit Dropdown --}}
                    <div class="dropdown ml-2">
                        <button class="btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown">✏️ Edit
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{route('restaurant.edit', $restaurant)}}">Restaurant</a>
                            <a class="dropdown-item" href="{{route('restaurant.workhour.index', $restaurant)}}">Workhours</a>
                            <a class="dropdown-item" href="{{route('restaurant.table.index', $restaurant)}}">Tables</a>
                            <a class="dropdown-item" href="{{route('restaurant.group.index', $restaurant)}}">Groups</a>
                            <a class="dropdown-item"
                               href="{{route('restaurant.product.index', $restaurant)}}">Products</a>
                        </div>
                    </div>

                    {{-- Delete Button --}}
                    @can('is-admin')
                        <form method="POST" action="{{route('restaurant.destroy', $restaurant->id)}}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn ml-2 btn-danger" onclick="deleteConfirm(event)">🗑️
                                Delete
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
                {{-- Restaurant Image --}}
                <img src="{{asset('storage/images/' . $restaurant->image_path)}}" onerror="imgError(event)"
                     class="d-block m-auto w-100 img-fluid dingg-border rounded" alt="{{$restaurant->name}} picture">

                {{-- Order / Register Button --}}
                {{-- !TODO: order shit --}}
                <a href="@auth {{route('restaurant.order.create', $restaurant->id)}} @else {{route('register')}} @endauth"
                   class="btn btn-lg d-block mx-auto mt-2 @auth btn-primary @else btn-secondary @endauth">
                    @auth Create an order 🍕 @else Register to order 😊 @endauth
                </a>
            </div>

            {{-- Right Column --}}
            <div class="col-md-8 text-center text-md-left">
                {{-- Title --}}
                <h1 class="mr-2 mb-2">{{$restaurant->name}}</h1>
                {{-- Description --}}
                <p class="lead mb-2">{{$restaurant->description}}</p>

                {{-- Categories --}}
                <div class="d-inline-block">
                    @foreach ($categories as $category)
                        <a href="{{route('category.show', $category->id)}}"
                           class="align-super btn btn-dark btn-secondary active mb-2"
                           role="button">{{$category->name}}</a>
                    @endforeach
                </div>

                {{-- Rating / Favorite --}}
                <div class="d-inline-block mb-3">
                    <button
                        class="btn {{$rating >= 4 ? 'btn-success' : ($rating < 2.5 ? 'btn-danger' : 'btn-warning')}} font-weight-bold disabled"
                        style="opacity: 1; vertical-align: super;">⭐ {{$rating}} / 5
                    </button>
                    @auth
                        @php($isFav = $restaurant->favorites()->where('user_id', Auth::user()->id)->first() ? '-' : '-outline-')
                        <a href="{{route('restaurant.favorite', $restaurant->id)}}"
                           class="align-super btn btn{{$isFav}}success">Favorite ❤️</a>
                    @endauth
                </div>

                {{-- Info --}}
                <table class="table table-sm">
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
                        <td><a href="{{$restaurant->website}}">{{$restaurant->website}}</a>
                        </td>
                    </tr>
                    </tbody>
                </table>

                {{-- Alert --}}
                <div class="alert alert-warning" role="alert">
                    If you have allergies or other dietary restrictions, please contact the restaurant.<br/>
                    The restaurant will provide food-specific information upon request.
                </div>
            </div>
        </div>

        {{-- 2-Column Below --}}
        <div class="row mb-2">
            {{-- Left Panel --}}
            <div class="col-md-4 mb-3">
                {{-- Workhours --}}
                <h3 class="text-center text-md-left">Workhours</h3>
                <table class="table table-sm dingg-border">
                    <tbody>
                    @foreach ($workhours as $workhour)
                        @if($workhour['open_time'])
                            <tr>
                                <th scope="row">{{$workhour['day']}}</th>
                                <td>{{$workhour['open_time']}} - {{$workhour['close_time']}}</td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>

                {{-- Menu items --}}
                <div class="d-flex justify-content-between btn-group" role="group">
                    <button type="button" class="btn btn-primary" onclick="cycleGroup(false)"
                            style="border-radius: 0.25rem 0 0 0;">←
                    </button>
                    <button type="button" class="btn btn-primary btn-lg disabled" style="opacity: 1;">
                        Menu
                    </button>
                    <button type="button" class="btn btn-primary" onclick="cycleGroup(true)"
                            style="border-radius: 0 0.25rem 0 0;">→
                    </button>
                </div>
                @php($i = 0) {{-- For the hide functionality --}}
                @foreach ($restaurant->groups()->get() as $group)
                    <table id="group_{{$i}}" class="table table-sm table-striped"
                           style="display: {{$i == 0 ? 'table' : 'none'}};">
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

            {{-- Right Column --}}
            <div class="col-md-8">

                <h3 class="d-inline-block mr-2 mb-2">Comments
                    @auth
                        <button id="addCommentBtn" class="ml-2 btn btn-success" onClick="toggleCommentForm()"
                                role="button">✎
                            Add
                        </button>
                    @endauth
                </h3>

                <form id="addCommentForm" method="POST" action="{{route('restaurant.comment.store', $restaurant->id)}}"
                      style="display: none;"> {{-- Add comment form --}}
                    @csrf
                    <div class="card mb-2">
                        <div class="card-header">
                            <div class="form-group"> {{-- Title --}}
                                <label for="title">Title</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Title of your comment" name="title" value="{{old('title')}}"
                                       required>
                                @error('name')
                                <small class="form-text text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-group"> {{-- Body --}}
                                <label for="body">Body</label>
                                <textarea class="form-control" name="body" placeholder="Type your experience here."
                                          rows="3"></textarea>
                            </div>
                            <div class="form-group"> {{-- Rating --}}
                                <label for="addCommentRange" id="addCommentRangeLabel">Rating</label>
                                <input type="range" class="form-control-range bg-warning" name="rating"
                                       id="addCommentRange"
                                       min="1" max="5" value="{{old('rating')}}" step="1" required>
                            </div>
                            <button type="submit" class="btn btn-primary">✉ Submit</button>
                        </div>
                    </div>
                </form>

                {{-- Existing comments --}}
                @forelse ($comments as $comment)
                    <div class="card mb-2">
                        <div class="card-body">
                            <img src="{{asset('storage/images/' . $comment->user->image_path)}}" alt="..."
                                 onerror="imgError(event)"
                                 width=64
                                 height=64 class="d-inline-block mb-2 mr-2 img-thumbnail">
                            <div class="d-inline-block" style="vertical-align: middle;">
                                <h5 class="card-title">{{str_repeat('⭐', $comment->rating)}} {{$comment->title}}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">by <b>{{$comment->user->name}}</b> at
                                    {{$comment->updated_at}}</h6>
                            </div>
                            <p class="card-text">{{$comment->body}}</p>
                            @can('delete-comment', $comment)

                                {{-- Add comment form --}}
                                <form method="POST"
                                      action="{{route('restaurant.comment.destroy', [$restaurant->id, $comment->id])}}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">🗑️ Delete
                                    </button> {{-- Delete comment Button --}}
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
@endsection

@push('scripts')
    <script>

        @auth
        var range = document.getElementById("addCommentRange");
        var label = document.getElementById("addCommentRangeLabel");
        label.innerHTML = "Rating: " + "⭐".repeat(range.value);

        range.oninput = function () {
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
                    document.getElementById("group_" + i).style.display = "table";
                } else {
                    document.getElementById("group_" + i).style.display = "none";
                }
            }
        }
    </script>
@endpush

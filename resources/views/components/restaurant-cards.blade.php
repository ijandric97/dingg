<div class="row justify-content-start mb-5" style="margin: 0 -3px;">
    @forelse ($restaurants as $restaurant)
        <div class="col-md-4 col-sm-6 p-0">
            <div class="card card-hover-blur bg-gradient-dark text-white dingg-border m-1 rounded">
                <img src="{{asset('storage/images/' . $restaurant->image_path)}}"
                     onerror="imgError(event)"
                     class="card-img-top fb-50 rounded rounded" alt="{{$restaurant->name}} picture">
                <div class="card-img-overlay rounded">
                    <h3 class="card-title mb-0 font-weight-bold ">
                        {{$restaurant->name}}
                        @auth
                            @if($restaurant->favorites()->where('user_id', Auth::user()->id)->first())
                                ❤️
                            @endif
                        @endauth
                    </h3>
                    <p class="card-text mb-0 font-weight-bold">{{$restaurant->description}}</p>
                    <p class="card-text mb-0 font-weight-bold">
                        @foreach($restaurant->categories as $rest_cat)
                            <span class="badge badge-light">{{$rest_cat->name}}</span>
                        @endforeach
                    </p>
                    <h3 class="mt-2" style="margin-left: -20px;">
                        @php($ratingColor = $restaurant->rating() >= 4 ? 'badge-success' : ($restaurant->rating() < 2.5 ? 'badge-danger' : 'badge-warning'))
                        <span
                            class="badge {{$ratingColor}} badge-success font-weight-bold mt-1 rounded-0">⭐ {{$restaurant->rating()}} / 5</span>
                    </h3>
                    <a href="{{route('restaurant.show', $restaurant->id)}}" class="stretched-link"></a>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-danger" role="alert">No restaurants found!</div>
    @endforelse
</div>

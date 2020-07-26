@auth
    <a href="{{route('restaurant.favorite', $restaurant->id)}}" style="vertical-align: super;"
        class="btn btn{{$restaurant->favorites()->where('user_id', Auth::user()->id)->first() ? '-' : '-outline-'}}success">Favorite ❤️</a>
@endauth

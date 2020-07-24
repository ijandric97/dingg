<div class="col-md-4 col-sm-6 p-0">
    <div class="card card-hover-blur bg-dark text-white dingg-border m-1 rounded">
        <img src="{{asset('storage/images/restaurant/' . $restaurant->image_path)}}" onerror="this.onerror=null; this.src='{{asset('storage/images/restaurant/placeholder.png')}}'" class="card-img-top fb-50 rounded" alt="{{$restaurant->name}} picture">
        <div class="card-img-overlay rounded">
            <h3 class="card-title mb-0 font-weight-bold ">{{$restaurant->name}}</h3>
            <p class="card-text mb-0 font-weight-bold">{{$restaurant->description}}</p>
            {{--<span class="badge badge-primary">{{$restaurant->count}} Restaurants</span>--}}
            <a href="{{route('restaurant.show', $restaurant->id)}}" class="stretched-link"></a>

            @can('is-admin', Auth::user())
            <div class="mt-2 d-flex">
                @include('includes.restaurant.edit-delete-button') {{-- Edit / Delete --}}
            </div>
            @endcan
        </div>
    </div>
</div>

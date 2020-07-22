<div class="col-md-4 col-sm-6 p-0">
    <div class="card card-hover-blur bg-dark text-white dingg-border m-1 rounded">
        <img src="{{asset('storage/images/category/' . $category->image_path)}}" onerror="this.onerror=null; this.src='{{asset('storage/images/category/placeholder.png')}}'" class="card-img-top fb-50 rounded" alt="{{$category->name}} picture">
        <div class="card-img-overlay rounded">
            <h3 class="card-title mb-0 font-weight-bold ">{{$category->name}}</h3>
            <p class="card-text mb-0 font-weight-bold">{{$category->description}}</p>
            <span class="badge badge-primary">{{$category->count}} Restaurants</span>
            <a href="{{route('category.show', $category->id)}}" class="stretched-link"></a>

            @can('is-admin', Auth::user())
            <div class="mt-2 d-flex">
                @include('includes.category.edit-delete-button') {{-- Edit / Delete --}}
            </div>
            @endcan
        </div>
    </div>
</div>

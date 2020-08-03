<div class="row justify-content-start mb-5" style="margin: 0 -3px;">
    @forelse ($categories as $category)
        <div class="col-md-4 col-sm-6 p-0">
            <div class="card card-hover-blur bg-gradient-dark text-white dingg-border m-1 rounded">
                <img src="{{asset('storage/images/' . $category->image_path)}}"
                     onerror="imgError(event)"
                     class="card-img-top fb-50 rounded" alt="{{$category->name}} picture">
                <div class="card-img-overlay rounded">
                    <h3 class="card-title mb-0 font-weight-bold ">{{$category->name}}</h3>
                    <p class="card-text mb-0 font-weight-bold">{{$category->description}}</p>
                    <span class="badge badge-primary">{{$category->count}} Restaurants</span>
                    <a href="{{route('category.show', $category->id)}}" class="stretched-link"></a>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-danger" role="alert">No categories found!</div>
    @endforelse
</div>


@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Categories</li>
        </ol>
    </nav>

    <!-- Title -->
    <h1 class="d-inline-block">Categories</h1>

    @can('is-admin', Auth::user())
        <a class="btn btn-success ml-2 align-text-bottom" href="{{route('category.create')}}" role="button">Create Category</a>
    @endcan

    <!-- Description -->
    @if (count($categories) > 0)
        <p class="lead">Pick restaurants from one of the  {{count($categories)}} delicious categories!</p>
    @endif

    <!-- Categories sections -->
    <div class="row justify-content-start" style="margin: 0px -3px;">
        @forelse ($categories as $category)
            <div class="col-md-4 col-sm-6 p-0">
                <div class="card card-hover-blur bg-dark text-white dingg-border m-1 rounded">
                    <img src="{{asset('storage/images/category/' . $category->image_path)}}" class="card-img-top fb-50 rounded" alt="...">
                    <div class="card-img-overlay rounded">
                        <h3 class="card-title mb-0 font-weight-bold ">{{$category->name}}</h3>
                        <p class="card-text mb-0 font-weight-bold">{{$category->description}}</p>
                        <span class="badge badge-primary">{{$category->count}} Restaurants</span>
                        <a href="{{route('category.show', $category->id)}}" class="stretched-link"></a>
                        <!-- Admin section -->
                        @can('is-admin', Auth::user())
                        <div class="mt-2 d-flex">
                            <a class="btn btn-warning on-top" href="{{route('category.edit', $category->id)}}" role="button" style="border-radius: 0.25rem 0 0 0.25rem;">Edit</a>
                            <button type="button" class="btn btn-danger on-top" data-toggle="modal" data-target="#deleteCategoryModal" data-title="{{$category->name}}" style="border-radius: 0 0.25rem 0.25rem 0;">Delete</button>
                        </div>
                        @endcan
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-danger" role="alert">
                ERROR: No categories found!
            </div>
        @endforelse
    </div>

    <!-- Admin section -->
    <div class="modal fade" id="deleteCategoryModal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white" style="margin-left: -1px;">
                    <h5 class="modal-title" id="deleteCategoryModalTitle">ARE YOU SURE?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>This action will permanently delete this category from the database. There is no going back after this.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">NO, GO BACK</button>
                    <button type="button" class="btn btn-danger">YES, DELETE</button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section("scripts")
@can('is-admin', Auth::user())
<script>
    $('#deleteCategoryModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var categoryName = button.data('title').toUpperCase();
        var modal = $(this)
        modal.find('.modal-title').text('Delete ' + categoryName + ' category?')
        modal.find('.btn-danger').text('YES, DELETE ' + categoryName)
    })
</script>
@endcan
@endsection

@can('is-admin') {{-- Only admin can edit and delete categories --}}
<div class="btn-group" role="group" style="vertical-align: super;">
    <a class="btn btn-warning on-top" href="{{route('category.edit', $category->id)}}" role="button">✎ Edit</a>
    <button type="button" class="btn btn-danger on-top" data-toggle="modal" data-target="#CategoryDeleteModal" data-id="{{$category->id}}" data-title="{{$category->name}}">Delete 🗑</button>
</div>
@endcan

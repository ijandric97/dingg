@can('edit-restaurant', $restaurant) {{-- Admin and owner can edit restaurant --}}
<div class="btn-group" role="group" style="vertical-align: super;">
    <a class="btn btn-warning on-top" href="{{route('restaurant.edit', $restaurant->id)}}" role="button">✎ Edit</a>
    @can('is-admin') {{-- But only admin can delete it --}}
        <button type="button" class="btn btn-danger on-top" data-toggle="modal" data-target="#RestaurantDeleteModal" data-id="{{$restaurant->id}}" data-title="{{$restaurant->name}}">🗑️ Delete</button>
    @endcan
</div>
@endcan

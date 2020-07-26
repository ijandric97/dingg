@can('is-admin') {{-- Only Admin can delete restaurant --}}
<div class="modal fade" id="RestaurantDeleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gradient-danger text-white">
                <h5 class="modal-title">Delete Restaurant?</h5>
                <button type="button" class="close" data-dismiss="modal">✖</button>
            </div>
            <div class="modal-body">
                <p>This action will permanently delete this restaurant from the database. There is no going back after this.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">✖ Cancel</button>
                <form id="deleteRestaurantForm" method="POST" action="#">
                    @csrf
                    @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Restaurant ✔</button>
                </form>
            </div>
        </div>
    </div>
</div>


@push('scripts')
<script>
    $('#RestaurantDeleteModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var restaurantName = button.data('title');
        var restaurantId = button.data('id');
        var modal = $(this)
        modal.find('#deleteRestaurantForm').attr('action', '{{route('restaurant.index')}}/' + restaurantId);
        modal.find('.modal-title').text('Delete ' + restaurantName + '?')
        modal.find('.btn-danger').text('Delete ' + restaurantName + ' ✔')
    })
</script>
@endpush
@endcan

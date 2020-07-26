@can('is-admin') {{-- Only admin can delete categories --}}
<div class="modal fade" id="CategoryDeleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gradient-danger text-white">
                <h5 class="modal-title">Delete Category?</h5>
                <button type="button" class="close" data-dismiss="modal">✖</button>
            </div>
            <div class="modal-body">
                <p>This action will permanently delete this category from the database. There is no going back after this.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">✖ Cancel</button>
                <form id="deleteCategoryForm" method="POST" action="#">
                    @csrf
                    @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Category ✔</button>
                </form>
            </div>
        </div>
    </div>
</div>


@push('scripts')
<script>
    $('#CategoryDeleteModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var categoryName = button.data('title');
        var categoryId = button.data('id');
        var modal = $(this)
        modal.find('#deleteCategoryForm').attr('action', '{{route('category.index')}}/' + categoryId);
        modal.find('.modal-title').text('Delete ' + categoryName + '?')
        modal.find('.btn-danger').text('Delete ' + categoryName + ' ✔')
    })
</script>
@endpush
@endcan

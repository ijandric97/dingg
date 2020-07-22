@can('is-admin', Auth::user())
<div class="modal fade" id="CategoryDeleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white" style="margin-left: -1px;">
                <h5 class="modal-title">ARE YOU SURE?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>This action will permanently delete this category from the database. There is no going back after this.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">✔ Cancel</button>
                <form id="deleteCategoryForm" method="POST" action="#">
                    @csrf
                    @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                </form>
            </div>
        </div>
    </div>
</div>


@section("scripts")
<script>
    $('#CategoryDeleteModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var categoryName = button.data('title');
        var categoryId = button.data('id');
        var modal = $(this)
        modal.find('#deleteCategoryForm').attr('action', '{{route('category.index')}}/' + categoryId);
        modal.find('.modal-title').text('Delete ' + categoryName + '?')
        modal.find('.btn-danger').text('Delete ' + categoryName + ' ✖')
    })
</script>
@endsection
@endcan

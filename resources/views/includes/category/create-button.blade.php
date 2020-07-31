@can('is-admin') {{-- Only admin can create categories --}}
    <a class="btn btn-success" style="vertical-align: super;" href="{{route('category.create')}}" role="button">📄 Create</a>
@endcan

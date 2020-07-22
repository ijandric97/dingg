@can('is-admin', Auth::user())
    <a class="btn btn-success" style="vertical-align: super;" href="{{route('category.create')}}" role="button">+ Create</a>
@endcan

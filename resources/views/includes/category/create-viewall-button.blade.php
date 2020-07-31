<div class="btn-group" role="group" style="vertical-align: super;">
    @can('is-admin') {{-- Only admin can create categories --}}
        <a class="btn btn-success" href="{{route('category.create')}}" role="button">📄 Create</a>
    @endcan
    <a class="btn btn-primary" href="{{route('category.index')}}" role="button">View All ↗</a>
</div>

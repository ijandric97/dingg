<div class="btn-group" role="group" style="vertical-align: super;">
    @can('is-admin') {{-- Only admin can create restaurants --}}
        <a class="btn btn-success" href="{{route('restaurant.create')}}" role="button">📄 Create</a>
    @endcan
    <a class="btn btn-primary" href="{{route('restaurant.index')}}" role="button">View All ↗</a>
</div>

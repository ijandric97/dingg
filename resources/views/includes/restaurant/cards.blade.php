<div class="row justify-content-start mb-5" style="margin: 0px -3px;">
    @forelse ($restaurants as $restaurant)
        @include('includes.restaurant.cards-item')
    @empty
        <div class="alert alert-danger" role="alert">ERROR: No restaurants found!</div>
    @endforelse
</div>

@include('includes.restaurant.delete-modal') {{-- Delete Modal --}}

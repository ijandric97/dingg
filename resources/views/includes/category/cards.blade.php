<div class="row justify-content-center mb-5" style="margin: 0px -3px;">
    @forelse ($categories as $category)
        @include('includes.category.cards-item')
    @empty
        <div class="alert alert-danger" role="alert">ERROR: No categories found!</div>
    @endforelse
</div>

@include("includes.category.delete-modal") {{-- Delete Modal --}}

<div class="row justify-content-center mb-5" style="margin: 0px -3px;">
    @forelse ($categories as $category)
        <x-category-cards-item :category="$category"/>
    @empty
        <div class="alert alert-danger" role="alert">
            ERROR: No categories found!
        </div>
    @endforelse
</div>

{{-- Admin Modal --}}
@include("includes.category.admin-delete-modal")

<div class="modal fade" id="delete-recipe-{{ $recipe->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('recipe.destroy',$recipe->id) }}" method="post">
            @csrf
            @method('DELETE')

            <div class="modal-content border-danger text-dark">
                <div class="modal-header border-danger">
                    <h3 class="h5 modal-title text-danger">
                        <i class="far fa-trash-can"></i> {{ __('Delete Recipe') }}
                    </h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> 
                </div>
                <div class="modal-body">
                    {{-- <p>Are you sure you want to delete <span class="fw-bold">{{ $recipe->title }}</span> recipe?</p> --}}
                    <p>{!! __('Are you sure you want to delete <span class="fw-bold">:title</span> recipe?', ['title' => $recipe->title]) !!}</p>
                    <p class="fw-light"> {{ __('This action cannot be undone.') }}</p>
                </div>
                <div class="modal-footer border-0">
                    <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-danger btn-sm">{{ __('Delete') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
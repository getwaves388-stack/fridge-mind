<div class="modal fade" id="edit-ingredient-{{ $ingredient->id }}">
    <div class="modal-dialog">
        <form action="{{ route('admin.ingredients.update',$ingredient->id) }}" method="post">
            @csrf
            @method('PATCH')

            <div class="modal-content border-warning">
                <div class="modal-header border-warning">
                    <h3 class="h5 modal-title">
                        <i class="far fa-pen-to-square"></i> Edit Ingredient
                    </h3>
                </div>
                <div class="modal-body">
                    <label for="key_name">Key Name</label>
                    <input type="text" name="key_name" id="key_name" placeholder="key name" value="{{ $ingredient->key_name }}" class="form-control mb-2">
                    <label for="calorie">Calorie</label>
                    <input type="number" name="calories" id="calories" placeholder="calories" value="{{ $ingredient->calories }}" class="form-control">
                </div>
                <div class="modal-footer border-0">
                    <button class="btn btn-outline-warning btn-sm" type="button" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning btn-sm">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="delete-ingredient-{{ $ingredient->id }}">
    <div class="modal-dialog">
        <form action="{{ route('admin.ingredients.destroy',$ingredient->id) }}" method="post">
            @csrf
            @method('DELETE')

            <div class="modal-content border-danger">
                <div class="modal-header border-danger">
                    <h3 class="h5 modal-title text-danger">
                        <i class="far fa-trash-can"></i> Delete Ingredient
                    </h3>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete <span class="fw-bold">{{ $ingredient->key_name }}</span> ingredient?</p>
                    <p class="fw-light">This action will affect all the automatic calorie caluclations. </p>
                </div>
                <div class="modal-footer border-0">
                    <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </div>
            </div>
        </form>
    </div>
</div>
@extends('layouts.app')

@section('title','Admin: Ingredients')

@section('content')
    <div class="container">
        <div class="row">
            
                <h2 class="fw-bold text-secondary mb-4"><i class="fa-sharp-duotone fa-solid fa-plus"></i> Adding ingredients<br>for automatic calorie calculation</h2>
                <form action="{{ route('admin.ingredients.store') }}" method="post">
                @csrf
                    <div class="row">
                        <div class="col ps-0">
                            <label class="text-muted mb-1">Ingredient keywords</label>
                            <input type="text" name="key_name" id="key_name" class="form-control" placeholder="Add ingredient name..." required autofocus>
                        </div>
                        <div class="col">
                            <div class="row">
                                <label class="text-muted ps-0 mb-1">Approximate calorie (kcal)</label>
                                <input type="number" name="calories" min="0" placeholder="e.g. 250" class="form-control col" required>
                                <span class="col d-flex align-items-end">kcal</span>
                            </div>
                        </div>
                        <div class="col d-flex align-items-end">
                            <button type="submit" name="add" class="btn btn-primary text-uppercase fw-bold"><i class="fa-solid fa-plus"></i> Add</button>
                        </div>
                    </div>
                    <p class="text-muted mt-2">※ Calories are added when the user enters an ingredient containing this character.</p>
                </form>
        </div>
        
        <div class="row">
            <table class="table border text-secondary mt-3 text-center w-auto">
                <thead class="small table-warning text-secondary">
                    <tr>
                        <th class="px-3">#</th>
                        <th class="px-3">Ingredient keywords</th>
                        <th class="px-3">Approximate calorie</th>
                        {{-- <th>COUNT</th> --}}
                        <th class="px-3"></th>
                        <th class="px-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ingredients as $ingredient)
                    <tr>
                        <td>{{ $ingredient->id }}</td>
                        <td>{{ $ingredient->key_name }}</td>
                        <td>{{ $ingredient->calories }} kcal</td>
                        {{-- <td>{{ $ingredient-> ->count() }}</td> --}}
                        <td>
                            <button class="btn btn-outline-warning btn-sm me-2" data-bs-toggle="modal" data-bs-target="#edit-ingredient-{{ $ingredient->id }}" title="Edit">
                            <i class="fa-solid fa-pen"></i>
                            </button>
                        </td>
                        <td>
                            <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete-ingredient-{{ $ingredient->id }}" title="Delete">
                            <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                        {{-- <td>
                            <form action="{{ route('admin.ingredients.destroy', $ingredient->id) }}" method="POST" onsubmit="return confirm('Do you want to delete this ingredient keyword?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-danger btn p-0 border-0"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td> --}}
                    </tr>
                    @include('admin.ingredients.modal.action')
                    @empty
                    <tr>
                        <td colspan="5" class="text-muted">No ingredients found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
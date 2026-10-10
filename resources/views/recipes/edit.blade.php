@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')

<a href="{{ route('recipe.index') }}" id="back" class="btn btn-outline-secondary rounded-pill shadow-sm mb-3" title="back">
    <i class="fa-solid fa-chevron-left"></i> {{ __('Back') }}
</a>

<div class="container p-0">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <h1 class="mb-4">{{ __('Edit the recipe') }}</h1>
            
            <form action="{{ route('recipe.update',$recipe->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="mb-3">
                    <label for="title" class="form-label">{{ __('Recipe Name') }}</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title',$recipe->title) }}">
                    @error('title')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                {{-- <div class="mb-3">
                    <label for="calories" class="form-label">Calories</label>
                    <input type="number" name="calories" id="calories" class="form-control" value="{{ old('calories',$recipe->calories) }}">
                </div> --}}
                <div class="mb-3">
                    <label for="image" class="form-label">{{ __('Recipe Photo') }}</label>

                    <img src="{{ asset('storage/images/'.$recipe->image) }}" alt="{{ $recipe->image }}" class="w-100 img-thumbnail">

                    <input type="file" name="image" id="image" class="form-control">

                    @if($recipe->image)
                        <div class="p-2 mt-2 border rounded" style="max-width: 300px;">    
                            <input class="form-check-input" type="checkbox" name="delete_image" id="delete_image" value="1">
                            <label class="form-check-label text-danger" for="delete_image"> {{ __('Delete the photo') }} <i class="fa-solid fa-trash-can"></i></label> 
                        </div>
                        <div class="form-text text-muted" id="image-info">
                        {{ __('If you want to replace the photo, please select a new file.') }} <br>
                        {{ __('Acceptable formats are jpeg,jpg,png and gif only.') }}<br>
                        {{ __('Maximum file size is 1048KB.') }}
                        </div>
                    @else
                        <div class="form-text text-muted" id="image-info">
                        {{ __('Acceptable formats are jpeg,jpg,png and gif only.') }}<br>
                        {{ __('Maximum file size is 1048KB.') }}
                        </div>
                    @endif

                    @error('image')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="ingredient_list" class="form-label">{{ __('Ingredients') }}</label>
                    <textarea name="ingredient_list" id="ingredient_list" rows="1" class="form-control">{{ old('ingredient_list',$recipe->ingredient_list) }}</textarea>
                    <div class="form-text text-muted" id="ingredient_list-info">
                        {{ __('Please enter the ingredients, separating each one with (,) or (、).') }}
                    </div>
                    @error('ingredient_list')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">{{ __('Note') }}</label>
                    <textarea name="description" id="description" rows="5" class="form-control">{{ old('description',$recipe->description) }}</textarea>
                    @error('description')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-success">
                        {{ __('Save Recipe') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@extends('layouts.app')

@section('title','Create Recipe')

@section('content')

<a href="{{ route('index') }}" id="back" class="btn btn-outline-secondary rounded-pill shadow-sm" title="back">
    <i class="fa-solid fa-chevron-left"></i> {{ __('Back') }}
</a>

<div class="container p-0">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <h1 class="mb-4">{{ __('Record a new recipe') }}</h1>
            
            <form action="{{ route('recipe.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">{{ __('Recipe Name') }}</label>
                    <input type="text" name="title" class="form-control" placeholder="{{ __('e.g. Chicken Curry') }}" value="{{ old('title') }}">
                    @error('title')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">{{ __('Recipe Photo') }}</label>
                    <input type="file" name="image" id="image" class="form-control">
                    <div class="form-text text-muted" id="image-info">
                        {{ __('Acceptable formats are jpeg,jpg,png and gif only.') }}<br>
                        {{ __('Maximum file size is 1048KB.') }}
                    </div>
                    @error('image')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="ingredient_list" class="form-label">{{ __('Ingredients') }}</label>
                    <textarea name="ingredient_list" id="ingredient_list" rows="1" class="form-control" placeholder="{{ __('e.g. chicken,onion,carrot,potato') }}">{{ old('ingredient_list') }}</textarea>
                    <div class="form-text text-muted" id="ingredient_list-info">
                        {{ __('Please enter the ingredients, separating each one with (,) or (、).') }}
                    </div>
                    @error('ingredient_list')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">{{ __('Note') }}</label>
                    <textarea name="description" id="description" rows="5" class="form-control">{{ old('description') }}</textarea>
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
@extends('layouts.app')

@section('title','Edit Ingedient')

@section('content')

<a href="{{ route('index') }}" id="back" class="btn btn-outline-secondary rounded-pill shadow-sm mb-3" title="back">
    <i class="fa-solid fa-chevron-left"></i> {{ __('Back') }}
</a>

<div class="container p-0">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-5">
                <div class="card-body">
                    <h3 class="mb-3"><i class="fa-solid fa-pen-to-square"></i> {{ __('Edit Ingredient') }}</h3>
                    <form action="{{ route('ingredient.update', $ingredient->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="row gx-1 gy-2">
                            <div class="col-md-5 col-12">
                                <label class="form-label">{{ __('Ingredient') }}</label>
                                <textarea name="name" id="name" rows="1" class="form-control" style="field-sizing:content;">{{ old('name',$ingredient->name)}}</textarea>
                                @error('name')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 col-7">
                                <label class="form-label">{{ __('Use by') }}</label>
                                <input type="date" name="expiry_date" id="expiry_date" class="form-control"  value="{{ old('expiry_date',$ingredient->expiry_date)}}">
                                @error('expiry_date')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 col-5">
                                <label class="form-label">{{ __('Count') }}</label>
                                <input type="number" name="quantity" id="quantity" value="{{ old('quantity',$ingredient->quantity)}}" min="1" class="form-control">
                                @error('quantity')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <button type="submit" class="btn btn-primary w-100 shadow-sm">
                                <i class="fa-solid fa-check"></i> {{ __('Update') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
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
                        @method('PATCh')
                        <div class="row g-3 align-items-end">
                            <div class="col-4">
                                <label class="form-label">{{ __('Ingredient') }}</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name',$ingredient->name)}}" placeholder="Add ingredient (Required)">
                                @error('name')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-4">
                                <label class="form-label">{{ __('Use by') }}</label>
                                <input type="date" name="expiry_date" id="expiry_date" class="form-control" value="{{ old('expiry_date',$ingredient->expiry_date)}}" placeholder="Expiry date">
                                @error('expiry_date')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-2">
                                <label class="form-label">{{ __('Count') }}</label>
                                <input type="number" name="quantity" id="quantity" value="{{ old('quantity',$ingredient->quantity)}}" min="1" class="form-control">
                                @error('quantity')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-2">
                                <button type="submit" class="btn btn-primary w-100 shadow-sm">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
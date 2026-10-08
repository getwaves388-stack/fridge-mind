@extends('layouts.app')

@section('title','Edit Ingedient')

@section('content')

<a href="{{ route('index') }}" id="back" class="btn btn-outline-secondary rounded-pill shadow-sm" title="back">
    <i class="fa-solid fa-chevron-left"></i> {{ __('Back') }}
</a>

<div class="container p-0">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-5">
                <div class="card-body">
                    <h3 class="mb-3"><i class="fa-solid fa-pen-to-square"></i> {{ __('Edit Ingredient') }}</h3>
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th class="col-5">{{ __('Ingredient') }}</th>
                                <th class="col-3">{{ __('Expiry date') }}</th>
                                <th class="col-2">{{ __('Count') }}</th>
                                <th class="col-2"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <form action="{{ route('ingredient.update', $ingredient->id) }}" method="post">
                            @csrf
                            @method('PATCh')
                                <tr>
                                    <td>
                                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name',$ingredient->name)}}" placeholder="Add ingredient (Required)">
                                        @error('name')
                                        <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </td>
                                    <td>
                                        <input type="date" name="expiry_date" id="expiry_date" class="form-control" value="{{ old('expiry_date',$ingredient->expiry_date)}}" placeholder="Expiry date">
                                        @error('expiry_date')
                                        <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </td>
                                    <td>
                                        <input type="number" name="quantity" id="quantity" value="{{ old('quantity',$ingredient->quantity)}}" min="1" class="form-control">
                                        @error('quantity')
                                        <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-primary w-100">
                                            {{ __('Update') }}
                                        </button>
                                    </td>
                                </tr>
                            </form>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
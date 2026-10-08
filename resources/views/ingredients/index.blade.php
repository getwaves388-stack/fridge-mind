@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="container p-0">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm mt-4">
                <div class="card-header h3 py-3 text-center bg-dark text-info"><i class="fa-solid fa-snowflake"></i> {{ __('Your Fridge Food') }} <i class="fa-solid fa-snowflake"></i></div>

                <div class="card-body bg-secondary">
                    <form action="{{ route('ingredient.store') }}" method="post">
                        @csrf
                        <div class="row gx-2 mb-3">
                            <div class="col-5">
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name')}}" placeholder="{{ __('Add ingredient (Required)') }}" autofocus>
                                @error('name')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-3">
                                {{-- Dynamically switching types on focus in JavaScript --}}
                                <input type="text" name="expiry_date" id="expiry_date" class="form-control" value="{{ old('expiry_date')}}" placeholder="{{ __('Expiry date') }}" onfocus="this.type='date'" onblur="if(!this.value)this.type='text'">
                                @error('expiry_date')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-2">
                                <div class="d-flex align-items-center">
                                <label for="quantity" class="me-1 text-white"><i class="fa-solid fa-xmark"></i></label>
                                <input type="number" name="quantity" id="quantity" value="{{ old('quantity',1) }}" min="1" class="form-control">
                                </div>
                                @error('quantity')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fa-solid fa-plus"></i> {{ __('Add') }}
                                </button>
                            </div>
                        </div>
                    </form>
                    @if ($all_ingredients->isNotEmpty())
                        <div class="rounded overflow-hidden">
                            <table class="table align-middle mb-2">
                                <thead class="table-secondary">
                                    <tr>
                                        <th class="col-5">{{ __('Ingredient') }}</th>
                                        <th class="col-3">{{ __('Expiry date') }}</th>
                                        <th class="col-2">{{ __('Count') }}</th>
                                        <th class="col-2">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($all_ingredients as $ingredient)
                                        @php
                                            // time zone : Japan (Asia/Tokyo) and convert these into timestamps (in seconds).
                                            $todayRaw = \Carbon\Carbon::today('Asia/Tokyo')->startOfDay();
                                            
                                            $expiryRaw = \Carbon\Carbon::parse($ingredient->expiry_date, 'Asia/Tokyo')->startOfDay();

                                            // Calculate the number of days remaining until the expiry date from today.
                                            //$secondsDiff = $todayRaw->diffInSeconds($expiryRaw, false);

                                            // A day is 86,400 seconds.
                                            //$daysDiff = (int) ($secondsDiff / 86400); 

                                            //Calculation of the difference in days
                                            $daysDiff = (int) $todayRaw->diffInDays($expiryRaw, false);
                                        
                                        @endphp
                                        <tr class="border-bottom">
                                            {{-- Ingredient --}}
                                            <td>{{ $ingredient->name }}</td>
                                            {{-- Expiry date --}}
                                            <td>
                                                @if ($ingredient->expiry_date)
                                                    @if ($daysDiff < 0)
                                                        <span class="text-danger fw-bold" title="Expired!">
                                                            <i class="fa-solid fa-triangle-exclamation me-1"></i>{{ $ingredient->expiry_date }}
                                                        </span>
                                                    @elseif ($daysDiff <= 2)
                                                        <span class="text-warning fw-bold" style="color: #fd7e14 !important;" title="Expires soon!">
                                                            <i class="fa-solid fa-clock me-1"></i>{{ $ingredient->expiry_date }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted">
                                                            <i class="fa-solid fa-clock me-1"></i>{{ $ingredient->expiry_date }}
                                                        </span>
                                                    @endif
                                                @else
                                                    <div class="text-muted"><i class="fa-solid fa-minus"></i></div>
                                                @endif  
                                            </td>
                                            {{-- Quantity --}}
                                            <td>{{ $ingredient->quantity }}</td>
                                            {{-- Action Buttons Edit/Delete --}}
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('ingredient.edit',$ingredient->id)}}" class="btn btn-sm text-secondary" title="Edit"><i class="fa-solid fa-pen-to-square fa-lg"></i></a>

                                                    <form action="{{ route('ingredient.destroy',$ingredient->id) }}" method="post" class="ms-1">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" title="Delete" class="btn btn-sm text-danger"><i class="fa-solid fa-trash-can fa-lg"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="py-2 text-center text-muted">
                            <div class="mb-2">
                                <i class="fa-solid fa-box-open fa-2x text-black-50"></i>
                            </div>
                            <p class="mb-0 fw-bold">{{ __('No ingredients registered yet.') }}</p>
                            <span class="small mt-1">{{ __('Add ingredients and start managing your fridge!') }}</span>
                        </div>
                    @endif
                </div>
            </div>
            {{-- Suggestions --}}
            <div class="m-5 text-center text-warning text-decoration-underline">
                <h2><i class="fa-solid fa-kiwi-bird"></i> {{ __('Recipe suggestions') }} <i class="fa-solid fa-feather"></i></h2>
            </div>
            
            @if($sortedSuggestions->isEmpty())
                <div class="my-5 text-center">
                    <div class="mb-2">
                        <i class="fa-solid fa-file fa-2x text-black-50"></i>
                    </div>
                    <h3 class="fw-bold text-secondary">{{ __('No Matching Recipes') }}</h3>
                    <a href="{{ route('recipe.create') }}" class="btn btn-success rounded-pill px-4 shadow-sm">{{ __('Create a new recipe') }}</a>
                </div>
            @else
                @foreach($sortedSuggestions as $item)
                    @php
                        $recipe = $item['recipe'];
                        $matchRate = $item['match_rate'];
                        $missing = $item['missing_ingredients'];
                    @endphp

                    <div class="card shadow my-5">
                        <!-- missing ingredients -->
                        @if($matchRate == 100)
                            <div class="card-header bg-success-subtle text-success border border-2 border-success p-2">
                                <i class="fa-solid fa-circle-check"></i> {{ __('Ready to Cook!') }}
                            </div>
                        @else
                            <div class="card-header bg-danger-subtle border border-2 border-danger text-danger p-2">
                                <p class="fw-bold mb-1"><i class="fa-solid fa-triangle-exclamation"></i> {{ __('Missing Ingredients:') }}</p>
                                <div class="gap-1">
                                    @foreach($missing as $missingItem)
                                        <span class="fw-bold px-2 py-1 d-inline-block my-1 rounded border border-danger-subtle">x {{ $missingItem }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        <div class="bg-light text-center border-start border-end border-bottom border-2 border-warning">
                            @if($recipe->image)
                                <img src="{{ asset('storage/images/'.$recipe->image) }}" alt="{{ $recipe->image }}" class="w-100">
                            @else
                                <p class="text-muted fs-4 m-3"><i class="fa-solid fa-utensils text-black-50"></i>  No image</p>
                            @endif
                        </div>
                        <div class="card-body border border-2 border-warning">
                            <div class="row mb-3">
                                <a href="{{ route('recipe.show',$recipe->id)}}" class="col-auto m-0 h3 text-decoration-none text-dark"><i class="fa-solid fa-angles-right"></i> {{ $recipe->title }}</a>
                                <p class="col m-0 d-flex align-items-end"><span class="me-1"><i class="fa-solid fa-fire text-secondary"></span></i>{{ $recipe->calories }} kcal</p>
                                <div class="col-auto d-flex align-items-end">
                                    {{ $matchRate }}% Match
                                </div>
                            </div>

                            <div class="gap-1">
                                @php
                                    // Split by commas(,) into an array and trim space.
                                    $ingredients = preg_split('/[,，、\x{3001}\x{ff0c}]+/u', $recipe->ingredient_list);
                                    $ingredients = array_filter(array_map('trim', $ingredients));
                                @endphp
                                @foreach($ingredients as $ingredient)
                                    <span class="px-2 py-1 d-inline-block my-1 rounded border">{{ $ingredient }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

@endsection

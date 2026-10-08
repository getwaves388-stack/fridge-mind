@extends('layouts.app')

@section('title','Recipes')

@section('content')

<a href="{{ route('recipe.index') }}" id="back" class="btn btn-outline-secondary rounded-pill shadow-sm" title="back">
    <i class="fa-solid fa-chevron-left"></i> {{ __('Back') }}
</a>

<div class="container p-0">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow mt-4">
                <div class="card-body">
                    <div class="row mb-4">
                        <h3 class="col-8 m-0 text-dark">{{ $recipe->title }}</h3>
                        
                        <div class="col-4 ms-auto mt-auto text-end">
                            {{ __('Record Date:') }} {{ \Carbon\Carbon::parse($recipe->created_at)->format('Y/m/d') }}
                        </div>
                    </div>
                    
                    <div class="bg-light border rounded text-center overflow-hidden" style="max-height: 500px;">
                        @if($recipe->image)
                        <img src="{{ asset('storage/images/'.$recipe->image) }}" alt="{{ $recipe->image }}" class="w-100">
                        @else
                            <p class="text-muted fs-4 m-3"><i class="fa-solid fa-utensils text-black-50"></i>  No image</p>
                        @endif
                    </div>

                    <div class="row mt-4">
                        <div class="col-4">
                            <h5 class="mb-3 fw-bold"><i class="fa-solid fa-list"></i> {{ __('Ingredients') }}</h5>
                            <p class="mb-1"><i class="fa-solid fa-fire text-secondary"></i> {{ __('Total calories :') }} {{ $recipe->calories }} kcal</p>
                            <ul>
                                @php
                                    // Split ingredients by commas.
                                    $ingredients = preg_split('/[,，、]+/u', $recipe->ingredient_list);
                                @endphp
                                
                                @foreach(array_filter(array_map('trim', $ingredients)) as $item)
                                    @php
                                        // Standardize the display
                                        $normalizedItem = mb_convert_kana($item, 'c', 'UTF-8');
                                        $normalizedItem = strtolower($normalizedItem);
                                        
                                        // Check if it is among the master ingredients.
                                        $foundCalorie = null;
                                        foreach ($calorie as $key => $calories) {
                                            if (str_contains($normalizedItem, $key)) {
                                                $foundCalorie = $calories . ' kcal';
                                                break;
                                            }
                                        }
                                    @endphp
                                    <li>
                                        <span class="fw-bold text-dark">{{ $item }}</span> : 
                                        <!-- Display the numerical value if available; otherwise, display "- kcal". -->
                                        <span class="{{ $foundCalorie ? 'text-primary' : 'text-secondary' }}">
                                            {{ $foundCalorie ?? '- kcal' }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="col-8">
                            <h5 class="mb-3 fw-bold"><i class="fa-solid fa-bookmark"></i> {{ __('Cooking Note') }}</h5>
                            @if($recipe->description)
                                <p class="mb-0" style="white-space: pre-wrap; word-break: break-word; overflow-wrap: break-word;">{{ $recipe->description }}</p>
                            @else
                                <p class="text-muted p-3 text-center">{{ __('No notes provided') }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <div class="mt-2 text-end">
                            <a href="{{ route('recipe.edit', $recipe->id) }}" class="btn btn-secondary btn-sm">
                                <i class="fa-solid fa-pen-to-square"></i> {{ __('Edit') }}
                            </a>
                        </div>
                        {{-- <div class="mt-2 text-end">
                            <form action="{{ route('recipe.destroy',$recipe->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash-can"></i> Delete</button>
                            </form>
                        </div> --}}
                        <div class="mt-2 text-end">
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete-recipe-{{ $recipe->id }}" title="Delete">
                            <i class="fa-solid fa-trash-can"></i> {{ __('Delete') }}
                            </button>
                        </div>
                        @include('recipes.modal.action')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@extends('layouts.app')

@section('title','Recipes')

@section('content')

<a href="{{ route('index') }}" id="back" class="btn btn-outline-secondary rounded-pill shadow-sm mb-3" title="back">
    <i class="fa-solid fa-chevron-left"></i> {{ __('Back') }}
</a>

<div class="container p-0">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="mb-4 text-center">
                <h2>{{ __('Cooking History') }} <i class="fa-regular fa-calendar-days"></i></h2>
            </div>
            @forelse ($all_recipes as $recipe)
                <div class="card shadow my-4 overflow-hidden">
                    <div class="row g-0">
                        <div class="col-4 p-0 d-flex align-items-center justify-content-center bg-light border rounded-start-1">
                            @if($recipe->image)
                            <img src="{{ asset('storage/images/'.$recipe->image) }}" alt="{{ $recipe->image }}" class="w-100 h-100 rounded-start-1" style="object-fit: cover;">
                            @else
                            <div class="text-center p-3">
                                <p class="text-muted m-0 fs-3"><i class="fa-solid fa-utensils text-black-50"></i>  No image</p>
                            </div>
                            @endif
                        </div>
                        <div class="col-8">
                            <div class="card-body">
                                
                                <div class="row mb-2">
                                    <a href="{{ route('recipe.show',$recipe->id)}}" class="m-0 h3 text-decoration-none text-dark"><i class="fa-solid fa-angles-right"></i> {{ $recipe->title }}</a>
                                </div>

                                <p><i class="fa-solid fa-fire text-secondary"></i> {{ $recipe->calories }} kcal</p>

                                <div class="gap-1">
                                    @php
                                        // Split by commas(,) into an array and trim space.    
                                        $ingredients = preg_split('/[,，、\x{3001}\x{ff0c}]+/u', $recipe->ingredient_list);
                                        $ingredients = array_filter(array_map('trim', $ingredients));
                                    @endphp
                                    @foreach($ingredients as $ingredient)
                                        <span class="px-2 py-1 d-inline-block my-2 border rounded">{{ $ingredient }}</span>
                                    @endforeach
                                </div>
                                
                                <div class="text-end">
                                    {{ __('Record Date:') }} {{ \Carbon\Carbon::parse($recipe->created_at)->format('Y/m/d') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="m-5 text-center">
                    <div class="mb-2">
                        <i class="fa-solid fa-file fa-2x text-black-50"></i>
                    </div>
                    <h3 class="fw-bold text-secondary">{{ __('No Recipes Yet') }}</h3>
                    <a href="{{ route('recipe.create') }}" class="btn btn-success rounded-pill px-4 shadow-sm">{{ __('Create a new recipe') }}</a>
                </div>
            @endforelse
            <div class="mt-4 d-flex justify-content-center">
                {{ $all_recipes->links() }}
            </div>
        </div>
    </div>
</div>

@endsection
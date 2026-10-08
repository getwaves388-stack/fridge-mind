@extends('layouts.app')

@section('title','Admin: Posts')

@section('content')
    <table class="table table-hover align-middle bg-white border text-secondary">
        <thead class="table-primary text-secondary small">
            <tr class="text-center">
                <th>ID</th>
                <th style="width: 80px;">IMAGE</th>
                <th>INGREDIENT</th>
                <th>OWNER</th>
                <th>CREATED AT</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($all_recipes as $recipe)
                <tr>
                    <td class="text-center">{{ $recipe->id }}</td>
                    <td>
                        @if($recipe->image)
                        <a href="#">
                            <img src="{{ asset('storage/images/'.$recipe->image) }}" alt="{{ $recipe->image }}" style="width: 80px;">
                        </a>
                        @else
                            <div class="text-center" style="width: 80px;">
                                <span class="text-muted fw-bold">No Image</span>
                            </div>
                        @endif
                    </td>
                    <td>
                        <div class="gap-1">
                        @php
                            // Split by commas(,) into an array and trim space.
                            $ingredients = array_map('trim', explode(',', $recipe->ingredient_list));
                        @endphp
                        @foreach($ingredients as $ingredient)
                            <span class="px-2 py-1 d-inline-block my-1 rounded border" style="font-size: 0.8rem;">{{ $ingredient }}</span>
                        @endforeach
                        </div>
                    </td>
                    <td class="text-center">
                        <a href="#" class="text-decoration-none text-dark">{{ $recipe->user->name }}</a>
                    </td>
                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($recipe->created_at)->format('Y/m/d') }}<br>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="lead text-muted text-center" colspan="5">No recipes found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $all_recipes->links() }}
@endsection
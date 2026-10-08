<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\RecipesController;
use App\Http\Controllers\Admin\IngredientsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LanguageController;


Route::get('lang/{lang}', [LanguageController::class, 'switchLang'])->name('lang.switch');

Auth::routes();

Route::group(['middleware' => 'auth'], function(){

    Route::get('/',[IngredientController::class,'index'])->name('index');
    
        Route::group(['prefix' => 'ingredient', 'as' => 'ingredient.'], function(){

        Route::post('/store',[IngredientController::class,'store'])->name('store');

        Route::get('/{id}/edit',[IngredientController::class,'edit'])->name('edit');
        
        Route::patch('/{id}/update',[IngredientController::class,'update'])->name('update');

        Route::delete('/{id}/destroy',[IngredientController::class,'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'recipe', 'as' => 'recipe.'], function(){

        Route::get('/',[RecipeController::class,'index'])->name('index');

        Route::get('/create',[RecipeController::class,'create'])->name('create');

        Route::post('/store',[RecipeController::class,'store'])->name('store');

        Route::get('/{id}/show',[RecipeController::class,'show'])->name('show');

        Route::get('/{id}/edit',[RecipeController::class,'edit'])->name('edit');

        Route::patch('/{id}/update',[RecipeController::class,'update'])->name('update');

        Route::delete('/{id}/destroy',[RecipeController::class,'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'admin', 'as' => 'admin.','middleware' => 'admin'], function(){
        #Admin User
        Route::get('/users',[UsersController::class,'index'])->name('users');

        Route::delete('/users/{id}/deactivate', [UsersController::class, 'deactivate'])->name('users.deactivate');

        Route::patch('/users/{id}/activate', [UsersController::class, 'activate'])->name('users.activate');

        #Admin Recipe
        Route::get('/recipes',[RecipesController::class,'index'])->name('recipes');

        #Admin Ingredient
        Route::get('/ingredients',[IngredientsController::class,'index'])->name('ingredients');

        Route::post('/ingredients', [IngredientsController::class, 'store'])->name('ingredients.store');

        Route::patch('/ingredients/{id}/update',[IngredientsController::class, 'update'])->name('ingredients.update');

        Route::delete('/ingredients/{id}', [IngredientsController::class, 'destroy'])->name('ingredients.destroy');

    });

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');

    Route::post('/profile/health', [ProfileController::class, 'storeHealth'])->name('profile.store_health'); 


});


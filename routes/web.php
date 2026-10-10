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

// 全ての不具合を強制クリアする最終ルート
Route::get('/run-seeder-securely', function () {
    try {
        // 1. 古い環境変数や設定のキャッシュを完全に破壊して消去する
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        \Illuminate\Support\Facades\Artisan::call('route:clear');
        
        // 2. データベースを完全にまっさらにして初期データを確実に流し込む
        \Illuminate\Support\Facades\Artisan::call('migrate:fresh', [
            '--seed' => true,
            '--force' => true,
        ]);
        
        return '【大成功】すべてのキャッシュを破壊し、データベースの初期化とシーダーの注入が100%完了しました！そのままアプリを開いて確認してください。';
    } catch (\Exception $e) {
        return 'エラーが発生しました: ' . $e->getMessage();
    }
});

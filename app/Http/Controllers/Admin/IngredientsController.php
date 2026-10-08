<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Calorie;
use App\Models\Ingredient;

class IngredientsController extends Controller
{
    private $ingredient; //null

    public function __construct(Calorie $ingredient){
        
        $this->ingredient = $ingredient;
    
    }

    public function index()
    {
        $ingredients = Calorie::orderBy('created_at', 'desc')->get();
        return view('admin.ingredients.index')->with('ingredients',$ingredients);
    }

    public function store(Request $request)
    {
        $request->validate([
            'key_name' => 'required|string|max:255|unique:calories,key_name',
            'calories' => 'required|integer|min:0',
        ]);

        Calorie::create($request->all());

        return redirect()->back();
    }

    public function update(Request $request, $id){
        $request->validate([
            'key_name' => 'required|max:50|unique:calories,key_name,'. $id ,
            'calories' => 'required|integer|min:0'. $id
        ]);

        $ingredient = $this->ingredient->findOrFail($id);
        $ingredient->key_name = ucwords(strtolower($request->key_name));
        // ucwords() - Transforms All First Letters of A sentence To Be Uppercase
        // strtolower() - transforms all the text to lowercase.
        $ingredient->calories = $request->calories;
        $ingredient->save();

        return back();
    }
    
    public function destroy($id)
    {
        $ingredient = Calorie::findOrFail($id);
        $ingredient->delete();

        return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient; //import new model
use Illuminate\Support\Facades\Auth;
use App\Models\Recipe;
use App\Models\User;

class IngredientController extends Controller
{
    private $ingredient;

    public function __construct(Ingredient $ingredient)
    {
        /**
         * Create a new controller instance.
         *
         * @return void
         */
        $this->middleware('auth');
        
        $this->ingredient = $ingredient;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        #Same as: "SELECT * FROM users WHERE id = $user_id";
        $user = User::find(Auth::id());
        
        if (!$user) { return redirect()->route('login'); }

        $all_ingredients = $user->ingredients()->orderByRaw('expiry_date IS NULL ASC')->oldest('expiry_date')->get();


        // Retrieve the names of ingredients in the refrigerator as an array (convert to lowercase).
        $myIngredients = $all_ingredients->pluck('name')
            ->map(function ($name) {
                return strtolower(trim($name));
            })
            ->toArray();

        $recipes = $user->recipes;
        $suggestions = collect();

        foreach ($recipes as $recipe) {
            // Break down the ingredient text into separate items using "," or "、"
            $recipeIngredients = preg_split('/[,，、\x{3001}\x{ff0c}]+/u', $recipe->ingredient_list); 

            $matchedCount = 0;
            $missingIngredients = [];

            foreach ($recipeIngredients as $recipeItem) {
                $recipeItem = strtolower(trim($recipeItem));
                if (empty($recipeItem)) continue;

                $isFound = false;
                foreach ($myIngredients as $myFood) {
                    // Does the list of ingredients in the refrigerator contain the recipe's ingredient string?
                    if (str_contains($myFood, $recipeItem)) {
                        $isFound = true;
                        break;
                    }
                }

                if ($isFound) {
                    $matchedCount++;
                } else {
                    $missingIngredients[] = $recipeItem;
                }
            }

            // If there are no matching ingredients, don't include this recipe in the suggestion list.
            if ($matchedCount === 0) {
                continue; // skip
            }

            // Calculation of coverage rate
            $totalCount = count(array_filter(array_map('trim', $recipeIngredients)));
            $matchRate = $totalCount > 0 ? round(($matchedCount / $totalCount) * 100) : 0;

            $suggestions->push([
                'recipe' => $recipe,
                'match_rate' => $matchRate,
                'missing_ingredients' => $missingIngredients,
            ]);
        }

        // Sort by match level (highest first)
        $sortedSuggestions = $suggestions->sortByDesc('match_rate')->values();


        return view('ingredients.index')->with('all_ingredients',$all_ingredients)->with('sortedSuggestions',$sortedSuggestions);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50',
            'quantity' => 'nullable|string|max:50'
        ]);

        $this->ingredient->user_id = Auth::user()->id;
        $this->ingredient->name = $request->name;
        $this->ingredient->quantity = $request->quantity;
        $this->ingredient->expiry_date = $request->expiry_date;
        $this->ingredient->save();
        return redirect()->back();
    }

    public function edit($id){
        # Same as: "SELECT * FROM ingredients WHERE id = $id"; ?
        $ingredient = $this->ingredient->findOrFail($id);
        return view('ingredients.edit')->with('ingredient',$ingredient);
    }

    public function update(Request $request,$id){
        $request->validate([
            'name' => 'required|string|max:50',
            'quantity' => 'required|integer|min:1'
        ]);

        # Same as: "SELECT * FROM ingredients WHERE id = $id";
        $ingredient = $this->ingredient->findOrFail($id);
        $ingredient->name = $request->name; 
        $ingredient->expiry_date = $request->expiry_date;
        $ingredient->quantity = $request->quantity;
        $ingredient->save();

        return redirect()->route('index');
    }

    public function destroy($id){
        $this->ingredient->destroy($id);
        return redirect()->back();
    }

}

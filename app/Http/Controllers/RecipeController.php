<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User; 
use App\Models\Calorie;

class RecipeController extends Controller
{
    private $recipe;

    const LOCAL_STORAGE_FOLDER = 'images/';

    public function __construct(Recipe $recipe)
    {
        $this->recipe = $recipe;
    }

    public function index()
    {
        #Same as: "SELECT * FROM users WHERE id = $user_id";
        $user = User::find(Auth::id());
        
        if (!$user) { return redirect()->route('login'); }

        $all_recipes = $user->recipes()->latest()->paginate(10);

        return view('recipes.index')->with('all_recipes',$all_recipes);
    }

    public function create()
    {
        return view('recipes.create');
    }


    /**
     * A private method that automatically calculates the total calories from the ingredient text.
     */
    private function calculateTotalCalories($ingredient_list)
    {
        // 1. Retrieve all master ingredient records from the database and convert them into an associative array.
        $calorie = Calorie::pluck('calories', 'key_name')->toArray();

        // 2. Split the text into an array using the three specified characters (','' ，''、').
        $ingredients = preg_split('/[,，、]+/u', $ingredient_list);
        $totalCalories = 0;

        foreach ($ingredients as $item) {
            // Standardize formatting (convert Katakana to Hiragana, remove leading/trailing whitespace, convert to lowercase)
            $normalizedItem = mb_convert_kana(trim($item), 'c', 'UTF-8');
            $normalizedItem = strtolower($normalizedItem);

            if (empty($normalizedItem)) {
                continue;
            }

            // 3. If the ingredients match those in the dictionary, the calories are added.
            $foundKey = null;
            foreach ($calorie as $key => $calories) {
                // Determine whether the input string contains a dictionary keyword.
                if (str_contains($normalizedItem, $key)) {
                    $totalCalories += $calories;
                    break;
                }
            }

            if ($foundKey) {
                $totalCalories += $calorie[$foundKey];
            }
        }

        return $totalCalories;
    }

    /**
     * 
     */

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:50',
            'ingredient_list' => 'required|string',
            'image' => 'nullable|mimes:jpeg,jpg,png,gif|max:1048',
            'description' => 'nullable|max:1000'
        ]);

        // Automatically calculate the total calories from the entered ingredients.
        $calculatedCalories = $this->calculateTotalCalories($request->ingredient_list);

        $this->recipe->user_id = Auth::user()->id;
        $this->recipe->title = $request->title;
        $this->recipe->ingredient_list = $request->ingredient_list;
        $this->recipe->calories = $calculatedCalories; 
        $this->recipe->description = $request->description;
        // Save the image and assign a file name.
        $this->recipe->image = $this->saveImage($request->image); 
        $this->recipe->save();

        return redirect()->route('recipe.index');
    }

    public function saveImage($image)
    {
        if (!$image) {
            return null; 
        }

        // Change the name of the image to CURRENT TIME to avoid overwriting
        $image_name = time() . "." . $image->extension();

        // Save the image to storage/app/public/images/
        $image->storeAs(self::LOCAL_STORAGE_FOLDER, $image_name);

        return $image_name;
    }

    public function show($id)
    {
        // Retrieve the recipe
        $recipe = $this->recipe->findOrFail($id);

        // Retrieve calorie data from database
        $calorie = Calorie::pluck('calories', 'key_name')->toArray();

        return view('recipes.show')->with('recipe',$recipe)->with('calorie', $calorie);
    }

    public function edit($id)
    {
        $recipe = $this->recipe->findOrFail($id);

        if($recipe->user->id != Auth::user()->id)
            {
                return redirect()->back();
            }
            
        return view('recipes.edit')->with('recipe',$recipe);
    }


    public function update(Request $request, $id){
        $request->validate([
            'title' => 'required|max:50',
            'ingredient_list' => 'required|string',
            'image' => 'nullable|mimes:jpeg,jpg,png,gif|max:1048',
            'description' => 'nullable|max:1000'
        ]);

        // recalculation
        $calculatedCalories = $this->calculateTotalCalories($request->ingredient_list);

        $recipe = $this->recipe->findOrFail($id);
        $recipe->title = $request->title;
        $recipe->ingredient_list = $request->ingredient_list;
        $recipe->calories = $calculatedCalories; // Overwrite with the latest automatically calculated calorie count.
        $recipe->description = $request->description;

        // Check if the image deletion option is selected.
        if ($request->delete_image) {
            
            // Delete the previous image from the local storage
            $this->deleteImage($recipe->image);
            
            // Set the data to "no image (null)."
            $recipe->image = null;
        } else {
            // If there is a new image
            if ($request->image) {
                //Delete the previous image from the local storage
                $this->deleteImage($recipe->image);
                //Save the new image
                $recipe->image = $this->saveImage($request->image);
            }   
        }

        $recipe->save();

        return redirect()->route('recipe.show',$id);
    }

    private function deleteImage($image)
    {
        $image_path = self::LOCAL_STORAGE_FOLDER . $image;

        if(storage::disk('public')->exists($image_path)){
            storage::disk('public')->delete($image_path);
        }
    }

    public function destroy($id)
    {
        $recipe = $this->recipe->findOrFail($id);

        //delete from storage (Make sure not to forget!)
        $this->deleteImage($recipe->image);

        $recipe->delete();

        return redirect()->route('recipe.index');
    }
}

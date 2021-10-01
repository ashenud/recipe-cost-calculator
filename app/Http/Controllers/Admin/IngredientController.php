<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ingredients\IngredientCategory;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    
    public function index() {
        $ingredient_categories = IngredientCategory::get();
        $data['item_types'] = $ingredient_categories;

        // dd($data);
        return view('Admin.items')->with('data',$data);
    }

}

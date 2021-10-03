<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ingredients\Ingredient;
use App\Models\Recipe\RecipeHead;
use App\Models\Recipe\RecipeLine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RecipeController extends Controller
{
    
    public function store(Request $request ) {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'recipe_code' => 'unique:recipe_heads,recipe_code',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'result' => false,
                'message' => $validator->errors()->first(),
            ]);
        }

        else {
            try {
                if ($request->has('recipe_image')) {
                    $image = File::get($request->recipe_image);
                    $image_name = time().'.'.$request->recipe_image->extension();
                    Storage::put('/public/recipe_image/'.date("ymd").'/'.$image_name,$image);

                    $recipe_image = '/storage/recipe_image/'.date("ymd").'/'.$image_name;
                }
                else {
                    $recipe_image = null;
                }
                DB::beginTransaction();
                $head = new RecipeHead();
                $head->recipe_name = $request->recipe_name;
                $head->recipe_date = date('Y-m-d');
                $head->recipe_code = null;
                $head->recipe_currency = $request->currency_id;
                $head->recipe_image = $recipe_image;
                $head->recipe_preparation = $request->recipe_preparation;
                $head->recipe_cost = $request->recipe_cost;
                $head->save();

                $line_count = 0;
                if (isset($request->row_count) && $request->row_count > 0) {
                    for ($i = 1; $i <= $request->row_count; $i++) {
                        if (isset($request['ingredient_'.$i]) && $request['ingredient_'.$i] != "") {
                            $line_count++;
                            $line = new RecipeLine();
                            $line->recipe_id = $head->recipe_id;
                            $line->line_no = $line_count;
                            $line->ingredient_id = $request['ingredient_'.$i];
                            $line->unit_id = $request['unit_'.$i];
                            $line->qty = $request['qty_'.$i];
                            $line->unit_cost = $request['unit_cost_'.$i];
                            $line->line_cost = $request['line_cost_'.$i];
                            $line->save();
                        }
                    }
                }
                
                DB::commit();
                return redirect()->route('admin')->with('success', 'Record has been successfully inserted !');
            } catch (\Exception $e) {
                DB::rollback();
                dd($e);
                return redirect()->route('admin')->with('error', 'Record has not been successfully inserted !');
            }
        }
    }

}

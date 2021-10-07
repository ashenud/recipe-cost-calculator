<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ingredients\IngredientCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class IngredientCategoryController extends Controller
{
    
    public function index() {
        $data = array();
        $data['page_title'] = 'Ingredient Categories';

        return view('contents.admin.ingredient.categories')->with('data',$data);
    }

    public function datatable(Request $request ) {
        if ($request->ajax()) {
            $data = IngredientCategory::withTrashed()->select([
                'in_cat_id AS id',
                'in_cat_name AS name',
                'in_cat_code AS code',
                'in_cat_short_name AS short_name',
                'deleted_at AS status',
            ]);

            return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $status = $data->status;
                        $id = $data->id;
                        return view('components.actions.ingredient-btn', compact('id','status'));
                    })
                    ->filter(function ($query) use ($request) {
                        if ($request->has('search') && ! is_null($request->get('search')['value']) ) {
                            $regex = $request->get('search')['value'];
                            return $query->where(function($queryNew) use($regex){
                                $queryNew->where('in_cat_name', 'like', '%' . $regex . '%')
                                    ->orWhere('in_cat_code', 'like', '%' . $regex . '%')
                                    ->orWhere('in_cat_short_name', 'like', '%' . $regex . '%');
                            });
                        }
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
    }

    public function getdata(Request $request ) {
        $data = IngredientCategory::where('in_cat_id',$request->id)->select([
            'in_cat_id AS id',
            'in_cat_name AS name',
            'in_cat_code AS code',
            'in_cat_short_name AS short_name',
            'deleted_at AS status',
        ])->limit(1)->get();

        if(count($data) > 0) {
            return response()->json([
                'result' => true,
                'data' => $data[0]
            ]);
        }
        else {
            return response()->json([
                'result' => false,
                'message' => 'Record not found !',
            ]);
        }
    }

    public function store(Request $request ) {
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:ingredient_categories,in_cat_code',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'result' => false,
                'message' => $validator->errors()->first(),
            ]);
        }
        else {
            try {
                DB::beginTransaction();
                $head = new IngredientCategory();
                $head->in_cat_name = $request->name;
                $head->in_cat_code = $request->code;
                $head->in_cat_short_name = $request->short_name;
                $head->save();
                
                DB::commit();
                return response()->json([
                    'result' => true,
                    'message' => 'Record successfully inserted',
                ]);
            } catch (\Exception $e) {
                DB::rollback();    
                return response()->json([
                    'result' => false,
                    'message' => $e->getMessage(),
                ]);
            }
        }
    }

    public function update(Request $request ) {
        $validator =Validator::make($request->all(), [
            'code' => 'required',
            'code' => Rule::unique('ingredient_categories','in_cat_code')->ignore($request->id,'in_cat_id'),
        ]);
        if ($validator->fails()) {
            return response()->json([
                'result' => false,
                'message' => $validator->errors()->first(),
            ]);
        }
        else {
            try {
                DB::beginTransaction();
                $head = IngredientCategory::find($request->id);
                $head->in_cat_name = $request->name;
                $head->in_cat_code = $request->code;
                $head->in_cat_short_name = $request->short_name;
                $head->save();
                
                DB::commit();
                return response()->json([
                    'result' => true,
                    'message' => 'Record successfully updated',
                ]);
            } catch (\Exception $e) {
                DB::rollback();    
                return response()->json([
                    'result' => false,
                    'message' => $e->getMessage(),
                ]);
            }
        }
    }

    public function status(Request $request ) {
        try {
            DB::beginTransaction();
            $head = IngredientCategory::withTrashed()->find($request->id);
            if($request->next_status == 0) {
                $head->delete();
            }
            else {
                $head->restore();
            }
            
            DB::commit();
            return response()->json([
                'result' => true,
                'message' => 'Status changed successfully',
            ]);
        } catch (\Exception $e) {
            DB::rollback();    
            return response()->json([
                'result' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ingredients\Ingredient;
use App\Models\Ingredients\IngredientCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class IngredientController extends Controller
{
    
    public function index() {
        $data = array();
        $data['page_title'] = 'Ingredients';

        $categories = IngredientCategory::get();
        $data['categories'] = $categories;

        return view('contents.admin.ingredient.ingredients')->with('data',$data);
    }

    public function datatable(Request $request ) {
        if ($request->ajax()) {
            $data = Ingredient::withTrashed()->with('belonged_category')->whereHas('belonged_category', function (Builder $query) {
                $query->whereNull('deleted_at');
            });

            return DataTables::of($data)
                    ->addColumn('action', function($data){
                        $status = $data->deleted_at;
                        $id = $data->in_id;
                        return view('components.actions', compact('id','status'));;
                    })
                    ->filter(function ($query) use ($request) {
                        if ($request->has('search') && ! is_null($request->get('search')['value']) ) {
                            $regex = $request->get('search')['value'];
                            return $query->where(function($queryNew) use($regex){
                                $queryNew->where('ingredients.in_name', 'like', '%' . $regex . '%')
                                    ->orWhere('ingredients.in_code', 'like', '%' . $regex . '%')
                                    ->orWhere('ingredients.in_short_name', 'like', '%' . $regex . '%')
                                    ->orWhereHas('belonged_category', function($q) use($regex){
                                        $q->where('in_cat_name', 'like', '%' . $regex . '%');
                                    });
                            });
                        }
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
    }

    public function getdata(Request $request ) {

        $data = Ingredient::where('in_id',$request->id)->limit(1)->get();
        $data->transform(function($d) {
            $category = $d->belonged_category;
            return [
                "id" => $d->in_id,
                "name" => $d->in_name,
                "code" => $d->in_code,
                "short_name" => $d->in_short_name,
                "category" => $category->in_cat_id,
                "status" => $d->deleted_at,
            ];
        });

        if(count($data) > 0) {
            return response()->json([
                'result' => true,
                'data' => $data[0]
            ]);
        }
        else {
            return response()->json([
                'result' => false,
                'message' => 'Record not dound !',
            ]);
        }
    }

    public function store(Request $request ) {
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:ingredients,in_code',
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
                $head = new Ingredient();
                $head->in_name = $request->name;
                $head->in_code = $request->code;
                $head->in_short_name = $request->short_name;
                $head->in_cat_id = $request->category;
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
            'code' => Rule::unique('ingredients','in_code')->ignore($request->id,'in_id'),
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
                $head = Ingredient::find($request->id);
                $head->in_name = $request->name;
                $head->in_code = $request->code;
                $head->in_short_name = $request->short_name;
                $head->in_cat_id = $request->category;
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
            $head = Ingredient::withTrashed()->find($request->id);
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

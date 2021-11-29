<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recipe\RecipeHead;
use App\Models\Recipe\RecipeLine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade as PDF;

class RecipeController extends Controller
{
    
    public function index() {
        $data = array();
        $data['page_title'] = 'Recipe';

        return view('contents.admin.recipe.view')->with('data',$data);
    }

    public function datatable(Request $request ) {
        if ($request->ajax()) {
            $data = DB::table('recipe_heads AS rh')
                        ->join('system_currencies AS sc', 'sc.cur_id', 'rh.recipe_currency')
                        ->select([
                            'rh.recipe_id',
                            'rh.recipe_name',
                            'rh.recipe_date',
                            'rh.recipe_code',
                            DB::raw('CONCAT(rh.recipe_cost," (",sc.cur_name,")") AS recipe_cost'),
                            'rh.recipe_image',
                            'rh.deleted_at',
                        ])
                        ->whereNull('rh.deleted_at')
                        ->groupBy('rh.recipe_id');

            return DataTables::of($data)
                    ->addColumn('image', function ($data) {
                        $id = $data->recipe_id;
                        $image_name = $data->recipe_name;
                        $img_url = asset($data->recipe_image);
                        $img_path = str_replace('/storage/','',$data->recipe_image);
                        $is_exists = Storage::disk('public')->exists($img_path);
                        return view('components.actions.image-modal', compact('id','image_name','img_url','img_path','is_exists'));
                    })
                    ->addColumn('action', function($data){
                        $status = $data->deleted_at;
                        $id = $data->recipe_id;
                        $route_display = "recipe_display";
                        $route_pdf = "recipe_pdf";
                        $route_edit = "recipe_edit";
                        return view('components.actions.recipe-btn', compact('id','status','route_display','route_pdf','route_edit'));
                    })
                    ->filter(function ($query) use ($request) {
                        if ($request->has('search') && !is_null($request->get('search')['value'])) {
                            $regex = $request->get('search')['value'];
                            return $query->where(function ($queryNew) use ($regex) {
                                $queryNew->where('rh.recipe_name', 'like', '%' . $regex . '%')
                                    ->orWhere('rh.recipe_code', 'like', '%' . $regex . '%')
                                    ->orWhere('rh.recipe_date', 'like', '%' . $regex . '%')
                                    ->orWhere('rh.recipe_cost', 'like', '%' . $regex . '%');
                            });
                        }
                    })
                    ->rawColumns(['image','action'])
                    ->make(true);
        }
    }
    
    public function store(Request $request ) {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'recipe_code' => 'unique:recipe_heads,recipe_code',
        ]);
        if ($validator->fails()) {
            return redirect()->route('admin')->with('error', $validator->errors()->first());
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
                $head->recipe_code = RecipeHead::genCode();
                $head->recipe_category = $request->recipe_category;
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
                // dd($e);
                return redirect()->route('admin')->with('error', 'Record has not been successfully inserted !');
            }
        }
    }

    public function display(Request $request, $id ) {
        $recipe = RecipeHead::find($id);
        $data = array();
        $data['page_title'] = 'DISPLAY '.strtoupper($recipe->recipe_name);
        return view('contents.admin.recipe.display', compact('recipe','data'));
    }

    public function pdf(Request $request) {
        $recipe = RecipeHead::find($request->recipe_id);
        $yield = ($request->yield) ? $request->yield : 1;
        $profit_discount = ($request->profit_discount) ? $request->profit_discount : 0;
        
        // $pdfname = strtoupper($pdfname);
        // $pdfname .= ".pdf";
        // $pdf = PDF::loadView('contents.admin.recipe.pdf', compact('recipe'));
        // $pdf->setPaper('A4', 'portrait');
        // return $pdf->stream($pdfname);

        $pdf = PDF::loadView('contents.admin.recipe.pdf', compact('recipe','yield','profit_discount'));
        $pdf->setPaper('A4', 'portrait');  
        $content = $pdf->download()->getOriginalContent();
        Storage::put('public/exports/recipe/recipe-details-export.pdf',$content);
        return response()->json([
            'file'=> 'storage/exports/recipe/recipe-details-export.pdf',
            'yield'=> $yield,
            'profit_discount'=> $profit_discount,
        ]);

    }

    public function status(Request $request ) {
        try {
            DB::beginTransaction();
            $head = RecipeHead::withTrashed()->find($request->id);
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

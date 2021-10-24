<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Other\SystemCurrency;
use App\Models\Other\SystemUnit;
use App\Models\Recipe\RecipeCategory;
use App\Models\Recipe\RecipeHead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index() {
        
        $data = array();
        $data['page_title'] = 'Dashboard';

        $recipe_code = RecipeHead::genCode();
        $units = SystemUnit::get();
        $currencies = SystemCurrency::get();
        $recipe_categories = RecipeCategory::get();

        // dd($data);
        return view('contents.admin.dashboard',compact('data','units','currencies','recipe_code','recipe_categories'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Other\SystemCurrency;
use App\Models\Other\SystemUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index() {
        
        $data = array();
        $data['page_title'] = 'Dashboard';

        $units = SystemUnit::get();
        $currencies = SystemCurrency::get();

        // dd($data);
        return view('contents.admin.dashboard',compact('data','units','currencies'));
    }
}

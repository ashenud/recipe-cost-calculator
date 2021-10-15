@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('libs/css/calculator-style.css') }}">
@endsection

@section('title', config('rcc.type'))

@section('navbar')
@include('layouts.navbars.admin')
@endsection

@section('content')
<div class="content">
   
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row head-row mb-5">
                    <div class="col-lg-6">
                        <table class="head-table w-100">
                            <thead>
                                <tr>
                                    <th>DATE</th>
                                    <td><input type="text" class="head-input form-control recipe-date" value="{{$recipe->recipe_date}}" readonly></td>
                                </tr>
                                <tr>
                                    <th>RECIPE CODE</th>
                                    <td><input type="text" class="head-input form-control" value="{{$recipe->recipe_code}}" readonly></td>
                                </tr>
                                <tr>
                                    <th>RECIPE NAME</th>
                                    <td><input type="text" class="head-input form-control" value="{{$recipe->recipe_name}}" readonly></td>
                                </tr>
                                <tr>
                                    <th>CURRENCY FOR CALCULATION</th>
                                    <td><input type="text" class="head-input form-control" value="{{$recipe->belonged_currency->cur_description}}" readonly></td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <div class="row recipe-row">
                    <div class="col-lg-8">
                        <table width="100%" class="table recipe-table" align="center">
                            <thead>
                                <tr>
                                    <th width="8%" height="25"></th>
                                    <th width="40%">INGREDIENT NAME</th>
                                    <th width="15%">UNIT</th>
                                    <th width="10%">QTY</th>
                                    <th width="12%">U. COST</th>
                                    <th width="15%">TOATAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recipe->has_lines as $key => $recipe_line)
                                <tr>
                                    <td>
                                        <input type="text" class="head-input form-control text-center" value="{{$key+1}}" readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="head-input form-control" value="{{$recipe_line->belonged_ingredient->in_name}}" readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="head-input form-control" value="{{$recipe_line->belonged_unit->unit_name}}" readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="head-input form-control text-right" value="{{$recipe_line->qty}}" readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="head-input form-control text-right" value="{{$recipe_line->unit_cost}}" readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="head-input form-control text-right" value="{{$recipe_line->line_cost}}" readonly>
                                    </td>
                                </tr>
                                @endforeach                                        
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" style="text-align: right">RECIPE COST &nbsp;</td>
                                    <td>
                                        <b> <input type="number" id="recipe_cost" class="form-control text-right" value="{{$recipe->recipe_cost}}" readonly> </b> 
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="text-align: right">COST PER PRICE (%) &nbsp;</td>
                                    <td colspan="1" style="text-align: right">
                                        <b> <input type="number" id="profit_discount" name="profit_discount" class="form-control text-right" onkeyup="calculateTotalCostWithProfit()"> </b>
                                    </td>
                                    <td>
                                        <b> <input type="number" id="cost_with_profit" class="form-control text-right" value="0.00" readonly> </b> 
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group row">
                            <div class="col-12 col-sm-12 col-lg-12">
                                <div class="card" style="width: 100%">
                                    <div class="card-header">
                                        <h6 class="card-title">RECIPE IMAGE</h6>
                                    </div>
                                    <div class="card-body">
                                        <div id="image_area" class="image-area p-0">
                                            <img id="image_display" class="image-display" 
                                                   src="@if (isset($recipe->recipe_image))
                                                            {{asset($recipe->recipe_image)}}
                                                        @else
                                                            {{asset('img/dish-preview.jpg')}}
                                                        @endif" alt="display selected image" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12 col-sm-12 col-lg-12">
                                <div class="card" style="width: 100%;">
                                    <div class="card-header">
                                        <h6 class="card-title">PREPARATION</h6>
                                    </div>
                                    <div class="card-body">
                                        <textarea style="width: 100%" class="form-control" rows="10">{{$recipe->recipe_preparation}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('footer')
@include('layouts.footer')
@endsection

@section('sidebar')
@include('layouts.sidebars.admin')
@endsection

@section('script')
<script>
    function calculateTotalCostWithProfit() {
        var sum = 0;
        if($(`#profit_discount`).val().length > 0) {
            if(parseFloat($(`#profit_discount`).val()) <= 0) {
                $(`#cost_with_profit`).val(sum.toFixed(2));
            }
            else {                
                var discount = parseFloat($(`#profit_discount`).val());
                var total_cost = parseFloat($(`#recipe_cost`).val());
                sum += parseFloat((total_cost/100)*(100+discount));
                $(`#cost_with_profit`).val(sum.toFixed(2));
            }
        }
        else {
            $(`#cost_with_profit`).val(sum.toFixed(2));
        }
    }    
</script>    
@endsection

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
                <form action="{{ url('admin/recipe/store') }}" method="POST" name="main_form" id="main_form" onsubmit="validateFormData();" enctype="multipart/form-data"> 
                    @csrf
                    <div class="row head-row mb-5">
                        <div class="col-lg-6">
                            <table class="head-table w-100">
                                <thead>
                                    <tr>
                                        <th>DATE</th>
                                        <td><input type="text" id="recipe_date" name="recipe_date" value="{{date('Y-m-d')}}" class="head-input recipe-date form-control"></td>
                                    </tr>
                                    <tr>
                                        <th>RECIPE CODE</th>
                                        <td><input type="text" id="recipe_code" name="recipe_code" class="head-input form-control" value="{{$recipe_code}}" readonly></td>
                                    </tr>
                                    <tr>
                                        <th>RECIPE CATEGORY</th>
                                        <td>
                                            <select id="recipe_category" name="recipe_category" class="form-control js-example-basic-single">
                                                <option value="">SELECT CATEGORY</option>
                                                @if (isset($recipe_categories))
                                                    @foreach ($recipe_categories as $data)
                                                        <option value="{{$data->rc_id}}">{{ $data->rc_name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>RECIPE NAME</th>
                                        <td><input type="text" id="recipe_name" name="recipe_name" class="head-input form-control" autocomplete="off"></td>
                                    </tr>
                                    <tr>
                                        <th>CURRENCY</th>
                                        <td>
                                            <select id="currency" name="currency" class="form-control js-example-basic-single" onchange="handleCurrencyChange()">
                                                <option value="">SELECT CURRENCY</option>
                                                @if (isset($currencies))
                                                    @foreach ($currencies as $data)
                                                        <option value="{{ $data->cur_id.",".$data->cur_name }}" @if ($data->cur_id == config('rcc.cur_lka')) selected @endif>{{ $data->cur_description }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <input type="hidden" id="currency_id" name="currency_id">
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                    <div class="row recipe-row">
                        <div class="col-lg-8">
                            <label id="recipe_table_error" class="recipe-table-error" style="display: none">please select at least one ingredient !</label>
                            <table width="100%" class="table recipe-table" align="center">
                                <thead>
                                    <tr>
                                        <th width="5%" height="25"></th>
                                        <th width="43%">INGREDIENT NAME</th>
                                        <th width="15%">UNIT</th>
                                        <th width="12%" id="currency_th">U. COST</th>
                                        <th width="10%">QTY</th>
                                        <th width="15%">TOATAL</th>
                                    </tr>
                                </thead>
                                <tbody id="tbl_body">
                                    <tr id="tr_1">
                                        <td>
                                            <div class="form-group">
                                                <button type="button" id="plus_icon_1" class="btn btn-plus" onclick="addNewRow(1)">
                                                    <i class="bi bi-plus-square-fill"></i>
                                                </button>
                                                <button type="button" id="minus_icon_1" class="btn btn-minus" style="display: none" onclick="removeCurretRow(1)">
                                                    <i class="bi bi-dash-square-fill"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <select id="ingredient_1" name="ingredient_1" class="form-control js-example-auto-single" onchange="handleIngredientChange(1)">
                                                    <option value="">SELECT INGREDIENT</option>
                                                </select>                              
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <select id="unit_1" name="unit_1" class="form-control js-example-basic-single" onchange="handleUnitChange(1)">
                                                    <option value="">SELECT UNIT</option>
                                                    @if (isset($units))
                                                        @foreach ($units as $data)
                                                            <option value="{{ $data->unit_id }}">{{ $data->unit_name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="number" id="unit_cost_1" name="unit_cost_1" class="form-control text-right" min="0" onkeyup="handleUnitCostChange(1)">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="number" id="qty_1" name="qty_1" class="form-control text-center" min="1" onkeyup="calculateRowTotalCost(1)">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="number" id="line_cost_1" name="line_cost_1" class="form-control text-right" readonly>
                                            </div>
                                        </td>
                                    </tr>                                         
                                </tbody>
                                <input type="hidden" id="row_count" name="row_count" value="1" />
                                <tfoot>
                                    <tr>
                                        <td colspan="5" style="text-align: right">RECIPE COST &nbsp;</td>
                                        <td>
                                            <div class="form-group">
                                                <b> <input id="recipe_cost" name="recipe_cost" class="form-control text-right" value="0.00" readonly> </b>
                                            </div> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="text-align: right">COST PER PRICE (%) &nbsp;</td>
                                        <td colspan="1" style="text-align: right">
                                            <b> <input id="profit_discount" name="profit_discount" class="form-control text-right" min="0" onkeyup="calculateTotalCostWithProfit()"> </b>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <b> <input id="cost_with_profit" name="cost_with_profit" class="form-control text-right" value="0.00" readonly> </b>
                                            </div> 
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
                                            <input type="file" id="recipe_image" name="recipe_image" class="form-control" accept="image/gif, image/jpeg, image/png" onchange="handleImageInput(this)">
                                            <div id="image_area" class="image-area">
                                                <img id="image_display" class="image-display" src="{{asset('img/dish-preview.jpg')}}" alt="display selected image" />
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
                                            <textarea id="recipe_preparation" name="recipe_preparation" style="width: 100%" class="form-control" rows="10"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12 col-sm-12 col-lg-12">
                                    <div class="btn-area">
                                        <button type="button" class="btn btn-secondary" onclick="resetPage()">RESET</button>
                                        <button type="button" id="btn_submit" class="btn btn-primary btn-submit float-right" onclick="submitForm('main_form','btn_submit')">SUBMIT</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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

    var rowCount = 1;

    $(document).ready(function() {
        $('.side-link.li-dash').addClass('active');
        handleCurrencyChange();
        $('.js-example-auto-single').select2({
            ajax: {
                url: "{{ url('admin/ingredient/autocomplete') }}",
                type: "POST",
                dataType: 'json',
                delay: 250,
                cache: false,
                data: function (params) {
                    return {
                        search_term: params.term
                    };
                },
                processResults: function (responce, params) {
                    return {
                        results: responce
                    };
                }
            },
            placeholder: 'SELECT INGREDIENT',
            minimumInputLength: 2
        });
    });

    function handleCurrencyChange() {
        if($(`#currency`).val() != "") {
            var currency = $(`#currency`).val().split(",");
            $(`#currency_id`).val(currency[0]);
            $(`#currency_th`).html(`U. COST<span class="currency-symbol">(${currency[1]})`);
        }
        else {
            $(`#currency_id`).val("");
            $(`#currency_th`).html("U.COST");
        }
    }

    function addNewRow(row) {
        var new_row = row+1;
        $('#tbl_body').append(`<tr id="tr_${new_row}">
                                    <td>
                                        <div class="form-group">
                                            <button type="button" id="plus_icon_${new_row}" class="btn btn-plus" onclick="addNewRow(${new_row})">
                                                <i class="bi bi-plus-square-fill"></i>
                                            </button>
                                            <button type="button" id="minus_icon_${new_row}" class="btn btn-minus" style="display: none" onclick="removeCurretRow(${new_row})">
                                                <i class="bi bi-dash-square-fill"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <select id="ingredient_${new_row}" name="ingredient_${new_row}" class="form-control js-example-auto-single" onchange="handleIngredientChange(${new_row})">
                                                <option value="">SELECT INGREDIENT</option>
                                            </select>                              
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <select id="unit_${new_row}" name="unit_${new_row}" class="form-control js-example-basic-single" onchange="handleUnitChange(${new_row})">
                                                <option value="">SELECT UNIT</option>
                                                @if (isset($units))
                                                    @foreach ($units as $data)
                                                        <option value="{{ $data->unit_id }}">{{ $data->unit_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="number" id="unit_cost_${new_row}" name="unit_cost_${new_row}" class="form-control text-right" min="0" onkeyup="handleUnitCostChange(${new_row})">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="number" id="qty_${new_row}" name="qty_${new_row}" class="form-control text-center" min="1" onkeyup="calculateRowTotalCost(${new_row})">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="number" id="line_cost_${new_row}" name="line_cost_${new_row}" class="form-control text-right" readonly>
                                        </div>
                                    </td>
                                </tr>`);

        document.getElementById('plus_icon_' + row).style.display = 'none';
        document.getElementById('minus_icon_' + row).style.display = 'block';

        
        $(`#ingredient_${new_row}`).select2({
            ajax: {
                url: "{{ url('admin/ingredient/autocomplete') }}",
                type: "POST",
                dataType: 'json',
                delay: 250,
                cache: false,
                data: function (params) {
                    return {
                        search_term: params.term
                    };
                },
                processResults: function (responce, params) {
                    return {
                        results: responce
                    };
                }
            },
            placeholder: 'SELECT INGREDIENT',
            minimumInputLength: 2
        });

        $(`#unit_${new_row}`).select2();

        rowCount = rowCount+1;
        $("#row_count").val(rowCount);
    }

    function removeCurretRow(row) {
        $('#tr_' + row).remove();
        calculateTotalCost();
    }

    function handleIngredientChange(row) {
        $(`#unit_${row}`).val("").trigger("change");
        $(`#unit_cost_${row}`).val("");
        $(`#qty_${row}`).val("");
        $(`#line_cost_${row}`).val("");

        if($(`#ingredient_${row}`).val() != "") {
            var valid = true;
            for (let i = 1; i <= rowCount; i++) {
                if(i != row && $('#ingredient_'+i).length > 0) {
                    if($('#ingredient_'+row).val() == $('#ingredient_'+i).val()) {
                        valid = false;
                        $($('#ingredient_'+i).data('select2').$selection).addClass('is-invalid');
                    }
                    else {
                        $($('#ingredient_'+i).data('select2').$selection).removeClass('is-invalid');
                    }
                }          
            }
            if(valid == false) {                
                $(`#ingredient_${row}`).val("").trigger("change");
                swal("Error!", "You can't select same ingredient twice", "error");
            }
        }
        calculateTotalCost();
    }

    function handleUnitChange(row) {
        $(`#unit_cost_${row}`).val("");
        $(`#qty_${row}`).val("");
        $(`#line_cost_${row}`).val("");
        calculateTotalCost();
    }

    function handleUnitCostChange(row) {
        $(`#qty_${row}`).val("");
        $(`#line_cost_${row}`).val("");
        calculateTotalCost();
    }

    function validateCurrentRow(row) {
        var valid = true;
        if ($(`#ingredient_${row}`).val().length === 0){
            valid =false;
            $($(`#ingredient_${row}`).data('select2').$selection).addClass('is-invalid');
        }
        else {
            $($(`#ingredient_${row}`).data('select2').$selection).removeClass('is-invalid');
        }
        if ($(`#unit_${row}`).val().length === 0){
            valid =false;
            $($(`#unit_${row}`).data('select2').$selection).addClass('is-invalid');
        }
        else {
            $($(`#unit_${row}`).data('select2').$selection).removeClass('is-invalid');
        }
        if ($(`#unit_cost_${row}`).val().length === 0 || $(`#unit_cost_${row}`).val() == 0){
            valid =false;
            $(`#unit_cost_${row}`).addClass('is-invalid');
        }
        else {
            $(`#unit_cost_${row}`).removeClass('is-invalid');
        }
        return valid;
    }

    function calculateRowTotalCost(row) {
        var sum = 0;
        if(validateCurrentRow(row)) {  
            var unit_cost = parseFloat($(`#unit_cost_${row}`).val());
            var qty = parseFloat($(`#qty_${row}`).val());
            sum += parseFloat(unit_cost*qty);
            $(`#line_cost_${row}`).val(sum.toFixed(2));            
            calculateTotalCost();
        }
        else {
            swal("Opps !", "Please check errors", "error");
        }
    }

    function calculateTotalCost() {
        var sum = 0;
        for (var i = 1; i <= rowCount; i++) {
            if ($(`#line_cost_${i}`).length > 0 && parseFloat($(`#line_cost_${i}`).val()) > 0) {
                sum += parseFloat($(`#line_cost_${i}`).val());
            }
        }        
        $(`#recipe_cost`).val(sum.toFixed(2));
        calculateTotalCostWithProfit();
    }

    function calculateTotalCostWithProfit() {
        var sum = 0;
        if($(`#profit_discount`).val().length > 0) {
            if(parseFloat($(`#profit_discount`).val()) <= 0) {
                console.error('error');
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

    function handleImageInput(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#image_display')
                    .attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
        else {
            $('#image_display').attr("src", "{{asset('img/dish-preview.jpg')}}");
        }
    }

    function validateFormData() {
        var valid = true;
        if ( $("#recipe_category").val().length === 0 ){
            valid =false;
            $($('#recipe_category').data('select2').$selection).addClass('is-invalid');
        }
        else {
            $($('#recipe_category').data('select2').$selection).removeClass('is-invalid');
        }
        if ( $("#recipe_name").val().length === 0 ){
            valid =false;
            $('#recipe_name').focus();
            $('#recipe_name').addClass('is-invalid');
        }
        else {
            $('#recipe_name').removeClass('is-invalid');
        }
        if ( $("#currency_id").val().length === 0 ){
            valid =false;
            $('#currency').focus();
            $($('#currency').data('select2').$selection).addClass('is-invalid');
        }
        else {
            $($('#currency').data('select2').$selection).removeClass('is-invalid');
        }
        if ( $("#recipe_preparation").val().length === 0 ){
            valid =false;
            $('#recipe_preparation').addClass('is-invalid');
        }
        else {
            $('#recipe_preparation').removeClass('is-invalid');
        }

        var ingredient_count = 0;
        for (let i = 1; i <= rowCount; i++) {
            if($(`#ingredient_${i}`).length > 0) {
                if($(`#ingredient_${i}`).val().length != 0) {
                    ingredient_count++;
                    if ($(`#unit_${i}`).val().length === 0){
                        valid =false;
                        $(`#unit_${i}`).focus();
                        $($(`#unit_${i}`).data('select2').$selection).addClass('is-invalid');
                    }
                    else {
                        $($(`#unit_${i}`).data('select2').$selection).removeClass('is-invalid');
                    }
                    if ($(`#qty_${i}`).val().length === 0 || $(`#qty_${i}`).val() == 0){
                        valid =false;
                        $(`#qty_${i}`).focus();
                        $(`#qty_${i}`).addClass('is-invalid');
                    }
                    else {
                        $(`#qty_${i}`).removeClass('is-invalid');
                    }
                    if ($(`#unit_cost_${i}`).val().length === 0 || $(`#unit_cost_${i}`).val() == 0){
                        valid =false;
                        $(`#unit_cost_${i}`).focus();
                        $(`#unit_cost_${i}`).addClass('is-invalid');
                    }
                    else {
                        $(`#unit_cost_${i}`).removeClass('is-invalid');
                    }
                }
            }          
        }
        if(ingredient_count == 0) {
            valid =false;
            $('#recipe_table_error').show();
        }
        else {
            $('#recipe_table_error').hide();
        }
        return valid;
    }
    
    function submitForm(form,button) {
        if(validateFormData()) {
            swal({
                title: 'Are you sure?',
                text: `You are going to submit this record !`,
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.value) {
                    document.getElementById(button).style.display = "none";
                    document.forms[form].submit();
                }
            });
        }
        else {
            swal("Opps !", "Please check errors", "error");
        }
    }

    function resetPage() {
        swal({
            title: 'Are you sure?',
            text: `You are going to reset this page !`,
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value) {
                location.reload();
            }
        });
    }
</script>

@endsection

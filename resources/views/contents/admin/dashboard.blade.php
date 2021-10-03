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
                <div class="row head-row mb-4">
                    <div class="col-lg-6">
                        <table class="head-table w-100">
                            <thead>
                                <tr>
                                    <th>DATE</th>
                                    <td><input type="text" id="date" name="date" value="{{date('Y-m-d')}}" class="head-input date form-control"></td>
                                </tr>
                                <tr>
                                    <th>DISH NAME</th>
                                    <td><input type="text" id="dish_name" name="dish_name" class="head-input form-control" autocomplete="off"></td>
                                </tr>
                                <tr>
                                    <th>CURRENCY FOR CALCULATION</th>
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
                        <table width="100%" class="table recipe-table" align="center">
                            <thead>
                                <tr>
                                    <th width="5%" height="25"></th>
                                    <th width="30%">INGREDIENT NAME</th>
                                    <th width="20%">UNIT</th>
                                    <th width="10%">QTY</th>
                                    <th width="15%" id="currency_th">U. COST</th>
                                    <th width="20%">TOATAL</th>
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
                                            <input type="number" id="qty_1" name="qty_1" class="form-control text-center" min="1" onkeyup="handleQtyChange(1)">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="number" id="unit_cost_1" name="unit_cost_1" class="form-control text-right" min="0" onkeyup="calculateRowTotalCost(1)">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="number" id="line_cost_1" id="line_cost_1" class="form-control text-right" readonly>
                                        </div>
                                    </td>
                                </tr>                                         
                            </tbody>
                            <input type="hidden" id="row_count" name="row_count" value="1" />
                            <tfoot>
                                <tr>
                                    <td colspan="5" style="text-align: right">TOTAL COST &nbsp;</td>
                                    <td>
                                        <div class="form-group">
                                            <b> <input id="total_recipe_cost" name="total_recipe_cost" class="form-control text-right" value="0.00" readonly> </b>
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
                                        <h6 class="card-title">DISH IMAGE</h6>
                                    </div>
                                    <div class="card-body">
                                        <input type="file" id="dish_image" name="dish_image" class="form-control" accept="image/gif, image/jpeg, image/png" onchange="handleImageInput(this)">
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
                                        <textarea id="preparation" name="preparation" style="width: 100%" rows="10"></textarea>
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
            $(`#currency_th`).html(`U. COST(${currency[1]})`);
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
                                            <input type="number" id="qty_${new_row}" name="qty_${new_row}" class="form-control text-center" min="1" onkeyup="handleQtyChange(${new_row})">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="number" id="unit_cost_${new_row}" name="unit_cost_${new_row}" class="form-control text-right" min="0" onkeyup="calculateRowTotalCost(${new_row})">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="number" id="line_cost_${new_row}" id="line_cost_${new_row}" class="form-control text-right" readonly>
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

    function handleQtyChange(row) {
        $(`#unit_cost_${row}`).val("");
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
        if ($(`#qty_${row}`).val().length === 0 || $(`#qty_${row}`).val() == 0){
            valid =false;
            $(`#qty_${row}`).addClass('is-invalid');
        }
        else {
            $(`#qty_${row}`).removeClass('is-invalid');
        }
        return valid;
    }

    function calculateRowTotalCost(row) {
        var sum = 0;
        if(validateCurrentRow(row)) { 
            var qty = parseFloat($(`#qty_${row}`).val());
            var unit_cost = parseFloat($(`#unit_cost_${row}`).val());
            sum += parseFloat(qty*unit_cost);
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
            if ($(`#line_cost_${i}`).length > 0 && $(`#line_cost_${i}`).val() > 0) {
                sum += parseFloat($(`#line_cost_${i}`).val());
            }
        }        
        $(`#total_recipe_cost`).val(sum.toFixed(2));
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

</script>

@endsection

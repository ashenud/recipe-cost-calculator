
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex">

        <title>RECIPE DETAILS OF {{strtoupper($recipe->recipe_name)}}</title>
        
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{asset('css/calculator-style.css')}}">
        
        <style>
            @page { margin: 50px 10px 30px 10px;}
            .text-right {
                text-align: right;
            }
            .text-center {
                text-align: center;
            }
            .table th, 
            .table td {
                border: 1px solid #d9d9d9;
                vertical-align: middle;    
                padding: 8px;
                vertical-align: middle;
                font-weight: normal;
            }
            .table th {
                background: #000;
                text-align: center !important;
                padding: 0.45rem !important;
                vertical-align: bottom;
                color: #fff;
            }
            .table td {
                padding: 4px;
            }

            .table-bordered {
                border: 1px solid #e6e6f2;
            }

            .table-bordered td,
            .table-bordered th {
                border: 1px solid #e6e6f2;
            }

            .table-border-none td,
            .table-border-none th
            .table-border-none {
                border: 0px;
            }

            .table-striped tbody tr:nth-of-type(odd) {
                background-color: rgba(230, 230, 242, .5);
            }

            .table-hover tbody tr:hover {
                background-color: rgba(230, 230, 242, .5);
            }
            .image-area {
                margin-top: 12px;
                vertical-align: middle;
            }
            .image-area .image-display {
                max-width: 180px;
                max-height: 124px;
            }
        </style>
    </head>
    <body style="background: white;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-6">
                    <img src="{{asset('img/favicon.png')}}" style="width: 200px; margin-top: -5px; margin-left: -5px;">
                </div>
                <div class="col-xs-5">
                    <address class="text-right">
                        <strong>{{ config('rcc.company_name') }}</strong><br>
                        <span>{{ config('rcc.company_email') }}</span> <br>
                        <span>T: {{ config('rcc.company_telephone') }}</span>
                    </address>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <table style="width: 100%; margin-bottom: 10px">
                        <tbody>
                            <tr class="well" style="padding: 5px">
                                <th style="padding: 5px;text-align: left; text-transform: uppercase;">RECIPE DETAILS OF {{$recipe->recipe_name}}</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            
            <div class="ecommerce-widget">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xs-8">
                                <table class="table" style="font-size:10px">
                                    <tr>
                                        <td><b>DATE</b></td>
                                        <td>{{$recipe->recipe_date}}</td>
                                    </tr>
                                    <tr>
                                        <td><b>RECIPE CODE</b></td>
                                        <td>{{$recipe->recipe_code}}</td>
                                    </tr>
                                    <tr>
                                        <td><b>RECIPE NAME</b></td>
                                        <td>{{$recipe->recipe_name}}</td>
                                    </tr>
                                    <tr>
                                        <td><b>CURRENCY FOR CALCULATION</b></td>
                                        <td>{{$recipe->belonged_currency->cur_description}}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-xs-4">                                
                                <div id="image_area" class="image-area p-0">
                                    @if(isset($recipe->recipe_image))
                                        <img id="image_display" class="image-display" src="{{asset($recipe->recipe_image)}}" alt="display selected image" />
                                    @else
                                        <img id="image_display" class="image-display" src="{{asset('img/dish-preview.jpg')}}" alt="display selected image" />                                                    
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="8%"></th>
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
                                            <td class="text-center">{{$key+1}}</td>
                                            <td>{{$recipe_line->belonged_ingredient->in_name}}</td>
                                            <td>{{$recipe_line->belonged_unit->unit_name}}</td>
                                            <td class="text-right">{{$recipe_line->qty}}</td>
                                            <td class="text-right">{{$recipe_line->unit_cost}}</td>
                                            <td class="text-right">{{$recipe_line->line_cost}}</td>
                                        </tr>
                                        @endforeach                                        
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5" class="text-right">RECIPE COST &nbsp;</td>
                                            <td class="text-right"><b>{{$recipe->recipe_cost}}</b></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="col-lg-4">
                                <table style="width: 100%; margin-bottom: 10px">
                                    <tbody>
                                        <tr class="well" style="padding: 5px">
                                            <th style="padding: 5px;text-align: left">PREPARATION</th>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td class="text-left">
                                                @php
                                                    $abc = nl2br($recipe->recipe_preparation);
                                                    echo  $abc;
                                                @endphp
                                            </td>
                                        </tr>                                    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>      
            </div>
        </div>
    </body>
</html>



































































{{-- <!doctype html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> --}}

    <!-- favicon -->
    {{-- <link rel="apple-touch-icon" sizes="76x76" href="{{asset('img/apple-icon.png')}}">
    <link rel="icon" type="image/png" href="{{asset('img/favicon.png')}}"> --}}

    <!--fonts and icons-->
    {{-- <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/fontawesome-all.css') }}"> --}}
    {{-- <link rel="stylesheet" href="{{asset('css/pdf-dom.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/calculator-style.css')}}">

</head>
<body>
    <div class="wrapper">

        <!-- main body (sidebar and content) -->
        <div class="main-body">

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
                            <div class="col-5">
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
                                    </tfoot>
                                </table>
                            </div>
                            <div class="col-4">
                                <div class="form-group row">
                                    <div class="col-12 col-sm-12 col-lg-12">
                                        <div class="card" style="width: 100%">
                                            <div class="card-header">
                                                <h6 class="card-title">RECIPE IMAGE</h6>
                                            </div>
                                            <div class="card-body">
                                                <div id="image_area" class="image-area p-0">
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
        <!-- end of main body (sidebar and content) -->

    </div>

</body>
</html> --}}

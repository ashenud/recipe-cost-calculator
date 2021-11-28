
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
            .footer {
                width: 100%;
                text-align: center;
                position: fixed;
                bottom: 0px;
            }
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
            .table.table-striped th,
            .table.table-striped td {
                padding: 4px !important;
                font-size: 12px !important;
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
                margin-top: 16px;
                vertical-align: middle;
                margin-left: -15px;
            }
            .image-area .image-display {
                width: 210px;
                height: 155px;
            }
        </style>
    </head>
    <body style="background: white;">
        <div class="footer">
            <hr style="margin-top: -10px; border-color:#000;">            
            <address class="text-left" style="margin-top: -40px;">
                <span>{{ config('rcc.company_email') }}</span> <br>
            </address>         
            <address class="text-right" style="margin-top: -40px;">
                <span>T: {{ config('rcc.company_telephone') }}</span>
            </address>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-3">
                    <img src="{{asset('img/favicon.png')}}" style="width: 200px; margin-top: 0px; margin-left: -15px;">
                </div>
                <div class="col-xs-8" style="margin-top: 15px;"> 
                    <h1 style="margin-top: 0; text-align: left; text-transform: uppercase; font-weight:normal; font-size: 40px;">{{$recipe->recipe_name}}</h1>
                </div>
            </div>
            
            <hr style="border-color:#A9A9A9; margin-top: -15px"/>
            
            <div class="ecommerce-widget">
                <div class="card" style="margin-top: -15px">
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
                                        <td><b>RECIPE CATEGORY</b></td>
                                        <td>{{$recipe->belonged_category->rc_name}}</td>
                                    </tr>
                                    <tr>
                                        <td><b>SERVING</b></td>
                                        <td>{{$yield}}</td>
                                    </tr>
                                    <tr>
                                        <td><b>POTION SIZE</b></td>
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

                <div class="card" style="margin-top: -18px">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="8%"></th>
                                            <th width="40%">INGREDIENT NAME</th>
                                            <th width="15%">UNIT</th>
                                            <th width="12%">U. COST</th>
                                            <th width="10%">QTY</th>
                                            <th width="15%">TOATAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $recipe_cost = 0;
                                        @endphp
                                        @foreach ($recipe->has_lines as $key => $recipe_line)
                                        @php
                                            $qty = $yield * $recipe_line->qty;
                                            $line_cost = $qty * $recipe_line->unit_cost;
                                            $recipe_cost += $line_cost;
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{$key+1}}</td>
                                            <td>{{$recipe_line->belonged_ingredient->in_name}}</td>
                                            <td>{{$recipe_line->belonged_unit->unit_name}}</td>
                                            <td class="text-right">{{number_format($recipe_line->unit_cost,2)}}</td>
                                            <td class="text-right">{{number_format($qty,3)}}</td>
                                            <td class="text-right">{{number_format($line_cost,2)}}</td>
                                        </tr>
                                        @endforeach
                                        @php
                                            $cost_with_profit = ($recipe_cost/100)*(100+$profit_discount);
                                        @endphp                                   
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5" class="text-right">RECIPE COST &nbsp;</td>
                                            <td class="text-right"><b>{{number_format($recipe_cost,2)}}</b></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-right">PROFIT MARGIN &nbsp;</td>
                                            <td colspan="1" class="text-right">
                                                <b>{{$profit_discount." (%)"}}</b>
                                            </td>
                                            <td class="text-right"> <b>{{number_format($cost_with_profit,2)}}</b></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div style="page-break-after: always;"></div>

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

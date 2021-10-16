@extends('layouts.app')

@section('css')
@include('includes.datatables.css')
<style>
    .custom-readonly:hover,
    .custom-readonly:focus,
    .custom-readonly {
        pointer-events: none;
        cursor: not-allowed;
        background: #848484 !important;
        border-color: #848484 !important;
    }
</style>
@endsection

@section('title', config('rcc.type'))

@section('navbar')
@include('layouts.navbars.admin')
@endsection

@section('content')
<div class="content">
   
    <div class="container">

        <div class="data-table-area">
            <table width="100%" class="table data-table table-hover" id="data-table">
                <thead>
                    <tr>
                        <th width="30%" scope="col">Recipe Name</th>
                        <th width="20%" scope="col">Recipe Code</th>
                        <th width="10%" scope="col">Recipe Date</th>
                        <th width="10%" scope="col">Cost</th>
                        <th width="10%" scope="col">Image</th>
                        <th width="20%"scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        
        <div class="modal fade" id="data_modal" aria-labelledby="view_model_Label" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
            <div class="modal-dialog .modal-side .modal-top-right">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="model_Label">RECIPE OPTIONS</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-area">
                            <div class="form-outline mb-4">
                                <label class="form-label" for="yield">Yield</label>
                                <input type="number" min="1" id="yield" name="yield" class="form-control input-handler"/>
                            </div>
                            <div class="form-outline mb-4">
                                <label class="form-label" for="profit_discount">COST PER PRICE (%)</label>
                                <input type="number" min="0" id="profit_discount" name="profit_discount" class="form-control input-handler"/>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="recipe_id" name="recipe_id"/>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CLOCE</button>
                        <button type="button" id="btn_print" class="btn btn-primary btn-submit float-right" onclick="submitData()">
                            <i id="loading_icon" class="fas fa-arrow-circle-down"></i>
                            SUBMIT
                        </button>
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

@include('includes.datatables.js')

<script>

    var dataTable;

    $(document).ready(function() {
        $('.side-link.li-recipe').addClass('active');
        fetchDatatable();
    });

    function fetchDatatable() {    
        dataTable = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('admin/recipe/datatable') }}",
            columns: [
                { data:'recipe_name', name:'recipe_name'},
                { data:'recipe_code', name:'recipe_code', className: 'text-center'},
                { data:'recipe_date', name:'recipe_date', className: 'text-center'},
                { data:'recipe_cost', name:'recipe_cost', className: 'text-right'},
                { data:'image', name:'image', className: 'text-center', orderable: false, searchable: false},
                { data:'action', name:'action', className: 'text-center', orderable: false, searchable: false},
            ]
        });
    }

    function changeStatus(next_status,id) {
        var content = "activate";
        if(next_status == 0) {
            content = "inactivate";
        }
        swal({
            title: 'Are you sure?',
            text: `You are going to ${content} this record !`,
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "{{ url('admin/recipe/status') }}",
                    type: 'POST',
                    data: {
                        id:id,
                        next_status:next_status,
                    },
                    dataType: 'JSON',
                    success: function (data) { 
                        if(data.result == true) {
                            console.log(data);
                            dataTable.ajax.reload();
                            swal("Done!", data.message, "success")
                        }
                        else {
                            swal("Opps!", data.message, "error")
                        }                      
                    }
                });
            }
        })
    }

    function openPdfOption(id) {        
        $('.input-handler').val("");
        $('#recipe_id').val(id);
        $('#data_modal').modal('toggle');
    }

    function validateData() {
        var valid = true;
        if (parseFloat($("#yield").val()) < 0){
            valid =false;
            $("#yield").addClass('is-invalid')
            swal("Opps !", "Please enter valid yield", "error");
        }
        else {
            $("#yield").removeClass('is-invalid')
        }
        if (parseFloat($("#profit_discount").val()) < 0){
            valid =false;
            $("#profit_discount").addClass('is-invalid')
            swal("Opps !", "Please enter valid profit discount", "error");
        }
        else {
            $("#profit_discount").removeClass('is-invalid')
        }
        return valid;
    }

    function submitData() {
        if(validateData()) {
            $.ajax({
                url: "{{ url('admin/recipe/pdf') }}",
                type: 'GET',
                data: {
                    recipe_id:$("#recipe_id").val(),
                    yield:$("#yield").val(),
                    profit_discount:$("#profit_discount").val(),
                },
                dataType: 'JSON',
                beforeSend: function() {
                    $('#btn_print').addClass('custom-readonly');
                    $('#loading_icon').addClass('fa-spin');
                },
                success: function (response) {
                    console.log(response);
                    $('#data_modal').modal('toggle');
                    window.open(BASE_URL+response.file);        
                },
                complete: function(){
                    $('#btn_print').removeClass('custom-readonly');
                    $('#loading_icon').removeClass('fa-spin');
                }
            });
        }
    }

</script>

@endsection

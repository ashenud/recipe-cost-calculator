@extends('layouts.app')

@section('css')
@include('includes.datatables.css')
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
                        <th width="25%" scope="col">Ingredient Name</th>
                        <th width="25%" scope="col">Category Name</th>
                        <th width="15%" scope="col">Ingredient Code</th>
                        <th width="15%" scope="col">Short Name</th>
                        <th width="20%"scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <button type="button" class="btn btn-primary btn-lg btn-floating" onclick="openInsertModal(0)">
            <i class="fas fa-plus"></i>
        </button>

        <!-- Modal -->
        <div class="modal fade" id="data_modal" aria-labelledby="view_model_Label" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
            <div class="modal-dialog .modal-side .modal-top-right">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="model_Label">INSERT NEW</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-area">
                            <div class="form-outline mb-4">
                                <label class="form-label" for="name">Name</label>
                                <input type="text" id="name" name="name" class="form-control input-handler"/>
                            </div>
                            <div class="form-outline mb-4">
                                <label class="form-label" for="category">Category</label>                                
                                <select  id="category" name="category" class="form-control js-example-modal-single select-handler">
                                    <option value="">SELECT CATEGORY</option>
                                    @if (isset($data['categories']))
                                        @foreach ($data['categories'] as $data)
                                            <option value="{{ $data->in_cat_id }}">{{ $data->in_cat_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-outline mb-4">
                                <label class="form-label" for="code">Code</label>
                                <input type="text" id="code" name="code" class="form-control" readonly/>
                                <input type="hidden" id="next_code" value="{{$next_code}}"/>
                            </div>
                            <div class="form-outline mb-3">
                                <label class="form-label" for="short_name">Short Name</label>
                                <input type="text" id="short_name" name="short_name" class="form-control input-handler"/>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="id" name="id"/>
                        <input type="hidden" id="type" name="type" value="0"/>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CLOCE</button>
                        <button type="button" class="btn btn-primary btn-submit float-right" onclick="submitData()">SUBMIT</button>
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
        $('.side-link.li-ingredient').addClass('active');
        $('.js-example-modal-single').select2({
            dropdownParent: $('#data_modal')
        });
        fetchDatatable();
    });

    function fetchDatatable() {    
        dataTable = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('admin/ingredient/datatable') }}",
            columns: [
                { data:'in_name', name:'in_name'},
                { data:'belonged_category.in_cat_name', name:'belonged_category.in_cat_name', orderable: false,},
                { data:'in_code', name:'in_code'},
                { data:'in_short_name', name:'in_short_name'},
                { data:'action', name:'action', className: 'text-center', orderable: false, searchable: false},
            ]
        });
    }

    function openModal(type,id) {
        $('.input-handler').val("");
        $(".select-handler").val("").trigger("change");
        $.ajax({
            url: "{{ url('admin/ingredient/getdata') }}",
            type: 'POST',
            data: {
                id:id
            },
            dataType: 'JSON',
            success: function (response) {
                console.log(response);
                if(response.result == true) {
                    $("#id").val(response.data.id);
                    $("#name").val(response.data.name);
                    $("#category").val(response.data.category).trigger("change");
                    $("#code").val(response.data.code);
                    $("#short_name").val(response.data.short_name);
                    $("#type").val(type);
                    if(type == 1) {
                        $('.input-handler').attr('readonly', true);
                        $('.btn-submit').prop('disabled', true);
                        $('#category').prop('disabled', true);
                        $("#model_Label").html("VIEW DETAILS");
                    }
                    else if(type == 2) {
                        $('.input-handler').attr('readonly', false);
                        $('.btn-submit').prop('disabled', false);
                        $('#category').prop('disabled', false);
                        $("#model_Label").html("EDIT DETAILS");
                    }
                    $('#data_modal').modal('toggle');
                }
                else {
                    swal("Opps !", response.message, "error");
                }              
            }
        });        
    }

    function openInsertModal(type) {
        var next_code = $('#next_code').val();
        $('#code').val(next_code);
        $('.input-handler').val("");
        $(".select-handler").val("").trigger("change");
        $('.input-handler').attr('readonly', false);
        $('.select-handler').prop('disabled', false);
        $('.btn-submit').prop('disabled', false);
        $("#model_Label").html("INSERT NEW");
        $("#type").val(type);
        $('#data_modal').modal('toggle');
    }

    function validateData() {
        var valid = true;
        if ( $("#name").val().length === 0 ){
            valid =false;
            swal("Opps !", "Please enter name", "error");
        }
        if ( $("#category").val().length === 0 ){
            valid =false;
            swal("Opps !", "Please select category", "error");
        }
        if ( $("#code").val().length === 0 ){
            valid =false;
            swal("Opps !", "Please enter code", "error");
        }
        return valid;
    }

    function submitData() {
        if(validateData()) {
            var ajaxUrl = "";
            if($("#type").val() == 0) {
                ajaxUrl = "{{ url('admin/ingredient/store') }}";
            }
            else if($("#type").val() == 2) {
                ajaxUrl = "{{ url('admin/ingredient/update') }}";
            }
            $.ajax({
                url: ajaxUrl,
                type: 'POST',
                data: {
                    id:$("#id").val(),
                    name:$("#name").val(),
                    code:$("#code").val(),
                    short_name:$("#short_name").val(),
                    category:$("#category").val(),
                },
                dataType: 'JSON',
                success: function (response) { 
                    if(response.result == true) {
                        console.log(response);
                        swal("Good Job !", response.message, "success");
                        $('.input-handler').val("");
                        $('#code').val("");
                        $("#next_code").val(response.next_code);
                        $(".select-handler").val("").trigger("change");
                        $('#data_modal').modal('toggle');
                        dataTable.ajax.reload();
                    }
                    else {
                        swal("Opps !", response.message, "error");
                    }                      
                }
            });
        }
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
                    url: "{{ url('admin/ingredient/status') }}",
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

</script>

@endsection

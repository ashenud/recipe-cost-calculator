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

</script>

@endsection

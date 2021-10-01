@if (!$status)
    <a class="btn btn-sheding btn-sm" onclick="openModal(1,{{$id}})" type="button"><i class="bi bi-eye-fill"></i></a>
    <a class="btn btn-sheding btn-sm" onclick="openModal(2,{{$id}})" type="button"><i class="bi bi-pen-fill"></i></a>
    <a class="btn btn-sheding btn-sm" onclick="changeStatus(0,{{$id}})" type="button"><i class="bi bi-trash-fill"></i></a>
@else
    <a class="btn btn-disabled btn-sm" type="button"><i class="bi bi-eye-fill"></i></a>
    <a class="btn btn-disabled btn-sm" type="button"><i class="bi bi-pen-fill"></i></a>
    <a class="btn btn-disabled btn-sm" onclick="changeStatus(1,{{$id}})" type="button" style="cursor: pointer !important;"><i class="bi bi-trash-fill"></i></a>
@endif
@if (!$status)
    <a class="btn btn-action btn-sm" href="{{route($route_display,array('id'=>$id))}}" type="button" target="_blank"><i class="bi bi-eye-fill"></i></a>
    <a class="btn btn-action btn-sm" onclick="openPdfOption({{$id}})" type="button" target="_blank"><i class="bi bi-file-earmark-pdf-fill"></i></a>
    <a class="btn btn-action btn-sm" onclick="changeStatus(0,{{$id}})" type="button"><i class="bi bi-trash-fill"></i></a>
@else
    <a class="btn btn-disabled btn-sm" type="button"><i class="bi bi-eye-fill"></i></a>
    <a class="btn btn-disabled btn-sm" type="button"><i class="bi bi-file-earmark-pdf-fill"></i></a>
    <a class="btn btn-disabled btn-sm" onclick="changeStatus(1,{{$id}})" type="button" style="cursor: pointer !important;"><i class="bi bi-trash-fill"></i></a>
@endif
@if ($is_exists)
    <img src="{{$img_url}}" class="img-rounded btn-image-modal-action" data-bs-toggle="modal" data-bs-target="#image_modal_{{$id}}" />
    <div class="modal fade" id="image_modal_{{$id}}" tabindex="-1" role="dialog" aria-labelledby="outletImageTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="outletImageTitle">{{$image_name}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="text-align: center">
                    <img src="{{$img_url}}" width="400px" class="img-rounded" />
                </div>
            </div>
        </div>
    </div>
@else
    <img src="{{asset('img/dish-preview.jpg')}}" class="img-rounded btn-image-modal-action btn-disabled"/>
@endif
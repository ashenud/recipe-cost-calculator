<div class="alert-section">
    <div class="container">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                {{-- @@ php alert @@ --}}
                @if (Session::has('message'))
                    <div class="alert {{Session::get('alert-class')}} alert-dismissible fade show animated fadeIn" data-auto-dismiss="2000" role="alert">
                        <strong> {{Session::get('message')}} </strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"> &times; </span>
                        </button>
                    </div>
                @endif
                {{-- @@ javascript alert @@ --}}
                <div class="alert alert-dismissible fade show animated fadeIn" id="js-alert" data-auto-dismiss="2000" role="alert" style="display:none ">
                    <strong id="alert-message"></strong>
                    <button type="button" class="close" onclick="removeJsAlert()" aria-label="Close">
                        <span aria-hidden="true"> &times; </span>
                    </button>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</div>
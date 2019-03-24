@if (Session::has('mail'))
    <div class="row">
        <div class="alert important alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <h4 class="text-center" style="margin: 0px">{{ Session::get('mail') }}</h4>
        </div>
    </div>
@endif
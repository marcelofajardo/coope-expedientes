@if ($message = Session::get('success'))
    <div class="row">
        <div class="alert important alert-success" role="alert" style="margin-top: 10px">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <h4 class="text-center" style="margin: 0px">{{ $message }}</h4>
        </div>
    </div>
@elseif( $message = Session::get('warning'))
    <div class="row">
        <div class="alert important alert-warning" role="alert" style="margin-top: 10px">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <h4 class="text-center" style="margin: 0px">{{  $message }}</h4>
        </div>
    </div>
@elseif( $message = Session::get('danger'))
    <div class="row">
        <div class="alert important alert-danger" role="alert" style="margin-top: 10px">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            <h4 class="text-center" style="margin: 0px">{{ $message }}</h4>
        </div>
    </div>
@endif
@if ($message = Session::get('info'))
      <div class="alert alert-info alert-block">
      	<button type="button" class="close" data-dismiss="alert">×</button>
      	<strong>{{ $message }}</strong>
      </div>
@endif


@if ($errors->any())
<div class="alert alert-danger">
	<button type="button" class="close" data-dismiss="alert">×</button>
	Please check the form below for errors
</div>
@endif

@extends('layout.main') @section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			{{ Form::open(['route' => 'report.bestSellerByStore', 'method' => 'post', 'id' => 'report-form']) }}
			<input type="hidden" name="store_id_hidden" value="{{$store_id}}">
            <h4 class="text-center mt-3">{{trans('file.Best Seller')}} {{trans('file.From')}} {{$start_month.' - '.date("F Y")}} &nbsp;&nbsp;
            <select class="selectpicker" id="store_id" name="store_id">
				<option value="0">{{trans('file.All')}} {{trans('file.Store')}}</option>
				@foreach($ezpos_store_list as $store)
				<option value="{{$store->id}}">{{$store->name}}</option>
				@endforeach
			</select>
            </h4>
            {{ Form::close() }}
            <div class="card-body">
              <canvas id="bestSeller" data-product = "{{json_encode($product)}}" data-sold_qty="{{json_encode($sold_qty)}}" ></canvas>
            </div>
        </div>
	</div>
</div>

<script type="text/javascript">

	$("ul#report").siblings('a').attr('aria-expanded','true');
    $("ul#report").addClass("show");
    $("ul#report li").eq(1).addClass("active");

	$('#store_id').val($('input[name="store_id_hidden"]').val());
	$('.selectpicker').selectpicker('refresh');

	$('#store_id').on("change", function(){
		$('#report-form').submit();
	});
</script>
@endsection
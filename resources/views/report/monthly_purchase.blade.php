@extends('layout.main') @section('content')
<section>
	{{ Form::open(['route' => ['report.monthlyPurchaseByStore', $year], 'method' => 'post', 'id' => 'report-form']) }}
	<input type="hidden" name="store_id_hidden" value="{{$store_id}}">
	<h4 class="text-center">{{trans('file.Monthly Purchase')}}s {{trans('file.Report')}} &nbsp;&nbsp;
	<select class="selectpicker" id="store_id" name="store_id">
		<option value="0">{{trans('file.All')}} {{trans('file.Store')}}</option>
		@foreach($ezpos_store_list as $store)
		<option value="{{$store->id}}">{{$store->name}}</option>
		@endforeach
	</select>
	</h4>
	<div class="table-responsive mt-4">
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th><a href="{{url('report/monthly_purchase/'.($year-1))}}"><i class="fa fa-arrow-left"></i> {{trans('file.Previous')}}</a></th>
			    	<th colspan="10" class="text-center">{{$year}}</th>
			    	<th><a href="{{url('report/monthly_purchase/'.($year+1))}}">{{trans('file.Next')}} <i class="fa fa-arrow-right"></i></a></th>
			    </tr>
			</thead>
		    <tbody>
			    <tr>
			      <td><strong>January</strong></td>
			      <td><strong>February</strong></td>
			      <td><strong>March</strong></td>
			      <td><strong>April</strong></td>
			      <td><strong>May</strong></td>
			      <td><strong>June</strong></td>
			      <td><strong>July</strong></td>
			      <td><strong>August</strong></td>
			      <td><strong>September</strong></td>
			      <td><strong>October</strong></td>
			      <td><strong>November</strong></td>
			      <td><strong>December</strong></td>
			    </tr>
			    <tr>
			    	@foreach($total_discount as $key => $discount)
			        <td>
			        	@if($discount > 0)
				      	<strong>{{trans("file.product").' '.trans("file.Discount")}}</strong><br>
				      	<span>{{$discount}}</span><br><br>
				      	@endif
				      	@if($order_discount[$key] > 0)
				      	<strong>{{trans("file.Order").' ' .trans("file.Discount")}}</strong><br>
				      	<span>{{$order_discount[$key]}}</span><br><br>
				      	@endif
				      	@if($total_tax[$key] > 0)
				      	<strong>{{trans("file.product").' ' .trans("file.Tax")}}</strong><br>
				      	<span>{{$total_tax[$key]}}</span><br><br>
				      	@endif
				      	@if($order_tax[$key] > 0)
				      	<strong>{{trans("file.Order").' '.trans("file.Tax")}}</strong><br>
				      	<span>{{$order_tax[$key]}}</span><br><br>
				      	@endif
				      	@if($shipping_cost[$key] > 0)
				      	<strong>{{trans("file.Shipping Cost")}}</strong><br>
				      	<span>{{$shipping_cost[$key]}}</span><br><br>
				      	@endif
				      	@if($grand_total[$key] > 0)
				      	<strong>{{trans("file.grand total")}}</strong><br>
				      	<span>{{$grand_total[$key]}}</span><br>
				      	@endif
			        </td>
			        @endforeach
			    </tr>
		    </tbody>
		</table>
	</div>	
</section>

<script type="text/javascript">

	$("ul#report").siblings('a').attr('aria-expanded','true');
    $("ul#report").addClass("show");
    $("ul#report li").eq(6).addClass("active");

	$('#store_id').val($('input[name="store_id_hidden"]').val());
	$('.selectpicker').selectpicker('refresh');

	$('#store_id').on("change", function(){
		$('#report-form').submit();
	});
</script>
@endsection
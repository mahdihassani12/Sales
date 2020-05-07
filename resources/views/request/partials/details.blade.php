<div class="row">
   <div class="col-md-4"> <h4> Request ID: &nbsp;&nbsp; {{$requested->id}}</h4>  </div>
   <div class="col-md-4"> <h4>Date: &nbsp;&nbsp; <?php echo explode(" ",$requested->created_at)[0]; ?>  </h4></div>
   <div class="col-md-4"> <h4> Time: &nbsp;&nbsp; <?php echo explode(" ",$requested->created_at)[1];  ?> </h4></div>
</div>

<div class="request_details">
<table class="table table-striped rwd-table">
   <tbody>
      <?php $totalQty=0;?>
       <?php $totalPrice=0;?>
      
      @foreach($requestDetail as $details)
	  <div class="details-row row">
	     <div class="col-md-2" style="padding:6px;display:none">
		     <img src="@if($details->external_link !=1) {{asset('public/images/product')}}/ @endif {{$details->itemphoto}}" style="width: 70%;height:100%;object-fit:cover;" >
		 </div>
		 <div class="col-md-2" style="padding:11px 6px;font-weight:600;font-size:17px">
		    <div style="height:40px;">{{$details->product_name}}</div>
		    <div style="display:none"><span class="labels">السعر &nbsp;&nbsp;&nbsp;{{$details->product_price}} </span></div>
		 </div>
		 <div class="col-md-3" style="padding-top: 10px;">
              <h4> {{trans('file.sub_category')}}</h4>
		       @if($details->parentCategory!=null)
				{{$details->cateName}}
				@else 
				{{'N\A'}}
				@endif	
		 </div>
		 <div class="col-md-3" style="padding-top: 10px;">
              <h4> {{trans('file.category')}}</h4>
		       @if($details->parentCategory==null)
				  {{$details->cateName}}
				@else 
				  <?php $category=DB::table('categories')->where('id',$details->parentCategory)->get(); if(count($category)>0): echo $category[0]->name; endif;?> 
				@endif
		 </div>
		 <div class="col-md-3" style="padding:11px 6px;font-weight:600;font-size:19px">
		     <div style="height:40px;"> <span class="labels">الکمیة </span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$details->product_qty}} </div>
		 </div>
	  </div>	   
	    
	 @endforeach	  
   </tbody>
</table>
</div>
<div class="footer-totals row" style="padding:20px 10px; text-align:center;">
  <div class="col-md-6" style="border-left:1px solid lightgray;"><h5 style="height:25px;">{{trans('file.sales_man')}}</h5><h5> {{$requested->customer_name}}</h5></div>
  <div class="col-md-6" style=""><h5 style="height:25px;">{{trans('file.phone')}}</h5><h5> {{$requested->customer_phone}}</h5></div>
  <div class="col-md-4" style="border-left:1px solid lightgray;display:none"><h5 style="height:25px;">{{trans('file.Total')}}</h5><h5><img  style="width:23px" src="{{asset('public/images/icons/chash.png')}}">&nbsp;&nbsp;&nbsp;&nbsp; {{$requested->subtotal}}</h5></div>
  <div class="col-md-4" style="border-left:1px solid lightgray;display:none"><h5 style="height:25px;">{{trans('file.Shipping Cost')}}</h5><h5><img style="width:23px" src="{{asset('public/images/icons/chash.png')}}">&nbsp;&nbsp;&nbsp;&nbsp;{{$requested->shipping_cost}}</h5></div>
  <div class="col-md-4" style="display:none"><h5 style="height:25px;">{{trans('file.grand total')}}</h5><h5><img src="{{asset('public/images/icons/chash.png')}}" style="width:23px">&nbsp;&nbsp;&nbsp;&nbsp;{{$requested->total}}</h5></div>
</div>

<div>
   <h2 style="text-align:center;">المخزن   {{$requested->storeName}}<h2>
</div>
	
<div>
   <h3 style="display:none">ملاحظات الطلب: {{$requested->marketer_note}}</h3>
   <a class="btn btn-success btn-lg" style="padding:0px 20px;" href="{{asset('online_order/print')}}/{{$requested->id}}" target="_blank">Print</a>
</div>	

<style>
.request_details{
	background:#504f4e;
    padding:10px;  	
}

.request_details .details-row{
	background-color:#fff !important;
	margin:0px; 
	margin-top:6px;
    height:94px;
}
.request_details .details-row .labels{
	color:#b3b2b2;
}
</style>

<div class="row">
@if(count($data['variations'])>0)
 @foreach($data['variations'] as $pv)
 <div class="col-md-4 ">
   <div class="variations_area">
    <img src="{{asset('public/images/product_variation')}}/{{$pv->image}}">
	<h3>{{$pv->name}}</h3>
	<h2>{{$pv->price}}</h2>
  </div>
 </div>
@endforeach
@else
<h3 class="col-sm-12" style="text-align:center" >{{trans('file.no_variation')}}</h3>
@endif	
</div>

<style>
.variations_area{
	border: 1px solid #d2cfcf;
    box-shadow: 1px 3px 2px #dededec4;
    text-align: center;
    padding: 17px;	
}
.variations_area img{
	width:100%;
}
.variations_area h3{
	margin-top:15px; 
}
</style>
@extends('fronted-layout.main')

 @section('content')
 <style>
    span.successCheck{
    font-size: 64px;
    background: #aaaaaa;
    padding:17px;
    border-radius: 50%;
    color: #fff;
	margin-top:107px; 
	}
 </style>
 <?php if(isset($_GET['ref'])){$reference_id=$_GET['ref']; $request_id=$_GET['req_id'];}?>
<div style="padding:10px; "> 
 <div class="card">
	<div class="card-header">
	  <h1 style="text-align:center; font-size:27px;color:#aaa">تم ارسال الطلب بنجاج</h1>
	</div>
   <div class="card-body" style="min-height:410px;text-align:center;">
       <div style="padding:120px 10px 10px"><span class="fa fa-check-circle" style="font-size:120px;color: #aaaab1;"></span></div>
         @if($reference_id=="null")
		<a href="{{asset('/')}}" style="    font-size: 18px;font-weight: 700;margin-top: 5px;color:#7b7bdc">تسوق المزید</a>
        @else	
		<a href="{{asset('/')}}{{'?ref_id='.$reference_id}}" style="    font-size: 18px;font-weight: 700;margin-top: 5px;color:#7b7bdc">تسوق المزید</a>
        @endif
		
		<div>
		   <a href="{{asset('orders/print')}}/{{$request_id}}/{{$reference_id}}" style="font-size:18px;font-weight:700;margin-top:15px;border-radius:5px; width:200px; height:50px; line-height:50px; border:1px dashed black" target="_blank"> مشاهدة الفاتورة</a>
		</div>
  </div>
 </div> 
</div> 
 @endsection
 <script>
 localStorage.setItem("userCoupon", 'null');
 localStorage.setItem("userCouponValue", '0');
 localStorage.setItem("CouponNumberCategories", 'null');
 </script>
 
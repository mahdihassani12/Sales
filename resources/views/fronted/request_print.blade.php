@extends('fronted-layout.main')
<?php $qr_code_data=""; $currency_type="";$currency_sign="";?>

 @section('content')
   <div class="print_area" >
  @if(isset($data['order']) and count($data['order'])>0)
		@foreach($data['order'] as $order) 
  <?php $qr_code_data=utf8_encode($order->customer_name).':'.utf8_encode($order->customer_phone).':'.utf8_encode($order->cityName) .':'.utf8_encode($order->order_note) .':'.$order->shipping_cost.'%'.PHP_EOL; ?>

  @if(isset($data['orderItems']) and count($data['orderItems'])>0)
				@foreach($data['orderItems'] as $items)
	   <?php $qr_code_data.=$items->barcode.':'.$items->ch_product_price.':'.$items->product_qty.'?'; $currency_type=$items->currency; ?>
	@endforeach
  @endif		

<?php if($qr_code_data==""){
	   $qr_code_data="null";
   }
   ?>
	   
       <div class="site-logo row">
	       <div class="col-md-12" style="text-align:center">
		      <img src="{{asset('public/logo/site_logo.png')}}" style="width:200px">
		   </div>   
		  
		   
		  
	   </div>	
	   
	   
       <div class="row invoice">
	    
	      <div class="col-md-6 customer_details">
		       <h1> اسم الزبون:  <span> {{$order->customer_name}}<span></h1>
			   <h1> رقم الهاتف: <span> {{$order->customer_phone}}<span></h1>	
		  </div>
		  
		      
		   <div class="col-md-6 bill_number"  style="text-align:left;">
		       <h1> رقم الفاتورة: <span> {{$order->id}}<span></h1>
		       <h1>  التاريخ: <span> <?php echo explode(' ',$order->created_at)[0];?><span></h1>
		       <h1 style="display:none">  العملة: <span> <?php if($currency_type=="ar"){echo "دينار عراقي"; $currency_sign="د.ع";}else{echo "دولار امريكي"; $currency_sign="$";}?><span></h1>
		   </div>
		  
          <div class="col-md-4  customer_details" style="display:none">
		       <h1> العنوان: <span> {{$order->cityName}}<span></h1>
		  </div>
          		  
		  @endforeach
		@endif  
	   </div>
      
	   <table class="table items_table">
	      <thead>
		     <tr>
			   <th>ت</th>
			   <th>images</th>
			   <th>اسم المنتج</th>
			   <th>الاسم العربي </th>
			   <th>Code</th>
			   <th>فئات المنتجات</th>
			   <th>الكمية</th>
			   <th style="display:none">المجموع</th>
			 </tr>
		  </thead>
		  <tbody>
		   <?php $counter=1;$total_qty=0;?>
		    @if(isset($data['orderItems']) and count($data['orderItems'])>0)
				@foreach($data['orderItems'] as $items)
			    <tr>
                   <td>{{$counter}}</td> 
				   <td>
					<img src="@if($items->external_link!=1){{asset('public/images/product')}}/@endif{{$items->image}}" >
				   </td>  
                   <td><b>{{$items->productName}}</b>
                   <td>{{$items->productArName}}</td> 
                   <td>{{$items->barcode}}</td> 
                   <td>{{$items->cate_name}}</td> 
                   <td style="display:none"><b>{{number_format($items->ch_product_price,0,'.',',')}} {{$currency_sign}}</b></td> 
                   <td><b>{{$items->product_qty}}</b>
				      <?php $total_qty+=$items->product_qty;?>
				   </td> 
                   <td style="display:none"><b>{{number_format($items->product_qty*$items->ch_product_price,0,'.',',')}} {{$currency_sign}}</b></td> 
			   </tr>
			   <?php $counter++;?>
			   @endforeach
			@endif
		  </tbody>
	   </table>
	   
	    
	   
	  @if(isset($data['order']) and count($data['order'])>0)
		@foreach($data['order'] as $order)		
	   <div class="row price_detials">
	      <div class="col-md-3 total">الاجمالي:  {{$total_qty}}</div>
	      <div class="col-md-3 shipping" style="display:none">كلفة التوصيل: {{number_format($order->shipping_cost,0,'.',',')}} {{$currency_sign}}</div>
	      <div class="col-md-3 discount" style="display:none"> مجموع الخصم : 0 {{$currency_sign}}</div>
	      <div class="col-md-3 grand_total" style="display:none">المبلغ النهائي: {{number_format($order->total,0,'.',',')}} {{$currency_sign}}</div>
	   </div>
	   @endforeach
	@endif 
	  
	  
	  <div class="col-md-12" style="text-align:center">
		        <div class="qr_code" style="display:none">
	          {!! QrCode::generate($qr_code_data); !!}
	        </div>
		   </div>
		   
  <div class="print_footer_details row" style="display:none">
     <div class="col-md-6 text_info">
	    <ul>
		   <li>العرض صالح لمدة 30 يوم من تاريخ الاصدار</li>
		   <li>الأسعار أعلاه غير شاملة أجور التنصيب الموقعي</li>
		   <li>جميع المنتجات مكفولة لمدة 6 أشهر استرجاع او تبديل</li>
		</ul>
	 </div>
     <div class="col-md-6 location_info">
	    <ul>
		   <li><span><img src="{{asset('public/images/icons/telephone-symbol-button.svg')}}"></span>  + 964 772 228 4111</li>
		   <li><span><img src="{{asset('public/images/icons/Location.svg')}}"> 	</span> Baghdad – Iraq – Sina’a St.</li>
		   <li><span><img src="{{asset('public/images/icons/Mail.svg')}}"> </span>  sales@iraq-soft.com</li>
		</ul>
	 </div>
  </div>
	 
	   
	    <div style="text-align:center; margin-top:40px" >
	     <button class="btn btn-primary btn-lg" onclick="print()" style="position:relative;z-index:4">Print</button>
	   </div>
	   
    </div>
	
<style>
.print_footer_details{
	margin-top:55px;
}
.print_footer_details .location_info{
	text-align:left;
	direction:ltr; 
	
}
.print_footer_details .location_info ul span{
	margin-right: 8px;
}
.print_area .btn.btn-primary.btn-lg{
	width:145px; 
	height:60px;
	border-radius:5px;
}
.print_footer_details .location_info ul{
	list-style-type:none;
	margin:0px; 
	padding:0px;
}
.print_area .items_table img{
	width:120px;
}
.qr_code{
	text-align:center;
}
.qr_code svg{
	width: 200px;
    height: 200px;
	margin-top:30px;
}
.print_area{
	margin:30px 50px;
	background:#fff;
	padding:50px;
	
}
.print_area table td b{
	font-size:18px;
}
.print_area:before{
	content:"";
	background-image:url("<?php echo asset('public/logo/site_logo.png')?>");
    background-repeat: no-repeat;
    background-size: 300px;
    background-position: 500px 200px;
	-khtml-opacity:.10; 
 -moz-opacity:.10; 
 -ms-filter:"alpha(opacity=10)";
  filter:alpha(opacity=10);
  filter: progid:DXImageTransform.Microsoft.Alpha(opacity=0.2);
  opacity:.10; 
  width:100%;
  height:700px;
  position:absolute;
  right:0px;
}
.print_area .site-logo{
	    margin-bottom: 54px;
}
.print_area .site-logo .bill_number{
	padding:4px 0px;
}
.print_area .site-logo .bill_number h1{
	font-size: 16px;
    font-weight: normal;
	color:#707070;
}
.print_area .site-logo .bill_number h1 span{
	font-weight:bold;
	color:#393939;
}
.price_detials{
	color:#000; 
	font-size:16px;
	font-weight:bold;	
}
.price_detials .shipping{
	text-align:center;
}
.price_detials .grand_total{
	text-align:left;
}
.btn.btn-primary.btn-lg{
	margin-top:30px;
}
.print_area .site-logo img{
	width:250px;
	padding-bottom:15px;
}
.print_area .invoice{
	margin-bottom:13px;
}
.print_area .invoice  h1{
	font-size:18px; 
	color:#707070;
	margin-bottom:15px;
	font-weight:normal;
}
.print_area .invoice h1 span{
	font-weight:bold; 
	color:#393939;
	margin-right:12px;
}
.print_area .invoice  .bill_details{
	text-align:left;
}
.items_table{
  border:1px solid #707070;	
}
.items_table thead{
	background:#5f090d;
	color:#fff;
}
.table th{
	border:none
}
.table td{
	border-bottom:1px solid #707070;
	color:#000000;
	font-size:14px;
	font-weight:500;
}
@media(max-width:450px){
	.print_area{
	  padding:10px !important;
	  margin:0px !important;
	}
	.customer_details{
		width:100% !important;
	}
}

@media print{
	.fronted_body .side-navbar,header.header, .btn.btn-primary.btn-lg{
		display:none;
	}
	.fronted_body .page{
		width:100%;
	}
	.items_table thead{
		color:#000;
	}
	.qr_code{
		display:block;
	}
	
	.print_footer_details {
    margin-top: 55px;
    position: absolute;
    bottom: 20px;
    width: 88%;
	right:6%;
	}
	.print_area{
		height:100% !important;
	}
	.fronted_body .page{
		background:#fff;
	}
}
</style>
 @endsection
 
 @section('scripts');

 <script>
     
    $(document).ready(function(){
		
	});
   
 </script>
	@endsection
 

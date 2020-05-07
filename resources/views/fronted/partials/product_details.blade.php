     @foreach($products as $product)
      <div class="modal-body">
         <div class="row">
		    <div class="col-md-6 description">
			   <a href="#">{{$product->cateName}}</a>
			    <h2 class="selected_product_name english_name" style="display:none">{{$product->name}}</h2>
			    <h2 class="selected_product_name arabic_name" style="">{{$product->arabic_name}}</h2>
			   <div style="text-align: justify;">
			   {{strip_tags($product->product_details)}}
			   </div>
			</div>
		    <div class="col-md-6 feature">
			  <div class="row">
			     <div class="col-md-9" style="padding-left:2px;padding-right:30px;">
			      <img style="width:100%;" src="@if($product->external_link==1) {{$product->image}} @else {{asset('public/images/product')}}/{{$product->image}} @endif" class="showBigPic">
			    </div>
				 <?php 
			      // $allQuantity=DB::table('product_store')->where('product_id',$product->id)->sum('qty');
			   $added_number=0;
				foreach(Cart::content() as $cr):
				  if($cr->id==$product->id){
					  $added_number=$cr->qty;
				  }
				endforeach;
			   ?>
			   
			    <div class="col-md-3" style='padding-right:10px;'>
				  <div class="product_variation">
				  <img style=" border:1px solid black" src="@if($product->external_link==1) {{$product->image}} @else {{asset('public/images/product')}}/{{$product->image}} @endif" variation_id="{{$product->id}}" variation_price="{{$product->price}}"  variation_name="{{$product->name}}">
			      <?php $counter=1; ?>
				  @foreach($productImages as $gl)
				     <?php //$allQTY=DB::table('product_store')->where('product_id',$product->id)->sum('qty')?>		  
				     <img src=" @if($gl->external_link!=1) {{asset('public/images/product_variation')}}/@endif{{$gl->imag_gallery}}"  >  
                                    <?php $counter++;?>				 
				  @endforeach
				  </div>	
			     </div>
			  </div>
			</div>
		 </div>
      </div>
      <div class="modal-footer" style="position:relative">
        <span class="price selected_product_price" style="display:none">@if(strpos($product->price,'.')===false) {{number_format($product->price,0,'.',',')}} @else{{rtrim(number_format($product->price,2,'.',','),".0")}} @endif</span>
	<input type="hidden" id="primary_selected_product_price" value="{{$product->price}}" category="{{$product->category_id}}">
	 
        <button style="position:absolute;left:10px;"  class="btn add_to_cartd" product_id="{{$product->id}}" product_qty="{{$product->storeqty-$added_number}}">اطلب الان</button>
		<div class="add_to_cart_alert alert alert-success alert-dismissable" style="display:none;background:transparent; border:none;position:absolute;left:9px;bottom:-10px;">  
		   
		  <strong >تمت اضافة المنتج للسلة بنجاح</strong>
		</div>
        
		   <div class="product_videos" style="display:none">
		     @if($product->product_link!=null) <a href="#product_video" data-toggle="modal" class="product_video" product_video="{{$product->product_link}}">Watch Video <b class="fa fa-eye"></b></a> @endif
		  </div>
		 <div class='social' style='margin-bottom: -50px; display:none'> 
		  <a class="share" href="#" ><span class="fa fa-share-alt"> </span> <span class="share_product">مشارکة المنتج</span></a>
	      <span class="caret"></span></button>
		  <ul class="">
			<li><a href="https://www.facebook.com/sharer.php?u=<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>" target="_blank"><i class="fa fa-facebook"></i> Facebook</a></li>

		<li style='margin-top:10px'><a href="https://twitter.com/share?&url=<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>" target="_blank"><i class="fa fa-twitter"></i> Twitter</a></li>

      <li style='margin-top:10px'><a href="#copyMessage" data-toggle="modal" custome_link="{{asset('fronted/product')}}/{{$product->id}}" class="copy_link_content" ><i class="fa fa-copy"></i> نسخ رابط المنتج </a></li>

		  </ul>
         </div>
     </div>
	@endforeach  
 
  
  
<div class="modal fade" id="copyMessage">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <h3>تم نسخ الرابط بنجاح </h3>
      </div>
    </div>
  </div>
</div>


  <?php $zero_qty=DB::table('general_settings')->where('id','1')->get()[0]->zero_balance; ?>

  <style>
  .modal-footer .product_videos{
	  width: 31%;
      text-align: left;
      margin-bottom: 31px;
  }
   #copyMessage .modal-content{
	    width: 291px;
		margin: 160px auto;
		background: #ffffff;
        box-shadow: 0px 0px 50px rgba(64, 49, 1, 0.12);
		text-align: center;
	}  

    .product_variation img{
	   cursor: pointer;
       width: 100%;
       margin: 2px 0px;
        max-height: 80px;
	   border:1px solid lightgray;
	}
	
	.showBigPic{
		height:253px; 
		object-fit:cover;
	}
     .social{
		position: absolute;
        left: 12px;
        direction: ltr;
		top:20px; 
	 }
	 .social:hover ul{
		 display:block;
	 }
	.fronted_body #productModal .modal-footer{
		 position:relative;
	 }
	 .social ul{
		    list-style-type: none;
			text-align: left;
			background: #3853d8;
			padding: 10px 20px;
			margin-left: 9px;
			display:none
			
	 }
	 .social ul li a{
		 color:#fff;
	 }
	 .fronted_body #productModal .modal-footer span.fa{
		 position:static;
	 }
	 .share_product{
      margin-left: 11px;
	 }
	 .feature .col-md-9 img{
		 border-radius:5px;
	 }
	 @media(max-width:450px){
	 
		 .feature .col-md-9{
			 padding-right:0px !important;
			 text-align:center;
		 }
		 .feature .col-md-9 img{
			 height: 300px;
			width: 95% !important;
			background: #fff;
			margin-top: 25px;
			object-fit: contain;
		 }
	 .product_variation{
         margin: 15px auto 0px; 
	 }	 
	 .feature .col-md-3{
		     padding-right: 15px;
	 }
	 .fronted_body #productModal .modal-footer .price{
		  font-size: 40px;
          margin-right: 0;
		  margin-top:36px;
	 }
	 .fronted_body #productModal .modal-footer .btn{
		  margin-right: 20px;
          position: absolute;
          left: 7px;
           bottom: 24px;
	 }
	 .modal-footer .social{
		    bottom: 7px;
			right: 10px;
			width: 100%;
			height: 31px;
	 }
	 .fronted_body #productModal .modal-footer{
		 height: 135px;
	 }
	 .add_to_cart_alert.alert.alert-success.alert-dismissable{
		 font-size:12px;padding:0px;
	 }
	 .fronted_body #productModal .description div{
		 margin-top:30px;
	 }
       .product_variation img{
         width:80px;
          }
		  
		.modal-footer .product_videos{
			width:80%;
		}  
		.add_to_cart_alert  strong{
			display: block;
            margin-top: 64px;
		}
	 }
	 
  </style>

  <script>
    var APP_URL = {!! json_encode(url('/')) !!}
      	var user_role=<?php echo Auth::user()->role_id;?>;
      var negative_sale='<?php echo DB::table('site_setting')->where('id','1')->first()->allow_negative;?>';

	
	$(document).on("click",'.product_video',function(){
		var link=$(this).attr('product_video');
		$("#product_video iframe").attr('src',link);
	})  
	
   var pr_name=localStorage.getItem("product_name");
	   if(pr_name=="ar"){
		  $('.arabic_name').css('display','block'); 
	   }
	   else{
		 // $('.english_name').css('display','block'); 
	   }

	
    var couponNumber=localStorage.getItem('userCoupon');

      $(document).ready(function(){
	var st=localStorage.getItem("userCouponValue");
	
var productlength=$(".selected_product_price").length;
	  var currency=localStorage.getItem("currency");
	 
	 if(currency=="ar" && (st!=null || st!=0 || st!='null' || st!='')){
	 $( '.product-price' ).each(function(){
            var actual = $("#primary_selected_product_price").val();
              actual=parseFloat(actual); 
		   
	    for (var i=0; i<productlength; i++){
           $(".selected_product_price").text( addCommas(parseFloat(actual*1200)));
            //$(this).next().next().text(seperated_value[i]+'%');
			
		   }	
          }); 
	   }
	 
 
        if(st=='null' || st==0 || st=='' || st==null){
           
        }
		else{
                      
			var categories=localStorage.getItem('CouponNumberCategories');
			 var seperated_cat=categories.split('-');
			 var seperated_value=st.split('-');
			 var lg=seperated_cat.length;
			 
			 var actual = $("#primary_selected_product_price").val();
                 actual=parseFloat(actual); 
				 
			for (var i=0; i<lg; i++){
			  if(parseInt($("#primary_selected_product_price").attr('category')) ==seperated_cat[i]){  
               		     if(currency=="ar"){
				$(".selected_product_price").text( addCommas(parseInt( (actual - actual*seperated_value[i]/100)*1200).toFixed(2)));
                                } 
			  else{
			  $(".selected_product_price").text( addCommas(parseFloat(actual - actual*seperated_value[i]/100).toFixed(2)));
                         }
			  }
			 }		
			}
	  });
	
  
    

    $("#colose_messge_modal").click(function(){
		$("#copyMessage").modal('hide');
	});

     $('.copy_link_content').click(function(){ 
		  var $temp = $("<input>");
		  $("body").append($temp);
		  $temp.val($(this).attr('custome_link')).select();
		  document.execCommand("copy");
		  $temp.remove();

        	 setTimeout(function(){$("#copyMessage").modal('hide')},3000);
	 });
	   
  
	  var zero_qty=<?php echo $zero_qty;?>;
	  
	 $(".product_variation img").click(function (){
		    var srcimg=$(this).attr('src');
		    $('.product_variation img').css('border','1px solid lightgray');
			$(this).css('border','1px solid black');
			
			var vid=$(this).attr('variation_id'); 
			var vname=$(this).attr('variation_name'); 
			var vprice=$(this).attr('variation_price'); 
			var vqty=$(this).attr('variation_qty');
			
			//$(".selected_product_name").text(vname);
			//$(".selected_product_price").text(vprice);
			//$(".add_to_cartd").attr('product_id',vid);
			//$(".add_to_cartd").attr('product_qty',vqty);
			
            $(".showBigPic").attr('src',srcimg); 	   		
	      }); 
	  
    $(".add_to_cartd").click(function(){
	   var pid=$(this).attr('product_id');
	   var currency=localStorage.getItem("currency");
          if(currency==null || currency=="" || currency=="null" || currency==0){
			   currency="en";
		   }

	   	  if($(this).attr('product_qty')<=-negative_sale && user_role !=8 /* && zero_qty==0 */ ){
				
               $('#confirmModal').on('show.bs.modal', function (e) {
				  var button = e.relatedTarget;
				  if($(button).hasClass('no-modal')) {
					e.stopPropagation();
				  }  
				});				
			   $("#product_not_available").modal('show');
			   $(this).val(0);
		   } 
      else{
		var homeProduct=$(".product-request button[product_id="+pid+"]").attr('product_qty');
		homeProduct=homeProduct-1;
		var homeProduct=$(".product-request button[product_id="+pid+"]").attr('product_qty',homeProduct);

		
        $.ajax({
			 url:APP_URL +'/add_to_cart/'+pid+'/'+couponNumber+'/'+currency,
			 type:'get',
			 success:function(response){
                                  $("#confirmModal").modal('show'); 
				  $("#productModal").modal('hide');
				  $("#productModalSingle").modal('hide');
                                 setTimeout(function() {$("#confirmModal").modal('hide');;}, 4000);
			
				$(".total-cart-item").text(response);  
			 },
			 error:function(){
				 
			 }
		 });	
	  }		 
	});
  </script>
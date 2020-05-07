 <?php $__env->startSection('content'); ?>
 
  <div style='padding:20px' class="fronted_body">
     <div id="productModal">
    <div class="modal-content">
      
	  <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="modal-body" style='border-radius:0px'>
         <div class="row">
		    <div class="col-md-6 description">
			   <a href="#"><?php echo e($product->cateName); ?></a>
			     <p style="display:none" class="english_name"><?php echo e($product->name); ?></p>
			     <p style="display:none" class="arabic_name"><?php echo e($product->arabic_name); ?></p>
				 
			   <div style="text-align: justify;">
			   <?php echo e(strip_tags($product->product_details)); ?>

			   </div>
			</div>
		    <div class="col-md-6 feature">
			  <div class="row">
			     <div class="col-md-10" style="padding-left:2px; padding-right:43px;">
			      <img style="width:405px; max-height:400px;object-fit:cover; " src="<?php if($product->external_link==1): ?> <?php echo e($product->image); ?> <?php else: ?> <?php echo e(asset('public/images/product')); ?>/<?php echo e($product->image); ?> <?php endif; ?>" class="showBigPic">
			    </div>
			    <div class="col-md-2" style="padding-right:2px">
				  <div class="product_variation">
				  <img style=" border:1px solid black" src="<?php if($product->external_link==1): ?> <?php echo e($product->image); ?> <?php else: ?> <?php echo e(asset('public/images/product')); ?>/<?php echo e($product->image); ?> <?php endif; ?>">
			      <?php $counter=1; ?>
				  <?php $__currentLoopData = $productImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proImage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <?php if($counter<4): ?> 				  
				     <img src="<?php if($proImage->external_link!=1): ?> <?php echo e(asset('public/images/product_variation')); ?>/<?php endif; ?> <?php echo e($proImage->imag_gallery); ?>" >
   				     <?php else: ?>
					 <?php endif; ?>
                     <?php $counter++;?>				 
				  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				  </div>	
			     </div>
			  </div>
			</div>
		 </div>
      </div>
      <div class="modal-footer">
        <span class="price selected_product_price"><?php if(strpos($product->price,'.')===false): ?> <?php echo e(number_format($product->price,0,'.',',')); ?> <?php else: ?><?php echo e(rtrim(number_format($product->price,2,'.',','),".0")); ?> <?php endif; ?></span>
		<input type="hidden" id="primary_selected_product_price" value="<?php echo e($product->price); ?>" category="<?php echo e($product->category_id); ?>">

		  <?php 
			        $allqty=DB::table('product_store')->where('product_id',$product->id)->get();
					 $allQuantity=0;
					 foreach($allqty as $totalCount){
						 $allQuantity=$allQuantity+$totalCount->qty; 
					 }
			   ?>
        <button  class="btn add_to_cartd" product_id="<?php echo e($product->id); ?>" product_qty="<?php echo e($allQuantity); ?>">اطلب الان</button>
		
		<div class="add_to_cart_alert alert alert-success alert-dismissable" style="display:none; background:transparent; border:none;">  
		  <strong >تم اضافة المنتج الى السلة بنجاح </strong>
		</div>
		
		 <div class='social'>
		  <a class="share" href="#" ><span class="fa fa-share-alt"> </span> <span class="share_product">مشارکة المنتج</span></a>
	      <span class="caret"></span></button>
		  <ul class="link-list">
			<li><a href="https://www.facebook.com/sharer.php?u=<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>" target="_blank"><i class="fa fa-facebook"></i> Facebook</a></li>
			<li><a href="https://twitter.com/share?&url=<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>" target="_blank"><i class="fa fa-twitter"></i> Twitter</a></li>
			<li><a href="#" custome_link="<?php echo e(asset('fronted/product')); ?>/<?php echo e($product->id); ?>"  class="copy_link_content" ><i class="fa fa-copy"></i> نسخ رابط المنتج</a></li>
		  </ul>
         </div>
     </div>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
    </div>
	
  </div>
  
  <!-- start today-->
<div class="fronted_body">    
<div class="fronted-content">   
 <div class="fonted_products"> 
	  <h3 style="margin-bottom:10px;"> كل المنتجات  <span style="float:left; font-size:20px; color:#d0d0d0;"> عدد المنتجات  &nbsp;&nbsp;&nbsp;<?php echo e($productQTY); ?><span></h3>
 
  <div class="row" id="load_more_item_section">
            <?php $getProduct_id=0;?>
	   <?php $__currentLoopData = $moreProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	     <div class="column5" product_id="<?php echo e($product->id); ?>" data-toggle="" data-target="#productModalSingle">
	      <div class="single_product">
		    <div class="product-image">
			   <span class="fa fa-youtube product_link" product_link="<?php echo e($product->product_link); ?>" data-toggle="modal" data-target="#product_video"></span>
			   <img src="<?php if($product->external_link==1): ?> <?php echo e($product->image); ?> <?php else: ?> <?php echo e(asset('public/images/product')); ?>/<?php echo e($product->image); ?> <?php endif; ?>" class="img-responsive">
			     <p class="main_price" style="color:#858585;margin:0px;font-weight:bold;font-size:22px;position:absolute;bottom:-9px;left:10px;z-index:3; display:none"><del><?php if(strpos($product->price,'.')===false): ?> <?php echo e(number_format($product->price,0,'.',',')); ?> <?php else: ?><?php echo e(rtrim(number_format($product->price,2,'.',','),".0")); ?> <?php endif; ?></del></p> 
			     <h3 class="product-price" category="<?php echo e($product->category_id); ?>" real_price="<?php echo e($product->price); ?>"><?php if(strpos($product->price,'.')===false): ?> <?php echo e(number_format($product->price,0,'.',',')); ?> <?php else: ?><?php echo e(rtrim(number_format($product->price,2,'.',','),".0")); ?> <?php endif; ?> $</h3>
				 <h4><?php if(strpos($product->price,'.')===false): ?> <?php echo e(number_format($product->price,0,'.',',')); ?> <?php else: ?><?php echo e(rtrim(number_format($product->price,2,'.',','),".0")); ?> <?php endif; ?></h4> 
				 <p class="discount_amount" style="color:#107b10;margin:0px;font-weight:bold;font-size:19px;position:absolute;bottom:-9px;right:10px;z-index:3;display:none">0</p> 

            </div> 		
            <div class="product-request"> 
			   <?php 
                                $getProduct_id=$product->id; 
					
			        $allqty=DB::table('product_store')->where('product_id',$product->id)->get();
					 $allQuantity=0;
					 foreach($allqty as $totalCount){
						 $allQuantity=$allQuantity+$totalCount->qty; 
					 }
			   ?>
			   <button class="btn add_to_cart" product_id="<?php echo e($product->id); ?>"  product_qty="<?php echo e($allQuantity); ?>">اطلب الان</button> 			
			   <p style="display:none" class="english_name"><?php echo e($product->name); ?></p>
			   <p style="display:none" class="arabic_name"><?php echo e($product->arabic_name); ?></p>
			</div>
		  </div> 
		 </div> 
	   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               <div id="remove_div" class="col-12" style="margin-top:20px; text-align:center;">
		           <button name="btn_more" id="btn_more" data-pro="<?php echo e($getProduct_id); ?>" class="load_more_item_btn">مشاهدة المزيد</button>
	            </div>
	   </div>
 </div>	 
</div>
</div>	 
	 <!-- end -->
  
 <div id="productModalSingle" class="modal fade product-details" role="dialog" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times; <span style="font-size:14px">اغلاق</span></button>
      </div>
      
         <div class="details_content">
          <div class="modal-body">
                   <p style="text-align:center;"><img style="width:45px;"src="<?php echo e(asset('public/images/icons/loader.gif')); ?>"></p>

          </div>
          <div class="modal-footer">
         </div>
        </div> 
    </div>
  </div>
</div>


 <div id="confirmModal" class="modal fade " role="dialog"  >
  <div class="modal-dialog " style="width:458px; padding-top:140px ">
    <div class="modal-content" style="border-radius:0px;">
      <div class="modal-body" style="background:#fff;padding:0px; ">
          <div style='padding:16px 40px;'>
		      <p style="font-weight:700;color:#cdcdcd; font-size:22px;color:#b5b4b4; text-align:center;">تمت اضافة المنتج لسلة التسوق بنجاح </p>
		     <div style="text-align:center">
		        <img src="<?php echo e(asset('public/images/icons/added-to-cart2.gif')); ?>">
		     </div>  
		     <p style="text-align:center; font-size:22px; font-weight:700;margin-top:22px">هل تريد إستكمال شراء المنتج ؟</p>
		  </div>
		  <hr>
		 <div class="row" style="padding: 0px 23px 16px;">		 
		  <div class="col-6"> 
		   <a href="<?php echo e(asset('/cart')); ?>/<?php echo e($reference_id); ?>" class="btn btn-accept btn-block" style="background: rgba(42,187,129,1);background: -moz-linear-gradient(45deg, rgba(42,187,129,1) 0%, rgba(0,155,194,1) 100%);background: -webkit-gradient(left bottom, right top, color-stop(0%, rgba(42,187,129,1)), color-stop(100%, rgba(0,155,194,1)));background: -webkit-linear-gradient(45deg, rgba(42,187,129,1) 0%, rgba(0,155,194,1) 100%);background: -o-linear-gradient(45deg, rgba(42,187,129,1) 0%, rgba(0,155,194,1) 100%);background: -ms-linear-gradient(45deg, rgba(42,187,129,1) 0%, rgba(0,155,194,1) 100%);background: linear-gradient(45deg, rgba(42,187,129,1) 0%, rgba(0,155,194,1) 100%);filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#2abb81', endColorstr='#009bc2', GradientType=1 ); color:#fff; padding:12px; border-radius:40px; ">نعم</a>
          </div>
          <div class="col-6">		 
		    <a href="#" class="btn btn-reject btn-block" style="background:#d03d69; color:#fff; padding:12px; border-radius:40px; "  data-dismiss="modal">لا، تسوق المزيد</a>
          </div> 
		 </div> 
	  </div>
      
    </div>
  </div>
</div>

 <div id="product_video" class="modal fade " role="dialog" >
  <div class="modal-dialog " style="width:600px; padding-top:80px ">
    <div class="modal-content" style="border-radius:0px;">
	  <div class="modal-header" style="padding:0px">
	       <button type="button" class="close" data-dismiss="modal">&times; <span style="font-size:14px">اغلاق</span></button>
	  </div>
      <div class="modal-body" style="background:#fff;padding:0px; ">
          <iframe width="100%" height="315" src="" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	     
	  </div>
    </div>
  </div>
</div>


<div id="product_not_available" class="modal fade " role="dialog" >
  <div class="modal-dialog " style="width:300px; padding-top:80px ">
    <div class="modal-content" style="border-radius:0px;padding:20px;">
      <div class="modal-body" style="background:#fff;padding:0px; ">
	    <button type="button" class="close" data-dismiss="modal" style="float:inherit">&times; <span style="font-size:14px">اغلاق</span></button> 
        <div style="text-align:center;">
		   <h1 style="margin:20px 0px;">لطلب هذا المنتج الرجاء الاتصال على </h1>
		    <h2>07722284333</h2>
        </div>		
	 </div>
    </div>
  </div>
</div>

  
  <?php $zero_qty=DB::table('general_settings')->where('id','1')->get()[0]->zero_balance; ?>

  <style>
 .fronted_body #productModal .description p.arabic_name, .fronted_body #productModal .description p.english_name{
	  font-weight:700;
	  font-size:25px;
  }

   .single_product .product_link {
    position: absolute;
    left: 9px;
    color: white;
    font-size: 24px;
    padding-top: 10px;
    top: 0px;
    background-color: #ff1616;
    width: 30px;
    height: 40px;
    text-align: center;
    border-radius: 0px 0px 5px 5px;
}
    .product_variation img{
		cursor:pointer;
		width:100%;
		margin:2px 0px; 
	}
	.product_variation{
		
	}
	.showBigPic{
	   object-fit:cover;
	}
     .social{
		position: absolute;
        left: 12px;
        direction: ltr;
		bottom:-52px; 
	 }
	 .social:hover ul{
		 visibility:visible;
	 }
	 .social ul{
		    list-style-type: none;
			text-align: left;
			background: #3853d8;
			padding: 10px 20px;
			margin-left: 9px;
			visibility:hidden;
			
	 }
	 .social ul li a{
		 color:#fff;
	 }
	 .fronted_body #productModalSingle .modal-footer span.fa{
		 position:static;
	 }
	 .share_product{
      margin-left: 11px;
	 }
	 
	 @media(max-width:425px){
	 .fronted_body #productModalSingle .modal-footer .price{
		 margin-right:0px;
	 }
	 .fronted_body #productModalSingle .modal-footer .btn{
		 margin-right:50px;
	 }
		 .feature .col-md-10{
			 padding-right:0px !important;
		 }
		 .feature .col-md-10 img{
			 width:100% !important;
		 }
		 .social{
			     bottom: -85px;
		 }
		 .fronted_body #productModalSingle .modal-footer{
			 height:132px;
		 }
          .product_variation img{
            width:30%;
           }
	 }
  </style>

 <?php $__env->stopSection(); ?>
 
 <?php $__env->startSection('scripts'); ?>;
  <script>
  var APP_URL = <?php echo json_encode(url('/')); ?>

  var couponNumber=localStorage.getItem('userCoupon');
  function addCommas(nStr) {
				nStr += '';
				var x = nStr.split('.');
				var x1 = x[0];
				var x2 = x.length > 1 ? '.' + x[1] : '';
				var rgx = /(\d+)(\d{3})/;
				while (rgx.test(x1)) {
					x1 = x1.replace(rgx, '$1' + ',' + '$2');
				}
				return x1 + x2;
			}
   $(document).ready(function(){
       var pr_name=localStorage.getItem("product_name");
	   if(pr_name=="ar"){
		  $('.arabic_name').css('display','block'); 
	   }
	   else{
		  $('.english_name').css('display','block'); 
	   }


	var st=localStorage.getItem("userCouponValue");
	 var productlength=$(".selected_product_price").length;
	  var currency=localStorage.getItem("currency");
	 
	 if(currency=="ar" && (st!=null || st!=0 || st!='null' || st!='')){
		   $( '.product-price' ).each(function(){
            var actual = $("#primary_selected_product_price").val();
           actual=parseFloat(actual); 
		   
		  for (var i=0; i<productlength; i++){
             $(".selected_product_price").text( addCommas(parseFloat(actual*1200)));
		   }	
          }); 
	   }
	   
        if(st=='null' || st==0){
        }
		else{
			var categories=localStorage.getItem('CouponNumberCategories');
			 var seperated_cat=categories.split('-');
			 var seperated_value=st.split('-');
			 var lg=seperated_cat.length;
			 
			 var actual = $("#primary_selected_product_price").val();
                 actual=parseFloat(actual); 
				 
			for (var i=0; i<lg; i++){
			     if(currency=="ar"){
					 $(".selected_product_price").text( addCommas(parseFloat( (actual - actual*seperated_value[i]/100)*1200).toFixed(2)));
				  } 
				  else{
				   $(".selected_product_price").text( addCommas(parseFloat(actual - actual*seperated_value[i]/100).toFixed(2)));
                  }
			  }
			 }		
			
	  });
	

 $(document).ready(function(){
	  var pr_name=localStorage.getItem("product_name");
	   if(pr_name=="ar"){
		  $('.arabic_name').css('display','block'); 
	   }
	   else{
		  $('.english_name').css('display','block'); 
	   }
	 
	  var st=localStorage.getItem("userCouponValue");
	  	 var productlength=$(".product-price").length;
	    var currency=localStorage.getItem("currency");
	 
	 if(currency=="ar" && (st!=null || st!=0 || st!='null' || st!='')){
		   $( '.product-price' ).each(function(){
           var actual = $(this).attr('real_price');
		   //actual=actual.replace(/\,/g,'');
           actual=parseFloat(actual); 
		   
		  for (var i=0; i<productlength; i++){
			 
            $(this).text( addCommas(parseFloat( actual*1200 )) +' د . ع');
            $(this).next().text( addCommas(parseFloat( actual*1200 )));
            //$(this).next().next().text(seperated_value[i]+'%');
			
		   }	
          }); 
	   }
	   
	  
        if(st==null || st==0 || st=='null' || st==''){
           st=0;
           $(".discount_amount").css('display','none');		
           $(".main_price").css('display','none');
		   
		     if(localStorage.getItem("show_coupon_modal")!='0'){
           	  setTimeout(function() {$('#insert_coupon_number_modal').modal('show');}, 4000);  
			 }			 
          }
      else{
     $(".discount_amount").css('display','block');		
     $(".main_price").css('display','block');
	 
	 var categories=localStorage.getItem('CouponNumberCategories');
	 
	 var seperated_cat=categories.split('-');
	 var seperated_value=st.split('-');
	 var lg=seperated_cat.length;
 
	   $( '.product-price' ).each(function(){
        var actual = $(this).attr('real_price');
		   //actual=actual.replace(/\,/g,'');
           actual=parseFloat(actual); 
		   //alert($(this).attr('category'));
		  for (var i=0; i<lg; i++){
			if( parseInt($(this).attr('category')) ==seperated_cat[i]){  
               if(currency=='ar'){
				 $(this).text( addCommas(parseFloat( (actual - actual*seperated_value[i]/100)*1200 )) +' د . ع');
                 $(this).next().text( addCommas(parseFloat( (actual - actual*seperated_value[i]/100)*1200 )));
                 $(this).prev().text(addCommas(actual*1200)).css('text-decoration','line-through');
				 $(this).next().next().text(seperated_value[i]+'%');   
			   }
			   else{
                 $(this).text( addCommas(parseFloat(actual - actual*seperated_value[i]/100)) +' $');
                 $(this).next().text( addCommas(parseFloat(actual - actual*seperated_value[i]/100)));
                 $(this).next().next().text(seperated_value[i]+'%');
			   }	
			}
		}	
    }); 
}

 });
 
 
 
 
 
     $('.copy_link_content').click(function(){ 
		  var $temp = $("<input>");
		  $("body").append($temp);
		  $temp.val($(this).attr('custome_link')).select();
		  document.execCommand("copy");
		  $temp.remove();
	 });
	   
	  var zero_qty=<?php echo $zero_qty;?>;
	  
	 $(".product_variation img").click(function (){
		var srcimg=$(this).attr('src');
		    $('.product_variation img').css('border','none');
			$(this).css('border','1px solid black');
			
         $(".showBigPic").attr('src',srcimg);		
	 }); 
	  
	
    	
	  
    $(".add_to_cartd").click(function(){
	   var pid=$(this).attr('product_id');
	   
	   	  if($(this).attr('product_qty')<=0 && zero_qty==0 ){
				
               $('#confirmModal').on('show.bs.modal', function (e) {
				  var button = e.relatedTarget;
				  if($(button).hasClass('no-modal')) {
					e.stopPropagation();
				  }  
				});				
			   alert('item is not available');
			   $(this).val(0);
		   } 
      else{
        $.ajax({
			 url:APP_URL+'/add_to_cart/'+pid+'/'+couponNumber,
			 type:'get',
			 success:function(response){
				$("#confirmModal").modal('show'); 
                                setTimeout(function() {$("#confirmModal").modal('hide');;}, 4000);			
		   	        $(".total-cart-item").text(response); 
                               //window.location.assign(APP_URL+"/cart");					
			 },
			 error:function(){
				 
			 }
		 });	
	  }		 
	});
	
	 $(".add_to_cart").click(function(){
       setTimeout(function() {$('#confirmModal').modal('hide');}, 7000);
    });	
	
	 $(document).ready(function(){
		$(document).on('click','#btn_more',function(){
			var last_product_id=$(this).attr('data-pro');
                        var start_from=15;
			 var sortby='date';
	                 var sorttype='des';
 
			 $("#btn_more").html('...');
                      $.ajax({
			url:APP_URL+'/fronted/load_more?product_id='+last_product_id+'&sort_by='+sortby+'&sort_type='+sorttype+'&start_from='+start_from,

				 type:'get',
				 
				 
				 success:function(data){
					  if(data=='no_date'){
						 $("#btn_more").text('No any Items');
					 }
					 else if(data !=''){
						 $("#remove_div").remove();
						 $("#load_more_item_section").append(data);
					 }
					 
				 },
				 error:function(){
					 
				 }
			 })			 
		}); 
	 });  
 
 var zero_qty=<?php echo $zero_qty;?>;
    
	 
  $(document).ready(function () {
	var $button = $('.load_more_item_btn');

	$button.on('click', function () {
		var $this = $(this);
		if ($this.hasClass('active') || $this.hasClass('success')) {
			return false;
		}
		$this.addClass('active');
		setTimeout(function () {
			$this.addClass('loader');
		}, 125);
		setTimeout(function () {
			$this.removeClass('loader active');
			$this.text('تم');
			$this.addClass('success animated pulse');
		}, 1600);
		setTimeout(function () {
			$this.text('مشاهدة المزيد');
			$this.removeClass('success animated pulse');
			$this.blur();
		}, 2900);
	});
});

  	$(document).on("click",'.product_link',function(){
		var link=$(this).attr('product_link');
		$("#product_video iframe").attr('src',link);
	})   
	
   $(document).on("click","#product_video .close", function(){
	   $("#product_video iframe").attr('src','');
   });
   
    $(document).on("click",".column5",function(e){
		 if (!$(e.target).hasClass('product_link') && !$(e.target).hasClass('btn')) {
		 var pid= $(this).attr("product_id");
         $.ajax({
			 url:APP_URL+'/fronted/selectProduct/'+pid,
			 type:'get',
			 success:function(response){
				$(".product-details .details_content").html(response);  
			 },
			 error:function(){
				 
			 }
		 });		 
         $('#productModalSingle').modal('toggle');
       }
	});
	
 	$(document).on("click",".add_to_cart",function(){
	   var pid=$(this).attr('product_id');
	   
	   if($(this).attr('product_qty')<=0  /* && zero_qty==0 */){
		$("#product_not_available").modal('show');
	   } 
      else
	  {
         $('#confirmModal').modal('show');	   
         $.ajax({
			 url:APP_URL+'/add_to_cart/'+pid+'/'+couponNumber,
			 type:'get',
			 success:function(response){
				$(".total-cart-item").text(response);  
			 },
			 error:function(){
				 
			 }
		 })
	  }		 
	});
	
  </script>
   
 </div>
 <?php $__env->stopSection(); ?>
<?php echo $__env->make('fronted-layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
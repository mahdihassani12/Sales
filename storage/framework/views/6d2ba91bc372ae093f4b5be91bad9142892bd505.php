<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times; <span style="font-size:14px">اغلاق</span></button>
      </div>
	  <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="modal-body">
         <div class="row">
		    <div class="col-md-6 description">
			   <a href="#"><?php echo e($product->cateName); ?></a>
			   <h2 class="selected_product_name"><?php echo e($product->name); ?></h2>
			   <div style="text-align: justify;">
			   <?php echo e(strip_tags($product->product_details)); ?>

			   </div>
			</div>
		    <div class="col-md-6 feature">
			  <div class="row">
			     <div class="col-md-9" style="padding-left:2px;padding-right:30px;">
			      <img style="width:100%;" src="<?php echo e(asset('public/images/product')); ?>/<?php echo e($product->image); ?>" class="showBigPic">
			    </div>
				 <?php 
			        $allQuantity=DB::table('product_store')->where('product_id',$product->id)->sum('qty');
					
			   ?>
			   
			    <div class="col-md-3" style='padding-right:10px;'>
				  <div class="product_variation">
				  <img style=" border:1px solid black" src="<?php echo e(asset('public/images/product')); ?>/<?php echo e($product->image); ?>" variation_id="<?php echo e($product->id); ?>" variation_price="<?php echo e($product->price); ?>"  variation_name="<?php echo e($product->name); ?>" variation_qty="<?php echo e($allQuantity); ?>">
			      <?php $counter=1; ?>
				  <?php $__currentLoopData = $productVariation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				     <?php $allQTY=DB::table('product_store')->where('product_id',$product->id)->sum('qty')?>
                     <?php if($counter<4): ?> 				  
				     <img src="<?php echo e(asset('public/images/product_variation')); ?>/<?php echo e($variation->image); ?>"  variation_id="<?php echo e($variation->id); ?>" variation_price="<?php echo e($variation->price); ?>"  variation_name="<?php echo e($variation->name); ?>" variation_qty="<?php echo e($allQTY); ?>">
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
        <span class="price selected_product_price"><?php echo e($product->price); ?></span>
	<input type="hidden" id="primary_selected_product_price" value="<?php echo e($product->price); ?>" category="<?php echo e($product->category_id); ?>">
	 
        <button  class="btn add_to_cartd" product_id="<?php echo e($product->id); ?>" product_qty="<?php echo e($allQuantity); ?>">اطلب الان</button>
		
		<div class="add_to_cart_alert alert alert-success alert-dismissable" style="display:none;background:transparent; border:none;">  
		   
		  <strong >تمت اضافة المنتج للسلة بنجاح</strong>
		</div>

		 <div class='social' style='margin-bottom: -50px;'>
		  <a class="share" href="#" ><span class="fa fa-share-alt"> </span> <span class="share_product">مشارکة المنتج</span></a>
	      <span class="caret"></span></button>
		  <ul class="">
			<li><a href="https://www.facebook.com/sharer.php?u=<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>" target="_blank"><i class="fa fa-facebook"></i> Facebook</a></li>

		<li style='margin-top:10px'><a href="https://twitter.com/share?&url=<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>" target="_blank"><i class="fa fa-twitter"></i> Twitter</a></li>

      <li style='margin-top:10px'><a href="#copyMessage" data-toggle="modal" custome_link="<?php echo e(asset('fronted/product')); ?>/<?php echo e($product->id); ?>" class="copy_link_content" ><i class="fa fa-copy"></i> نسخ رابط المنتج </a></li>

		  </ul>
         </div>
     </div>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
    </div>
  </div>
  
  
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
       height: auto;
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
			 width:95% !important;
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
	 }
	 
  </style>

  <script>
    var APP_URL = <?php echo json_encode(url('/')); ?>

    var couponNumber=localStorage.getItem('userCoupon');

      $(document).ready(function(){
	var st=localStorage.getItem("userCouponValue");
	  
        if(st=='null' || st==0){
        }
		else{
			var categories=localStorage.getItem('CouponNumberCategories');
			 var seperated_cat=categories.split('-');
			 var lg=seperated_cat.length;
			 
			 var actual = $("#primary_selected_product_price").val();
                 actual=parseInt(actual,10); 
				 
			for (var i=0; i<lg; i++){
			     if( parseInt($("#primary_selected_product_price").attr('category')) ==seperated_cat[i]){  
                 $(".selected_product_price").text( addCommas(parseInt(actual - actual*st/100)));
                //$(this).next().text( addCommas(parseInt(actual - actual*st/100)));
                //$(this).next().next().text(st+'%');
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
			
			$(".selected_product_name").text(vname);
			$(".selected_product_price").text(vprice);
			$(".add_to_cartd").attr('product_id',vid);
			$(".add_to_cartd").attr('product_qty',vqty);
			
            $(".showBigPic").attr('src',srcimg); 	   		
	      }); 
	  
    $(".add_to_cartd").click(function(){
	   var pid=$(this).attr('product_id');
	   
	   	  if($(this).attr('product_qty')<=0 /* && zero_qty==0 */ ){
				
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
        $.ajax({
			 url:APP_URL +'/add_to_cart/'+pid+'/'+couponNumber,
			 type:'get',
			 success:function(response){
                                 $(".add_to_cart_alert").css('display','block'); 
                                 setTimeout(function() {$('.add_to_cart_alert').css('display','none');}, 4000);				
				$(".total-cart-item").text(response);  
			 },
			 error:function(){
				 
			 }
		 });	
	  }		 
	});
  </script>
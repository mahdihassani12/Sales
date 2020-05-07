 <?php $__env->startSection('content'); ?>
 
  <div style='padding:20px' class="fronted_body">
     <div id="productModal">
    <div class="modal-content">
      
	  <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="modal-body" style='border-radius:0px'>
         <div class="row">
		    <div class="col-md-6 description">
			   <a href="#"><?php echo e($product->cateName); ?></a>
			   <h2><?php echo e($product->name); ?></h2>
			   <div style="text-align: justify;">
			   <?php echo e(strip_tags($product->product_details)); ?>

			   </div>
			</div>
		    <div class="col-md-6 feature">
			  <div class="row">
			     <div class="col-md-10" style="padding-left:2px; padding-right:43px;">
			      <img style="width:405px; height:375px;object-fit:cover; " src="<?php echo e(asset('public/images/product')); ?>/<?php echo e($product->image); ?>" class="showBigPic">
			    </div>
			    <div class="col-md-2" style="padding-right:2px">
				  <div class="product_variation">
				  <img style=" border:1px solid black" src="<?php echo e(asset('public/images/product')); ?>/<?php echo e($product->image); ?>">
			      <?php $counter=1; ?>
				  <?php $__currentLoopData = $productImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proImage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <?php if($counter<4): ?> 				  
				     <img src="<?php echo e(asset('public/images/product_variation')); ?>/<?php echo e($proImage->imag_gallery); ?>" >
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
  
  <?php $zero_qty=DB::table('general_settings')->where('id','1')->get()[0]->zero_balance; ?>

  <style>
   
    .product_variation img{
		cursor:pointer;
		width:60%;
		margin:2px 0px; 
	}
	.product_variation{
		margin-top:40px; 
	}
	.showBigPic{
		height:253px; 
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
	 .fronted_body #productModal .modal-footer span.fa{
		 position:static;
	 }
	 .share_product{
      margin-left: 11px;
	 }
	 
	 @media(max-width:425px){
	 .fronted_body #productModal .modal-footer .price{
		 margin-right:0px;
	 }
	 .fronted_body #productModal .modal-footer .btn{
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
		 .fronted_body #productModal .modal-footer{
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
				$(".add_to_cart_alert").css('display','block');
                setTimeout(function() {$('.add_to_cart_alert').css('display','none');}, 4000);				
				//$(".total-cart-item").text(response); 
                window.location.assign(APP_URL+"/cart");				
			 },
			 error:function(){
				 
			 }
		 });	
	  }		 
	});
  </script>
   
 </div>
 <?php $__env->stopSection(); ?>
<?php echo $__env->make('fronted-layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
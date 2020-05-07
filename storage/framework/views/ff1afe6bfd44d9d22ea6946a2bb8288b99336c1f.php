 <?php $__env->startSection('content'); ?>
 <style>
    .category_active{
		background:#504f4e !important; 
	}
 </style>
 <?php $discount="<script> document.write( parseInt(localStorage.getItem('userCouponValue')));</script>";?>
   <div class="fronted-content">
       <?php $mobileLogo=DB::table('site_setting')->where('id','1')->get()[0];?>
   
	
    <h2 style="text-align:center; margin-bottom:20px;">اختر فئة</h2>
	<ul class="category-list" style='text-align:center;'>
	  <li category_id="all" class="category_item category_active">كل المنتجات</li>
      <?php $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categories): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	    <li category_id="<?php echo e($categories->id); ?>" class="category_item"><?php echo e($categories->name); ?></li>
	  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul> 
	
	
		  
	<div class="form-group mobile-cartegory-list">
	 <select class="form-control mobile-cartegory">
             <option value="all">كل المنتجات</option>
	    <?php $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categories): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	    <option value="<?php echo e($categories->id); ?>" ><?php echo e($categories->name); ?></option>
	   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
	 </select>
	</div>
	<div class="fonted_products">
	  <h3 style="margin-bottom:10px;"> كل المنتجات  <span style="float:left; font-size:20px; color:#d0d0d0;"> عدد المنتجات  &nbsp;&nbsp;&nbsp;<?php echo e($productQTY); ?><span></h3>
	 <div class="category-result">
	  
	  <div class="row" id="load_more_item_section">
            <?php $getProduct_id=0;?>
	   <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	     <div class="column5" product_id="<?php echo e($product->id); ?>" data-toggle="" data-target="#productModal">
	      <div class="single_product">
		    <div class="product-image">
			   <span class="fa fa-youtube product_link" product_link="<?php echo e($product->product_link); ?>" data-toggle="modal" data-target="#product_video"></span>
			   <img src="<?php echo e(asset('public/images/product')); ?>/<?php echo e($product->image); ?>" class="img-responsive">
			     <p class="main_price" style="color:#858585;margin:0px;font-weight:bold;font-size:22px;position:absolute;bottom:-9px;left:10px;z-index:3;"><del><?php echo e(number_format($product->price)); ?></del></p> 
			     <h3 class="product-price" category="<?php echo e($product->category_id); ?>" real_price="<?php echo e($product->price); ?>"><?php echo e(number_format($product->price)); ?></h3>
				 <h4><?php echo e(number_format($product->price)); ?></h4> 
				 <p class="discount_amount" style="color:#107b10;margin:0px;font-weight:bold;font-size:19px;position:absolute;bottom:-9px;right:10px;z-index:3;">0</p> 

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
			   <p><?php echo e($product->name); ?></p>
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
   
 <div id="productModal" class="modal fade product-details" role="dialog" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times; <span style="font-size:14px">اغلاق</span></button>
      </div>
      <div class="modal-body">
                   <p style="text-align:center;"><img style="width:45px;"src="<?php echo e(asset('public/images/icons/loader.gif')); ?>"></p>

      </div>
      <div class="modal-footer">
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
		   <h1 style="margin-bottom:20px;">Product Not Available</h1>
		    <button class="btn btn-primary" data-dismiss="modal">OK</button>
        </div>		
	 </div>
    </div>
  </div>
</div>

  <div class="css_preloader" style='display:none'>
    <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
</div>

<?php $zero_qty=DB::table('general_settings')->where('id','1')->get()[0]->zero_balance; ?>
 <?php $__env->stopSection(); ?>
 
 <style>
  @media(max-width:450px){ 
     #product_video .modal-dialog ,#confirmModal .modal-dialog {
       width:95% !important;
        padding-top:30px !important;
     }
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
 </style>
 
 <?php $__env->startSection('scripts'); ?>;
 <script>
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
        if(st==null || st==0){
           st=0;
           $(".discount_amount").css('display','none');		
           $(".main_price").css('display','none');		
          }
	 var categories=localStorage.getItem('CouponNumberCategories');
	 var seperated_cat=categories.split('-');
	 var lg=seperated_cat.length;
 
	   $( '.product-price' ).each(function(){
        var actual = $(this).attr('real_price');
		   //actual=actual.replace(/\,/g,'');
           actual=parseInt(actual,10); 
		   //alert($(this).attr('category'));
		  for (var i=0; i<lg; i++){
			if( parseInt($(this).attr('category')) ==seperated_cat[i]){  
            $(this).text( addCommas(parseInt(actual - actual*st/100)));
            $(this).next().text( addCommas(parseInt(actual - actual*st/100)));
            $(this).next().next().text(st+'%');
			}
		}	
    }); 
 });
 
    $(".add_to_cart").click(function(){
       setTimeout(function() {$('#confirmModal').modal('hide');}, 7000);
    });	
	
   var APP_URL = <?php echo json_encode(url('/')); ?>


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
	

	 $(document).ready(function(){
		$(document).on('click','#btn_more',function(){
			var last_product_id=$(this).attr('data-pro');
			 $("#btn_more").html('...');
             $.ajax({
				 url:APP_URL+'/fronted/load_more/'+last_product_id,
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
 
 	
	 $(document).ready(function(){
		$(document).on('click','#btn_more_cate',function(){
			var last_product_id=$(this).attr('data-pro');
			var selectedCate=$(this).attr('data-cate');
			 $("#btn_more_cate").html('...');
             $.ajax({
				 url:APP_URL+'/fronted/load_more_cat_item/'+last_product_id+'/'+selectedCate,
				 type:'get',
				 
				 
				 success:function(data){
					  if(data=='no_date'){
						 $("#btn_more_cate").text('No any Items');
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
				$(".product-details").html(response);  
			 },
			 error:function(){
				 
			 }
		 });		 
         $('#productModal').modal('toggle');
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
	
	
	$(".category_item").click(function(){
                $('.css_preloader').css('display','block');
                $('.fonted_products').css('display','none');
				
		var cid=$(this).attr('category_id');
		$(".category_item").removeClass('category_active'); 
	    $(this).addClass('category_active'); 
		$.ajax({
			 url:APP_URL+'/fronted/selectCategory/'+cid,
			 type:'get',
			 success:function(response){
                $('.fonted_products').css('display','block');
				$(".fonted_products").html(response);  
                 $('.css_preloader').css('display','none');
			 },
			 error:function(){
				 
			 }
		 })		 
	});
	
	
	$(".mobile-cartegory").change(function(){
		var cid=$(this).val();
		$.ajax({
			 url:APP_URL+'/fronted/selectCategory/'+cid,
			 type:'get',
			 success:function(response){
				$(".fonted_products").html(response);  
			 },
			 error:function(){
				 
			 }
		 })		 
	});
	
	window.unload = function(){
    // alert('some');
  }
 </script>
 <?php $__env->stopSection(); ?>
 

<?php echo $__env->make('fronted-layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
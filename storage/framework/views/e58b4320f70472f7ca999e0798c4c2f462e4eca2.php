<?php $getProduct_id=0;?>
	   <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	     <div class="column5" product_id="<?php echo e($product->id); ?>" data-toggle="" data-target="#productModal">
	      <div class="single_product">
		    <div class="product-image">
			 	<span class="fa fa-youtube product_link" product_link="<?php echo e($product->product_link); ?>" data-toggle="modal" data-target="#product_video" style="position: absolute;left:9px;color:red;font-size: 24px;top:4px;width:23px;height:23px;"></span>

			   <img src="<?php echo e(asset('public/images/product')); ?>/<?php echo e($product->image); ?>" class="img-responsive">
			      <p style="color:#858585;margin:0px;font-weight:bold;font-size:22px;position:absolute;bottom:-9px;left:10px;z-index:3;"><del><?php echo e(number_format($product->price)); ?></del></p> 
  				 <h3 class="product-price"><?php echo e(number_format($product->price)); ?></h3>
                 <h4><?php echo e($product->price); ?></h4>
				 <p style="color:#107b10;margin:0px;font-weight:bold;font-size:19px;position:absolute;bottom:-9px;right:10px;z-index:3;">0</p> 

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
			   <button class="btn add_to_cart" product_id="<?php echo e($product->id); ?>" data-toggle="modal" data-target="#confirmModal" product_qty="<?php echo e($allQuantity); ?>">اطلب الان</button> 			
			   <p><?php echo e($product->name); ?></p>
			</div>
		  </div> 
		 </div> 
	   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	      <div id="remove_div" class="col-12" style="margin-top:20px; text-align:center;">
		    <button name="btn_more_cate" id="btn_more_cate" data-cate="<?php echo e($cid); ?>" data-pro="<?php echo e($getProduct_id); ?>" class="load_more_item_btn"> مشاهدة المزيد</button>
		  </div>
		  


<script>
     var APP_URL = <?php echo json_encode(url('/')); ?>


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
	  var st=localStorage.getItem("userCouponValue");
        if(st==null){
        st=0;	 
      }
	 var categories=localStorage.getItem('CouponNumberCategories');
	 var seperated_cat=categories.split('-');
	 var lg=seperated_cat.length;
 
	   $( '.product-price' ).each(function(){
        var actual = $(this).text();
		   actual=actual.replace(/\,/g,'');
           actual=parseInt(actual,10); 
		  for (var i=0; i<lg; i++){
			if( parseInt($(this).attr('category')) ==parseInt(seperated_cat[i])){  
              $(this).text( addCommas(parseInt(actual - actual*st/100)));
              $(this).next().text( addCommas(parseInt(actual - actual*st/100)));
	      $(this).next().next().text(st+'%');

			}
		}	
    }); 
 });
</script>		  
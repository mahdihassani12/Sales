
		  <?php if($products): ?>
		    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		       <li class="single_item_list"><?php echo e($product->name); ?><a class="btn add_to_cart" product_id="<?php echo e($product->id); ?>">اطلب الان</a></li>
		    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         <?php else: ?>
		 <li>Not Found</li>
		 <?php endif; ?>	
		 
<script>
  
	var APP_URL = <?php echo json_encode(url('/')); ?>

	   

    $(".add_to_cart").click(function(){
	   var pid=$(this).attr('product_id');
        $.ajax({
			 url:'add_to_cart/'+pid,
			 type:'get',
			 success:function(response){
				 $(".total-cart-item").text(response);  
				  $(".cart-page").load(APP_URL+'/cart_items'); 
			 },
			 error:function(){
				 
			 }
		 })		 	   
	});

	 $(document).click(function (e){
		 if(e.target.class != 'single_item_list') {
			 $(".search-result").css('display','none');
		 } 
	   });
	   
	   
</script>		 
<h3 style="margin-bottom:10px;">احذیة <span style="float:left; font-size:20px; color:#d0d0d0;"> عدد المنتجات  &nbsp;&nbsp;&nbsp;<?php echo e($productQTY); ?><span></h3>
	 <div class="category-result">
	  <div class="row">
	   <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	     <div class="column5" product_id="<?php echo e($product->id); ?>" data-toggle="" data-target="#productModal">
	      <div class="single_product">
		    <div class="product-image">
			   <img src="<?php echo e(asset('public/images/product')); ?>/<?php echo e($product->image); ?>" class="img-responsive">
			     <h3 class="product-price"><?php echo e($product->price); ?></h3>
               <h4><?php echo e($product->price); ?></h4>
            </div> 		
            <div class="product-request">
			   <button class="btn add_to_cart" product_id="<?php echo e($product->id); ?>">اطلب الان</button> 			
			   <p><?php echo e($product->name); ?></p>
			</div>
		  </div> 
		 </div> 
	   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	   </div>
	  </div>
<script>
 $(".column5").click(function(e){
		 if (!$(e.target).hasClass('btn')) {
		 var pid= $(this).attr("product_id");
         $.ajax({
			 url:'fronted/selectProduct/'+pid,
			 type:'get',
			 success:function(response){
				$(".product-details").html(response);  
			 },
			 error:function(){
				 
			 }
		 })		 
         $('#productModal').modal('toggle');
		 
       }
	});
	
	$(".add_to_cart").click(function(){
	   var pid=$(this).attr('product_id');
        $.ajax({
			 url:'add_to_cart/'+pid,
			 type:'get',
			 success:function(response){
				$(".total-cart-item").text(response);  
			 },
			 error:function(){
				 
			 }
		 })		 	   
	});
</script>	   
<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times; <span style="font-size:14px">اغلاق</span></button>
      </div>
	  <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="modal-body">
         <div class="row">
		    <div class="col-md-6 description">
			   <a href="#">احذیة</a>
			   <h2><?php echo e($product->name); ?></h2>
			   <div>
			   <?php echo e(strip_tags($product->product_details)); ?>

			   </div>
			</div>
		    <div class="col-md-6 feature">
			  <div class="row">
			     <div class="col-md-9">
			      <img style="width:100%;" src="<?php echo e(asset('public/images/product')); ?>/<?php echo e($product->image); ?>">
			    </div>
			    <div class="col-md-3">
			      
			     </div>
			  </div>
			</div>
		 </div>
      </div>
      <div class="modal-footer">
        <span class="price"><?php echo e($product->price); ?></span>
        <button  class="btn add_to_cart" product_id="<?php echo e($product->id); ?>">اطلب الان</button>
		<a class="share" href="#"><span class="fa fa-share-alt"></span></a>
	  </div>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
    </div>
  </div>
  
  <script>
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
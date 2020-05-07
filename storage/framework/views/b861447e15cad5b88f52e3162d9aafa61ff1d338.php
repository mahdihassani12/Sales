 <?php $__env->startSection('content'); ?>
   <div class="fronted-content">
   <div class="mobile-size sidenav-header-inner text-center brand">
            <a href="<?php echo e(asset('/')); ?>"><span class="brand-big text-center">HB</span></a>
    </div>
	
    <h2 style="text-align:center; margin-bottom:20px;">اختر فئة</h2>
	<ul class="category-list">
	  <li category_id="all" class="category_item"><?php echo e(trans('file.view_all')); ?></li>
      <?php $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categories): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	    <li category_id="<?php echo e($categories->id); ?>" class="category_item"><?php echo e($categories->name); ?></li>
	  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul> 
	
	
		  
	<div class="form-group mobile-cartegory-list">
	 <select class="form-control mobile-cartegory">
	    <?php $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categories): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	    <option value="<?php echo e($categories->id); ?>" ><?php echo e($categories->name); ?></option>
	   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
	 </select>
	</div>
	<div class="fonted_products">
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
	</div>
   </div>
   
 <div id="productModal" class="modal fade product-details" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times; <span style="font-size:14px">اغلاق</span></button>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
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
		 });		 
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
	
	
	$(".category_item").click(function(){
		var cid=$(this).attr('category_id');
		$.ajax({
			 url:'fronted/selectCategory/'+cid,
			 type:'get',
			 success:function(response){
				$(".fonted_products").html(response);  
			 },
			 error:function(){
				 
			 }
		 })		 
	});
	
	$(".mobile-cartegory").change(function(){
		var cid=$(this).val();
		$.ajax({
			 url:'fronted/selectCategory/'+cid,
			 type:'get',
			 success:function(response){
				$(".fonted_products").html(response);  
			 },
			 error:function(){
				 
			 }
		 })		 
	});
 </script>
 <?php $__env->stopSection(); ?>
 

<?php echo $__env->make('fronted-layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
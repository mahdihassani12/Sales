
<?php $__currentLoopData = $getPro; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proImag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
   <div class="product-gallery-image" id='remove_product<?php echo e($proImag->id); ?>'>
      <span class='fa fa-close close_btn' gimage_id="<?php echo e($proImag->id); ?>" image_src="<?php echo e($proImag->imag_gallery); ?>">
	  </span>
	 <?php if($proImag->external_link==0): ?> 
	  <img src="<?php echo e(asset('public/images/product_variation')); ?>/<?php echo e($proImag->imag_gallery); ?>">
     <?php else: ?>
	   <img src="<?php echo e($proImag->imag_gallery); ?>">
     <?php endif; ?>
   </div>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<span class='devider'></span>

<style>
  #gallery_images .close_btn{
	color: red;
	cursor:pointer; 
    position: absolute;
    right: 14px;
    top: 12px;
    padding: 1px 2px;
    background: #ffffffd4;
    border-radius: 6px; 
}

#gallery_images #attachment_tbl .product-gallery-image{
	display:inline-block;
	position:relative;
}
</style>
<script>
var APP_URL = <?php echo json_encode(url('/')); ?>


    $(document).ready(function(){       
	  $(".close_btn").click(function(){
		var gid=$(this).attr('gimage_id');
		var gsrc=$(this).attr('image_src');
		
         $.ajax({
			 url:APP_URL+'/products/delete_image/'+gid,
			 type:'get',
			 success:function(){
				$("#remove_product"+gid).remove(); 
			 },
			 error:function(){
				 
			 }
		 })		
	   });
});	
</script>
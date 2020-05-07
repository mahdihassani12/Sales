<style>
tr{
	cursor:pointer;
}
td{
	padding: 7px !important;
    color: #ddd;
    border: none !important;
}
</style>
<table class="table table-hover">
<?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $products): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
 <tr product_id="<?php echo e($products->id); ?>" class="product"><td><?php echo e($products->name); ?>-<?php echo e($products->code); ?></td></tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</table>

<script>
   var APP_URL = <?php echo json_encode(url('/')); ?>


  $('.product').click(function(){
	  var pid=$(this).attr('product_id');
	  $.ajax({
		 url:''+APP_URL+'/select/specific_products/'+pid,
         type:'get',
         success:function(){
			 
		 },
        error:function(){
			
		}		 
	  });
	  $('.home-search-result').css('display','none');
  })
</script>
 <?php $__env->startSection('content'); ?>
   <div class="cart-page">
      
	</div>
 <script>
 
    var APP_URL = <?php echo json_encode(url('/')); ?>


   $(document).ready(function(){
	  $(".cart-page").load(APP_URL+'/cart_items'); 
   });
   
 </script>
	<?php $__env->stopSection(); ?>
 

<?php echo $__env->make('fronted-layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
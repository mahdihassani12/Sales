 <?php $__env->startSection('content'); ?>
   <div class="cart-page">
      
	</div>

<div id="product_not_available" class="modal fade " role="dialog" >
  <div class="modal-dialog " style="width:320px; padding-top:80px ">
    <div class="modal-content" style="border-radius:0px;padding:20px;">
      <div class="modal-body" style="background:#fff;padding:0px; ">
	    <button type="button" class="close" data-dismiss="modal" style="float:inherit">&times; <span style="font-size:14px">اغلاق</span></button> 
        <div style="text-align:center;">
	<h1 style="margin-bottom:20px;">يوجد لديك <span class="available_product_qty" style="border-bottom:1px solid red"></span> قطعة من هذا المنتج فقط</h1>

		    <button class="btn btn-primary" data-dismiss="modal">OK</button>
        </div>		
	 </div>
    </div>
  </div>
</div>	 

 <?php $__env->stopSection(); ?>
 
 <?php $__env->startSection('scripts'); ?>;

 <script>
   var refID=<?php if($reference_id !=""): echo $reference_id; else: echo "null";endif;?>;
     
    var APP_URL = <?php echo json_encode(url('/')); ?>


   $(document).ready(function(){
	  $(".cart-page").load(APP_URL+'/cart_items/'+refID); 
   });
   
 </script>
	<?php $__env->stopSection(); ?>
 

<?php echo $__env->make('fronted-layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
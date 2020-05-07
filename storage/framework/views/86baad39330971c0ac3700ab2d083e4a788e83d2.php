		  <?php if(count($products)>0): ?>
		    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		        <?php 
					//$allqty=DB::table('product_store')->where('product_id',$product->id)->get();
					 //$allQuantity=0;
					 //foreach($allqty as $totalCount){
					//	 $allQuantity=$allQuantity+$totalCount->qty; 
					 //}
					 
										
				$added_number=0;
				   foreach(Cart::content() as $cr):
				  if($cr->id==$product->id){
					    $added_number=$cr->qty;
				     }
			    	endforeach;	 
			   ?>
		       <li class="single_item_list"><?php echo e($product->arabic_name); ?><a class="btn add_to_carts" product_id="<?php echo e($product->id); ?>" product_qty="<?php echo e($product->storeqty-$added_number); ?>">اطلب الان</a></li>
		    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         <?php else: ?>
		 <li>Not Found</li>
		 <?php endif; ?>	
		

<?php $zero_qty=DB::table('general_settings')->where('id','1')->get()[0]->zero_balance; ?>	
<script>
  var zero_qty=<?php echo $zero_qty;?>;
  var couponNumber=localStorage.getItem('userCoupon');
  var user_role=<?php echo Auth::user()->role_id;?>;
  var negative_sale='<?php echo DB::table('site_setting')->where('id','1')->first()->allow_negative;?>';

  
	var APP_URL = <?php echo json_encode(url('/')); ?>

	   

    $(".add_to_carts").click(function(){
	   var pid=$(this).attr('product_id');
           $(this).css('pointer-events','none');

	   if($(this).attr('product_qty')<=-negative_sale  && user_role !=8   /* && zero_qty==0 */){
				
               $('#confirmModal').on('show.bs.modal', function (e) {
				  var button = e.relatedTarget;
				  if($(button).hasClass('no-modal')) {
					e.stopPropagation();
				  }  
				});				
		    $("#product_not_available").modal('show');
                   $(".available_product_qty").text(0);
      } 
      else{
            var currency=localStorage.getItem("currency");
		   if(currency==null || currency=="" || currency=="null" || currency==0){
			   currency="en";
		   } 	
           window.location.assign(APP_URL+'/add_to_cart_search/'+pid+'/'+couponNumber+'/'+currency);
	  }		 
	});

	 $(document).click(function (e){
		 if(e.target.class != 'single_item_list') {
			 $(".search-result").css('display','none');
		 } 
	   });
	   
	   
</script>		 
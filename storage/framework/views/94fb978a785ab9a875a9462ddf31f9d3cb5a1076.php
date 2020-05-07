  
  <?php $product= DB::table('products')->where('id',$id)->get()[0];
    
	   $store= DB::table('product_store')
		   ->join('stores','stores.id','product_store.store_id')
		   ->select('stores.name','product_store.qty')
		   ->where('stores.is_active','1')
		   ->where('product_id',$product->id)->get();
   $total=0;
  ?>        
 <div class="selected_item" style="position:relative">
					 <h5><?php echo e($product->name); ?></h5>
					 <h6><?php echo e(trans('file.total_qty')); ?> <span class="total_item">  </span></h6>
				   
				   <table class="table table-hover">
				     <thead>
					    <tr><th><?php echo e(trans('file.name')); ?> <?php echo e(trans('file.Store')); ?></td><th><?php echo e(trans('file.count')); ?></th></tr>
					 </thead>
					 <tbody>
					   <?php $__currentLoopData = $store; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $str): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					    <tr><td><?php echo e($str->name); ?></td><td style="color:green"><?php echo e($str->qty); ?></td></tr>
					   <?php $total+=$str->qty;?>
					   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					 </tbody>
				   </table>
				   <span id="search_total_item_result"><?php echo e($total); ?></span>
				  </div> 
				   
<style>
  #search_total_item_result{
	 position: absolute;
    top: 29px;
    right: 12px;
    font-weight: bold;
    color: cornflowerblue;
  }
</style>		
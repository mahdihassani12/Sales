

<table class="table table-striped rwd-table">
   <thead>
      <tr>
	      <th><?php echo e(trans('file.product')); ?></th>
	      <th><?php echo e(trans('file.qty')); ?></th>
	      <th><?php echo e(trans('file.Price')); ?></th>
	      <th><?php echo e(trans('file.Subtotal')); ?></th>
	  </tr>
   </thead>
   <tbody>
      <?php $totalQty=0;?>
       <?php $totalPrice=0;?>
      <?php if($requestDetail->count()>0): ?>
      <?php $__currentLoopData = $requestDetail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	  <tr>
	     <td><?php echo e($details->product_name); ?></td>
	     <td><?php echo e($details->product_qty); ?></td>
	     <td><?php echo e($details->product_price); ?></td>
	     <td><?php echo e($details->product_qty*$details->product_price); ?></td>
	  </tr>
	  <?php $totalQty+=$details->product_qty;?>
	  <?php $totalPrice+=$details->product_price*$details->product_qty;?>
	  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	   <tr><td><b><?php echo e(trans('file.Total')); ?></b></td><td><b><?php echo e($totalQty); ?></b></td><td></td><td><b><?php echo e($totalPrice); ?></b></td></tr>
       <tr>
	       <td colspan="2"><?php echo e(trans('file.Shipping Cost')); ?></td><td colspan="2">300.00</td>
	  </tr> 
      <tr>	  
	       <td colspan="2"><?php echo e(trans('file.grand total')); ?></td><td colspan="2"><?php echo e($totalPrice+300); ?></td>
	  </tr>	 
	 <?php else: ?>
         <tr><td colspan="4" style="text-align:center;"><?php echo e(trans('file.not_found')); ?></td></tr>
      <?php endif; ?>		  
   </tbody>
</table>
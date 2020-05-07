<div class="print_arial">
<div style="direction:rtl">
  <p><b><?php echo e(trans('file.date')); ?> : </b> <span><?php echo e($data['order'][0]->date); ?></span>  <button style="float:left;" class="print_btn btn btn-info"><a href="<?php echo e(asset('online_order/print')); ?>/<?php echo e($data['order'][0]->request_id); ?>" style="color:#fff" target="_blank"><?php echo e(trans('file.Print')); ?></a></button></p>
  <p><b><?php echo e(trans('file.reference_no')); ?> : </b> <span><?php echo e($data['order'][0]->reference_no); ?></span></p>
  <p><b><?php echo e(trans('file.Store')); ?> : </b> <span><?php echo e($data['order'][0]->storeName); ?></span></p>
  <p><b><?php echo e(trans('file.To')); ?> : </b> <span><?php echo e($data['order'][0]->customerName); ?></span></p>
</div>
<table class="table table-striped">
   <tr>
      <th><?php echo e(trans('file.products')); ?></th>
      <th><?php echo e(trans('file.arabic_name')); ?></th>
      <th><?php echo e(trans('file.sub_category')); ?></th>
      <th><?php echo e(trans('file.category')); ?></th>
      <th><?php echo e(trans('file.Code')); ?></th>
      <th><?php echo e(trans('file.qty')); ?></th>
   </tr>
   <?php $totalQty=0; ?>
   <?php $__currentLoopData = $data['products']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
         <tr>
	  <td><?php echo e($pr->pro_name); ?></td>
	  <td><?php echo e($pr->arabic_name); ?></td>
	  <td>
		<?php if($pr->parentCategory!=null): ?>
		<?php echo e($pr->cateName); ?>

		<?php else: ?> 
		<?php echo e('N\A'); ?>

		<?php endif; ?>				
	 </td>
	 <td>
		<?php if($pr->parentCategory==null): ?>
		  <?php echo e($pr->cateName); ?>

		<?php else: ?> 
          <?php $category=DB::table('categories')->where('id',$pr->parentCategory)->get(); if(count($category)>0): echo $category[0]->name; endif;?> 
		<?php endif; ?>
	 </td>
	  <td><?php echo e($pr->code); ?></td>
	  <td><?php echo e($pr->qty); ?></td>
	</tr>
	<?php $totalQty+=$pr->qty;?>
   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
  </table>
  <h5>
  <?php echo e(trans('file.total_qty')); ?>

	  <span style="float:left"><?php echo e($totalQty); ?></span>
  </h5>
<div>  
<script>
   $(".print_btn").click(function(){
		//w=window.open();
		//w.document.write('<style type="text/css">@media  print { .print_btn { display: none } #close-btn { display: none } table{width:100%;border:1px solid gray;border-collapse:collapse;} table td{border:1px solid gray;} }</style>'+$('.print_arial').html());
		//w.print();
		//w.close(); 
	 });
</script>
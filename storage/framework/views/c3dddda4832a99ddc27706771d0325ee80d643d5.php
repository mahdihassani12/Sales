<button style="float:left"  class="btn btn-primary print_the_modal"style="@media  print{.print_the_modal{display:none}}">Print</button>

<div id="modal_print_data">
<div style="direction:rtl">
  <p><b><?php echo e(trans('file.date')); ?> : </b> <span><?php echo e($data['order'][0]->date); ?></span>    </p>
  <p><b><?php echo e(trans('file.reference_no')); ?> : </b> <span><?php echo e($data['order'][0]->reference_no); ?></span></p>
  <p><b><?php echo e(trans('file.Store')); ?> : </b> <span><?php echo e($data['order'][0]->storeName); ?></span></p>
</div>
<table class="table table-striped" style="width:100%; 1px solid lightgray; border-collapse: collapse;" border="1">
   <tr>
      <th><?php echo e(trans('file.products')); ?></th>
      <th><?php echo e(trans('file.sub_category')); ?></th>
      <th><?php echo e(trans('file.category')); ?></th>
      <th><?php echo e(trans('file.qty')); ?></th>
   </tr>
   <?php $totalQty=0; ?>
   <?php $__currentLoopData = $data['products']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
	  <td><?php echo e($pr->prName); ?></td>
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
	  <td><?php echo e($pr->qty); ?></td>
	</tr>
	<?php $totalQty+=$pr->qty;?>
   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
  </table>
  <h5>
  <?php echo e(trans('file.total_qty')); ?>

	  <span style="float:left"><?php echo e($totalQty); ?></span>
  </h5>
 </div> 
 <style>
 @media  print{
	 #modal_print_data table{
		 width:100%;
	 }
	 #modal_print_data table,#modal_print_data table td,#modal_print_data table th{
		 border:1px solid gray;
       background:red	
	}
	 #modal_print_data table{
		 
	 }
 }
 </style>
  <script>
     $(".print_the_modal").click(function(){
		w=window.open();
		w.document.write($('#modal_print_data').html());
		w.print();
		w.close(); 
	 });
  </script>
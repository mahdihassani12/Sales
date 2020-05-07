 
 <?php if($storeName=="single_store"): ?>
    <a class="btn btn-primary export_btn" href="<?php echo e(URL::to('store_qty/export')); ?>/<?php echo e($store_id); ?>">xls</a>
   <table class="table table-striped rwd-table" id="report-table" data-autogen-headers="true">
	     <thead>
			 <tr>
			    <th class="not-exported"></th>
				<th><?php echo e(trans('file.product')); ?></th>
                <th><?php echo e(trans('file.arabic_name')); ?></th>
                <th><?php echo e(trans('file.sub_category')); ?></th>
                <th><?php echo e(trans('file.category')); ?></th>
				<th><?php echo e(trans('file.Code')); ?></th>
				<th><?php echo e(trans('file.qty')); ?></th>
			</tr>
		 </thead>
         <tbody>
		  <?php $__currentLoopData = $products_qty; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product_qty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		  <tr><td></td>
		   <td><?php echo e($product_qty->name); ?></td>
		   <td><?php echo e($product_qty->arabic_name); ?></td>
		   <td>
			<?php if($product_qty->parentCategory!=null): ?>
			<?php echo e($product_qty->cateName); ?>

			<?php else: ?> 
			<?php echo e('N\A'); ?>

			<?php endif; ?>				
		   </td>
		   <td>
			<?php if($product_qty->parentCategory==null): ?>
			  <?php echo e($product_qty->cateName); ?>

			<?php else: ?> 
			  <?php $category=DB::table('categories')->where('id',$product_qty->parentCategory)->get(); if(count($category)>0): echo $category[0]->name; endif;?> 
			<?php endif; ?>
		   </td>
		   <td><?php echo e($product_qty->code); ?></td>
		   <td><?php echo e($product_qty->qty); ?></td>
		   </tr>
		  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </tbody>
	</table>
	<?php else: ?>
	    <a class="btn btn-primary export_btn" href="<?php echo e(URL::to('store_qty/export')); ?>/all">xls</a>

	  <table class="table table-striped" id="report-table">
	     <thead>
			 <tr>
			    <th class="not-exported"></th>
				<th><?php echo e(trans('file.product')); ?></th>
                                 <th><?php echo e(trans('file.arabic_name')); ?></th>
				<th><?php echo e(trans('file.Code')); ?></th>
				<th><?php echo e(trans('file.qty')); ?></th>
				<th><?php echo e(trans('file.Store')); ?></th>
			</tr>
		 </thead>
         <tbody>
		  <?php $__currentLoopData = $products_qty; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product_qty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		  <tr><td></td><td><?php echo e($product_qty->name); ?></td><td><?php echo e($product_qty->arabic_name); ?></td><td><?php echo e($product_qty->code); ?></td><td><?php echo e($product_qty->qty); ?></td><td><?php echo e($product_qty->storename); ?></td></tr>
		  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </tbody>
	</table>
	<?php endif;?>
	
	<style>
	  .export_btn{
    position: absolute;
    right: 383px;
    padding: 5px 28px;
    border-radius: 5px;
    background: #FF9800;
    border: none;
	  }
	</style>
	<script>
	      $("ul#report").siblings('a').attr('aria-expanded','true');
    $("ul#report").addClass("show");
    $("ul#report li").eq(10).addClass("active");

    $('#report-table').DataTable( {
        "order": [],
        'columnDefs': [
            {
                "orderable": false,
                'targets': 0
            },
            {
                'checkboxes': {
                   'selectRow': true
                },
                'targets': 0
            }
        ],
        'select': { style: 'multi',  selector: 'td:first-child'},
        'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
        dom: 'Blfrtip',
        buttons: [
            {
                extend: 'pdf',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
            },
            {
                extend: 'colvis',
                columns: ':gt(0)'
            }
        ],
    } );

	
	</script>
 
 <?php if($storeName=="single_store"): ?>
   <table class="table table-striped rwd-table" id="report-table" data-autogen-headers="true">
	     <thead>
			 <tr>
			    <th class="not-exported"></th>
				<th><?php echo e(trans('file.product')); ?></th>
				<th><?php echo e(trans('file.qty')); ?></th>
			</tr>
		 </thead>
         <tbody>
		  <?php $__currentLoopData = $products_qty; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product_qty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		  <tr><td></td><td><?php echo e($product_qty->name); ?></td><td><?php echo e($product_qty->qty); ?></td></tr>
		  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </tbody>
	</table>
	<?php else: ?>
	  <table class="table table-striped" id="report-table">
	     <thead>
			 <tr>
			    <th class="not-exported"></th>
				<th><?php echo e(trans('file.product')); ?></th>
				<th><?php echo e(trans('file.qty')); ?></th>
				<th><?php echo e(trans('file.Store')); ?></th>
			</tr>
		 </thead>
         <tbody>
		  <?php $__currentLoopData = $products_qty; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product_qty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		  <tr><td></td><td><?php echo e($product_qty->name); ?></td><td><?php echo e($product_qty->qty); ?></td><td><?php echo e($product_qty->storename); ?></td></tr>
		  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </tbody>
	</table>
	<?php endif;?>
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
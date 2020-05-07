 <?php $__env->startSection('content'); ?>

<section>
	<h4 class="text-center"><?php echo e(trans('file.product')); ?> <?php echo e(trans('file.movement')); ?> <?php echo e(trans('file.Report')); ?></h4>
	<div class="table-responsive">
        <table class="table table-striped rwd-table" id="report-table" data-autogen-headers="true"> 
            <thead>
                <tr>
                    <th class="not-exported">#</th>
                    <th><?php echo e(trans('file.product')); ?> <?php echo e(trans('file.name')); ?></th>
                    <th><?php echo e(trans('file.date')); ?> </th>
                    <th> <?php echo e(trans('file.time')); ?> </th>
                    <th> <?php echo e(trans('file.category')); ?> </th>
					<th><?php echo e(trans('file.Store')); ?> </th>
                    <th><?php echo e(trans('file.Quantity')); ?> <?php echo e(trans('file.in')); ?></th>
                    <th><?php echo e(trans('file.Quantity')); ?> <?php echo e(trans('file.out')); ?></th>
					<th><?php echo e(trans('file.Balance')); ?> </th>
                    <th><?php echo e(trans('file.Invoice')); ?> <?php echo e(trans('file.Type')); ?> </th>
                    <th><?php echo e(trans('file.reference')); ?>  </th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $type_ext= explode('-',$product->reference)[0];?>
				
				<tr>
                    <td><?php echo e($key); ?></td>
                    <td><?php echo e($product->product_name); ?></td>
                    <td><?php echo e($product->date); ?></td>
                    <td><?php echo e($product->time); ?></td>
                    <td><?php echo e($product->category_name); ?></td>
                    <td><?php echo e($product->store_name); ?></td>
                    <td><?php echo e($product->qty_in); ?></td>
                    <td><?php echo e($product->qty_out); ?></td>
                    <td>
                       <?php
		          $allProduct= DB::table('item_movement')->where('product_id',$product->product_id)->where('store_id',$product->store_id)->where('id' ,'<',$product->id)->orderBy('id','DESC')->get();		   
			echo $allProduct->sum('qty_in')-$allProduct->sum('qty_out')+$product->qty_in-$product->qty_out;
			?>
                    </td>
                    <td><?php echo e($product->type_invoice); ?></td>
                    <td><a href="<?php echo e(asset('invoice/details/')); ?>/<?php echo e($product->reference); ?>"><?php echo e($product->reference); ?></a></td>
                    
                </tr>
                 
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</section>
<style>
 .mobile-table td[data-title]:before{
	 padding-left:10px;
	 padding-right:10px;
 }
</style>
<script type="text/javascript">
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
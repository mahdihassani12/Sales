 <?php $__env->startSection('content'); ?>

<section>
	<h4 class="text-center"><?php echo e(trans('file.product')); ?> <?php echo e(trans('file.Quantity')); ?> <?php echo e(trans('file.Alert')); ?></h4>
	<div class="table-responsive"> 
        <table id="report-table" class="table table-hover rwd-table" data-autogen-headers="true">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th><?php echo e(trans('file.Image')); ?></th>
                    <th><?php echo e(trans('file.product')); ?> <?php echo e(trans('file.name')); ?></th>
                    <th><?php echo e(trans('file.product')); ?> <?php echo e(trans('file.Code')); ?></th>
                    <th><?php echo e(trans('file.Quantity')); ?></th>
                    <th><?php echo e(trans('file.Alert')); ?> <?php echo e(trans('file.Quantity')); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $ezpos_product_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($key); ?></td>
                    <td> <img src="<?php echo e(url('public/images/product',$product->image)); ?>" height="80" width="80"> </td>
                    <td><?php echo e($product->name); ?></td>
                    <td><?php echo e($product->code); ?></td>
                    <td><?php echo e(number_format((float)($product->qty), 2, '.', '')); ?></td>
                    <td><?php echo e(number_format((float)($product->alert_quantity), 2, '.', '')); ?></td>
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
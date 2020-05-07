<?php $__env->startSection('content'); ?>
<?php if(session()->has('message')): ?>
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message')); ?></div> 
<?php endif; ?>
<?php if(session()->has('not_permitted')): ?>
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('not_permitted')); ?></div> 
<?php endif; ?>

<section>
    <div class="container-fluid">
	<?php $__currentLoopData = $adjusInvoice; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="row">	
  <div class="invoice_details col-sm-8">	
	<p><b><?php echo e(trans('file.date')); ?> : &nbsp;&nbsp;&nbsp;&nbsp;</b><?php echo explode(' ',$invoice->created_at)[0]?></p>
	<p><b><?php echo e(trans('file.time')); ?> : &nbsp;&nbsp;&nbsp;&nbsp;</b><?php echo explode(' ',$invoice->created_at)[1]?></p>
	<p><b><?php echo e(trans('file.reference')); ?> : &nbsp;&nbsp;&nbsp;&nbsp;</b><?php echo e($invoice->reference_no); ?></p>
	<p><b><?php echo e(trans('file.Store')); ?> : &nbsp;&nbsp;&nbsp;&nbsp;</b><?php echo e($invoice->name); ?></p>
  </div>	
  <div class="col-sm-4" style="display:none">
    <?php if(in_array("adjusment-edit", $all_permission)): ?>
     <a class='btn btn-success' href="<?php echo e(route('qty_adjustment.edit', ['id' => $invoice->id])); ?>" style="color:#fff; padding:4px 35px; font-size:18px"><?php echo e(trans('file.edit')); ?></a>
    <?php endif; ?> 
 </div> 
</div>  
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<table class="table table-striped rwd-table" data-autogen-headers="true">
	  <thead>
	    <tr><th>#</th><th><?php echo e(trans('file.product')); ?></th><th><?php echo e(trans('file.qty')); ?></th><th><?php echo e(trans('file.price')); ?></th><th><?php echo e(trans('file.Subtotal')); ?></th></tr>
	  </thead>
	  <tbody>
	    <?php $counter=1;
         $total=0;
		 $totalItem=0;
		 $totalPrice=0;
		 
		?>
 	    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <tr><td><?php echo e($counter); ?></td><td><?php echo e($product->name); ?></td><td><?php echo e($product->qty); ?></td><td><?php echo e($product->price); ?></td><td><?php echo $product->price*$product->qty; ?></td></tr>		
 		<?php 
		$counter++;
		$totalItem+=$product->qty;
		$totalPrice+=$product->price;
		$total+=$product->price*$product->qty;
		?>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	  </tbody>
	  <tfoot>
	    <tr><th><?php echo e(trans('file.Total')); ?></th><th></th><th><?php echo e($totalItem); ?></th><th><?php echo e($totalPrice); ?></th><th><?php echo e($total); ?></th></tr>
	  </tfoot>
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
    $("ul#adjustment").siblings('a').attr('aria-expanded','true');
    $("ul#adjustment").addClass("show");
    $("ul#adjustment li").eq(0).addClass("active");

    function confirmDelete() {
        if (confirm("Are you sure want to delete?")) {
            return true;
        }
        return false;
    }

    $('#adjustment-table').DataTable( {
        "order": [],
        'columnDefs': [
            {
                "orderable": false,
                'targets': [0, 6]
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
                footer:true
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
                footer:true
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
                footer:true
            },
            {
                extend: 'colvis',
                columns: ':gt(0)'
            },
        ],
    } );

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
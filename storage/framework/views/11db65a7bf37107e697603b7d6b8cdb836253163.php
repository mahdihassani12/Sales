 <?php $__env->startSection('content'); ?>

<section>
	<h4 class="text-center"><?php echo e(trans('file.requested')); ?> <?php echo e(trans('file.products')); ?> </h4>
	<div class="table-responsive">
        <table class="table table-striped rwd-table" id="report-table" data-autogen-headers="true"> 
            <thead>
               <tr>
                    <th class="not-exported">#</th>
                    <th><?php echo e(trans('file.customer')); ?> <?php echo e(trans('file.name')); ?></th>
                    <th><?php echo e(trans('file.customer')); ?> <?php echo e(trans('file.phone')); ?></th>
                    <th> <?php echo e(trans('file.customer')); ?> <?php echo e(trans('file.City')); ?> </th>
                    <th> <?php echo e(trans('file.Subtotal')); ?> </th>
					<th><?php echo e(trans('file.Shipping Cost')); ?>  </th>
                    <th><?php echo e(trans('file.Total')); ?></th>
                    
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $request; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $requests): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<tr id="<?php echo e($requests->id); ?>" class="customer_list" data-toggle="modal" data-target="#detailModal"> 
                    <td></td>
                    <td><?php echo e($requests->customer_name); ?></td>
                    <td><?php echo e($requests->customer_phone); ?></td>
                    <td><?php echo e($requests->customer_city); ?></td>
                    <td><?php echo e($requests->subtotal); ?></td>
                    <td><?php echo e($requests->shipping_cost); ?></td>
                    <td><?php echo e($requests->total); ?></td>
                
                </tr>
                 
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</section>

<div id="detailModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">   
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> <?php echo e(trans('file.request')); ?> <?php echo e(trans('file.Details')); ?> </h4>
      </div>
      <div class="modal-body">
        
      </div>
    </div>

  </div>
</div>

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

		var APP_URL = <?php echo json_encode(url('/')); ?>

	
	 $(".customer_list").click(function(){
		var cid=$(this).attr('id'); 
		$.ajax({
			url:APP_URL+'/request_details/'+cid,
			type:'get',
			success:function(response){
				$('#detailModal .modal-body').html(response);
			},
			error:function(){
				
			}
		}) 
	 });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->startSection('content'); ?>
<section>
    <?php if(session()->has('request_message')): ?>
       <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('request_message')); ?></div> 
   <?php endif; ?>
   <?php if(session()->has('message')): ?>
       <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message')); ?></div> 
   <?php endif; ?>
 
  
	<div class="show_order_list" >
	  <table  class="table table-striped rwd-table" data-autogen-headers="true" id="report-table"> 
            <thead>
               <tr>
                    <th class="not-exported">#</th>
                    <th><?php echo e(trans('file.customer')); ?> <?php echo e(trans('file.name')); ?></th>
                    <th><?php echo e(trans('file.customer')); ?> <?php echo e(trans('file.phone')); ?></th>
                    <th> <?php echo e(trans('file.customer')); ?> <?php echo e(trans('file.City')); ?> </th>                    
                    <th> <?php echo e(trans('file.date')); ?> </th>
                     <th> <?php echo e(trans('file.note')); ?> </th>
                    <th><?php echo e(trans('file.Details')); ?></th>
                   <?php if(Auth::user()->role_id<=2): ?> 
					<th><?php echo e(trans('file.action')); ?></th>
			       <?php endif; ?>	
                </tr>
            </thead>
            <tbody>
			  <?php $currentStatus='null';?>
                <?php $__currentLoopData = $request; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $requests): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		            <tr> 
                    <td requestId="<?php echo e($requests->id); ?>"></td>
                    <td><?php echo e($requests->customer_name); ?></td>
                    <td><?php echo e($requests->customer_phone); ?></td>
                    <td><?php echo e($requests->ccity); ?></td>
                    
                    <td> <?php echo explode(' ',$requests->created_at)[0]?> </td>
                    <td><?php echo e($requests->marketer_note); ?></td>
                    <td id="<?php echo e($requests->id); ?>" class="customer_list" data-toggle="modal" data-target="#detailModal"><a class=" btn btn-info" style="color:#fff"><?php echo e(trans('file.Details')); ?></a></td>
                    <?php if(Auth::user()->role_id<=2): ?>
					<td>
					      <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo e(trans('file.action')); ?><span class="caret"></span><span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                
								<li>
                                    <a href="<?php echo e(asset('sale/marketer_orders/edit')); ?>/<?php echo e($requests->id); ?>" class="btn btn-link"><i class="fa fa-edit"></i> <?php echo e(trans('file.edit')); ?></a> 
                                </li>
                                <li class="divider"></li>
								
                                <?php echo e(Form::open(['url' => ['marketer_order/destroy', $requests->id], 'method' => 'DELETE'] )); ?>

                                <li>
                                    <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="fa fa-trash"></i> <?php echo e(trans('file.delete')); ?></button>
                                </li>
                                <?php echo e(Form::close()); ?>

                            </ul>
                        </div>
					</td>
				   <?php endif; ?>	
                </tr>
				 <?php $currentStatus=$requests->status;?>
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
        <button type="button" class="close" data-dismiss="modal" style="padding:0px">&times;</button>
        <h4 class="modal-title"> <?php echo e(trans('file.request')); ?> <?php echo e(trans('file.Details')); ?> </h4>
      </div>
      <div class="modal-body">
        
      </div>
    </div>

  </div>
</div>
<script>
  
  function confirmDelete(){
	  var con=confirm('Are you Sure to delete?');
	  if(con !=true){
		  return false;
	  }
  }
    $('#report-table').DataTable( {
        "order": [],
        'columnDefs': [
            {
                "orderable": false,
                'targets': [0]
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
            },
        ],
     });
	 
  
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
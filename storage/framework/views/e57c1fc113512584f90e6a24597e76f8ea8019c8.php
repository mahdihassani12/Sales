 <?php $__env->startSection('content'); ?>

<section>
    <?php if(session()->has('request_message')): ?>
       <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('request_message')); ?></div> 
   <?php endif; ?>
	<h4 class="text-center"><?php echo e(trans('file.rejected')); ?> <?php echo e(trans('file.orders')); ?> </h4>
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
                    <th><?php echo e(trans('file.paid_amount')); ?></th>
                    <th> <?php echo e(trans('file.date')); ?> </th>
                    <th> <?php echo e(trans('file.Details')); ?> </th>
                    <th><?php echo e(trans('file.change')); ?> <?php echo e(trans('file.status')); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $request; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $requests): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<tr> 
                    <td requestId="<?php echo e($requests->id); ?>"></td>
                    <td><?php echo e($requests->customer_name); ?></td>
                    <td><?php echo e($requests->customer_phone); ?></td>
                    <td><?php echo e($requests->ccity); ?></td>
                    <td><?php echo e($requests->subtotal); ?></td>
                    <td><?php echo e($requests->shipping_cost); ?></td>
                    <td><?php echo e($requests->total); ?></td>
                    <td><?php echo e($requests->paid_amount); ?></td>
                    <td> <?php echo explode(' ',$requests->created_at)[0]?> </td>
                     <td id="<?php echo e($requests->id); ?>" class="customer_list" data-toggle="modal" data-target="#detailModal"><a class=" btn btn-info" style="color:#fff"><?php echo e(trans('file.Details')); ?></a></td>
					
                    <td>
					  
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo e(trans('file.change')); ?> <?php echo e(trans('file.status')); ?>

                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
							    
								  <li>
                                    <a href="<?php echo e(asset('request/change_rejected_status')); ?>/<?php echo e($requests->id); ?>/<?php echo e($requests->status); ?>/waiting" class="btn btn-link"> <?php echo e(trans('file.waiting')); ?></a>
                                  </li>
								  
								 <?php if(Auth::user()->role_id==1 || Auth::user()->role_id==2): ?> 
								  <li>
                                    <a href="<?php echo e(asset('request/change_rejected_status')); ?>/<?php echo e($requests->id); ?>/<?php echo e($requests->status); ?>/delete" class="btn btn-link"> <?php echo e(trans('file.delete')); ?></a>
                                  </li>
							     <?php endif; ?>

                            </ul>
                        </div>
                    
					</td>
                </tr>
                 
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

         <div style="padding:6px 44px; font-size:17px; font-weight:bold; ">
	     <span><?php echo e(trans('file.select_status')); ?></span>
		 <select class="status-list">
		    <option value="waiting"><?php echo e(trans('file.waiting')); ?></option>
		    <option value="delete"><?php echo e(trans('file.delete')); ?></option>
		 </select>
		 <button id="allItems" class="btn btn-success" style="padding: 5px 16px;"><?php echo e(trans('file.execute')); ?></button>            
	  </div>
</section>

<div id="process_modal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="max-width: 483px;">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">   
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> <?php echo e(trans('file.orders')); ?> <?php echo e(trans('file.process')); ?> </h4>
      </div>
      <div class="modal-body">
        
      </div>
    </div>

  </div>
</div>


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

<style>
 .mobile-table td[data-title]:before{
	 padding-left:10px;
	 padding-right:10px;
 }
 .status{
	 color:#fff; 
	 padding:3px 10px; 
 }
 @media(max-width:450px){
	#allItems{
     width:100%;
	 margin-top:10px;
  }
 }
</style>
<script type="text/javascript">
 $("#allItems").click(function(){
	   var totalIds="";
	   var tostatus=$(".status-list option:selected").val();
	   $('input.dt-checkboxes').each(function () {
          totalIds =totalIds+ (this.checked ? $(this).parent().attr('requestId')+"," :"")
		});
		if(totalIds==""){
			alert('first select any orders');
		}
		else{ 	
       	  window.location.assign(APP_URL+'/changeRejectedOredersStatus/'+totalIds+'/'+tostatus)	
		}
   });


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

	 $(".process_order").click(function(){
	
		var orId=$(this).attr('order_id'); 
		$.ajax({
			url:'request/process_status/'+orId,
			type:'get',
			success:function(response){
			   $("#process_modal").html(response);	
			},
			error:function(){
				
			}
		});
	 });
	 
	 

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
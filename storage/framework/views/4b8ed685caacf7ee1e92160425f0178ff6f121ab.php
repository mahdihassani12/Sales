     <table class="table table-striped rwd-table"  id="report-table" data-autogen-headers="true"> 
            <thead>
               <tr>
                      <th class="not-exported">#</th>
                    <th><?php echo e(trans('file.customer')); ?> <?php echo e(trans('file.name')); ?></th>
                    <th><?php echo e(trans('file.customer')); ?> <?php echo e(trans('file.phone')); ?></th>
                    <th> <?php echo e(trans('file.date')); ?> </th>
                    <th> <?php echo e(trans('file.total_qty')); ?> </th>
                    <th> <?php echo e(trans('file.Store')); ?> </th>
                    <th> Username </th>
                    <th><?php echo e(trans('file.Details')); ?></th>
                    <th><?php echo e(trans('file.action')); ?> </th>
                </tr>
            </thead>
            <tbody>
			       <?php $currentStatus='null';?>
                <?php $__currentLoopData = $request; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $requests): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		            <tr> 
                    <td requestId="<?php echo e($requests->id); ?>"></td>
                    <td><?php echo e($requests->customer_name); ?></td>
                    <td><?php echo e($requests->customer_phone); ?></td>
                    <td> <?php echo e($requests->request_date); ?> </td>					
                    <td><?php echo e($requests->totalQty); ?></td>
                    <td><?php echo e($requests->storeName); ?></td>
                    <td><?php echo e($requests->customer_name); ?></td>
                   
				   <td id="<?php echo e($requests->id); ?>" class="customer_list" data-toggle="modal" data-target="#detailModal"><a class=" btn btn-info" style="color:#fff"><?php echo e(trans('file.Details')); ?></a></td>

                    <td>
					  
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ><?php echo e(trans('file.change')); ?> <?php echo e(trans('file.status')); ?>

                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                              <li style="display:none">
                                <a data-toggle="modal" href="#process_modal" class="btn btn-link process_order" order_id="<?php echo e($requests->id); ?>"> <?php echo e(trans('file.process')); ?></a>
                               </li>
			       <li style="diaplay:none">
                                <a href="<?php echo e(asset('request/change_status')); ?>/<?php echo e($requests->id); ?>/<?php echo e($requests->status); ?>/rejected" class="btn btn-link"> <?php echo e(trans('file.reject')); ?></a>
                               </li>
							  <?php  $sale_id=DB::table('sales')->where('request_id',$requests->id)->first()->id;?> 
                              <?php if(Auth::user()->role_id==1 || Auth::user()->role_id==2): ?>
                                <?php echo e(Form::open(['route' => ['sale.destroy', $sale_id], 'method' => 'DELETE'] )); ?>

                                <li >
                                    <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="fa fa-trash"></i> <?php echo e(trans('file.delete')); ?></button>
                                </li>
                                <?php echo e(Form::close()); ?>

							  <?php endif; ?>
                            </ul>
                        </div>
					</td>
                </tr>
				 <?php $currentStatus=$requests->status;?>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>	
<input type="hidden" id="current_status" value="<?php echo e($currentStatus); ?>">
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

<div id="changePaidAmount" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:485px">
    <div class="modal-content">
      <div class="modal-header">   
        <button type="button" class="close" data-dismiss="modal" style="padding:0px">&times;</button>
      </div>
      <div class="modal-body">
        <div class="col-12 from-group">
           <label> <?php echo e(trans('file.paid_amount')); ?></label>		
		   <input type="number" placeholder="<?php echo e(trans('file.enter_paid_amount')); ?>" class="form-control" name="paid_amount" id="change_paid_amount">
		   <input type="hidden" id="selected_orders" name="selected_orders">
		</div> 
		<div class="col-12 form-group">
		  <button class="btn btn-primary btn-block" id="save_paid_amount_change" style="margin-top:10px;"><?php echo e(trans('file.save')); ?></button>
		</div>
      </div>
    </div>

  </div>
</div>


   <script>
   var APP_URL = <?php echo json_encode(url('/')); ?>

     $(".change_paid_amount_link").click(function(){
		var currentPaid=$(this).parents("td").find(".online_order_paid_amount").text();
		var order_id=$(this).attr("orderID");
        	$("#change_paid_amount").val(currentPaid);	
        	$("#selected_orders").val(order_id);	
	 });
	 
	$("#save_paid_amount_change").click(function(){
		//alert($("#change_paid_amount").val()+ $("#selected_orders").val());
		var amount=$("#change_paid_amount").val();
		var req_id=$("#selected_orders").val();
		 
		$.ajax({
			url:APP_URL+'/request/change_paid_amount/'+amount+'/'+req_id,
			type:'get',
			success:function(response){
				if(response=='1'){
				 $(".request_id"+req_id+" .online_order_paid_amount").text(amount);
				 $("#changePaidAmount").modal('hide');
				}
			}
			
		}) 
	}) 
	 
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

 $(".process_order").click(function(){
	
		var orId=$(this).attr('order_id'); 
		$.ajax({
			url:APP_URL+'/request/process_status/'+orId,
			type:'get',
			success:function(response){
			   $("#process_modal").html(response);	
			},
			error:function(){
				
			}
		});
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

   </script>
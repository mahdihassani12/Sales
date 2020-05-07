     <table class="table table-striped rwd-table"  id="report-table" data-autogen-headers="true"> 
            <thead>
               <tr>
                      <th class="not-exported">#</th>
                    <th>{{trans('file.customer')}} {{trans('file.name')}}</th>
                    <th>{{trans('file.customer')}} {{trans('file.phone')}}</th>
                    <th> {{trans('file.date')}} </th>
                    <th> {{trans('file.total_qty')}} </th>
                    <th> {{trans('file.Store')}} </th>
                    <th> Is printed </th>
                    <th> Username </th>
                    <th>{{trans('file.Details')}}</th>
                    <th>{{trans('file.action')}} </th>
                </tr>
            </thead>
            <tbody>
			       <?php $currentStatus='null';?>
                @foreach($request as $requests)
                 @if((Auth::user()->role_id==12 and $requests->sales_isprint==0) or (Auth::user()->role_id!=12 ))
		            <tr class="is_printed{{$requests->SalesID}}"  @if($requests->sales_isprint==1)  style="background: #e3ffb6;" @endif> 
                    <td requestId="{{$requests->id}}"></td>
                    <td>{{$requests->customer_name}}</td>
                    <td>{{$requests->customer_phone}}</td>
                    <td> {{$requests->request_date}} </td>					
                    <td>{{$requests->totalQty}}</td>
                    <td>{{$requests->storeName}}</td> 
                    <td><input type="checkbox" name="is_printed" class="is_printed" value="{{$requests->SalesID}}" @if($requests->sales_isprint==1) checked @endif></td>
                    <td>{{$requests->customer_name}}</td>
                   
				   <td id="{{$requests->id}}" class="customer_list" data-toggle="modal" data-target="#detailModal"><a class=" btn btn-info" style="color:#fff">{{trans('file.Details')}}</a></td>

                    <td>
					  
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >{{trans('file.change')}} {{trans('file.status')}}
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                              <li style="display:none">
                                <a data-toggle="modal" href="#process_modal" class="btn btn-link process_order" order_id="{{$requests->id}}"> {{trans('file.process')}}</a>
                               </li>
			       <li style="diaplay:none">
                                <a href="{{asset('request/change_status')}}/{{$requests->id}}/{{$requests->status}}/rejected" class="btn btn-link"> {{trans('file.reject')}}</a>
                               </li>
							  <?php  $sale_id=DB::table('sales')->where('request_id',$requests->id)->first()->id;?> 
                              @if(Auth::user()->role_id==1 || Auth::user()->role_id==2)
                                {{ Form::open(['route' => ['sale.destroy', $sale_id], 'method' => 'DELETE'] ) }}
                                <li >
                                    <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="fa fa-trash"></i> {{trans('file.delete')}}</button>
                                </li>
                                {{ Form::close() }}
							  @endif
                            </ul>
                        </div>
					</td>
                </tr>
                @endif
				 <?php $currentStatus=$requests->status;?>
				@endforeach
            </tbody>
        </table>	
<input type="hidden" id="current_status" value="{{$currentStatus}}">
<div id="process_modal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="max-width: 483px;">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">   
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> {{trans('file.orders')}} {{trans('file.process')}} </h4>
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
           <label> {{trans('file.paid_amount')}}</label>		
		   <input type="number" placeholder="{{trans('file.enter_paid_amount')}}" class="form-control" name="paid_amount" id="change_paid_amount">
		   <input type="hidden" id="selected_orders" name="selected_orders">
		</div> 
		<div class="col-12 form-group">
		  <button class="btn btn-primary btn-block" id="save_paid_amount_change" style="margin-top:10px;">{{trans('file.save')}}</button>
		</div>
      </div>
    </div>

  </div>
</div>


   <script>
   var APP_URL = {!! json_encode(url('/')) !!}
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
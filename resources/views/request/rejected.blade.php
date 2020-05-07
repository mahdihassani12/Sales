@extends('layout.main') @section('content')

<section>
    @if(session()->has('request_message'))
       <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('request_message') }}</div> 
   @endif
	<h4 class="text-center">{{trans('file.rejected')}} {{trans('file.orders')}} </h4>
	<div class="table-responsive">
        <table class="table table-striped rwd-table" id="report-table" data-autogen-headers="true"> 
            <thead>
               <tr>
                    <th class="not-exported">#</th>
                    <th>{{trans('file.customer')}} {{trans('file.name')}}</th>
                    <th>{{trans('file.customer')}} {{trans('file.phone')}}</th>
                    <th> {{trans('file.customer')}} {{trans('file.City')}} </th>
                    <th> {{trans('file.Subtotal')}} </th>
		    <th>{{trans('file.Shipping Cost')}}  </th>
                    <th>{{trans('file.Total')}}</th>
                    <th>{{trans('file.paid_amount')}}</th>
                    <th> {{trans('file.date')}} </th>
                    <th> {{trans('file.Details')}} </th>
                    <th>{{trans('file.change')}} {{trans('file.status')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($request as $requests)
		<tr> 
                    <td requestId="{{$requests->id}}"></td>
                    <td>{{$requests->customer_name}}</td>
                    <td>{{$requests->customer_phone}}</td>
                    <td>{{$requests->ccity}}</td>
                    <td>{{$requests->subtotal}}</td>
                    <td>{{$requests->shipping_cost}}</td>
                    <td>{{$requests->total}}</td>
                    <td>{{$requests->paid_amount}}</td>
                    <td> <?php echo explode(' ',$requests->created_at)[0]?> </td>
                     <td id="{{$requests->id}}" class="customer_list" data-toggle="modal" data-target="#detailModal"><a class=" btn btn-info" style="color:#fff">{{trans('file.Details')}}</a></td>
					
                    <td>
					  
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{trans('file.change')}} {{trans('file.status')}}
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
							    
								  <li>
                                    <a href="{{asset('request/change_rejected_status')}}/{{$requests->id}}/{{$requests->status}}/waiting" class="btn btn-link"> {{trans('file.waiting')}}</a>
                                  </li>
			 @if(Auth::user()->role_id==1 || Auth::user()->role_id==2) 
                        <li>
                                    <a href="{{asset('request/change_rejected_status')}}/{{$requests->id}}/{{$requests->status}}/delete" class="btn btn-link"> {{trans('file.delete')}}</a>
                       </li>
                       @endif 
                            </ul>
                        </div>
                    
					</td>
                </tr>
                 
				@endforeach
            </tbody>
        </table>
    </div>

         <div style="padding:6px 44px; font-size:17px; font-weight:bold; ">
	     <span>{{trans('file.select_status')}}</span>
		 <select class="status-list">
		    <option value="waiting">{{trans('file.waiting')}}</option>
		    <option value="delete">{{trans('file.delete')}}</option>
		 </select>
		 <button id="allItems" class="btn btn-success" style="padding: 5px 16px;">{{trans('file.execute')}}</button>            
	  </div>
</section>

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


<div id="detailModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">   
        <button type="button" class="close" data-dismiss="modal" style="padding:0px">&times;</button>
        <h4 class="modal-title"> {{trans('file.request')}} {{trans('file.Details')}} </h4>
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

		var APP_URL = {!! json_encode(url('/')) !!}
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
@endsection
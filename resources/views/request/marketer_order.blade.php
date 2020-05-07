@extends('layout.main')


@section('content')
<section>
    @if(session()->has('request_message'))
       <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('request_message') }}</div> 
   @endif
   @if(session()->has('message'))
       <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div> 
   @endif
 
  
	<div class="show_order_list" >
	  <table  class="table table-striped rwd-table" data-autogen-headers="true" id="report-table"> 
            <thead>
               <tr>
                    <th class="not-exported">#</th>
                    <th>{{trans('file.customer')}} {{trans('file.name')}}</th>
                    <th>{{trans('file.customer')}} {{trans('file.phone')}}</th>
                    <th> {{trans('file.customer')}} {{trans('file.City')}} </th>                    
                    <th> {{trans('file.date')}} </th>
                     <th> {{trans('file.note')}} </th>
                    <th>{{trans('file.Details')}}</th>
                   @if(Auth::user()->role_id<=2) 
					<th>{{trans('file.action')}}</th>
			       @endif	
                </tr>
            </thead>
            <tbody>
			  <?php $currentStatus='null';?>
                @foreach($request as $requests)
		            <tr> 
                    <td requestId="{{$requests->id}}"></td>
                    <td>{{$requests->customer_name}}</td>
                    <td>{{$requests->customer_phone}}</td>
                    <td>{{$requests->ccity}}</td>
                    
                    <td> <?php echo explode(' ',$requests->created_at)[0]?> </td>
                    <td>{{$requests->marketer_note}}</td>
                    <td id="{{$requests->id}}" class="customer_list" data-toggle="modal" data-target="#detailModal"><a class=" btn btn-info" style="color:#fff">{{trans('file.Details')}}</a></td>
                    @if(Auth::user()->role_id<=2)
					<td>
					      <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{trans('file.action')}}<span class="caret"></span><span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                
								<li>
                                    <a href="{{ asset('sale/marketer_orders/edit')}}/{{$requests->id}}" class="btn btn-link"><i class="fa fa-edit"></i> {{trans('file.edit')}}</a> 
                                </li>
                                <li class="divider"></li>
								
                                {{ Form::open(['url' => ['marketer_order/destroy', $requests->id], 'method' => 'DELETE'] ) }}
                                <li>
                                    <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="fa fa-trash"></i> {{trans('file.delete')}}</button>
                                </li>
                                {{ Form::close() }}
                            </ul>
                        </div>
					</td>
				   @endif	
                </tr>
				 <?php $currentStatus=$requests->status;?>
				@endforeach
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
        <h4 class="modal-title"> {{trans('file.request')}} {{trans('file.Details')}} </h4>
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
	 
  
   var APP_URL = {!! json_encode(url('/')) !!}

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
@endsection('content')	
	
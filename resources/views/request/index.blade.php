@extends('layout.main') @section('content')

<section>
    @if(session()->has('request_message'))
       <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('request_message') }}</div> 
   @endif

  <div style="width:400px;margin:auto;" id="select_user_cobobox">   
   <select class="selectpicker form-control" id="user_list" name="user_list" data-live-search="true" data-live-search-style="begins" title="Select User...">
     <option value="all">all</option>
	 @foreach($users as $user)
	   <option value="{{$user->id}}">{{$user->name}}</option>
	 @endforeach
   </select>
</div> 


   <div class="tabs-list" style="display:none">
      <ul>
	     <li style="display:none" class="order_status" status="offer">{{trans('file.offer')}}</li>
	     <li class="order_status active" status="waiting">{{trans('file.waiting')}}</li>
	     <li class="order_status" status="process">{{trans('file.process')}}</li>
	     <li class="order_status" status="pickup">{{trans('file.pickup')}}</li>
	     <li class="order_status" status="delivered">{{trans('file.delivered')}}</li>
	     <li style="display:none" class="order_status" status="paid">{{trans('file.paid')}}</li>
	  </ul>
   </div>
	<div class="show_order_list" >
        <table  class="table table-striped rwd-table" data-autogen-headers="true" id="report-table"> 
            <thead>
               <tr>
                    <th class="not-exported">#</th>
                    <th>{{trans('file.customer')}} {{trans('file.name')}}</th>
                    <th>{{trans('file.customer')}} {{trans('file.phone')}}</th>
                    <th> {{trans('file.date')}} </th>
                    <th> {{trans('file.total_qty')}} </th>
                    <th> {{trans('file.Store')}} </th>
                    <th> Is printed </th>
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
                    <td>{{$requests->customer_name}} </td>
                    <td>{{$requests->customer_phone}}</td>
                    <td> {{$requests->request_date}} </td>						
                    <td>{{$requests->totalQty}}</td>
                    <td>{{$requests->storeName}}</td>
                    <td><input type="checkbox" name="is_printed" class="is_printed" value="{{$requests->SalesID}}" @if($requests->sales_isprint==1) checked @endif></td>
                   
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
                                    <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="fa fa-trash"></i> 
                                   {{trans('file.delete')}}</button>
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
    </div>

 <div style="padding:6px 44px; font-size:17px; font-weight:bold;display:none ">
	     <span>{{trans('file.select_status')}}</span>
		 <select class="status-list">
                    <option value="offer">{{trans('file.offer')}}</option>     
		    <option value="waiting">{{trans('file.waiting')}}</option>
		    <option value="process">{{trans('file.process')}}</option>
		    <option value="pickup">{{trans('file.pickup')}}</option>
		    <option value="delivered">{{trans('file.delivered')}}</option>
		    <option value="paid">{{trans('file.paid')}}</option>
		    <option value="rejected">{{trans('file.reject')}}</option>
		 </select>
		 <button id="allItems" class="btn btn-success" style="padding:5px 16px;">{{trans('file.execute')}}</button>            
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

<div id="amountModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:485px">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">   
        <button type="button" class="close" data-dismiss="modal" style="padding:0px">&times;</button>
      </div>
      <div class="modal-body">
        <div class="col-12 from-group">
           <label> {{trans('file.paid_amount')}}</label>		
		   <input type="number" placeholder="{{trans('file.enter_paid_amount')}}" class="form-control" name="paid_amount" id="paid_amount">
		</div> 
		<div class="col-12 form-group">
		  <button class="btn btn-primary btn-block" id="submit_paid_amount" style="margin-top:10px;">{{trans('file.save')}}</button>
		</div>
      </div>
    </div>

  </div>
</div>

<div class="css_preloader" style='display:none'>
    <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
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
 .tabs-list{
    height: 46px;
    margin: 0px 40px;
    padding: 0px;
 }
 .tabs-list ul{
	  list-style-type:none; 
	  direction:rtl; 
	  
	}
.tabs-list ul li{
    display: inline;
    cursor: pointer;
    padding: 10px 20px;
    float: right;
    border-left: none;
    background: #fcfcff;
    border-bottom: 2px solid transparent;	
	}	 
   .tabs-list ul li.active{
	   background: #c1eefd;
       border-bottom: 2px solid #a9a8a8;
   } 
   
   @media(max-width:450px){
	#allItems{
     width:100%;
	 margin-top:10px;
  }
  #amountModal modal-dialog{
	  width:100%;
  }
  #select_user_cobobox{
	  width:100% !important;
  }
  .tabs-list{
	  margin: 6px 10px;
  }
  .tabs-list ul{
	margin: 0px;
    padding: 0px;
  }
  .tabs-list ul li{
	  width:46%;
	  margin:5px;
	  border-right:2px solid gray;
  }
 }
 
</style>
<script type="text/javascript">

  var APP_URL = {!! json_encode(url('/')) !!}
  $(document).on("click",".is_printed" , function(){
  	var salesId=$(this).val();
  	$.ajax({
  		url:APP_URL+"/sales/is_print/"+salesId,
  		type:'get',
  		success:function(response){
          if(response==1){
          	$(".is_printed"+salesId).css('background','#e3ffb6');
          	location.reload();
          }
  		}

  	})
  });

  
  function confirmDelete() {
	    if (confirm("Are you sure want to delete?")) {
	        return true;
	    }
	    return false;
	}

  $(document).on("click",".deleteOnlineReques",function(event){ 
	  var c=confirm('are you sure to delete this?');
	  if(c!=true){
		event.preventDefault();  
	  }
  });
  

  
  $("#submit_paid_amount").click(function(){
	   var totalIds="";
	   var tostatus=$(".status-list option:selected").val();
	   var fromstatus=$("#current_status").val();
	   
	   $('input.dt-checkboxes').each(function () {
		  totalIds =totalIds+ (this.checked ? $(this).parent().attr('requestId')+"," :"");
		});
		
	  var paid_amount=$("#paid_amount").val();
      if(paid_amount==""){
		  alert('please enter paid value');
	  }	  
	  else{
		 window.location.assign(APP_URL+'/changeOredersStatus/'+totalIds+'/'+fromstatus+'/'+tostatus+'/'+paid_amount); 
	  }
  });
  
  
  
    $("#user_list").change(function(){
	   var userid=$(this).val();
	   $(".show_order_list").css('display','none');
		$(".css_preloader").css('display','block');
	   $.ajax({
		   url:APP_URL+'/selec_request/'+userid,
		   type:'get',
		   success:function(response){
			   $("div.tabs-list ul li").removeClass('active');
			   $("div.tabs-list ul li:first-child").addClass('active');
			   $(".show_order_list").css('display','block');
		       $(".css_preloader").css('display','none');
			   $(".show_order_list").html(response);	
		   },
          error:function(){
			  
		  }  
		   
	   })
   })

      $("#allItems").click(function(){
	   var totalIds="";
	   var tostatus=$(".status-list option:selected").val();
	   var fromstatus=$("#current_status").val();
	   
	   $('input.dt-checkboxes').each(function () {
		  totalIds =totalIds+ (this.checked ? $(this).parent().attr('requestId')+"," :"");
		});
		//alert(totalIds);return ;
		if(totalIds==""){
			alert('first select any orders');
		}
		// today codes
		else if(tostatus=="paid"){
			var ids=totalIds.split(',');
			if(ids.length>2){
				alert('please select one Order for paid Status');
			}
			else{
				$("#amountModal").modal('show');
			}
		}
		// end of today codes

		else{			
       	  window.location.assign(APP_URL+'/changeOredersStatus/'+totalIds+'/'+fromstatus+'/'+tostatus+'/'+0);	
		}
   });


  $(".order_status").click(function(){
		var status=$(this).attr('status');
		var ref_user=$("#user_list option:selected").val();
		
		$(".show_order_list").css('display','none');
		$(".css_preloader").css('display','block');
		$(".order_status").removeClass('active');
		$(this).addClass('active');
		
		if(ref_user=="" || ref_user=="all"){
		  $.ajax({
			url:APP_URL+'/show_orders/'+status,
			type:'get',
			success:function(response){
		       $(".show_order_list").css('display','block');	    	
		       $(".css_preloader").css('display','none');	    	
			   $(".show_order_list").html(response);	
			},
			error:function(){
				
			}
		});
	}
   else{
	      $.ajax({
			url:APP_URL+'/show_orders/'+status+'/'+ref_user,
			type:'get',
			success:function(response){
		       $(".show_order_list").css('display','block');	    	
		       $(".css_preloader").css('display','none');	    	
			   $(".show_order_list").html(response);	
			},
			error:function(){
				
			}
		}); 
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
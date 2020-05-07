@extends('layout.main') @section('content')
@if(session()->has('message'))
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div> 
@endif
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div> 
@endif

<section>
    <div class="container-fluid" style="display:none">
        @if(in_array("sales-add", $all_permission))
            <a href="{{url('/offers1')}}" class="btn btn-info"><i class="fa fa-plus"></i> {{trans('file.add')}} {{trans('file.Sale')}}</a>
        @endif
    </div>
    <div class="table-responsive">
        <table id="sale-table" class="table table-hover sale-list rwd-table" data-autogen-headers="true">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>{{trans('file.Date')}}</th>
                    <th>{{trans('file.time')}}</th>
                    <th>{{trans('file.reference')}} </th>
                    <th>{{trans('file.customer')}}</th>
                    <th>{{trans('file.total_qty')}}</th>
                    <th>{{trans('file.Sale')}} {{trans('file.status')}}</th>
                    <th> Is printed </th>
                    <th>{{trans('file.action')}}</th> 
	       </tr>
            </thead>
                       <tbody>
                @foreach($ezpos_sale_all as $key => $sale)
                <?php 
                                         
                       $customer = DB::table('customers')->find($sale->customer_id);
					if($sale->request_id != ""){
					$customer1=DB::table('request')
					 ->leftjoin('country','country.country_id','request.customer_city')
					 ->where('request.id',$sale->request_id)
					 ->select('country.country as customerCity','request.*')
					 ->get()[0];
					 
					 $customerName=$customer1->customer_name;
                     $phone_number=$customer1->customer_phone;					
                     $customer_address='';					
                     $customer_city=$customer1->customerCity;					
					}
					else{
                    $customerName=$customer->name; 
					$phone_number=$customer->phone_number;
					$customer_address=$customer->address;
					$customer_city=$customer->city;
					}

                    $date = date('d-m-Y', strtotime($sale->date));
                    $user = DB::table('users')->find($sale->user_id);
                    $store = DB::table('stores')->find($sale->store_id);
                    if($sale->sale_status == 1)
                        $sale_status = 'Completed';
                    else
                        $sale_status = 'Draft';
                    
                    $replace = Array(
                        '\\' => '',
                        '"' => '\"'
                    );

                    $sale->sale_note = str_replace(array_keys($replace), $replace, $sale->sale_note);
                    $sale->sale_note = preg_replace('/\r\n+/', "<br>", $sale->sale_note);
                    $sale->staff_note = str_replace(array_keys($replace), $replace, $sale->staff_note);
                    $sale->staff_note = preg_replace('/\r\n+/', "<br>", $sale->staff_note);
                ?>

                @if((Auth::user()->role_id==12 and $sale->is_printed==0) or (Auth::user()->role_id!=12 )) 

                <tr class="sale-link is_printed{{$sale->id}}" data-sale='["{{$date}}", "{{$sale->reference_no}}", "{{$sale_status}}", "{{$customerName}}", "{{$phone_number}}", "{{$customer_address}}", "{{$customer_city}}", "{{$sale->id}}", "{{$sale->total_tax}}", "{{$sale->total_discount}}", "{{$sale->total_price}}", "{{$sale->order_tax}}", "{{$sale->order_tax_rate}}", "{{$sale->order_discount}}", "{{$sale->shipping_cost}}", "{{$sale->grand_total}}", "{{$sale->paid_amount}}", "{{$sale->sale_note}}", "{{$sale->staff_note}}", "@if(isset($user->name)){{$user->name}} @endif", "{{$user->email}}", "@if(isset($store->name)){{$store->name}} @endif"]'  request_id="{{$sale->request_id}}"  @if($sale->is_printed==1)  style="background: #e3ffb6;" @endif>
                    <td>{{$key}}</td>
                    <td>{{$date}}</td>
                    <td><?php echo explode(" ",$sale->created_at)[1];?></td>
                    <td>{{ $sale->reference_no }}</td>
                    <td>
		         @if($sale->request_id !="")
			 <span style="width:10px; height:10px; background:#00c500;border-radius:50%"></span> 
				<?php
				   echo  DB::table('request')->where('id',$sale->request_id)->get()[0]->customer_name;
			   ?>
                        @else					
                        {{ $customer->name }}
					    @endif
                        <input type="hidden" class="deposit" value="@if($sale->request_id ==null){{$customer->deposit - $customer->expense}} @endif" >                  
		         </td>
                 <td>
				 {{$sale->total_qty}}
				 </td>
                    @if($sale_status == 'Completed')
                    <td><div class="badge badge-success">{{$sale_status}}</div></td>
                    @else
                    <td><div class="badge badge-warning">{{$sale_status}}</div></td>
                    @endif
					
                    
                    <td><input type="checkbox" name="is_printed" class="is_printed" value="{{$sale->id}}" @if($sale->is_printed==1) checked @endif></td>
                    <td >
                      
                      @if(Auth::user()->role_id==1 || Auth::user()->role_id==2 || Auth::user()->role_id==11)
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{trans('file.action')}}
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                <li style="display:none">
                                    <button type="button" class="btn btn-link view"><i class="fa fa-eye"></i> {{trans('file.View')}}</button>
                                </li>
                                
                                <li>
                                 
                                        <a href="{{ route('sale.edit', ['id' => $sale->id]) }}" class="btn btn-link"><i class="fa fa-edit"></i> {{trans('file.edit')}}</a>
                                 
                                 
                                </li>
                                
                                
                                @if(in_array("sales-delete", $all_permission))
                                {{ Form::open(['route' => ['sale.destroy', $sale->id], 'method' => 'DELETE'] ) }}
                                <li >
                                    <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="fa fa-trash"></i> {{trans('file.delete')}}</button>
                                </li>
                                {{ Form::close() }}
                                @endif
                            </ul>
                         </div>
                      
                       @else 					  
                            online <span style="width:10px; height:10px; background:#00c500;border-radius:50%"></span> 					
			            @endif
                    </td>
                </tr>
                @endif
                @endforeach
            </tbody>
 
            
        </table>
    </div>
</section>

<div id="sale-details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
      <input type="hidden" id="selected_sale_id" value="">   
  <div role="document" class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 id="exampleModalLabel" class="modal-title">{{trans('file.Sale')}} {{trans('file.Details')}} &nbsp;&nbsp;</h5>
          <button id="print-btn" type="button" class="btn btn-default btn-sm"><i class="fa fa-print"></i> {{trans('file.Print')}}</button>
          <button type="button" id="close-btn" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
        </div>
            <div id="sale-content" class="modal-body">
            </div>
            <br>
            <table class="table table-bordered product-sale-list">
                <thead>
                     <th>#</th>
                    <th>{{trans('file.product')}}</th>
                    <th>{{trans('file.arabic_name')}}</th>
                    <th>{{trans('file.sub_category')}}</th>
                    <th>{{trans('file.category')}}</th>
                    <th>Qty</th>
                    <th style="display:none">{{trans('file.Unit Price')}}</th>
                    <th style="display:none">{{trans('file.Tax')}}</th>
                    <th style="display:none">{{trans('file.Discount')}}</th>
                    <th style="display:none">{{trans('file.Subtotal')}}</th>
               
                </thead>
                <tbody>
                </tbody>
            </table>
            <div id="sale-footer" class="modal-body"></div>
      </div>
    </div>
</div>

<div id="view-payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="exampleModalLabel" class="modal-title">{{trans('file.All')}} {{trans('file.Payment')}}</h5>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <table class="table table-hover payment-list">
                    <thead>
                        <tr>
                            <th>{{trans('file.date')}}</th>
                            <th>{{trans('file.reference')}} No</th>
                            <th>{{trans('file.Amount')}}</th>
                            <th>{{trans('file.Paid')}} {{trans('file.By')}}</th>
                            <th>{{trans('file.action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="add-payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="exampleModalLabel" class="modal-title">{{trans('file.add')}} {{trans('file.Payment')}}</h5>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                {!! Form::open(['route' => 'sale.add-payment', 'method' => 'post', 'files' => true, 'class' => 'payment-form' ]) !!}
                    <div class="form-group">
                        <label><strong>{{trans('file.date')}}</strong></label>
                        <input type="text" name="date" class="form-control date" value="{{date('d-m-Y')}}" required>
                    </div>
                    <div class="form-group">
                        <label><strong>{{trans('file.reference')}} No</strong></label>
                        <p>{{'spr-' . date("Ymd") . '-'. date("his")}}</p>
                    </div>
                    <div class="form-group">
                        <label><strong>{{trans('file.Amount')}}</strong></label>
                        <input required type="number" name="amount" class="form-control" step="any">
                    </div>
                    <div class="form-group">
                        <label><strong>{{trans('file.Paid')}} {{trans('file.By')}}</strong></label>
                        <select name="paid_by_id" class="form-control selectpicker">
                            <option value="1">Cash</option>
                            <option value="2">Gift Card</option>
                            <option value="3">Credit Card</option>
                            <option value="4">Cheque</option>
                            <option value="5">Paypal</option>
                            <option value="6">Deposit</option>
                        </select>
                    </div>
                    <div class="gift-card form-group">
                        <label><strong> {{trans('file.Gift Card')}}</strong></label>
                        <select id="gift_card_id" name="gift_card_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Gift Card...">
                            @php 
                                $balance = [];
                                $expired_date = [];
                            @endphp
                            @foreach($ezpos_gift_card_list as $gift_card)
                            <?php 
                                $balance[$gift_card->id] = $gift_card->amount - $gift_card->expense;
                                $expired_date[$gift_card->id] = $gift_card->expired_date;
                            ?>
                                <option value="{{$gift_card->id}}">{{$gift_card->card_no}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="card-element" class="form-control">
                        </div>
                        <div class="card-errors" role="alert"></div>
                    </div>

                    <div id="cheque">
                        <div class="form-group">
                            <label><strong>{{trans('file.Cheque')}} No</strong></label>
                            <input type="text" name="cheque_no" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label><strong>{{trans('file.Payment')}} {{trans('file.Note')}}</strong></label>
                        <textarea rows="5" class="form-control" name="payment_note"></textarea>
                    </div>

                    <input type="hidden" name="sale_id">

                    <button type="submit" class="btn btn-primary">{{trans('file.submit')}}</button>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

<div id="edit-payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="exampleModalLabel" class="modal-title">{{trans('file.update')}} {{trans('file.Payment')}}</h5>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                {!! Form::open(['route' => 'sale.update-payment', 'method' => 'post', 'class' => 'payment-form' ]) !!}
                    <div class="form-group">
                        <label><strong>{{trans('file.date')}}</strong></label>
                        <input type="text" name="date" class="form-control date" required>
                    </div>
                    <div class="form-group">
                        <label><strong>{{trans('file.reference')}} No</strong></label>
                        <p id="payment_reference"></p>
                    </div>
                    <div class="form-group">
                        <label><strong>{{trans('file.Amount')}}</strong></label>
                        <input type="number" name="edit_amount" class="form-control" step="any">
                    </div>
                    <div class="form-group">
                        <label><strong>{{trans('file.Paid')}} {{trans('file.By')}}</strong></label>
                        <select name="edit_paid_by_id" class="form-control selectpicker">
                            <option value="1">Cash</option>
                            <option value="2">Gift Card</option>
                            <option value="3">Credit Card</option>
                            <option value="4">Cheque</option>
                            <option value="5">Paypal</option>
                            <option value="6">Deposit</option>
                        </select>
                    </div>
                    <div class="gift-card form-group">
                        <label><strong> {{trans('file.Gift Card')}}</strong></label>
                        <select id="gift_card_id" name="gift_card_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Gift Card...">
                            @foreach($ezpos_gift_card_list as $gift_card)
                                <option value="{{$gift_card->id}}">{{$gift_card->card_no}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="card-element" class="form-control">
                        </div>
                        <div class="card-errors" role="alert"></div>
                    </div>
                    <div id="edit-cheque">
                        <div class="form-group">
                            <label><strong>{{trans('file.Cheque')}} No</strong></label>
                            <input type="text" name="edit_cheque_no" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label><strong>{{trans('file.Payment')}} {{trans('file.Note')}}</strong></label>
                        <textarea rows="5" class="form-control" name="edit_payment_note"></textarea>
                    </div>

                    <input type="hidden" name="payment_id">

                    <button type="submit" class="btn btn-primary">{{trans('file.update')}}</button>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

<div id="add-delivery" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="exampleModalLabel" class="modal-title">{{trans('file.add')}} {{trans('file.Delivery')}}</h5>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                {!! Form::open(['route' => 'delivery.store', 'method' => 'post', 'files' => true]) !!}
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label><strong>{{trans('file.date')}}</strong></label>
                        <input type="text" name="date" class="form-control date" value="" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label><strong>{{trans('file.Delivery')}} {{trans('file.reference')}}</strong></label>
                        <p id="dr"></p>
                    </div>
                    <div class="col-md-6 form-group">
                        <label><strong>{{trans('file.Sale')}} {{trans('file.reference')}}</strong></label>
                        <p id="sr"></p>
                    </div>
                    <div class="col-md-6 form-group">
                        <label><strong>{{trans('file.Status')}} *</strong></label>
                        <select name="status" required class="form-control selectpicker">
                            <option value="packing">Packing</option>
                            <option value="delivering">Delivering</option>
                            <option value="delivered">Delivered</option>
                        </select>
                    </div>
                    <div class="col-md-6 mt-2 form-group">
                        <label><strong>{{trans('file.Delivered')}} {{trans('file.By')}}</strong></label>
                        <select name="delivered_by" class="form-control">
				 <?php 
				   $companies=DB::table('company')->get();
				   foreach($companies as $company):
				     ?>
				<option value="{{$company->company_id}}">{{$company->name}}</option>
				<?php endforeach; ?>
		       </select>
                    </div>
                    <div class="col-md-6 mt-2 form-group">
                        <label><strong>{{trans('file.Recieved')}} {{trans('file.By')}}</strong></label>
                        <input type="text" name="recieved_by" class="form-control">
                    </div>
                    <div class="col-md-6 form-group">
                        <label><strong>{{trans('file.customer')}} *</strong></label>
                        <p id="customer"></p>
                    </div>
                    <div class="col-md-6 form-group">
                        <label><strong>{{trans('file.Attach File')}}</strong></label>
                        <input type="file" name="file" class="form-control">
                    </div>
                    <div class="col-md-6 form-group">
                        <label><strong>{{trans('file.Address')}} *</strong></label>
                        <textarea rows="3" name="address" class="form-control" required></textarea>
                    </div>
                    <div class="col-md-6 form-group">
                        <label><strong>{{trans('file.Note')}}</strong></label>
                        <textarea rows="3" name="note" class="form-control"></textarea>
                    </div>
                </div>
                <input type="hidden" name="reference_no">
                <input type="hidden" name="sale_id">
                <button type="submit" class="btn btn-primary">{{trans('file.submit')}}</button>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

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


    var public_key = <?php echo json_encode($ezpos_pos_setting_data->stripe_public_key); ?>;
    
    $("ul#sale").siblings('a').attr('aria-expanded','true');
    $("ul#sale").addClass("show");
    $("ul#sale li").eq(0).addClass("active");

    var date = $('.date');
    date.datepicker({
     format: "dd-mm-yyyy",
     startDate: "<?php echo date('d-m-Y', strtotime('')); ?>",
     autoclose: true,
     todayHighlight: true
     });

    var balance = <?php echo json_encode($balance) ?>;
    var expired_date = <?php echo json_encode($expired_date) ?>;
    var current_date = <?php echo json_encode(date("Y-m-d")) ?>;
    var payment_date = [];
    var payment_reference = [];
    var paid_amount = [];
    var paying_method = [];
    var payment_id = [];
    var payment_note = [];
    var deposit;

    $(".gift-card").hide();
    $(".card-element").hide();
    $("#cheque").hide();
    $('#view-payment').modal('hide');

    $("tr.sale-link td:not(:first-child, :last-child,:nth-child(8))").on("click", function(){
        // var sale = $(this).parent().data('sale');
         var request_id=$(this).parent().attr("request_id");
        $("#selected_sale_id").val(request_id);
        var sale = $(this).parent().data('sale');
        saleDetails(sale);
    });

    $(".view").on("click", function(){
        var sale = $(this).parent().parent().parent().parent().parent().data('sale');
		var request_id=$(this).parent().parent().parent().parent().parent().attr("request_id");
        $("#selected_sale_id").val(request_id);
        saleDetails(sale);
    });

    $("#print-btn").on("click", function(){
          //var divToPrint=document.getElementById('sale-details');
          //var newWin=window.open('','Print-Window');
          //newWin.document.open();
          //newWin.document.write('<style type="text/css">@media print { #print-btn { display: none } #close-btn { display: none }  body{direction:rtl;text-align:right;}table.product-sale-list{width:100%;direction:rtl; border-collapse:collapse} table.product-sale-list,table.product-sale-list td{border:1px solid gray;} }</style><body onload="window.print()">'+divToPrint.innerHTML+'</body>');
          //newWin.document.close();
          //setTimeout(function(){newWin.close();},10);

          var request_id=$("#selected_sale_id").val();
		  //alert(request_id);
		  var url="{{url('online_order/print')}}/"+request_id;
		
		window.open(url, '_blank'); 
    });

    $("table.sale-list tbody").on("click", ".add-payment", function(event) {
        $("#cheque").hide();
        $(".gift-card").hide();
        $(".card-element").hide();
        $('select[name="paid_by_id"]').val(1);
        $('.selectpicker').selectpicker('refresh');
        rowindex = $(this).closest('tr').index();
        deposit = $('table.sale-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.deposit').val();
        var sale_id = $(this).data('id').toString();
        var balance = $('table.sale-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(9)').text();
        $('input[name="amount"]').val(balance);
        $('input[name="sale_id"]').val(sale_id);
    });

    $("table.sale-list tbody").on("click", ".get-payment", function(event) {
        rowindex = $(this).closest('tr').index();
        deposit = $('table.sale-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.deposit').val();
        var id = $(this).data('id').toString();
        $.get('sale/getpayment/' + id, function(data) {
            $(".payment-list tbody").remove();
            var newBody = $("<tbody>");
            payment_date  = data[0];
            payment_reference = data[1];
            paid_amount = data[2];
            paying_method = data[3];
            payment_id = data[4];
            payment_note = data[5];
            cheque_no = data[6];
            gift_card_id = data[7];

            $.each(payment_date, function(index){
                var newRow = $("<tr>");
                var cols = '';

                cols += '<td>' + payment_date[index] + '</td>';
                cols += '<td>' + payment_reference[index] + '</td>';
                cols += '<td>' + paid_amount[index] + '</td>';
                cols += '<td>' + paying_method[index] + '</td>';
                if(paying_method[index] != 'Paypal')
                    cols += '<td><div class="btn-group"><button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{trans("file.action")}}<span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button><ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu"><li><button type="button" class="btn btn-link edit-btn" data-id="' + payment_id[index] +'" data-clicked=false data-toggle="modal" data-target="#edit-payment"><i class="fa fa-edit"></i> {{trans("file.edit")}}</button></li><li class="divider"></li>{{ Form::open(['route' => 'sale.delete-payment', 'method' => 'post'] ) }}<li><input type="hidden" name="id" value="' + payment_id[index] + '" /> <button type="submit" class="btn btn-link" onclick="return confirmPaymentDelete()"><i class="fa fa-trash"></i> {{trans("file.delete")}}</button></li>{{ Form::close() }}</ul></div></td>';
                else
                    cols += '<td><div class="btn-group"><button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{trans("file.action")}}<span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button><ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">{{ Form::open(['route' => 'sale.delete-payment', 'method' => 'post'] ) }}<li><input type="hidden" name="id" value="' + payment_id[index] + '" /> <button type="submit" class="btn btn-link" onclick="return confirmPaymentDelete()"><i class="fa fa-trash"></i> {{trans("file.delete")}}</button></li>{{ Form::close() }}</ul></div></td>';

                newRow.append(cols);
                newBody.append(newRow);
                $("table.payment-list").append(newBody);
            });
            $('#view-payment').modal('show');
        });
    });
    
    $("table.payment-list").on("click", ".edit-btn", function(event) {
        $(".edit-btn").attr('data-clicked', true);        
        $(".card-element").hide();
        $("#edit-cheque").hide();
        $('.gift-card').hide();
        $('#edit-payment select[name="edit_paid_by_id"]').prop('disabled', false);
        var id = $(this).data('id').toString();
        $.each(payment_id, function(index){
            if(payment_id[index] == parseFloat(id)){
                $('#edit-payment input[name="date"]').val(payment_date[index]);
                $('input[name="payment_id"]').val(payment_id[index]);
                if(paying_method[index] == 'Cash')
                    $('select[name="edit_paid_by_id"]').val(1);
                else if(paying_method[index] == 'Gift Card'){
                    $('select[name="edit_paid_by_id"]').val(2);
                    $('#edit-payment select[name="gift_card_id"]').val(gift_card_id[index]);
                    $('.gift-card').show();
                    $('#edit-payment select[name="edit_paid_by_id"]').prop('disabled', true);
                }
                else if(paying_method[index] == 'Credit Card'){
                    $('select[name="edit_paid_by_id"]').val(3);
                    $.getScript( "public/vendor/stripe/checkout.js" );
                    $(".card-element").show();
                    $('#edit-payment select[name="edit_paid_by_id"]').prop('disabled', true);
                }
                else if(paying_method[index] == 'Cheque'){
                    $('select[name="edit_paid_by_id"]').val(4);
                    $("#edit-cheque").show();
                    $('input[name="edit_cheque_no"]').val(cheque_no[index]);
                }
                else
                    $('select[name="edit_paid_by_id"]').val(6);

                $('.selectpicker').selectpicker('refresh');
                $("#payment_reference").html(payment_reference[index]);
                $('input[name="edit_amount"]').val(paid_amount[index]);
                $('textarea[name="edit_payment_note"]').val(payment_note[index]);
                return false;
            }
        });
        $('#view-payment').modal('hide');
    });

    $('select[name="paid_by_id"]').on("change", function() {       
        var id = $(this).val();
        $(".payment-form").off("submit");
        if(id == 2){
            $(".gift-card").show();
            $(".card-element").hide();
            $("#cheque").hide();
        }
        else if (id == 3) {
            $.getScript( "public/vendor/stripe/checkout.js" );
            $(".card-element").show();
            $(".gift-card").hide();
            $("#cheque").hide();
        } else if (id == 4) {
            $("#cheque").show();
            $(".gift-card").hide();
            $(".card-element").hide();
        } else if (id == 5) {
            $(".card-element").hide();
            $(".gift-card").hide();
            $("#cheque").hide();
        } else {
            $(".card-element").hide();
            $(".gift-card").hide();
            $("#cheque").hide();
            if(id == 6){
                if($('#add-payment input[name="amount"]').val() > parseFloat(deposit))
                    alert('Amount exceeds customer deposit! Customer deposit : ' + deposit);
            }
        }
    });
    
    $('#add-payment select[name="gift_card_id"]').on("change", function() {
        var id = $(this).val();
        if(expired_date[id] < current_date)
            alert('This card is expired!');
        else if($('#add-payment input[name="amount"]').val() > balance[id]){
            alert('Amount exceeds card balance! Gift Card balance: '+ balance[id]);
        }
    });

    $('input[name="amount"]').on("input", function() {
        var id = $('#add-payment select[name="paid_by_id"]').val();
        var amount = $(this).val();
        if(id == 2){
            id = $('#add-payment select[name="gift_card_id"]').val();
            if(amount > balance[id])
                alert('Amount exceeds card balance! Gift Card balance: '+ balance[id]);
        }
        else if(id == 6){
            if(amount > parseFloat(deposit))
                alert('Amount exceeds customer deposit! Customer deposit : ' + deposit);
        }
    });

    $('select[name="edit_paid_by_id"]').on("change", function() {        
        var id = $(this).val();
        $(".payment-form").off("submit");
        if(id == 2){
            $(".card-element").hide();
            $("#edit-cheque").hide();
            $('.gift-card').show();
        }
        else if (id == 3) {
            $(".edit-btn").attr('data-clicked', true);
            $.getScript( "public/vendor/stripe/checkout.js" );
            $(".card-element").show();
            $("#edit-cheque").hide();
            $('.gift-card').hide();
        } else if (id == 4) {
            $("#edit-cheque").show();
            $(".card-element").hide();
            $('.gift-card').hide();
        } else {
            $(".card-element").hide();
            $("#edit-cheque").hide();
            $('.gift-card').hide();
            if(id == 6){
                if($('input[name="edit_amount"]').val() > parseFloat(deposit))
                    alert('Amount exceeds customer deposit! Customer deposit : ' + deposit);
            }
        }
    });

    $('#edit-payment select[name="gift_card_id"]').on("change", function() {
        var id = $(this).val();
        if(expired_date[id] < current_date)
            alert('This card is expired!');
        else if($('#edit-payment input[name="edit_amount"]').val() > balance[id])
            alert('Amount exceeds card balance! Gift Card balance: '+ balance[id]);
    });

    $('input[name="edit_amount"]').on("input", function() {
        var amount = $(this).val();
        var id = $('#edit-payment select[name="gift_card_id"]').val();
        if(amount > balance[id]){
            alert('Amount exceeds card balance! Gift Card balance: '+ balance[id]);
        }
        var id = $('#edit-payment select[name="edit_paid_by_id"]').val();
        if(id == 6){
            if(amount > parseFloat(deposit))
                alert('Amount exceeds customer deposit! Customer deposit : ' + deposit);
        }
    });

    $("table.sale-list tbody").on("click", ".add-delivery", function(event) {
        var id = $(this).data('id').toString();
        $.get('delivery/create/'+id, function(data) {
            $('#dr').text(data[0]);
            $('#sr').text(data[1]);
            if(data[2]){
                $('select[name="status"]').val(data[2]);
                $('.selectpicker').selectpicker('refresh');
            }
            $('select[name="delivered_by"]').val(data[3]);
            $('input[name="recieved_by"]').val(data[4]);
            $('#customer').text(data[5]);
            $('textarea[name="address"]').val(data[6]);
            $('textarea[name="note"]').val(data[7]);
            $('#add-delivery input[name="date"]').val(data[8]);
            $('input[name="reference_no"]').val(data[0]);
            $('input[name="sale_id"]').val(id);
            $('#add-delivery').modal('show');
        });
    });

    $('#sale-table').DataTable( {
        "order": [],
        'columnDefs': [
            {
                "orderable": false,
                'targets': [0, 7]
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
                action: function(e, dt, button, config) {
                    datatable_sum(dt, true);
                    $.fn.dataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, button, config);
                    datatable_sum(dt, false);
                },
                footer:true
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    datatable_sum(dt, true);
                    $.fn.dataTable.ext.buttons.csvHtml5.action.call(this, e, dt, button, config);
                    datatable_sum(dt, false);
                },
                footer:true
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    datatable_sum(dt, true);
                    $.fn.dataTable.ext.buttons.print.action.call(this, e, dt, button, config);
                    datatable_sum(dt, false);
                },
                footer:true
            },
            {
                extend: 'colvis',
                columns: ':gt(0)'
            },
        ],
        drawCallback: function () {
            var api = this.api();
            datatable_sum(api, false);
        }
    } );

    function datatable_sum(dt_selector, is_calling_first) {
        if (dt_selector.rows( '.selected' ).any() && is_calling_first) {
            var rows = dt_selector.rows( '.selected' ).indexes();

            $( dt_selector.column( 6 ).footer() ).html(dt_selector.cells( rows, 6, { page: 'current' } ).data().sum().toFixed(2));
            $( dt_selector.column( 7 ).footer() ).html(dt_selector.cells( rows, 7, { page: 'current' } ).data().sum().toFixed(2));
            $( dt_selector.column( 8 ).footer() ).html(dt_selector.cells( rows, 8, { page: 'current' } ).data().sum().toFixed(2));
        }
        else {
            $( dt_selector.column( 6 ).footer() ).html(dt_selector.cells( rows, 6, { page: 'current' } ).data().sum().toFixed(2));
            $( dt_selector.column( 7 ).footer() ).html(dt_selector.cells( rows, 7, { page: 'current' } ).data().sum().toFixed(2));
            $( dt_selector.column( 8 ).footer() ).html(dt_selector.cells( rows, 8, { page: 'current' } ).data().sum().toFixed(2));
        }
    }

    function saleDetails(sale){
        var htmltext = '<strong>{{trans("file.Date")}}: </strong>'+sale[0]+'<br><strong>{{trans("file.reference")}}: </strong>'+sale[1]+'<br><strong>{{trans("file.Store")}}: </strong>'+sale[21]+'<br><strong>{{trans("file.Sale")}} {{trans("file.Status")}}: </strong>'+sale[2]+'<br><br><div class="row"><div class="col-md-6"><strong>{{trans("file.To")}}:</strong><br>'+sale[3]+'<br>'+sale[4]+'<br>'+sale[5]+'<br>'+sale[6]+'</div></div>';
        $.get('sale/product_sale/' + sale[7], function(data){
            $(".product-sale-list tbody").remove();
            var name_code = data[0];
            var qty = data[1];
            var unit = data[2];
            var tax = data[3];
            var tax_rate = data[4];
            var discount = data[5];
            var subtotal = data[6];
            var arabic_name = data[7];
            var sub_category = data[8];
            var category = data[9];
            var newBody = $("<tbody>");
            $.each(name_code, function(index){
                var newRow = $("<tr>");
                var cols = '';
                cols += '<td><strong>' + (index+1) + '</strong></td>';
                cols += '<td>' + name_code[index] + '</td>';
				cols += '<td>' + arabic_name[index] + '</td>';
				cols += '<td>' + sub_category[index] + '</td>';
				cols += '<td>' + category[index] + '</td>';
                cols += '<td>' + qty[index] + ' ' + unit[index] + '</td>';
                cols += '<td style="display:none">' + parseFloat(subtotal[index] / qty[index]).toFixed(2) + '</td>';
                cols += '<td style="display:none">' + tax[index] + '(' + tax_rate[index] + '%)' + '</td>';
                cols += '<td style="display:none">' + discount[index] + '</td>';
                cols += '<td style="display:none">' + subtotal[index] + '</td>';
                
                newRow.append(cols);
                newBody.append(newRow);
            });

            var newRow = $("<tr style='display:none'>");
            cols = '';
            cols += '<td colspan=4><strong>{{trans("file.Total")}}:</strong></td>';
            cols += '<td>' + sale[8] + '</td>';
            cols += '<td>' + sale[9] + '</td>';
            cols += '<td>' + sale[10] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr style='display:none'>");
            cols = '';
            cols += '<td colspan=6><strong>{{trans("file.Order")}} {{trans("file.Tax")}}:</strong></td>';
            cols += '<td>' + sale[11] + '(' + sale[12] + '%)' + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr style='display:none'>");
            cols = '';
            cols += '<td colspan=6><strong>{{trans("file.Order")}} {{trans("file.Discount")}}:</strong></td>';
            cols += '<td>' + sale[13] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr style='display:none'>");
            cols = '';
            cols += '<td colspan=6><strong>{{trans("file.Shipping Cost")}}:</strong></td>';
            cols += '<td>' + sale[14] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr style='display:none'>");
            cols = '';
            cols += '<td colspan=6><strong>{{trans("file.grand total")}}:</strong></td>';
            cols += '<td>' + sale[15] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr style='display:none'>");
            cols = '';
            cols += '<td colspan=6><strong>{{trans("file.Paid")}} {{trans("file.Amount")}}:</strong></td>';
            cols += '<td>' + sale[16] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr style='display:none'>");
            cols = '';
            cols += '<td colspan=6><strong>{{trans("file.Balance")}}:</strong></td>';
            cols += '<td>' + parseFloat(sale[15] - sale[16]).toFixed(2) + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            $("table.product-sale-list").append(newBody);
        });
        var htmlfooter = '<p style="display:none"><strong>{{trans("file.Sale")}} {{trans("file.Note")}}:</strong> '+sale[17]+'</p><p style="display:none"><strong>{{trans("file.Staff")}} {{trans("file.Note")}}:</strong> '+sale[18]+'</p><strong>{{trans("file.Created By")}}:</strong><br>'+sale[19]+'<br>'+sale[20];
        $('#sale-content').html(htmltext);
        $('#sale-footer').html(htmlfooter);
        $('#sale-details').modal('show');
    }

    $('.payment-form').on('submit',function(){
        $('#edit-payment select[name="edit_paid_by_id"]').prop('disabled', false);
    });

    function confirmDelete() {
        if (confirm("Are you sure want to delete?")) {
            return true;
        }
        return false;
    }

    function confirmPaymentDelete() {
        if (confirm("Are you sure want to delete? If you delete this money will be refunded.")) {
            return true;
        }
        return false;
    }

</script>
@endsection

@section('scripts')
<script type="text/javascript" src="https://js.stripe.com/v3/"></script>

@endsection
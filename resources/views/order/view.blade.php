@extends('layout.main') @section('content')
@if(session()->has('create_message'))
    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('create_message') }}</div> 
@endif
@if(session()->has('edit_message'))
    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('edit_message') }}</div> 
@endif
@if(session()->has('import_message'))
    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('import_message') }}</div> 
@endif
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div> 
@endif
@if(session()->has('message'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div> 
@endif

<section class="default_page_design">
     <div class="container-fluid ">
	   <div class="row page_title_part">
	      <div class="col-6 title_icon">
		    <img src="{{asset('public/images/icons/shop.svg')}}">
		    <div class="page_title">
			  <h1>{{$data['title']}}</h1>
			  <p>الطلبيات</p>
		    </div>
		  </div>
		   <div class="col-6 title_link">
		     <span>جرد مخزني</span>
			 <a href="{{asset('dashboard/store_movement/')}}/{{$data['store_id']}}"> مشاهدة  &nbsp;&nbsp;<img src="{{asset('public/images/icons/focus.svg')}}"></a>
		  </div>
	   </div>
	 </div>
    <div class="table-responsive">
	    <button class="add_new_order search_side_button btn" style="display:none">إضافة طلبية  +</button>
        <table id="product-data-table" class="table table-striped rwd-table" data-autogen-headers="true">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>التاريخ</th>
                    <th>رقم التسجيل</th>
                    <th>الموظف</th>
                     <th>{{trans('file.full_name')}}</th>          
                    <th>حالة الطلب</th>
                    <th style="display:none">حالة الدفع</th>
                    <th>الاجمالي</th>
                    <th style="display:none">المدفوع</th>
                    <th style="display:none">الرصيد</th>
					<th>التدقيق</th>
                    <th>order</th> 
                    @if(Auth::user()->role_id==1 || Auth::user()->role_id==2) 
			 <th>تحكم</th>
                    @endif
                 </tr>
            </thead>
            <tbody>
			@foreach($data['sale'] as $sl)
			  <tr  @if($sl->order_status==0) style="background:#fdffce;" @endif class="order_details" data-target="" data-toggle="" order_id="{{$sl->id}}"   order_request="{{$sl->request_id}}"> 
			     <td></td> 
			     <td>{{$sl->date}}</td>
			     <td>{{$sl->reference_no}}</td>
			     <td><span class="circle"></span> {{$sl->userName}}</td>
                             <td><span class="circle"></span> {{$sl->fullName}}</td>
				
                 @if($sl->sale_status==1) 				
				   <td><button class="order_status btn">Completed</button></td>
				 @else
					<td><button class="delivery_status btn">Draft</button></td> 
				 @endif
				 
				 @if($sl->payment_status == 2)
				    <td style="display:none"><button class="delivery_status btn">Due</button></td>
				 @else 
					<td style="display:none"><button class="order_status btn">paid</button></td> 
				 @endif
				 <td>{{$sl->total_qty}}</td>
				 <td style="display:none">@if($sl->paid_amount){{$sl->paid_amount}} @else {{'0'}} @endif </td>
				 <td style="display:none">
				     @if($sl->grand_total - $sl->paid_amount)
                     {{ $sl->grand_total - $sl->paid_amount }}
                    @else
                    0.00
                    @endif
				 </td>
				 <td class="change_status"><input type="checkbox" class="order_status" sale_id="{{$sl->id}}" name="order_status"  @if($sl->order_status==1) {{'checked'}} @endif>  تمت مشاهدتها</td>
				 @if($sl->request_id !="")
				    <td>Online <span class="circle"></span></td>
			     @else
					<td>Offline <span class="circle" style="background:red"></span></td> 
				 @endif
                         @if(Auth::user()->role_id==1 || Auth::user()->role_id==2) 
				 <td>
				   <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{trans('file.action')}}
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                <li>
                                    <a href="{{ route('sale.edit', ['id' => $sl->id]) }}" class="btn btn-link"><i class="fa fa-edit"></i> {{trans('file.edit')}}</a>
                                </li>
                                
                              
                                {{ Form::open(['route' => ['sale.destroy', $sl->id], 'method' => 'DELETE'] ) }}
                                <li >
                                    <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="fa fa-trash"></i> {{trans('file.delete')}}</button>
                                </li>
                                {{ Form::close() }}
                            </ul>
                         </div>
				 </td>
				 @endif
			  </tr>
			 @endforeach 
			  </tbody>
        </table>
    </div>
</section>

<div id="orderDetailsModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
	<input type="hidden" id="selected_order_request_id" value="">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
         
      </div>
    </div>

  </div>
</div>

<style>
  table.dataTable{
   width:100% !important;
 }
</style>
<script type="text/javascript">
   var base_url=<?php echo json_encode(url('/'));?>;
   
   $(".change_status .order_status").click(function(event){
	   event.preventDefault();
	   $("#orderDetailsModal").modal('hide');
	   var sale_id=$(this).attr('sale_id');
	   var isChecked=0;
	  if($(this).is(":checked")){
		  isChecked=1; 
	  }
	  
	  $.ajax({
		  url:base_url+'/orders/change_status?sale_id='+sale_id+"&is_checked="+isChecked,
		  type:'get',
		  success:function(){
			  location.reload();
		  },
		  error:function(){
			  
		  }
	  });
   });
   
    $(".order_details").click(function(evt){
	if($(evt.target).is('.change_status .order_status,.btn.btn-default.dropdown-toggle ,.dropdown-default a, .dropdown-default form')) {   
		   return;
       }
	
	   var order=$(this).attr('order_id');	
           var request_id=$(this).attr('order_request');
           $("#selected_order_request_id").val(request_id);	   
	   

	   $("#orderDetailsModal").modal('show');
	   $.ajax({
		  url:base_url+'/order/detail?id='+order,
          type:'get',
          success:function(response){
			  $("#orderDetailsModal .modal-body").html(response);
		  },
		  error:function(){
			  
		  }
		  
	   }); 
	
	});
	
    $("ul#product").siblings('a').attr('aria-expanded','true');
    $("ul#product").addClass("show");
    $("ul#product li").eq(1).addClass("active");

	function confirmDelete() {
	    if (confirm("Are you sure want to delete?")) {
	        return true;
	    }
	    return false;
	}

    var store = [];
    var qty = [];
    var htmltext;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $( "#select_all" ).on( "change", function() {
        if ($(this).is(':checked')) {
            $("tbody input[type='checkbox']").prop('checked', true);
        } 
        else {
            $("tbody input[type='checkbox']").prop('checked', false);
        }
    });
    
    $("tr.product-link td:not(:first-child, :last-child)").on("click", function(){
        var product = $(this).parent().data('product');
        var imagedata = $(this).parent().data('imagedata');
        htmltext = '';
        htmltext = '<p><strong>{{trans("file.Type")}}: </strong>'+product[0].toUpperCase()+'</p><p><strong>{{trans("file.name")}}: </strong>'+product[1]+'</p><p><strong>{{trans("file.Code")}}: </strong>'+product[2]+ '</p><strong>{{trans("file.Barcode")}}: </strong><img src="data:image/png;base64,'+imagedata+'" alt="barcode" /></p><p><strong>{{trans("file.Brand")}}: </strong>'+product[3]+'</p><p><strong>{{trans("file.category")}}: </strong>'+product[4]+'</p><p><strong>{{trans("file.Unit")}}: </strong>'+product[5]+'</p><p><strong>{{trans("file.Quantity")}}: </strong>'+product[13]+'</p><p><strong>{{trans("file.Alert")}} {{trans("file.Quantity")}}: </strong>'+product[10]+'</p><p><strong>{{trans("file.Cost")}}: </strong>'+product[6]+'</p><p><strong>{{trans("file.Price")}}: </strong>'+product[7]+'</p><p><strong>{{trans("file.Tax")}}: </strong>'+product[8]+'</p><p><strong>{{trans("file.Tax")}} {{trans("file.Method")}}: </strong>'+product[9]+'</p><p><strong>{{trans("file.product details")}}: </strong></p>'+product[11];

        $.get('products/product_store/' + product[12], function(data) {
            $(".product-store-list thead").remove();
            $(".product-store-list tbody").remove();
            
            store = data[0];
            qty = data[1];
            if(store.length != 0){
                var newHead = $("<thead>");
                var newBody = $("<tbody>");
                var newRow = $("<tr>");
                newRow.append('<th>{{trans("file.Store")}}</th><th>{{trans("file.Quantity")}}</th>');
                newHead.append(newRow);
                $.each(store, function(index){
                    var newRow = $("<tr>");
                    var cols = '';
                    cols += '<td>' + store[index] + '</td>';
                    cols += '<td>' + qty[index] + '</td>';

                    newRow.append(cols);
                    newBody.append(newRow);
                    $("table.product-store-list").append(newHead);
                    $("table.product-store-list").append(newBody);
                });
            }
        });

        $('#product-content').html(htmltext);
        $('#product-details').modal('show');
    });

    $("#print-btn").on("click", function(){
          var divToPrint=document.getElementById('product-details');
          var newWin=window.open('','Print-Window');
          newWin.document.open();
          newWin.document.write('<style type="text/css">@media print { #print-btn { display: none } #close-btn { display: none } }</style><body onload="window.print()">'+divToPrint.innerHTML+'</body>');
          newWin.document.close();
          setTimeout(function(){newWin.close();},10);
    });

    $('#product-data-table').DataTable( {
		language: { 
		search: "",
        searchPlaceholder: "إبحث عن الكلمات هنا ... "
		},
        "order": [],
        'columnDefs': [
            {
                "orderable": false,
                'targets': [0, 1, 9]
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
                    columns: ':visible:not(.not-exported)',
                    rows: ':visible',
                    stripHtml: false
                },
                customize: function(doc) {
                    for (var i = 1; i < doc.content[1].table.body.length; i++) {
                        if (doc.content[1].table.body[i][0].text.indexOf('<img src=') !== -1) {
                            var imagehtml = doc.content[1].table.body[i][0].text;
                            var regex = /<img.*?src=['"](.*?)['"]/;
                            var src = regex.exec(imagehtml)[1];
                            var tempImage = new Image();
                            tempImage.src = src;
                            var canvas = document.createElement("canvas");
                            canvas.width = tempImage.width;
                            canvas.height = tempImage.height;
                            var ctx = canvas.getContext("2d");
                            ctx.drawImage(tempImage, 0, 0);
                            var imagedata = canvas.toDataURL("image/png");
                            delete doc.content[1].table.body[i][0].text;
                            doc.content[1].table.body[i][0].image = imagedata;
                            doc.content[1].table.body[i][0].fit = [30, 30];
                        }
                    }
                },
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: ':visible:not(.not-exported)',
                    rows: ':visible',
                    format: {
                        body: function ( data, row, column, node ) {
                            if (column === 0 && (data.indexOf('<img src=') !== -1)) {
                                var regex = /<img.*?src=['"](.*?)['"]/;
                                data = regex.exec(data)[1];                 
                            }
                            return data;
                        }
                    }
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible:not(.not-exported)',
                    rows: ':visible',
                    stripHtml: false
                }
            },
            {
                extend: 'colvis',
                columns: ':gt(0)'
            },
        ],
    } );

</script>
@endsection
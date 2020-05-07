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
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div> 
@endif

<section class="default_page_design">
    <div class="table-responsive">
        <table id="product-data-table" class="table table-striped rwd-table" data-autogen-headers="true">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{trans('file.bill_no')}}</th>
                    <th>{{trans('file.Store')}} </th>
                    <th> نوع العملية </th>
                    <th> التاريخ و الوقت </th>
                    <th>UserName</th>
                    <th>البيان</th> 
                    <th>check</th> 
                    <th>{{trans('file.Details')}} </th>
                    <th>تكرار الادخال </th>
                    <th>{{trans('file.action')}} </th>
                 </tr>
            </thead>
            <tbody>
			<?php $counter=1;?>
			@foreach($data['orders'] as $or)
			 <tr>
				   <td>{{$counter}}</td>
			    <td>{{$or->reference_no}}</td>
			    <td>{{$or->storeName}}</td>
			    <td>@if($or->type=='in_store') {{' ادخال مخزني'}} @else {{'اخراج مخزني'}}  @endif</td>
			    <td> {{$or->date}} | <?php echo explode(" ",$or->created_at)[1];?></td>
			    <td>{{$or->userName}}</td>
			    <td>{{$or->note}}</td>
				<td><input type="checkbox" class="check_order" order_id="{{$or->id}}"></td>
                <td>
				 <button  class="btn btn-info order_details" order_id="{{$or->id}}" data-toggle="modal" data-target="#ShowDetails">مشاهدة</button>
				</td>
				<td>
				  <a href="{{ asset('qty_adjustment/re_insert/')}}/{{$or->id}}" class="btn btn-link"><i class="fa fa-plus"></i> تكرار الادخال</a> 
				</td>
			    <td>
				   <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{trans('file.action')}}<span class="caret"></span><span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                
								<li>
                                    <a href="{{ route('qty_adjustment.edit', ['id' => $or->id]) }}" class="btn btn-link"><i class="fa fa-edit"></i> {{trans('file.edit')}}</a> 
                                </li>
								
                                <li class="divider"></li>
								
								
                                {{ Form::open(['route' => ['qty_adjustment.destroy', $or->id], 'method' => 'DELETE'] ) }}
                                <li>
                                    <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="fa fa-trash"></i> {{trans('file.delete')}}</button>
                                </li>
                                {{ Form::close() }}
								
                            </ul>
                        </div>
				</td>
				<?php $counter++;?>
				</tr>
			 @endforeach 
			  </tbody>
        </table>
    </div>
</section>

<div id="ShowDetails" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
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
   
    $(".check_order").click(function(){
        var id=$(this).attr("order_id");
        location.assign(base_url+'/change_adjustment_checked/'+id);
    })

   $(".order_status").click(function(event){
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
		
	   var order=$(this).attr('order_id');	
	  // $("#ShowDetails").modal('show');
	   $.ajax({
		  url:base_url+'/order_archive/detail?id='+order,
          type:'get',
          success:function(response){
			  $("#ShowDetails .modal-body").html(response);
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
                'targets': [0, 1, 6]
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
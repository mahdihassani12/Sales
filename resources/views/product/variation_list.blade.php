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

<section>
    <div class="container-fluid">
        @if(in_array("products-add", $all_permission))
            <a href="#add_variation" class="btn btn-info" data-toggle="modal" ><i class="fa fa-plus"></i> {{__('file.add_varition')}}</a>
		@endif
    </div>
    <div class="table-responsive">
        <table id="product-data-table" class="table table-hover rwd-table" data-autogen-headers="true">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>{{trans('file.Image')}}</th>
                    <th>{{trans('file.variation_name')}}</th>
                    <th>{{trans('file.product')}}</th>
                    <th>{{trans('file.alert_quantity')}}</th>
                    <th>{{trans('file.Price')}}</th>
                    <th class="not-exported">{{trans('file.action')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ezpos_product_variation as $key => $variation)
                <tr class="product-link"  >
                    <td>{{$key}}</td>
                    @if($variation->image)
                      <td> <img src="{{url('public/images/product_variation',$variation->image)}}" height="80" width="80"></td>
                    @else
                    <td>No Image</td>
                    @endif
					<td>{{ $variation->name }}</td>
                    <td><?php echo DB::table('products')->where('id',$variation->product_id)->get()[0]->name;?></td>
                    <td>{{ $variation->alert_quantity}}</td>
                    <td>{{ $variation->price}}</td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{trans('file.action')}}
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                @if(in_array("products-edit", $all_permission))
                                  <li>
                                    <a href="#edit_variation" class="btn btn-link edit_variation" data-toggle="modal" variation_id="{{$variation->id}}"><i class="fa fa-edit"></i> {{trans('file.edit')}}</a>
                                  </li>
                                @endif
                                @if(in_array("products-delete", $all_permission))
                                <li class="divider"></li>
                                {{ Form::open(['url' => ['variations/delete_variation', $variation->id], 'method' => 'get'] ) }}
                                <li>
                                    <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="fa fa-trash"></i> {{trans('file.delete')}}</button>
                                </li>
								<li class="divider"></li>
								<li>
                                </li>
                                {{ Form::close() }}
                                @endif
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

<div id="add_variation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 id="exampleModalLabel" class="modal-title">{{trans('file.add_varition')}} &nbsp;&nbsp;</h5>
          <button type="button" id="close-btn" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
        </div>
		<div id="product-content" class="modal-body">
		{!! Form::open(['url' => 'variations/create_variation', 'method' => 'post', 'class' => ' main_form form-whitout-modal','id'=>'add_suggest','enctype'=> 'multipart/form-data']) !!}
		 <div class="row">
		  <div class="form-group col-sm-6">
		     <label for="variation_name" class="label">{{trans('file.variation_name')}}</label> 
		     <input type="text" class="form-control" name="variation_name" id="variation_name">
		  </div>
		  <div class="form-group col-sm-6">
		     <label for="variation_photo" class="label">{{trans('file.Image')}}</label> 
		     <input type="file" class="form-control" name="variation_photo" id="variation_photo">
		  </div>
		  <div class="form-group col-sm-6">
		     <label for="variation_product" class="label">{{trans('file.product')}}</label> 
		     <select class="form-control selectpicker" id="variation_product" name="variation_product" data-live-search="true" data-live-search-style="begins" title="Select Product..."> 
			   @foreach($products as $product)
                 <option value="{{$product->id}}">{{$product->name}}</option>			   
 			   @endforeach
			 </select>
		  </div>
		  <div class="form-group col-sm-6">
		     <label for="variation_price" class="label">{{trans('file.Price')}}</label> 
		     <input type="number" class="form-control" name="variation_price" id="variation_price">
		  </div>
		  <div class="form-group col-sm-6">
		     <label for="variation_alert" class="label">{{trans('file.alert_quantity')}}</label> 
		     <input type="number" class="form-control" name="variation_alert" id="variation_alert">
		  </div>
		  <div class="form-group col-sm-6">
		     <label  class="label" style='visibility:hidden'>{{trans('file.alert_quantity')}}</label> 
		     <input type="submit" class="btn btn-success btn-block"  value="{{trans('file.submit')}}">
		  </div>
		  </div> 
		  {!! Form::close(); !!}
		</div>
      </div>
    </div>
</div>


<div id="edit_variation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 id="exampleModalLabel" class="modal-title">{{trans('file.edit_varition')}} &nbsp;&nbsp;</h5>
          <button type="button" id="close-btn" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
        </div>
		<div id="product-content" class="modal-body">
		
		</div>
      </div>
    </div>
</div>



<style>
 .mobile-table td[data-title]:before{
	 padding-left:10px;
	 padding-right:10px;
 }
 
 .upload-btn-wrapper {
  position: relative;
  overflow: hidden;
  display: inline-block;
}

.file_btn {
     color: #6b6464;
    background-color: #d4d4d4;
    border-radius: 10px;
    font-size: 15px;
    width: 40%;
    margin-top: 7px;
    padding: 3px 0;
    border: none;
}
#lbl_passenger_attachment{
      color: #a5a4a4;
	  width:100%;
    display: inline-block
}
#attachment_tbl img{
    width: 120px;
    height: 100px;
    margin: 10px;	
}
.upload-btn-wrapper input[type=file] {
  font-size: 19px;
  left: 0;
  top: 0;
  opacity: 0;
}
.save_attachment{
    background: #2196f3;
    width: 70%;
    height: 47px;
    border: none;
    border-radius: 5px;
    color:#fff;
	font-size:20px; 
}

#gallery_images .close_btn{
	color: red;
    position: absolute;
    right: 14px;
    top: 12px;
    padding: 1px 2px;
    background: #ffffffd4;
    border-radius: 6px; 
}

#gallery_images #attachment_tbl .product-gallery-image{
	display:inline-block;
	position:relative;
}
</style>
<script type="text/javascript">

     var APP_URL = {!! json_encode(url('/')) !!}
     $(".edit_variation").click(function(){
		 var var_id=$(this).attr('variation_id');
		 $.ajax({
			 url:APP_URL+'/variation/edit/'+var_id,
			type:'get',
			success:function(response){
				$("#edit_variation .modal-body").html(response);
			},
			error:function(){
				
			}
			
		 });
	 })
	  
    
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
        "order": [],
        'columnDefs': [
            {
                "orderable": false,
                'targets': [0, 1, 5]
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
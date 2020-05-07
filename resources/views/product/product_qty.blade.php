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
        {!! Form::open(['url' => 'order/product_qty', 'method' => 'get', 'class' => 'form-horizontal main_form form-whitout-modal', 'enctype'=> 'multipart/form-data', 'id'=> 'add_attachment_form']) !!} 
        <div class="row">
         <div  class="col-md-3">
           <input type="text" name="name" placeholder="Product Name" class="form-control" @if(isset($data['name'])) value="{{$data['name']}}" @endif>
         </div>
         <div  class="col-md-3">
           <input type="text" name="arname" placeholder="Product AR name" class="form-control" @if(isset($data['arname'])) value="{{$data['arname']}}" @endif>
         </div>
         <div  class="col-md-3">
           <input type="number" name="code" placeholder="product  code" class="form-control" @if(isset($data['code'])) value="{{$data['code']}}" @endif>
         </div>
         <div class="col-md-3 form-group ">
        <select class="form-control  selectpicker category" data-live-search="true" data-live-search-style="begins" title="Select category..." name="category">
         <option value="all" @if(isset($data['categories']) and $data['categories']=="all") {{'selected'}} @endif>{{trans('file.all')}}</option>
       @foreach($data['categories'] as $ct)
         <option value="{{$ct->id}}" @if(isset($data['category']) and $ct->id==$data['category']) selected="selected" @endif>{{$ct->name}}</option>
       @endforeach
      </select>
     </div> 
       <div class="col-md-3 form-group ">
        <select class="form-control  selectpicker category" data-live-search="true" data-live-search-style="begins" title="Select Sub category..." name="subcategory">
         <option value="all" @if(isset($data['subcategory']) and $data['subcategory']=="all") {{'selected'}} @endif>{{trans('file.all')}}</option>
       @foreach($data['subcategories'] as $sct)
         <option value="{{$sct->id}}" @if(isset($data['subcategory']) and $sct->id==$data['subcategory']) selected="selected" @endif>{{$sct->name}}</option>
       @endforeach
      </select>
     </div>
         <div  class="col-md-3">
           <input type="submit" name="search" value="{{trans('file.search')}}" class="btn btn-primary form-control">
         </div>
        
        <div class="col-md-3">
          <button class="form-control btn btn-secondary" type="submit" name="export" value="export">Exls Export</button>
        </div>
       </div>
        {!! Form::close() !!}
    </div>
    <div class="table-responsive">
        <table id="product-data-table" class="table table-hover rwd-table" data-autogen-headers="true">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>{{trans('file.branch')}}</th>
                    <th>{{trans('file.Store')}}</th>
                    <th>{{trans('file.product')}}</th>
                    <th>{{trans('file.arabic_name')}}</th>
                    <th>{{trans('file.Barcode')}}</th>
                    <th>{{trans('file.sub_category')}}</th>
                    <th>{{trans('file.category')}}</th>
                    <th>{{trans('file.Quantity')}}</th>
                    
                </tr>
            </thead>
            <tbody>
              @if(isset($data['result']))
               @foreach($data['result'] as $pr)
                 <tr>
                   <td></td>
                   <td>@if($pr->branchName != "")  {{$pr->branchName}}  @else {{'Admin'}}  @endif</td>                   
                   <td>{{$pr->storeName}}</td>                   
                   <td>{{$pr->name}}</td>                   
                   <td>{{$pr->arabic_name}}</td>                   
                   <td>{{$pr->code}}</td> 
                      <td>
					@if($pr->parentCategory!=null)
					{{$pr->cateName}}
					@else 
					{{'N\A'}}
					@endif				
				 </td>
				 <td>
					@if($pr->parentCategory==null)
					  {{$pr->cateName}}
					@else 
					  <?php $category=DB::table('categories')->where('id',$pr->parentCategory)->get(); if(count($category)>0): echo $category[0]->name; endif;?> 
					@endif
				 </td>				   
                   <td>{{$pr->total_qty}}</td>  

                 </tr>

               @endforeach
              @endif
            </tbody>
        </table>
    </div>
</section>



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

.file_btn,.change_product_img {
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

div.dataTables_wrapper div.dataTables_filter input,div.dataTables_wrapper div.dataTables_filter label{
	width:100%;
}
div.dataTables_wrapper div.dataTables_filter{
	width:40%;
}

</style>
<script type="text/javascript">

     var APP_URL = {!! json_encode(url('/')) !!}

	
	
	

	


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
htmltext = '<p><strong>{{trans("file.Type")}}: </strong>'+product[0].toUpperCase()+'</p><p><strong>{{trans("file.name")}}: </strong>'+product[1]+'</p><p><strong>{{trans("file.Code")}}: </strong>'+product[2]+ '</p><strong>{{trans("file.Barcode")}}: </strong><img src="data:image/png;base64,'+imagedata+'" alt="barcode" /></p><p><strong>{{trans("file.category")}}: </strong>'+product[4]+'</p><p><strong>{{trans("file.Alert")}} {{trans("file.Quantity")}}: </strong>'+product[10]+'</p><p><strong>{{trans("file.product details")}}: </strong></p>'+product[11];

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
                'targets': [0, 1, 4]
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
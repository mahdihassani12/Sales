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
			  <p> 
			    @include('layout.breadcrum')
			  </p>
		    </div>
		  </div>
		  <div class="col-6 title_link">
		     <span>طلبيات جديدة</span>
		<h1 style="display:inline"><a href="{{asset('dashboard/orders')}}/{{$data['store_id']}}"> {{$data['sales_count']}} &nbsp;&nbsp;<img src="{{asset('public/images/icons/shopping-cart-black-shape.svg')}}"></a></h1>

		  </div>
	   </div>
	 </div>
    <div class="table-responsive">
	    <button class="add_new_order search_side_button btn" style="display:none"><a href="{{asset('/offers1')}}" style="color:#fff;">إضافة طلبية  + </a></button>
        <table id="product-data-table" class="table table-striped rwd-table" data-autogen-headers="true">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>اسم المنتج</th>
                    <th>الاسم بالعربي</th>
                    <th>رمز الباركود</th> 
                    <th>التاريخ و الوقت</th>
                    <th>{{trans('file.sub_category')}}</th>
                    <th>{{trans('file.category')}}</th>
                    <th>الوارد</th>
                    <th>الصادر</th>
                    <th>الرصيد</th>
                    <th>ادخال مخزني</th>
                    <th>اخراج مخزني</th>
                 </tr>
            </thead>
            <tbody>
			@foreach($data['products'] as $pr)
			  <tr> 
			     <td></td> 
			     <td>{{$pr->productname}}</td>
                  <td>{{$pr->productArabicName}}</td>
			     <td>{{$pr->productCode}}</td>       
			     <td>{{$pr->date}} | {{$pr->time}}</td>
				 <td>
				    @if($pr->parentCategory!=null)
					{{$pr->catename}}
                    @else 
					{{'N\A'}}
                    @endif				
				 </td>
			     <td>
				    @if($pr->parentCategory==null)
					  {{$pr->catename}}
                    @else 
                     <?php $category=DB::table('categories')->where('id',$pr->parentCategory)->get(); if(count($category)>0): echo $category[0]->name; endif;?> 
                    @endif
				 </td>
			     <td>
                    <button class="store_in btn">{{$pr->qty_in}}</button>
                </td>
			     <td>
                    <button class="store_out btn">  {{$pr->qty_out}}</button>
                 </td>
			     <td><button class="store_balance btn">
				    <?php $allin=DB::table('item_movement')->where('product_id',$pr->product_id)->where('store_id',$pr->store_id)->where('id','<=',$pr->id);echo $allin->sum('qty_in')-$allin->sum('qty_out');?>
				 </button></td>
			     <td>
                    <button class="add_store btn"><a href="{{asset('qty_adjustment/create')}}?store_id={{$pr->store_id}}&product_id={{$pr->product_id}}" style="color:#fff"> ادخال مخزني</a>
                    </button>
                 </td>
			     <td>
                    <button class="out_store btn "> <a href="{{asset('qty_adjustment/store_out')}}" style="color:#fff">اخراج مخزني</a></button>
                </td>
			  </tr>
			@endforeach  
			 </tbody>
        </table>
    </div>
</section>

<style>
  table.dataTable{
   width:100% !important;
 }
</style>
<script type="text/javascript">

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
                'targets': [0, 1, 8]
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
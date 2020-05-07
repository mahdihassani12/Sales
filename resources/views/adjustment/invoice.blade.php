@extends('layout.main')
@section('content')
@if(session()->has('message'))
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div> 
@endif
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div> 
@endif

<section>
    <div class="container-fluid">
	@foreach($adjusInvoice as $invoice)
<div class="row">	
  <div class="invoice_details col-sm-8">	
	<p><b>{{trans('file.date')}} : &nbsp;&nbsp;&nbsp;&nbsp;</b><?php echo explode(' ',$invoice->created_at)[0]?></p>
	<p><b>{{trans('file.time')}} : &nbsp;&nbsp;&nbsp;&nbsp;</b><?php echo explode(' ',$invoice->created_at)[1]?></p>
	<p><b>{{trans('file.reference')}} : &nbsp;&nbsp;&nbsp;&nbsp;</b>{{$invoice->reference_no}}</p>
	<p><b>{{trans('file.Store')}} : &nbsp;&nbsp;&nbsp;&nbsp;</b>{{$invoice->name}}</p>
  </div>	
  <div class="col-sm-4" style="display:none">
    @if(in_array("adjusment-edit", $all_permission))
     <a class='btn btn-success' href="{{ route('qty_adjustment.edit', ['id' => $invoice->id]) }}" style="color:#fff; padding:4px 35px; font-size:18px">{{trans('file.edit')}}</a>
    @endif 
 </div> 
</div>  
	@endforeach
	<table class="table table-striped rwd-table" data-autogen-headers="true">
	  <thead>
	    <tr><th>#</th><th>{{trans('file.product')}}</th><th>{{trans('file.qty')}}</th><th>{{trans('file.price')}}</th><th>{{trans('file.Subtotal')}}</th></tr>
	  </thead>
	  <tbody>
	    <?php $counter=1;
         $total=0;
		 $totalItem=0;
		 $totalPrice=0;
		 
		?>
 	    @foreach($products as $product)
          <tr><td>{{$counter}}</td><td>{{$product->name}}</td><td>{{$product->qty}}</td><td>{{$product->price}}</td><td><?php echo $product->price*$product->qty; ?></td></tr>		
 		<?php 
		$counter++;
		$totalItem+=$product->qty;
		$totalPrice+=$product->price;
		$total+=$product->price*$product->qty;
		?>
		@endforeach
	  </tbody>
	  <tfoot>
	    <tr><th>{{trans('file.Total')}}</th><th></th><th>{{$totalItem}}</th><th>{{$totalPrice}}</th><th>{{$total}}</th></tr>
	  </tfoot>
	</table>
    </div>    
</section>
<style>
 .mobile-table td[data-title]:before{
	 padding-left:10px;
	 padding-right:10px;
 }
</style>
<script type="text/javascript">
    $("ul#adjustment").siblings('a').attr('aria-expanded','true');
    $("ul#adjustment").addClass("show");
    $("ul#adjustment li").eq(0).addClass("active");

    function confirmDelete() {
        if (confirm("Are you sure want to delete?")) {
            return true;
        }
        return false;
    }

    $('#adjustment-table').DataTable( {
        "order": [],
        'columnDefs': [
            {
                "orderable": false,
                'targets': [0, 6]
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
                footer:true
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
                footer:true
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
                footer:true
            },
            {
                extend: 'colvis',
                columns: ':gt(0)'
            },
        ],
    } );

</script>
@endsection
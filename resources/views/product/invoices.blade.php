@extends('layout.main') @section('content')
<style>
  .invoice_details p{
	  margin-bottom:5px; 
  }
</style>
<section style="padding:15px;">
	<h4 class="text-center">{{trans('file.Invoice')}}</h4>
	<?php 
	$invoice_type=explode("-",$id)[0];
      $allRecords=DB::table('item_movement')->where("reference",$id)->get(); 	
	  $item=$allRecords[0];
	  
	?> 
	<div class="invoice_details">
	   <p><b>{{trans('file.date')}}:</b>&nbsp;&nbsp;&nbsp; {{$item->date}} </p>
	   <p><b>{{trans('file.time')}}:</b>&nbsp;&nbsp;&nbsp; {{$item->time}} </p>
	   <p><b>{{trans('file.reference')}}:</b> &nbsp;&nbsp; {{$item->reference}} </p>
	   <p><b>{{trans('file.Invoice')}} {{trans('file.Type')}}: </b> &nbsp;&nbsp;&nbsp; {{$item->type_invoice}} </p>
	</div>
	<?php if($invoice_type=="adr"):
	  $adjustment=DB::table('adjustments')->where('reference_no',$item->reference)->get()[0];
      $adj_id=$adjustment->id;
	  $store_id=$adjustment->store_id;
	  $store=DB::table('stores')->where('id',$store_id)->get()[0];
	  
	  $products=DB::table('product_adjustments')
	      ->join('products','products.id','product_adjustments.product_id')
	      ->where('product_adjustments.adjustment_id',$adj_id)
		  ->select('products.*','product_adjustments.qty as product_qty')
	      ->get();  
   ?>
   <a class='btn btn-success' href="{{ route('qty_adjustment.edit', ['id' => $adj_id]) }}" style="color:#fff; padding:4px 35px; font-size:18px">{{trans('file.edit')}}</a>
   <table class="table table-striped  " style="margin-top:10px;">
	  <thead>
	     <tr><th>#</th> <th>{{trans('file.product')}}</th><th>{{trans('file.Store')}}</th><th>{{trans('file.qty')}} </th> <th>{{trans('file.price')}}</th><th>{{trans('file.Subtotal')}}</th></tr>
	  </thead>
      <tbody>
	     <?php 
		 $counter=1;
         $countItem=0;
		 $total=0;
		 ?>
	     @foreach($products as $product)
            <tr><td>{{$counter}}</td><td>{{$product->name}}</td><td>{{$store->name}}</td><td>{{$product->product_qty}}</td><td>{{$product->price}}</td><td>{{$product->product_qty*$product->price}}</td></tr> 
            <?php 
			$total+=$product->product_qty*$product->price;
			$countItem +=$product->product_qty;
			$counter++;
			?>
		 @endforeach 
          	  <tr><td><b>{{trans('file.Total')}}</b></td><td></td><td></td><td>{{$countItem}}</td><td> </td><td>{{$total}}</td></tr>		 
	          <tr><td>{{trans('file.Note')}}</td><td colspan="5">{{$adjustment->note}}</td></tr>
	  </tbody>
   </table>
   
   <?php 
        elseif($invoice_type=="tr"):
		$transfer=DB::table('transfers')->where('reference_no',$item->reference)->get()[0];
        $tran_id=$transfer->id;
		
	   $storeFrom=$transfer->from_store_id;
	   $storeTo=$transfer->to_store_id;
	   
	   $fromStoreName=DB::table('stores')->where('id',$storeFrom)->get()[0]->name;
	   $toStoreName=DB::table('stores')->where('id',$storeTo)->get()[0]->name;
  
        $products=DB::table('product_transfer')
	      ->join('products','products.id','product_transfer.product_id')
	      ->where('product_transfer.transfer_id',$tran_id)
		  ->select('products.*','product_transfer.qty as product_qty')
	      ->get();  
  ?>
      <a class='btn btn-success' href="{{ route('transfers.edit', ['id' => $transfer->id]) }}" style="color:#fff; padding:4px 35px; font-size:18px">{{trans('file.edit')}}</a>
   <table class="table table-striped  " style="margin-top:10px;">
	  <thead>
	     <tr><th>#</th> <th>{{trans('file.product')}}</th><th>{{trans('file.From')}} {{trans('file.Store')}}</th><th>{{trans('file.To')}} {{trans('file.Store')}}</th><th>{{trans('file.qty')}} </th> <th>{{trans('file.price')}}</th><th>{{trans('file.Subtotal')}}</th></tr>
	  </thead>
      <tbody>
	        <?php 
		 $counter=1;
         $countItem=0;
		 $total=0;
		 ?>
	     @foreach($products as $product)
            <tr><td>{{$counter}}</td><td>{{$product->name}}</td><td>{{$fromStoreName}}</td><td>{{$toStoreName}}</td><td>{{$product->product_qty}}</td><td>{{$product->price}}</td><td>{{$product->product_qty*$product->price}}</td></tr> 
            <?php 
			$total+=$product->product_qty*$product->price;
			$countItem +=$product->product_qty;
			$counter++;
			?>
		 @endforeach 
          	  <tr><td><b>{{trans('file.Total')}}</b></td><td></td><td></td><td></td><td>{{$countItem}}</td><td> </td><td>{{$total}}</td></tr>		 
	          <tr><td><b>{{trans('file.shipping_cost')}}</b> </td><td colspan="6">{{$transfer->shipping_cost}}</td></tr>
	          <tr><td><b>{{trans('file.grand total')}}</b> </td><td colspan="6">{{$transfer->shipping_cost+$total}}</td></tr>
			  <tr><td><b>{{trans('file.Note')}} </b></td><td colspan="6">{{$transfer->note}}</td></tr>
	  
	  </tbody>
	</table>  
    
	<?php   
		elseif($invoice_type=="sr"):
		
		$sales=DB::table('sales')->where('reference_no',$item->reference)->get()[0];
        $sales_id=$sales->id;
		
	   $store_id=$sales->store_id;
	   
	   $storeName=DB::table('stores')->where('id',$store_id)->get()[0]->name;
  
        $products=DB::table('product_sales')
	      ->join('products','products.id','product_sales.product_id')
	      ->where('product_sales.sale_id',$sales_id)
		  ->select('products.*','product_sales.qty as product_qty')
	      ->get(); 
		
		?>
      <a class='btn btn-success' href="{{ route('sale.edit', ['id' => $sales->id]) }}" style="color:#fff; padding:4px 35px; font-size:18px">{{trans('file.edit')}}</a>
    <table class="table table-striped  " style="margin-top:10px;">
	  <thead>
	     <tr><th>#</th> <th>{{trans('file.product')}}</th><th>{{trans('file.Store')}}</th><th>{{trans('file.qty')}} </th> <th>{{trans('file.price')}}</th><th>{{trans('file.Subtotal')}}</th></tr>
	  </thead>
      <tbody>
	        <?php 
		 $counter=1;
         $countItem=0;
		 $total=0;
		 ?>
	     @foreach($products as $product)
            <tr><td>{{$counter}}</td><td>{{$product->name}}</td><td>{{$storeName}}</td><td>{{$product->product_qty}}</td><td>{{$product->price}}</td><td>{{$product->product_qty*$product->price}}</td></tr> 
            <?php 
			$total+=$product->product_qty*$product->price;
			$countItem +=$product->product_qty;
			$counter++;
			?>
		 @endforeach 
          	  <tr><td><b>{{trans('file.Total')}}</b></td><td></td><td></td><td>{{$countItem}}</td><td> </td><td>{{$total}}</td></tr>		 
	          <tr><td><b>{{trans('file.shipping_cost')}}</b> </td><td colspan="6">{{$sales->shipping_cost}}</td></tr>
	          <tr><td><b>{{trans('file.discount')}}</b> </td><td colspan="6">{{$sales->order_discount}}</td></tr>
	          <tr><td><b>{{trans('file.grand total')}}</b> </td><td colspan="6">{{$total+$sales->shipping_cost-$sales->order_discount}}</td></tr>
			  <tr><td><b>{{trans('file.Note')}} </b></td><td colspan="6">{{$sales->sale_note}}</td></tr>
	  
	  </tbody>
	</table>  
    		
		
		<?php 
		else:
   	?>
	<table class="table table-striped table-responsive " style="margin-top:40px;">
	  <thead>
	     <th>#</th> <th>{{trans('file.product')}}</th><th>{{trans('file.qty')}}</th><th>{{trans('file.price')}}</th><th>{{trans('file.Subtotal')}}</th>
	  </thead>
	  <tbody>
	<?php 
	 $counter=1; 
	 $countItem=0;
	 $countItem1=0;
	 $totalPrice=0;
	 $total=0;
	 
	 $shipping=0;
	 $discount=0;
	 
	  foreach($allRecords as $allItem){
		  $product=DB::table('products')->where('id',$allItem->product_id)->get()[0];
       
       
			$product_result=$allItem->qty_in*$product->price; 
			$purchase=DB::table('purchases')->where('reference_no',$id)->get()[0];
			$discount=$purchase->order_discount;
			$shipping=$purchase->shipping_cost;
		
		 ?>
		  <tr><td>{{$counter}}</td><td>{{$product->name}}</td><td>{{$allItem->qty_in}}</td><td>{{$allItem->qty_out}}</td><td>{{$product->price}}</td><td>{{$product_result}}</td></tr>
	<?php
      $countItem=$countItem+$allItem->qty_out;
	  $countItem1=$countItem1+$allItem->qty_in;
	  $totalPrice=$totalPrice+$product->price;
      $total=$total+$product_result;  
      $counter++;
	  }
	?> 
	  <tr><td><b>{{trans('file.Total')}}</b></td><td></td><td>{{$countItem1}}</td><td>{{$countItem}}</td><td>{{$totalPrice}}</td><td>{{$total}}</td></tr>
	  <tr><td><b>{{trans('file.Note')}} :</b></td><td colspan="5">{{$allItem->description}}</td></tr>
	   <tr><td colspan="3"> {{trans('file.Shipping Cost')}} <td><td colspan="3">{{$shipping}}<td></tr>
	   <tr><td colspan="3"> {{trans('file.Discount')}} <td><td colspan="3">{{$discount}}<td></tr>
	   <tr><td > {{trans('file.grand total')}} <td><td colspan="5"><?php echo $total+$shipping-$discount;?><td></tr>
	 </tbody>
	</table>
	<?php 	endif; ?>
</section>

<script type="text/javascript">
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

</script>
@endsection
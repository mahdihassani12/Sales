<button style="float:left"  class="btn btn-primary print_the_modal"style="@media print{.print_the_modal{display:none}}">Print</button>

<div id="modal_print_data">
<div style="direction:rtl">
  <p><b>{{trans('file.date')}} : </b> <span>{{$data['order'][0]->date}}</span>    </p>
  <p><b>{{trans('file.reference_no')}} : </b> <span>{{$data['order'][0]->reference_no}}</span></p>
  <p><b>{{trans('file.Store')}} : </b> <span>{{$data['order'][0]->storeName}}</span></p>
</div>
<table class="table table-striped" style="width:100%; 1px solid lightgray; border-collapse: collapse;" border="1">
   <tr>
      <th>{{trans('file.products')}}</th>
      <th>{{trans('file.sub_category')}}</th>
      <th>{{trans('file.category')}}</th>
      <th>{{trans('file.qty')}}</th>
   </tr>
   <?php $totalQty=0; ?>
   @foreach($data['products'] as $pr )
    <tr>
	  <td>{{$pr->prName}}</td>
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
	  <td>{{$pr->qty}}</td>
	</tr>
	<?php $totalQty+=$pr->qty;?>
   @endforeach 
  </table>
  <h5>
  {{trans('file.total_qty')}}
	  <span style="float:left">{{$totalQty}}</span>
  </h5>
 </div> 
 <style>
 @media print{
	 #modal_print_data table{
		 width:100%;
	 }
	 #modal_print_data table,#modal_print_data table td,#modal_print_data table th{
		 border:1px solid gray;
       background:red	
	}
	 #modal_print_data table{
		 
	 }
 }
 </style>
  <script>
     $(".print_the_modal").click(function(){
		w=window.open();
		w.document.write($('#modal_print_data').html());
		w.print();
		w.close(); 
	 });
  </script>
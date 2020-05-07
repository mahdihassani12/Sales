<div class="print_arial">
<div style="direction:rtl">
  <p><b>{{trans('file.date')}} : </b> <span>{{$data['order'][0]->date}}</span>  <button style="float:left;" class="print_btn btn btn-info"><a href="{{asset('online_order/print')}}/{{$data['order'][0]->request_id}}" style="color:#fff" target="_blank">{{trans('file.Print')}}</a></button></p>
  <p><b>{{trans('file.reference_no')}} : </b> <span>{{$data['order'][0]->reference_no}}</span></p>
  <p><b>{{trans('file.Store')}} : </b> <span>{{$data['order'][0]->storeName}}</span></p>
  <p><b>{{trans('file.To')}} : </b> <span>{{$data['order'][0]->customerName}}</span></p>
</div>
<table class="table table-striped">
   <tr>
      <th>{{trans('file.products')}}</th>
      <th>{{trans('file.arabic_name')}}</th>
      <th>{{trans('file.sub_category')}}</th>
      <th>{{trans('file.category')}}</th>
      <th>{{trans('file.Code')}}</th>
      <th>{{trans('file.qty')}}</th>
   </tr>
   <?php $totalQty=0; ?>
   @foreach($data['products'] as $pr )
         <tr>
	  <td>{{$pr->pro_name}}</td>
	  <td>{{$pr->arabic_name}}</td>
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
	  <td>{{$pr->code}}</td>
	  <td>{{$pr->qty}}</td>
	</tr>
	<?php $totalQty+=$pr->qty;?>
   @endforeach 
  </table>
  <h5>
  {{trans('file.total_qty')}}
	  <span style="float:left">{{$totalQty}}</span>
  </h5>
<div>  
<script>
   $(".print_btn").click(function(){
		//w=window.open();
		//w.document.write('<style type="text/css">@media print { .print_btn { display: none } #close-btn { display: none } table{width:100%;border:1px solid gray;border-collapse:collapse;} table td{border:1px solid gray;} }</style>'+$('.print_arial').html());
		//w.print();
		//w.close(); 
	 });
</script>
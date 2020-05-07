 
 <?php if($storeName=="single_store"): ?>
    <a class="btn btn-primary export_btn" href="{{ URL::to('store_qty/export') }}/{{$store_id}}">xls</a>
   <table class="table table-striped rwd-table" id="report-table" data-autogen-headers="true">
	     <thead>
			 <tr>
			    <th class="not-exported"></th>
				<th>{{trans('file.product')}}</th>
                <th>{{trans('file.arabic_name')}}</th>
                <th>{{trans('file.sub_category')}}</th>
                <th>{{trans('file.category')}}</th>
				<th>{{trans('file.Code')}}</th>
				<th>{{trans('file.qty')}}</th>
			</tr>
		 </thead>
         <tbody>
		  @foreach($products_qty as $product_qty)
		  <tr><td></td>
		   <td>{{$product_qty->name}}</td>
		   <td>{{$product_qty->arabic_name}}</td>
		   <td>
			@if($product_qty->parentCategory!=null)
			{{$product_qty->cateName}}
			@else 
			{{'N\A'}}
			@endif				
		   </td>
		   <td>
			@if($product_qty->parentCategory==null)
			  {{$product_qty->cateName}}
			@else 
			  <?php $category=DB::table('categories')->where('id',$product_qty->parentCategory)->get(); if(count($category)>0): echo $category[0]->name; endif;?> 
			@endif
		   </td>
		   <td>{{$product_qty->code}}</td>
		   <td>{{$product_qty->qty}}</td>
		   </tr>
		  @endforeach
         </tbody>
	</table>
	<?php else: ?>
	    <a class="btn btn-primary export_btn" href="{{ URL::to('store_qty/export') }}/all">xls</a>

	  <table class="table table-striped" id="report-table">
	     <thead>
			 <tr>
			    <th class="not-exported"></th>
				<th>{{trans('file.product')}}</th>
                                 <th>{{trans('file.arabic_name')}}</th>
				<th>{{trans('file.Code')}}</th>
				<th>{{trans('file.qty')}}</th>
				<th>{{trans('file.Store')}}</th>
			</tr>
		 </thead>
         <tbody>
		  @foreach($products_qty as $product_qty)
		  <tr><td></td><td>{{$product_qty->name}}</td><td>{{$product_qty->arabic_name}}</td><td>{{$product_qty->code}}</td><td>{{$product_qty->qty}}</td><td>{{$product_qty->storename}}</td></tr>
		  @endforeach
         </tbody>
	</table>
	<?php endif;?>
	
	<style>
	  .export_btn{
    position: absolute;
    right: 383px;
    padding: 5px 28px;
    border-radius: 5px;
    background: #FF9800;
    border: none;
	  }
	</style>
	<script>
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
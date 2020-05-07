@extends('layout.main') @section('content')

<section>
	<h4 class="text-center">{{trans('file.product')}} {{trans('file.movement')}} {{trans('file.Report')}}</h4>
	<div class="table-responsive">
        <table class="table table-striped rwd-table" id="report-table" data-autogen-headers="true"> 
            <thead>
                <tr>
                    <th class="not-exported">#</th>
                    <th>{{trans('file.product')}} {{trans('file.name')}}</th>
                    <th>{{trans('file.date')}} </th>
                    <th> {{trans('file.time')}} </th>
                    <th> {{trans('file.category')}} </th>
					<th>{{trans('file.Store')}} </th>
                    <th>{{trans('file.Quantity')}} {{trans('file.in')}}</th>
                    <th>{{trans('file.Quantity')}} {{trans('file.out')}}</th>
					<th>{{trans('file.Balance')}} </th>
                    <th>{{trans('file.Invoice')}} {{trans('file.Type')}} </th>
                    <th>{{trans('file.reference')}}  </th>
                </tr>
            </thead>
            <tbody>
                @foreach($reports as $key=>$product)
                <?php $type_ext= explode('-',$product->reference)[0];?>
				
				<tr>
                    <td>{{$key}}</td>
                    <td>{{$product->product_name}}</td>
                    <td>{{$product->date}}</td>
                    <td>{{$product->time}}</td>
                    <td>{{$product->category_name}}</td>
                    <td>{{$product->store_name}}</td>
                    <td>{{$product->qty_in}}</td>
                    <td>{{$product->qty_out}}</td>
                    <td>
                       <?php
		          $allProduct= DB::table('item_movement')->where('product_id',$product->product_id)->where('store_id',$product->store_id)->where('id' ,'<',$product->id)->orderBy('id','DESC')->get();		   
			echo $allProduct->sum('qty_in')-$allProduct->sum('qty_out')+$product->qty_in-$product->qty_out;
			?>
                    </td>
                    <td>{{$product->type_invoice}}</td>
                    <td><a href="{{asset('invoice/details/')}}/{{$product->reference}}">{{$product->reference}}</a></td>
                    
                </tr>
                 
				@endforeach
            </tbody>
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
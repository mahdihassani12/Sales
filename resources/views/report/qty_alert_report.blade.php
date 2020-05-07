@extends('layout.main') @section('content')

<section>
	<h4 class="text-center">{{trans('file.product')}} {{trans('file.Quantity')}} {{trans('file.Alert')}}</h4>
	<div class="table-responsive"> 
        <table id="report-table" class="table table-hover rwd-table" data-autogen-headers="true">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>{{trans('file.Image')}}</th>
                    <th>{{trans('file.product')}} {{trans('file.name')}}</th>
                    <th>{{trans('file.arabic_name')}} </th>
                    <th>{{trans('file.sub_category')}} </th>
                    <th>{{trans('file.category')}} </th>
                    <th>{{trans('file.product')}} {{trans('file.Code')}}</th>
                    <th>{{trans('file.Store')}}</th>
                    <th>{{trans('file.Quantity')}}</th>
                    <th>{{trans('file.Alert')}} {{trans('file.Quantity')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ezpos_product_data as $key=>$product)
                 @if($product->alert_quantity>$product->sqty)
                <tr>
                    <td>{{$key}}</td>
                    <td> <img src="{{url('public/images/product',$product->image)}}" height="80" width="80"> </td>
                    <td>{{$product->name}}</td>
                    <td>{{$product->arabic_name}}</td>
					<td>
						@if($product->parentCategory!=null)
						{{$product->cateName}}
						@else 
						{{'N\A'}}
						@endif				
					 </td>
					 <td>
						@if($product->parentCategory==null)
						  {{$product->cateName}}
						@else 
						  <?php $category=DB::table('categories')->where('id',$product->parentCategory)->get(); if(count($category)>0): echo $category[0]->name; endif;?> 
						@endif
					 </td>
                    <td>{{$product->code}}</td>
                    <td>{{$product->storeName}}</td>
                    <td>{{number_format((float)($product->sqty), 0, '.', '')}}</td>
                    <td>{{number_format((float)($product->alert_quantity), 0, '.', '')}}</td>
                </tr>
                 @endif
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
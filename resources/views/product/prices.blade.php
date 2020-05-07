@extends('layout.main') @section('content')

<section>
	<h4 class="text-center">{{trans('file.product')}}  {{trans('file.prices')}}</h4>
	<div class="table-responsive">
        <table id="report-table" class="table table-hover rwd-table" data-autogen-headers="true">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>{{trans('file.product')}} {{trans('file.name')}}</th>
                    <th>{{trans('file.category')}} </th>
                    <th>{{trans('file.price')}} </th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $key=>$product)
                <tr>
                    <td>{{$key}}</td>
                    <td>{{$product->pname}}</td>
                    <td>{{$product->cname}}</td>
                    <td>{{$product->price}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
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
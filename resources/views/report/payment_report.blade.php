@extends('layout.main') @section('content')

<section>
    <h4 class="text-center">{{trans('file.Payment')}} {{trans('file.Report')}}</h4>
    {!! Form::open(['route' => 'report.paymentByDate', 'method' => 'post']) !!}
    <div class="col-md-6 offset-md-3 mt-4">
        <div class="form-group row">
            <label class="d-tc mt-2"><strong>{{trans('file.Choose Your Date')}}</strong> &nbsp;</label>
            <div class="d-tc">
                <div class="input-group">
                    <input type="text" class="daterangepicker-field form-control" value="{{date('d-m-Y', strtotime($start_date))}} to {{date('d-m-Y', strtotime($end_date))}}" required />
                    <input type="hidden" name="start_date" value="{{$start_date}}" />
                    <input type="hidden" name="end_date" value="{{$end_date}}" />
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">{{trans('file.submit')}}</button>
                    </div>
                </div>
            </div>
        </div> 
    </div>
    {!! Form::close() !!}
    <div class="table-responsive">
        <table id="report-table" class="table table-hover">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>{{trans('file.Date')}}</th>
                    <th>{{trans('file.Payment')}} {{trans('file.reference')}} </th>
                    <th>{{trans('file.Sale')}} {{trans('file.reference')}}</th>
                    <th>{{trans('file.Purchase')}} {{trans('file.reference')}}</th>
                    <th>{{trans('file.Paid')}} {{trans('file.By')}}</th>
                    <th>{{trans('file.Amount')}}</th>
                    <th>{{trans('file.Created By')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ezpos_payment_data as $payment)
                <?php 
                    $sale = DB::table('sales')->find($payment->sale_id);
                    $purchase = DB::table('purchases')->find($payment->purchase_id);
                    $user = DB::table('users')->find($payment->user_id);
                ?>
                <tr>
                    <td></td>
                    <td>{{date('d-m-Y', strtotime($payment->date))}}</td>
                    <td>{{$payment->payment_reference}}</td>
                    <td>@if($sale){{$sale->reference_no}}@endif</td>
                    <td>@if($purchase){{$purchase->reference_no}}@endif</td>
                    <td>{{$payment->paying_method}}</td>
                    <td>{{$payment->amount}}</td>
                    <td>{{$user->name}}<br>{{$user->email}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>


<script type="text/javascript">
    $("ul#report").siblings('a').attr('aria-expanded','true');
    $("ul#report").addClass("show");
    $("ul#report li").eq(8).addClass("active");

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

$(".daterangepicker-field").daterangepicker({
  callback: function(startDate, endDate, period){
    var start_date = startDate.format('DD-MM-YYYY');
    var end_date = endDate.format('DD-MM-YYYY');
    var title = start_date + ' to ' + end_date;
    $(this).val(title);
    $('input[name="start_date"]').val(start_date);
    $('input[name="end_date"]').val(end_date);
  }
});

</script>
@endsection
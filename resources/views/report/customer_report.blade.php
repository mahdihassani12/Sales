@extends('layout.main') @section('content')
<section>
    <h3 class="text-center">{{trans('file.customer')}} {{trans('file.Report')}}</h3>
    {!! Form::open(['route' => 'report.customer', 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-4 offset-md-1 mt-4">
            <div class="form-group row">
                <label class="d-tc mt-2"><strong>{{trans('file.Choose Your Date')}}</strong> &nbsp;</label>
                <div class="d-tc">
                    <div class="input-group">
                        <input type="text" class="daterangepicker-field form-control" value="{{date('d-m-Y', strtotime($start_date))}} to {{date('d-m-Y', strtotime($end_date))}}" required />
                        <input type="hidden" name="start_date" value="{{$start_date}}" />
                        <input type="hidden" name="end_date" value="{{$end_date}}" />
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5 mt-4">
            <div class="form-group row">
                <label class="d-tc mt-2"><strong>{{trans('file.Choose Customer')}}</strong> &nbsp;</label>
                <div class="d-tc">
                    <input type="hidden" name="customer_id_hidden" value="{{$customer_id}}" />
                    <select id="customer_id" name="customer_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins">
                        @foreach($ezpos_customer_list as $customer)
                        <option value="{{$customer->id}}">{{$customer->name}} ({{$customer->phone_number}})</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-2 mt-4">
            <div class="form-group">
                <button class="btn btn-primary" type="submit">{{trans('file.submit')}}</button>
            </div>
        </div>
    </div>
    <input type="hidden" name="customer_id_hidden" value="{{$customer_id}}" />
    {!! Form::close() !!}

    <ul class="nav nav-tabs ml-4" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" href="#customer-sale" role="tab" data-toggle="tab">{{trans('file.Sale')}}</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#customer-payments" role="tab" data-toggle="tab">{{trans('file.Payment')}}</a>
      </li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade show active" id="customer-sale">
            <div class="table-responsive">
                <table id="sale-table" class="table table-hover">
                    <thead>
                        <tr>
                            <th class="not-exported-sale"></th>
                            <th>{{trans('file.Date')}}</th>
                            <th>{{trans('file.reference')}} No</th>
                            <th>{{trans('file.Store')}}</th>
                            <th>{{trans('file.product')}} ({{trans('file.qty')}})</th>
                            <th>{{trans('file.grand total')}}</th>
                            <th>{{trans('file.Paid')}}</th>
                            <th>{{trans('file.Balance')}}</th>
                            <th>{{trans('file.Status')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ezpos_sale_data as $key=>$sale)
                        <tr>
                            <td>{{$key}}</td>
                            <?php 
                                $store = DB::table('stores')->find($sale->store_id);
                                if($sale->sale_status == 1)
                                    $status = 'Completed';
                                elseif($sale->sale_status == 2)
                                    $status = 'Pending';
                            ?>
                            <td>{{date('d-m-Y', strtotime($sale->date))}}</td>
                            <td>{{$sale->reference_no}}</td>
                            <td>{{$store->name}}</td>
                            <td>
                                @foreach($ezpos_product_sale_data[$key] as $product_sale_data)
                                <?php $product = App\Product::find($product_sale_data->product_id);
                                ?>
                                @if($product_sale_data->unit != 'null')
                                    {{$product->name.' ('.$product_sale_data->qty.' '.$product_sale_data->unit.')'}}
                                @else
                                    {{$product->name.' ('.$product_sale_data->qty.')'}}
                                @endif
                                <br>
                                @endforeach
                            </td>
                            <td>{{$sale->grand_total}}</td>
                            <td>{{$sale->paid_amount}}</td>
                            <td>{{number_format((float)($sale->grand_total - $sale->paid_amount), 2, '.', '')}}</td>
                            <td>{{$status}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="tfoot active">
                        <tr>
                            <th></th>
                            <th>Total:</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>0.00</th>
                            <th>0.00</th>
                            <th>0.00</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div role="tabpanel" class="tab-pane fade" id="customer-payments">
            <div class="table-responsive">
                <table id="payment-table" class="table table-hover">
                    <thead>
                        <tr>
                            <th class="not-exported-payment"></th>
                            <th>{{trans('file.Date')}}</th>
                            <th>{{trans('file.Payment')}} {{trans('file.reference')}}</th>
                            <th>{{trans('file.Sale')}} {{trans('file.reference')}}</th>
                            <th>{{trans('file.Amount')}}</th>
                            <th>{{trans('file.Paid')}} {{trans('file.Method')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i=0; @endphp
                        @foreach($ezpos_sale_data as $key=>$sale)
                            @foreach($ezpos_payment_data[$key] as $payment)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{date('d-m-Y', strtotime($payment->date))}}</td>
                                <td>{{$payment->payment_reference}}</td>
                                <td>{{$sale->reference_no}}</td>
                                <td>{{$payment->amount}}</td>
                                <td>{{$payment->paying_method}}</td>
                            </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                    <tfoot class="tfoot active">
                        <tr>
                            <th></th>
                            <th>Total:</th>
                            <th></th>
                            <th></th>
                            <th>0.00</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    
</section>

<script type="text/javascript">
    $("ul#report").siblings('a').attr('aria-expanded','true');
    $("ul#report").addClass("show");
    $("ul#report li").eq(11).addClass("active");

    $('#customer_id').val($('input[name="customer_id_hidden"]').val());
    $('.selectpicker').selectpicker('refresh');

    $('#sale-table').DataTable( {
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
                    columns: ':visible:Not(.not-exported-sale)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    datatable_sum_sale(dt, true);
                    $.fn.dataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, button, config);
                    datatable_sum_sale(dt, false);
                },
                footer:true
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: ':visible:Not(.not-exported-sale)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    datatable_sum_sale(dt, true);
                    $.fn.dataTable.ext.buttons.csvHtml5.action.call(this, e, dt, button, config);
                    datatable_sum_sale(dt, false);
                },
                footer:true
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible:Not(.not-exported-sale)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    datatable_sum_sale(dt, true);
                    $.fn.dataTable.ext.buttons.print.action.call(this, e, dt, button, config);
                    datatable_sum_sale(dt, false);
                },
                footer:true
            },
            {
                extend: 'colvis',
                columns: ':gt(0)'
            }
        ],
        drawCallback: function () {
            var api = this.api();
            datatable_sum_sale(api, false);
        }
    } );

    function datatable_sum_sale(dt_selector, is_calling_first) {
        if (dt_selector.rows( '.selected' ).any() && is_calling_first) {
            var rows = dt_selector.rows( '.selected' ).indexes();

            $( dt_selector.column( 5 ).footer() ).html(dt_selector.cells( rows, 5, { page: 'current' } ).data().sum().toFixed(2));
            $( dt_selector.column( 6 ).footer() ).html(dt_selector.cells( rows, 6, { page: 'current' } ).data().sum().toFixed(2));
            $( dt_selector.column( 7 ).footer() ).html(dt_selector.cells( rows, 7, { page: 'current' } ).data().sum().toFixed(2));
        }
        else {
            $( dt_selector.column( 5 ).footer() ).html(dt_selector.column( 5, {page:'current'} ).data().sum().toFixed(2));
            $( dt_selector.column( 6 ).footer() ).html(dt_selector.column( 6, {page:'current'} ).data().sum().toFixed(2));
            $( dt_selector.column( 7 ).footer() ).html(dt_selector.cells( rows, 7, { page: 'current' } ).data().sum().toFixed(2));
        }
    }

    $('#payment-table').DataTable( {
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
                    columns: ':visible:Not(.not-exported-payment)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    datatable_sum_payment(dt, true);
                    $.fn.dataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, button, config);
                    datatable_sum_payment(dt, false);
                },
                footer:true
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    datatable_sum_payment(dt, true);
                    $.fn.dataTable.ext.buttons.csvHtml5.action.call(this, e, dt, button, config);
                    datatable_sum_payment(dt, false);
                },
                footer:true
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    datatable_sum_payment(dt, true);
                    $.fn.dataTable.ext.buttons.print.action.call(this, e, dt, button, config);
                    datatable_sum_payment(dt, false);
                },
                footer:true
            },
            {
                extend: 'colvis',
                columns: ':gt(0)'
            }
        ],
        drawCallback: function () {
            var api = this.api();
            datatable_sum_payment(api, false);
        }
    } );

    function datatable_sum_payment(dt_selector, is_calling_first) {
        if (dt_selector.rows( '.selected' ).any() && is_calling_first) {
            var rows = dt_selector.rows( '.selected' ).indexes();

            $( dt_selector.column( 4 ).footer() ).html(dt_selector.cells( rows, 4, { page: 'current' } ).data().sum().toFixed(2));
        }
        else {
            $( dt_selector.column( 4 ).footer() ).html(dt_selector.column( 4, {page:'current'} ).data().sum().toFixed(2));
        }
    }

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
@extends('layout.main') @section('content')
@if(session()->has('message'))
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div> 
@endif
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div> 
@endif

<section>
    <div class="container-fluid">
        @if(in_array("transfers-add", $all_permission))
            <a href="{{route('transfers.create')}}" class="btn btn-info"><i class="fa fa-plus"></i> {{trans('file.add')}} {{trans('file.Transfer')}}</a>
        @endif
    </div>
    <div class="table-responsive">
        <table id="transfer-table" class="table table-hover transfer-list respond rwd-table" data-autogen-headers="true">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>{{trans('file.Date')}}</th>
                    <th>{{trans('file.reference')}} No</th>
                    <th>{{trans('file.Store')}}({{trans('file.From')}})</th>
                    <th>{{trans('file.Store')}}({{trans('file.To')}})</th>
                    <th>{{trans('file.product')}} {{trans('file.Cost')}}</th>
                    <th>{{trans('file.product')}} {{trans('file.Tax')}}</th>
                    <th>{{trans('file.grand total')}}</th>
                    <th>{{trans("file.Status")}}</th>
                    <th class="not-exported">{{trans('file.action')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ezpos_transfer_all as $key=>$transfer)
                <?php
                    $date =  date('d-m-Y', strtotime($transfer->date));
                    $from_store = DB::table('stores')->find($transfer->from_store_id);
                    $to_store = DB::table('stores')->find($transfer->to_store_id);
                    $user = DB::table('users')->find($transfer->user_id);
                    if($transfer->status == 1)
                        $status = 'Completed';
                    elseif($transfer->status == 2)
                        $status = 'Pending';
                    elseif($transfer->status == 3)
                        $status = 'Sent';

                    $replace = Array(
                        '\\' => '',
                        '"' => '\"'
                    );

                    $transfer->note = str_replace(array_keys($replace), $replace, $transfer->note);
                    $transfer->note = preg_replace('/\r\n+/', "<br>", $transfer->note);
                ?>
                <tr class="transfer-link" data-transfer='["{{$date}}", "{{$transfer->reference_no}}", "{{$status}}", "{{$transfer->id}}", "{{$from_store->name}}", "{{$from_store->phone}}", "{{$from_store->address}}", "{{$to_store->name}}", "{{$to_store->phone}}", "{{$to_store->address}}", "{{$transfer->total_tax}}", "{{$transfer->total_cost}}", "{{$transfer->shipping_cost}}", "{{$transfer->grand_total}}", "{{$transfer->note}}", "{{$user->name}}", "{{$user->email}}"]'>
                    <td>{{$key}}</td>
                    <td>{{ $date }}</td>
                    <td>{{ $transfer->reference_no }}</td>
                    <td>{{ $from_store->name }}</td>
                    <td>{{ $to_store->name }}</td>
                    <td class="total-cost">{{ $transfer->total_cost }}</td>
                    <td class="total-tax">{{ $transfer->total_tax }}</td>
                    <td class="grand-total">{{ $transfer->grand_total }}</td>
                    @if($status == 'Completed' || $status == 'Sent')
                        <td><div class="badge badge-success">{{$status}}</div></td>
                    @elseif($status == 'Pending')
                        <td><div class="badge badge-danger">{{$status}}</div></td>
                    @endif
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{trans('file.action')}}<span class="caret"></span><span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                <li>
                                    <button type="button" class="btn btn-link view"><i class="fa fa-eye"></i> {{trans('file.View')}}</button>
                                </li>
                                @if(in_array("transfers-edit", $all_permission))
                                <li>
                                    <a href="{{ route('transfers.edit', ['id' => $transfer->id]) }}" class="btn btn-link"><i class="fa fa-edit"></i> {{trans('file.edit')}}</a> 
                                </li>
                                @endif
                                <li class="divider"></li>
                                @if(in_array("transfers-delete", $all_permission))
                                {{ Form::open(['route' => ['transfers.destroy', $transfer->id], 'method' => 'DELETE'] ) }}
                                <li>
                                    <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="fa fa-trash"></i> {{trans('file.delete')}}</button>
                                </li>
                                {{ Form::close() }}
                                @endif
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="tfoot active">
                <th></th>
                <th>{{trans('file.Total')}}</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tfoot>
        </table>
    </div>
</section>

<div id="transfer-details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 id="exampleModalLabel" class="modal-title">{{trans('file.Transfer')}} {{trans('file.Details')}} &nbsp;&nbsp;</h5>
          <button id="print-btn" type="button" class="btn btn-default btn-sm"><i class="fa fa-print"></i> {{trans('file.Print')}}</button>
          <button type="button" id="close-btn" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
        </div>
            <div id="transfer-content" class="modal-body">
            </div>
            <br>
            <table class="table table-bordered product-transfer-list table-responsive">
                <thead>
                    <th>#</th>
                    <th>{{trans('file.product')}}</th>
                    <th>Qty</th>
                    <th>{{trans('file.Unit Cost')}}</th>
                    <th>{{trans('file.Tax')}}</th>
                    <th>{{trans('file.Subtotal')}}</th>
                </thead>
                <tbody>
                </tbody>
            </table>
            <div id="transfer-footer" class="modal-body"></div>
      </div>
    </div>
</div>
<style>
 .mobile-table td[data-title]:before{
	 padding-left:10px;
	 padding-right:10px;
 }
</style>
<script type="text/javascript">
   
	
    $("ul#transfer").siblings('a').attr('aria-expanded','true');
    $("ul#transfer").addClass("show");
    $("ul#transfer li").eq(0).addClass("active");

    function confirmDelete() {
        if (confirm("Are you sure want to delete?")) {
            return true;
        }
        return false;
    }

    $("tr.transfer-link td:not(:first-child, :last-child)").on("click", function(){
        var transfer = $(this).parent().data('transfer');
        transferDetails(transfer);
    });

    $(".view").on("click", function(){
        var transfer = $(this).parent().parent().parent().parent().parent().data('transfer');
        transferDetails(transfer);
    });

    $("#print-btn").on("click", function(){
          var divToPrint=document.getElementById('transfer-details');
          var newWin=window.open('','Print-Window');
          newWin.document.open();
          newWin.document.write('<style type="text/css">@media print { #print-btn { display: none } #close-btn { display: none } }</style><body onload="window.print()">'+divToPrint.innerHTML+'</body>');
          newWin.document.close();
          setTimeout(function(){newWin.close();},10);
    });

    $('#transfer-table').DataTable( {
        "order": [],
        'columnDefs': [
            {
                "orderable": false,
                'targets': [0, 9]
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
                action: function(e, dt, button, config) {
                    datatable_sum(dt, true);
                    $.fn.dataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, button, config);
                    datatable_sum(dt, false);
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
                    datatable_sum(dt, true);
                    $.fn.dataTable.ext.buttons.csvHtml5.action.call(this, e, dt, button, config);
                    datatable_sum(dt, false);
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
                    datatable_sum(dt, true);
                    $.fn.dataTable.ext.buttons.print.action.call(this, e, dt, button, config);
                    datatable_sum(dt, false);
                },
                footer:true
            },
            {
                extend: 'colvis',
                columns: ':gt(0)'
            },
        ],
        drawCallback: function () {
            var api = this.api();
            datatable_sum(api, false);
        }
    } );

    function datatable_sum(dt_selector, is_calling_first) {
        if (dt_selector.rows( '.selected' ).any() && is_calling_first) {
            var rows = dt_selector.rows( '.selected' ).indexes();

            $( dt_selector.column( 5 ).footer() ).html(dt_selector.cells( rows, 5, { page: 'current' } ).data().sum().toFixed(2));
            $( dt_selector.column( 6 ).footer() ).html(dt_selector.cells( rows, 6, { page: 'current' } ).data().sum().toFixed(2));
            $( dt_selector.column( 7 ).footer() ).html(dt_selector.cells( rows, 7, { page: 'current' } ).data().sum().toFixed(2));
        }
        else {
            $( dt_selector.column( 5 ).footer() ).html(dt_selector.cells( rows, 5, { page: 'current' } ).data().sum().toFixed(2));
            $( dt_selector.column( 6 ).footer() ).html(dt_selector.cells( rows, 6, { page: 'current' } ).data().sum().toFixed(2));
            $( dt_selector.column( 7 ).footer() ).html(dt_selector.cells( rows, 7, { page: 'current' } ).data().sum().toFixed(2));
        }
    }

    function transferDetails(transfer){
        var htmltext = '<strong>{{trans("file.Date")}}: </strong>'+transfer[0]+'<br><strong>{{trans("file.reference")}}: </strong>'+transfer[1]+'<br><strong> {{trans("file.Transfer")}} {{trans("file.Status")}}: </strong>'+transfer[2]+'<br><br><div class="row"><div class="col-md-6"><strong>{{trans("file.From")}}:</strong><br>'+transfer[4]+'<br>'+transfer[5]+'<br>'+transfer[6]+'</div><div class="col-md-6"><strong>{{trans("file.To")}}:</strong><br>'+transfer[7]+'<br>'+transfer[8]+'<br>'+transfer[9]+'</div></div>';

        $.get('transfers/product_transfer/' + transfer[3], function(data){
            $(".product-transfer-list tbody").remove();
            var name_code = data[0];
            var qty = data[1];
            var unit = data[2];
            var tax = data[3];
            var tax_rate = data[4];
            var subtotal = data[5];
            var newBody = $("<tbody>");
            $.each(name_code, function(index){
                var newRow = $("<tr>");
                var cols = '';
                cols += '<td><strong>' + (index+1) + '</strong></td>';
                cols += '<td>' + name_code[index] + '</td>';
                cols += '<td>' + qty[index] + ' ' + unit[index] + '</td>';
                cols += '<td>' + (subtotal[index] / qty[index]) + '</td>';
                cols += '<td>' + tax[index] + '(' + tax_rate[index] + '%)' + '</td>';
                cols += '<td>' + subtotal[index] + '</td>';
                newRow.append(cols);
                newBody.append(newRow);
            });

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=4><strong>{{trans("file.Total")}}:</strong></td>';
            cols += '<td>' + transfer[10] + '</td>';
            cols += '<td>' + transfer[11] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=5><strong>{{trans("file.Shipping Cost")}}:</strong></td>';
            cols += '<td>' + transfer[12] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=5><strong>{{trans("file.grand total")}}:</strong></td>';
            cols += '<td>' + transfer[13] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

             $("table.product-transfer-list").append(newBody);
        });

        var htmlfooter = '<p><strong>{{trans("file.Note")}}:</strong> '+transfer[14]+'</p><strong>{{trans("file.Created By")}}:</strong><br>'+transfer[15]+'<br>'+transfer[16];

        $('#transfer-content').html(htmltext);
        $('#transfer-footer').html(htmlfooter);
        $('#transfer-details').modal('show');
    };
	
	
	
	
</script>
@endsection
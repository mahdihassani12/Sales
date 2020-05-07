@extends('layout.main') @section('content')
@if(session()->has('message'))
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div> 
@endif
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div> 
@endif

<section>
    <div class="container-fluid">
      @if(in_array("expenses-add", $all_permission))
        <button class="btn btn-info" data-toggle="modal" data-target="#expense-modal"><i class="fa fa-plus"></i> {{trans('file.add')}} {{trans('file.Expense')}} </button>
      @endif
    </div>
    <div class="table-responsive">
        <table id="expense-table" class="table table-hover">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>{{trans('file.Date')}}</th>
                    <th>{{trans('file.reference')}} No</th>
                    <th>{{trans('file.Store')}}</th>
                    <th>{{trans('file.category')}}</th>
                    <th>{{trans('file.Amount')}}</th>
                    <th>{{trans('file.Note')}}</th>
                    <th class="not-exported">{{trans('file.action')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ezpos_expense_all as $key=>$expense)
                <?php 
                    $store = DB::table('stores')->find($expense->store_id);
                    $expense_category = DB::table('expense_categories')->find($expense->expense_category_id);
                ?>
                <tr>
                    <td>{{$key}}</td>
                    <td>{{ date('d-m-Y', strtotime($expense->date))}}</td>
                    <td>{{ $expense->reference_no }}</td>
                    <td>{{ $store->name }}</td>
                    <td>{{ $expense_category->name }}</td>
                    <td>{{ $expense->amount }}</td>
                    <td>{{ $expense->note }}</td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{trans('file.action')}}
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                @if(in_array("expenses-edit", $all_permission))
                                <li><button type="button" data-id="{{$expense->id}}" class="open-Editexpense_categoryDialog btn btn-link" data-toggle="modal" data-target="#editModal"><i class="fa fa-edit"></i> {{trans('file.edit')}}</button></li>
                                @endif
                                @if(in_array("expenses-delete", $all_permission))
                                <li class="divider"></li>
                                {{ Form::open(['route' => ['expenses.destroy', $expense->id], 'method' => 'DELETE'] ) }}
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
            </tfoot>
        </table>
    </div>
</section>

<div id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="exampleModalLabel" class="modal-title">{{trans('file.update')}} {{trans('file.Expense')}}</h5>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
              <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
                {!! Form::open(['route' => ['expenses.update', 1], 'method' => 'put']) !!}
                <?php 
                  $ezpos_expense_category_list = DB::table('expense_categories')->where('is_active', true)->get();
                  $ezpos_store_list = DB::table('stores')->where('is_active', true)->get();
                ?>
                  <div class="form-group">
                      <input type="hidden" name="expense_id">
                      <label><strong>{{trans('file.reference')}}</strong></label>
                      <p id="reference"></p>
                  </div>
                  <div class="form-group">
                      <label><strong>{{trans('file.date')}} *</strong></label>
                      <input type="text" name="date" required class="form-control date">
                  </div>
                  <div class="form-group">
                      <label><strong>{{trans('file.Expense Category')}} *</strong></label>
                      <select name="expense_category_id" class="selectpicker form-control" required data-live-search="true" data-live-search-style="begins" title="Select Expense Category...">
                          @foreach($ezpos_expense_category_list as $expense_category)
                          <option value="{{$expense_category->id}}">{{$expense_category->name . ' (' . $expense_category->code. ')'}}</option>
                          @endforeach
                      </select>
                  </div>
                  <div class="form-group">
                      <label><strong>{{trans('file.Store')}} *</strong></label>
                      <select name="store_id" class="selectpicker form-control" required data-live-search="true" data-live-search-style="begins" title="Select store...">
                          @foreach($ezpos_store_list as $store)
                          <option value="{{$store->id}}">{{$store->name}}</option>
                          @endforeach
                      </select>
                  </div>
                  <div class="form-group">
                      <label><strong>{{trans('file.Amount')}} *</strong></label>
                      <input type="number" name="amount" step="any" required class="form-control">
                  </div>
                  <div class="form-group">
                      <label><strong>{{trans('file.Note')}}</strong></label>
                      <textarea name="note" rows="5" class="form-control"></textarea>
                  </div>
                  <div class="form-group">
                      <button type="submit" class="btn btn-primary">{{trans('file.submit')}}</button>
                  </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $("ul#expense").siblings('a').attr('aria-expanded','true');
    $("ul#expense").addClass("show");
    $("ul#expense li").eq(1).addClass("active");

    var date = $('.date');
    date.datepicker({
     format: "dd-mm-yyyy",
     startDate: "<?php echo date('d-m-Y', strtotime('')); ?>",
     autoclose: true,
     todayHighlight: true
     });

    $(document).ready(function() {
        $('.open-Editexpense_categoryDialog').on('click', function() {
            var url = "expenses/"
            var id = $(this).data('id').toString();
            url = url.concat(id).concat("/edit");
            $.get(url, function(data) {
                $('#editModal #reference').text(data['reference_no']);
                $('#editModal .date').val(data['date']);
                $("#editModal select[name='store_id']").val(data['store_id']);
                $("#editModal select[name='expense_category_id']").val(data['expense_category_id']);
                $("#editModal input[name='amount']").val(data['amount']);
                $("#editModal input[name='expense_id']").val(data['id']);
                $("#editModal textarea[name='note']").val(data['note']);
                $('.selectpicker').selectpicker('refresh');
            });
        });
    })

function confirmDelete() {
    if (confirm("Are you sure want to delete?")) {
        return true;
    }
    return false;
}

    $('#expense-table').DataTable( {
        "order": [],
        'columnDefs': [
            {
                "orderable": false,
                'targets': [0, 7]
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
        }
        else {
            $( dt_selector.column( 5 ).footer() ).html(dt_selector.cells( rows, 5, { page: 'current' } ).data().sum().toFixed(2));
        }
    }

</script>
@endsection
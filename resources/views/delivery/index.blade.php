@extends('layout.main') @section('content')

@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div> 
@endif
@if(session()->has('message'))
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div> 
@endif

<section>
    <div class="table-responsive">
        <table id="delivery-table" class="table table-hover">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>{{trans('file.date')}}</th>
                    <th>{{trans('file.Delivery')}} {{trans('file.reference')}}</th>
                    <th>{{trans('file.Sale')}} {{trans('file.reference')}}</th>
                    <th>{{trans('file.customer')}}</th>
                    <th>{{trans('file.Address')}}</th>
                    <th>{{trans('file.Status')}}</th>
                    <th class="not-exported">{{trans('file.action')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ezpos_delivery_all as $key=>$delivery)
                <?php 
                    $customer_sale = DB::table('sales')->join('customers', 'sales.customer_id', '=', 'customers.id')->where('sales.id', $delivery->sale_id)->select('sales.reference_no','customers.name')->get();
                    $requestedOrder= DB::table('sales')->where('id',$delivery->sale_id)->get()[0]->request_id;

?>
                <tr>
                    <td>{{$key}}</td>
                    <td>{{ date('d-m-Y', strtotime($delivery->date)) }}</td>
                    <td>{{ $delivery->reference_no }}</td>
                    <td>{{ $customer_sale[0]->reference_no }}</td>
                    @if($requestedOrder != "")
		    <td><span style="width:10px; height:10px; background:#00c500;border-radius:50%"></span> <?php echo DB::table('request')->where('id',$requestedOrder)->get()[0]->customer_name;?></td>
                    @else				
                    <td>{{ $customer_sale[0]->name }}</td>
	            @endif
                    <td>{{ $delivery->address }}</td>
                    @if($delivery->status == 'packing')
                    <td><div class="badge badge-info">{{$delivery->status}}</div></td>
                    @elseif($delivery->status == 'delivering')
                    <td><div class="badge badge-primary">{{$delivery->status}}</div></td>
                    @elseif($delivery->status == 'delivered')
                    <td><div class="badge badge-success">{{$delivery->status}}</div></td>
                    @endif
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{trans('file.action')}}
                              <span class="caret"></span>
                              <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                <li>
                                    <button type="button" data-id="{{$delivery->id}}" class="open-EditCategoryDialog btn btn-link"><i class="fa fa-edit"></i> {{trans('file.edit')}}</button>
                                </li>
                                <li class="divider"></li>
                                {{ Form::open(['route' => ['delivery.delete', $delivery->id], 'method' => 'post'] ) }}
                                <li>
                                  <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="fa fa-trash"></i> {{trans('file.delete')}}</button> 
                                </li>
                                {{ Form::close() }}
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</seaction>

<!-- Modal -->
<div id="edit-delivery" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="exampleModalLabel" class="modal-title">{{trans('file.update')}} {{trans('file.Delivery')}}</h5>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                {!! Form::open(['route' => 'delivery.update', 'method' => 'post', 'files' => true]) !!}
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label><strong>{{trans('file.date')}} *</strong></label>
                        <input type="text" name="date" id="date" class="form-control" value="" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label><strong>{{trans('file.Delivery')}} {{trans('file.reference')}}</strong></label>
                        <p id="dr"></p>
                    </div>
                    <div class="col-md-6 form-group">
                        <label><strong>{{trans('file.Sale')}} {{trans('file.reference')}}</strong></label>
                        <p id="sr"></p>
                    </div>
                    <div class="col-md-6 form-group">
                        <label><strong>{{trans('file.Status')}} *</strong></label>
                        <select name="status" required class="form-control selectpicker">
                            <option value="packing">Packing</option>
                            <option value="delivering">Delivering</option>
                            <option value="delivered">Delivered</option>
                        </select>
                    </div>
                    <div class="col-md-6 mt-2 form-group">
                        <label><strong>{{trans('file.Delivered')}} {{trans('file.By')}}</strong></label>
                         <select name="delivered_by" class="form-control">
				  <?php 
				   $companies=DB::table('company')->get();
				    foreach($companies as $company):
			           ?>
			       <option value="{{$company->company_id}}">{{$company->name}}</option>
			   <?php endforeach; ?>
			</select>		 
                    </div>
                    <div class="col-md-6 mt-2 form-group">
                        <label><strong>{{trans('file.Recieved')}} {{trans('file.By')}}</strong></label>
                        <input type="text" name="recieved_by" class="form-control">
                    </div>
                    <div class="col-md-6 form-group">
                        <label><strong>{{trans('file.customer')}}</strong></label>
                        <p id="customer"></p>
                    </div>
                    <div class="col-md-6 form-group">
                        <label><strong>{{trans('file.Attach File')}}</strong></label>
                        <input type="file" name="file" class="form-control">
                    </div>
                    <div class="col-md-6 form-group">
                        <label><strong>{{trans('file.Address')}} *</strong></label>
                        <textarea rows="3" name="address" class="form-control" required></textarea>
                    </div>
                    <div class="col-md-6 form-group">
                        <label><strong>{{trans('file.Note')}}</strong></label>
                        <textarea rows="3" name="note" class="form-control"></textarea>
                    </div>
                </div>
                <input type="hidden" name="reference_no">
                <input type="hidden" name="delivery_id">
                <button type="submit" class="btn btn-primary">{{trans('file.submit')}}</button>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $("ul#sale").siblings('a').attr('aria-expanded','true');
    $("ul#sale").addClass("show");
    $("ul#sale li").eq(3).addClass("active");

    var date = $('#date');
    date.datepicker({
     format: "dd-mm-yyyy",
     startDate: "<?php echo date('d-m-Y', strtotime('')); ?>",
     autoclose: true,
     todayHighlight: true
     });


    function confirmDelete() {
      if (confirm("Are you sure want to delete?")) {
          return true;
      }
      return false;
    }
$(document).ready(function() {
    $('.open-EditCategoryDialog').on('click', function(){
      var url ="delivery/"  
      var id = $(this).data('id').toString();
      url = url.concat(id).concat("/edit");
      
      $.get(url, function(data){
            $('#dr').text(data[0]);
            $('#sr').text(data[1]);
            $('select[name="status"]').val(data[2]);
            $('.selectpicker').selectpicker('refresh');
            $('select[name="delivered_by"]').val(data[3]);
            $('input[name="recieved_by"]').val(data[4]);
            $('#customer').text(data[5]);
            $('textarea[name="address"]').val(data[6]);
            $('textarea[name="note"]').val(data[7]);
            $('#edit-delivery input[name="date"]').val(data[8]);
            $('input[name="reference_no"]').val(data[0]);
            $('input[name="delivery_id"]').val(id);
      });
      $("#edit-delivery").modal('show');
    });
});

    $('#delivery-table').DataTable( {
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
            },
        ],
    } );
</script>
@endsection
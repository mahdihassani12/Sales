 <?php $__env->startSection('content'); ?>
<?php if(session()->has('message')): ?>
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message')); ?></div> 
<?php endif; ?>
<?php if(session()->has('not_permitted')): ?>
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('not_permitted')); ?></div> 
<?php endif; ?>

<section>
    <div class="container-fluid">
        <?php if(in_array("purchases-add", $all_permission)): ?>
            <a href="<?php echo e(route('purchase.create')); ?>" class="btn btn-info"><i class="fa fa-plus"></i> <?php echo e(trans('file.add')); ?> <?php echo e(trans('file.Purchase')); ?></a>
        <?php endif; ?>
    </div>
    <div class="table-responsive">
        <table id="purchase-table" class="table table-hover purchase-list">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th><?php echo e(trans('file.Date')); ?></th>
                    <th><?php echo e(trans('file.reference')); ?> No</th>
                    <th><?php echo e(trans('file.Supplier')); ?></th>
                    <th><?php echo e(trans('file.Purchase')); ?> <?php echo e(trans('file.status')); ?></th>
                    <th><?php echo e(trans('file.grand total')); ?></th>
                    <th><?php echo e(trans('file.Paid')); ?></th>
                    <th><?php echo e(trans('file.Balance')); ?></th>
                    <th><?php echo e(trans('file.Payment')); ?> <?php echo e(trans('file.status')); ?></th>
                    <th class="not-exported"><?php echo e(trans('file.action')); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $ezpos_purchase_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$purchase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $supplier = DB::table('suppliers')->find($purchase->supplier_id);
                    $date =  date('d-m-Y', strtotime($purchase->date));
                    if(!$supplier){
                        $supplier = new App\Supplier();
                        $supplier->name = $supplier->company_name = $supplier->email = $supplier->phone_number = $supplier->address = $supplier->city = '';
                    }
                    $store = DB::table('stores')->find($purchase->store_id);
                    $user = DB::table('users')->find($purchase->user_id);
                    if($purchase->status == 1)
                        $status = 'Recieved';
                    elseif($purchase->status == 2)
                        $status = 'Partial';
                    elseif($purchase->status == 3)
                        $status = 'Pending';
                    else
                        $status = 'Ordered';

                    $replace = Array(
                        '\\' => '',
                        '"' => '\"'
                    );

                    $purchase->note = str_replace(array_keys($replace), $replace, $purchase->note);
                    $purchase->note = preg_replace('/\r\n+/', "<br>", $purchase->note);
                ?>
                <tr class="purchase-link" data-purchase='["<?php echo e($date); ?>", "<?php echo e($purchase->reference_no); ?>", "<?php echo e($status); ?>", "<?php echo e($purchase->id); ?>", "<?php echo e($store->name); ?>", "<?php echo e($store->phone); ?>", "<?php echo e($store->address); ?>", "<?php echo e($supplier->name); ?>", "<?php echo e($supplier->company_name); ?>","<?php echo e($supplier->email); ?>", "<?php echo e($supplier->phone_number); ?>", "<?php echo e($supplier->address); ?>", "<?php echo e($supplier->city); ?>", "<?php echo e($purchase->total_tax); ?>", "<?php echo e($purchase->total_discount); ?>", "<?php echo e($purchase->total_cost); ?>", "<?php echo e($purchase->order_tax); ?>", "<?php echo e($purchase->order_tax_rate); ?>", "<?php echo e($purchase->order_discount); ?>", "<?php echo e($purchase->shipping_cost); ?>", "<?php echo e($purchase->grand_total); ?>", "<?php echo e($purchase->paid_amount); ?>", "<?php echo e($purchase->note); ?>", "<?php echo e($user->name); ?>", "<?php echo e($user->email); ?>"]'>
                    <td><?php echo e($key); ?></td>
                    <td><?php echo e($date); ?></td>
                    <td><?php echo e($purchase->reference_no); ?></td>
                    <?php if($supplier->name): ?>
                    <td><?php echo e($supplier->name); ?></td>
                    <?php else: ?>
                    <td>N/A</td>
                    <?php endif; ?>
                    <?php if($purchase->status == 1): ?>
                        <td><div class="badge badge-success">Recieved</div></td>
                    <?php elseif($purchase->status == 2): ?>
                        <td><div class="badge badge-success">Partial</div></td>
                    <?php elseif($purchase->status == 3): ?>
                        <td><div class="badge badge-danger">Pending</div></td>
                    <?php else: ?>
                        <td><div class="badge badge-danger">Ordered</div></td>
                    <?php endif; ?>
                    <td class="grand-total"><?php echo e($purchase->grand_total); ?></td>
                    <?php if($purchase->paid_amount): ?>
                    <td class="paid-amount"><?php echo e($purchase->paid_amount); ?></td>
                    <?php else: ?>
                    <td>0.00</td>
                    <?php endif; ?>
                    <?php if($purchase->grand_total - $purchase->paid_amount): ?>
                    <td class="balance"><?php echo e($purchase->grand_total - $purchase->paid_amount); ?></td>
                    <?php else: ?>
                    <td>0.00</td>
                    <?php endif; ?>
                    <?php if($purchase->payment_status == 1): ?>
                        <td>Due</td>
                    <?php elseif($purchase->payment_status == 2): ?>
                        <td>Paid</td>
                    <?php endif; ?>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo e(trans('file.action')); ?>

                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                <li>
                                    <button type="button" class="btn btn-link view"><i class="fa fa-eye"></i> <?php echo e(trans('file.View')); ?></button>
                                </li>
                                <?php if(in_array("purchases-edit", $all_permission)): ?>
                                <li>
                                    <a href="<?php echo e(route('purchase.edit', ['id' => $purchase->id])); ?>" class="btn btn-link"><i class="fa fa-edit"></i> <?php echo e(trans('file.edit')); ?></a> 
                                </li>
                                <?php endif; ?>
                                <li>
                                    <button type="button" class="add-payment btn btn-link" data-id = "<?php echo e($purchase->id); ?>" data-toggle="modal" data-target="#add-payment"><i class="fa fa-plus"></i> <?php echo e(trans('file.add')); ?> <?php echo e(trans('file.Payment')); ?></button>
                                </li>
                                <li>
                                    <button type="button" class="get-payment btn btn-link" data-id = "<?php echo e($purchase->id); ?>"><i class="fa fa-money"></i> <?php echo e(trans('file.View')); ?> <?php echo e(trans('file.Payment')); ?></button>
                                </li>
                                <?php if(in_array("purchases-delete", $all_permission)): ?>
                                <?php echo e(Form::open(['route' => ['purchase.destroy', $purchase->id], 'method' => 'DELETE'] )); ?>

                                <li>
                                    <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="fa fa-trash"></i> <?php echo e(trans('file.delete')); ?></button>
                                </li>
                                <?php echo e(Form::close()); ?>

                                <?php endif; ?>
                            </ul>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
            <tfoot class="tfoot active">
                <th></th>
                <th><?php echo e(trans('file.Total')); ?></th>
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

<div id="purchase-details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 id="exampleModalLabel" class="modal-title"><?php echo e(trans('file.Purchase')); ?> <?php echo e(trans('file.Details')); ?> &nbsp;&nbsp;</h5>
          <button id="print-btn" type="button" class="btn btn-default btn-sm"><i class="fa fa-print"></i> <?php echo e(trans('file.Print')); ?></button>
          <button type="button" id="close-btn" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
        </div>
            <div id="purchase-content" class="modal-body"></div>
            <br>
            <table class="table table-bordered product-purchase-list">
                <thead>
                    <th>#</th>
                    <th><?php echo e(trans('file.product')); ?></th>
                    <th>Qty</th>
                    <th><?php echo e(trans('file.Unit Cost')); ?></th>
                    <th><?php echo e(trans('file.Tax')); ?></th>
                    <th><?php echo e(trans('file.Discount')); ?></th>
                    <th><?php echo e(trans('file.Subtotal')); ?></th>
                </thead>
                <tbody>
                </tbody>
            </table>
            <div id="purchase-footer" class="modal-body"></div>
      </div>
    </div>
</div>

<div id="view-payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="exampleModalLabel" class="modal-title"><?php echo e(trans('file.All')); ?> <?php echo e(trans('file.Payment')); ?></h5>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <table class="table table-hover payment-list">
                    <thead>
                        <tr>
                            <th><?php echo e(trans('file.date')); ?></th>
                            <th><?php echo e(trans('file.reference')); ?> No</th>
                            <th><?php echo e(trans('file.Amount')); ?></th>
                            <th><?php echo e(trans('file.Paid')); ?> <?php echo e(trans('file.By')); ?></th>
                            <th><?php echo e(trans('file.action')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="add-payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="exampleModalLabel" class="modal-title"><?php echo e(trans('file.add')); ?> <?php echo e(trans('file.Payment')); ?></h5>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <?php echo Form::open(['route' => 'purchase.add-payment', 'method' => 'post', 'files' => true, 'class' => 'payment-form' ]); ?>

                    <div class="form-group">
                        <label><strong><?php echo e(trans('file.date')); ?></strong></label>
                        <input type="text" name="date" class="form-control date" value="<?php echo e(date('d-m-Y')); ?>" required>
                    </div>
                    <div class="form-group">
                        <label><strong><?php echo e(trans('file.reference')); ?> No</strong></label>
                        <p><?php echo e('ppr-' . date("Ymd") . '-'. date("his")); ?></p>
                    </div>
                    <div class="form-group">
                        <label><strong><?php echo e(trans('file.Amount')); ?> *</strong></label>
                        <input type="number" name="amount" class="form-control" step="any" required>
                    </div>
                    <div class="form-group">
                        <label><strong><?php echo e(trans('file.Paid')); ?> <?php echo e(trans('file.By')); ?></strong></label>
                        <select name="paid_by_id" class="form-control selectpicker">
                            <option value="1">Cash</option>
                            <option value="3">Credit Card</option>
                            <option value="4">Cheque</option>
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <div class="card-element" class="form-control">
                        </div>
                        <div class="card-errors" role="alert"></div>
                    </div>
                    <div id="cheque">
                        <div class="form-group">
                            <label><strong><?php echo e(trans('file.Cheque')); ?> No</strong></label>
                            <input type="text" name="cheque_no" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label><strong><?php echo e(trans('file.Payment')); ?> <?php echo e(trans('file.Note')); ?></strong></label>
                        <textarea rows="5" class="form-control" name="payment_note"></textarea>
                    </div>

                    <input type="hidden" name="purchase_id">

                    <button type="submit" class="btn btn-primary"><?php echo e(trans('file.submit')); ?></button>
                <?php echo e(Form::close()); ?>

            </div>
        </div>
    </div>
</div>

<div id="edit-payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="exampleModalLabel" class="modal-title"><?php echo e(trans('file.update')); ?> <?php echo e(trans('file.Payment')); ?></h5>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <?php echo Form::open(['route' => 'purchase.update-payment', 'method' => 'post', 'class' => 'payment-form' ]); ?>

                    <div class="form-group">
                        <label><strong><?php echo e(trans('file.date')); ?></strong></label>
                        <input type="text" name="date" class="form-control date" required>
                    </div>

                    <div class="form-group">
                        <label><strong><?php echo e(trans('file.reference')); ?> No</strong></label>
                        <p id="payment_reference"></p>
                    </div>

                    <div class="form-group">
                        <label><strong><?php echo e(trans('file.Amount')); ?></strong></label>
                        <input type="number" name="edit_amount" class="form-control" required step="any">
                    </div>

                    <div class="form-group">
                        <label><strong><?php echo e(trans('file.Paid')); ?> <?php echo e(trans('file.By')); ?></strong></label>
                        <select name="edit_paid_by_id" class="form-control selectpicker">
                            <option value="1">Cash</option>
                            <option value="3">Credit Card</option>
                            <option value="4">Cheque</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="card-element" class="form-control">
                        </div>
                        <div class="card-errors" role="alert"></div>
                    </div>
                    <div id="edit-cheque">
                        <div class="form-group">
                            <label><strong><?php echo e(trans('file.Cheque')); ?> No</strong></label>
                            <input type="text" name="edit_cheque_no" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label><strong><?php echo e(trans('file.Payment')); ?> <?php echo e(trans('file.Note')); ?></strong></label>
                        <textarea rows="5" class="form-control" name="edit_payment_note"></textarea>
                    </div>

                    <input type="hidden" name="payment_id">

                    <button type="submit" class="btn btn-primary"><?php echo e(trans('file.update')); ?></button>
                <?php echo e(Form::close()); ?>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    var public_key = <?php echo json_encode($ezpos_pos_setting_data->stripe_public_key); ?>;

    $("ul#purchase").siblings('a').attr('aria-expanded','true');
    $("ul#purchase").addClass("show");
    $("ul#purchase li").eq(0).addClass("active");

    var date = $('.date');
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

    $("tr.purchase-link td:not(:first-child, :last-child)").on("click", function(){
        var purchase = $(this).parent().data('purchase');
        purchaseDetails(purchase);
    });

    $(".view").on("click", function(){
        var purchase = $(this).parent().parent().parent().parent().parent().data('purchase');
        purchaseDetails(purchase);
    });

    $("#print-btn").on("click", function(){
          var divToPrint=document.getElementById('purchase-details');
          var newWin=window.open('','Print-Window');
          newWin.document.open();
          newWin.document.write('<style type="text/css">@media  print { #print-btn { display: none } #close-btn { display: none } }</style><body onload="window.print()">'+divToPrint.innerHTML+'</body>');
          newWin.document.close();
          setTimeout(function(){newWin.close();},10);
    });

    $("table.purchase-list tbody").on("click", ".add-payment", function(event) {
        $("#cheque").hide();
        $(".card-element").hide();
        $('select[name="paid_by_id"]').val(1);
        rowindex = $(this).closest('tr').index();
        var purchase_id = $(this).data('id').toString();
        var balance = $('table.purchase-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(8)').text();
        $('input[name="amount"]').val(balance);
        $('input[name="purchase_id"]').val(purchase_id);
    });

    $("table.purchase-list tbody").on("click", ".get-payment", function(event) {
        var id = $(this).data('id').toString();
        $.get('purchase/getpayment/' + id, function(data) {
            $(".payment-list tbody").remove();
            var newBody = $("<tbody>");
            payment_date  = data[0];
            payment_reference = data[1];
            paid_amount = data[2];
            paying_method = data[3];
            payment_id = data[4];
            payment_note = data[5];
            cheque_no = data[6];

            $.each(payment_date, function(index){
                var newRow = $("<tr>");
                var cols = '';

                cols += '<td>' + payment_date[index] + '</td>';
                cols += '<td>' + payment_reference[index] + '</td>';
                cols += '<td>' + paid_amount[index] + '</td>';
                cols += '<td>' + paying_method[index] + '</td>';
                cols += '<td><div class="btn-group"><button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button><ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu"><li><button type="button" class="btn btn-link edit-btn" data-id="' + payment_id[index] +'" data-clicked=false data-toggle="modal" data-target="#edit-payment"><i class="fa fa-edit"></i> Edit</button></li><li class="divider"></li><?php echo e(Form::open(['route' => 'purchase.delete-payment', 'method' => 'post'] )); ?><li><input type="hidden" name="id" value="' + payment_id[index] + '" /> <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="fa fa-trash"></i> Delete</button></li><?php echo e(Form::close()); ?></ul></div></td>'
                newRow.append(cols);
                newBody.append(newRow);
                $("table.payment-list").append(newBody);
            });
            $('#view-payment').modal('show');
        });
    });

    $("table.payment-list").on("click", ".edit-btn", function(event) {
        $(".edit-btn").attr('data-clicked', true);        
        $(".card-element").hide();
        $("#edit-cheque").hide();
        $('#edit-payment select[name="edit_paid_by_id"]').prop('disabled', false);
        var id = $(this).data('id').toString();
        $.each(payment_id, function(index){
            if(payment_id[index] == parseFloat(id)){
                $('#edit-payment input[name="date"]').val(payment_date[index]);
                $('input[name="payment_id"]').val(payment_id[index]);
                if(paying_method[index] == 'Cash')
                    $('select[name="edit_paid_by_id"]').val(1);
                else if(paying_method[index] == 'Gift Card')
                    $('select[name="edit_paid_by_id"]').val(2);
                else if(paying_method[index] == 'Credit Card'){
                    $('select[name="edit_paid_by_id"]').val(3);
                    $.getScript( "public/vendor/stripe/checkout.js" );
                    $(".card-element").show();
                    $("#edit-cheque").hide();
                    $('#edit-payment select[name="edit_paid_by_id"]').prop('disabled', true);
                }
                else{
                    $('select[name="edit_paid_by_id"]').val(4);
                    $("#edit-cheque").show();
                    $('input[name="edit_cheque_no"]').val(cheque_no[index]);
                }
                $('input[name="edit_date"]').val(payment_date[index]);
                $("#payment_reference").html(payment_reference[index]);
                $('input[name="edit_amount"]').val(paid_amount[index]);
                $('textarea[name="edit_payment_note"]').val(payment_note[index]);
                return false;
            }
        });
        $('.selectpicker').selectpicker('refresh');
        $('#view-payment').modal('hide');
    });

    $('select[name="paid_by_id"]').on("change", function() {        
        var id = $('select[name="paid_by_id"]').val();
        $(".payment-form").off("submit");
        if (id == 3) {
            $.getScript( "public/vendor/stripe/checkout.js" );
            $(".card-element").show();
            $("#cheque").hide();
        } else if (id == 4) {
            $("#cheque").show();
            $(".card-element").hide();
        } else {
            $(".card-element").hide();
            $("#cheque").hide();
        }
    });

    $('select[name="edit_paid_by_id"]').on("change", function() {        
        var id = $('select[name="edit_paid_by_id"]').val();
        $(".payment-form").off("submit");
        if (id == 3) {
            $(".edit-btn").attr('data-clicked', true);
            $.getScript( "public/vendor/stripe/checkout.js" );
            $(".card-element").show();
            $("#edit-cheque").hide();
        } else if (id == 4) {
            $("#edit-cheque").show();
            $(".card-element").hide();
        } else {
            $(".card-element").hide();
            $("#edit-cheque").hide();
        }
    });

    $('#purchase-table').DataTable( {
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
                    columns: ':visible:not(.not-exported)',
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
                    columns: ':visible:not(.not-exported)',
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
            $( dt_selector.column( 5 ).footer() ).html(dt_selector.column( 5, {page:'current'} ).data().sum().toFixed(2));
            $( dt_selector.column( 6 ).footer() ).html(dt_selector.column( 6, {page:'current'} ).data().sum().toFixed(2));
            $( dt_selector.column( 7 ).footer() ).html(dt_selector.column( 7, {page:'current'} ).data().sum().toFixed(2));
        }
    }

    function purchaseDetails(purchase){
        var htmltext = '<strong><?php echo e(trans("file.Date")); ?>: </strong>'+purchase[0]+'<br><strong><?php echo e(trans("file.reference")); ?>: </strong>'+purchase[1]+'<br><strong><?php echo e(trans("file.Purchase")); ?> <?php echo e(trans("file.Status")); ?>: </strong>'+purchase[2]+'<br><br><div class="row"><div class="col-md-6"><strong><?php echo e(trans("file.From")); ?>:</strong><br>'+purchase[4]+'<br>'+purchase[5]+'<br>'+purchase[6]+'</div><div class="col-md-6"><strong><?php echo e(trans("file.To")); ?>:</strong><br>'+purchase[7]+'<br>'+purchase[8]+'<br>'+purchase[9]+'<br>'+purchase[10]+'<br>'+purchase[11]+'<br>'+purchase[12]+'</div></div>';

        $.get('purchase/product_purchase/' + purchase[3], function(data){
            $(".product-purchase-list tbody").remove();
            var name_code = data[0];
            var qty = data[1];
            var unit_code = data[2];
            var tax = data[3];
            var tax_rate = data[4];
            var discount = data[5];
            var subtotal = data[6];
            var newBody = $("<tbody>");
            $.each(name_code, function(index){
                var newRow = $("<tr>");
                var cols = '';
                cols += '<td><strong>' + (index+1) + '</strong></td>';
                cols += '<td>' + name_code[index] + '</td>';
                cols += '<td>' + qty[index] + ' ' + unit_code[index] + '</td>';
                cols += '<td>' + (subtotal[index] / qty[index]) + '</td>';
                cols += '<td>' + tax[index] + '(' + tax_rate[index] + '%)' + '</td>';
                cols += '<td>' + discount[index] + '</td>';
                cols += '<td>' + subtotal[index] + '</td>';
                newRow.append(cols);
                newBody.append(newRow);
            });

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=4><strong><?php echo e(trans("file.Total")); ?>:</strong></td>';
            cols += '<td>' + purchase[13] + '</td>';
            cols += '<td>' + purchase[14] + '</td>';
            cols += '<td>' + purchase[15] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=6><strong><?php echo e(trans("file.Order")); ?> <?php echo e(trans("file.Tax")); ?>:</strong></td>';
            cols += '<td>' + purchase[16] + '(' + purchase[17] + '%)' + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=6><strong><?php echo e(trans("file.Order")); ?> <?php echo e(trans("file.Discount")); ?>:</strong></td>';
            cols += '<td>' + purchase[18] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=6><strong><?php echo e(trans("file.Shipping Cost")); ?>:</strong></td>';
            cols += '<td>' + purchase[19] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=6><strong><?php echo e(trans("file.grand total")); ?>:</strong></td>';
            cols += '<td>' + purchase[20] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=6><strong><?php echo e(trans("file.Paid")); ?> <?php echo e(trans("file.Amount")); ?>:</strong></td>';
            cols += '<td>' + purchase[21] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=6><strong><?php echo e(trans("file.Balance")); ?>:</strong></td>';
            cols += '<td>' + (purchase[20] - purchase[21]) + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

             $("table.product-purchase-list").append(newBody);
        });

        var htmlfooter = '<p><strong><?php echo e(trans("file.Note")); ?>:</strong> '+purchase[22]+'</p><strong><?php echo e(trans("file.Created By")); ?>:</strong><br>'+purchase[23]+'<br>'+purchase[24];

        $('#purchase-content').html(htmltext);
        $('#purchase-footer').html(htmlfooter);
        $('#purchase-details').modal('show');
    }
</script>
<?php $__env->stopSection(); ?> <?php $__env->startSection('scripts'); ?>
<script type="text/javascript" src="https://js.stripe.com/v3/"></script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
 <?php $__env->startSection('content'); ?>

<section>
    <h4 class="text-center"><?php echo e(trans('file.Due')); ?> <?php echo e(trans('file.Report')); ?></h4>
    <?php echo Form::open(['route' => 'report.dueByDate', 'method' => 'post']); ?>

    <div class="col-md-6 offset-md-3 mt-4">
        <div class="form-group row">
            <label class="d-tc mt-2"><strong><?php echo e(trans('file.Choose Your Date')); ?></strong> &nbsp;</label>
            <div class="d-tc">
                <div class="input-group">
                    <input type="text" class="daterangepicker-field form-control" value="<?php echo e(date('d-m-Y', strtotime($start_date))); ?> to <?php echo e(date('d-m-Y', strtotime($end_date))); ?>" required />
                    <input type="hidden" name="start_date" value="<?php echo e($start_date); ?>" />
                    <input type="hidden" name="end_date" value="<?php echo e($end_date); ?>" />
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit"><?php echo e(trans('file.submit')); ?></button>
                    </div>
                </div>
            </div>
        </div> 
    </div>
    <?php echo Form::close(); ?>

    <div class="table-responsive">
        <table id="report-table" class="table table-hover">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th><?php echo e(trans('file.Date')); ?></th>
                    <th><?php echo e(trans('file.Bill')); ?> No</th>
                    <th><?php echo e(trans('file.customer')); ?> <?php echo e(trans('file.Details')); ?> </th>
                    <th><?php echo e(trans('file.Paid')); ?></th>
                    <th><?php echo e(trans('file.Due')); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $ezpos_sale_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$sale_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($key); ?></td>
                    <td><?php echo e(date('d-m-Y', strtotime($sale_data->date))); ?></td>
                    <td><?php echo e($sale_data->reference_no); ?></td>
                    <?php
                        $customer = DB::table('customers')->find($sale_data->customer_id);
                    ?>
                    <td><?php echo e($customer->name .' (' .$customer->phone_number . ')'); ?></td>
                    <?php if($sale_data->paid_amount): ?>
                    <td><?php echo e(number_format((float)$sale_data->paid_amount, 2, '.', '')); ?></td>
                    <?php else: ?>
                    <td>0.00</td>
                    <?php endif; ?>
                    <td><?php echo e(number_format((float)($sale_data->grand_total - $sale_data->paid_amount), 2, '.', '')); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
            <tfoot class="tfoot active">
                <th></th>
                <th><?php echo e(trans('file.Total')); ?>:</th>
                <th></th>
                <th></th>
                <th>0.00</th>
                <th>0.00</th>
            </tfoot>
        </table>
    </div>
</section>


<script type="text/javascript">

    $("ul#report").siblings('a').attr('aria-expanded','true');
    $("ul#report").addClass("show");
    $("ul#report li").eq(13).addClass("active");

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
            }
        ],
        drawCallback: function () {
            var api = this.api();
            datatable_sum(api, false);
        }
    } );

    function datatable_sum(dt_selector, is_calling_first) {
        if (dt_selector.rows( '.selected' ).any() && is_calling_first) {
            var rows = dt_selector.rows( '.selected' ).indexes();

            $( dt_selector.column( 4 ).footer() ).html(dt_selector.cells( rows, 4, { page: 'current' } ).data().sum().toFixed(2));
            $( dt_selector.column( 5 ).footer() ).html(dt_selector.cells( rows, 5, { page: 'current' } ).data().sum().toFixed(2));
        }
        else {
            $( dt_selector.column( 4 ).footer() ).html(dt_selector.column( 4, {page:'current'} ).data().sum().toFixed(2));
            $( dt_selector.column( 5 ).footer() ).html(dt_selector.column( 5, {page:'current'} ).data().sum().toFixed(2));
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
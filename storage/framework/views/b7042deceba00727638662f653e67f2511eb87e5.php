 <?php $__env->startSection('content'); ?>
<?php if(empty($product_name)): ?>
<div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e('No Data exist between this date range!'); ?></div>
<?php endif; ?>
<?php if(session()->has('not_permitted')): ?>
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('not_permitted')); ?></div> 
<?php endif; ?>

<section>
    <h4 class="text-center"><?php echo e(trans('file.product')); ?> <?php echo e(trans('file.Report')); ?></h4>
    <?php echo Form::open(['route' => 'report.product', 'method' => 'post']); ?>

    <div class="row">
        <div class="col-md-4 offset-md-1 mt-4">
            <div class="form-group row">
                <label class="d-tc mt-2"><strong><?php echo e(trans('file.Choose Your Date')); ?></strong> &nbsp;</label>
                <div class="d-tc">
                    <div class="input-group">
                        <input type="text" class="daterangepicker-field form-control" value="<?php echo e(date('d-m-Y', strtotime($start_date))); ?> to <?php echo e(date('d-m-Y', strtotime($end_date))); ?>" required />
                        <input type="hidden" name="start_date" value="<?php echo e($start_date); ?>" />
                        <input type="hidden" name="end_date" value="<?php echo e($end_date); ?>" />
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-4">
            <div class="form-group row">
                <label class="d-tc mt-2"><strong><?php echo e(trans('file.Choose Store')); ?></strong> &nbsp;</label>
                <div class="d-tc">
                    <input type="hidden" name="store_id_hidden" value="<?php echo e($store_id); ?>" />
                    <select id="store_id" name="store_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" >
                        <option value="0"><?php echo e(trans('file.All')); ?> <?php echo e(trans('file.Store')); ?></option>
                        <?php $__currentLoopData = $ezpos_store_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($store->id); ?>"><?php echo e($store->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-3 mt-4">
            <div class="form-group">
                <button class="btn btn-primary" type="submit"><?php echo e(trans('file.submit')); ?></button>
            </div>
        </div>
    </div>
    <?php echo Form::close(); ?>

    <div class="table-responsive">
        <table id="report-table" class="table table-hover">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th><?php echo e(trans('file.product')); ?> <?php echo e(trans('file.name')); ?></th>
                    <th><?php echo e(trans('file.Purchased')); ?> <?php echo e(trans('file.Amount')); ?></th>
                    <th><?php echo e(trans('file.Purchased')); ?> Qty</th>
                    <th><?php echo e(trans('file.Sold')); ?> <?php echo e(trans('file.Amount')); ?></th>
                    <th><?php echo e(trans('file.Sold')); ?> Qty</th>
                    <th><?php echo e(trans('file.profit')); ?></th>
                    <th><?php echo e(trans('file.In Stock')); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($product_name)): ?>
                <?php $__currentLoopData = $product_id; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $pro_id): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($key); ?></td>
                    <td><?php echo e($product_name[$key]); ?></td>
                    <?php
                        if($store_id == 0){
                            $purchased_cost = DB::table('purchases')
                            ->join('product_purchases', 'purchases.id', '=', 'product_purchases.purchase_id')->where('product_purchases.product_id', $pro_id)->whereDate('purchases.date', '>=', $start_date)->whereDate('purchases.date', '<=' , $end_date)->sum('product_purchases.total');

                            $sold_price = DB::table('sales')
                            ->join('product_sales', 'sales.id', '=', 'product_sales.sale_id')->where('product_sales.product_id', $pro_id)->whereDate('sales.date', '>=', $start_date)->whereDate('sales.date', '<=' , $end_date)->sum('product_sales.total');

                            $purchased_qty = DB::table('purchases')
                            ->join('product_purchases', 'purchases.id', '=', 'product_purchases.purchase_id')->where('product_purchases.product_id', $pro_id)->whereDate('purchases.date','>=', $start_date)->whereDate('purchases.date','<=', $end_date)->sum('product_purchases.qty');

                            $sold_qty = DB::table('sales')
                            ->join('product_sales', 'sales.id', '=', 'product_sales.sale_id')->where('product_sales.product_id', $pro_id)->whereDate('sales.date','>=', $start_date)->whereDate('sales.date','<=', $end_date)->sum('product_sales.qty');
                        }
                        else{
                            $purchased_cost = DB::table('purchases')
                                ->join('product_purchases', 'purchases.id', '=', 'product_purchases.purchase_id')->where([
                                    ['product_purchases.product_id', $pro_id],
                                    ['purchases.store_id', $store_id]
                                ])->whereDate('purchases.date','>=', $start_date)->whereDate('purchases.date','<=', $end_date)->sum('total');

                            $sold_price = DB::table('sales')
                                ->join('product_sales', 'sales.id', '=', 'product_sales.sale_id')->where([
                                    ['product_sales.product_id', $pro_id],
                                    ['sales.store_id', $store_id]
                                ])->whereDate('sales.date','>=', $start_date)->whereDate('sales.date','<=', $end_date)->sum('total');

                            $purchased_qty = DB::table('purchases')
                                ->join('product_purchases', 'purchases.id', '=', 'product_purchases.purchase_id')->where([
                                    ['product_purchases.product_id', $pro_id],
                                    ['purchases.store_id', $store_id]
                                ])->whereDate('purchases.date','>=', $start_date)->whereDate('purchases.date','<=', $end_date)->sum('product_purchases.qty');

                            $sold_qty = DB::table('sales')
                                ->join('product_sales', 'sales.id', '=', 'product_sales.sale_id')->where([
                                    ['product_sales.product_id', $pro_id],
                                    ['sales.store_id', $store_id]
                                ])->whereDate('sales.date','>=', $start_date)->whereDate('sales.date','<=', $end_date)->sum('product_sales.qty');
                        }

                        if($purchased_qty > 0)
                            $profit = $sold_price - (($purchased_cost / $purchased_qty) * $sold_qty);
                        else
                           $profit =  $sold_price;
                    ?>
                    <td><?php echo e(number_format((float)$purchased_cost, 2, '.', '')); ?></td>
                    <td><?php echo e($purchased_qty); ?></td>
                    <td><?php echo e(number_format((float)$sold_price, 2, '.', '')); ?></td>
                    <td><?php echo e($sold_qty); ?></td>
                    <td><?php echo e(number_format((float)$profit, 2, '.', '')); ?></td>
                    <td><?php echo e($product_qty[$key]); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </tbody>
            <tfoot>
                <th></th>
            	<th>Total</th>
            	<th>0.00</th>
                <th>0.00</th>
            	<th>0.00</th>
                <th>0.00</th>
            	<th>0.00</th>
            	<th>0.00</th>
            </tfoot>
        </table>
    </div>
</section>


<script type="text/javascript">

    $("ul#report").siblings('a').attr('aria-expanded','true');
    $("ul#report").addClass("show");
    $("ul#report li").eq(2).addClass("active");

    $('#store_id').val($('input[name="store_id_hidden"]').val());
    $('.selectpicker').selectpicker('refresh');

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
                    columns: ':visible:not(.not-exported)',
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

            $( dt_selector.column( 2 ).footer() ).html(dt_selector.cells( rows, 2, { page: 'current' } ).data().sum().toFixed(2));
            $( dt_selector.column( 3 ).footer() ).html(dt_selector.cells( rows, 3, { page: 'current' } ).data().sum());
            $( dt_selector.column( 4 ).footer() ).html(dt_selector.cells( rows, 4, { page: 'current' } ).data().sum().toFixed(2));
            $( dt_selector.column( 5 ).footer() ).html(dt_selector.cells( rows, 5, { page: 'current' } ).data().sum());
            $( dt_selector.column( 6 ).footer() ).html(dt_selector.cells( rows, 6, { page: 'current' } ).data().sum().toFixed(2));
            $( dt_selector.column( 7 ).footer() ).html(dt_selector.cells( rows, 7, { page: 'current' } ).data().sum());
        }
        else {
            $( dt_selector.column( 2 ).footer() ).html(dt_selector.column( 2, {page:'current'} ).data().sum().toFixed(2));
            $( dt_selector.column( 3 ).footer() ).html(dt_selector.column( 3, {page:'current'} ).data().sum());
            $( dt_selector.column( 4 ).footer() ).html(dt_selector.column( 4, {page:'current'} ).data().sum().toFixed(2));
            $( dt_selector.column( 5 ).footer() ).html(dt_selector.column( 5, {page:'current'} ).data().sum());
            $( dt_selector.column( 6 ).footer() ).html(dt_selector.column( 6, {page:'current'} ).data().sum().toFixed(2));
            $( dt_selector.column( 7 ).footer() ).html(dt_selector.column( 7, {page:'current'} ).data().sum());
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
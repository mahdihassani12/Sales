 <?php $__env->startSection('content'); ?>
<?php if(session()->has('not_permitted')): ?>
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('not_permitted')); ?></div> 
<?php endif; ?>
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4><?php echo e(trans('file.update')); ?> <?php echo e(trans('file.Transfer')); ?></h4>
                    </div>
                    <div class="card-body">
                        <p class="italic"><small><?php echo e(trans('file.The field labels marked with * are required input fields')); ?>.</small></p>
                        <?php echo Form::open(['route' => ['transfers.update', $ezpos_transfer_data->id], 'method' => 'put', 'files' => true, 'id' => 'transfer-form']); ?>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><strong><?php echo e(trans('file.date')); ?></strong></label>
                                            <input type="text" id="date" name="date" value="<?php echo e(date('d-m-Y', strtotime($ezpos_transfer_data->date))); ?>" class="form-control" required />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><strong><?php echo e(trans('file.reference')); ?> No</strong></label>
                                            <p><strong><?php echo e($ezpos_transfer_data->reference_no); ?></strong></p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><strong><?php echo e(trans("file.Status")); ?></strong></label>
                                            <input type="hidden" name="status_hidden" value="<?php echo e($ezpos_transfer_data->status); ?>">
                                            <select name="status" class="form-control selectpicker">
                                                <option value="1">Completed</option>
                                                <option value="2">Pending</option>
                                                <option value="3">Sent</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">  
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><strong><?php echo e(trans('file.From')); ?> <?php echo e(trans('file.Store')); ?> *</strong></label>
                                            <input type="hidden" name="from_store_id_hidden" value="<?php echo e($ezpos_transfer_data->from_store_id); ?>" />
                                            <select required name="from_store_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select store...">
                                                <?php $__currentLoopData = $ezpos_store_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($store->id); ?>"><?php echo e($store->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><strong><?php echo e(trans('file.To')); ?> <?php echo e(trans('file.Store')); ?> *</strong></label>
                                            <input type="hidden" name="to_store_id_hidden" value="<?php echo e($ezpos_transfer_data->to_store_id); ?>" />
                                            <select required name="to_store_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select store...">
                                                <?php $__currentLoopData = $ezpos_store_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($store->id); ?>"><?php echo e($store->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <label><strong><?php echo e(trans('file.Select Product')); ?></strong></label>
                                        <div class="search-box input-group">
                                            <button type="button" class="btn btn-secondary btn-lg"><i class="fa fa-barcode"></i></button>
                                            <input type="text" name="product_code_name" id="ezpos_productcodeSearch" placeholder="Please type product code and select..." class="form-control" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-md-12">
                                        
                                        <h5><?php echo e(trans('file.Order Table')); ?> *</h5>
                                        <div class="table-responsive mt-3">
                                            <table id="myTable" class="table table-hover order-list">
                                                <thead>
                                                    <tr>
                                                        <th><?php echo e(trans('file.name')); ?></th>
                                                        <th><?php echo e(trans('file.Code')); ?></th>
                                                        <th><?php echo e(trans('file.Quantity')); ?></th>
                                                        <th><?php echo e(trans('file.Net Unit Cost')); ?></th>
                                                        <th><?php echo e(trans('file.Tax')); ?></th>
                                                        <th><?php echo e(trans('file.Subtotal')); ?></th>
                                                        <th><i class="fa fa-trash"></i></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    $temp_unit_name = [];
                                                    $temp_unit_operator = [];
                                                    $temp_unit_operation_value = [];
                                                    ?>
                                                    <?php $__currentLoopData = $ezpos_product_transfer_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product_transfer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                    <?php 
                                                        $product_data = DB::table('products')->find($product_transfer->product_id);

                                                        $tax = DB::table('taxes')->where('rate', $product_transfer->tax_rate)->first();

                                                        if($product_data->tax_method == 1)
                                                            $product_cost = $product_transfer->net_unit_cost;
                                                        else
                                                           $product_cost = $product_transfer->total / $product_transfer->qty;
                                                    ?>
                                                        <td><?php echo e($product_data->name); ?> <button type="button" class="edit-product btn btn-link" data-toggle="modal" data-target="#editModal"> <i class="fa fa-edit"></i></button> </td>
                                                        <td><?php echo e($product_data->code); ?></td>
                                                        <td><input type="number" class="form-control qty" name="qty[]" value="<?php echo e($product_transfer->qty); ?>" required /></td>
                                                        <td class="net_unit_cost"><?php echo e(number_format((float)$product_transfer->net_unit_cost, 2, '.', '')); ?> </td>
                                                        <td class="tax"><?php echo e(number_format((float)$product_transfer->tax, 2, '.', '')); ?></td>
                                                        <td class="sub-total"><?php echo e(number_format((float)$product_transfer->total, 2, '.', '')); ?></td>
                                                        <td><button type="button" class="ibtnDel btn btn-md btn-danger"><?php echo e(trans("file.delete")); ?></button></td>
                                                        <input type="hidden" class="product-id" name="product_id[]" value="<?php echo e($product_data->id); ?>"/>
                                                        <input type="hidden" class="product-code" name="product_code[]" value="<?php echo e($product_data->code); ?>"/>
                                                        <input type="hidden" class="product-cost" name="product_cost[]" value="<?php echo e($product_cost); ?>"/>
                                                        <input type="hidden" class="purchase-unit" name="purchase_unit[]" value="<?php echo e($product_transfer->unit); ?>"/>
                                                        <input type="hidden" class="net_unit_cost" name="net_unit_cost[]" value="<?php echo e($product_transfer->net_unit_cost); ?>" />
                                                        <input type="hidden" class="tax-rate" name="tax_rate[]" value="<?php echo e($product_transfer->tax_rate); ?>"/>
                                                        <?php if($tax): ?>
                                                        <input type="hidden" class="tax-name" value="<?php echo e($tax->name); ?>" />
                                                        <?php else: ?>
                                                        <input type="hidden" class="tax-name" value="No Tax" />
                                                        <?php endif; ?>
                                                        <input type="hidden" class="tax-method" value="<?php echo e($product_data->tax_method); ?>"/>
                                                        <input type="hidden" class="tax-value" name="tax[]" value="<?php echo e($product_transfer->tax); ?>" />
                                                        <input type="hidden" class="subtotal-value" name="subtotal[]" value="<?php echo e($product_transfer->total); ?>" />
                                                    </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                                <tfoot class="tfoot active">
                                                    <th colspan="2"><?php echo e(trans('file.Total')); ?></th>
                                                    <th id="total-qty"><?php echo e($ezpos_transfer_data->total_qty); ?></th>
                                                    <th></th>
                                                    <th id="total-tax"><?php echo e(number_format((float)$ezpos_transfer_data->total_tax, 2, '.', '')); ?></th>
                                                    <th id="total"><?php echo e(number_format((float)$ezpos_transfer_data->total_cost, 2, '.', '')); ?></th>
                                                    <th><i class="fa fa-trash"></i></th>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="hidden" name="total_qty" value="<?php echo e($ezpos_transfer_data->total_qty); ?>" />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="hidden" name="total_tax" value="<?php echo e($ezpos_transfer_data->total_tax); ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="hidden" name="total_cost" value="<?php echo e($ezpos_transfer_data->total_cost); ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="hidden" name="item" value="<?php echo e($ezpos_transfer_data->item); ?>" />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="hidden" name="grand_total" value="<?php echo e($ezpos_transfer_data->grand_total); ?>" />
                                            <input type="hidden" name="paid_amount" value="<?php echo e($ezpos_transfer_data->paid_amount); ?>" />
                                            <input type="hidden" name="payment_status" value="1" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>
                                                <strong><?php echo e(trans('file.Shipping Cost')); ?></strong>
                                            </label>
                                            <input type="number" name="shipping_cost" class="form-control" value="<?php echo e($ezpos_transfer_data->shipping_cost); ?>" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><strong><?php echo e(trans('file.Attach Document')); ?></strong></label>
                                            <input type="file" name="document" class="form-control" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label><strong><?php echo e(trans('file.Note')); ?></strong></label>
                                            <textarea rows="5" class="form-control" name="note"><?php echo e($ezpos_transfer_data->note); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="submit" value="<?php echo e(trans('file.submit')); ?>" class="btn btn-primary" id="submit-button">
                                </div>
                            </div>
                        </div>
                        <?php echo Form::close(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <table class="table table-bordered table-condensed totals">
            <td><strong><?php echo e(trans('file.Items')); ?></strong>
                <span class="pull-right" id="item">0.00</span>
            </td>
            <td><strong><?php echo e(trans('file.Total')); ?></strong>
                <span class="pull-right" id="subtotal">0.00</span>
            </td>
            <td><strong><?php echo e(trans('file.Shipping Cost')); ?></strong>
                <span class="pull-right" id="shipping_cost">0.00</span>
            </td>
            <td><strong><?php echo e(trans('file.grand total')); ?></strong>
                <span class="pull-right" id="grand_total">0.00</span>
            </td>
        </table>
    </div>
    <div id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="modal_header" class="modal-title"></h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label><strong><?php echo e(trans('file.Quantity')); ?></strong></label>
                            <input type="number" name="edit_qty" class="form-control">
                        </div>
                        <div class="form-group">
                            <label><strong><?php echo e(trans('file.Unit Cost')); ?></strong></label>
                            <input type="number" name="edit_unit_cost" class="form-control">
                        </div>
                        <button type="button" name="update_btn" class="btn btn-primary"><?php echo e(trans('file.update')); ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</section>
<script type="text/javascript">
    $("ul#transfer").siblings('a').attr('aria-expanded','true');
    $("ul#transfer").addClass("show");

    var date = $('#date');
    date.datepicker({
     format: "dd-mm-yyyy",
     startDate: "<?php echo date('d-m-Y', strtotime('')); ?>",
     autoclose: true,
     todayHighlight: true
     });
    
// array data depend on store
var ezpos_product_array = [];
var product_code = [];
var product_name = [];
var product_qty = [];

// array data with selection
var product_cost = [];
var tax_rate = [];
var tax_name = [];
var tax_method = [];
var unit_name = [];
var unit_operator = [];
var unit_operation_value = [];

// temporary array
var temp_unit_name = [];
var temp_unit_operator = [];
var temp_unit_operation_value = [];

var rowindex;
var row_product_cost;

var rownumber = $('table.order-list tbody tr:last').index();

for(rowindex  =0; rowindex <= rownumber; rowindex++){

    product_cost.push(parseFloat($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.product-cost').val()));
    var quantity = parseFloat($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.qty').val());
    tax_rate.push(parseFloat($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.tax-rate').val()));
    tax_name.push($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.tax-name').val());
    tax_method.push($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.tax-method').val());
}


$('.selectpicker').selectpicker({
    style: 'btn-link',
});

//assigning previous value
$('select[name="status"]').val($('input[name="status_hidden"]').val());
$('select[name="from_store_id"]').val($('input[name="from_store_id_hidden"]').val());
$('select[name="to_store_id"]').val($('input[name="to_store_id_hidden"]').val());
$('.selectpicker').selectpicker('refresh');
$('#item').text($('input[name="item"]').val() + '(' + $('input[name="total_qty"]').val() + ')');
$('#subtotal').text(parseFloat($('input[name="total_cost"]').val()).toFixed(2));
if(!$('input[name="shipping_cost"]').val())
    $('input[name="shipping_cost"]').val('0.00');
$('#shipping_cost').text(parseFloat($('input[name="shipping_cost"]').val()).toFixed(2));
$('#grand_total').text(parseFloat($('input[name="grand_total"]').val()).toFixed(2));
$('select[name="from_store_id"]').prop('disabled', true);

var id = $('select[name="from_store_id"]').val();
    $.get('../getproduct/' + id, function(data) {
        ezpos_product_array = [];
        product_code = data[0];
        product_name = data[1];
        product_qty = data[2];
        $.each(product_code, function(index) {
            ezpos_product_array.push(product_code[index] + ' (' + product_name[index] + ')');
        });
    });
//assigning value end

$('select[name="from_store_id"]').on('change', function() {
    var id = $('select[name="from_store_id"]').val();
    $.get('../getproduct/' + id, function(data) {
        ezpos_product_array = [];
        product_code = data[0];
        product_name = data[1];
        product_qty = data[2];
        $.each(product_code, function(index) {
            ezpos_product_array.push(product_code[index] + ' (' + product_name[index] + ')');
        });
    });
});

$('#ezpos_productcodeSearch').on('input', function(){
    var store_id = $('select[name="from_store_id"]').val();
    temp_data = $('#ezpos_productcodeSearch').val();

    if(!store_id){
        $('#ezpos_productcodeSearch').val(temp_data.substring(0, temp_data.length - 1));
        alert('Please select store!');
    }
});

var ezpos_productcodeSearch = $('#ezpos_productcodeSearch');

ezpos_productcodeSearch.autocomplete({
    source: function(request, response) {
        var matcher = new RegExp(".?" + $.ui.autocomplete.escapeRegex(request.term), "i");
        response($.grep(ezpos_product_array, function(item) {
            return matcher.test(item);
        }));
    },
    select: function(event, ui) {
        var data = ui.item.value;
        $.ajax({
            type: 'GET',
            url: '../ezpos_product_search',
            data: {
                data: data
            },
            success: function(data) {
                var flag = 1;
                $(".product-code").each(function() {
                    if ($(this).val() == data[1]) {
                        alert('Duplicate input is not allowed!')
                        flag = 0;
                    }
                });
                $("input[name='product_code_name']").val('');
                if(flag){
                    var newRow = $("<tr>");
                    var cols = '';
                    cols += '<td>' + data[0] + '<button type="button" class="edit-product btn btn-link" data-toggle="modal" data-target="#editModal"> <i class="fa fa-edit"></i></button></td>';
                    cols += '<td>' + data[1] + '</td>';
                    cols += '<td><input type="number" class="form-control qty" name="qty[]" value="1" step="any" required/></td>';
                    cols += '<td class="net_unit_cost"></td>';
                    cols += '<td class="tax"></td>';
                    cols += '<td class="sub-total"></td>';
                    cols += '<td><button type="button" class="ibtnDel btn btn-md btn-danger"><?php echo e(trans("file.delete")); ?></button></td>';
                    cols += '<input type="hidden" class="product-code" name="product_code[]" value="' + data[1] + '"/>';
                    cols += '<input type="hidden" class="product-id" name="product_id[]" value="' + data[7] + '"/>';
                    cols += '<input type="hidden" class="purchase-unit" name="purchase_unit[]" value="' + data[6] + '"/>';
                    cols += '<input type="hidden" class="net_unit_cost" name="net_unit_cost[]" />';
                    cols += '<input type="hidden" class="tax-rate" name="tax_rate[]" value="' + data[3] + '"/>';
                    cols += '<input type="hidden" class="tax-value" name="tax[]" />';
                    cols += '<input type="hidden" class="subtotal-value" name="subtotal[]" />';

                    newRow.append(cols);
                    $("table.order-list tbody").append(newRow);

                    product_cost.push(parseFloat(data[2]));
                    tax_rate.push(parseFloat(data[3]));
                    tax_name.push(data[4]);
                    tax_method.push(data[5]);
                    rowindex = newRow.index();
                    checkQuantity(1, true);
                }  
            }
        });
    }
});

//Change quantity
$("#myTable").on('input', '.qty', function() {
    rowindex = $(this).closest('tr').index();
    checkQuantity($(this).val(), true);
});


//Delete product
$("table.order-list tbody").on("click", ".ibtnDel", function(event) {
    rowindex = $(this).closest('tr').index();
    product_cost.splice(rowindex, 1);
    tax_rate.splice(rowindex, 1);
    tax_name.splice(rowindex, 1);
    tax_method.splice(rowindex, 1);
    $(this).closest("tr").remove();
    calculateTotal();
});

//Edit product
$("table.order-list").on("click", ".edit-product", function() {
    rowindex = $(this).closest('tr').index();
    edit();
});

//Update product
$('button[name="update_btn"]').on("click", function() {
    var edit_qty = $('input[name="edit_qty"]').val();
    var edit_unit_cost = $('input[name="edit_unit_cost"]').val();
    product_cost[rowindex] = parseFloat($('input[name="edit_unit_cost"]').val());
    checkQuantity(edit_qty, false);
});

function edit(){
    var row_product_name = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(1)').text();
    var row_product_code = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(2)').text();
    $('#modal_header').text(row_product_name + '(' + row_product_code + ')');

    var qty = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.qty').val();
    $('input[name="edit_qty"]').val(qty);
    $('input[name="edit_unit_cost"]').val(product_cost[rowindex].toFixed(2));
}

function checkQuantity(purchase_qty, flag) {
    var row_product_code = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(2)').text();
    var pos = product_code.indexOf(row_product_code);

    if (parseFloat(purchase_qty) > product_qty[pos]) {
        alert('Quantity exceeds stock quantity!');
        if (flag) {
            var row_qty = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.qty').val();
            row_qty = row_qty.substring(0, row_qty.length - 1);
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.qty').val(row_qty);
        } else {
            edit();
            return;
        }
    }
    else {
        $('#editModal').modal('hide');
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.qty').val(purchase_qty);

        calculateRowProductData(purchase_qty);
    }
}

function calculateRowProductData(quantity) {
    $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.tax-rate').val(tax_rate[rowindex].toFixed(2));

    if (tax_method[rowindex] == 1) {
        var net_unit_cost = product_cost[rowindex];
        var tax = net_unit_cost * quantity * (tax_rate[rowindex] / 100);
        var sub_total = (net_unit_cost * quantity) + tax;
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(4)').text(net_unit_cost.toFixed(2));
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.net_unit_cost').val(net_unit_cost.toFixed(2));
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(5)').text(tax.toFixed(2));
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.tax-value').val(tax.toFixed(2));
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(6)').text(sub_total.toFixed(2));
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.subtotal-value').val(sub_total.toFixed(2));
    } else {

        var sub_total_unit = product_cost[rowindex];
        var net_unit_cost = (100 / (100 + tax_rate[rowindex])) * sub_total_unit;
        var tax = (sub_total_unit - net_unit_cost) * quantity;
        var sub_total = sub_total_unit * quantity;

        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(4)').text(net_unit_cost.toFixed(2));
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.net_unit_cost').val(net_unit_cost.toFixed(2));
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(5)').text(tax.toFixed(2));
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.tax-value').val(tax.toFixed(2));
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(6)').text(sub_total.toFixed(2));
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.subtotal-value').val(sub_total.toFixed(2));
    }

    calculateTotal();
}

function calculateTotal() {
    //Sum of quantity
    var total_qty = 0;
    $(".qty").each(function() {

        if ($(this).val() == '') {
            total_qty += 0;
        } else {
            total_qty += parseFloat($(this).val());
        }
    });
    $("#total-qty").text(total_qty);
    $('input[name="total_qty"]').val(total_qty);

    //Sum of tax
    var total_tax = 0;
    $(".tax").each(function() {
        total_tax += parseFloat($(this).text());
    });
    $("#total-tax").text(total_tax.toFixed(2));
    $('input[name="total_tax"]').val(total_tax.toFixed(2));

    //Sum of subtotal
    var total = 0;
    $(".sub-total").each(function() {
        total += parseFloat($(this).text());
    });
    $("#total").text(total.toFixed(2));
    $('input[name="total_cost"]').val(total.toFixed(2));

    calculateGrandTotal();
}

function calculateGrandTotal() {

    var item = $('table.order-list tbody tr:last').index();

    var total_qty = parseFloat($('#total-qty').text());
    var subtotal = parseFloat($('#total').text());
    var shipping_cost = parseFloat($('input[name="shipping_cost"]').val());

    if (!shipping_cost)
        shipping_cost = 0.00;

    item = ++item + '(' + total_qty + ')';

    var grand_total = (subtotal + shipping_cost);

    $('#item').text(item);
    $('input[name="item"]').val($('table.order-list tbody tr:last').index() + 1);
    $('#subtotal').text(subtotal.toFixed(2));
    $('#shipping_cost').text(shipping_cost.toFixed(2));
    $('#grand_total').text(grand_total.toFixed(2));
    $('input[name="grand_total"]').val(grand_total.toFixed(2));
}

$('input[name="shipping_cost"]').on("input", function() {
    calculateGrandTotal();
});

$('#transfer-form').on('submit',function(e){
    $('select[name="from_store_id"]').prop('disabled', false);
    var rownumber = $('table.order-list tbody tr:last').index();
    if (rownumber < 0) {
        alert("Please insert product to order table!")
        e.preventDefault();
        $('select[name="from_store_id"]').prop('disabled', true);
    }

    if($('select[name="from_store_id"]').val() == $('select[name="to_store_id"]').val()){
        alert('Both store can not be same!');
        e.preventDefault();
        $('select[name="from_store_id"]').prop('disabled', true);
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
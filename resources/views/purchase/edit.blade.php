@extends('layout.main') @section('content')
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div> 
@endif
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4>{{trans('file.update')}} {{trans('file.Purchase')}}</h4>
                    </div>
                    <div class="card-body">
                        <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
                        {!! Form::open(['route' => ['purchase.update', $ezpos_purchase_data->id], 'method' => 'put', 'files' => true, 'id' => 'purchase-form']) !!}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><strong>{{trans('file.date')}}</strong></label>
                                            <input type="text" id="date" name="date" value="{{ date('d-m-Y', strtotime($ezpos_purchase_data->date)) }}" class="form-control" required />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><strong>{{trans('file.reference')}} No</strong></label>
                                            <p><strong>{{ $ezpos_purchase_data->reference_no }}</strong> </p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><strong>{{trans('file.Store')}} *</strong></label>
                                            <input type="hidden" name="store_id_hidden" value="{{$ezpos_purchase_data->store_id}}" />
                                            <select required name="store_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select store...">
                                                @foreach($ezpos_store_list as $store)
                                                <option value="{{$store->id}}">{{$store->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><strong>{{trans('file.Supplier')}}</strong></label>
                                            <input type="hidden" name="supplier_id_hidden" value="{{ $ezpos_purchase_data->supplier_id }}" />
                                            <select name="supplier_id" class="selectpicker form-control" data-live-search="true" id="supplier-id" data-live-search-style="begins" title="Select supplier...">
                                                @foreach($ezpos_supplier_list as $supplier)
                                                <option value="{{$supplier->id}}">{{$supplier->name .' ('. $supplier->company_name .')'}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                	<div class="col-md-4">
                                        <div class="form-group">
                                            <label><strong>{{trans('file.Purchase')}} {{trans('file.status')}}</strong></label>
                                            <input type="hidden" name="status_hidden" value="{{$ezpos_purchase_data->status}}">
                                            <select name="status" class="form-control">
                                                <option value="1">Recieved</option>
                                                <option value="2">Partial</option>
                                                <option value="3">Pending</option>
                                                <option value="4">Ordered</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><strong>{{trans('file.Attach Document')}}</strong></label>
                                            <input type="file" name="document" class="form-control" >
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <label><strong>{{trans('file.Select Product')}}</strong></label>
                                        <div class="search-box input-group">
                                            <button type="button" class="btn btn-secondary"><i class="fa fa-barcode"></i></button>
                                            <input type="text" name="product_code_name" id="ezpos_productcodeSearch" placeholder="Please type product code and select..." class="form-control" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-md-12">
                                        <h5>{{trans('file.Order Table')}} *</h5>
                                        <div class="table-responsive mt-3">
                                            <table id="myTable" class="table table-hover order-list">
                                                <thead>
                                                    <tr>
                                                        <th>{{trans('file.name')}}</th>
                                                        <th>{{trans('file.Code')}}</th>
                                                        <th>{{trans('file.Quantity')}}</th>
                                                        <th class="recieved-product-qty d-none">{{trans('file.Recieved')}}</th>
                                                        <th>{{trans('file.Net Unit Cost')}}</th>
                                                        <th>{{trans('file.Discount')}}</th>
                                                        <th>{{trans('file.Tax')}}</th>
                                                        <th>{{trans('file.Subtotal')}}</th>
                                                        <th><i class="fa fa-trash"></i></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($ezpos_product_purchase_data as $product_purchase)
                                                    <tr>
                                                    <?php 
                                                        $product_data = DB::table('products')->find($product_purchase->product_id);

                                                        $tax = DB::table('taxes')->where('rate', $product_purchase->tax_rate)->first();

                                                        if($product_data->tax_method == 1){
                                                            $product_cost = ($product_purchase->net_unit_cost + ($product_purchase->discount / $product_purchase->qty));
                                                        }
                                                        else{
                                                            $product_cost = (($product_purchase->total + ($product_purchase->discount / $product_purchase->qty)) / $product_purchase->qty);
                                                        }
                                                    ?>
                                                        <td>{{$product_data->name}} <button type="button" class="edit-product btn btn-link" data-toggle="modal" data-target="#editModal"> <i class="fa fa-edit"></i></button> </td>
                                                        <td>{{$product_data->code}}</td>
                                                        <td><input type="number" class="form-control qty" name="qty[]" value="{{$product_purchase->qty}}" step="any" required /></td>
                                                        <td class="recieved-product-qty d-none"><input type="number" class="form-control recieved" name="recieved[]" value="{{$product_purchase->recieved}}" step="any"/></td>
                                                        <td class="net_unit_cost">{{ number_format((float)$product_purchase->net_unit_cost, 2, '.', '') }} </td>
                                                        <td class="discount">{{ number_format((float)$product_purchase->discount, 2, '.', '') }}</td>
                                                        <td class="tax">{{ number_format((float)$product_purchase->tax, 2, '.', '') }}</td>
                                                        <td class="sub-total">{{ number_format((float)$product_purchase->total, 2, '.', '') }}</td>
                                                        <td><button type="button" class="ibtnDel btn btn-md btn-danger">{{trans("file.delete")}}</button></td>
                                                        <input type="hidden" class="product-id" name="product_id[]" value="{{$product_data->id}}"/>
                                                        <input type="hidden" class="product-code" name="product_code[]" value="{{$product_data->code}}"/>
                                                        <input type="hidden" class="product-cost" name="product_cost[]" value="{{ $product_cost}}"/>
                                                        <input type="hidden" class="purchase-unit" name="purchase_unit[]" value="{{$product_purchase->unit}}"/>
                                                        <input type="hidden" class="net_unit_cost" name="net_unit_cost[]" value="{{$product_purchase->net_unit_cost}}" />
                                                        <input type="hidden" class="discount-value" name="discount[]" value="{{$product_purchase->discount}}" />
                                                        <input type="hidden" class="tax-rate" name="tax_rate[]" value="{{$product_purchase->tax_rate}}"/>
                                                        @if($tax)
                                                        <input type="hidden" class="tax-name" value="{{$tax->name}}" />
                                                        @else
                                                        <input type="hidden" class="tax-name" value="No Tax" />
                                                        @endif
                                                        <input type="hidden" class="tax-method" value="{{$product_data->tax_method}}"/>
                                                        <input type="hidden" class="tax-value" name="tax[]" value="{{$product_purchase->tax}}" />
                                                        <input type="hidden" class="subtotal-value" name="subtotal[]" value="{{$product_purchase->total}}" />
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot class="tfoot active">
                                                    <th colspan="2">{{trans('file.Total')}}</th>
                                                    <th id="total-qty">{{$ezpos_purchase_data->total_qty}}</th>
                                                    <th></th>
                                                    <th class="recieved-product-qty d-none"></th>
                                                    <th id="total-discount">{{ number_format((float)$ezpos_purchase_data->total_discount, 2, '.', '') }}</th>
                                                    <th id="total-tax">{{ number_format((float)$ezpos_purchase_data->total_tax, 2, '.', '')}}</th>
                                                    <th id="total">{{ number_format((float)$ezpos_purchase_data->total_cost, 2, '.', '') }}</th>
                                                    <th><i class="fa fa-trash"></i></th>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="hidden" name="total_qty" value="{{$ezpos_purchase_data->total_qty}}" />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="hidden" name="total_discount" value="{{$ezpos_purchase_data->total_discount}}" />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="hidden" name="total_tax" value="{{$ezpos_purchase_data->total_tax}}" />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="hidden" name="total_cost" value="{{$ezpos_purchase_data->total_cost}}" />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="hidden" name="item" value="{{$ezpos_purchase_data->item}}" />
                                            <input type="hidden" name="order_tax" value="{{$ezpos_purchase_data->order_tax}}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="hidden" name="grand_total" value="{{$ezpos_purchase_data->grand_total}}" />
                                            <input type="hidden" name="paid_amount" value="{{$ezpos_purchase_data->paid_amount}}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><strong>{{trans('file.Order')}} {{trans('file.Tax')}}</strong></label>
                                            <input type="hidden" name="order_tax_rate_hidden" value="{{$ezpos_purchase_data->order_tax_rate}}">
                                            <select class="form-control" name="order_tax_rate">
                                                <option value="0">No Tax</option>
                                                @foreach($ezpos_tax_list as $tax)
                                                <option value="{{$tax->rate}}">{{$tax->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>
                                                <strong>{{trans('file.Discount')}}</strong>
                                            </label>
                                            <input type="number" name="order_discount" class="form-control" value="{{$ezpos_purchase_data->order_discount}}" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>
                                                <strong>{{trans('file.Shipping Cost')}}</strong>
                                            </label>
                                            <input type="number" name="shipping_cost" class="form-control" value="{{$ezpos_purchase_data->shipping_cost}}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label><strong>{{trans('file.Note')}}</strong></label>
                                            <textarea rows="5" class="form-control" name="note" >{{ $ezpos_purchase_data->note }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="submit" value="{{trans('file.submit')}}" class="btn btn-primary" id="submit-button">
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <table class="table table-bordered table-condensed totals">
            <td><strong>{{trans('file.Items')}}</strong>
                <span class="pull-right" id="item">0.00</span>
            </td>
            <td><strong>{{trans('file.Total')}}</strong>
                <span class="pull-right" id="subtotal">0.00</span>
            </td>
            <td><strong>{{trans('file.Order')}} {{trans('file.Tax')}}</strong>
                <span class="pull-right" id="order_tax">0.00</span>
            </td>
            <td><strong>{{trans('file.Order')}} {{trans('file.Discount')}}</strong>
                <span class="pull-right" id="order_discount">0.00</span>
            </td>
            <td><strong>{{trans('file.Shipping Cost')}}</strong>
                <span class="pull-right" id="shipping_cost">0.00</span>
            </td>
            <td><strong>{{trans('file.grand total')}}</strong>
                <span class="pull-right" id="grand_total">0.00</span>
            </td>
        </table>
    </div>
    <div id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="modal-header" class="modal-title"></h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label><strong>{{trans('file.Quantity')}}</strong></label>
                            <input type="number" name="edit_qty" class="form-control" step="any">
                        </div>
                        <div class="form-group">
                            <label><strong>{{trans('file.Unit')}} {{trans('file.Discount')}}</strong></label>
                            <input type="number" name="edit_discount" class="form-control" step="any">
                        </div>
                        <div class="form-group">
                            <label><strong>{{trans('file.Unit Cost')}}</strong></label>
                            <input type="number" name="edit_unit_cost" class="form-control" step="any">
                        </div>
                        <?php
                            $tax_name_all[] = 'No Tax';
                            $tax_rate_all[] = 0;
                            foreach($ezpos_tax_list as $tax) {
                                $tax_name_all[] = $tax->name;
                                $tax_rate_all[] = $tax->rate;
                            }
                        ?>
                            <div class="form-group">
                                <label><strong>{{trans('file.Tax')}} {{trans('file.Rate')}}</strong></label>
                                <select name="edit_tax_rate" class="form-control">
                                    @foreach($tax_name_all as $key => $name)
                                    <option value="{{$key}}">{{$name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="button" name="update_btn" class="btn btn-primary">{{trans('file.update')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">

    $("ul#purchase").siblings('a').addClass("active");
    $("ul#purchase").addClass("show");

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
var product_discount = [];
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
var customer_group_rate;
var row_product_cost;

var rownumber = $('table.order-list tbody tr:last').index();

for(rowindex  =0; rowindex <= rownumber; rowindex++){

    product_cost.push(parseFloat($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.product-cost').val()));
    var total_discount = parseFloat($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(6)').text());
    var quantity = parseFloat($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.qty').val());
    product_discount.push((total_discount / quantity).toFixed(2));
    tax_rate.push(parseFloat($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.tax-rate').val()));
    tax_name.push($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.tax-name').val());
    tax_method.push($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.tax-method').val());
}


$('.selectpicker').selectpicker({
    style: 'btn-link',
});

//assigning value
$('select[name="supplier_id"]').val($('input[name="supplier_id_hidden"]').val());
$('select[name="store_id"]').val($('input[name="store_id_hidden"]').val());
$('select[name="status"]').val($('input[name="status_hidden"]').val());
$('select[name="order_tax_rate"]').val($('input[name="order_tax_rate_hidden"]').val());
$('select[name="purchase_status"]').val($('input[name="purchase_status_hidden"]').val());
$('.selectpicker').selectpicker('refresh');

$('#item').text($('input[name="item"]').val() + '(' + $('input[name="total_qty"]').val() + ')');
$('#subtotal').text(parseFloat($('input[name="total_cost"]').val()).toFixed(2));
$('#order_tax').text(parseFloat($('input[name="order_tax"]').val()).toFixed(2));
if($('select[name="status"]').val() == 2){
    $(".recieved-product-qty").removeClass("d-none");
    
}
if(!$('input[name="order_discount"]').val())
    $('input[name="order_discount"]').val('0.00');
$('#order_discount').text(parseFloat($('input[name="order_discount"]').val()).toFixed(2));
if(!$('input[name="shipping_cost"]').val())
    $('input[name="shipping_cost"]').val('0.00');
$('#shipping_cost').text(parseFloat($('input[name="shipping_cost"]').val()).toFixed(2));
$('#grand_total').text(parseFloat($('input[name="grand_total"]').val()).toFixed(2));

$('select[name="status"]').on('change', function() {
    if($('select[name="status"]').val() == 2){
        $(".recieved-product-qty").removeClass("d-none");
        $(".qty").each(function() {
            rowindex = $(this).closest('tr').index();
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.recieved').val($(this).val());
        });

    }
    else if(($('select[name="status"]').val() == 3) || ($('select[name="status"]').val() == 4)){
        $(".recieved-product-qty").addClass("d-none");
        $(".recieved").each(function() {
            $(this).val(0);
        });
    }
    else {
        $(".recieved-product-qty").addClass("d-none");
        $(".qty").each(function() {
            rowindex = $(this).closest('tr').index();
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.recieved').val($(this).val());
        });
    }
});


var ezpos_product_code = [ @foreach($ezpos_product_list as $product)
        <?php
            $productArray[] = $product->code . ' (' . $product->name . ')';
        ?>
         @endforeach
            <?php
            echo  '"'.implode('","', $productArray).'"';
            ?> ];

    var ezpos_productcodeSearch = $('#ezpos_productcodeSearch');

    ezpos_productcodeSearch.autocomplete({
    source: function(request, response) {
        var matcher = new RegExp(".?" + $.ui.autocomplete.escapeRegex(request.term), "i");
        response($.grep(ezpos_product_code, function(item) {
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
                        alert('duplicate input is not allowed!')
                        flag = 0;
                    }
                });
                $("input[name='product_code_name']").val('');
                if(flag){
                    var newRow = $("<tr>");
                    var cols = '';
                    temp_unit_name = (data[6]).split(',');
                    cols += '<td>' + data[0] + '<button type="button" class="edit-product btn btn-link" data-toggle="modal" data-target="#editModal"> <i class="fa fa-edit"></i></button></td>';
                    cols += '<td>' + data[1] + '</td>';
                    cols += '<td><input type="number" class="form-control qty" name="qty[]" value="1" step="any" required /></td>';
                    if($('select[name="status"]').val() == 1)
                        cols += '<td class="recieved-product-qty d-none"><input type="number" class="form-control recieved" name="recieved[]" value="1" /></td>';
                    else if($('select[name="status"]').val() == 2)
                        cols += '<td class="recieved-product-qty"><input type="number" class="form-control recieved" name="recieved[]" value="1" step="any"/></td>';
                    else
                        cols += '<td class="recieved-product-qty d-none"><input type="number" class="form-control recieved" name="recieved[]" value="0" /></td>';
                    cols += '<td class="net_unit_cost"></td>';
                    cols += '<td class="discount">0.00</td>';
                    cols += '<td class="tax"></td>';
                    cols += '<td class="sub-total"></td>';
                    cols += '<td><button type="button" class="ibtnDel btn btn-md btn-danger">{{trans("file.delete")}}</button></td>';
                    cols += '<input type="hidden" class="product-code" name="product_code[]" value="' + data[1] + '"/>';
                    cols += '<input type="hidden" class="product-id" name="product_id[]" value="' + data[7] + '"/>';
                    cols += '<input type="hidden" class="purchase-unit" name="purchase_unit[]" value="' + data[6] + '"/>';
                    cols += '<input type="hidden" class="net_unit_cost" name="net_unit_cost[]" />';
                    cols += '<input type="hidden" class="discount-value" name="discount[]" />';
                    cols += '<input type="hidden" class="tax-rate" name="tax_rate[]" value="' + data[3] + '"/>';
                    cols += '<input type="hidden" class="tax-value" name="tax[]" />';
                    cols += '<input type="hidden" class="subtotal-value" name="subtotal[]" />';

                    newRow.append(cols);
                    $("table.order-list tbody").append(newRow);

                    product_cost.push(parseFloat(data[2]));
                    product_discount.push('0.00');
                    tax_rate.push(parseFloat(data[3]));
                    tax_name.push(data[4]);
                    tax_method.push(data[5]);
                    rowindex = newRow.index();
                    calculateRowProductData(1);
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
    product_discount.splice(rowindex, 1);
    tax_rate.splice(rowindex, 1);
    tax_name.splice(rowindex, 1);
    tax_method.splice(rowindex, 1);
    $(this).closest("tr").remove();
    calculateTotal();
});

//Edit product
$("table.order-list").on("click", ".edit-product", function() {
    rowindex = $(this).closest('tr').index();
    var row_product_name = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(1)').text();
    var row_product_code = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(2)').text();
    $('#modal-header').text(row_product_name + '(' + row_product_code + ')');

    var qty = $(this).closest('tr').find('.qty').val();
    $('input[name="edit_qty"]').val(qty);

    $('input[name="edit_discount"]').val(parseFloat(product_discount[rowindex]).toFixed(2));

    $('input[name="edit_unit_cost"]').val(product_cost[rowindex].toFixed(2));

    var tax_name_all = <?php echo json_encode($tax_name_all) ?>;
    var pos = tax_name_all.indexOf(tax_name[rowindex]);
    $('select[name="edit_tax_rate"]').val(pos);
});

//Update product
$('button[name="update_btn"]').on("click", function() {
    var edit_discount = $('input[name="edit_discount"]').val();
    var edit_qty = $('input[name="edit_qty"]').val();
    var edit_unit_cost = $('input[name="edit_unit_cost"]').val();

    if (parseFloat(edit_discount) > parseFloat(edit_unit_cost)) {
        alert('Invalid Discount Input!');
        return;
    }
    var tax_rate_all = <?php echo json_encode($tax_rate_all) ?>;

    tax_rate[rowindex] = parseFloat(tax_rate_all[$('select[name="edit_tax_rate"]').val()]);
    tax_name[rowindex] = $('select[name="edit_tax_rate"] option:selected').text();
    product_cost[rowindex] = $('input[name="edit_unit_cost"]').val();
    product_discount[rowindex] = $('input[name="edit_discount"]').val();
    checkQuantity(edit_qty, false);
});

function checkQuantity(purchase_qty, flag) {
    $('#editModal').modal('hide');
    $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.qty').val(purchase_qty);
    var status = $('select[name="status"]').val();
    if(status == '1' || status == '2' )
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.recieved').val(purchase_qty);
    calculateRowProductData(purchase_qty);
}

function calculateRowProductData(quantity) {
    $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(6)').text((product_discount[rowindex] * quantity).toFixed(2));
    $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.discount-value').val((product_discount[rowindex] * quantity).toFixed(2));
    $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.tax-rate').val(tax_rate[rowindex].toFixed(2));

    if (tax_method[rowindex] == 1) {
        var net_unit_cost = product_cost[rowindex] - product_discount[rowindex];
        var tax = net_unit_cost * quantity * (tax_rate[rowindex] / 100);
        var sub_total = (net_unit_cost * quantity) + tax;

        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(5)').text(net_unit_cost.toFixed(2));
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.net_unit_cost').val(net_unit_cost.toFixed(2));
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(7)').text(tax.toFixed(2));
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.tax-value').val(tax.toFixed(2));
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(8)').text(sub_total.toFixed(2));
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.subtotal-value').val(sub_total.toFixed(2));
    } else {
        var sub_total_unit = product_cost[rowindex] - product_discount[rowindex];
        var net_unit_cost = (100 / (100 + tax_rate[rowindex])) * sub_total_unit;
        var tax = (sub_total_unit - net_unit_cost) * quantity;
        var sub_total = sub_total_unit * quantity;
    
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(5)').text(net_unit_cost.toFixed(2));
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.net_unit_cost').val(net_unit_cost.toFixed(2));
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(7)').text(tax.toFixed(2));
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.tax-value').val(tax.toFixed(2));
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(8)').text(sub_total.toFixed(2));
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

    //Sum of discount
    var total_discount = 0;
    $(".discount").each(function() {
        total_discount += parseFloat($(this).text());
    });
    $("#total-discount").text(total_discount.toFixed(2));
    $('input[name="total_discount"]').val(total_discount.toFixed(2));

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
    var order_tax = parseFloat($('select[name="order_tax_rate"]').val());
    var order_discount = parseFloat($('input[name="order_discount"]').val());
    var shipping_cost = parseFloat($('input[name="shipping_cost"]').val());

    if (!order_discount)
        order_discount = 0.00;
    if (!shipping_cost)
        shipping_cost = 0.00;

    item = ++item + '(' + total_qty + ')';
    order_tax = (subtotal - order_discount) * (order_tax / 100);
    var grand_total = (subtotal + order_tax + shipping_cost) - order_discount;

    $('#item').text(item);
    $('input[name="item"]').val($('table.order-list tbody tr:last').index() + 1);
    $('#subtotal').text(subtotal.toFixed(2));
    $('#order_tax').text(order_tax.toFixed(2));
    $('input[name="order_tax"]').val(order_tax.toFixed(2));
    $('#order_discount').text(order_discount.toFixed(2));
    $('#shipping_cost').text(shipping_cost.toFixed(2));
    $('#grand_total').text(grand_total.toFixed(2));
    $('input[name="grand_total"]').val(grand_total.toFixed(2));
}

$('input[name="order_discount"]').on("input", function() {
    calculateGrandTotal();
});

$('input[name="shipping_cost"]').on("input", function() {
    calculateGrandTotal();
});

$('select[name="order_tax_rate"]').on("change", function() {
    calculateGrandTotal();
});


$('#purchase-form').on('submit',function(e){
    var rownumber = $('table.order-list tbody tr:last').index();
    if (rownumber < 0) {
        alert("Please insert product to order table!")
        e.preventDefault();
    }

    else if($('select[name="status"]').val() != 1)
    {
        flag = 0;
        $(".qty").each(function() {
            rowindex = $(this).closest('tr').index();
            quantity =  $(this).val();
            recieved = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.recieved').val();

            if(quantity != recieved){
                flag = 1;
                return false;
            }
        });
        if(!flag){
            alert('Quantity and Recieved value is same! Please Change Purchase Status or Recieved value');
            e.preventDefault();
        }
    }
});
</script>
@endsection
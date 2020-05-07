
@extends('layout.top-head') @section('content')
<style>
  .pos-page header.header, .pos-page .card{
	width: 100% !important;
    margin-right: 0px !important;  
    }
</style>
@if($errors->has('phone_number'))
<div class="alert alert-danger alert-dismissible text-center">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ $errors->first('phone_number') }}</div>
@endif 
@if(session()->has('message'))
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div> 
@endif
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div> 
@endif

<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                        {!! Form::open(['route' => ['sale.update', $ezpos_sale_data->id], 'method' => 'put', 'files' => true, 'class' => 'payment-form']) !!}
                        @php
                            if($ezpos_pos_setting_data)
                                $keybord_active = $ezpos_pos_setting_data->keybord_active;
                            else
                                $keybord_active = 0;
                        @endphp
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6 date">
                                        <div class="form-group">
                                            <input type="text" id="date" name="date" value="{{date('d-m-Y', strtotime($ezpos_sale_data->date))}}" class="form-control pos-text" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6 store_id">
                                        <div class="form-group">
                                            <input type="hidden" name="store_id_hidden" value="{{$ezpos_sale_data->store_id}}">
                                            <select required id="store_id" name="store_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select store...">
                                                @foreach($ezpos_store_list as $store)
                                                <option value="{{$store->id}}">{{$store->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="hidden" name="customer_id_hidden" value="{{$ezpos_sale_data->customer_id}}">
                                            <div class="input-group pos">
                                                <select required name="customer_id" id="customer_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select customer...">
                                                @foreach($ezpos_customer_list as $customer)
                                                    @php $deposit[$customer->id] = $customer->deposit - $customer->expense; @endphp
                                                    <option value="{{$customer->id}}">{{$customer->name . ' (' . $customer->phone_number . ')'}}</option>
                                                @endforeach
                                                </select>
                                                <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#addCustomer"><i class="fa fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="search-box form-group">
                                            <input type="text" name="product_code_name" id="ezpos_productcodeSearch" placeholder="Scan/Search product by name/code" class="form-control pos-text" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-3">
                                    <div class="table-responsive">
                                        <table id="myTable" class="table table-hover order-list table-fixed">
                                            <thead>
                                                <tr>
                                                    <th class="col-sm-3">{{trans('file.product')}}</th>
                                                    <th class="col-sm-2">{{trans('file.Price')}}</th>
                                                    <th class="col-sm-3">{{trans('file.Quantity')}}</th>
                                                    <th class="col-sm-3">{{trans('file.Subtotal')}}</th>
                                                    <th class="col-sm-1"><i class="fa fa-trash"></i></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($ezpos_product_sale_data as $product_sale)
                                                    <tr>
                                                    <?php
                                                        $product_data = DB::table('products')->find($product_sale->product_id);

                                                        if($product_data->tax_method == 1){
                                                            $product_price = $product_sale->net_unit_price + ($product_sale->discount / $product_sale->qty);
                                                        }
                                                        elseif ($product_data->tax_method == 2) {
                                                            $product_price =($product_sale->total / $product_sale->qty) + ($product_sale->discount / $product_sale->qty);
                                                        }

                                                        $tax = DB::table('taxes')->where('rate',$product_sale->tax_rate)->first();
                                                    ?>
                                                        <td class="col-sm-3 product-title">{{$product_data->name}}:{{$product_data->code}} <button type="button" class="edit-product btn btn-link" data-toggle="modal" data-target="#editModal"> <i class="fa fa-edit"></i></button> </td>
                                                        <td class="col-sm-2 product-price">{{ number_format((float)($product_sale->total / $product_sale->qty), 2, '.', '') }}</td>
                                                        <td class="col-sm-3"><div class="input-group"><span class="input-group-btn"><button type="button" class="btn btn-default minus"><span class="fa fa-minus"></span></button></span><input type="text" name="qty[]" class="form-control qty numkey input-number" value="{{$product_sale->qty}}" step="any" required><span class="input-group-btn"><button type="button" class="btn btn-default plus"><span class="fa fa-plus"></span></button></span></div></td>
                                                        <td class="col-sm-3 sub-total">{{ number_format((float)$product_sale->total, 2, '.', '') }}</td>
                                                        <td class="col-sm-1"><button type="button" class="ibtnDel btn btn-danger btn-sm">X</button></td>
                                                        <input type="hidden" class="product-code" name="product_code[]" value="{{$product_data->code}}"/>
                                                        <input type="hidden" name="product_id[]" value="{{$product_data->id}}"/>
                                                        <input type="hidden" class="product_price" name="product_price[]" value="{{$product_price}}"/>
                                                        <input type="hidden" class="sale-unit" name="sale_unit[]" value="{{$product_sale->unit}}"/>
                                                        <input type="hidden" class="net_unit_price" name="net_unit_price[]" value="{{$product_sale->net_unit_price}}" />
                                                        <input type="hidden" class="discount-value" name="discount[]" value="{{$product_sale->discount}}" />
                                                        <input type="hidden" class="tax-rate" name="tax_rate[]" value="{{$product_sale->tax_rate}}"/>
                                                        @if($tax)
                                                        <input type="hidden" class="tax-name" value="{{$tax->name}}" />
                                                        @else
                                                        <input type="hidden" class="tax-name" value="No Tax" />
                                                        @endif
                                                        <input type="hidden" class="tax-method" value="{{$product_data->tax_method}}"/>
                                                        <input type="hidden" class="tax-value" name="tax[]" value="{{$product_sale->tax}}" />
                                                        <input type="hidden" class="total-discount" value="{{$product_sale->discount}}">
                                                        <input type="hidden" class="subtotal-value" name="subtotal[]" value="{{$product_sale->total}}" />
                                                    </tr>
                                                    @endforeach
                                            </tbody>
                                            <tfoot class="tfoot active">
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="hidden" name="total_qty" value="{{$ezpos_sale_data->total_qty}}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="hidden" name="total_discount" value="{{$ezpos_sale_data->total_discount}}" />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="hidden" name="total_tax" value="{{$ezpos_sale_data->total_tax}}" />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="hidden" name="total_price" value="{{$ezpos_sale_data->total_price}}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="hidden" name="item" value="{{$ezpos_sale_data->item}}" />
                                            <input type="hidden" name="order_tax" value="{{$ezpos_sale_data->order_tax}}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="hidden" name="grand_total" value="{{$ezpos_sale_data->grand_total}}"/>
                                            <input type="hidden" name="sale_status" value="1" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <table class="table table-bordered table-condensed totals">
                                        <tr>
                                            <td><strong>{{trans('file.Items')}}</strong>
                                            <span class="pull-right" id="item">{{$ezpos_sale_data->item}}( {{$ezpos_sale_data->total_qty}})</span>
                                            </td>
                                            <td><strong>{{trans('file.Total')}}</strong>
                                                <span class="pull-right" id="subtotal">{{number_format((float)($ezpos_sale_data->total_price), 2, '.', '')}}</span>
                                            </td>
                                            <td><strong>{{trans('file.Discount')}}</strong>
                                                <button type="button" class="btn btn-link" data-toggle="modal" data-target="#order-discount"><i class="fa fa-edit"></i></button>
                                                <span class="pull-right pos-btn" id="discount">{{number_format((float)($ezpos_sale_data->total_discount + $ezpos_sale_data->order_discount), 2, '.', '') }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>{{trans('file.Tax')}}</strong>
                                            <button type="button" class="btn btn-link" data-toggle="modal" data-target="#order-tax"><i class="fa fa-edit"></i></button>
                                            <span class="pull-right pos-btn" id="tax">{{number_format((float)($ezpos_sale_data->total_tax + $ezpos_sale_data->order_tax), 2, '.', '')}}</span>
                                            </td>
                                            <td><strong>{{trans('file.Shipping')}}</strong>
                                                <button type="button" class="btn btn-link" data-toggle="modal" data-target="#shipping-cost-modal"><i class="fa fa-edit"></i></button>
                                                <span class="pull-right pos-btn" id="shipping-cost">{{number_format((float)($ezpos_sale_data->shipping_cost), 2, '.', '')}}</span>
                                            </td>
                                            <td><strong>{{trans('file.grand total')}}</strong>
                                                <span class="pull-right" id="grand-total">{{number_format((float)($ezpos_sale_data->grand_total), 2, '.', '')}}</span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6 form-group">
                                        <label><strong>{{trans('file.Sale')}} {{trans('file.Note')}}</strong></label>
                                        <textarea rows="3" class="form-control" name="sale_note">{{$ezpos_sale_data->sale_note}}</textarea>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label><strong>{{trans('file.Staff')}} {{trans('file.Note')}}</strong></label>
                                        <textarea rows="3" class="form-control" name="staff_note">{{$ezpos_sale_data->staff_note}}</textarea>
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <button type="button" class="btn btn-primary btn-block btn-lg mt-2 form-group" id="submit-btn"><i class="fa fa-paper-plane"></i> {{trans('file.submit')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
            <!-- order_discount modal -->
            <div id="order-discount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                <div role="document" class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{trans('file.Order')}} {{trans('file.Discount')}}</h5>
                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" name="order_discount" class="form-control numkey" step="any" value="{{number_format((float)$ezpos_sale_data->order_discount, 2, '.', '')}}">
                            </div>
                            <button type="button" name="order_discount_btn" class="btn btn-primary" data-dismiss="modal">{{trans('file.submit')}}</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- order_tax modal -->
            <div id="order-tax" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                <div role="document" class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{trans('file.Order')}} {{trans('file.Tax')}}</h5>
                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="hidden" name="order_tax_rate_hidden" value="{{$ezpos_sale_data->order_tax_rate}}">
                                <select class="form-control" name="order_tax_rate">
                                    <option value="0">No Tax</option>
                                    @foreach($ezpos_tax_list as $tax)
                                    <option value="{{$tax->rate}}">{{$tax->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="button" name="order_tax_btn" class="btn btn-primary" data-dismiss="modal">{{trans('file.submit')}}</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- shipping_cost modal -->
            <div id="shipping-cost-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                <div role="document" class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{trans('file.Shipping Cost')}}</h5>
                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" name="shipping_cost" class="form-control numkey" value="{{number_format((float)($ezpos_sale_data->shipping_cost), 2, '.', '')}}" step="any">
                            </div>
                            <button type="button" name="shipping_cost_btn" class="btn btn-primary" data-dismiss="modal">{{trans('file.submit')}}</button>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
            <!-- product list -->
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <select required name="category_id" id="category_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins">
                                        <option value="0">All Category</option>
                                        @foreach($ezpos_category_list as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5 pl-0">
                                <div class="form-group">
                                    <select required name="brand_id" id="brand_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins">
                                        <option value="0">All Brand</option>
                                        @foreach($ezpos_brand_list as $brand)
                                        <option value="{{$brand->id}}">{{$brand->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 pl-0">
                                <div class="form-group">
                                    <input type="button" id="filter-btn" class="btn btn-primary" value="{{trans('file.submit')}}">
                                </div>
                            </div>
                            <div class="col-md-12 mt-2 table-container">
                                <table id="product-table" class="table product-list">
                                    <thead class="d-none">
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @for ($i=0; $i < ceil($product_number/4); $i++)
                                        <tr>
                                            <td class="product-img" title="{{$ezpos_product_list[0+$i*4]->name}}" data-product ="{{$ezpos_product_list[0+$i*4]->code . ' (' . $ezpos_product_list[0+$i*4]->name . ')'}}"><img  src="{{url('public/images/product',$ezpos_product_list[0+$i*4]->image)}}" width="100%" />
                                                <p>{{$ezpos_product_list[0+$i*4]->name}}</p></td>
                                            @if(!empty($ezpos_product_list[1+$i*4]))
                                            <td class="product-img" title="{{$ezpos_product_list[1+$i*4]->name}}" data-product ="{{$ezpos_product_list[1+$i*4]->code . ' (' . $ezpos_product_list[1+$i*4]->name . ')'}}"><img  src="{{url('public/images/product',$ezpos_product_list[1+$i*4]->image)}}" width="100%" />
                                                <p>{{$ezpos_product_list[1+$i*4]->name}}</p></td>
                                            @else
                                            <td></td>
                                            @endif
                                            @if(!empty($ezpos_product_list[2+$i*4]))
                                            <td class="product-img" title="{{$ezpos_product_list[2+$i*4]->name}}" data-product ="{{$ezpos_product_list[2+$i*4]->code . ' (' . $ezpos_product_list[2+$i*4]->name . ')'}}"><img  src="{{url('public/images/product',$ezpos_product_list[2+$i*4]->image)}}" width="100%" />
                                                <p>{{$ezpos_product_list[2+$i*4]->name}}</p></td>
                                            @else
                                            <td></td>
                                            @endif
                                            @if(!empty($ezpos_product_list[3+$i*4]))
                                            <td class="product-img" title="{{$ezpos_product_list[3+$i*4]->name}}" data-product ="{{$ezpos_product_list[3+$i*4]->code . ' (' . $ezpos_product_list[3+$i*4]->name . ')'}}"><img  src="{{url('public/images/product',$ezpos_product_list[3+$i*4]->image)}}" width="100%" />
                                                <p>{{$ezpos_product_list[3+$i*4]->name}}</p></td>
                                            @else
                                            <td></td>
                                            @endif
                                        </tr>
                                    @endfor
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- product edit modal -->
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
                                    <label><strong>{{trans('file.Quantity')}}</strong></label>
                                    <input type="text" name="edit_qty" class="form-control numkey">
                                </div>
                                <div class="form-group">
                                    <label><strong>{{trans('file.Unit')}} {{trans('file.Discount')}}</strong></label>
                                    <input type="text" name="edit_discount" class="form-control numkey">
                                </div>
                                <div class="form-group">
                                    <label><strong>{{trans('file.Unit Price')}}</strong></label>
                                    <input type="text" name="edit_unit_price" class="form-control numkey" step="any">
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
            <!-- add customer modal -->
            <div id="addCustomer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                <div role="document" class="modal-dialog">
                  <div class="modal-content">
                    {!! Form::open(['route' => 'customer.store', 'method' => 'post', 'files' => true]) !!}
                    <div class="modal-header">
                      <h5 id="exampleModalLabel" class="modal-title">{{trans('file.add')}} {{trans('file.customer')}}</h5>
                      <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                      <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
                        <div class="form-group">
                            <label><strong>{{trans('file.Customer Group')}} *</strong> </label>
                            <select required class="form-control selectpicker" name="customer_group_id">
                                @foreach($ezpos_customer_group_all as $customer_group)
                                    <option value="{{$customer_group->id}}">{{$customer_group->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label><strong>{{trans('file.name')}} *</strong> </label>
                            <input type="text" name="name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label><strong>{{trans('file.Email')}}</strong></label>
                            <input type="text" name="email" placeholder="example@example.com" class="form-control">
                        </div>
                        <div class="form-group">
                            <label><strong>{{trans('file.Phone Number')}} *</strong></label>
                            <input type="text" name="phone_number" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label><strong>{{trans('file.Address')}} *</strong></label>
                            <input type="text" name="address" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label><strong>{{trans('file.City')}} *</strong></label>
                            <input type="text" name="city" required class="form-control">
                        </div>
                        <div class="form-group">
                        <input type="hidden" name="pos" value="1">      
                          <input type="submit" value="{{trans('file.submit')}}" class="btn btn-primary">
                        </div>
                    </div>
                    {{ Form::close() }}
                  </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">

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
var product_type = [];

// array data with selection
var product_price = [];
var product_discount = [];
var tax_rate = [];
var tax_name = [];
var tax_method = [];

var deposit = <?php echo json_encode($deposit) ?>;
var product_row_number = <?php echo json_encode($ezpos_pos_setting_data->product_number) ?>;
var rowindex;
var customer_group_rate;
var row_product_price;
var pos;
var keyboard_active = <?php echo json_encode($keybord_active); ?>;
var role_id = <?php echo json_encode(\Auth::user()->role_id) ?>;
var store_id = <?php echo json_encode(\Auth::user()->store_id) ?>;
var rownumber = $('table.order-list tbody tr:last').index();

for(rowindex  =0; rowindex <= rownumber; rowindex++){
    product_price.push(parseFloat($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.product_price').val()));
    var total_discount = parseFloat($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.total-discount').val());
    var quantity = parseFloat($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.qty').val());
    product_discount.push((total_discount / quantity).toFixed(2));
    tax_rate.push(parseFloat($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.tax-rate').val()));
    tax_name.push($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.tax-name').val());
    tax_method.push($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.tax-method').val());
}

$('.selectpicker').selectpicker({
    style: 'btn-link',
});

if(keyboard_active==1){

    $("input.numkey:text").keyboard({
        usePreview: false,
        layout: 'custom',
        display: {
        'accept'  : '&#10004;',
        'cancel'  : '&#10006;'
        },
        customLayout : {
          'normal' : ['1 2 3', '4 5 6', '7 8 9','0 {dec} {bksp}','{clear} {cancel} {accept}']
        },
        restrictInput : true, // Prevent keys not in the displayed keyboard from being typed in
        preventPaste : true,  // prevent ctrl-v and right click
        autoAccept : true,
        css: {
            // input & preview
            // keyboard container
            container: 'center-block dropdown-menu', // jumbotron
            // default state
            buttonDefault: 'btn btn-default',
            // hovered button
            buttonHover: 'btn-primary',
            // Action keys (e.g. Accept, Cancel, Tab, etc);
            // this replaces "actionClass" option
            buttonAction: 'active'
        },
    });

    $('input[type="text"]:not(#date)').keyboard({
        usePreview: false,
        autoAccept: true,
        autoAcceptOnEsc: true,
        css: {
            // input & preview
            // keyboard container
            container: 'center-block dropdown-menu', // jumbotron
            // default state
            buttonDefault: 'btn btn-default',
            // hovered button
            buttonHover: 'btn-primary',
            // Action keys (e.g. Accept, Cancel, Tab, etc);
            // this replaces "actionClass" option
            buttonAction: 'active',
            // used when disabling the decimal button {dec}
            // when a decimal exists in the input area
            buttonDisabled: 'disabled'
        },
        change: function(e, keyboard) {
                keyboard.$el.val(keyboard.$preview.val())
                keyboard.$el.trigger('propertychange')        
              }
    });

    $('textarea').keyboard({
        usePreview: false,
        autoAccept: true,
        autoAcceptOnEsc: true,
        css: {
            // input & preview
            // keyboard container
            container: 'center-block dropdown-menu', // jumbotron
            // default state
            buttonDefault: 'btn btn-default',
            // hovered button
            buttonHover: 'btn-primary',
            // Action keys (e.g. Accept, Cancel, Tab, etc);
            // this replaces "actionClass" option
            buttonAction: 'active',
            // used when disabling the decimal button {dec}
            // when a decimal exists in the input area
            buttonDisabled: 'disabled'
        },
        change: function(e, keyboard) {
                keyboard.$el.val(keyboard.$preview.val())
                keyboard.$el.trigger('propertychange')        
              }
    });

    $('#ezpos_productcodeSearch').keyboard().autocomplete().addAutocomplete({
        // add autocomplete window positioning
        // options here (using position utility)
        position: {
          of: '#ezpos_productcodeSearch',
          my: 'top+18px',
          at: 'center',
          collision: 'flip'
        }
    });
}

$('select[name=customer_id]').val($("input[name='customer_id_hidden']").val());
$('select[name=order_tax_rate]').val($("input[name='order_tax_rate_hidden']").val());
$('select[name=store_id]').val($("input[name='store_id_hidden']").val());
$('select[name=biller_id]').val($("input[name='biller_id_hidden']").val());
if(role_id > 2){
    $('.date').addClass('d-none');
    $('.store_id').addClass('d-none');
    $('select[name=store_id]').val(store_id);
}
else
    $('select[name=store_id]').val($("input[name='store_id_hidden']").val());

$('.selectpicker').selectpicker('refresh');

var id = $('select[name="customer_id"]').val();
$.get('../getcustomergroup/' + id, function(data) {
    customer_group_rate = (data / 100);
});

var id = $('select[name="store_id"]').val();
$.get('../getproduct/' + id, function(data) {
    ezpos_product_array = [];
    product_code = data[0];
    product_name = data[1];
    product_qty = data[2];
    product_type = data[3];
    $.each(product_code, function(index) {
        ezpos_product_array.push(product_code[index] + ' (' + product_name[index] + ')');
    });
});

if(keyboard_active==1){
    $('#ezpos_productcodeSearch').bind('keyboardChange', function (e, keyboard, el) {
        var customer_id = $('#customer_id').val();
        var store_id = $('select[name="store_id"]').val();
        temp_data = $('#ezpos_productcodeSearch').val();
        if(!customer_id){
            $('#ezpos_productcodeSearch').val(temp_data.substring(0, temp_data.length - 1));
            alert('Please select Customer!');
        }
        else if(!store_id){
            $('#ezpos_productcodeSearch').val(temp_data.substring(0, temp_data.length - 1));
            alert('Please select store!');
        }
    });
}
else{
    $('#ezpos_productcodeSearch').on('input', function(){
        var customer_id = $('#customer_id').val();
        var store_id = $('#store_id').val();
        temp_data = $('#ezpos_productcodeSearch').val();
        if(!customer_id){
            $('#ezpos_productcodeSearch').val(temp_data.substring(0, temp_data.length - 1));
            alert('Please select Customer!');
        }
        else if(!store_id){
            $('#ezpos_productcodeSearch').val(temp_data.substring(0, temp_data.length - 1));
            alert('Please select store!');
        }

    });
}

$('#filter-btn').on('click', function(){
    var category_id = $('select[name="category_id"]').val();
    var brand_id = $('select[name="brand_id"]').val();

    $(".table-container").children().remove();
    $.get('../getproduct/' + category_id + '/' + brand_id, function(data) {
        var tableData = '<table id="product-table" class="table product-list"> <thead class="d-none"> <tr> <th></th> <th></th> <th></th> <th></th> </tr></thead> <tbody><tr>';
        if (Object.keys(data).length != 0) {
            $.each(data['name'], function(index) {
                var product_info = data['code'][index]+' (' + data['name'][index] + ')';
                if(index % 4 == 0 && index != 0){
                    tableData += '</tr><tr><td class="product-img" title="'+data['name'][index]+'" data-product = "'+product_info+'"><img  src="../../public/images/product/'+data['image'][index]+'" width="100%" /><p>'+data['name'][index]+'</p></td>';
                }
                else
                    tableData += '<td class="product-img" title="'+data['name'][index]+'" data-product = "'+product_info+'"><img  src="../../public/images/product/'+data['image'][index]+'" width="100%" /><p>'+data['name'][index]+'</p></td>';
            });

            if(data['name'].length % 4){
                var number = 4 - (data['name'].length % 4);
                while(number > 0)
                {
                    tableData += '<td></td>';
                    number--;
                }
            }

            tableData += '</tr></tbody></table>';
            $(".table-container").html(tableData);
            $('#product-table').DataTable( {
            "order": [],
            'pageLength': product_row_number,
            dom: 'tp'
            });
            $('table.product-list').hide();
            $('table.product-list').show(500);
        }
        else{
            tableData += '<td class="text-center">No data avaialable</td></tr></tbody></table>'
            $(".table-container").html(tableData);
        }
    });
});

$('select[name="customer_id"]').on('change', function() {
    var id = $(this).val();
    $.get('../getcustomergroup/' + id, function(data) {
        customer_group_rate = (data / 100);
    });
});

$('select[name="store_id"]').on('change', function() {
    var id = $(this).val();
    $.get('../getproduct/' + id, function(data) {
        ezpos_product_array = [];
        product_code = data[0];
        product_name = data[1];
        product_qty = data[2];
        product_type = data[3];
        $.each(product_code, function(index) {
            ezpos_product_array.push(product_code[index] + ' (' + product_name[index] + ')');
        });
    });
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
                $(".product-code").each(function(i) {
                    if ($(this).val() == data[1]) {
                        rowindex = i;
                        var qty = parseFloat($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val()) + 1;
                        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val(qty);
                        flag = 0;
                        checkQuantity(String(qty), true);
                    }
                });
                $("input[name='product_code_name']").val('');
                if(flag){
                    addNewProduct(data);
                }
            }
        });
    }
});

$('#myTable').keyboard({
        accepted : function(event, keyboard, el) {
            checkQuantity(el.value, true);
      }
    });

$("#myTable").on('click', '.plus', function() {
    rowindex = $(this).closest('tr').index();
    var qty = parseFloat($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val()) + 1;
    $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val(qty);
    checkQuantity(String(qty), true);
});

$("#myTable").on('click', '.minus', function() {
    rowindex = $(this).closest('tr').index();
    var qty = parseFloat($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val()) - 1;
    $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val(qty);
    checkQuantity(String(qty), true);
});

//Change quantity
$("#myTable").on('input', '.qty', function() {
    rowindex = $(this).closest('tr').index();
    checkQuantity($(this).val(), true);
});

$("#myTable").on('click', '.qty', function() {
    rowindex = $(this).closest('tr').index();
});


$(document).on('click', '.product-img', function(){
    var customer_id = $('#customer_id').val();
    var store_id = $('select[name="store_id"]').val();
    if(!customer_id)
        alert('Please select Customer!');
    else if(!store_id)
        alert('Please select store!');
    else{
        var data = $(this).data('product');
        data = data.split(" ");
        pos = product_code.indexOf(data[0]);
        if(pos < 0)
            alert('Product is not avaialable in the selected store');
        else{
           $.ajax({
                type: 'GET',
                url: '../ezpos_product_search',
                data: {
                    data: data[0]
                },
                success: function(data) {
                    var flag = 1;
                    $(".product-code").each(function(i) {
                        if ($(this).val() == data[1]) {
                            rowindex = i;
                            var qty = parseFloat($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val()) + 1;
                            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val(qty);
                            flag = 0;
                            checkQuantity(String(qty), true);
                        }
                    });
                    $("input[name='product_code_name']").val('');
                    if(flag){
                        addNewProduct(data);
                    }
                }
           }); 
        }
    }
});
//Delete product
$("table.order-list tbody").on("click", ".ibtnDel", function(event) {
    rowindex = $(this).closest('tr').index();
    product_price.splice(rowindex, 1);
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
    edit();
});

//Update product
$('button[name="update_btn"]').on("click", function() {
    var edit_discount = $('input[name="edit_discount"]').val();
    var edit_qty = $('input[name="edit_qty"]').val();
    var edit_unit_price = $('input[name="edit_unit_price"]').val();

    if (parseFloat(edit_discount) > parseFloat(edit_unit_price)) {
        alert('Invalid Discount Input!');
        return;
    }

    var tax_rate_all = <?php echo json_encode($tax_rate_all) ?>;
    tax_rate[rowindex] = parseFloat(tax_rate_all[$('select[name="edit_tax_rate"]').val()]);
    tax_name[rowindex] = $('select[name="edit_tax_rate"] option:selected').text();
    product_discount[rowindex] = $('input[name="edit_discount"]').val();
    product_price[rowindex] = $('input[name="edit_unit_price"]').val();
    checkQuantity(edit_qty, false);
});

$('button[name="order_discount_btn"]').on("click", function() {
    calculateGrandTotal();
});

$('button[name="shipping_cost_btn"]').on("click", function() {
    calculateGrandTotal();
});

$('button[name="order_tax_btn"]').on("click", function() {
    calculateGrandTotal();
});

$("#submit-btn").on("click",function(){
    $(".payment-form").submit();
});

function addNewProduct(data){
    var newRow = $("<tr>");
    var cols = '';
    cols += '<td class="col-sm-3 product-title">' + data[0] + ':' + data[1] + '<button type="button" class="edit-product btn btn-link" data-toggle="modal" data-target="#editModal"> <i class="fa fa-edit"></i></button></td>';
    cols += '<td class="col-sm-2 product-price"></td>';
    cols += '<td class="col-sm-3"><div class="input-group"><span class="input-group-btn"><button type="button" class="btn btn-default minus"><span class="fa fa-minus"></span></button></span><input type="text" name="qty[]" class="form-control qty numkey input-number" value="1" step="any" required><span class="input-group-btn"><button type="button" class="btn btn-default plus"><span class="fa fa-plus"></span></button></span></div></td>';
    cols += '<td class="col-sm-3 sub-total"></td>';
    cols += '<td class="col-sm-1"><button type="button" class="ibtnDel btn btn-danger btn-sm">X</button></td>';
    cols += '<input type="hidden" class="product-code" name="product_code[]" value="' + data[1] + '"/>';
    cols += '<input type="hidden" class="product-id" name="product_id[]" value="' + data[7] + '"/>';
    cols += '<input type="hidden" class="sale-unit" name="sale_unit[]" value="' + data[6] + '"/>';
    cols += '<input type="hidden" class="net_unit_price" name="net_unit_price[]" />';
    cols += '<input type="hidden" class="discount-value" name="discount[]" />';
    cols += '<input type="hidden" class="tax-rate" name="tax_rate[]" value="' + data[3] + '"/>';
    cols += '<input type="hidden" class="tax-value" name="tax[]" />';
    cols += '<input type="hidden" class="subtotal-value" name="subtotal[]" />';

    newRow.append(cols);
    if(keyboard_active==1){
        $("table.order-list tbody").append(newRow).find('.qty').keyboard({usePreview: false, layout: 'custom', display: { 'accept'  : '&#10004;', 'cancel'  : '&#10006;' }, customLayout : {
          'normal' : ['1 2 3', '4 5 6', '7 8 9','0 {dec} {bksp}','{clear} {cancel} {accept}']}, restrictInput : true, preventPaste : true, autoAccept : true, css: { container: 'center-block dropdown-menu', buttonDefault: 'btn btn-default', buttonHover: 'btn-primary',buttonAction: 'active', buttonDisabled: 'disabled'},});
    }
    else
        $("table.order-list tbody").append(newRow);

    product_price.push(parseFloat(data[2]) + parseFloat(data[2] * customer_group_rate));
    product_discount.push('0.00');
    tax_rate.push(parseFloat(data[3]));
    tax_name.push(data[4]);
    tax_method.push(data[5]);
    rowindex = newRow.index();
    checkQuantity(1, true);
}

function edit(){
    var row_product_name_code = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(1)').text();
    $('#modal_header').text(row_product_name_code);

    var qty = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.qty').val();
    $('input[name="edit_qty"]').val(qty);

    $('input[name="edit_discount"]').val(parseFloat(product_discount[rowindex]).toFixed(2));

    var tax_name_all = <?php echo json_encode($tax_name_all) ?>;
    pos = tax_name_all.indexOf(tax_name[rowindex]);
    $('select[name="edit_tax_rate"]').val(pos);

    var row_product_code = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.product-code').val();
    pos = product_code.indexOf(row_product_code);
    row_product_price = product_price[rowindex];
    $('input[name="edit_unit_price"]').val(parseFloat(row_product_price).toFixed(2));
}

function checkQuantity(sale_qty, flag) {
    var row_product_code = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.product-code').val();
    pos = product_code.indexOf(row_product_code);
    if(product_type[pos] == 'standard'){
        //alert(product_qty[pos]);
        if (parseFloat(sale_qty) > product_qty[pos]) {
            alert('Quantity exceeds stock quantity!');
            if (flag) {
                sale_qty = sale_qty.substring(0, sale_qty.length - 1);
                $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.qty').val(sale_qty);
                checkQuantity(sale_qty, true);
            } else {
                edit();
                return;
            }
        }
    }

    $('#editModal').modal('hide');
    $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.qty').val(sale_qty);
    calculateRowProductData(sale_qty);

}

function calculateRowProductData(quantity) {
    row_product_price = product_price[rowindex];

    $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.discount-value').val((product_discount[rowindex] * quantity).toFixed(2));

    $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.tax-rate').val(tax_rate[rowindex].toFixed(2));

    if (tax_method[rowindex] == 1) {
        var net_unit_price = row_product_price - product_discount[rowindex];
        var tax = net_unit_price * quantity * (tax_rate[rowindex] / 100);
        var sub_total = (net_unit_price * quantity) + tax;
        if(quantity)
            var sub_total_unit = sub_total / quantity;
        else
            var sub_total_unit = sub_total;

        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.net_unit_price').val(net_unit_price.toFixed(2));
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.tax-value').val(tax.toFixed(2));
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(2)').text(sub_total_unit.toFixed(2));
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(4)').text(sub_total.toFixed(2));
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.subtotal-value').val(sub_total.toFixed(2));
    } else {
        var sub_total_unit = row_product_price - product_discount[rowindex];
        var net_unit_price = (100 / (100 + tax_rate[rowindex])) * sub_total_unit;
        var tax = (sub_total_unit - net_unit_price) * quantity;
        var sub_total = sub_total_unit * quantity;

        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.net_unit_price').val(net_unit_price.toFixed(2));
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.tax-value').val(tax.toFixed(2));
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(2)').text(sub_total_unit.toFixed(2));
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(4)').text(sub_total.toFixed(2));
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.subtotal-value').val(sub_total.toFixed(2));
    }
    calculateTotal();
}

function calculateTotal() {
    //Sum of quantity
    var total_qty = 0;
    $("table.order-list tbody .qty").each(function(index) {
        if ($(this).val() == '') {
            total_qty += 0;
        } else {
            total_qty += parseFloat($(this).val());
        }
    });
    $('input[name="total_qty"]').val(total_qty);

    //Sum of discount
    var total_discount = 0;
    $("table.order-list tbody .discount-value").each(function() {
        total_discount += parseFloat($(this).val());
    });

    $('input[name="total_discount"]').val(total_discount.toFixed(2));

    //Sum of tax
    var total_tax = 0;
    $(".tax-value").each(function() {
        total_tax += parseFloat($(this).val());
    });

    $('input[name="total_tax"]').val(total_tax.toFixed(2));

    //Sum of subtotal
    var total = 0;
    $(".sub-total").each(function() {
        total += parseFloat($(this).text());
    });
    $('input[name="total_price"]').val(total.toFixed(2));

    calculateGrandTotal();
}

function calculateGrandTotal() {

    var item = $('table.order-list tbody tr:last').index();

    var total_qty = parseFloat($('input[name="total_qty"]').val());
    var subtotal = parseFloat($('input[name="total_price"]').val());
    var order_tax = parseFloat($('select[name="order_tax_rate"]').val());
   var order_discount = parseFloat($('input[name="order_discount"]').val());
   if (!order_discount)
        order_discount = 0.00;
   var total_discount = order_discount + parseFloat($('input[name="total_discount"]').val());
   $("#discount").text(total_discount.toFixed(2));

   var shipping_cost = parseFloat($('input[name="shipping_cost"]').val());
    if (!shipping_cost)
        shipping_cost = 0.00;

    item = ++item + '(' + total_qty + ')';
    order_tax = (subtotal - order_discount) * (order_tax / 100);
    var total_tax = order_tax + parseFloat($('input[name="total_tax"]').val());
    var grand_total = (subtotal + order_tax + shipping_cost) - order_discount;

    $('#item').text(item);
    $('input[name="item"]').val($('table.order-list tbody tr:last').index() + 1);
    $('#subtotal').text(subtotal.toFixed(2));
    $('#tax').text(total_tax.toFixed(2));
    $('input[name="order_tax"]').val(order_tax.toFixed(2));
    $('#shipping-cost').text(shipping_cost.toFixed(2));
    $('#grand-total').text(grand_total.toFixed(2));
    $('input[name="grand_total"]').val(grand_total.toFixed(2));
}

$('.payment-form').on('submit',function(e){
    var rownumber = $('table.order-list tbody tr:last').index();
    if (rownumber < 0) {
        alert("Please insert product to order table!")
        e.preventDefault();
    }
});

$('#product-table').DataTable( {
    "order": [],
    'pageLength': product_row_number,
    dom: 'tp'
});

</script>
@endsection
@section('scripts')
<script type="text/javascript" src="https://js.stripe.com/v3/"></script>

@endsection



@extends('layout.top-head') @section('content')
@if($errors->has('phone_number'))
<div class="alert alert-danger alert-dismissible text-center">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ $errors->first('phone_number') }}</div>
@endif 
@if(session()->has('message'))
    @php
        if(session()->get('message') == 'Sale created successfully')
            $flag = 1;
    @endphp
    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div>
@endif
@if(session()->has('not_permitted'))
    <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div> 
@endif
<style>
 .pos-page header.header,.pos-page .card{
	 width:100% !important;
     margin-right: 0px !important;
 }
</style>
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                        {!! Form::open(['route' => 'sale.store', 'method' => 'post', 'files' => true, 'class' => 'payment-form']) !!}
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
                                            <input type="text" id="date" name="date" value="{{date('d-m-Y')}}" class="form-control pos-text" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6 store_id">
                                        <div class="form-group">
                                            @if($ezpos_pos_setting_data)
                                            <input type="hidden" name="store_id_hidden" value="{{$ezpos_pos_setting_data->store_id}}">
                                            @endif
                                            <select required id="store_id" name="store_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select store...">
                                                @foreach($ezpos_store_list as $store)
                                                <option value="{{$store->id}}">{{$store->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            @if($ezpos_pos_setting_data)
                                            <input type="hidden" name="customer_id_hidden" value="{{$ezpos_pos_setting_data->customer_id}}">
                                            @endif
                                            <div class="input-group pos">
                                                <select required name="customer_id" id="customer_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select customer...">
                                                @foreach($ezpos_customer_list as $customer)
                                                    @php $deposit[$customer->id] = $customer->deposit - $customer->expense; @endphp
                                                    <option value="{{$customer->id}}">{{$customer->name . ' (' . $customer->phone_number . ')'}}</option>
                                                @endforeach
                                                </select>
                                                <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#addCustomer" title="Add Customer"><i class="fa fa-plus"></i></button>
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
                                            </tbody>
                                            <tfoot class="tfoot active">
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="hidden" name="total_qty" />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="hidden" name="total_discount" value="0.00" />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="hidden" name="total_tax" value="0.00"/>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="hidden" name="total_price" />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="hidden" name="item" />
                                            <input type="hidden" name="order_tax" />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="hidden" name="grand_total" />
                                            <input type="hidden" name="sale_status" value="1" />
                                            <input type="hidden" name="draft" value="0" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <table class="table table-bordered table-condensed totals">
                                        <tr>
                                            <td><strong>{{trans('file.Items')}}</strong>
                                            <span class="pull-right" id="item">0</span>
                                            </td>
                                            <td><strong>{{trans('file.Total')}}</strong>
                                                <span class="pull-right" id="subtotal">0.00</span>
                                            </td>
                                            <td><strong>{{trans('file.Discount')}}</strong>
                                                <button type="button" class="btn btn-link" data-toggle="modal" data-target="#order-discount"> <i class="fa fa-edit"></i></button>
                                                <span class="pull-right pos-btn" id="discount">0.00</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>{{trans('file.Tax')}}</strong>
                                            <button type="button" class="btn btn-link" data-toggle="modal" data-target="#order-tax"><i class="fa fa-edit"></i></button>
                                            <span class="pull-right pos-btn" id="tax">0.00</span>
                                            </td>
                                            <td><strong>{{trans('file.Shipping')}}</strong>
                                                <button type="button" class="btn btn-link" data-toggle="modal" data-target="#shipping-cost-modal"><i class="fa fa-edit"></i></button>
                                                <span class="pull-right pos-btn" id="shipping-cost">0.00</span>
                                            </td>
                                            <td><strong>{{trans('file.grand total')}}</strong>
                                                <span class="pull-right" id="grand-total">0.00</span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="column-5">
                                    <button style="background: #0066cc" type="button" class="btn btn-custom" data-toggle="modal" data-target="#add-payment" id="credit-card-btn"><i class="fa fa-credit-card"></i> Card</button>   
                                </div>
                                <div class="column-5">
                                    <button style="background: #47d147" type="button" class="btn btn-custom" data-toggle="modal" data-target="#add-payment" id="cash-btn"><i class="fa fa-money"></i> Cash</button>
                                </div>
                                <div class="column-5">
                                    <button style="background-color: #6666ff" type="button" class="btn btn-custom" data-toggle="modal" data-target="#add-payment" id="paypal-btn"><i class="fa fa-paypal"></i> Paypal</button>
                                </div>
                                <div class="column-5">
                                    <button style="background-color: #e28d02" type="button" class="btn btn-custom" id="draft-btn"><i class="ion-android-drafts"></i> Draft</button>
                                </div>
                                <div class="column-5">
                                    <button style="background-color: #163951" type="button" class="btn btn-custom" data-toggle="modal" data-target="#add-payment" id="cheque-btn"><i class="ion-cash"></i> Cheque</button>
                                </div>
                                <div class="column-5">
                                    <button style="background-color: #800080" type="button" class="btn btn-custom" data-toggle="modal" data-target="#add-payment" id="gift-card-btn"><i class="ion-card"></i> GiftCard</button>
                                </div>
                                <div class="column-5">
                                    <button style="background-color: #7f4f01" type="button" class="btn btn-custom" data-toggle="modal" data-target="#add-payment" id="deposit-btn"><i class="fa fa-university"></i> Deposit</button>
                                </div>
                                <div class="column-5">
                                    <button style="background-color: #cc0000;" type="button" class="btn btn-custom" id="cancel-btn" onclick="return confirmCancel()"><i class="ion-android-cancel"></i> Cancel</button>
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
                                <input type="text" name="order_discount" class="form-control numkey" step="any">
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
                                <input type="text" name="shipping_cost" class="form-control numkey" step="any">
                            </div>
                            <button type="button" name="shipping_cost_btn" class="btn btn-primary" data-dismiss="modal">{{trans('file.submit')}}</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- payment modal -->
            <div id="add-payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                <div role="document" class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 id="exampleModalLabel" class="modal-title">{{trans('file.Finalize')}} {{trans('file.Sale')}}</h5>
                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="">
                                <label><strong>{{trans('file.Payment')}} {{trans('file.reference')}} : </strong></label>
                                <span style="color: #868e96">{{'spr-' . date("Ymd") . '-'. date("his")}}</span>
                            </div>
                            <div class="form-group">
                                <label><strong>{{trans('file.Paid')}} {{trans('file.Amount')}} *</strong></label>
                                <input type="text" name="paid_amount" class="form-control numkey" required step="any">
                            </div>
                            <div class="form-group">
                                <label><strong>{{trans('file.Paid')}} {{trans('file.By')}}</strong></label>
                                <select name="paid_by_id" class="form-control">
                                    <option value="1">Cash</option>
                                    <option value="2">Gift Card</option>
                                    <option value="3">Credit Card</option>
                                    <option value="4">Cheque</option>
                                    <option value="5">Paypal</option>
                                    <option value="6">Deposit</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="card-element form-control">
                                </div>
                                <div class="card-errors" role="alert"></div>
                            </div>
                            <div class="form-group" id="gift-card">
                                <label><strong> {{trans('file.Gift Card')}}</strong></label>
                                <input type="hidden" name="gift_card_id">
                                <select id="gift_card_id_select" name="gift_card_id_select" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Gift Card..."></select>
                            </div>
                            <div id="cheque">
                                <div class="form-group">
                                    <label><strong>{{trans('file.Cheque')}} No</strong></label>
                                    <input type="text" name="cheque_no" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label><strong>{{trans('file.Payment')}} {{trans('file.Note')}}</strong></label>
                                <textarea id="payment_note" rows="2" class="form-control" name="payment_note"></textarea>
                            </div>
                            <div class="row">
                               <div class="col-md-6 form-group">
                                    <label><strong>{{trans('file.Sale')}} {{trans('file.Note')}}</strong></label>
                                    <textarea rows="3" class="form-control" name="sale_note"></textarea>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label><strong>{{trans('file.Staff')}} {{trans('file.Note')}}</strong></label>
                                    <textarea rows="3" class="form-control" name="staff_note"></textarea>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button id="submit-btn" type="submit" class="btn btn-primary">{{trans('file.submit')}}</button>
                            </div>
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
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                  <h4>{{trans('file.Recent Transaction')}}</h4>
                                  <div class="right-column">
                                    <div class="badge badge-primary">{{trans('file.latest')}} 10</div>
                                  </div>
                                  <button class="btn btn-default btn-sm transaction-btn-plus" type="button" data-toggle="collapse" data-target="#transaction" aria-expanded="false" aria-controls="transaction"><i class="ion-plus-circled"></i></button>
                                  <button class="btn btn-default btn-sm transaction-btn-close d-none" type="button" data-toggle="collapse" data-target="#transaction" aria-expanded="false" aria-controls="transaction"><i class="ion-close-circled"></i></button>
                                </div>
                                <div class="collapse" id="transaction">
                                    <div class="card card-body">
                                        <ul class="nav nav-tabs" role="tablist">
                                          <li class="nav-item">
                                            <a class="nav-link active" href="#sale-latest" role="tab" data-toggle="tab">{{trans('file.Sale')}}</a>
                                          </li>
                                          <li class="nav-item">
                                            <a class="nav-link" href="#draft-latest" role="tab" data-toggle="tab">{{trans('file.Draft')}}</a>
                                          </li>
                                        </ul>
                                        <div class="tab-content">
                                          <div role="tabpanel" class="tab-pane show active" id="sale-latest">
                                              <div class="table-responsive">
                                                <table class="table table-striped">
                                                  <thead>
                                                    <tr>
                                                      <th>{{trans('file.date')}}</th>
                                                      <th>{{trans('file.reference')}}</th>
                                                      <th>{{trans('file.customer')}}</th>
                                                      <th>{{trans('file.grand total')}}</th>
                                                      <th>{{trans('file.action')}}</th>
                                                    </tr>
                                                  </thead>
                                                  <tbody>
                                                    @foreach($recent_sale as $sale)
                                                    <?php $customer = DB::table('customers')->find($sale->customer_id); ?>
                                                    <tr>
                                                      <td>{{date('d-m-Y', strtotime($sale->date))}}</td>
                                                      <td>{{$sale->reference_no}}</td>
                                                      <td>{{$customer->name}}</td>
                                                      <td>{{$sale->grand_total}}</td>
                                                      <td>
                                                        <div class="btn-group">
                                                            @if(in_array("sales-edit", $all_permission))
                                                            <a href="{{ route('sale.edit', ['id' => $sale->id]) }}" class="btn btn-success btn-sm" title="Edit"><i class="fa fa-edit"></i></a>&nbsp;
                                                            @endif
                                                            @if(in_array("sales-delete", $all_permission))
                                                            {{ Form::open(['route' => ['sale.destroy', $sale->id], 'method' => 'DELETE'] ) }}
                                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirmDelete()" title="Delete"><i class="fa fa-trash"></i></button>
                                                            {{ Form::close() }}
                                                            @endif
                                                        </div>
                                                      </td>
                                                    </tr>
                                                    @endforeach
                                                  </tbody>
                                                </table>
                                              </div>
                                          </div>
                                          <div role="tabpanel" class="tab-pane fade" id="draft-latest">
                                              <div class="table-responsive">
                                                <table class="table table-striped">
                                                  <thead>
                                                    <tr>
                                                      <th>{{trans('file.date')}}</th>
                                                      <th>{{trans('file.reference')}}</th>
                                                      <th>{{trans('file.customer')}}</th>
                                                      <th>{{trans('file.grand total')}}</th>
                                                      <th>{{trans('file.action')}}</th>
                                                    </tr>
                                                  </thead>
                                                  <tbody>
                                                    @foreach($recent_draft as $draft)
                                                    <?php $customer = DB::table('customers')->find($draft->customer_id); ?>
                                                    <tr>
                                                      <td>{{date('d-m-Y', strtotime($draft->date))}}</td>
                                                      <td>{{$draft->reference_no}}</td>
                                                      <td>{{$customer->name}}</td>
                                                      <td>{{$draft->grand_total}}</td>
                                                      <td>
                                                        <div class="btn-group">
                                                            @if(in_array("sales-edit", $all_permission))
                                                            <a href="{{url('sale/'.$draft->id.'/create') }}" class="btn btn-success btn-sm" title="Edit"><i class="fa fa-edit"></i></a>&nbsp;
                                                            @endif
                                                            @if(in_array("sales-delete", $all_permission))
                                                            {{ Form::open(['route' => ['sale.destroy', $draft->id], 'method' => 'DELETE'] ) }}
                                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirmDelete()" title="Delete"><i class="fa fa-trash"></i></button>
                                                            {{ Form::close() }}
                                                            @endif
                                                        </div>
                                                      </td>
                                                    </tr>
                                                    @endforeach
                                                  </tbody>
                                                </table>
                                              </div>
                                          </div>
                                        </div>
                                    </div>
                                </div>
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

<div id="sale-details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 id="exampleModalLabel" class="modal-title">{{trans('file.Sale')}} {{trans('file.Details')}} &nbsp;&nbsp;</h5>
          <button id="print-btn" type="button" class="btn btn-default btn-sm"><i class="fa fa-print"></i> {{trans('file.Print')}}</button>
          <button type="button" id="close-btn" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
        </div>
            <div id="sale-content" class="modal-body">
                @php
                    $store = \App\Store::find($recent_sale[0]->store_id);
                    $customer = \App\Customer::find($recent_sale[0]->customer_id);
                    $product_sale_data = \App\Product_Sale::where('sale_id', $recent_sale[0]->id)->get();
                @endphp
                <strong>{{trans("file.Date")}}: </strong>{{date('d-m-Y',  strtotime($recent_sale[0]->date))}}<br>
                <strong>{{trans("file.reference")}}: </strong>{{$recent_sale[0]->reference_no}}<br>
                <strong>{{trans("file.Store")}}: </strong>{{$store->name}}<br>
                <strong>{{trans("file.Sale")}} {{trans("file.Status")}}: </strong>Completed<br><br>
                <div class="row">
                    <div class="col-md-6">
                        <strong>{{trans("file.To")}}:</strong><br>
                        {{$customer->name}}<br>
                        {{$customer->phone_number}}<br>
                        {{$customer->address}}<br>
                        {{$customer->city}}                        
                    </div>
                </div>
            </div>
            <table class="table table-bordered product-sale-list">
                <thead>
                    <th>#</th>
                    <th>{{trans('file.product')}}</th>
                    <th>Qty</th>
                    <th>{{trans('file.Unit Price')}}</th>
                    <th>{{trans('file.Tax')}}</th>
                    <th>{{trans('file.Discount')}}</th>
                    <th>{{trans('file.Subtotal')}}</th>
                </thead>
                <tbody>
                    @foreach($product_sale_data as $key=>$product_sale)
                    @php $product = \App\Product::find($product_sale->product_id) @endphp
                    <tr>
                        <td>{{$key + 1}}</td>
                        <td>{{$product->name}} [{{$product->code}}]</td>
                        @if($product_sale->unit != 'null')
                            <td>{{$product_sale->qty}} {{$product_sale->unit}}</td>
                        @else
                            <td>{{$product_sale->qty}}</td>
                        @endif
                        <td>{{$product_sale->total / $product_sale->qty}}</td>
                        <td>{{$product_sale->tax}} ({{$product_sale->tax_rate}}%)</td>
                        <td>{{$product_sale->discount}}</td>
                        <td>{{$product_sale->total}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="2"><strong>{{trans("file.Total")}}:</strong></td>
                        <td colspan="2">{{$recent_sale[0]->total_qty}}</td>
                        <td>{{$recent_sale[0]->total_tax}}</td>
                        <td>{{$recent_sale[0]->total_discount}}</td>
                        <td>{{$recent_sale[0]->total_price}}</td>
                    </tr>
                    <tr>
                        <td colspan=6><strong>{{trans("file.Order")}} {{trans("file.Tax")}}:</strong></td>
                        <td>{{$recent_sale[0]->order_tax}} ({{$recent_sale[0]->order_tax_rate}}%)</td>
                    </tr>
                    <tr>
                        <td colspan=6><strong>{{trans("file.Order")}} {{trans("file.Discount")}}:</strong></td>
                        <td>{{$recent_sale[0]->order_discount}}</td>
                    </tr>
                    <tr>
                        <td colspan=6><strong>{{trans("file.Shipping Cost")}}:</strong></td>
                        <td>{{$recent_sale[0]->shipping_cost}}</td>
                    </tr>
                    <tr>
                        <td colspan=6><strong>{{trans("file.grand total")}}:</strong></td>
                        <td>{{$recent_sale[0]->grand_total}}</td>
                    </tr>
                    <tr>
                        <td colspan=6><strong>{{trans("file.Paid")}} {{trans("file.Amount")}}:</strong></td>
                        <td>{{$recent_sale[0]->paid_amount}}</td>
                    </tr>
                    <tr>
                        <td colspan=6><strong>{{trans("file.Balance")}}:</strong></td>
                        <td>{{$recent_sale[0]->grand_total - $recent_sale[0]->paid_amount}}</td>
                    </tr>
                </tbody>
            </table>
            <div class="modal-body">
                <p><strong>{{trans("file.Sale")}} {{trans("file.Note")}}: </strong>{{$recent_sale[0]->sale_note}}</p>
                <p><strong>{{trans("file.Staff")}} {{trans("file.Note")}}: </strong>{{$recent_sale[0]->staff_note}}</p>
                <strong>{{trans("file.Created By")}}:</strong><br>
                {{\Auth::user()->name}}<br>
                {{\Auth::user()->email}}
            </div>
      </div>
    </div>
</div>

<script type="text/javascript">
    var flag = <?php echo json_encode($flag) ?>;
    if(flag){
        $('#sale-details').modal('show');
    }

    var public_key = <?php echo json_encode($ezpos_pos_setting_data->stripe_public_key); ?>;

    var product_row_number = <?php echo json_encode($ezpos_pos_setting_data->product_number); ?>;

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
var unit_name = [];
var unit_operator = [];
var unit_operation_value = [];
var gift_card_amount = [];
var gift_card_expense = [];

// temporary array
var temp_unit_name = [];
var temp_unit_operator = [];
var temp_unit_operation_value = [];

var deposit = <?php echo json_encode($deposit) ?>;
var rowindex;
var customer_group_rate;
var row_product_price;
var pos;
var keyboard_active = <?php echo json_encode($keybord_active); ?>;

var role_id = <?php echo json_encode(\Auth::user()->role_id) ?>;
var store_id = <?php echo json_encode(\Auth::user()->store_id) ?>;
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

if(role_id > 2){
    $('.date').addClass('d-none');
    $('.store_id').addClass('d-none');
    $('select[name=store_id]').val(store_id);
}
else
    $('select[name=store_id]').val($("input[name='store_id_hidden']").val());

$('.selectpicker').selectpicker('refresh');

var id = $('select[name="customer_id"]').val();
$.get('sale/getcustomergroup/' + id, function(data) {
    customer_group_rate = (data / 100);
});

var id = $('select[name="store_id"]').val();
$.get('sale/getproduct/' + id, function(data) {
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
    $.get('sale/getproduct/' + category_id + '/' + brand_id, function(data) {
        var tableData = '<table id="product-table" class="table product-list"> <thead class="d-none"> <tr> <th></th> <th></th> <th></th> <th></th> </tr></thead> <tbody><tr>';
        if (Object.keys(data).length != 0) {
            $.each(data['name'], function(index) {
                var product_info = data['code'][index]+' (' + data['name'][index] + ')';
                if(index % 4 == 0 && index != 0){
                    tableData += '</tr><tr><td class="product-img" title="'+data['name'][index]+'" data-product = "'+product_info+'"><img  src="public/images/product/'+data['image'][index]+'" width="100%" /><p>'+data['name'][index]+'</p></td>';
                }
                else
                    tableData += '<td class="product-img" title="'+data['name'][index]+'" data-product = "'+product_info+'"><img  src="public/images/product/'+data['image'][index]+'" width="100%" /><p>'+data['name'][index]+'</p></td>';
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

$("#print-btn").on("click", function(){
          var divToPrint=document.getElementById('sale-details');
          var newWin=window.open('','Print-Window');
          newWin.document.open();
          newWin.document.write('<style type="text/css">@media print { #print-btn { display: none } #close-btn { display: none } }</style><body onload="window.print()">'+divToPrint.innerHTML+'</body>');
          newWin.document.close();
          setTimeout(function(){newWin.close();},10);
    });

$('select[name="customer_id"]').on('change', function() {
    var id = $(this).val();
    $.get('sale/getcustomergroup/' + id, function(data) {
        customer_group_rate = (data / 100);
    });
});

$('select[name="store_id"]').on('change', function() {
    var id = $(this).val();
    $.get('sale/getproduct/' + id, function(data) {
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
            url: 'sale/ezpos_product_search',
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

//Change quantity
$("#myTable").on('input', '.qty', function() {
    rowindex = $(this).closest('tr').index();
    checkQuantity($(this).val(), true);
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
                url: 'sale/ezpos_product_search',
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

$("#draft-btn").on("click",function(){
    $('input[name="sale_status"]').val(2);
    $('input[name="paid_amount"]').prop('required',false);
    var rownumber = $('table.order-list tbody tr:last').index();
    if (rownumber < 0) {
        alert("Please insert product to order table!")
    }
    else
        $('.payment-form').submit();
});

$("#gift-card-btn").on("click",function(){
    $('select[name="paid_by_id"]').val(2);
    $('input[name="paid_amount"]').val($("#grand-total").text());
    giftCard();
});

$("#credit-card-btn").on("click",function(){
    $('select[name="paid_by_id"]').val(3);
    $('input[name="paid_amount"]').val($("#grand-total").text());
    creditCard();
});

$("#cheque-btn").on("click",function(){
    $('select[name="paid_by_id"]').val(4);
    $('input[name="paid_amount"]').val($("#grand-total").text());
    cheque();
});

$("#cash-btn").on("click",function(){
    $('select[name="paid_by_id"]').val(1);
    $('input[name="paid_amount"]').val($("#grand-total").text());
    hide();
});

$("#paypal-btn").on("click",function(){
    $('select[name="paid_by_id"]').val(5);
    $('input[name="paid_amount"]').val($("#grand-total").text());
    hide();
});

$("#deposit-btn").on("click",function(){
    $('select[name="paid_by_id"]').val(6);
    $('input[name="paid_amount"]').val($("#grand-total").text());
    hide();
    deposits();
});

$('select[name="paid_by_id"]').on("change", function() {       
    var id = $(this).val();
    $(".payment-form").off("submit");
    if(id == 2) {
        giftCard();
    }
    else if (id == 3) {
        creditCard();
    } else if (id == 4) {
        cheque();
    } else {
        hide();
        if (id == 6){
            deposits();
        }
    }
});

$('#add-payment select[name="gift_card_id_select"]').on("change", function() {
    var balance = gift_card_amount[$(this).val()] - gift_card_expense[$(this).val()];
    $('#add-payment input[name="gift_card_id"]').val($(this).val());
    if($('input[name="paid_amount"]').val() > balance){
        alert('Amount exceeds card balance! Gift Card balance: '+ balance);
    }
});

$('input[name="paid_amount"]').on("input", function() {
    var id = $('select[name="paid_by_id"]').val();
    if(id == 2){
        var balance = gift_card_amount[$("#gift_card_id_select").val()] - gift_card_expense[$("#gift_card_id_select").val()];
        if($(this).val() > balance)
            alert('Amount exceeds card balance! Gift Card balance: '+ balance);
    }
    else if (id == 6){
        if($('input[name="paid_amount"]').val() > deposit[$('#customer_id').val()]){
            alert('Amount exceeds customer deposit! Customer deposit : '+ deposit[$('#customer_id').val()]);
        }
    }
});

$('.transaction-btn-plus').on("click", function() {
    $(this).addClass('d-none');
    $('.transaction-btn-close').removeClass('d-none');
});

$('.transaction-btn-close').on("click", function() {
    $(this).addClass('d-none');
    $('.transaction-btn-plus').removeClass('d-none');
});

function confirmDelete() {
    if (confirm("Are you sure want to delete?")) {
        return true;
    }
    return false;
}

function addNewProduct(data){
    var newRow = $("<tr>");
    var cols = '';
    cols += '<td class="col-sm-3 product-title">' + data[0] + '<br>[' + data[1] + ']<button type="button" class="edit-product btn btn-link" data-toggle="modal" data-target="#editModal"> <i class="fa fa-edit"></i></button></td>';
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
    $('input[name="edit_unit_price"]').val(row_product_price.toFixed(2));
}

function checkQuantity(sale_qty, flag) {
    var row_product_code = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.product-code').val();
    pos = product_code.indexOf(row_product_code);
    if(product_type[pos] == 'standard'){
        if (parseFloat(sale_qty) > product_qty[pos]) {
            alert('Quantity exceeds stock quantity! ' + flag);
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

function hide() {
    $(".card-element").hide();
    $(".card-errors").hide();
    $("#cheque").hide();
    $("#gift-card").hide();
}

function giftCard() {
    $("#gift-card").show();
    $.ajax({
        url: 'sale/get_gift_card',
        type: "GET",
        dataType: "json",
        success:function(data) {
            $('#add-payment select[name="gift_card_id_select"]').empty();
            $.each(data, function(index) {
                gift_card_amount[data[index]['id']] = data[index]['amount'];
                gift_card_expense[data[index]['id']] = data[index]['expense'];
                $('#add-payment select[name="gift_card_id_select"]').append('<option value="'+ data[index]['id'] +'">'+ data[index]['card_no'] +'</option>');
            });
            $('.selectpicker').selectpicker('refresh');
            $('.selectpicker').selectpicker();
        }
    });
    $(".card-element").hide();
    $(".card-errors").hide();
    $("#cheque").hide();
}

function cheque() {
    $("#cheque").show();
    $(".card-element").hide();
    $(".card-errors").hide();
    $("#gift-card").hide();
}

function creditCard() {
    $.getScript( "public/vendor/stripe/checkout.js" );
    $(".card-element").show();
    $(".card-errors").show();
    $("#cheque").hide();
    $("#gift-card").hide();
}

function deposits() {
    if($('input[name="paid_amount"]').val() > deposit[$('#customer_id').val()]){
        alert('Amount exceeds customer deposit! Customer deposit : '+ deposit[$('#customer_id').val()]);
    }
}

function cancel(rownumber) {
    while(rownumber >= 0) {
        product_price.pop();
        product_discount.pop();
        tax_rate.pop();
        tax_name.pop();
        tax_method.pop();
        $('table.order-list tbody tr:last').remove();
        rownumber--;
    }
    $('input[name="shipping_cost"]').val('');
    $('input[name="order_discount"]').val('');
    $('select[name="order_tax_rate"]').val(0);
    calculateTotal();
}

function confirmCancel() {
    if (confirm("Are you sure want to cancel?")){
        cancel($('table.order-list tbody tr:last').index());
    }
    return false;
}

$(document).on('submit', '.payment-form', function(e) {
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


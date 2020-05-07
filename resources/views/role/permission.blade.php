@extends('layout.main')
@section('content')
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div> 
@endif
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
			                    <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4>{{trans('file.Group Permission')}}</h4>
                    </div>
                    {!! Form::open(['route' => 'role.setPermission', 'method' => 'post']) !!}
                    <div class="card-body">
                    	<input type="hidden" name="role_id" value="{{$ezpos_role_data->id}}" />
						<div class="table-responsive">
						    <table class="table table-bordered table-hover table-striped reports-table">
						        <thead>
						        <tr>
						            <th colspan="5" class="text-center">{{$ezpos_role_data->name}} {{trans('file.Group Permission')}}</th>
						        </tr>
						        <tr>
						            <th rowspan="2" class="text-center">{{trans('file.module_name')}}                                    </th>
						            <th colspan="4" class="text-center">{{trans('file.Permissions')}}&nbsp;&nbsp; <input type="checkbox" id="select_all" class="checkbox"></th>
						        </tr>
						        <tr>
						            <th class="text-center">{{trans('file.View')}}</th>
						            <th class="text-center">{{trans('file.add')}}</th>
						            <th class="text-center">{{trans('file.edit')}}</th>
						            <th class="text-center">{{trans('file.delete')}}</th>
						        </tr>
						        </thead>
						        <tbody>
						        <tr>
						            <td>{{trans('file.product')}}</td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
						                @if(in_array("products-index", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="products-index" checked />
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="products-index" />
						                @endif
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                @if(in_array("products-add", $all_permission))
						               	<input type="checkbox" value="1" class="checkbox" name="products-add" checked>
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="products-add">
						                @endif
						                </div>

						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                @if(in_array("products-edit", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="products-edit" checked />
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="products-edit" />
						                @endif
						                </div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                @if(in_array("products-delete", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="products-delete" checked />
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="products-delete" />
						                @endif
						                </div>
						            </td>
						        </tr>

                                 <tr>
						            <td>{{trans('file.category')}}</td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
						                @if(in_array("category-index", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="category-index" checked />
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="category-index" />
						                @endif
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                @if(in_array("category-add", $all_permission))
						               	<input type="checkbox" value="1" class="checkbox" name="category-add" checked>
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="category-add">
						                @endif
						                </div>

						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                @if(in_array("category-edit", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="category-edit" checked />
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="category-edit" />
						                @endif
						                </div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                @if(in_array("category-delete", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="category-delete" checked />
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="category-delete" />
						                @endif
						                </div>
						            </td>
						        </tr>

						                                     
							   
							  <tr>
						            <td>{{trans('file.Sale')}}/{{trans('file.orders')}}</td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
						                @if(in_array("sales-index", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="sales-index" checked />
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="sales-index">
						                @endif
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
						                @if(in_array("sales-add", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="sales-add" checked />
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="sales-add">
						                @endif
						            	</div>
										{{trans('file.send')}}
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                @if(in_array("sales-edit", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="sales-edit" checked>
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="sales-edit">
						                @endif
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                @if(in_array("sales-delete", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="sales-delete" checked>
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="sales-delete">
						                @endif
						            	</div>
						            </td>
						        </tr>
 
						       
						        <tr>
						            <td>{{trans('file.Transfer')}}</td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                @if(in_array("transfers-index", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="transfers-index" checked>
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="transfers-index">
						                @endif
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                @if(in_array("transfers-add", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="transfers-add" checked>
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="transfers-add">
						                @endif
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                @if(in_array("transfers-edit", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="transfers-edit" checked>
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="transfers-edit">
						                @endif
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                @if(in_array("transfers-delete", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="transfers-delete" checked>
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="transfers-delete">
						                @endif
						            	</div>
						            </td>
						        </tr>

						        <tr>
						            <td>{{trans('file.User')}}</td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
						                @if(in_array("users-index", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="users-index" checked>
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="users-index">
						                @endif
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
						                @if(in_array("users-add", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="users-add" checked>
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="users-add">
						                @endif
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
						                @if(in_array("users-edit", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="users-edit" checked>
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="users-edit">
						                @endif
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                @if(in_array("users-delete", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="users-delete" checked>
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="users-delete">
						                @endif
						            	</div>
						            </td>
						        </tr>
						       
							     <tr>
						            <td>{{trans('file.Roles')}}</td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
						                @if(in_array("role-index", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="role-index" checked>
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="role-index">
						                @endif
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
						                @if(in_array("role-add", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="role-add" checked>
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="role-add">
						                @endif
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
						                @if(in_array("role-edit", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="role-edit" checked>
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="role-edit">
						                @endif
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                @if(in_array("role-delete", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="role-delete" checked>
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="role-delete">
						                @endif
						            	</div>
						            </td>
						        </tr>
						       
                                <tr>
						            <td>{{trans('file.Adjustment')}}</td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
						                @if(in_array("adjustment-index", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="adjustment-index" checked>
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="adjustment-index">
						                @endif
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
										{{trans('file.in_store')}}
										@if(in_array("adjustment-in", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="adjustment-in" checked>
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="adjustment-in">
						                @endif
						            	</div>
										
										 <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
                                         {{trans('file.out_store')}}						               
									   @if(in_array("adjustment-out", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="adjustment-out" checked>
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="adjustment-out">
						                @endif
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
						                @if(in_array("adjusment-edit", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="adjusment-edit" checked>
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="adjusment-edit">
						                @endif
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
						                @if(in_array("adjustment-delete", $all_permission))
						                <input type="checkbox" value="1" class="checkbox" name="adjustment-delete" checked>
						                @else
						                <input type="checkbox" value="1" class="checkbox" name="adjustment-delete">
						                @endif
						            	</div>
						            </td>
						        </tr>
						       
							 							  
							     
							   <tr>
						            <td>{{trans('file.Report')}}</td>
						            <td colspan="5">
						            	<span style="display:inline-block;">
						                    <div class="text-center" aria-checked="false" aria-disabled="false">
					                    	@if(in_array("product-price", $all_permission))
					                    	<input type="checkbox" value="1" class="checkbox" name="product-price" checked>
					                    	@else
					                    	<input type="checkbox" value="1" class="checkbox" name="product-price">
					                    	@endif
						                    </div>
						                    <label for="profit-loss" class="padding05">{{trans('file.price')}} &nbsp;&nbsp;</label>
						                </span>
						               
										<span style="display:inline-block;">
						                    <div class="text-center" aria-checked="false" aria-disabled="false">
					                    	@if(in_array("item_count_store", $all_permission))
					                    	<input type="checkbox" value="1" class="checkbox" name="item_count_store" checked>
					                    	@else
					                    	<input type="checkbox" value="1" class="checkbox" name="item_count_store">
					                    	@endif
						                    </div>
						                    <label for="item_count_store" class="padding05">{{trans('file.item_count_store')}} &nbsp;&nbsp;</label>
						                </span>
						               
						                <span style="display:inline-block;">
						                    <div class="text-center" aria-checked="false" aria-disabled="false">
					                    	@if(in_array("item_movement", $all_permission))
					                    	<input type="checkbox" value="1" class="checkbox" name="item_movement" checked>
					                    	@else
					                    	<input type="checkbox" value="1" class="checkbox" name="item_movement">
					                    	@endif
						                    </div>
						                    <label for="product-qty-alert" class="padding05">{{trans('file.item_movement')}}  &nbsp;&nbsp;</label>
						                </span>
						                
										<span style="display:inline-block;">
						                    <div class="text-center" aria-checked="false" aria-disabled="false">
					                    	@if(in_array("product-qty-alert", $all_permission))
					                    	<input type="checkbox" value="1" class="checkbox" name="product-qty-alert" checked>
					                    	@else
					                    	<input type="checkbox" value="1" class="checkbox" name="product-qty-alert">
					                    	@endif
						                    </div>
						                    <label for="product-qty-alert" class="padding05">{{trans('file.product')}} {{trans('file.Quantity')}} {{trans('file.Alert')}} &nbsp;&nbsp;</label>
						                </span>
						             
									 </td>
						        </tr>
						       
  							   
								<tr>
						            <td>{{trans('file.settings')}}</td>
						            <td colspan="5">
						            	<span style="display:inline-block;">
						                    <div class="text-center" aria-checked="false" aria-disabled="false">
					                    	@if(in_array("general_setting", $all_permission))
					                    	<input type="checkbox" value="1" class="checkbox" name="general_setting" checked>
					                    	@else
					                    	<input type="checkbox" value="1" class="checkbox" name="general_setting">
					                    	@endif
						                    </div>
						                    <label for="general_setting" class="padding05">{{trans('file.General Setting')}} &nbsp;&nbsp;</label>
						                </span>
						                <span style="display:inline-block;">
						                    <div class="text-center" aria-checked="false" aria-disabled="false">
					                    	@if(in_array("store_setting", $all_permission))
					                    	<input type="checkbox" value="1" class="checkbox" name="store_setting" checked>
					                    	@else
					                    	<input type="checkbox" value="1" class="checkbox" name="store_setting">
					                    	@endif
						                    </div>
						                    <label for="mail_setting" class="padding05">{{trans('file.store_setting')}} &nbsp;&nbsp;</label>
						                </span>
						                <span style="display:inline-block;">
						                    <div class="text-center" aria-checked="false" aria-disabled="false">
					                    	@if(in_array("pos_setting", $all_permission))
					                    	<input type="checkbox" value="1" class="checkbox" name="pos_setting" checked>
					                    	@else
					                    	<input type="checkbox" value="1" class="checkbox" name="pos_setting">
					                    	@endif
						                    </div>
						                    <label for="pos_setting" class="padding05">{{trans('file.POS Setting')}} &nbsp;&nbsp;</label>
						                </span>
						            </td>
						        </tr>
						        
								<tr>
						            <td>{{trans('file.Permissions')}}</td>
						            <td colspan="5">
						            	 <span style="display:inline-block;">
						                    <div class="text-center" aria-checked="false" aria-disabled="false">
					                    	@if(in_array("permission", $all_permission))
					                    	<input type="checkbox" value="1" class="checkbox" name="permission" checked>
					                    	@else
					                    	<input type="checkbox" value="1" class="checkbox" name="permission">
					                    	@endif
						                    </div>
						                    <label for="pos_setting" class="padding05">{{trans('file.Permissions')}} &nbsp;&nbsp;</label>
						                </span>
						            </td>
						        </tr>
						        
								</tbody>
						    </table>
						</div>
						<div class="form-group">
	                        <input type="submit" value="{{trans('file.submit')}}" class="btn btn-primary">
	                    </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            
                
			</div>
        </div>
    </div>
</section>

<script type="text/javascript">

	$("ul#setting").siblings('a').attr('aria-expanded','true');
    $("ul#setting").addClass("show");
    $("ul#setting li").eq(0).addClass("active");

	$("#select_all").on( "change", function() {
	    if ($(this).is(':checked')) {
	        $("tbody input[type='checkbox']").prop('checked', true);
	    } 
	    else {
	        $("tbody input[type='checkbox']").prop('checked', false);
	    }
	});
</script>
@endsection
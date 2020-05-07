@extends('layout.main')
@section('content')
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4>{{trans('file.update')}} {{trans('file.Adjustment')}}</h4>
                    </div>
                    <div class="card-body">
                        <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
                        {!! Form::open(['url' => ['marketer_order/update', $ezpos_marketer_data->id], 'method' => 'post', 'files' => true]) !!}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label><strong>{{trans('file.date')}}</strong></label>
                                            <input type="text" id="date" name="date" value="{{date('d-m-Y', strtotime($ezpos_marketer_data->created_at)) }}" class="form-control" required />
                                        </div>
                                    </div>
									<div class="col-md-4">
                                        <div class="form-group">
                                            <label><strong>{{trans('file.customer')}} {{trans('file.name')}}</strong></label>
                                             <h3>{{$ezpos_marketer_data->customer_name}}</h3>
										</div>
                                    </div>
                                   <div class="col-md-4">
                                        <div class="form-group">
                                            <label><strong>{{trans('file.customer')}} {{trans('file.phone')}}</strong></label>
                                             <h3>{{$ezpos_marketer_data->customer_phone}}</h3>
										</div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <label><strong>{{trans('file.Select Product')}}</strong></label>
                                        <div class="search-box input-group">
                                            <button type="button" class="btn btn-secondary btn-lg"><i class="fa fa-barcode"></i></button>
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
                                                        <th>{{trans('file.arabic_name')}}</th>
                                                        <th>{{trans('file.Code')}}</th>
                                                        <th>{{trans('file.Quantity')}}</th>
                                                        <th style="display:none">{{trans('file.action')}}</th>
                                                        <th><i class="fa fa-trash"></i></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                	@foreach($ezpos_product_marketer_data as $product_adjustment_data)
                                                	<tr>
                                                	<?php 
                                                	$product = DB::table('products')->find($product_adjustment_data->product_id);
                                                	?>
                                                	<td>{{$product->name}}</td>
                                                	<td>{{$product->arabic_name}}</td>
                                                	<td>{{$product->code}}</td>
													<td><input type="number" class="form-control qty" name="qty[]" value="{{$product_adjustment_data->product_qty}}" required></td>
                                                	<td><button type="button" class="ibtnDel btn btn-md btn-danger">{{trans("file.delete")}}</button>
                                                	<input type="hidden" class="product-code" value="{{$product->code}}" />
                                                	<input type="hidden" class="product-id" name="product_id[]" value="{{$product->id}}" />
                                                	</td>
                                                	@endforeach
                                                	</tr>
                                                </tbody>
                                                <tfoot class="tfoot active">
                                                    <th colspan="2">{{trans('file.Total')}}</th>
                                                    <th id="total-qty" colspan="2">0</th>
                                                    <th><i class="fa fa-trash"></i></th>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="hidden" name="total_qty" />
                                            <input type="hidden" name="item" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label><strong>{{trans('file.Note')}}</strong></label>
                                            <textarea rows="5" class="form-control" name="note">{{$ezpos_marketer_data->marketer_note}}</textarea>
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
</section>

<script type="text/javascript">
	 
    $("ul#adjustment").siblings('a').attr('aria-expanded','true');
    $("ul#adjustment").addClass("show");

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

	$('.selectpicker').selectpicker({
	    style: 'btn-link',
	});
	//assigning value
	$('select[name="store_id"]').val($('input[name="store_id_hidden"]').val());
	$('.selectpicker').selectpicker('refresh');
	calculateTotal();

	$('#ezpos_productcodeSearch').on('input', function(){
	   // var store_id = $('#store_id').val();
	    temp_data = $('#ezpos_productcodeSearch').val();

	   // if(!store_id){
	    //    $('#ezpos_productcodeSearch').val(temp_data.substring(0, temp_data.length - 1));
	     //   alert('Please select store!');
	   // }

	});

	//var id = $('#store_id').val();
    $.get('../getproduct/' , function(data) {
        ezpos_product_array = [];
        product_code = data[0];
        product_name = data[1];
        product_qty = data[2];
        $.each(product_code, function(index) {
            ezpos_product_array.push(product_code[index] + ' (' + product_name[index] + ')');
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
	                    cols += '<td>' + data[0] + '</td>';
	                    cols += '<td>' + data[3] + '</td>';
	                    cols += '<td>' + data[1] + '</td>';
	                    cols += '<td><input type="number" class="form-control qty" name="qty[]" value="1" required /></td>';
						
						cols += '<td><button type="button" class="ibtnDel btn btn-md btn-danger">{{trans("file.delete")}}</button></td>';
	                    cols += '<input type="hidden" class="product-code" name="product_code[]" value="' + data[1] + '"/>';
	                    cols += '<input type="hidden" class="product-id" name="product_id[]" value="' + data[2] + '"/>';

	                    newRow.append(cols);
	                    $("table.order-list tbody").append(newRow);
	                    rowindex = newRow.index();
	                    calculateTotal();
	                }  
	            }
	        });
	    }
	});

	$('select[name="store_id"]').on('change', function() {
	    var id = $('#store_id').val();
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

	$("#myTable").on('input', '.qty', function() {
	    rowindex = $(this).closest('tr').index();
	    checkQuantity($(this).val(), true);
	});

	$("table.order-list tbody").on("click", ".ibtnDel", function(event) {
	    rowindex = $(this).closest('tr').index();
	    $(this).closest("tr").remove();
	    calculateTotal();
	});

	function checkQuantity(qty) {
	    var row_product_code = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(2)').text();
	    var pos = product_code.indexOf(row_product_code);
	    var action = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.act-val').val();
        if (parseFloat(qty) > product_qty[pos] && action == '-' ) {
	        alert('Quantity exceeds stock quantity!');
            var row_qty = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.qty').val();
            row_qty = row_qty.substring(0, row_qty.length - 1);
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.qty').val(row_qty);
	    }
	    else {
	        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.qty').val(qty);
	        calculateTotal();
	    }
	}

	function calculateTotal() {
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
	    $('input[name="item"]').val($('table.order-list tbody tr:last').index() + 1);
	}
</script>
@endsection
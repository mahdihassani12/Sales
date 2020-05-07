@extends('layout.main')
@section('content')
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4>{{trans('file.update')}} {{trans('file.product')}}</h4>
                    </div>
                    <div class="card-body">
                        <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
                        {!! Form::open(['route' => ['products.update', $ezpos_product_data->id], 'method' => 'put', 'files' => true, 'id' => 'product-form']) !!}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label><strong>{{trans('file.product')}} {{trans('file.Image')}}</strong> </label>
                                    <input type="file" name="image" class="form-control">
                                    @if($errors->has('image'))
                                        <span>
                                           <strong>{{ $errors->first('image') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
							
							<div class="col-md-2" style="display:none">
							   <label class="custome_checkbox"><strong>External Link</strong>
								  <input type="checkbox" class="external_link" id="has_external_link" @if($ezpos_product_data->external_link =='1') {{'checked'}} @endif>
								  <span class="checkmark" ></span>
								</label>
							</div>
							
							<div class="col-md-8" style="display:none">
							   <input type="text" name="external_link" class="form-control external_link_input" placeholder="enter image link" style="@if($ezpos_product_data->external_link!='1') {{'display:none'}} @endif" value="@if($ezpos_product_data->external_link=='1') {{$ezpos_product_data->image}} @endif">
							</div>
                           <div class="col-md-2" style="display:none"><a href="#MoreImagesModal" data-toggle="modal">More images</a></div>
					
							
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>{{trans('file.product')}} {{trans('file.name')}} *</strong> </label>
                                    <input type="text" name="name" value="{{$ezpos_product_data->name}}" required class="form-control">
                                    @if($errors->has('name'))
                                    <span>
                                       <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                           
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Arabic Name *</strong> </label>
                                    <input type="text" name="arabic_name" value="{{$ezpos_product_data->arabic_name}}" required class="form-control">
                                    @if($errors->has('arabic_name'))
                                    <span>
                                       <strong>{{ $errors->first('arabic_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                       
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>{{trans('file.product')}} {{trans('file.Code')}} </strong> </label>
                                    <div class="input-group">
                                        <input type="text" name="code" value="{{$ezpos_product_data->code}}" class="form-control">
                                        <div class="input-group-append">
                                            <button id="genbutton" type="button" class="btn btn-default">{{trans('file.Generate')}}</button>
                                        </div>
                                        @if($errors->has('code'))
                                        <span>
                                           <strong>{{ $errors->first('code') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="display:none">
                                <div class="form-group">
                                    <label><strong>{{trans('file.product')}} {{trans('file.Type')}} *</strong> </label>
                                    <div class="input-group">
                                        <select name="type"  class="form-control selectpicker">
                                            <option value="standard" selected>Standard</option>
                                            <option value="digital" selected>Digital</option>
                                        </select>
                                        <input type="hidden" name="type_hidden" value="{{$ezpos_product_data->type}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>{{trans('file.Barcode Symbology')}} *</strong> </label>
                                    <div class="input-group">
                                        <input type="hidden" name="barcode_symbology_hidden" value="{{$ezpos_product_data->barcode_symbology}}">
                                        <select name="barcode_symbology" required class="form-control selectpicker">
                                            <option value="C128">Code 128</option>
                                            <option value="C39">Code 39</option>
                                            <option value="UPCA">UPC-A</option>
                                            <option value="UPCE">UPC-E</option>
                                            <option value="EAN8">EAN-8</option>
                                            <option value="EAN13" selected>EAN-13</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="digital" class="col-md-6" style="display:none">
                                <div class="form-group">
                                    <label><strong>{{trans('file.Attach File')}}</strong> </label>
                                    <div class="input-group">
                                        <input type="file" name="file" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6"  style="display:none">
                                <div class="form-group">
                                    <label><strong>{{trans('file.Brand')}}</strong> </label>
                                    <div class="input-group">
                                        <input type="hidden" name="brand" value="{{ $ezpos_product_data->brand_id}}">
                                      <select name="brand_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Brand...">
                                        @foreach($ezpos_brand_list as $brand)
                                            <option value="{{$brand->id}}">{{$brand->title}}</option>
                                        @endforeach
                                      </select>
                                  </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" name="category" value="{{$ezpos_product_data->category_id}}">
                                    <label><strong>{{trans('file.category')}} *</strong> </label>
                                    <div class="input-group">
                                      <select name="category_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Category...">
                                        @foreach($ezpos_category_list as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                      </select>
                                  </div>
                                </div>
                            </div>
                            <div id="unit" class="col-md-6">
                                <div class="row ">
                                    <div class="col-md-6" style="display:none">
                                        <label><strong>{{trans('file.product')}} {{trans('file.Unit')}}</strong> </label>
                                        <div class="input-group">
                                          <input type="text" name="unit" class="form-control" value="{{$ezpos_product_data->unit}}">
                                      </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label><strong>{{trans('file.Alert')}} {{trans('file.Quantity')}}</strong> </label>
                                        <input type="number" name="alert_quantity" value="{{$ezpos_product_data->alert_quantity}}" class="form-control" step="any">
                                    </div>                             
                                </div>                                
                            </div>
                            <div id="cost" class="col-md-6" style="display:none">
                                <div class="form-group">
                                    <label><strong>{{trans('file.product')}} {{trans('file.Cost')}} *</strong> </label>
                                    <input type="number" name="cost" value="{{$ezpos_product_data->cost}}" required class="form-control" step="any" value="1">
                                </div>
                            </div>
                            <div class="col-md-6" style="display:none">
                                <div class="form-group">
                                    <label><strong>{{trans('file.product')}} {{trans('file.Price')}} *</strong> </label>
                                    <input type="number" name="price" value="{{$ezpos_product_data->price}}" required class="form-control" step="any" value="1">
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="qty" value="{{ $ezpos_product_data->qty }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6" style="display:none">
                                <div class="form-group mt-3">
                                    <label><strong>{{trans('file.Featured')}}</strong></label>
                                    @if($ezpos_product_data->featured)
                                        <input type="checkbox" name="featured" value="1" checked>
                                    @else
                                        <input type="checkbox" name="featured" value="1">
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 mt-3" style="display:none">
                                <input type="hidden" name="promotion_hidden" value="{{$ezpos_product_data->promotion}}">
                                <label><strong>{{trans('file.Promotion')}}</strong></label>
                                <input name="promotion" type="checkbox" id="promotion" value="1">
                            </div>
                            <div class="col-md-6" id="promotion_price" style="display:none">    
                                <label><strong>{{trans('file.Promotional Price')}}</strong></label>
                                <input type="number" name="promotion_price" value="{{$ezpos_product_data->promotion_price}}" class="form-control" step="any" />
                            </div>
                            <div id="start_date" class="col-md-6">
                                <div class="form-group">
                                    <label><strong>{{trans('file.Starting')}} {{trans('file.Date')}}</strong></label>
                                    <input type="text" name="starting_date" value="{{$ezpos_product_data->starting_date}}" id="starting_date" class="form-control" />
                                </div>
                            </div>
                            <div id="last_date" class="col-md-6" style="display:none">
                                <div class="form-group">
                                    <label><strong>{{trans('file.Ending')}} {{trans('file.Date')}}</strong></label>
                                    <input type="text" name="last_date" value="{{$ezpos_product_data->last_date}}" id="ending_date" class="form-control" />
                                </div>
                            </div>
                            <div class="col-md-6" style="display:none">
                                <div class="form-group">
                                    <input type="hidden" name="tax" value="{{$ezpos_product_data->tax_id}}">
                                    <label><strong>{{trans('file.product')}} {{trans('file.Tax')}}</strong> </label>
                                    <select name="tax_id" class="form-control selectpicker">
                                        <option value="">No Tax</option>
                                        @foreach($ezpos_tax_list as $tax)
                                            <option value="{{$tax->id}}">{{$tax->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6" style="display:none">
                                <div class="form-group">
                                    <input type="hidden" name="tax_method_id" value="{{$ezpos_product_data->tax_method}}">
                                    <label><strong>{{trans('file.Tax')}} {{trans('file.Method')}}</strong> </label>
                                    <select name="tax_method" class="form-control selectpicker">
                                        <option value="1">Exclusive</option>
                                        <option value="2">Inclusive</option>
                                    </select>
                                </div>
                            </div>
                         
                                <div class="col-md-6" style="display:none">
                                 <div class="form-group">
                                    <label for="product_link"><strong>youtube link </strong> </label>
                                    <input type="text" class="form-control" name="product_link" value="{{$ezpos_product_data->product_link}}" placeholder="{{trans('file.product_link')}}" id="product_link"  class="form-control">
				</div>
                            </div>                     

                            <div class="col-md-12"> 
                                <div class="form-group">
                                    <label><strong>{{trans('file.product')}} {{trans('file.Details')}}</strong></label>
                                    <textarea name="product_details" class="form-control" rows="5" wrap="hard">{{str_replace('@', '"', $ezpos_product_data->product_details)}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="submit" value="{{trans('file.submit')}}" class="btn btn-primary">
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

<div id="MoreImagesModal" class="modal fade " role="dialog" >
  <div class="modal-dialog " style="width:400px; padding-top:80px ">
    <div class="modal-content" style="border-radius:0px;padding:20px;">
      <div class="modal-body" style="background:#fff;padding:0px; ">
	    <button type="button" class="close" data-dismiss="modal" style="float:inherit">&times; <span style="font-size:14px">اغلاق</span></button> 
         {!! Form::open(['url' => '', 'method' => 'post', 'files' => true, 'id' => 'add_more_images']) !!}
	        <input type="hidden" name="product_id" value="{{$ezpos_product_data->id}}">
			<?php 
			   $counter=1;
			  $gimages=DB::table('product_gallery_images')->where('product_id',$ezpos_product_data->id)->get();
			  foreach($gimages as $img):
			  
			?>
			
			<div class="form-group">
			  <input type="text" class="form-control" name="image{{$counter}}" value="{{$img->imag_gallery}}" placeholder="enter product image link {{$counter}}" id="first_image{{$counter}}">
			</div> 
           <?php 
		   $counter++;
		    endforeach;
			
			for($i=0; $i<6; $i++):
		     if($counter>6):
		     break;
		     endif;
		   ?>  
	       <input type="text" class="form-control" name="image{{$counter}}"  placeholder="enter product image link {{$counter}}" id="first_image{{$counter}}">
         <?php 
		  
		   $counter++;
		   endfor;
		 ?>
           	<div class="form-group">
			  	<input type="button" class="form-control btn btn-primary saveMoreImages" value="{{trans('file.save')}}">
            </div>			
		 {!! Form::close() !!}
	 </div>
    </div>
  </div>
</div>



<style>
  .custome_checkbox {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 22px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default checkbox */
.custome_checkbox input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

/* Create a custom checkbox */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #fff;
  border: 1px solid black;
  border-radius: 3px;
}

/* On mouse-over, add a grey background color */
.custome_checkbox:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.custome_checkbox input:checked ~ .checkmark {
  background-color: #2196F3;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.custome_checkbox input:checked ~ .checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.custome_checkbox .checkmark:after {
   left: 8px;
  top: 2px;
  width: 9px;
  height: 14px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}
</style>
<script type="text/javascript">
var APP_URL = {!! json_encode(url('/')) !!}
  $(".saveMoreImages").click(function(){
		 if($("#first_image1").val()==""){
				$("#first_image").css('border','1px solid red');
				return;
		  }
				
		var myform=$("#add_more_images");
		var formData = new FormData(myform[0]);
		$.ajax({
			type:"POST",
            url: APP_URL+'/products/quickaddimagesUpdate',
            data:formData,
			success:function(response){
				console.log(response);
				if(response=='1'){
			    $("#MoreImagesModal").modal('hide');
			   }else{
				   alert('try again');
			   }
			},
			 cache: false,
             contentType: false,
             processData: false,
			 
			error:function(data){
			  alert(data);
			}
		}); 		 
	 });
 



 $("#has_external_link").click(function(){
		 $(".external_link_input").toggle(); 
	 });
	 
	 
    $("ul#product").siblings('a').attr('aria-expanded','true');
    $("ul#product").addClass("show");

    $("select[name='type']").val($("input[name='type_hidden']").val());
    if($("input[name='type_hidden']").val() == "digital"){
        $("input[name='cost']").prop('required',false);
        $("select[name='unit_id']").prop('required',false);
        $("#cost").hide();
        $("#unit").hide();
        $("#alert-qty").hide();
        $("#digital").show();
    }
    else{
        $("#digital").hide();
    }
    var promotion = $("input[name='promotion_hidden']").val();
    if(promotion){
        $("input[name='promotion']").prop('checked', true);
        $("#promotion_price").show();
        $("#start_date").show();
        $("#last_date").show();
    }
    else {
        $("#promotion_price").hide();
        $("#start_date").hide();
        $("#last_date").hide();
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#genbutton').on("click", function(){
      $.get('../gencode', function(data){
        $("input[name='code']").val(data);
      });
    });

    $('.selectpicker').selectpicker({
      style: 'btn-link',
    });

    tinymce.init({
      selector: 'textarea',
      height: 200,
      plugins: [
        'advlist autolink lists link image charmap print preview anchor textcolor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table contextmenu paste code wordcount'
      ],
      toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat',
      branding:false
    });

    var barcode_symbology = $("input[name='barcode_symbology_hidden']").val();
    $('select[name=barcode_symbology]').val(barcode_symbology);

    var brand = $("input[name='brand']").val();
    $('select[name=brand_id]').val(brand);

    var cat = $("input[name='category']").val();
    $('select[name=category_id]').val(cat);
    $('select[name=unit_id]').val($("input[name='unit']").val());
    populate_unit($("input[name='unit']").val());

    var tax = $("input[name='tax']").val();
    if(tax)
        $('select[name=tax_id]').val(tax);

    var tax_method = $("input[name='tax_method_id']").val();
    $('select[name=tax_method]').val(tax_method);

    $('select[name="type"]').on('change', function() {
        if($(this).val() == 'digital'){
            $("input[name='cost']").prop('required',false);
            $("select[name='unit_id']").prop('required',false);
            $("input[name='file']").prop('required',true);
            $("#cost").hide();
            $("#unit").hide();
            $("#alert-qty").hide();
            $("#digital").show();
        }
        else if($(this).val() == 'standard'){
            $("input[name='cost']").prop('required',true);
            $("select[name='unit_id']").prop('required',true);
            $("input[name='file']").prop('required',false);
            $("#cost").show();
            $("#unit").show();
            $("#alert-qty").show();
            $("#digital").hide();
        }
    });

    $('select[name="unit_id"]').on('change', function() {
        unitID = $(this).val();
        if(unitID) {
            populate_unit_second(unitID);
        }else{    
            $('select[name="sale_unit_id"]').empty();
            $('select[name="purchase_unit_id"]').empty();
        }                        
    });
    $('.selectpicker').selectpicker('refresh');
    function populate_unit(unitID){
        $.ajax({
            url: '../saleunit/'+unitID,
            type: "GET",
            dataType: "json",

            success:function(data) {
                  $('select[name="sale_unit_id"]').empty();
                  $('select[name="purchase_unit_id"]').empty();
                  $.each(data, function(key, value) {
                      $('select[name="sale_unit_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                      $('select[name="purchase_unit_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                  });
                  $('.selectpicker').selectpicker('refresh');
                  var sale_unit = $("input[name='sale_unit']").val();
                  var purchase_unit = $("input[name='purchase_unit']").val();
                $('select[name=purchase_unit_id]').val(sale_unit);
                $('select[name=purchase_unit_id]').val(purchase_unit);
            },
        });
    }

    function populate_unit_second(unitID){
        $.ajax({
            url: '../saleunit/'+unitID,
            type: "GET",
            dataType: "json",
            success:function(data) {
                  $('select[name="sale_unit_id"]').empty();
                  $('select[name="purchase_unit_id"]').empty();
                  $.each(data, function(key, value) {
                      $('select[name="sale_unit_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                      $('select[name="purchase_unit_id"]').append('<option value="'+ key +'">'+ value +'</option>');
                  });
                  $('.selectpicker').selectpicker('refresh');
            },
        });
    }

    $( "#promotion" ).on( "change", function() {
        if ($(this).is(':checked')) {
            $("#promotion_price").show();
            $("#start_date").show();
            $("#last_date").show();
        } 
        else {
            $("#promotion_price").hide();
            $("#start_date").hide();
            $("#last_date").hide();
        }
    });

    var starting_date = $('#starting_date');
    starting_date.datepicker({
     format: "dd-mm-yyyy",
     startDate: "<?php echo date('d-m-Y'); ?>",
     autoclose: true,
     todayHighlight: true
     });

    var ending_date = $('#ending_date');
    ending_date.datepicker({
     format: "dd-mm-yyyy",
     startDate: "<?php echo date('d-m-Y'); ?>",
     autoclose: true,
     todayHighlight: true
     });

    $('#product-form').on('submit',function(e){
        var product_code = $("input[name='code']").val();
        var barcode_symbology = $('select[name="barcode_symbology"]').val();
        var exp = /^\d+$/;

        if(!(product_code.match(exp)) && (barcode_symbology == 'UPCA' || barcode_symbology == 'UPCE' || barcode_symbology == 'EAN8' || barcode_symbology == 'EAN13') ) {
            alert('Product code must be numeric.');
            e.preventDefault();
        }
        else if(product_code.match(exp)) {
            //  if(barcode_symbology == 'UPCA' && product_code.length > 11){
           //     alert('Product code length must be less than 12');
            //    e.preventDefault();
           // }
           // else if(barcode_symbology == 'EAN8' && product_code.length > 7){
            //    alert('Product code length must be less than 8');
             //   e.preventDefault();
           // }
           // else if(barcode_symbology == 'EAN13' && product_code.length > 12){
            //    alert('Product code length must be less than 13');
             //   e.preventDefault();
            //}
        }
    });

</script>
@endsection

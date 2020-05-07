 <?php $__env->startSection('content'); ?>
<?php if(session()->has('create_message')): ?>
    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('create_message')); ?></div> 
<?php endif; ?>
<?php if(session()->has('edit_message')): ?>
    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('edit_message')); ?></div> 
<?php endif; ?>
<?php if(session()->has('import_message')): ?>
    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('import_message')); ?></div> 
<?php endif; ?>
<?php if(session()->has('not_permitted')): ?>
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('not_permitted')); ?></div> 
<?php endif; ?>
<?php if(session()->has('message')): ?>
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message')); ?></div> 
<?php endif; ?>

<section>
    <div class="container-fluid">
        <?php if(in_array("products-add", $all_permission)): ?>
            <a href="<?php echo e(route('products.create')); ?>" class="btn btn-info"><i class="fa fa-plus"></i> <?php echo e(__('file.add_product')); ?></a>
            <a href="#" data-toggle="modal" data-target="#importProduct" class="btn btn-primary"><i class="fa fa-file"></i> <?php echo e(__('file.import_product')); ?></a>
            <a href="<?php echo e(asset('products/createQuick')); ?>" class="btn btn-success" style="display: none"><i class="fa fa-plus"></i> <?php echo e(__('file.add_product_quick')); ?></a> 
		<?php endif; ?>
    </div>
    <div class="table-responsive">
        <table id="product-data-table" class="table table-hover rwd-table" data-autogen-headers="true">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th><?php echo e(trans('file.Image')); ?></th>
                    <th><?php echo e(trans('file.name')); ?></th>
                    <th><?php echo e(trans('file.Code')); ?></th>
                    <th style="display:none"><?php echo e(trans('file.Brand')); ?></th>
                    <th><?php echo e(trans('file.sub_category')); ?></th>
                    <th><?php echo e(trans('file.category')); ?></th>
                    <th><?php echo e(trans('file.Quantity')); ?></th>
                    <th><?php echo e(trans('file.Unit')); ?></th>
                    <th style="display:none"><?php echo e(trans('file.Price')); ?></th>
                    <th class="not-exported"><?php echo e(trans('file.action')); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $ezpos_product_all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($product->brand_id): ?>
                <?php 
                    $brand = DB::table('brands')->where('id', $product->brand_id)->first();
		     if($brand!=null):
			$brand = $brand->title;
			else:
			$brand = 'N/A';
		    endif;
                ?>
                <?php else: ?>
                    <?php $brand = 'N/A'; ?>
                <?php endif; ?>

                <?php
                    $category = DB::table('categories')->where('id', $product->category_id)->first();
                    $tax = DB::table('taxes')->where('id', $product->tax_id)->first();
                    if($product->unit)
                        $unit = $product->unit;
                    else
                        $unit = 'N/A';
                    if($tax)
                        $tax = $tax->name;
                    else
                        $tax = 'N/A';
                    if($product->tax_method == 1)
                        $tax_method = 'Exclusive';
                    else
                        $tax_method = 'Inclusive';

                    $replace = Array(
                        '\\' => '',
                        '"' => '\"'
                    );

                    $product_name = str_replace(array_keys($replace), $replace, $product->name);

                    $product->product_details = str_replace(array_keys($replace), $replace, $product->product_details);

                    $product->product_details = preg_replace('/\r\n+/', "<br>", $product->product_details);
                ?>
                <?php if(isset($category->name)){ 
				     if($category->parent_id!=null){
						$chilCategory= $category->name;
						$ccategory=DB::table('categories')->where('id',$category->parent_id)->get();if(count($ccategory)>0){$ccategory=$ccategory[0]->name;}
					 } 
					 else{
						 $ccategory=$category->name;
					     $chilCategory='N/A';
					 }
					 }
					 else{ $ccategory='';$chilCategory='';}?>                 
                <tr class="product-link" data-product='[ "<?php echo e($product->type); ?>", "<?php echo e($product_name); ?>", "<?php echo e($product->code); ?>", "<?php echo e($brand); ?>", "<?php echo e($ccategory); ?>", "<?php echo e($unit); ?>", "<?php echo e($product->cost); ?>", "<?php echo e($product->price); ?>", "<?php echo e($tax); ?>", "<?php echo e($tax_method); ?>", "<?php echo e($product->alert_quantity); ?>","<?php echo e($product->product_details); ?>", "<?php echo e($product->id); ?>", "<?php echo e($product->qty); ?>"]' data-imagedata ="<?php echo e(DNS1D::getBarcodePNG($product->code, $product->barcode_symbology)); ?>">
                    <td><?php echo e($key); ?></td>
                    <?php if($product->image): ?>
                    <td> <img src="<?php if($product->external_link==1): ?> <?php echo e($product->image); ?>   <?php else: ?><?php echo e(url('public/images/product',$product->image)); ?> <?php endif; ?>" height="80" width="80"   id="pr_img_<?php echo e($product->id); ?>">
                    </td>
                    <?php else: ?>
                    <td>No Image</td>
                    <?php endif; ?>
		            <td><?php echo e($product->name); ?></td>
                    <td><?php echo e($product->code); ?></td>
                    <td style="display:none"><?php echo e($brand); ?></td>
                    <td class="chcategroy_<?php echo e($product->id); ?>"><?php echo e($chilCategory); ?></td>
                    <td class="categroy_<?php echo e($product->id); ?>"><?php echo e($ccategory); ?></td>
                    <td><?php echo e($product->qty); ?></td>
                    <?php if($unit == 'N/A'): ?>
                    <td>N/A</td>
                    <?php else: ?>
                    <td><?php echo e($product->unit); ?></td>
                    <?php endif; ?>
                    <td style="display:none"><?php echo e($product->price); ?></td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo e(trans('file.action')); ?>

                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                  <li>
                                    <a href="#gallery_images" class="btn btn-link show-modal-linke" data-toggle="modal" product_id="<?php echo e($product->id); ?>" >
                                        <i class="fa fa-photo"  ></i> <?php echo e(trans('file.gallery_photos')); ?>

                                    </a>
                                  </li>
                                  <li style="display:none">
                                    <a href="#product_variations" class="btn btn-link show_variation" data-toggle="modal" product_id="<?php echo e($product->id); ?>" >
                                        <i class="fa fa-table"  ></i> <?php echo e(trans('file.variations')); ?>

                                    </a>
                                  </li>
                                 <li>
									 <a href="#changeProductPhoto" data-toggle="modal" pro_id="<?php echo e($product->id); ?>" class="change_image btn btn-link show-modal-linke">
									    <i class="fa fa-table"></i> Change Image
								     </a>
								  </li>
                                   
                                 <li>
									 <a href="#changeProductCategory" data-toggle="modal" pro_id="<?php echo e($product->id); ?>" class="change_category btn btn-link show-modal-linke">
									    <i class="fa fa-list-alt"></i> Change Category
								     </a>
								  </li>
								  
                                <?php if(in_array("products-edit", $all_permission)): ?>
                                  <li>
                                    <a href="<?php echo e(route('products.edit', ['id' => $product->id])); ?>" class="btn btn-link"><i class="fa fa-edit"></i> <?php echo e(trans('file.edit')); ?></a>
                                  </li>
                                <?php endif; ?>
                                <?php if(in_array("products-delete", $all_permission)): ?>
                                <li class="divider"></li>
                                <?php echo e(Form::open(['route' => ['products.destroy', $product->id], 'method' => 'DELETE'] )); ?>

                                <li>
                                    <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="fa fa-trash"></i> <?php echo e(trans('file.delete')); ?></button>
                                </li>
								<li class="divider"></li>
								<li>
                                </li>
                                <?php echo e(Form::close()); ?>

                                <?php endif; ?>
                            </ul>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</section>

<div id="gallery_images" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius:0px;background:#242e42; ">
      <div class="modal-header" style="background: #242e42;color: #fff;}">
        <button type="button" style="padding:0px;color:#fff;" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo e(trans('file.gallery_photos')); ?></h4>
      </div>
      <div class="modal-body" style="background:#fff;">
           
		   <?php echo Form::open(['url' => 'products/add_image_gallery', 'method' => 'post', 'class' => 'form-horizontal main_form form-whitout-modal', 'enctype'=> 'multipart/form-data', 'id'=> 'add_attachment_form']); ?> 
            <input type="hidden" name="product_id" value="" id="selectedProductID">
            <div class="row" style="margin:20px 10px 10px 15px;">
              <div class="col-lg-12" style="border-bottom:1px solid gray;">
                <div class="col-lg-9 pull-right">
                  <div class="upload-btn-wrapper add_attach_inout">
                    <span style="color: #a5a4a4" id="lbl_passenger_attachment"><?php echo e(trans('file.select_attachment')); ?></span>
                    <span style="display: none" id="select_attachment"><?php echo e(trans('file.select_attachment')); ?></span>
                    <button type="button" class="file_btn"><?php echo e(trans('file.browse')); ?></button>
                    <input type="file" name="passenger_attachment" id="passenger_attachment"  />

		    <input type="text" name="external_link" class="form-control" placeholder="Enter External Link">    

                  </div>
                </div>
                <div class="col-lg-3 pull-right">
                  <button  type="submit" class="save_attachment"><?php echo e(trans("file.save")); ?></button>
                </div>
            </div>
            </div>

            <?php echo Form::close(); ?>

             <label class="message"></label>
            <div id="attachment_tbl">
            </div>

		   
      </div>
      <div class="modal-footer" style="background:#fff;">
      </div>
    </div>

  </div>
</div>


<div id="importProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
      <div class="modal-content">
        <?php echo Form::open(['route' => 'product.import', 'method' => 'post', 'files' => true]); ?>

        <div class="modal-header">
          <h5 id="exampleModalLabel" class="modal-title">Import Product</h5>
          <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
          <p class="italic"><small><?php echo e(trans('file.The field labels marked with * are required input fields')); ?>.</small></p>
           <p><?php echo e(trans('file.The correct column order is')); ?> (name*, code*) <?php echo e(trans('file.and you must follow this')); ?>.</p>
           <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label><strong><?php echo e(trans('file.Upload xls File')); ?> *</strong></label>
                        <?php echo e(Form::file('file', array('class' => 'form-control','required'))); ?>

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label><strong> <?php echo e(trans('file.Sample File')); ?></strong></label>
                        <a href="public/sample_file/sample_products.xls" class="btn btn-info btn-block btn-md"><i class="fa fa-download"></i>  <?php echo e(trans('file.Download')); ?></a>
                    </div>
                </div>
           </div>           
            <?php echo e(Form::submit('Submit', ['class' => 'btn btn-primary'])); ?>

        </div>
        <?php echo Form::close(); ?>

      </div>
    </div>
</div>

<div id="product-details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 id="exampleModalLabel" class="modal-title">Product Details &nbsp;&nbsp;</h5>
          <button id="print-btn" type="button" class="btn btn-default btn-sm"><i class="fa fa-print"></i> <?php echo e(trans('file.Print')); ?></button>
          <button type="button" id="close-btn" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
        </div>
            <div id="product-content" class="modal-body">
            </div>
            <table class="table table-bordered table-hover product-store-list">
                <thead>
                </thead>
                <tbody>
                </tbody>
            </table>
      </div>
    </div>
</div>

<div id="product_variations" tabindex="-1" role="dialog"  aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
      <div class="modal-content" style="border-radius:0px;background:#242e42;">
        <div class="modal-header" style="background: #242e42;color: #fff;}">
           <button type="button" id="close-btn" style="padding:0px;color:#fff;" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
		  <h4  class="modal-title"><?php echo e(trans('file.product_variations')); ?> &nbsp;&nbsp;</h4>
        </div>
            <div class="modal-body" style="background:#fff">
            </div>
      </div>
    </div>
</div>



<div id="changeProductPhoto" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:450px;">
    <div class="modal-content" style="border-radius:0px;background:#242e42; ">
      <div class="modal-header" style="background: #242e42;color: #fff;}">
        <button type="button" style="padding:0px;color:#fff;" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" style="background:#fff;">
           
            <input type="hidden" name="product_id" value="" id="selectedProductID">
            <div class="row" style="margin:20px 10px 10px 15px;">
              <div class="col-lg-12" style="border-bottom:1px solid gray;">
                <div class="col-lg-12 pull-right" style="text-align:center;">
                  <div class="upload-btn-wrapper add_attach_inout">
                    <span style="color: #a5a4a4" id="lbl_passenger_attachment">Change Image</span>
                    <span style="display: none" id="select_attachment">Change Image</span>
                    <button type="button" class="change_product_img"><?php echo e(trans('file.browse')); ?></button>
                    <input type="file" name="passenger_attachment" id="prdocut_image"  />
                    <input type="hidden" id="get_product_id" value="">                
				</div>
                </div>
            </div>
            </div>
    </div>

  </div>
</div>
</div>


<div id="changeProductCategory" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:450px;">
    <div class="modal-content" style="border-radius:0px;background:#242e42; ">
      <div class="modal-header" style="background: #242e42;color: #fff;}">
        <button type="button" style="padding:0px;color:#fff;" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" style="background:#fff;">  
            <input type="hidden" name="product_id" value="" id="selectedProductID_category_modal">
            <div class="row" style="margin:20px 10px 10px 15px;">
              <div class="col-lg-12" style="border-bottom:1px solid gray;padding-bottom:20px;margin-bottom:10px;">
                <div class="col-lg-12 pull-right" style="text-align:center;">
                  <select class="form-control selectpicker"  data-live-search="true" data-live-search-style="begins" title="Select Category..." id="select_product_category_select"> 
					<?php $__currentLoopData = $all_category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                         <option value="<?php echo e($ct->id); ?>"><?php echo e($ct->name); ?></option>					
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				  </select>
                </div>
            </div>
			<div class="col-12">
				<button class="btn btn-primary form-control" id="select_product_category_btn"><?php echo e(trans('file.submit')); ?></button>
			</div>
          </div>
    </div>
  </div>
</div>
</div>


<style>
 .mobile-table td[data-title]:before{
	 padding-left:10px;
	 padding-right:10px;
 }
 
 .upload-btn-wrapper {
  position: relative;
  overflow: hidden;
  display: inline-block;
}

.file_btn,.change_product_img {
     color: #6b6464;
    background-color: #d4d4d4;
    border-radius: 10px;
    font-size: 15px;
    width: 40%;
    margin-top: 7px;
    padding: 3px 0;
    border: none;
}
#lbl_passenger_attachment{
      color: #a5a4a4;
	  width:100%;
    display: inline-block
}
#attachment_tbl img{
    width: 120px;
    height: 100px;
    margin: 10px;	
}
.upload-btn-wrapper input[type=file] {
  font-size: 19px;
  left: 0;
  top: 0;
  opacity: 0;
}
.save_attachment{
    background: #2196f3;
    width: 70%;
    height: 47px;
    border: none;
    border-radius: 5px;
    color:#fff;
	font-size:20px; 
}

#gallery_images .close_btn{
	color: red;
    position: absolute;
    right: 14px;
    top: 12px;
    padding: 1px 2px;
    background: #ffffffd4;
    border-radius: 6px; 
}

#gallery_images #attachment_tbl .product-gallery-image{
	display:inline-block;
	position:relative;
}

div.dataTables_wrapper div.dataTables_filter input,div.dataTables_wrapper div.dataTables_filter label{
	width:100%;
}
div.dataTables_wrapper div.dataTables_filter{
	width:40%;
}

</style>
<script type="text/javascript">

     var APP_URL = <?php echo json_encode(url('/')); ?>


     $(".change_category").click(function(){
		var p_id=$(this).attr('pro_id');
		$("#selectedProductID_category_modal").val(p_id);
	 }); 

	 
    $("#select_product_category_btn").click(function(){
		var category= $("#select_product_category_select").val();
	    var product=$("#selectedProductID_category_modal").val();
		var text= $("#select_product_category_select  option:selected").text();
		$.ajax({
		    url:APP_URL+'/products/changes_product_category/'+category+'/'+product,
			p_id:product,
			text:text,
			type:'get',
			success:function(res){
				if(res==1){
					$("#changeProductCategory").modal("hide");
				    $(".categroy_"+this.p_id).text(this.text);
					
				}
			},
			error:function(){		
			}
	   }); 
    });	
		 
		 
		 
	 $(".change_product_img").click(function(){
			$("#prdocut_image").click();
		})  
	
	
	 $(".change_image").click(function(){
		var p_id=$(this).attr('pro_id');
		$("#get_product_id").val(p_id);
	}); 
	
	
	 
	  $('#prdocut_image').change(function () {
		  console.log('something');
        if ($(this).val() != '') {
            upload(this);
        }
    });
    function upload(img) {
		var product_id= $("#get_product_id").val();
        var form_data = new FormData();
        form_data.append('file', img.files[0]);
        form_data.append('product_id', product_id);
       form_data.append('_token', '<?php echo e(csrf_token()); ?>');

        $('.j_modal_loader').css('display','block');
        $('.newOrderViewsModal .modal-body').css('visibility','hidden');
		   
     
        $.ajax({
            url: "<?php echo e(url('products/change_product_image')); ?>",
            data: form_data,
            type: 'POST',
            contentType: false,
            processData: false,
			p_id:product_id,
            success: function (data) {
                if (data.fail) {
                    $('.uploaed_file').html(data);
					alert('faild')
                }
                else {
                    $('.uploaed_file').html(data);
					if(data!=0){
						$("#pr_img_"+this.p_id).attr('src','<?php echo e(asset("public/images/product/")); ?>'+'/'+data);
					    $("#changeProductPhoto").modal('hide');
					}
               }
                
            },
            error: function (xhr, status, error) {
              alert(error);
             $('.j_modal_loader').css('display','none');
	         $('.newOrderViewsModal .modal-body').css('visibility','visible');
			}
        });
    }


 
	 

     $(".show_variation").click(function(){
		  var prodcut_id=$(this).attr('product_id'); 
		  
		  $.ajax({
			  url:APP_URL+"/getProductVariations/"+prodcut_id,
			  type:'get',
			  success:function(response){
				  $("#product_variations .modal-body").html(response);
			  },
			  error:function(){
				  
			  }
		  })
	  });

      $(".show-modal-linke").click(function(){
		  var prodcut_id=$(this).attr('product_id'); 
		  $("input#selectedProductID").val(prodcut_id);
		  $.ajax({
			  url:APP_URL+"/getProductImages/"+prodcut_id,
			  type:'get',
			  success:function(response){
				  $("#attachment_tbl").html(response);
			  },
			  error:function(){
				  
			  }
		  })
	  });
	  
      $("#passenger_attachment").change(function() { 
              var fileList = document.getElementById("passenger_attachment").files;
              var list = '';
              for(var x = 0; x < fileList.length; x++){
                  if(x>0){
                      list += ', ';
                  }
                  list += fileList[x].name;
              }
              $('#lbl_passenger_attachment').text(list); 
          }); 
		  
		$(".file_btn").click(function(){
			$("#passenger_attachment").click();
		})  
	
	
	
	$("#add_attachment_form").submit(function(e){
        e.preventDefault();
        var form = $("#add_attachment_form");
        var formData = new FormData(form[0]);
        var select_attachment = $("#select_attachment").text();
        $.ajax({
            type:"POST",
            enctype: 'multipart/form-data',
            url: $(form).prop("action"),
            data:formData,
            contentType: false, //this is requireded please see answers above
            processData: false, //this is requireded please see answers above
            cache: false, //not sure but works for me without this
            success: function(response){
                //$("#attachment_tbl").append("<img src='"+APP_URL+"/public/images/product_variation/"+responce+"' >");
                //$('#add_attachment_form').each (function(){
                  $("#attachment_tbl").html(response);
				  //changes here
				  this.reset();
                  //$("#lbl_passenger_attachment").append("<img src='"+<?php echo asset('public/images/product_variation')?>+"/'"+responce+"'' />");
                  //$("#lbl_passenger_attachment .message").text("photo added ");
                  
                }			
	   });
        });

	


    $("ul#product").siblings('a').attr('aria-expanded','true');
    $("ul#product").addClass("show");
    $("ul#product li").eq(1).addClass("active");

	function confirmDelete() {
	    if (confirm("Are you sure want to delete?")) {
	        return true;
	    }
	    return false;
	}

    var store = [];
    var qty = [];
    var htmltext;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $( "#select_all" ).on( "change", function() {
        if ($(this).is(':checked')) {
            $("tbody input[type='checkbox']").prop('checked', true);
        } 
        else {
            $("tbody input[type='checkbox']").prop('checked', false);
        }
    });
    
    $("tr.product-link td:not(:first-child, :last-child)").on("click", function(){
        var product = $(this).parent().data('product');
        var imagedata = $(this).parent().data('imagedata');
        htmltext = '';
htmltext = '<p><strong><?php echo e(trans("file.Type")); ?>: </strong>'+product[0].toUpperCase()+'</p><p><strong><?php echo e(trans("file.name")); ?>: </strong>'+product[1]+'</p><p><strong><?php echo e(trans("file.Code")); ?>: </strong>'+product[2]+ '</p><strong><?php echo e(trans("file.Barcode")); ?>: </strong><img src="data:image/png;base64,'+imagedata+'" alt="barcode" /></p><p><strong><?php echo e(trans("file.category")); ?>: </strong>'+product[4]+'</p><p><strong><?php echo e(trans("file.Alert")); ?> <?php echo e(trans("file.Quantity")); ?>: </strong>'+product[10]+'</p><p><strong><?php echo e(trans("file.product details")); ?>: </strong></p>'+product[11];

        $.get('products/product_store/' + product[12], function(data) {
            $(".product-store-list thead").remove();
            $(".product-store-list tbody").remove();
            
            store = data[0];
            qty = data[1];
            if(store.length != 0){
                var newHead = $("<thead>");
                var newBody = $("<tbody>");
                var newRow = $("<tr>");
                newRow.append('<th><?php echo e(trans("file.Store")); ?></th><th><?php echo e(trans("file.Quantity")); ?></th>');
                newHead.append(newRow);
                $.each(store, function(index){
                    var newRow = $("<tr>");
                    var cols = '';
                    cols += '<td>' + store[index] + '</td>';
                    cols += '<td>' + qty[index] + '</td>';

                    newRow.append(cols);
                    newBody.append(newRow);
                    $("table.product-store-list").append(newHead);
                    $("table.product-store-list").append(newBody);
                });
            }
        });

        $('#product-content').html(htmltext);
        $('#product-details').modal('show');
    });

    $("#print-btn").on("click", function(){
          var divToPrint=document.getElementById('product-details');
          var newWin=window.open('','Print-Window');
          newWin.document.open();
          newWin.document.write('<style type="text/css">@media  print { #print-btn { display: none } #close-btn { display: none } }</style><body onload="window.print()">'+divToPrint.innerHTML+'</body>');
          newWin.document.close();
          setTimeout(function(){newWin.close();},10);
    });

    $('#product-data-table').DataTable( {
        "order": [],
        'columnDefs': [
            {
                "orderable": false,
                'targets': [0, 1, 9]
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
                    rows: ':visible',
                    stripHtml: false
                },
                customize: function(doc) {
                    for (var i = 1; i < doc.content[1].table.body.length; i++) {
                        if (doc.content[1].table.body[i][0].text.indexOf('<img src=') !== -1) {
                            var imagehtml = doc.content[1].table.body[i][0].text;
                            var regex = /<img.*?src=['"](.*?)['"]/;
                            var src = regex.exec(imagehtml)[1];
                            var tempImage = new Image();
                            tempImage.src = src;
                            var canvas = document.createElement("canvas");
                            canvas.width = tempImage.width;
                            canvas.height = tempImage.height;
                            var ctx = canvas.getContext("2d");
                            ctx.drawImage(tempImage, 0, 0);
                            var imagedata = canvas.toDataURL("image/png");
                            delete doc.content[1].table.body[i][0].text;
                            doc.content[1].table.body[i][0].image = imagedata;
                            doc.content[1].table.body[i][0].fit = [30, 30];
                        }
                    }
                },
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: ':visible:not(.not-exported)',
                    rows: ':visible',
                    format: {
                        body: function ( data, row, column, node ) {
                            if (column === 0 && (data.indexOf('<img src=') !== -1)) {
                                var regex = /<img.*?src=['"](.*?)['"]/;
                                data = regex.exec(data)[1];                 
                            }
                            return data;
                        }
                    }
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible:not(.not-exported)',
                    rows: ':visible',
                    stripHtml: false
                }
            },
            {
                extend: 'colvis',
                columns: ':gt(0)'
            },
        ],
    } );

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
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
 <button class="btn btn-primary" data-target="#product-details" data-toggle="modal" style="margin:20px 53px 0px 0px; float:right;"><?php echo e(trans('file.add_new')); ?></button>
<section style="padding-top:0px">
   
    <div class="table-responsive">
        <table id="product-data-table" class="table table-striped rwd-table" data-autogen-headers="true" >
            <thead>
                <tr>
                    <th class="not-exported"></th>
					<th>No.</th>
                    <th><?php echo e(trans('file.coupon_number')); ?></th>
                    <th><?php echo e(trans('file.number_of_use')); ?></th>
                    <th><?php echo e(trans('file.discount_value')); ?></th>
                    <th><?php echo e(trans('file.expire_date')); ?></th>
                    <th style="display:none"></th><th style="display:none"></th><th style="display:none"></th><th style="display:none"></th>
                    <th class="not-exported"><?php echo e(trans('file.action')); ?></th>
                </tr>
            </thead>
            <tbody>
			   <?php $counter=1; ?>
			   <?php if($data['cobun']): ?>
                <?php $__currentLoopData = $data['cobun']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
                <tr class="company-link" >
                    <td></td>
					<td><?php echo e($counter); ?></td>
					<td><?php echo e($cb->cobun_number); ?></td>
                    <td><?php echo e($cb->number_of_use); ?></td>
                    <td><?php echo e($cb->value); ?></td>
                    <td><?php echo e($cb->expire_date); ?></td>
                    <td style="display:none"></td><td style="display:none"></td><td style="display:none"></td><td style="display:none"></td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo e(trans('file.action')); ?>

                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                
								<li>
                                    <a href="#edit-product-details" data-toggle="modal" class="btn btn-link edit_cobuns" cobun_id="<?php echo e($cb->id); ?>"><i class="fa fa-edit"></i> <?php echo e(trans('file.edit')); ?></a>
                                </li>
								<li class="divider"></li>
								
								<?php echo e(Form::open(['url' => ['cobun/delete', $cb->id], 'method' => 'DELETE'] )); ?>

                                <li>
                                    <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="fa fa-trash"></i> <?php echo e(trans('file.delete')); ?></button>
                                </li>
                                <?php echo e(Form::close()); ?>

                            </ul>
                        </div>
                    </td>
                </tr>
				<?php $counter++; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<?php else: ?>
                <tr><td><?php echo e(trans('file.not_found')); ?></td></tr>					
				<?php endif; ?>
				
            </tbody>
        </table>
    </div>
</section>


<div id="product-details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 id="exampleModalLabel" class="modal-title"><?php echo e(trans('file.add')); ?> <?php echo e(trans('file.coupons')); ?> &nbsp;&nbsp;</h5>
          <button type="button" id="close-btn" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
        </div>
            <div id="product-content" class="modal-body">
            </div>
            <table class="table table-bordered table-hover product-store-list">
                <thead>
                </thead>
                <tbody >
				 <div class="row" style="margin:0px">
				  <?php echo Form::open(['url' => 'cobuns/create_cobon', 'method' => 'get', 'class' => ' main_form form-whitout-modal','id'=>'add_suggest','enctype'=> 'multipart/form-data']); ?>

				   <div class="col-md-6">
				      <div class="form-group">
					    <label for="cobun_no" style="width:100%"><a href="javascript:void(0)" 
								id="auto_generate_pincode" style="float:left"><?php echo e(trans("file.auto_generate")); ?></a>
								<?php echo e(trans('file.coupon_number')); ?> 
						</label>
					    <input type="number" name="cobun_no" id="cobun_no" class="form-control">
					  </div>
					  
					   <div class="form-group">
					    <label for="number_of_use"><?php echo e(trans('file.number_of_use')); ?></label>
					    <input type="number" name="number_of_use" id="number_of_use" class="form-control">
					  </div>
					  
					  <div class="form-group">
					    <label for="discount_value" ><?php echo e(trans('file.discount_value')); ?></label>
					    <input type="number" name="discount_value" id="discount_value" class="form-control">
					   </div>

                                        <div class="form-group">
					    <label for="expire_date" ><?php echo e(trans('file.expire_date')); ?></label>
					    <input type="text" name="expire_date" id="expire_date" class="form-control">
					   </div>
					   
				   </div>
				    <div class="col-md-6">
					<h3 ><?php echo e(trans('file.select_category')); ?></h3>
					   <div class="row" style="margin-right:0px">
					   <div class="col-md-12 checkbox_container all_categoris_container" >
						   <label for="select_all_category_inser"> <?php echo e(trans('file.all')); ?> </label>
						   <input type="checkbox" class="defaul_checkbox"  id="select_all_category_inser">
                           <label class="checkmark_button" for="select_all_category_inser"></label>
						</div><hr>
					 
					  <?php $__currentLoopData = $data['category']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-6 checkbox_container" >
						   <label for="<?php echo e($category->id); ?>"> <?php echo e($category->name); ?> </label>
						   <input type="checkbox" class="defaul_checkbox insert_checkbox" name="selected_category[]" id="<?php echo e($category->id); ?>" value="<?php echo e($category->id); ?>">
                           <label class="checkmark_button" for="<?php echo e($category->id); ?>"></label>
						</div>						
					  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					 </div> 
				   </div>
				   
					
				     <div class="col-md-12">
					      <label style="visibility:hidden"><?php echo e(trans('file.submit')); ?></label>
					   	 <input type="submit" name="submit" class="btn btn-primary" value="<?php echo e(trans('file.create')); ?>">
					 </div>
				  <?php echo Form::close(); ?> 
				  </div> 
                </tbody>
            </table>
      </div>
    </div>
</div>

<div id="edit-product-details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 id="exampleModalLabel" class="modal-title"><?php echo e(trans('file.edit')); ?> <?php echo e(trans('file.coupons')); ?> &nbsp;&nbsp;</h5>
          <button type="button" id="close-btn" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
        </div>
            <div id="product-content" class="modal-body">
            </div>
            <table class="table table-bordered table-hover product-store-list">
                <thead>
                </thead>
                <tbody >
				 <div class="row" style="margin:0px">
				  <?php echo Form::open(['url' => 'cobuns/update_cobon', 'method' => 'get', 'class' => ' main_form form-whitout-modal','id'=>'add_suggest','enctype'=> 'multipart/form-data']); ?>

				   <div class="col-md-6">
				      <div class="form-group">
					    <label for="u_cobun_no" style="width:100%"><a href="javascript:void(0)" 
								id="uauto_generate_pincode" style="float:left"><?php echo e(trans("file.auto_generate")); ?></a>
								<?php echo e(trans('file.coupon_number')); ?> 
						</label>
					    <input type="number" name="u_cobun_no" id="u_cobun_no" class="form-control">
					    <input type="hidden" id="selected_cobun_id" name="cobun_id_c">
					  </div>
					  
					  <div class="form-group">
					    <label for="u_number_of_use"><?php echo e(trans('file.number_of_use')); ?></label>
					    <input type="number" name="u_number_of_use" id="u_number_of_use" class="form-control">
					  </div>
				     
					  <div class="form-group">
					    <label for="u_discount_value" ><?php echo e(trans('file.discount_value')); ?></label>
					    <input type="number" name="u_discount_value" id="u_discount_value" class="form-control">
					   </div>
                                         		
					 <div class="form-group">
					    <label for="u_expire_date" ><?php echo e(trans('file.expire_date')); ?></label>
					    <input type="text" name="u_expire_date" id="u_expire_date" class="form-control">
					   </div>  
				   </div>
				   <div class="col-md-6">
				       <h3 ><?php echo e(trans('file.select_category')); ?></h3>
					   <div class="row" style="margin-right:0px">
					   <div class="col-md-12 checkbox_container all_categoris_container" >
						   <label for="select_all_category_update"> <?php echo e(trans('file.all')); ?> </label>
						   <input type="checkbox" class="defaul_checkbox update_checkbox"  id="select_all_category_update">
                           <label class="checkmark_button" for="select_all_category_update"></label>
						</div><hr>
					 
					  <?php $__currentLoopData = $data['category']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-6 checkbox_container  update_list" >
						   <label for="up_check<?php echo e($category->id); ?>"> <?php echo e($category->name); ?> </label>
						   <input type="checkbox" class="defaul_checkbox update_checkbox"  name="selected_category[]" id="up_check<?php echo e($category->id); ?>" value="<?php echo e($category->id); ?>" >
                           <label class="checkmark_button" for="up_check<?php echo e($category->id); ?>"></label>
						</div>						
					  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					 </div> 
				   </div>
				   
				     <div class="col-md-12">
					      <label style="visibility:hidden"><?php echo e(trans('file.update')); ?></label>
					   	 <input type="submit" name="submit" class="btn btn-primary" value="<?php echo e(trans('file.update')); ?>">
					 </div>
				  <?php echo Form::close(); ?> 
				  </div> 
                </tbody>
            </table>
      </div>
    </div>
</div>
<style>
.all_categoris_container{
	margin-bottom:14px;
    border-bottom:1px solid lightgray;	
}
.checkbox_container {
  display: block;
  position: relative;
  padding-right: 45px;
  cursor: pointer;
  font-size: 20px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}
.checkbox_container .defaul_checkbox {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}


.checkmark_button {
  position: absolute;
  top: 0;
  right: 0;
  height: 21px;
  width: 21px;
  background-color: #eee;
}


.checkbox_container:hover .defaul_checkbox ~ .checkmark_button {
  background-color: #ccc;
}


.checkbox_container .defaul_checkbox:checked ~ .checkmark_button {
  background-color: #2196F3;
}


.checkmark_button:after {
  content: "";
  position: absolute;
  display: none;
}

.checkbox_container .defaul_checkbox:checked ~ .checkmark_button:after {
  display: block;
}

.checkbox_container .checkmark_button:after {
  left: 8px;
  top: 2px;
  width: 8px;
  height: 14px;
  border: solid white;
  border-width: 0 5px 5px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}

table.dataTable{
	width:100% !important;
}
</style>
<script type="text/javascript">
     
     var APP_URL = <?php echo json_encode(url('/')); ?>


       var date = $('#expire_date');
		date.datepicker({
		 format: "yyyy-mm-dd",
		 startDate: "<?php echo date('d-m-Y', strtotime('')); ?>",
		 autoclose: true,
		 todayHighlight: true
       });
      var date = $('#u_expire_date');
		date.datepicker({
		 format: "yyyy-mm-dd",
		 autoclose: true,
		 todayHighlight: true
         });

	 $("#select_all_category_inser").click(function(){
		 if($('#select_all_category_inser').is(":checked")==true){
		   $('.insert_checkbox').prop('checked',true);
		 }
		 else{
			$('.insert_checkbox').prop('checked',false); 
		 }
	 });
	 
	 
	  $("#select_all_category_update").click(function(){
		 if($('#select_all_category_update').is(":checked")==true){
		   $('.update_checkbox').prop('checked',true);
		 }
		 else{
			$('.update_checkbox').prop('checked',false); 
		 }
	 });
	 
	 
     $(document).on("click",'#auto_generate_pincode', function(){
          var val = Math.floor(10000000 + Math.random() * 90000000);
		  $.ajax({
			  url:APP_URL+'/coupon/check_auto_cobun_no/'+val,
			  type:'get',
			  success:function(response){
			    $("#cobun_no").val(response);	  
			  } 
		  });
        });
	
    $(document).on("click",'#uauto_generate_pincode', function(){
          var val = Math.floor(10000000 + Math.random() * 90000000);
		     
			 $.ajax({
			  url:APP_URL+'/coupon/check_auto_cobun_no/'+val,
			  type:'get',
			  success:function(response){
			    $("#u_cobun_no").val(response);			
			  } 
		  });
           
		});

		$(".edit_cobuns").click(function(){
		var cid=$(this).attr('cobun_id');
		$.ajax({
			url:APP_URL+'/cobun/edit/'+cid,
			type:'get',
			success:function(response){
				$("#u_cobun_no").val(response.split('&')[0]);
				$("#u_number_of_use").val(response.split('&')[1]);
				$("#u_discount_value").val(response.split('&')[2]);
                                $("#u_expire_date").val(response.split('&')[4]);
				$("#selected_cobun_id").val(cid);
				var categories=response.split('&')[3];
				var splitecate = categories.split("-");
				$('.update_checkbox').prop('checked',false);
				for(var i=0; i<splitecate.length; i++){
					$("#up_check"+splitecate[i]).prop('checked',true);
					
				}
			},
			error:function(){
				
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
        htmltext = '<p><strong><?php echo e(trans("file.Type")); ?>: </strong>'+product[0].toUpperCase()+'</p><p><strong><?php echo e(trans("file.name")); ?>: </strong>'+product[1]+'</p><p><strong><?php echo e(trans("file.Code")); ?>: </strong>'+product[2]+ '</p><strong><?php echo e(trans("file.Barcode")); ?>: </strong><img src="data:image/png;base64,'+imagedata+'" alt="barcode" /></p><p><strong><?php echo e(trans("file.Brand")); ?>: </strong>'+product[3]+'</p><p><strong><?php echo e(trans("file.category")); ?>: </strong>'+product[4]+'</p><p><strong><?php echo e(trans("file.Unit")); ?>: </strong>'+product[5]+'</p><p><strong><?php echo e(trans("file.Quantity")); ?>: </strong>'+product[13]+'</p><p><strong><?php echo e(trans("file.Alert")); ?> <?php echo e(trans("file.Quantity")); ?>: </strong>'+product[10]+'</p><p><strong><?php echo e(trans("file.Cost")); ?>: </strong>'+product[6]+'</p><p><strong><?php echo e(trans("file.Price")); ?>: </strong>'+product[7]+'</p><p><strong><?php echo e(trans("file.Tax")); ?>: </strong>'+product[8]+'</p><p><strong><?php echo e(trans("file.Tax")); ?> <?php echo e(trans("file.Method")); ?>: </strong>'+product[9]+'</p><p><strong><?php echo e(trans("file.product details")); ?>: </strong></p>'+product[11];

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
<?php $__env->startSection('content'); ?>
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4><?php echo e(trans('file.add_product_quick')); ?></h4>
                    </div>
                    <div class="card-body">
                        <p class="italic"><small><?php echo e(trans('file.The field labels marked with * are required input fields')); ?>.</small></p>
                        <?php echo Form::open(['url' => '', 'method' => 'post', 'files' => true, 'id' => 'add_product_form']); ?>

                        <div class="row">
						  <div class="col-md-3">
						    <div class="form-group">
							  <label for="product_name"><strong><?php echo e(trans('file.product')); ?> <?php echo e(trans('file.name')); ?> *</strong></label>
							  <input type="text" required name="product_name" class="form-control" id="product_name">
							   <input type="hidden" id="product_id" name="product_id">
							</div>
						  </div>
						  
						  <div class="col-md-3">
						    <div class="input-group">
							  <label for="barcode" style="width:100%"><strong><?php echo e(trans('file.Code')); ?></strong> </label>
							  <input type="text"  name="barcode" class="form-control" id="barcode"><div class="input-group-append"><button id="genbutton" type="button" class="btn btn-default"><?php echo e(trans('file.Generate')); ?></button></div>
							</div>
						  </div>
						  
						  <div class="col-md-3">
						    <div class="form-group">
                                    <label for="category_id"><strong><?php echo e(trans('file.category')); ?> </strong> </label>
                                    <div class="input-group">
                                      <select name="category_id"   id="category_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Category...">
                                        <?php $__currentLoopData = $ezpos_category_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                      </select>
                                  </div>
                                </div>
						  </div>
						  
						  <div class="col-md-3">
						     <div class="form-group">
							     <label for="file"><strong><?php echo e(trans('file.Attach File')); ?> </strong> </label>
                                 <input type="file" name="file" id="file" class="form-control">
							 </div>
						  </div>
						  
						  <div class="col-md-3">
						       <div class="form-group">
                                 <label for="cost"><strong><?php echo e(trans('file.product')); ?> <?php echo e(trans('file.Cost')); ?> </strong> </label>
                                 <input type="number" name="cost" id="cost"  class="form-control" step="any">
                                </div>
						  </div>
						  
						  <div class="col-md-3">
						    <div class="form-group">
                              <label for="price"><strong><?php echo e(trans('file.product')); ?> <?php echo e(trans('file.Price')); ?> </strong> </label>
                              <input type="number" name="price" id="price" class="form-control" step="any">
                            </div>
						  </div>
						  
						  <div class="col-md-3">
						    <div class="form-group">
							  <label for="unit"><strong><?php echo e(trans('file.product')); ?> <?php echo e(trans('file.Unit')); ?> </strong></label>
							  <input type="text"  name="unit" class="form-control" id="unit">
							</div>
						  </div>
						  
						   <div class="col-md-3">
						    <div class="form-group">
							  <label for="quantity"><strong><?php echo e(trans('file.Quantity')); ?> </strong></label>
							  <input type="text"  name="quantity" class="form-control" id="quantity">
							</div>
						  </div>
						  
						  <div class="col-md-3">
						    <div class="form-group">
							  <label for="alert_quantity"><strong><?php echo e(trans('file.Alert')); ?> <?php echo e(trans('file.Quantity')); ?></strong> </label>
                              <input type="number" name="alert_quantity" id="alert_quantity" class="form-control" step="any">
							</div>
						  </div>
						  
						</div>
						<div class="form-group">
                            <input type="button" value="<?php echo e(trans('file.submit')); ?>" class="btn btn-primary" id="sendformData">
                            <input type="button" value="<?php echo e(trans('file.edit')); ?>" class="btn btn-success" id="editformData">
                            
						</div>

                        <?php echo Form::close(); ?>

						<hr>
						<div class="search_allproducts">
						   <input type="text" class="form-control" name="search" id="search" autocomplete="off">
                           <span class="fa fa-search"></span>
						   <div id="search_result">
							</div>
						</div>
						<h4><?php echo e(trans('file.lastest_inserted')); ?></h4>
						<table class="table table-striped">
						   <thead>
						     <tr><th>#</th><th><?php echo e(trans('file.name')); ?></th><th><?php echo e(trans('file.Code')); ?></th><th><?php echo e(trans('file.category')); ?></th><th><?php echo e(trans('file.Alert')); ?> <?php echo e(trans('file.Quantity')); ?></th><th><?php echo e(trans('file.Unit')); ?></th><th><?php echo e(trans('file.price')); ?></th></tr>
						   </thead>
						   <tbody id="lastest_product">
						     <?php $counter=1; ?>
						     <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                               <tr class="edit_product" product_id="<?php echo e($product->id); ?>" ><td><?php echo e($counter); ?></td><td><?php echo e($product->name); ?></td><td><?php echo e($product->code); ?></td><td><?php echo e($product->category); ?></td><td><?php echo e($product->alert_quantity); ?></td><td><?php echo e($product->unit); ?></td><td><?php echo e($product->price); ?></td></tr>							 
							 <?php $counter++;?>
							 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						   </tbody>
						</table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
 .search_allproducts{
    margin-bottom: 20px;
    position: relative; 
 }
 .search_allproducts span{
	position: absolute;
    top: 9px;
    left: 10px;
    color: #ced4da;
 }
 .search_allproducts input{
	padding-left: 30px;
    padding-right: 30px;
 }
 #search_result {
	 z-index: 333;
    position: absolute;
    width: 100%;
    height: 100px;
    background: #242e42;
    color: #fff;
    display: none;
	overflow: auto;
 }
 
 
 #search_result::-webkit-scrollbar{
	 width: 5px;
 }
 #search_result::-webkit-scrollbar-track {
    box-shadow: outset 4px 14px 5px red; 
    border-radius: 10px;
}
#search_result::-webkit-scrollbar-thumb {
    background: #bbbec3; 
    border-radius: 10px;
}

</style>
<script type="text/javascript">
    var APP_URL = <?php echo json_encode(url('/')); ?>

	
	$("#search").keyup(function(){
		var word=$(this).val();
		$.ajax({
			url:APP_URL+'/products/searchProduct/'+word,
			type:'get',
			success:function(response){
				$("#search_result").css('display','block');
				$("#search_result").html(response);
				
			},
			error:function(data){
				//alert(data);
			}
			
		})
	});
	
	$(document).click(function(e){
		if(e.target.class != "edit_product"){
			$("#search_result").css('display','none');
		}
	})
      $("#product_name").on({
		  focus:function(){
			  $(this).css('border','1px solid  #7c5cc4');
		  },
		  blur:function(){
			 if($(this).val()==""){
				 $(this).css('border','1px solid  red');
			 } 
			 else{
			    $(this).css('border','1px solid #ced4da');	 
			 }
		  }
	  })
	  
	  
	  
     $("#sendformData").click(function(){
		 if($("#product_name").val()==""){
				$("#product_name").css('border','1px solid red');
				return;
		  }
				
		var myform=$("#add_product_form");
		var formData = new FormData(myform[0]);
		$.ajax({
			type:"POST",
            url: APP_URL+'/products/quickstore',
            data:formData,
			success:function(response){
				$("#lastest_product").html(response);
				$("#add_product_form input[type='text'],#add_product_form input[type='number'],#add_product_form input[type='file']").val("");
			  
			},
			 cache: false,
             contentType: false,
             processData: false,
			 
			error:function(data){
			  alert(data);
			}
			
		}); 
		 
	 })
 
      $('#genbutton').on("click", function(){
      $.get('gencode', function(data){
        $("input[name='barcode']").val(data);
      });
    });
 
 
   $(".edit_product").click(function(){
	   var product_id=$(this).attr('product_id');
	   $.ajax({
		   url:APP_URL+'/products/searchPro/'+product_id,
		   type:'get',
		   success:function(response){
			   $("#product_name").val(response.split(',')[0]);
			   //$("#category_id option[value="+response.split(',')[1]+"]").attr('selected', 'selected');
			   //$("#category_id").val(response.split(',')[1]);
			   $('#category_id option[value='+response.split(',')[1]+']').prop('selected', true);
			   $('.filter-option.pull-left').text($("#category_id option:selected").text());

			   $("#quantity").val(response.split(',')[2]);
			   $("#price").val(response.split(',')[3]);
			   $("#cost").val(response.split(',')[4]);
			   $("#unit").val(response.split(',')[5]);
			   $("#alert_quantity").val(response.split(',')[6]);
			   $("#barcode").val(response.split(',')[7]);
			   $("#product_id").val(product_id);
		   },
		   error:function(data){
			  alert(data); 
		   }
	   })
   });

 $("#editformData").click(function(){
	 if($('#product_id').val()==""){
		 alert('first select the product');
	 }
	 else{
		 var myform=$("#add_product_form");
		 var formData = new FormData(myform[0]);
		 $.ajax({
			type:"POST",
            url: APP_URL+'/products/updateproduct',
            data:formData,
			success:function(response){
				$("#lastest_product").html(response);
				$("#add_product_form input[type='text'],#add_product_form input[type='number'],#add_product_form input[type='file']").val("");
			  
			},
			 cache: false,
             contentType: false,
             processData: false,
			 
			error:function(data){
			  alert(data);
			}
			 
		 });
	 }
 })   
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->startSection('content'); ?>
<style >
.btns{
	 width: 28px;
    height: 28px;
    border-radius: 50%;
    border: 1px solid gray;
    background: transparent;
    box-shadow: 1px 1px #c1c1c1;
	position:relative;
}
.btns span{
	font-size: 33px;
    position: absolute;
  
    
}
.btns span.left{
     left: 6px;
    top: -14px;
}
.btns span.right{
	top: -14px;
    left: 4px;
}
</style>
<section class="forms" style="padding:2px 0px;background:#dcdcdc;">
    <div class="container-fluid" style="padding:0px;">
        <div class="row">
            <div class="col-md-12">
                <div class="card" style="margin-bottom:0px;background:#dcdcdc">
                    <div class="card-header  align-items-center">
                        <div class="row">
						  <div class="col-md-6">
						    <div class="form-group">
							  <input type="text" class="form-control" name="product" id="product_name" placeholder="<?php echo e(trans('file.barcode_or_name')); ?>" style="background:#efefef; font-family:Cairo;font-size:22px; padding:0px 10px 0px">
							</div>
						  </div>
						
						  <div class="col-md-4">
						    <div class="form-group">
							  <select class="form-control"> 
							    <option value=""><?php echo e(trans('file.select_customer')); ?></option>
								<?php $__currentLoopData = $customer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customers): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								  <option value="<?php echo e($customers->id); ?>"><?php echo e($customers->name); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							  </select>
							</div>
						  </div>
						  <div class="col-md-2 col-sm-2" style="padding:0px;">
						   <button class="btn" style="background:#41d395;color:#fff"><span class="fa fa-user-plus"></span></button>
						   <button class="btn" style="background:#ff7d2e;color:#fff"><span class="ion-arrow-return-left"></span></button>
						  </div>
						   
						</div>
                    </div>
                    <div class="card-body jproduct-list" style="height:400px; overflow:auto; padding:1.25rem 2em" id="result-search">
                        <ul style="list-style-type:none;margin:0px;padding:0px;">
						  <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						   <div class="row" style="margin-top:10px;margin-bottom:10px;;padding-top:5px;padding-bottom:5px; background:#fff; background:2px 2px 12px #b1adad;">
							 <div class="col-md-2" style="border-right:1px solid #c5c4c4;">
							   <img src="<?php echo e(url('public/images/product',$product->image)); ?>" style="width:120px">
							 </div>
							 <div class="col-md-8" >
							   <h2 style="font-size:1.3rem"><?php echo e($product->name); ?></h2>
							   <h3 style="font-size:1rem; color:gray;"> <?php echo e($product->product_details); ?> </h3>
							   <p style="font-size:33px;font-size: 28px;margin: 0px;position: absolute;bottom: 0px;"><?php echo e($product->price); ?>$</p>
							 </div>
							 <div class="col-md-2 add_to_cart" style="border-left:1px solid #c5c4c4;">
							   <p style="text-align:center" ><?php echo e(trans('file.count')); ?></p>
							   <p style="margin-top:-17px" ><button class="btns minus" product_id="<?php echo e($product->id); ?>" ><span class="left"  >-</span></button > <input type="text" id="<?php echo e($product->id); ?>" name="product_count"  style="width:57px;text-align:center; font-size:20px; margin-left:4px" value="0" ><button class="btns sum" style="margin-left:4px;"  product_id="<?php echo e($product->id); ?>"><span class="right" >+</span></button></p>
							   <p><button class="btn btn-block add_cart" style="color:#fff; font-size:17px; background:linear-gradient(to right,#EE8636,#E03C8E)" product_id="<?php echo e($product->id); ?>"><?php echo e(trans('file.add')); ?></button></p>

							 </div>
						   </div>
						  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </ul>
                    </div>
                </div>
				<div class="card" style="margin:0px;">
				  <div class="card-body jshipping">
				    <div class="row" style="font-weight:bold;color:#a7a6a6">
					  <div class="col-md-6">
					    <div class="row" style="margin:0px">
						 <div class="col-md-6">
						  <?php echo e(trans('file.total_item')); ?>:   <span id="span-right" style="margin-left:24px;color:#000">0</span>
						 </div>
                         <div class="col-md-6">						 
						   <?php echo e(trans('file.total_money')); ?>:  <span id="span-left" style="margin-left:24px;color:#000">0</span>
						 </div>  
						</div>
						<div class="row" style="margin:0px; margin-top:13px">
						   <div class="col-md-5">
						  <?php echo e(trans('file.payment_method')); ?>: 
						 </div>
                         <div class="col-md-7">						 					 
						   <button class="btn" style="width:88px"><?php echo e(trans('file.debit')); ?></button>
						   <button class="btn" style="width:88px;background:#fff;border:1px solid gray;" ><?php echo e(trans('file.cash')); ?></button>
						 </div> 
						</div>
					  </div>
					  <div class="col-md-3">
					     <div> <?php echo e(trans('file.discount')); ?>  <input type="number" value="0" id="discount" name="discount" style="width: 133px;float: right;font-weight:bold"></div>
					     <div style="clear: both;margin-top: 10px;"><?php echo e(trans('file.net')); ?>  <input type="text" readonly name="net" id="net" style="font-weight:bold;width:133px; float:right"></div>
					  </div>
					  <div class="col-md-3">
					    <button class="btn btn-lg " style="background:#6d6b6b;color:#fff;width:100px;padding:15px;" ><?php echo e(trans('file.save_draft')); ?></button>
					    <button class="btn btn-lg cash" style="background:linear-gradient(to right,#EE8636,#E03C8E);color:#fff;width:100px;padding:15px;" data-toggle="modal" data-target="#payModal"><?php echo e(trans('file.save')); ?></button>
					  </div>
					</div>
				  </div>
			   </div>	
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="payModal">
   <div role="document" class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 id="exampleModalLabel" class="modal-title"><?php echo e(trans('file.Finalize')); ?> <?php echo e(trans('file.Sale')); ?></h5>
                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
						  <?php echo Form::open(['url' => 'offers/sele', 'method' => 'post', 'files' => true, 'class' => 'payment-form']); ?>

                            <div class="">
                                <label><strong><?php echo e(trans('file.Payment')); ?> <?php echo e(trans('file.reference')); ?> : </strong></label>
                                <span style="color: #868e96"><?php echo e('spr-' . date("Ymd") . '-'. date("his")); ?></span>
                            </div>
                            <div class="form-group">
                                <label><strong><?php echo e(trans('file.Paid')); ?> <?php echo e(trans('file.Amount')); ?> *</strong></label>
                                <input type="text" name="paid_amount" class="form-control numkey" required step="any">
                            </div>
                            <div class="form-group" style="display:none">
                                <label><strong><?php echo e(trans('file.Paid')); ?> <?php echo e(trans('file.By')); ?></strong></label>
                                <select name="paid_by_id" class="form-control">
                                    <option value="1">Cash</option>
                                    <option value="2">Gift Card</option>
                                    <option value="3">Credit Card</option>
                                    <option value="4">Cheque</option>
                                    <option value="5">Paypal</option>
                                    <option value="6">Deposit</option>
                                </select>
                            </div>
                            <div class="form-group" style="display:none">
                                <div class="card-element form-control">
                                </div>
                                <div class="card-errors" role="alert"></div>
                            </div>
                            <div class="form-group" id="gift-card" style="display:none">
                                <label><strong> <?php echo e(trans('file.Gift Card')); ?></strong></label>
                                <input type="hidden" name="gift_card_id">
                                <select id="gift_card_id_select" name="gift_card_id_select" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Gift Card..."></select>
                            </div>
                            <div id="cheque" style="display:none">
                                <div class="form-group">
                                    <label><strong><?php echo e(trans('file.Cheque')); ?> No</strong></label>
                                    <input type="text" name="cheque_no" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label><strong><?php echo e(trans('file.Payment')); ?> <?php echo e(trans('file.Note')); ?></strong></label>
                                <textarea id="payment_note" rows="2" class="form-control" name="payment_note"></textarea>
                            </div>
                            <div class="row">
                               <div class="col-md-6 form-group">
                                    <label><strong><?php echo e(trans('file.Sale')); ?> <?php echo e(trans('file.Note')); ?></strong></label>
                                    <textarea rows="3" class="form-control" name="sale_note"></textarea>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label><strong><?php echo e(trans('file.Staff')); ?> <?php echo e(trans('file.Note')); ?></strong></label>
                                    <textarea rows="3" class="form-control" name="staff_note"></textarea>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button id="submit-btn" type="submit" class="btn btn-primary"><?php echo e(trans('file.submit')); ?></button>
                            </div>
							<?php echo Form::close(); ?>

                        </div>
                    </div>
                </div>
            
</div>

<script type="text/javascript">
     var APP_URL = <?php echo json_encode(url('/')); ?>

     $("#product_name").keyup(function(event){
		 if(event.which==13){
			 var word=$(this).val();
			 jQuery.ajax({
                    method : 'GET',
                    url : ''+APP_URL+'/offers/search_product/'+word,
                    success: function(response){ 
                        $('#result-search').html(response);
                    }
                });
		 }
	 });
     
	 $(".add_cart").click(function(){
		 var id=$(this).attr('product_id');
		 var qty=$("input#"+id).attr('value');
		 
			jQuery.ajax({
				method : 'GET',
				url : ''+APP_URL+'/offers/add_to_cart/'+id+'/'+qty,
				success: function(response){
					var pqty=$("#span-right").text();
					var ptotal=$("#span-left").text();
					pqty=parseInt(pqty);
					ptotal=parseInt(ptotal);
					
                    var nqty=response.split(",")[0];
                    var cost=response.split(",")[1];
                      					
					$("#span-right").text(pqty+parseInt(nqty));
					$("#span-left").text(ptotal+nqty*cost);
					$("#net").val((ptotal+nqty*cost)-parseInt($("#discount").val()));
				}
          });
	 })
	 $("#discount").change(function (){
		var total=parseInt($("#net").val()); 
		var newval=total-parseInt($(this).val());
		$("#net").val(newval);
	 });
	 
	 $(".cash").click(function(){
		 $(".numkey").val($("#net").val()); 
	 })
	 $(".minus").click(function(){
	 var id=$(this).attr('product_id');
     var newvalue=Number($("#"+id).val())-1;
     if(newvalue>0){
		 $('#'+id).attr("value",newvalue);
	 }
     else{
		$('#'+id).attr("value",0); 
	 }	 
  });
  
   $(".sum").click(function(){
	 var id=$(this).attr('product_id');
        var newvalue=Number($("#"+id).val())+1;
       
	 $('#'+id).attr("value",newvalue); 	 
  });
	 
    $("ul#product").siblings('a').attr('aria-expanded','true');
    $("ul#product").addClass("show");
    $("ul#product li").eq(2).addClass("active");

    $("#digital").hide();
    $("#promotion_price").hide();
    $("#start_date").hide();
    $("#last_date").hide();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

	$('#genbutton').on("click", function(){
      $.get('gencode', function(data){
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


    $( "#promotion" ).on( "change", function() {
        if ($(this).is(':checked')) {
            $("#starting_date").val($.datepicker.formatDate('dd-mm-yy', new Date()));
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
            if(barcode_symbology == 'UPCA' && product_code.length > 11){
                alert('Product code length must be less than 12');
                e.preventDefault();
            }
            else if(barcode_symbology == 'EAN8' && product_code.length > 7){
                alert('Product code length must be less than 8');
                e.preventDefault();
            }
            else if(barcode_symbology == 'EAN13' && product_code.length > 12){
                alert('Product code length must be less than 13');
                e.preventDefault();
            }
        }
    });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
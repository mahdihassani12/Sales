 <?php echo Form::open(['url' => 'sendRequest', 'method' => 'post', 'id'=> 'sendRequestForm', 'class' => 'form-horizontal main_form form-whitout-modal']); ?>  

<div class="card cart-labels">
	   
		<div class="card-body">
		    <div class="row">
			   <div class="col-lg-6"> 			  
			      <div class="form">
					    <div class="form-group">
						  <label for="firstname">اسمک</label>
						  <input type="text" name="firstname" placeholder="ادخل اسمک الکامل هنا" id="firstname" class="form-control">
						</div>
						<div class="form-group">
						  <label for="phone">رقم الهاتف</label><span class='valid_phone' style='margin-right:10px;display:none; color:red;'><?php echo e(trans('file.valid_phone')); ?></span>
						  <input type="text" name="phone" id="phone" class="form-control" placeholder="مثل: 07701234123">
						</div>
						<div class="form-group">
						  <label>اختر طريقة التسليم</label>
						  <div class="deliver_type_section">
						     <label class="active"><span > توصيل منزلي:  <span class="radio_btn"> <input type="radio" id="deliver_item" name="deliver_type" style="height:auto !important;display:none " value="deliver" checked></span>  </span></label>
						     <label> <span>عبر الانترنت:     <span class="radio_btn"><input type="radio" id="online" name="deliver_type" style="height:auto !important;display:none "  value="online"></span>   </span></label>
						     <label><span> استلام من المكتب:<span class="radio_btn"> <input type="radio" id="pick_up" name="deliver_type" style="height:auto !important;display:none" value="pick_up"></span> </span></label>
						   </div>
						</div>
						<div class="form-group select_country_deliver" >
						  <label for="city">اختر المحافظة</label>
						  <select class="form-control" name="city" id="city">
						    <option value="" disabled selected>اختر المحافظة</option>
							<?php $__currentLoopData = $country; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $countries): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <option value="<?php echo e($countries->country_id); ?>" shipping_cost="<?php echo e($countries->sale_shipping); ?>"> <?php echo e($countries->country); ?> </option>							
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						  </select>
                         </div>
                        <div class="form-group">
						  <label for="order_note"> ملاحظات الطلب (اختیاری)</label>
						  <textarea rows="3" name='order_note' id="order_note" class="form-control" placeholder="ادخل اللون المطلوب او الحجم المطلوب او ملاحظاتك هنا"></textarea>
						</div>
						<div class="form-group" style="display:none">
						  <label for="cobun_number"> Coupon number</label>
						  <input type="hidden" name="cobun_number" id="cobun_number" class="form-control" placeholder="787878">
						  <input type="hidden" name="is_valid_coupon" id="is_valid_coupon" value="0">
						  <span id="cobuns_result_message"></span>
						</div>
						  <input type="hidden" id="shipping_city_cost" name="shipping_cost" value="0">
						  <input type="hidden" id="reference_id" name="reference_id" value="<?php echo e($reference_id); ?>"> 
				  </div>
			   </div>
			   <div class="col-lg-6">
                            <label> سلة التسوق</label>
			     <div class="cart-items">
				    <?php $__currentLoopData = Cart::content(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<div class="item"id="<?php echo e($product->rowId); ?>">
					   <div class="row">
					      <div class="col-3" style="padding-left:0px;">
						     <img src="<?php echo e($product->options->has('image') ? $product->options->image : ''); ?>" >
						  </div>
						  <div class="col-9" style="/*padding: 0px 3px 0px 12px*/">
						    <div class="row" style='padding:7px;'>
							<div class="col-9" style="padding: 0px 3px;">
							  <h2 style="white-space:nowrap; overflow:hidden; text-overflow:ellipsis;"><a href="#changeCartItem" class="editProductName" data-toggle="modal" item_id="<?php echo e($product->rowId); ?>">edit</a> <?php echo e($product->name); ?></h2>
								   <?php 
									$allqty=DB::table('product_store')->where('product_id',$product->id)->get();
									 $allQuantity=0;
									 foreach($allqty as $totalCount){
										 $allQuantity=$allQuantity+$totalCount->qty; 
									 }
			                      ?>
							  </div>
							  <div class="col-3" style='text-align:left;padding: 0px 3px; '>
							  <h3 style="display:inline" class='removeItem' item_id="<?php echo e($product->rowId); ?>"><span class="fa fa-close"></span> ازالة</h3>
							  </div>
							</div>
							<div class="row" style="margin-top:0px">
							  <div class="col-5">
							      
							     <h4><span class='graytitle'>السعر</span>  &nbsp;&nbsp;&nbsp;<?php echo e(number_format($product->price,0,'.',',')); ?> </h4>
							  </div>
							  <div class="col-7">
							      <h4 style="text-align:left; margin-left:4px;margin-top:6px;"><span class='graytitle'>الکمیة</span>  &nbsp;&nbsp;
								  <button  type="button" class='plus' plus_item="<?php echo e($product->rowId); ?>"> + </button> <input type="number" class="productQTY <?php echo e($product->rowId); ?>" id="<?php echo e($product->rowId); ?>" value="<?php echo e($product->qty); ?>"  item_id="<?php echo e($product->rowId); ?>"  product_qty="<?php echo e($allQuantity); ?>" ><button class='minus' minus_item="<?php echo e($product->rowId); ?>" type="button"> - </button></h4>
							  </div>
							</div>
						  </div>
					   </div>
                    </div>					
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>					  
				</div>
				  <div style="padding-top:54px; font-size:22px;">
				    <span> * </span> للحصول على فاتورة عرض اسعار  <button type='submit' class="btn" value="sandp" name="print_save" style="background:transparent;border:none;font-size:23px;color: blue;float:left;margin-top: -10px;">ضغط هنا</button> 
			      </div>
			   </div>
			   
			</div>
		</div>
		<div class="cart-footer">
		 <div class="footer_actions">
		  <div class="row">
		    <div class="col-lg-2 col-md-2 col-6">الاجمالی &nbsp;&nbsp;&nbsp;<span class='sub-total'><?php  $subtotalCost= explode('.', Cart::subtotal()); echo $subtotalCost[0];if($subtotalCost[1]!='0'){echo '.'.$subtotalCost[1];} ?></span></div>
		    <div class="col-lg-3 col-md-3 col-6">کلفة الشحن &nbsp;&nbsp;&nbsp;<span class='shipping'>00</span></div>
		    <div class="col-lg-3 col-md-3 col-6">المبلغ الکلی &nbsp;&nbsp;&nbsp;<span class='total'></span><input type="hidden" id="total_cost" name="total_cost"></div>
		    <div class="col-lg-4 col-md-4 col-6">
                         <button type='submit' class="btn" style="float:left">ارسال الطلب</button>
                          
                   </div>
		  </div>
		  <?php echo Form::close();; ?> 
		  </div>
		</div>
		
	  </div>
	  <div class="overlay-f">
      </div>	  
<?php $zero_qty=DB::table('general_settings')->where('id','1')->get()[0]->zero_balance; ?>	


<div id="changeCartItem" class="modal fade " role="dialog">
  <div class="modal-dialog " style="width:458px; padding-top:140px ">
    <div class="modal-content" style="border-radius:0px;">
	 <div class="modal-header" style="padding:0px">
        <button type="button" class="close" data-dismiss="modal">&times; <span style="font-size:14px">اغلاق</span></button>
	 </div>
      <div class="modal-body" style="background:#fff; ">
	    <?php echo Form::open(['url' => 'fronted/changeCartItem', 'method' => 'get', 'class' => 'form-horizontal main_form form-whitout-modal','id'=>'add_room']); ?>

         <div class="row">    
		  <div class="form-group col-md-7">
		     <input type="text" name="product_name"  class="form-control product_name" placeholder="enter new product name">
             <input type="hidden" name="selectedrowId" id="selectedrowId">
		   </div> 	
           <div class="form-group col-md-5">
		     <input type="number" name="product_price"  class="product_cost" placeholder="enter new product price">
           </div> 
		   <div class="col-md-12 form-group">
		      <textarea class="form-control" name="description" placeholder=" Enter Description"></textarea>
		   </div>
		    <div class="col-12">
			  <input type="submit" class="form-control btn btn-primary">
			</div>
		 </div> 
     <?php echo Form::close(); ?>			 
	  </div>
    </div>
  </div>
</div>
	  
<style>
.editProductName{
	font-size:15px;
}	
#changeCartItem input{
	width: 100%;
    font-size: 14px;
    font-weight: normal;
    padding-right: 7px;
}
#changeCartItem input[type='text']{
	font-size:19px;
}
#changeCartItem input[type='submit']{
	background:blue;
}





input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    margin: 0; 
}
.cart-labels label{
	color:#999;
}
.deliver_type_section label{
	border: 1px solid #06C97A;
    border-radius: 24px;
    padding: 6px 17px;
	color:#06C97A;
}
.deliver_type_section label.active{
	background:#06C97A;
	color:#fff;
}
.deliver_type_section label.active span.radio_btn{
	border: 2px solid #fff;
	background:#fff;
}
.deliver_type_section label span.radio_btn{
	width: 13px;
    height: 13px;
    border: 2px solid #06C97A;
    float: left;
    display: inline-block;
    margin-top: 7px;
    margin-right: 7px;
    border-radius: 50%;
}
.deliver_type_section span{
	float:right;
}
.deliver_type_section{
	width:100%;
	
}
.overlay-f{
	width:100%;
	height:900px; 
	background:#efeded0f; 
	position:absolute; 
	top:0;
	display:none;
}

@media(max-width:425px){
  #changeCartItem .modal-dialog {width:91% !important;}	
  .cart-items  .item h2{font-size:14px;margin:0px}
   .cart-items  .item .col-9 .row{
      padding:3px !important;
    }	
  .fronted_body .cart-page .cart-items .item img{height:66px;}
  .cart-items .item .col-9 .col-6 h2, .fronted_body .cart-page .cart-items .item .removeItem{font-size:12px;}
  .fronted_body .cart-page .cart-items .item .col-9 .col-7 h4, .fronted_body .cart-page .cart-items .item .col-9 .col-5 h4{font-size:11px}
  .fronted_body .cart-page .cart-items .item button{font-size:16px;line-height: 1;} 
  .fronted_body .cart-page .cart-items .item input{width: 25px;font-size: 14px;}
  }
	</style>
	<script>
	  var zero_qty=<?php echo $zero_qty;?>;
      var APP_URL = <?php echo json_encode(url('/')); ?>

	 
	 
	 $(".editProductName").click(function(){
		 $("#selectedrowId").val($(this).attr('item_id'));
	 });
	 
	    var currency=localStorage.getItem("currency");
       if(currency=="ar"){
		   $('#city option').each(function(){
			   $(this).attr("shipping_cost",parseFloat($(this).attr("shipping_cost"))*1200);
		   })
		}
	
	 
	 
	  function addCommas(nStr) {
				nStr += '';
				var x = nStr.split('.');
				var x1 = x[0];
				var x2 = x.length > 1 ? '.' + x[1] : '';
				var rgx = /(\d+)(\d{3})/;
				while (rgx.test(x1)) {
					x1 = x1.replace(rgx, '$1' + ',' + '$2');
				}
				return x1 + x2;
			}
			
	  $(document).ready(function(){
		    calculateAll();
	    });
	 
	 function calculateAll(){
		 var subtotal=$(".sub-total").text();
           subtotal=subtotal.replace(/\,/g,'');
           subtotal=parseFloat(subtotal,10);
           var total=subtotal+parseFloat($('#shipping_city_cost').val());
		   
		   var savedCopun=0000;
		  if(localStorage.getItem('userCoupon') && localStorage.getItem('userCoupon') !=""){
			  var savedCopun=localStorage.getItem('userCoupon');
		  } 
		 $.ajax({
			  url:APP_URL+'/fronted/calculate_coupon/'+savedCopun,
			  type:'get',
			  success:function(response){
				// $(".total").text(addCommas(total-parseInt(response)));
		        // $("#total_cost").val(total-parseInt(response)); 
				
				$(".total").text(addCommas(total));
		        $("#total_cost").val(total); 
				if(response !=0 ){
					$("#is_valid_coupon").val("1");
					$("#cobun_number").val(savedCopun);
				}
			  },
			  error:function(){
				   
			  }
		  });
		  
	 }
	
			
			 
			 
	$("#deliver_item").click(function(){
		if($(this).is(":checked")==true){
		   $(".deliver_type_section label").removeClass("active");	
		   $(this).parents('label').addClass("active");	
		  $(".select_country_deliver").css("display",'block');	
		  $("#online").prop("checked",false);
		  $("#pick_up").prop("checked",false);
		  $(".deliver_type_section").css('border','none');
		}
		else{
			$(".select_country_deliver").css("display",'none');
		}
	});
 	
	
  $("#online").click(function(){
	  if($(this).is(":checked")==true){
		  $(".deliver_type_section label").removeClass("active");	
		  $(this).parents('label').addClass("active");	
		   
		 $(".select_country_deliver").css("display",'none');	
		  $("#deliver_item").prop("checked",false);
		  $(".shipping").text("00");
		  $("#shipping_city_cost").val("0");
		  //$(".total").text($(".sub-total").text());
		  calculateAll();
		  $("#pick_up").prop("checked",false); 
         $("#city").val($("#city option:first").val());	
         $(".deliver_type_section").css('border','none');		 
	  }
  });	
  
  $("#pick_up").click(function(){
	  if($(this).is(":checked")==true){
		 $(".deliver_type_section label").removeClass("active");	
		  $(this).parents('label').addClass("active");
		  
		 $(".select_country_deliver").css("display",'none');	
		  $("#deliver_item").prop("checked",false);
		  $("#online").prop("checked",false);
          $(".shipping").text("00");
		  $("#shipping_city_cost").val("0");		  
		   calculateAll();
		  //$(".total").text($(".sub-total").text());
          $("#city").val($("#city option:first").val());		  
		  $(".deliver_type_section").css('border','none'); 
	  }
  });	
  
	
	   $(".productQTY").change(function(){
		  var item_id=$(this).attr('item_id');
		  var newQty=$(this).val();
		  var shipping_costs=$("#shipping_city_cost").val();

		  if(parseInt($(this).attr('product_qty'))< parseInt(newQty) /* && zero_qty==0 */){
				
                  $('#confirmModal').on('show.bs.modal', function (e) {
				  var button = e.relatedTarget;
				  if($(button).hasClass('no-modal')) {
					e.stopPropagation();
				  }  
				});				
			   $("#product_not_available").modal('show');
                           $(".available_product_qty").text($(this).attr('product_qty'));
			   $(this).val(0);
		   } 
      else{
		  $.ajax({
			  url:APP_URL+"/changeQty/"+item_id+"/"+newQty,
			  type:'get',
			  success:function(response){
				$(".total-cart-item").text(response.split('-')[0]);
				 $(".sub-total").text(response.split('-')[1]);
				 //var subtotals=response.split('-')[1];
				 //   subtotals=subtotals.replace(/\,/g,'');
                 //   subtotals=parseInt(subtotals,10); 
				 //$(".total").text(addCommas(subtotals+parseInt(shipping_costs)));
				 calculateAll();
				 //alert(response);
			  },
			  error:function(){
				  
			  }
		   });
	      }
	   });
	   
	   $("#city").change(function(){
     		   
		  var shippingCost=$("#city option:selected").attr('shipping_cost');
          
		  
		  
		  $(".shipping").text(addCommas(shippingCost));
          var subtotal=$(".sub-total").text();
		     
           subtotal=subtotal.replace(/\,/g,'');
           subtotal=parseFloat(subtotal);
		   
		   $("#shipping_city_cost").val(parseFloat(shippingCost));
		   
           calculateAll();	   
	   });
	
	 
	
	  $("#sendRequestForm").submit(function(){
		 var name=$("#firstname").val(); 
		 var phone=$("#phone").val(); 
		 var city=$("#city").val();

                if(name ==""  ||  phone=="" || (city=="" && $("#deliver_item").is(":checked")==true)){
                    $("#sendRequestForm input[type='text'],#sendRequestForm select").filter(function(){return this.value==''}).css('border','1px solid red');
			        return false; 		
		          }
				if($("#pick_up").is(":checked")==false && $("#online").is(":checked")==false && $("#deliver_item").is(":checked")==false) {
					$(".deliver_type_section").css('border','1px solid red');
					 
					return false;
				} 
                 
            if(phone.length<10){
			$('#phone').css('border','1px solid red');
			$(".valid_phone").css('display','inline'); 
			return false; 
		   }
		
        if($(".cart-items .item").length<=0){
			return false; 
		};			
	  });
	  
	   $("#sendRequestForm input, #sendRequestForm select").focus(function(){
	       $(this).css('border','1px solid #dce1e4 ');
              $(".valid_phone").css('display','none');
       });
 
		 $("#sendRequestForm input").blur(function (){
			if($(this).val()==""){
				$(this).css("border","1px solid red ");
			} 
		 });
	  	 
			 
	 	  $(".removeItem").click(function(){
		  var item_id=$(this).attr('item_id');
                  var shipping_costs=$("#shipping_city_cost").val();
		  $.ajax({
			  url:APP_URL+"/removeItem/"+item_id,
			  type:'get',
			  success:function(response){
				    $(".total-cart-item").text(response.split('-')[0]);
				    $("div#"+item_id).remove();
				   $(".sub-total").text(response.split('-')[1]);
				 //var subtotals=response.split('-')[1];
				 //subtotals=subtotals.replace(/\,/g,'');
                  //subtotals=parseInt(subtotals,10);
				 //$(".total").text(addCommas(subtotals+parseInt(shipping_costs)));
				calculateAll();
			  },
			  error:function(){
				  alert('not');
			  }
		  });
	  });
	  
  $(".plus").click(function(){
		 var itemId=$(this).attr('plus_item');
         var exitQty=parseFloat($("input."+itemId).val());
		 
		  exitQty=exitQty+1;
         var shipping_costs=$("#shipping_city_cost").val();		 

		  if(parseInt($("input."+itemId).attr('product_qty'))<parseInt(exitQty) /* && zero_qty==0  */ ){
				
               $('#confirmModal').on('show.bs.modal', function (e) {
				  var button = e.relatedTarget;
				  if($(button).hasClass('no-modal')) {
					e.stopPropagation();
				  }  
				});				
			   $("#product_not_available").modal('show');
               $(".available_product_qty").text($("input."+itemId).attr('product_qty'));
			   $(this).val(0);
		   } 
      else{
        $("input."+itemId).val(exitQty);
         $.ajax({
			  url:APP_URL+"/increaseItem/"+itemId,
			  type:'get',
			  success:function(response){
				  //$("input."+itemId).val(exitQty);
				   $(".total-cart-item").text(response.split('-')[0]);
				 $(".sub-total").text(response.split('-')[1]);
				 //var subtotals=response.split('-')[1];
				 //subtotals=subtotals.replace(/\,/g,'');
                  //subtotals=parseInt(subtotals,10);
				 //$(".total").text(addCommas(subtotals+parseInt(shipping_costs)));
				calculateAll();
			  },
			  error:function(){
				 
			  }
		  });
	  } 
	  });
	  
	  $(".minus").click(function(){
		var itemId=$(this).attr('minus_item');
         var exitQty=parseFloat($("input."+itemId).val());
		 exitQty=exitQty-1;
                var shipping_costs=$("#shipping_city_cost").val();
		 $("input."+itemId).val(exitQty); 
         $.ajax({
			  url:APP_URL+"/decreaseItem/"+itemId,
			  type:'get',
			  success:function(response){
				   //$("input."+itemId).val(exitQty);
                                if(exitQty==0){
					  $("div#"+itemId).remove();
				  }
				 $(".total-cart-item").text(response.split('-')[0]);
                                
				 $(".sub-total").text(response.split('-')[1]);
				 //var subtotals=response.split('-')[1];
				 //     subtotals=subtotals.replace(/\,/g,'');
                 //     subtotals=parseInt(subtotals,10);
					 
				 //$(".total").text(addCommas(subtotals+parseInt(shipping_costs)));
				calculateAll();
			  },
			  error:function(){
				 
			  }
		  });
	  });
	  
	  
	  
	
	</script>
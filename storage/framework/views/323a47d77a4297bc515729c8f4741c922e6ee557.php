 <?php echo Form::open(['url' => 'sendRequest', 'method' => 'post', 'id'=> 'sendRequestForm', 'class' => 'form-horizontal main_form form-whitout-modal']); ?>  

<div class="card">
	    <div class="card-header">
		  <h3>استکمال الطلب</h3>
		</div>
		<div class="card-body">
		    <div class="row">
			   <div class="col-lg-6">
			      <?php if(session()->has('message')): ?>
				     <div class="alert alert-success alert-dismissable">
					  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					  <strong><?php echo e(session()->get('message')); ?></strong> 
					</div>
                  <?php endif; ?>  			  
			      <div class="form">
					    <div class="form-group">
						  <label for="firstname">اسمک</label>
						  <input type="text" name="firstname" placeholder="ادخل اسمک الکامل هنا" id="firstname" class="form-control">
						</div>
						<div class="form-group">
						  <label for="phone">رقم الهاتف</label>
						  <input type="text" name="phone" id="phone" class="form-control" placeholder="مثل: 07701234123">
						</div>
						<div class="form-group">
						  <label for="city">اختر المحافظة</label>
						  <select class="form-control" name="city" id="city">
						    <option value="بغداد">بغداد</option>
						    <option value="کربلا">کربلا</option>
						    <option value="اربیل">اربیل</option>
						    <option value="دهوک">دهوک</option>
						    <option value="قادسیه">قادسیه</option>
						    <option value="نجف">نجف</option>
						  </select>
						</div>
				  </div>
			   </div>
			   <div class="col-lg-6">
			     <div class="cart-items">
				    <?php $__currentLoopData = Cart::content(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<div class="item"id="<?php echo e($product->rowId); ?>">
					   <div class="row">
					      <div class="col-3" style="padding-left:0px;">
						     <img src="<?php echo e(asset('public/images/product')); ?>/<?php echo e($product->options->has('image') ? $product->options->image : ''); ?>" >
						  </div>
						  <div class="col-9">
						    <div class="row" style='padding:7px;'>
							  <div class="col-6">
							      <h2> <?php echo e($product->name); ?></h2>
							  </div>
							  <div class="col-6" style='text-align:left;'>
							  <h3 class='removeItem' item_id="<?php echo e($product->rowId); ?>"><span class="fa fa-close"></span> ازالة</h3>
							  </div>
							</div>
							<div class="row" style="margin-top:7px">
							  <div class="col-5">
							     <h4><span class='graytitle'>السعر</span>  &nbsp;&nbsp;&nbsp;<?php echo e($product->price); ?> </h4>
							  </div>
							  <div class="col-7">
							      <h4><span class='graytitle'>الکمیة</span>  &nbsp;&nbsp;
								  <button  type="button" class='plus' plus_item="<?php echo e($product->rowId); ?>"> + </button> <input type="text" class="<?php echo e($product->rowId); ?>" value="<?php echo e($product->qty); ?>" ><button class='minus' minus_item="<?php echo e($product->rowId); ?>" type="button"> - </button></h4>
							  </div>
							</div>
						  </div>
					   </div>
                    </div>					
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>				
				</div>
			   </div>
			</div>
		</div>
		<div class="cart-footer">
		 <div class="footer_actions">
		  <div class="row">
		    <div class="col-lg-3 col-md-3 col-6">الاجمالی &nbsp;&nbsp;&nbsp;<span class='sub-total'><?php echo e(Cart::subtotal()); ?></span></div>
		    <div class="col-lg-3 col-md-3 col-6">کلفة الشحن &nbsp;&nbsp;&nbsp;<span class='shipping'>300,00</span></div>
		    <div class="col-lg-3 col-md-3 col-6">المبلغ الکلی &nbsp;&nbsp;&nbsp;<span class='total'></span><input type="hidden" id="total_cost" name="total_cost"></div>
		    <div class="col-lg-3 col-md-3 col-6"><button type='submit' class="btn">ارسال الطلب</button></div>
		  </div>
		  <?php echo Form::close();; ?> 
		  </div>
		</div>
		
	  </div>
	
	<script>
	var APP_URL = <?php echo json_encode(url('/')); ?>

	
	
	  $("#sendRequestForm").submit(function(){
		 var name=$("#firstname").val(); 
		 var phone=$("#phone").val(); 
		 var city=$("#city").val();

         if(name ==""  ||  phone=="" || city==""){
            $("#sendRequestForm input[type='text']").filter(function(){return this.value==''}).css('border','1px solid red');
			 return false; 		
		}		 
	  });
	  
	   $("#sendRequestForm input,select").focus(function(){
	       $(this).css('border','1px solid #dce1e4 ');
       });
 
		 $("#sendRequestForm input").blur(function (){
			if($(this).val()==""){
				$(this).css("border","1px solid red ");
			} 
		 });
	  
	  
	     var subtotal=$(".sub-total").text();
		     
           subtotal=subtotal.replace(/\,/g,'');
           subtotal=parseInt(subtotal,10);
           var total=subtotal+300;
			
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
			
			 $(".total").text(addCommas(total));
			 $("#total_cost").val(addCommas(total));
			 
			 
	 	  $(".removeItem").click(function(){
		  var item_id=$(this).attr('item_id');
		  $.ajax({
			  url:APP_URL+"/removeItem/"+item_id,
			  type:'get',
			  success:function(response){
				 $(".cart-page").load(APP_URL+'/cart_items'); 
				 $(".total-cart-item").text(response);
			  },
			  error:function(){
				  alert('not');
			  }
		  });
	  });
	  
	  $(".plus").click(function(){
		 var itemId=$(this).attr('plus_item');
         var exitQty=parseInt($("input."+itemId).val());
		 exitQty=exitQty+1;
		 
         $.ajax({
			  url:APP_URL+"/increaseItem/"+itemId,
			  type:'get',
			  success:function(response){
				 //$("input."+itemId).val(exitQty);
				  $(".cart-page").load(APP_URL+'/cart_items'); 
				 $(".total-cart-item").text(response);
			  },
			  error:function(){
				 
			  }
		  });
		  
	  });
	  
	  $(".minus").click(function(){
		var itemId=$(this).attr('minus_item');
          var exitQty=parseInt($("input."+itemId).val());
		 exitQty=exitQty-1;
		 
         $.ajax({
			  url:APP_URL+"/decreaseItem/"+itemId,
			  type:'get',
			  success:function(response){
				 //$("input."+itemId).val(exitQty);
				  $(".cart-page").load(APP_URL+'/cart_items'); 
				 $(".total-cart-item").text(response);
			  },
			  error:function(){
				 
			  }
		  });
	  });
	  
	  
	  
	
	</script>
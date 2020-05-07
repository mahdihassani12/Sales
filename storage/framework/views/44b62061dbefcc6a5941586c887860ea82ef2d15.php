 <?php $__env->startSection('content'); ?>
 <style>
    .category_active{
		background:#504f4e !important; 
	}
 </style>
 <?php $discount="<script> document.write( parseInt(localStorage.getItem('userCouponValue')));</script>";?>
   <div class="fronted-content">
       <?php $mobileLogo=DB::table('site_setting')->where('id','1')->get()[0];?>
   
	
    <h2 style="text-align:center; margin-bottom:20px;">اختر فئة</h2>
	<ul class="category-list" style='text-align:center;'>
	  <li category_id="all" class="category_item category_active">كل المنتجات</li>
      <?php $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categories): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	    <li category_id="<?php echo e($categories->id); ?>" class="category_item"><?php echo e($categories->name); ?></li>
	  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul> 
	
	
		  
	<div class="form-group mobile-cartegory-list">
	 <select class="form-control mobile-cartegory">
             <option value="all">كل المنتجات</option>
	    <?php $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categories): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	    <option value="<?php echo e($categories->id); ?>" ><?php echo e($categories->name); ?></option>
	   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
	 </select>
	</div>

  


	<div class="fonted_products">
	 <div class="row">
	  <h3 style="margin-bottom:10px;" class="col-md-9"> كل المنتجات  <span style="float:left; font-size:20px; color:#d0d0d0;"> عدد المنتجات  &nbsp;&nbsp;&nbsp;<?php echo e($productQTY); ?><span></h3>
	 
	<div class="sort_product_part col-md-3">	
	<label class="sort_by" >ترتيب بواسطة</label>
	<select name="sortBy" class="sortBy">
	    <option value="date" type="des"> الافتراضي </option>
	    <option value="date" type="asc"> التاريخ - تصاعدي </option>
	    <option value="date" type="des">التاريخ - تنازلي</option>
	    <option value="price" type="asc" >السعر - تصاعدي</option>
	    <option value="price" type="des">السعر - تنازلي</option>
	</select>
   </div>
 </div>	 
	 <div class="category-result">
	  
	  <div class="row" id="load_more_item_section">
            <?php $getProduct_id=0;?>
	   <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	     <div class="column5" product_id="<?php echo e($product->id); ?>" data-toggle="" data-target="#productModal">
	      <div class="single_product">
		    <div class="product-image">
			  <?php if($product->product_link!=null): ?> <span class="fa fa-youtube product_link" product_link="<?php echo e($product->product_link); ?>" data-toggle="modal" data-target="#product_video"></span><?php endif; ?>
			   <img src="<?php if($product->external_link==1): ?> <?php echo e($product->image); ?> <?php else: ?> <?php echo e(asset('public/images/product')); ?>/<?php echo e($product->image); ?> <?php endif; ?>" class="img-responsive">
			     <p class="main_price" style="color:#858585;margin:0px;font-weight:bold;font-size:22px;position:absolute;bottom:-9px;left:10px;z-index:3; display:none"><del><?php if(strpos($product->price,'.')===false): ?> <?php echo e(number_format($product->price,0,'.',',')); ?> <?php else: ?><?php echo e(rtrim(number_format($product->price,2,'.',','),".0")); ?> <?php endif; ?> </del></p> 
			     <h3 class="product-price" category="<?php echo e($product->category_id); ?>" real_price="<?php echo e($product->price); ?>"><?php if(strpos($product->price,'.')===false): ?> <?php echo e(number_format($product->price,0,'.',',')); ?> <?php else: ?><?php echo e(rtrim(number_format($product->price,2,'.',','),".0")); ?> <?php endif; ?> $</h3>
				 <h4><?php if(strpos($product->price,'.')===false): ?> <?php echo e(number_format($product->price,0,'.',',')); ?> <?php else: ?><?php echo e(rtrim(number_format($product->price,2,'.',','),".0")); ?> <?php endif; ?></h4> 
				 <p class="discount_amount" style="color:#107b10;margin:0px;font-weight:bold;font-size:19px;position:absolute;bottom:-9px;right:10px;z-index:3;display:none">0</p> 

            </div> 		
            <div class="product-request"> 
			   <?php 
                                $getProduct_id=$product->id; 
					
			        $allqty=DB::table('product_store')->where('product_id',$product->id)->get();
					 $allQuantity=0;
					 foreach($allqty as $totalCount){
						 $allQuantity=$allQuantity+$totalCount->qty; 
					 }
			   ?>
			   <button class="btn add_to_cart" product_id="<?php echo e($product->id); ?>"  product_qty="<?php echo e($allQuantity); ?>">اطلب الان</button> 			
			   <p style="display:none" class="english_name"><?php echo e($product->name); ?></p>
			   <p style="display:none" class="arabic_name"><?php echo e($product->arabic_name); ?></p>
			</div>
		  </div> 
		 </div> 
	   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               <div id="remove_div" class="col-12" style="margin-top:20px; text-align:center;">
		           <button name="btn_more" id="btn_more" data-pro="<?php echo e($getProduct_id); ?>"  class="load_more_item_btn" start_number="<?php echo e($startFrom); ?>">مشاهدة المزيد</button>
	            </div>
	   </div>
	  </div>
	</div>
   </div>
   
 <div id="productModal" class="modal fade product-details" role="dialog" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times; <span style="font-size:14px">اغلاق</span></button>
      </div>
      
         <div class="details_content">
          <div class="modal-body">
                   <p style="text-align:center;"><img style="width:45px;"src="<?php echo e(asset('public/images/icons/loader.gif')); ?>"></p>

          </div>
          <div class="modal-footer">
         </div>
        </div> 
    </div>
  </div>
</div>


 <div id="confirmModal" class="modal fade " role="dialog"  >
  <div class="modal-dialog " style="width:458px; padding-top:140px ">
    <div class="modal-content" style="border-radius:0px;">
      <div class="modal-body" style="background:#fff;padding:0px; ">
          <div style='padding:16px 40px;'>
		      <p style="font-weight:700;color:#cdcdcd; font-size:22px;color:#b5b4b4; text-align:center;">تمت اضافة المنتج لسلة التسوق بنجاح </p>
		     <div style="text-align:center">
		        <img src="<?php echo e(asset('public/images/icons/added-to-cart2.gif')); ?>">
		     </div>  
		     <p style="text-align:center; font-size:22px; font-weight:700;margin-top:22px">هل تريد إستكمال شراء المنتج ؟</p>
		  </div>
		  <hr>
		 <div class="row" style="padding: 0px 23px 16px;">		 
		  <div class="col-6"> 
		   <a href="<?php echo e(asset('/cart')); ?>/<?php echo e($reference_id); ?>" class="btn btn-accept btn-block" style="background: rgba(42,187,129,1);background: -moz-linear-gradient(45deg, rgba(42,187,129,1) 0%, rgba(0,155,194,1) 100%);background: -webkit-gradient(left bottom, right top, color-stop(0%, rgba(42,187,129,1)), color-stop(100%, rgba(0,155,194,1)));background: -webkit-linear-gradient(45deg, rgba(42,187,129,1) 0%, rgba(0,155,194,1) 100%);background: -o-linear-gradient(45deg, rgba(42,187,129,1) 0%, rgba(0,155,194,1) 100%);background: -ms-linear-gradient(45deg, rgba(42,187,129,1) 0%, rgba(0,155,194,1) 100%);background: linear-gradient(45deg, rgba(42,187,129,1) 0%, rgba(0,155,194,1) 100%);filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#2abb81', endColorstr='#009bc2', GradientType=1 ); color:#fff; padding:12px; border-radius:40px; ">نعم</a>
          </div>
          <div class="col-6">		 
		    <a href="#" class="btn btn-reject btn-block" style="background:#d03d69; color:#fff; padding:12px; border-radius:40px; "  data-dismiss="modal">لا، تسوق المزيد</a>
          </div> 
		 </div> 
	  </div>
      
    </div>
  </div>
</div>

 <div id="product_video" class="modal fade " role="dialog" >
  <div class="modal-dialog " style="width:600px; padding-top:80px ">
    <div class="modal-content" style="border-radius:0px;">
	  <div class="modal-header" style="padding:0px">
	       <button type="button" class="close" data-dismiss="modal">&times; <span style="font-size:14px">اغلاق</span></button>
	  </div>
      <div class="modal-body" style="background:#fff;padding:0px; ">
          <iframe width="100%" height="315" src="" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	     
	  </div>
    </div>
  </div>
</div>


<div id="product_not_available" class="modal fade " role="dialog" >
  <div class="modal-dialog " style="width:300px; padding-top:80px ">
    <div class="modal-content" style="border-radius:0px;padding:20px;">
      <div class="modal-body" style="background:#fff;padding:0px; ">
	    <button type="button" class="close" data-dismiss="modal" style="float:inherit">&times; <span style="font-size:14px">اغلاق</span></button> 
        <div style="text-align:center;">
		   <h1 style="margin:20px 0px;">لطلب هذا المنتج الرجاء الاتصال على </h1>
		    <h2>07722284333</h2>
        </div>		
	 </div>
    </div>
  </div>
</div>

  <div class="css_preloader" style='display:none'>
    <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
</div>


<div id="insert_coupon_number_modal" class="modal fade " role="dialog" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
	    <div class="row">
		    <div class="col-sm-8 modal_text">
			   <div class="header_circles"> 
				<div class="row">
				  <div class="sperator"></div>
				   <div class="col-sm-4">
				        <span class="circle noselect">
						    1
						</span>
						<img src="<?php echo e(asset('public/images/icons/customer.svg')); ?>">
				   </div>
				   <div class="col-sm-4">
				        <span class="circle noselect">
						    2
						</span>
						 <img src="<?php echo e(asset('public/images/icons/voucher.svg')); ?>" style="margin-top:30px;">
				   </div>
				   <div class="col-sm-4">
				        <span class="circle noselect">
						    3
						</span>
						<img src="<?php echo e(asset('public/images/icons/tax.svg')); ?>">
				   </div>
				</div>
			   </div>
			   
			   <div class="icons_lables">
				<div class="row">
				  <div class="col-sm-4">
				    <label class="noselect">هل انت زبون مميز ؟</label>
				  </div>
				   <div class="col-sm-4">
				    <label class="noselect">اكتب رمز الخصم</label>
				  </div>
				   <div class="col-sm-4">
				    <label class="noselect">احصل على خصومات</label>
				  </div>
				</div>
			   </div>	
			   <div class="desciption">
				<div class="row">
				   <p class="col-12 noselect">
                     تقدم عراق سوفت خدمة الخصومات لزبائنها المميزين من خلال إعطاء رموز خصومات خاصة لاضافة خصومات حصرية على المنتجات المتوفرة في الموقع
                   </p>					 
				</div>
			   </div>
               <div class="couponNumber">			   
				<div class="row">
				  <div class="col-sm-12">
				      <h3 class="noselect">ادخل رمز الخصم هنا</h3>
					  <input type="number" class="form-control inserted_counpon_number_feild">
				  </div>
				  <div class="col-6 submit_coupon">
				    <button class="btn submit_coupon_number_btn noselect">تطبيق رمز الخصم</button>
				  </div>
				  <div class="col-6 exit_modal_lable">
				    <a href="#" class="close noselect" data-dismiss="modal"><span class="fa fa-close"></span>  ليس لدي رمز , تخطي </a>
				  </div>
				</div>
			   </div>
			</div> 
			<div class="col-sm-4 modal_image">
			  <img src="<?php echo e(asset('public/images/icons/modal_image.jpg')); ?>">
			</div>
                  </div>
                <div class="row">
	      <div class="col-12">
		     <div class="prevent_section">
			    <a href="#" class="prevent_coupon_modal"> لا تظهر هذه الرسالة مرة اخرى <span class="fa fa-close"></span></a>
			 </div>
		  </div>
             </div>      
		
	 </div>
    </div>
  </div>
</div>



<?php $zero_qty=DB::table('general_settings')->where('id','1')->get()[0]->zero_balance; ?>
 <?php $__env->stopSection(); ?>
 
 <style>
   .noselect {
  -webkit-touch-callout: none; /* iOS Safari */
    -webkit-user-select: none; /* Safari */
     -khtml-user-select: none; /* Konqueror HTML */
       -moz-user-select: none; /* Firefox */
        -ms-user-select: none; /* Internet Explorer/Edge */
        user-select: none; /* Non-prefixed version, currently
                                  supported by Chrome and Opera */
}  

.prevent_section{
	text-align: center;
    width: 88%;
    font-weight: bold;
    margin: auto;
    border-top: 2px dashed #e9e9e9;
    padding: 11px;
}
.prevent_section .prevent_coupon_modal{
	color:red;
}
   .single_product .product_link {
	  position: absolute;
	  left: 9px;
    color: white;
    font-size: 24px;
    padding-top: 10px;
    top: 0px;
    background-color: #ff1616;
    width: 30px;
    height: 40px;
    text-align: center;
    border-radius: 0px 0px 5px 5px;
  }
  #insert_coupon_number_modal  .modal-content{
	  border-radius:0px;
  }
   #insert_coupon_number_modal  .modal-body{
	   padding:0px;
   } 
   #insert_coupon_number_modal .modal_text{
	 padding: 26px 64px 11px 31px;
   }
   #insert_coupon_number_modal .header_circles{
	   text-align:center;
   }
   #insert_coupon_number_modal .header_circles .circle{
	font-size: 27px;
    width: 53px;
    height: 53px;
    background: #F8F8F8;
    border-radius: 50%;
    color: #CECECE;
    font-weight:bold;
    line-height: 1.9;	
   }
   #insert_coupon_number_modal .sperator{
	  width: 61%;
      height: 2px;
      border: 1px dashed #cecece;
      position: absolute;
      top: 55px;
      left: 78px;
   }
   #insert_coupon_number_modal .header_circles img{
	   display: block;
		margin: 19px auto 7px;
		
   }
   #insert_coupon_number_modal .icons_lables label{
	    font-size: 15px;
        font-weight: bold;
        color: #A2A2A2;
   }
   #insert_coupon_number_modal .icons_lables{
	   border-bottom: 2px solid #F8F8F8;
       padding-bottom: 15px;
   }
   #insert_coupon_number_modal .modal_image{
	   padding-right:0px;
   }
   #insert_coupon_number_modal .modal_image img{
	   width:100%;
	   
   }
   #insert_coupon_number_modal .desciption{
	font-size: 14px;
    padding: 13px 0px;
    color: #A2A2A2;
    font-weight: 600;
	border-bottom: 2px solid #F8F8F8;
   }
   #insert_coupon_number_modal .desciption p{
	   margin:0px;
   }
   #insert_coupon_number_modal .couponNumber h3{
	       text-align: center;
			font-size: 18px;
			font-weight: bold;
			padding-top: 15px;
			padding-bottom: 8px;
			color: #2A2A2A;
   }
   #insert_coupon_number_modal .couponNumber input{
	   color:#686868;
	   background:#E9E9E9;
	   text-align: center;
       font-weight: bold;
   }
   #insert_coupon_number_modal .couponNumber .submit_coupon_number_btn{
	     background: linear-gradient(to right,#039DBC,#24B689);
		color: #fff;
		box-shadow: 0px 7px 6px #e2e2e2;
		margin-top: 12px;
   }
   #insert_coupon_number_modal .couponNumber .exit_modal_lable{
	    padding-top: 15px;
        text-align: left;
   }
   #insert_coupon_number_modal .couponNumber .exit_modal_lable a{
	   font-size: 13px;
       color: #0F0F0F;
	   float: left;
   }
   @media(max-width:575px){ 
     #product_video .modal-dialog ,#confirmModal .modal-dialog {
       width:95% !important;
        padding-top:30px !important;
     }
	 #insert_coupon_number_modal .header_circles .col-sm-4,#insert_coupon_number_modal .icons_lables .col-sm-4{
		 width:33%;
	 }
	 #insert_coupon_number_modal .sperator{
		   width: 72%;
          top: 44px;
          left: 48px;
	 }
	 #insert_coupon_number_modal .header_circles .circle{
		 width:40px;
		 height:40px;
		 font-size:21px;
	 }
	 #insert_coupon_number_modal .header_circles img{
		 width:68%;
	 }
	 #insert_coupon_number_modal .icons_lables label{
		 font-weight:normal;
		 font-size:13px;
		 text-align:center;
	 }
	 #insert_coupon_number_modal .desciption p{
		 font-size:14px !important;
	 }
	 #insert_coupon_number_modal .couponNumber .exit_modal_lable a{
		     margin-top: 10px;
			 font-size: 11px;
	 }
	 #insert_coupon_number_modal .modal_text{
		 padding: 26px 30px;
	 }
     #insert_coupon_number_modal .modal_image{
		 padding-right:15px;
	 }
  }
 </style>
 
 <?php $__env->startSection('scripts'); ?>;
 <script>
 var couponNumber=localStorage.getItem('userCoupon');

 $(".prevent_coupon_modal").click(function(){
	localStorage.setItem("show_coupon_modal", '0'); 
	$("#insert_coupon_number_modal").modal('hide');
 })


 $(document).on("change",".sortBy", function(){
	 var sortby=$(".sort_product_part .sortBy").val();
	 var sorttype=$('option:selected', this).attr('type');
	 var category=$("#btn_more_cate").attr("data-cate");
	  $('.fonted_products').css('display','none');
	  $('.css_preloader').css('display','block');
	 $.ajax({
		 url:APP_URL+'/fronted/sortProduct?sort_by='+sortby+'&sort_type='+sorttype+'&category='+category,
		 type:'get',
		 success:function(response){
		   $('.fonted_products').css('display','block');
		   $('.css_preloader').css('display','none');
           $(".fonted_products #load_more_item_section").html(response);    		   
		 },
		error:function(){
			
		} 
		 
	 });
 });
 
 


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
	 var pr_name=localStorage.getItem("product_name");
	 
	   if(pr_name=="ar"){
		  $('.arabic_name').css('display','block'); 
	   }
	   else{
		  $('.english_name').css('display','block'); 
	   }
	   
	   
	   
	   

	  var st=localStorage.getItem("userCouponValue");
	  
	 var productlength=$(".product-price").length;
	 var currency=localStorage.getItem("currency");
	 
	 if(currency=="ar" && (st!=null || st!=0 || st!='null' || st!='')){
		   $( '.product-price' ).each(function(){
           var actual = $(this).attr('real_price');
		   //actual=actual.replace(/\,/g,'');
           actual=parseFloat(actual); 
		   
		  for (var i=0; i<productlength; i++){
			 
            $(this).text( addCommas(parseFloat( actual*1200 )) +' د . ع');
            $(this).next().text( addCommas(parseFloat( actual*1200 )));
            //$(this).next().next().text(seperated_value[i]+'%');
			
		   }	
          }); 
	   }
	   
	   
        if(st==null || st==0 || st=='null' || st==''){
           st=0;
           $(".discount_amount").css('display','none');		
           $(".main_price").css('display','none');
	    if(localStorage.getItem("show_coupon_modal")!='0'){	   
              setTimeout(function() {$('#insert_coupon_number_modal').modal('show');}, 4000); 
            }  		   
          }
      else{
	$(".discount_amount").css('display','block');		
        $(".main_price").css('display','block');
	  
	 var categories=localStorage.getItem('CouponNumberCategories');
	 
	 var seperated_cat=categories.split('-');
	 var seperated_value=st.split('-');
	 var lg=seperated_cat.length;
 
	   $( '.product-price' ).each(function(){
        var actual = $(this).attr('real_price');
		   //actual=actual.replace(/\,/g,'');
           actual=parseFloat(actual); 
		   //alert($(this).attr('category'));
		  for (var i=0; i<lg; i++){
			if( parseInt($(this).attr('category')) ==seperated_cat[i]){  
			   if(currency=='ar'){
				 $(this).text( addCommas(parseInt( (actual - actual*seperated_value[i]/100)*1200 )) +' د . ع');
                 $(this).next().text( addCommas(parseInt( (actual - actual*seperated_value[i]/100)*1200 )));
                 $(this).prev().text(addCommas(actual*1200)).css('text-decoration','line-through');
				 $(this).next().next().text(seperated_value[i]+'%');   
			   }
			   else{
                 $(this).text( addCommas(parseFloat(actual - actual*seperated_value[i]/100)) +' $');
                 $(this).next().text( addCommas(parseFloat(actual - actual*seperated_value[i]/100)));
                 $(this).next().next().text(seperated_value[i]+'%');
			   }
			}
		}	
    }); 
    }

	
	   
 });
 
  $(".submit_coupon_number_btn").click(function(){
		 var cp=$(".inserted_counpon_number_feild").val();
		 if(cp !=0 && cp !=""){
		 $.ajax({
			 url:APP_URL+'/fronted/check_coupon/'+cp,
			 type:'get',
			 success:function(response){
				if(response=="ended_nubmer_of_use"){ 
				  alert('the number of use is finished!');
				  localStorage.setItem("userCoupon", '');
				}
				else if(response=="expire_date"){
				   alert('the date is expired!');
				  localStorage.setItem("userCoupon", '');	
				}
				else if(response=="not_valid"){
					alert('بروموكود غير فعال');
					localStorage.setItem("userCoupon", '');
				}
				else{
					
					localStorage.setItem("userCoupon", response.split('&&')[0]);
					localStorage.setItem("userCouponValue", response.split('&&')[1]);
					localStorage.setItem("CouponNumberCategories", response.split('&&')[2]);
					$(".coupon_check_result").text(' تم ادخال البروموكود بنجاح');
					setTimeout(function(){location.reload();},1000);
				}
			 },
			 error:function(){
				 
			 }
		 })
		 }
	 })
	 
    $(".add_to_cart").click(function(){
       setTimeout(function() {$('#confirmModal').modal('hide');}, 7000);
    });	
	
   var APP_URL = <?php echo json_encode(url('/')); ?>


    var zero_qty=<?php echo $zero_qty;?>;
    

 $(document).ready(function () {
	var $button = $('.load_more_item_btn');

	$button.on('click', function () {
		var $this = $(this);
		if ($this.hasClass('active') || $this.hasClass('success')) {
			return false;
		}
		$this.addClass('active');
		setTimeout(function () {
			$this.addClass('loader');
		}, 125);
		setTimeout(function () {
			$this.removeClass('loader active');
			$this.text('تم');
			$this.addClass('success animated pulse');
		}, 1600);
		setTimeout(function () {
			$this.text('مشاهدة المزيد');
			$this.removeClass('success animated pulse');
			$this.blur();
		}, 2900);
	});
});	  
	

	 $(document).ready(function(){
		$(document).on('click','#btn_more',function(){
			var last_product_id=$(this).attr('data-pro');
            var start_from=$(this).attr('start_number');
			
			 var sortby=$(".sort_product_part .sortBy").val();
	         var sorttype=$('option:selected', ".sort_product_part .sortBy").attr('type');

			 $("#btn_more").html('...');
                         $.ajax({
				 url:APP_URL+'/fronted/load_more?product_id='+last_product_id+'&sort_by='+sortby+'&sort_type='+sorttype+'&start_from='+start_from,
				 type:'get',
				 
				 
				 success:function(data){
					  if(data=='no_date'){
						 $("#btn_more").text('No any Items');
					 }
					 else if(data !=''){
						 $("#remove_div").remove();
						 $("#load_more_item_section").append(data);
					 }
					 
				 },
				 error:function(){
					 
				 }
			 })			 
		}); 
	 });  
 
 	
	$(document).ready(function(){
		$(document).on('click','#btn_more_cate',function(){
			var last_product_id=$(this).attr('data-pro');
			var selectedCate=$(this).attr('data-cate');
			
			var last_product_id=$(this).attr('data-pro');
			var start_from=$(this).attr('start_number');
			
			 var sortby=$(".sort_product_part .sortBy").val();
	         var sorttype=$('option:selected', ".sort_product_part .sortBy").attr('type');
			 
			var selectedCate=$(this).attr('data-cate');
			
			 $("#btn_more_cate").html('...');
             $.ajax({
				 url:APP_URL+'/fronted/load_more_cat_item?product_id='+last_product_id+'&sort_by='+sortby+'&sort_type='+sorttype+'&start_from='+start_from+'&category='+selectedCate,
				 type:'get',
				 
				 
				 success:function(data){
					  if(data=='no_date'){
						 $("#btn_more_cate").text('No any Items');
					 }
					 else if(data !=''){
						 $("#remove_div").remove();
						 $("#load_more_item_section").append(data);
					 }
					 
				 },
				 error:function(){
					 
				 }
			 })			 
		}); 
	 }); 
 
	
	
	$(document).on("click",'.product_link',function(){
		var link=$(this).attr('product_link');
		$("#product_video iframe").attr('src',link);
	})   
	
   $(document).on("click","#product_video .close", function(){
	   $("#product_video iframe").attr('src','');
   });
   
    $(document).on("click",".column5",function(e){
		 if (!$(e.target).hasClass('product_link') && !$(e.target).hasClass('btn')) {
		 var pid= $(this).attr("product_id");
         $.ajax({
			 url:APP_URL+'/fronted/selectProduct/'+pid,
			 type:'get',
			 success:function(response){
				$(".product-details .details_content").html(response);  
			 },
			 error:function(){
				 
			 }
		 });		 
         $('#productModal').modal('toggle');
       }
	});
	
	
	$(document).on("click",".add_to_cart",function(){
	   var pid=$(this).attr('product_id');
	   var currency=localStorage.getItem("currency");
       if(currency==null || currency=="" || currency=="null" || currency==0){
			   currency="en";
		   }
	   
	   if($(this).attr('product_qty')<=0  /* && zero_qty==0 */){
		$("#product_not_available").modal('show');
	   } 
      else
	  {
         $('#confirmModal').modal('show');	   
         $.ajax({
			 url:APP_URL+'/add_to_cart/'+pid+'/'+couponNumber+'/'+currency,
			 type:'get',
			 success:function(response){
				$(".total-cart-item").text(response);  
			 },
			 error:function(){
				 
			 }
		 })
	  }		 
	});
	
	
	$(".category_item").click(function(){
                $('.css_preloader').css('display','block');
                $('.fonted_products').css('display','none');
		
                $(".sort_product_part .sortBy").val('date');
		$(".sort_product_part .sortType").val('des');

		
		var cid=$(this).attr('category_id');
		$(".category_item").removeClass('category_active'); 
	    $(this).addClass('category_active'); 
		$.ajax({
			 url:APP_URL+'/fronted/selectCategory/'+cid,
			 type:'get',
			 success:function(response){
                $('.fonted_products').css('display','block');
				$(".fonted_products").html(response);  
                 $('.css_preloader').css('display','none');
			 },
			 error:function(){
				 
			 }
		 })		 
	});
	
	
	$(".mobile-cartegory").change(function(){
		var cid=$(this).val();
		$.ajax({
			 url:APP_URL+'/fronted/selectCategory/'+cid,
			 type:'get',
			 success:function(response){
				$(".fonted_products").html(response);  
			 },
			 error:function(){
				 
			 }
		 })		 
	});
	
	window.unload = function(){
    // alert('some');
  }
 </script>
 <?php $__env->stopSection(); ?>
 

<?php echo $__env->make('fronted-layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
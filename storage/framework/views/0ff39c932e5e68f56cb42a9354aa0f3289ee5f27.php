<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" href="<?php echo e(url('public/logo', $general_setting->site_logo)); ?>" />
    <title><?php echo e($general_setting->site_title); ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    
     <!-- Bootstrap CSS
    <link rel="stylesheet" href="<?php // echo asset('public/vendor/bootstrap/css/bootstrap.min.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?php //echo asset('public/vendor/bootstrap/css/bootstrap-select.min.css') ?>" type="text/css">
    
    <link rel="stylesheet" href="<?php //echo asset('public/vendor/font-awesome/css/font-awesome.min.css') ?>" type="text/css">
    -->
    
    <link rel="stylesheet" href="<?php echo asset('public/css/ionicons.min.css') ?>" type="text/css">
    <!-- Google fonts - Roboto -->
    <link href="https://fonts.googleapis.com/css?family=Cairo:200,300,400,600,700,900&amp;subset=arabic" rel="stylesheet">
    <!-- jQuery Circle-->
   
  <!-- 
    <link rel="stylesheet" href="<?php //echo asset('public/css/responsivetables.css') ?>" id="table_responsive_style" type="text/css">
    <link rel="stylesheet" href="<?php //echo asset('public/css/style.default.css') ?>" id="theme-stylesheet" type="text/css">  
    <link rel="stylesheet" href="<?php //echo asset('public/css/custom.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?php //echo asset('public/css/fronted.css') ?>" type="text/css">
     <link rel="stylesheet" href="<?php //echo asset('public/css/rtl.css') ?>" type="text/css">
   -->   
   <link rel="stylesheet" href="<?php echo asset('public/css/compressed.css') ?>" type="text/css">
	
	
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/favicon.ico">
  </head>
  <body class="fronted_body">
    <!-- Side Navbar -->
	
 	
 <?php $siteDetail=DB::table('site_setting')->where('id','1')->get()[0];?>
 

    <nav class="side-navbar" >
      <div class="side-navbar-wrapper">
        <!-- Sidebar Header    -->
        <div class="sidenav-header d-flex align-items-center justify-content-center">
          <!-- User Info-->
          <div class="sidenav-header-inner text-center brand">
                        <a href="<?php echo e(asset('/fronted')); ?>"><span class="brand-big text-center"><img src="<?php echo e(asset('public/logo')); ?>/<?php echo e($siteDetail->logo); ?>"></span></a>

          </div>
          <!-- Small Brand information, appears on minimized sidebar-->
        </div>
        <!-- Sidebar Navigation Menus-->
        <div class="main-menu">
		   <li class="mobile-expand"><span class="fa fa-close"></span></li>
          <ul id="side-main-menu" class="side-menu list-unstyled"> 
              <li><a href="<?php echo e(asset('/fronted')); ?>/<?php if($reference_id !='null'): ?><?php echo e($reference_id); ?> <?php endif; ?>">الرئیسیة</a></li>
              <li> <a href="<?php echo e(asset('/cart')); ?>/<?php if($reference_id!='null'): ?><?php echo e($reference_id); ?> <?php endif; ?>">سلة التسق  &nbsp;&nbsp;&nbsp;&nbsp;<span class="fa fa-shopping-cart" style="font-size:27px; float:left;"></span><span class="total-cart-item"><?php echo e($totalCartQty); ?></span></a></li>
              <li> <a href="#InserCouponNumber" data-toggle="modal">ادخل البروموكود هنا </a></li>
          </ul>
        
		</div>
      </div>
       
	 <div class="sidebar_contact">
	        <ul> 
		   <li><a href="<?php echo e($siteDetail->facebook); ?>" target="_blank" style="padding:0px;margin:0px; color:#605f5e;"><span class="fa fa-facebook"></span>&nbsp;&nbsp  زیارةصفحة الفیسبوک</a></li>
		   <li><a href="tel:<?php echo e($siteDetail->phone_no1); ?>" target="_blank" style="padding:0px;margin:0px; color:#605f5e;"><span class="fa fa-phone"></span>&nbsp;&nbsp <?php echo e($siteDetail->phone_no1); ?></a></li>
		   <li><a href="tel:<?php echo e($siteDetail->phone_no2); ?>" target="_blank" style="padding:0px;margin:0px; color:#605f5e;"><span class="fa fa-phone" style='visibility:hidden'></span>&nbsp;&nbsp  <?php echo e($siteDetail->phone_no2); ?> </a></li>
		</ul>
     </div>	 
	</nav>
    <div class="page">
      <!-- navbar-->
      <header class="header">
        <nav class="navbar">
          <div class="container-fluid">
            <div class="navbar-holder d-flex align-items-center justify-content-between">
                <div class="fronted_label">
				   <div class="fronted-background">
     				   <h1> <?php echo e($siteDetail->title); ?> </h1> 
				   </div>
				   <div class="label">
				      <h1> <?php echo e($siteDetail->title); ?> </h1>
				   </div> 
				   
				   <div class="contacts">
				      <a href="<?php echo e($siteDetail->facebook); ?>" style='font-size:26px;' target="_blank"><span class="fa fa-facebook"></span></a>&nbsp;&nbsp;&nbsp; <a href="tel:<?php echo e($siteDetail->phone_no1); ?>" style='font-size:26px;'><span class="fa fa-phone"></span></a>
				   </div>
				</div>
				<div class="mobile-collapse">
				 <div class="contacts">
				      <a href="<?php echo e($siteDetail->facebook); ?>" style='font-size:26px;' target="_blank"><span class="fa fa-facebook"></span></a>&nbsp;&nbsp;&nbsp; <a href="tel:<?php echo e($siteDetail->phone_no1); ?>" style='font-size:26px;'><span class="fa fa-phone"></span></a>
				   </div>
				   <img src="<?php echo e(asset('public/logo/expand.png')); ?>" style="width:50px;">
				</div>
				
				<div class="col-md-12 mobile-view" style="display:none">
				  <img src="<?php echo e(asset('public/logo')); ?>/<?php echo e($siteDetail->logo); ?>" style="display:none">
				  <h1 style="display:none"> <?php echo e($siteDetail->title); ?> </h1>
				</div>
            </div>
			
			<div class="search-products">
			      <div class="form-group">
				   <input type="text" autocomplete="off" class="form-control" placeholder="بحت عن منتج..." name="search" id="fronted_search_product">
				   <span class="fa fa-search"></span>
		         </div>
				 <div class="search-result" style="display:none">
				     <ul>
					  
					 </ul>
				 </div>
		   </div>
          </div>
        </nav>
      </header>
     
      <?php echo $__env->yieldContent('content'); ?>
     
    </div>
	
<div id="InserCouponNumber" class="modal fade " role="dialog"  >
  <div class="modal-dialog " style="width:458px; padding-top:140px ">
    <div class="modal-content" style="border-radius:0px;">
	 <div class="modal-header" style="padding:0px">
        <button type="button" class="close" data-dismiss="modal">&times; <span style="font-size:14px">اغلاق</span></button>
      <button class="btn btn-danger class_coupon_number" style="color:red;padding:16px;background:transparent;border:none;font-weight:bold">الغاء البروموكود</button>     
	 </div>
      <div class="modal-body" style="background:#fff; ">
         <div class="row">          
		  <div class="form-group col-md-8">
		     <input type="number" name="coupun_number" min="1" class="form-control inserted_counpon_number" placeholder="ادخل البروموكود هنا">
           </div> 	

           <div class="form-group col-md-4">
		     <input type="submit" name="save" value="ادخال" class="btn btn-block btn-primary check_coupon_number">
           </div> 
		    <div class="col-md-12 coupon_check_result"></div>
		 </div>  
	  </div>
    </div>
  </div>
</div>
<style>
@media(max-width:450px){
	.fronted_body .mobile-expand span{
		position:absolute;
		top:0px;
		left:0px;
		z-index:444;
	}
        .fronted_body .search-products{
            margin-top:25px;
          }
	.fronted_body .page header .navbar{
		height:212px;
	}
	.d-flex{
		display:block !important; 
	}
	.mobile-view{
		text-align:center;
		display:block !important;
	}
	.mobile-view img{
		display:inline !important;
		width:67px;
	}
	.mobile-view h1{
	     display: block !important;
        font-size: 20px;
        margin-top: 10px;
	}
	#InserCouponNumber .modal-dialog {
		width: 96% !important;
	}
	
	.mobile-collapse img{
       width: 26px !important;
       padding: 20px;
       box-sizing: content-box;
	}
	.fronted_body .mobile-collapse{
	      height: 67px;	
	}
	.fronted_body .search-result ul li{
		line-height: initial;
		padding:0px 0px 4px 0px;
	}
	.fronted_body .search-result ul li .btn{
		float:unset;
	}
	header{
		margin-bottom:55px;
	}
}

</style>
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
<!--
<script type="text/javascript" src="<?php //echo asset('public/vendor/jquery/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?php //echo asset('public/vendor/jquery/jquery-ui.min.js') ?>"></script>
<script type="text/javascript" src="<?php // echo asset('public/vendor/jquery/bootstrap-datepicker.min.js') ?>"></script>
<script type="text/javascript" src="<?php // echo asset('public/vendor/popper.js/umd/popper.min.js') ?>">
</script>
<script type="text/javascript" src="<?php //echo asset('public/vendor/bootstrap/js/bootstrap.min.js') ?>"></script>
<script type="text/javascript" src="<?php //echo asset('public/vendor/bootstrap/js/bootstrap-select.min.js') ?>"></script>
<script type="text/javascript" src="<?php //echo asset('public/vendor/jquery.cookie/jquery.cookie.js') ?>">
</script>
<script type="text/javascript" src="<?php //echo asset('public/vendor/jquery-validation/jquery.validate.min.js') ?>"></script>
<script type="text/javascript" src="<?php //echo asset('public/js/front.js') ?>"></script>
<script type="text/javascript" src="<?php //echo asset('public/vendor/daterange/js/moment.min.js') ?>"></script>
<script type="text/javascript" src="<?php //echo asset('public/js/responsivetables.js') ?>"></script>
-->

<script type="text/javascript" src="<?php echo asset('public/js/compressed.js') ?>"></script>



<?php echo $__env->yieldContent('scripts'); ?>

    <script type="text/javascript">
	var APP_URL = <?php echo json_encode(url('/')); ?>

     $(".class_coupon_number").click(function(){
		    localStorage.setItem("userCoupon", 'null');
			localStorage.setItem("userCouponValue", '0');
			localStorage.setItem("CouponNumberCategories", 'null'); 
		document.location.reload();	
	 });
	 
       $("#fronted_search_product").keyup(function(){
		   var word=$(this).val();
		   if(word==''){
			   word='null';
		   }
		   $.ajax({
			 url:'fronted/searchProduct/'+word,
			 type:'get',
			 success:function(response){
				 $(".search-result").css('display','block');
				$(".search-result ul").html(response); 			
			 },
			 error:function(){
				 
			 }
		 })
	   });
	  
	  
	 $(".check_coupon_number").click(function(){
		 var cp=$(".inserted_counpon_number").val();
		 if(cp !=0 && cp !=""){
		 $.ajax({
			 url:APP_URL+'/fronted/check_coupon/'+cp,
			 type:'get',
			 success:function(response){
				if(response=="ended_nubmer_of_use"){ 
				  $(".coupon_check_result").text('the number of use is finished!');
				  $(".coupon_check_result").css("color",'red');
				  localStorage.setItem("userCoupon", '');
				}
				else if(response=="expire_date"){
				   $(".coupon_check_result").text('the date is expired!');
				  $(".coupon_check_result").css("color",'red');
				  localStorage.setItem("userCoupon", '');	
				}
				else if(response=="not_valid"){
					$(".coupon_check_result").text('بروموكود غير فعال');
					$(".coupon_check_result").css("colo",'red');
					localStorage.setItem("userCoupon", '');
				}
				else{
					
					$(".coupon_check_result").css("color",'green');
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
	
      var date = $('#date');
    date.datepicker({
     format: "dd-mm-yyyy",
     startDate: "<?php echo date('d-m-Y', strtotime('')); ?>",
     autoclose: true,
     todayHighlight: true
     });
      
	  
	   //auto hide alert
     $(".alert").delay(4000).slideUp(200, function() {
        $(this).alert('close');
     });
	 
	 
      $("a#add-expense").click(function(e){
        e.preventDefault();
        $('#expense-modal').modal();
      });

      $("a#profitLoss-link").click(function(e){
        e.preventDefault();
        $("#profitLoss-report-form").submit();
      });

      $("a#report-link").click(function(e){
        e.preventDefault();
        $("#product-report-form").submit();
      });

      $("a#purchase-report-link").click(function(e){
        e.preventDefault();
        $("#purchase-report-form").submit();
      });

      $("a#sale-report-link").click(function(e){
        e.preventDefault();
        $("#sale-report-form").submit();
      });

      $("a#payment-report-link").click(function(e){
        e.preventDefault();
        $("#payment-report-form").submit();
      });

      $("a#customer-report-link").click(function(e){
        e.preventDefault();
        $('#customer-modal').modal();
      });

      $("a#supplier-report-link").click(function(e){
        e.preventDefault();
        $('#supplier-modal').modal();
      });

      $("a#due-report-link").click(function(e){
        e.preventDefault();
        $("#due-report-form").submit();
      });

      $('.selectpicker').selectpicker({
          style: 'btn-link',
      });
	  
	  $(window).on('load', function() {
        $(document).responsiveTables();
     });
	 
	 $(".mobile-collapse").click(function(){
		$(".fronted_body .side-navbar").toggle(); 
	 });
	 
	 $(".mobile-expand").click(function(){
		$(".fronted_body .side-navbar").toggle(); 
	 });
    </script>
  </body>
</html>
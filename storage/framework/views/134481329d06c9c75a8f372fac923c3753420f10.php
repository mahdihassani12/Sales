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
    
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="<?php echo asset('public/vendor/bootstrap/css/bootstrap.min.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo asset('public/vendor/bootstrap/css/bootstrap-datepicker.min.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo asset('public/vendor/bootstrap/css/bootstrap-select.min.css') ?>" type="text/css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="<?php echo asset('public/vendor/font-awesome/css/font-awesome.min.css') ?>" type="text/css">
    <!-- Fontastic Custom icon font-->
    <link rel="stylesheet" href="<?php echo asset('public/css/fontastic.css') ?>" type="text/css">
    <!-- Ion icon font-->
    <link rel="stylesheet" href="<?php echo asset('public/css/ionicons.min.css') ?>" type="text/css">
    <!-- Google fonts - Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cairo">
    <!-- jQuery Circle-->
    <link rel="stylesheet" href="<?php echo asset('public/css/grasp_mobile_progress_circle-1.0.0.min.css') ?>" type="text/css">
    <!-- Custom Scrollbar-->
    <link rel="stylesheet" href="<?php echo asset('public/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css') ?>" type="text/css">
    <!-- virtual keybord stylesheet-->
    <link rel="stylesheet" href="<?php echo asset('public/vendor/keyboard/css/keyboard.css') ?>" type="text/css">
    <!-- date range stylesheet-->
    <link rel="stylesheet" href="<?php echo asset('public/vendor/daterange/css/daterangepicker.min.css') ?>" type="text/css">
    <!-- table sorter stylesheet-->
    <link rel="stylesheet" type="text/css" href="<?php echo asset('public/vendor/datatable/dataTables.bootstrap4.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('public/vendor/datatable/buttons.bootstrap4.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('public/vendor/datatable/select.bootstrap4.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('public/vendor/datatable/dataTables.checkboxes.css') ?>">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="<?php echo asset('public/css/responsivetables.css') ?>" id="table_responsive_style" type="text/css">
    <link rel="stylesheet" href="<?php echo asset('public/css/style.default.css') ?>" id="theme-stylesheet" type="text/css">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="<?php echo asset('public/css/custom.css') ?>" type="text/css">
    <link rel="stylesheet" href="<?php echo asset('public/css/fronted.css') ?>" type="text/css">

      
	     <link rel="stylesheet" href="<?php echo asset('public/css/rtl.css') ?>" type="text/css">
	
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/favicon.ico">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->

<script type="text/javascript" src="<?php echo asset('public/vendor/jquery/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/vendor/jquery/jquery-ui.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/vendor/jquery/bootstrap-datepicker.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/vendor/popper.js/umd/popper.min.js') ?>">
</script>
<script type="text/javascript" src="<?php echo asset('public/vendor/bootstrap/js/bootstrap.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/vendor/bootstrap/js/bootstrap-select.min.js') ?>"></script>
<script type="text/javascript" src="<?php // echo asset('public/vendor/keyboard/js/jquery.keyboard.js') ?>"></script>
<script type="text/javascript" src="<?php // echo asset('public/vendor/keyboard/js/jquery.keyboard.extension-autocomplete.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/js/grasp_mobile_progress_circle-1.0.0.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/vendor/jquery.cookie/jquery.cookie.js') ?>">
</script>
<script type="text/javascript" src="<?php echo asset('public/vendor/chart.js/Chart.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/vendor/jquery-validation/jquery.validate.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js')?>"></script>
<script type="text/javascript" src="<?php echo asset('public/js/charts-custom.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/js/front.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/vendor/daterange/js/moment.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/vendor/daterange/js/knockout-3.4.2.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/vendor/daterange/js/daterangepicker.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/vendor/tinymce/js/tinymce/tinymce.min.js') ?>"></script>

<script type="text/javascript" src="<?php echo asset('public/vendor/datatable/pdfmake.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/vendor/datatable/vfs_fonts.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/vendor/datatable/jquery.dataTables.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/vendor/datatable/dataTables.bootstrap4.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/vendor/datatable/dataTables.buttons.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/vendor/datatable/buttons.bootstrap4.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/vendor/datatable/buttons.colVis.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/vendor/datatable/buttons.html5.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/vendor/datatable/buttons.print.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/vendor/datatable/dataTables.select.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/vendor/datatable/sum().js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/vendor/datatable/dataTables.checkboxes.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/js/responsivetables.js') ?>"></script>
   
  </head>
  <body class="fronted_body">
    <!-- Side Navbar -->
	
 
    <nav class="side-navbar" >
      <div class="side-navbar-wrapper">
        <!-- Sidebar Header    -->
        <div class="sidenav-header d-flex align-items-center justify-content-center">
          <!-- User Info-->
          <div class="sidenav-header-inner text-center brand">
            <a href="<?php echo e(asset('/')); ?>"><span class="brand-big text-center">HB</span></a>
          </div>
          <!-- Small Brand information, appears on minimized sidebar-->
        </div>
        <!-- Sidebar Navigation Menus-->
        <div class="main-menu">
		   <li class="mobile-expand"><span class="fa fa-close"></span></li>
          <ul id="side-main-menu" class="side-menu list-unstyled"> 
              <li><a href="<?php echo e(asset('/fronted')); ?>">الرئیسیة</a></li>
              <li> <a href="<?php echo e(asset('/cart')); ?>">سلة التسق  &nbsp;&nbsp;&nbsp;&nbsp;<span class="fa fa-shopping-cart" style="font-size:27px"></span><span class="total-cart-item"><?php echo e($totalCartQty); ?></span></a></li>
          </ul>
        
		</div>
      </div>
       
	 <div class="sidebar_contact">
	    <ul> 
		   <li><span class="fa fa-facebook"></span>&nbsp;&nbsp; زیارةصفحة الفیسبوک</li>
		   <li><span class="fa fa-phone"></span>&nbsp;&nbsp; 0770 123 1234</li>
		   <li><span class=""></span>&nbsp;&nbsp; &nbsp;&nbsp; 0770 123 1234</li>
		   
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
     				   <h1> هدی بیوتی للتسوق الالکترونی</h1> 
				   </div>
				   <div class="label">
				      <h1> هدی بیوتی للتسوق الالکترونی</h1>
				   </div> 
				   
				   <div class="contacts">
				      <span class="fa fa-facebook"></span>&nbsp;&nbsp;&nbsp; <span class="fa fa-phone"></span>
				   </div>
				</div>
				<div class="mobile-collapse">
				   <img src="<?php echo e(asset('public/logo/expand.png')); ?>" style="width:50px;">
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
      <footer class="main-footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6">
              <p>&copy; <?php echo e($general_setting->site_title); ?></p>
            </div>
            <div class="col-sm-6 text-right">
              <p><?php echo e(trans('file.Developed')); ?> <?php echo e(trans('file.By')); ?> <a href="http://iraq-soft.info" class="external">IraqSoft</a></p>
            </div>
          </div>
        </div>
      </footer>
    </div>
    <?php echo $__env->yieldContent('scripts'); ?>
    <script type="text/javascript">
       $("#fronted_search_product").keyup(function(){
		   var word=$(this).val();
		   
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
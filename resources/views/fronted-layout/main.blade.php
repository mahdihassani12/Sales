 <?php $siteDetail=DB::table('site_setting')->where('id','1')->get()[0];?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" href="{{url('public/logo', $general_setting->site_logo)}}" />
    <title>{{$siteDetail->title}}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="all,follow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
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
<style>
    #interactive.viewport {position: absolute !important; z-index:11111; width: 95%; height: auto; overflow: hidden; text-align: center;}
    #interactive.viewport > canvas, #interactive.viewport > video {max-width: 100%;width: 100%;}
    canvas.drawing, canvas.drawingBuffer {position: absolute; left: 0; top: 0;}
    .open_camera{
		float:left;
		line-height:2 !important;
		    color: red !important;
	}
	
	
 @charset "UTF-8";

.collapsable-source pre {
    font-size: small;
}

.input-field {
    display: flex;
    align-items: center;
    width: 260px;
}

.input-field label {
    flex: 0 0 auto;
    padding-right: 0.5rem;
}

.input-field input {
    flex: 1 1 auto;
    height: 20px;
}



.icon-barcode {
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center center;
    background-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48IURPQ1RZUEUgc3ZnIFBVQkxJQyAiLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4iICJodHRwOi8vd3d3LnczLm9yZy9HcmFwaGljcy9TVkcvMS4xL0RURC9zdmcxMS5kdGQiPjxzdmcgdmVyc2lvbj0iMS4xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB3aWR0aD0iMzIiIGhlaWdodD0iMzIiIHZpZXdCb3g9IjAgMCAzMiAzMiI+PHBhdGggZD0iTTAgNGg0djIwaC00ek02IDRoMnYyMGgtMnpNMTAgNGgydjIwaC0yek0xNiA0aDJ2MjBoLTJ6TTI0IDRoMnYyMGgtMnpNMzAgNGgydjIwaC0yek0yMCA0aDF2MjBoLTF6TTE0IDRoMXYyMGgtMXpNMjcgNGgxdjIwaC0xek0wIDI2aDJ2MmgtMnpNNiAyNmgydjJoLTJ6TTEwIDI2aDJ2MmgtMnpNMjAgMjZoMnYyaC0yek0zMCAyNmgydjJoLTJ6TTI0IDI2aDR2MmgtNHpNMTQgMjZoNHYyaC00eiI+PC9wYXRoPjwvc3ZnPg==);
}

.overlay {
    overflow: hidden;
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    width: 100%;
    background-color: rgba(0, 0, 0, 0.3);
}

.overlay__content {
    top: 50%;
    position: absolute;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 90%;
    max-height: 90%;
    max-width: 800px;
}

.overlay__close {
    position: absolute;
    right: 0;
    padding: 0.5rem;
    width: 2rem;
    height: 2rem;
    line-height: 2rem;
    text-align: center;
    background-color: white;
    cursor: pointer;
    border: 3px solid black;
    font-size: 1.5rem;
    margin: -1rem;
    border-radius: 2rem;
    z-index: 100;
    box-sizing: content-box;
}

.overlay__content video {
    width: 100%;
    height: 100%;
}

.overlay__content canvas {
    position: absolute;
    width: 100%;
    height: 100%;
    left: 0;
    top: 0;
}



#interactive.viewport > canvas, #interactive.viewport > video {
    max-width: 100%;
    width: 100%;
}

canvas.drawing, canvas.drawingBuffer {
    position: absolute;
    left: 0;
    top: 0;
}

/* line 16, ../sass/_viewport.scss */
.controls fieldset {
  border: none;
}
/* line 19, ../sass/_viewport.scss */
.controls .input-group {
  float: left;
}
/* line 21, ../sass/_viewport.scss */
.controls .input-group input, .controls .input-group button {
  display: block;
}
/* line 25, ../sass/_viewport.scss */
.controls .reader-config-group {
  float: right;
}
/* line 28, ../sass/_viewport.scss */
.controls .reader-config-group label {
  display: block;
}
/* line 30, ../sass/_viewport.scss */
.controls .reader-config-group label span {
  width: 11rem;
  display: inline-block;
  text-align: right;
}
/* line 37, ../sass/_viewport.scss */
.controls:after {
  content: '';
  display: block;
  clear: both;
}

/* line 22, ../sass/_viewport.scss */
#result_strip {
  margin: 10px 0;
  border-top: 1px solid #EEE;
  border-bottom: 1px solid #EEE;
  padding: 10px 0;
}
/* line 28, ../sass/_viewport.scss */
#result_strip ul.thumbnails {
  padding: 0;
  margin: 0;
  list-style-type: none;
  width: auto;
  overflow-x: auto;
  overflow-y: hidden;
  white-space: nowrap;
}
/* line 37, ../sass/_viewport.scss */
#result_strip ul.thumbnails > li {
  display: inline-block;
  vertical-align: middle;
  width: 160px;
}
/* line 41, ../sass/_viewport.scss */
#result_strip ul.thumbnails > li .thumbnail {
  padding: 5px;
  margin: 4px;
  border: 1px dashed #CCC;
}
/* line 46, ../sass/_viewport.scss */
#result_strip ul.thumbnails > li .thumbnail img {
  max-width: 140px;
}
/* line 49, ../sass/_viewport.scss */
#result_strip ul.thumbnails > li .thumbnail .caption {
  white-space: normal;
}
/* line 51, ../sass/_viewport.scss */
#result_strip ul.thumbnails > li .thumbnail .caption h4 {
  text-align: center;
  word-wrap: break-word;
  height: 40px;
  margin: 0px;
}
/* line 61, ../sass/_viewport.scss */
#result_strip ul.thumbnails:after {
  content: "";
  display: table;
  clear: both;
}

@media (max-width: 603px) {
  /* line 2, ../sass/phone/_core.scss */
  #container {
    margin: 10px auto;
    -moz-box-shadow: none;
    -webkit-box-shadow: none;
    box-shadow: none;
  }
}
@media (max-width: 603px) {
  /* line 5, ../sass/phone/_viewport.scss */
  #interactive.viewport {
    width: 100%;
    height: auto;
    overflow: hidden;
  }

  /* line 20, ../sass/phone/_viewport.scss */
  #result_strip {
    margin-top: 5px;
    padding-top: 5px;
  }

  #result_strip ul.thumbnails {
    width: 100%;
    height: auto;
  }

  /* line 24, ../sass/phone/_viewport.scss */
  #result_strip ul.thumbnails > li {
    width: 150px;
  }
  /* line 27, ../sass/phone/_viewport.scss */
  #result_strip ul.thumbnails > li .thumbnail .imgWrapper {
    width: 130px;
    height: 130px;
    overflow: hidden;
  }
  /* line 31, ../sass/phone/_viewport.scss */
  #result_strip ul.thumbnails > li .thumbnail .imgWrapper img {
    margin-top: -25px;
    width: 130px;
    height: 180px;
  }
}
</style>


  </head>
  <body class="fronted_body">
    <!-- Side Navbar -->
	

 

    <nav class="side-navbar" >
      <div class="side-navbar-wrapper">
        <!-- Sidebar Header    -->
        <div class="sidenav-header d-flex align-items-center justify-content-center">
          <!-- User Info-->
          <div class="sidenav-header-inner text-center brand">
                        <a href="{{asset('web')}} @if($reference_id !='null' and $reference_id != ''){{'?ref_id='.$reference_id}} @endif"><span class="brand-big text-center"><img src="{{asset('public/logo')}}/{{$siteDetail->logo}}"></span></a>

          </div>
          <!-- Small Brand information, appears on minimized sidebar-->
        </div>
        <!-- Sidebar Navigation Menus-->
        <div class="main-menu">
		    
					 
		   <li class="mobile-expand"><span class="fa fa-close"></span></li>
          <ul id="side-main-menu" class="side-menu list-unstyled"> 
               <li><a href="{{asset('web')}}@if($reference_id !='null' and $reference_id != ''){{'?ref_id='.$reference_id}} @endif">الرئیسیة</a></li>
              <li> <a href="{{asset('/cart')}}/@if($reference_id!='null'){{$reference_id}} @endif">سلة التسوق  &nbsp;&nbsp;&nbsp;&nbsp;<span class="fa fa-shopping-cart" style="font-size:27px; float:left;"></span><span class="total-cart-item">{{$totalCartQty}}</span></a></li>
              <li style="display:none"> <a href="#InserCouponNumber" data-toggle="modal" style="display:none">ادخل البروموكود هنا </a></li>
              <li > <a href="#select_user_store_modal" data-toggle="modal">تغيير المخزن </a></li>              
<li> 
                 <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">تسجيل خروج </a>
		     <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                 {{ csrf_field() }}
                     </form>
             </li>
          </ul>
        
		</div>
      </div>
       
	 <div class="sidebar_contact">
	        <ul> 
		   <li><a href="{{$siteDetail->facebook}}" target="_blank" style="padding:0px;margin:0px; color:#605f5e;"><span class="fa fa-facebook"></span>&nbsp;&nbsp  زیارةصفحة الفیسبوک</a></li>
		   <li><a href="tel:{{$siteDetail->phone_no1}}" target="_blank" style="padding:0px;margin:0px; color:#605f5e;"><span class="fa fa-phone"></span>&nbsp;&nbsp {{$siteDetail->phone_no1}}</a></li>
		   <li><a href="tel:{{$siteDetail->phone_no2}}" target="_blank" style="padding:0px;margin:0px; color:#605f5e;"><span class="fa fa-phone" style='visibility:hidden'></span>&nbsp;&nbsp  {{$siteDetail->phone_no2}} </a></li>
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
     				   <h1> {{$siteDetail->title}} </h1> 
				   </div>
				   <div class="label">
				      <h1> {{$siteDetail->title}} </h1>
					  
				   </div> 
				   
				   <div class="contacts">
				       
				      <a href="{{$siteDetail->facebook}}" style='font-size:26px;' target="_blank"><span class="fa fa-facebook"></span></a>&nbsp;&nbsp;&nbsp; <a href="tel:{{$siteDetail->phone_no1}}" style='font-size:26px;'><span class="fa fa-phone"></span></a>
					 
					  <span class="currency" href="#" style="display:none">  
					  <span class="selected_currencty dollar" style="display:none"> <img src="{{asset('public/images/icons/coin.svg')}}">&nbsp; USD</span>
					  <span class="selected_currencty arabic" style="display:none">  <img src="{{asset('public/images/icons/coin.svg')}}">&nbsp; د . ع</span>
					  <span class="fa fa-angle-down"> </span>
					  <span class="language_dropdwon">
					     <a href="#" class="arabic_currenty">USD &nbsp;<img src="{{asset('public/images/icons/coin.svg')}}"></a>
					     <a href="#" class="dollar_currency">د . ع &nbsp;<img src="{{asset('public/images/icons/coin.svg')}}"></a>
					   </span>
					 </span>
					 
					  <span class="language" href="#" style="display:none">  
					  <span class="selected_lang english" style="display:none"><img src="{{asset('public/images/icons/united-states.svg')}}">&nbsp; English </span>
					  <span class="selected_lang arabic" style=""><img src="{{asset('public/images/icons/iraq.svg')}}"> &nbsp;  عربی </span>
					  <span class="fa fa-angle-down" style="display:none"> </span>
					  <span class="language_dropdwon" style="display:none">
					     <a href="#" class="arabic_lang">عربی &nbsp;<img src="{{asset('public/images/icons/iraq.svg')}}"></a>
					     <a href="#" class="english_lang">English &nbsp;<img src="{{asset('public/images/icons/united-states.svg')}}"></a>
					   </span>
					 </span>
					 
					
					 
				   </div>
				</div>
				<div class="mobile-collapse">
				 <div class="contacts">
				 
				  <span class="currency" href="#" style="display:none">  
					  <span class="selected_currencty dollar" style="display:none"> <img src="{{asset('public/images/icons/coin.svg')}}">&nbsp; USD</span>
					  <span class="selected_currencty arabic" style="display:none">  <img src="{{asset('public/images/icons/coin.svg')}}">&nbsp; د . ع</span>
					  <span class="fa fa-angle-down"> </span>
					  <span class="language_dropdwon">
					     <a href="#" class="arabic_currenty">USD &nbsp;<img src="{{asset('public/images/icons/coin.svg')}}"></a>
					     <a href="#" class="dollar_currency">د . ع &nbsp;<img src="{{asset('public/images/icons/coin.svg')}}"></a>
					   </span>
					 </span>
					 
				       <span class="language" href="#" style="display:none">  
					  <span class="selected_lang english" style="display:none">English &nbsp;<img src="{{asset('public/images/icons/united-states.svg')}}"></span>
					  <span class="selected_lang arabic" style="">عربی &nbsp;<img src="{{asset('public/images/icons/iraq.svg')}}"></span>
					  <span class="fa fa-angle-down" style="display:none"> </span>
					  <span class="language_dropdwon" style="display:none">
					     <a href="#" class="arabic_lang">عربی &nbsp;<img src="{{asset('public/images/icons/iraq.svg')}}"></a>
					     <a href="#" class="english_lang">English &nbsp;<img src="{{asset('public/images/icons/united-states.svg')}}"></a>
					   </span>
					 </span>
					 
				      <a href="{{$siteDetail->facebook}}" style='font-size:26px;' target="_blank"><span class="fa fa-facebook"></span></a>&nbsp;&nbsp;&nbsp; <a href="tel:{{$siteDetail->phone_no1}}" style='font-size:26px;'><span class="fa fa-phone"></span></a>
				       
				  </div>
				   <img src="{{asset('public/logo/expand.png')}}" style="width:50px;">
				</div>
				
				<div class="col-md-12 mobile-view" style="display:none">
				   <a href="{{asset('/')}}"><img src="{{asset('public/logo')}}/{{$siteDetail->logo}}" style="display:none"></a>
				  <h1 style="display:none"> {{$siteDetail->title}} </h1>
				</div>
            </div>
			
			<div class="search-products">
			      <div class="form-group">
				   <input type="text" autocomplete="off" class="form-control" placeholder="بحت عن منتج..." name="search" id="fronted_search_product">
				   <span class="fa fa-search"></span>
				   <a href="#" class="open_camera">Scan Barcode</a>
		         </div>
				 <div class="search-result" style="display:none">
				     <ul>
					  
					 </ul>
					  <img src="{{asset('public/images/icons/small_loader.gif')}}">
				 </div>
		   </div>
          </div>
        </nav>
      </header>
     <div id="interactive" class="viewport" >
	
	</div>
      @yield('content')
     
    </div>

<div id="select_user_store_modal" class="modal fade " role="dialog"  >
  <div class="modal-dialog " style="width:458px; padding-top:140px ">
    <div class="modal-content" style="border-radius:0px;">
	 <div class="modal-header" style="padding:0px">
        <button type="button" class="close" data-dismiss="modal">&times; <span style="font-size:14px">اغلاق</span></button>
	 </div>
      <div class="modal-body" style="background:#fff; ">
         <div class="row">          
		  <div class="form-group col-md-8">
              <?php 
			     $ids=explode("-",Auth::user()->store_id);
			     $previous_store=Auth::user()->selected_store;
			     $user_id=Auth::user()->id;
			     $str=DB::table('stores')->whereIn('id',$ids)->where('is_active','1')->get();
			  ?>
			 <form action="{{url('fronted/change_user_store')}}" method="post"> 
				 {{csrf_field()}}			 
			 <select name="selected_store" class="form-control" required>
			  <option value="">Select Store</option>
			  <?php foreach ($str as $st):
			  ?>
                <option value="{{$st->id}}" @if($st->id==$previous_store) selected @endif>{{$st->name}}</option>
			  <?php endforeach;?>
			 </select> 
  		  </div> 	
               <input type="hidden" name="user_id" value="{{$user_id}}">
           <div class="form-group col-md-4">
		     <input type="submit" name="save" value="ادخال" class="btn btn-block btn-primary check_coupon_number">
           </div> 
		    <div class="col-md-12 coupon_check_result"></div>
		
           </form>		
		 </div>  
	  </div>
    </div>
  </div>
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
.language,.currency{
	margin-left:16px;
	font-size:17px;
    position:relative; 
    cursor:pointer;	
}
 .language_dropdwon{
	 list-style-type: none;
    position: absolute;
    margin: 0;
    padding: 15px 13px;
	top: 46px;
    z-index: 444;
    left: 0px;
    background: whitesmoke;
    height: 74px;
    width: 110px;
	display:none; 	
}
.language:hover .language_dropdwon,.currency:hover .language_dropdwon{
	display:block; 
}
.language_dropdwon a{
	display: block;
    line-height: 0 !important;
    height: 30px;
    font-weight: normal !important;
}
.language_dropdwon img{float:right;margin-top: -7px;}
.selected_lang,.selected_currencty{
	font-size:14px;
}
.selected_lang img,.selected_currencty img{
	width:25px; 
	height:16px;
}


.fronted_body .search-result{
	min-height:44px;
}
.fronted_body .search-result img{
	    width: 39px;
    float: left;
}


@media(max-width:450px){
	.fronted_body .mobile-expand span{
		position:absolute;
		top:0px;
		left:0px;
		z-index:444;
	}
	.language, .currency{
		margin-left:4px;
	}
	.language_dropdwon{ 
		height:auto; 
	}
	
	.language_dropdwon img{
		padding:0px !important; 
	}
	.selected_lang img, .selected_currencty img{
		    padding: 0px !important;
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
	.currency .language_dropdwon img{
		width:15px !important;
	}
	.language_dropdwon a{
		text-align:left;
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

<script type="text/javascript" src="<?php echo asset('public/js/quagga.min.js') ?>"></script>



@yield('scripts')
   
    <script type="text/javascript">
/* from here*/
$(document).on("click",".open_camera",function(evvt){
   evvt.preventDefault();
   $(".viewport").css("display",'block');
$(function() {
    var value;
    var App = {
        init : function() {
            Quagga.init(this.state, function(err) {
                if (err) {
                    console.log(err);
                    return;
                }
                App.attachListeners();
                Quagga.start();
            });
        },
        initCameraSelection: function(){
            var streamLabel = Quagga.CameraAccess.getActiveStreamLabel();

            return Quagga.CameraAccess.enumerateVideoDevices()
            .then(function(devices) {
                function pruneText(text) {
                    return text.length > 30 ? text.substr(0, 30) : text;
                }
                var $deviceSelection = document.getElementById("deviceSelection");
                while ($deviceSelection.firstChild) {
                    $deviceSelection.removeChild($deviceSelection.firstChild);
                }
                devices.forEach(function(device) {
                    var $option = document.createElement("option");
                    $option.value = device.deviceId || device.id;
                    $option.appendChild(document.createTextNode(pruneText(device.label || device.deviceId || device.id)));
                    $option.selected = streamLabel === device.label;
                    $deviceSelection.appendChild($option);
                });
            });
        },
            querySelectedReaders: function() {
        return Array.prototype.slice.call(document.querySelectorAll('.readers input[type=checkbox]'))
            .filter(function(element) {
                return !!element.checked;
            })
            .map(function(element) {
                return element.getAttribute("name");
            });
    },
        attachListeners: function() {
            var self = this;

            self.initCameraSelection();
            $(".controls").on("click", "button.stop", function(e) {
                e.preventDefault();
                Quagga.stop();
            });

            $(".controls .reader-config-group").on("change", "input, select", function(e) {
                e.preventDefault();
                var $target = $(e.target);
                   // value = $target.attr("type") === "checkbox" ? $target.prop("checked") : $target.val(),
                   value =  $target.attr("type") === "checkbox" ? this.querySelectedReaders() : $target.val();
                  var  name = $target.attr("name"),
                    state = self._convertNameToState(name);

                console.log("Value of "+ state + " changed to " + value);
                self.setState(state, value);
            });
        },
        _accessByPath: function(obj, path, val) {
            var parts = path.split('.'),
                depth = parts.length,
                setter = (typeof val !== "undefined") ? true : false;

            return parts.reduce(function(o, key, i) {
                if (setter && (i + 1) === depth) {
                    if (typeof o[key] === "object" && typeof val === "object") {
                        Object.assign(o[key], val);
                    } else {
                        o[key] = val;
                    }
                }
                return key in o ? o[key] : {};
            }, obj);
        },
        _convertNameToState: function(name) {
            return name.replace("_", ".").split("-").reduce(function(result, value) {
                return result + value.charAt(0).toUpperCase() + value.substring(1);
            });
        },
        detachListeners: function() {
            $(".controls").off("click", "button.stop");
            $(".controls .reader-config-group").off("change", "input, select");
        },
        setState: function(path, value) {
            var self = this;

            if (typeof self._accessByPath(self.inputMapper, path) === "function") {
                value = self._accessByPath(self.inputMapper, path)(value);
            }

            self._accessByPath(self.state, path, value);

            console.log(JSON.stringify(self.state));
            App.detachListeners();
            Quagga.stop();
            App.init();
        },
        inputMapper: {
            inputStream: {
                constraints: function(value){
                    if (/^(\d+)x(\d+)$/.test(value)) {
                        var values = value.split('x');
                        return {
                            width: {min: parseInt(values[0])},
                            height: {min: parseInt(values[1])}
                        };
                    }
                    return {
                        deviceId: value
                    };
                }
            },
            numOfWorkers: function(value) {
                return parseInt(value);
            },
            decoder: {
                readers: function(value) {
                    if (value === 'ean_extended') {
                        return [{
                            format: "ean_reader",
                            config: {
                                supplements: [
                                    'ean_5_reader', 'ean_2_reader'
                                ]
                            }
                        }];
                    }
                    console.log("value before format :"+value);
                    return [{
                        format: value + "_reader",
                        config: {}
                    }];
                }
            }
        },
        state: {
            inputStream: {
                type : "LiveStream",
                constraints: {
                    width: {min: 640},
                    height: {min: 480},
                    aspectRatio: {min: 1, max: 100},
                    facingMode: "environment" // or user
                }
            },
            locator: {
                patchSize: "large",
                halfSample: true
            },
            numOfWorkers: 4,
            decoder: {
                readers : ["code_39_reader","code_128_reader","code_39_vin_reader","code_93_reader","ean_reader","ean_8_reader"]
            },
            locate: true,
            multiple:true
        },
        lastResult : null
    };
    
                   //value =  App.querySelectedReaders() ;
    App.init();

    Quagga.onProcessed(function(result) {
        var drawingCtx = Quagga.canvas.ctx.overlay,
            drawingCanvas = Quagga.canvas.dom.overlay;

        if (result) {
            if (result.boxes) {
                drawingCtx.clearRect(0, 0, parseInt(drawingCanvas.getAttribute("width")), parseInt(drawingCanvas.getAttribute("height")));
                result.boxes.filter(function (box) {
                    return box !== result.box;
                }).forEach(function (box) {
                    Quagga.ImageDebug.drawPath(box, {x: 0, y: 1}, drawingCtx, {color: "green", lineWidth: 2});
                });
            }

            if (result.box) {
                Quagga.ImageDebug.drawPath(result.box, {x: 0, y: 1}, drawingCtx, {color: "#00F", lineWidth: 2});
            }

            if (result.codeResult && result.codeResult.code) {
                Quagga.ImageDebug.drawPath(result.line, {x: 'x', y: 'y'}, drawingCtx, {color: 'red', lineWidth: 3});
            }
        }
    });

    Quagga.onDetected(function(result) {
        var code = result.codeResult.code;
		
        console.log(code);
        if (App.lastResult !== code) {
		$("#fronted_search_product").val(code);
		$("#fronted_search_product").trigger("keyup");
		$(".viewport").css("display",'none');
         //   App.lastResult = code;
         //   var $node = null, canvas = Quagga.canvas.dom.image;

            //$node = $('<li><div class="thumbnail"><div class="imgWrapper"><img /></div><div class="caption"><h4 class="code"></h4></div></div></li>');
            //$node.find("img").attr("src", canvas.toDataURL());
            //$node.find("h4.code").html(code);
            //$("#result_strip ul.thumbnails").prepend($node);
        }
    });
});

   
  });

/*........................*/




	var APP_URL = {!! json_encode(url('/')) !!}

       $('select[name="selected_store"]').change(function(){
		if($(this).val() !=""){
		  $(this).parents('form').submit();
		}
	})


	$(".arabic_lang").click(function(event){
		event.preventDefault();
		localStorage.setItem("product_name", 'ar');
		document.location.reload();	
	});
	
	$(".english_lang").click(function(event){
		event.preventDefault();
		localStorage.setItem("product_name", 'en');
		document.location.reload();	
	});
	
	var pr_name=localStorage.getItem("product_name");
	   if(pr_name=="ar"){
		  $('.selected_lang.arabic').css('display','inline'); 
	   }
	   else{
		 // $('.selected_lang.english').css('display','inline'); 
	   }
	  
  // select currency
        $(".dollar_currency").click(function(event){
	    event.preventDefault();
	    localStorage.setItem("currency", 'ar');
	    window.location.assign(APP_URL+'/currency/changeCurrency/ar');
	});
	
	$(".arabic_currenty").click(function(event){
	     event.preventDefault();
	     localStorage.setItem("currency", 'en');
	     window.location.assign(APP_URL+'/currency/changeCurrency/en');	
	});
	
	var ccurency=localStorage.getItem("currency");
	   if(ccurency=="ar"){
		  $('.selected_currencty.arabic').css('display','inline'); 
	   }
	   else{
		  $('.selected_currencty.dollar').css('display','inline'); 
	   }	 
//end of currency chacking
	 
     $(".class_coupon_number").click(function(){
		    localStorage.setItem("userCoupon", 'null');
			localStorage.setItem("userCouponValue", '0');
			localStorage.setItem("CouponNumberCategories", 'null'); 
		document.location.reload();	
	 });
	 
    
       $("#fronted_search_product").keyup(function(event){
		   var word=$(this).val();
		   $(".search-result").css('display','block');
		   $(".search-result img").css('display','block');
		    $(".search-result ul").css('display','none');
		   var len=word.length;
           console.log(len);
		 if(len>3){		  
		  if(word==''){
			   word='null';
		   }
		   $.ajax({
			 url:'fronted/searchProduct/'+word,
			 type:'get',
			 success:function(response){
				 $(".search-result").css('display','block');
				 $(".search-result img").css('display','none');
				 $(".search-result ul").css('display','block');
				$(".search-result ul").html(response); 			
			 },
			 error:function(){
				 
			 }
		 });
		 }
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
	 
	 $(".mobile-collapse img").click(function(){
		$(".fronted_body .side-navbar").toggle(); 
	 });
	 
	 $(".mobile-expand").click(function(){
		$(".fronted_body .side-navbar").toggle(); 
	 });
    </script>
  </body>
</html>
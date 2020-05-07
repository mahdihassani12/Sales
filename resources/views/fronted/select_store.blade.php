<?php $general_setting = DB::table('general_settings')->find(1); ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{$general_setting->site_title}}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="<?php echo asset('public/vendor/bootstrap/css/bootstrap.min.css') ?>" type="text/css">
    
    <!-- Google fonts - Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cairo">
    <!-- jQuery Circle-->
    
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="<?php echo asset('public/css/style.default.css') ?>" id="theme-stylesheet" type="text/css">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="<?php echo asset('public/css/custom.css') ?>" type="text/css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/favicon.ico">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
        <script type="text/javascript" src="<?php echo asset('public/vendor/jquery/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/vendor/jquery-validation/jquery.validate.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/js/front.js') ?>"></script>

  </head>
  <body>
    <div class="page login-page">
      <div class="container">
        <div class="form-outer text-center d-flex align-items-center">
          <div class="form-inner">
            <div class="logo text-uppercase"><span><img src="{{asset('public/logo/logo-home.png')}}" style="width:133px;"></span></div>
              <h1>اختر المخزن</h1>
			  <ul class="store_list">
			     @foreach($data['stores'] as $st)
			       <li><a href="{{asset('fronted/changes_user_default_store')}}/{{$st->id}}/{{$data['user_id']}}"><span class="circle"> </span> {{$st->name}}  </a> <img src="{{asset('public/images/icons/shop.svg')}}"></li>			  
			     @endforeach
			  </ul>
           </div>
          <div class="copyrights text-center">
            <p>{{trans('file.Developed By')}} <a href="http://iraq-soft.info/" class="external">IraqSoft</a></p>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>

<style>
.store_list{
	width:320px;
	background:#071124;
	padding:15px; 
    margin:auto;
	margin-top:15px;
	}
.store_list li{
	background:#fff;
	border-radius:7px; 
	margin:5px 0px;
	padding:6px;
	font-size:19px;
	text-align:right;
	direction:rtl;
}
.store_list li a{
	color:#000;
}
.store_list li .circle{
	width:12px; 
	height:12px;
	//float:right;
	border-radius:50%;
	border:2px solid #000;
	margin-left:4px;
}
.store_list li img{
	width:29px;
	float:left;
}
h1{
	    color: #dbdddf;
    margin-top: 17px;
}
</style>
@extends('layout.main') @section('content')

@if(session()->has('message'))
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div> 
@endif
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div> 
@endif
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4>{{trans('file.Site Setting')}} </h4>
                    </div>
                    <div class="card-body">
                        <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
                        {!! Form::open(['route' => 'setting.updateSiteSetting', 'files' => true, 'method' => 'post']) !!}
                            <div class="row">
							 <div class="col-4 form-group">
							   <label for="site_title">{{trans('file.site_title')}} *</label>
							   <input type="text" required name='site_title' id="site_title" class='form-control' value="{{$site_setting->title}}">
  							 </div>
							 
							  <div class="col-4 form-group">
							   <label for="phone_no1">{{trans('file.phone_no')}} 1 *</label>
							   <input type="text" required name='phone_no1' id="phone_no1" class='form-control' value="{{$site_setting->phone_no1}}">
  							 </div>
							  
							 <div class="col-4 form-group">
							   <label for="phone_no2">{{trans('file.phone_no')}} 2 </label>
							   <input type="text" name='phone_no2' id="phone_no2" class='form-control' value="{{$site_setting->phone_no2}}">
  							 </div>
							 
							  <div class="col-4 form-group">
							   <label for="facebook">{{trans('file.facebook')}} </label>
							   <input type="text" name='facebook' id="facebook" class='form-control' value="{{$site_setting->facebook}}">
  							 </div>
							<div class="col-4 form-group">
							   <label for="email">{{trans('file.email')}}  </label>
							   <input type="text" name='email' id="email" class='form-control' value="{{$site_setting->email}}">
  							 </div>
							 
							 <div class="col-4 form-group">
							   <label for="allow_negative">Allow Negative Sales Number</label>
							   <input type="number" name='allow_negative' id="allow_negative" class='form-control' value="{{$site_setting->allow_negative}}">
  							 </div>
							 
							 <div class="col-4 form-group">
							        <img src="{{asset('public/logo/')}}/{{$site_setting->logo}}" style="width:96px; ">
							        <label for="site_logo">{{trans('file.site_logo')}} </label>
							        <input type="file" name='site_logo' id="site_logo" class='form-control'>
							  </div>
							  
							  <div class="col-4 float-right form-group">
							     <input type="submit" value="{{trans('file.submit')}}" class="btn btn-success btn-lg">
							  </div>
							</div> 
                      </div>
                    </div>
                </div>
            </div>
        </div>
</section>

<script type="text/javascript">
    var APP_URL = {!! json_encode(url('/')) !!}
	
    $("ul#setting").siblings('a').attr('aria-expanded','true');
    $("ul#setting").addClass("show");
    $("ul#setting li").eq(5).addClass("active");

    $('.selectpicker').selectpicker({
      style: 'btn-link',
    });
  $("#color").change(function(){
	  console.log($(this).val());
	  $('nav.mCustomScrollbar,.side-navbar li a:focus, .side-navbar li a:hover, .side-navbar li a[aria-expanded="true"], .side-navbar .sidenav-header,.btn-primary, .btn-primary.active').css('background',$(this).val());
	  $('.btn-primary, .btn-primary.active').css('border','2px solid'+$(this).val()+'!important');
  
  })
  
  $("#zero_balance").click(function(){
	     var id=0; 
	    if($(this).is(':checked')==true){
			id=1; 
		}
		else{
			id=0;
		}
		jQuery.ajax({
				method : 'GET',
				url : ''+APP_URL+'/setting/zero_balance/'+id,
				success: function(response){
					
				}
          }); 
  });
</script>
@endsection
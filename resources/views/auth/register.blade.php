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
    <link rel="stylesheet" href="<?php echo asset('public/vendor/bootstrap/css/bootstrap-select.min.css') ?>" type="text/css">


    <!-- Google fonts - Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cairo">
    <!-- jQuery Circle-->
  
    <link rel="stylesheet" href="<?php echo asset('public/css/style.default.css') ?>" id="theme-stylesheet" type="text/css">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="<?php echo asset('public/css/custom.css') ?>" type="text/css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/favicon.ico">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
  </head>
  <body>
    <div class="page login-page">
      <div class="container">
        <div class="form-outer text-center d-flex align-items-center">
          <div class="form-inner">
            <div class="logo text-uppercase"><span><img src="{{asset('public/logo/logo-home.png')}}" style="width:133px;"></span></div>
            <form method="POST" action="{{ route('register') }}">
                @csrf
              <div class="form-group-material">
                <input id="register-username" type="text" name="name" required class="input-material">
                <label for="register-username" class="label-material">{{trans('file.UserName')}} *</label>
                @if ($errors->has('name'))
                    <p>
                        <strong>{{ $errors->first('name') }}</strong>
                    </p>
                @endif
              </div>
              <div class="form-group-material">
                <input id="register-email" type="email" name="email" required class="input-material">
                <label for="register-email" class="label-material">{{trans('file.Email')}} *</label>
                @if ($errors->has('email'))
                    <p>
                        <strong>{{ $errors->first('email') }}</strong>
                    </p>
                @endif
              </div>
              <div class="form-group-material">
                <input id="register-phone" type="text" name="phone" required class="input-material">
                <label for="register-phone" class="label-material">{{trans('file.Phone Number')}} *</label>
              </div>
              <div class="form-group-material">
                <input id="register-company" type="text" name="company_name" class="input-material">
                <label for="register-company" class="label-material">{{trans('file.Company Name')}}</label>
              </div>
              <div class="form-group-material">
                <select name="role_id" required class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Role*...">
                  @foreach($ezpos_role_list as $role)
                      <option value="{{$role->id}}">{{$role->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group-material" id="store-id">
                <select name="store_id" required class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Store*...">
                    @foreach($ezpos_store_list as $store)
                        <option value="{{$store->id}}">{{$store->name}}</option>
                    @endforeach
                </select>
              </div>
              <div class="form-group-material">
                <input id="password" type="password" class="input-material" name="password" required>
                <label for="passowrd" class="label-material">{{trans('file.Password')}} *</label>
                @if ($errors->has('password'))
                    <p>
                        <strong>{{ $errors->first('password') }}</strong>
                    </p>
                @endif
              </div>
              <div class="form-group-material">
                <input id="password-confirm" type="password" name="password_confirmation" required class="input-material">
                <label for="password-confirm" class="label-material">{{trans('file.Confirm Password')}} *</label>
              </div>
              <input id="register" type="submit" value="Register" class="btn btn-primary">
            </form><small>{{trans('file.Already have an account')}}? </small><a href="{{url('login')}}" class="signup">{{trans('file.LogIn')}}</a>
          </div>
          <div class="copyrights text-center">
            <p>{{trans('file.Developed By')}} <a href="http://iraq-soft.info/" class="external">IraqSoft</a></p>
          </div>
        </div>
      </div>
    </div>

<script type="text/javascript" src="<?php echo asset('public/vendor/jquery/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/vendor/popper.js/umd/popper.min.js') ?>">
</script>
<script type="text/javascript" src="<?php echo asset('public/vendor/bootstrap/js/bootstrap.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/vendor/bootstrap/js/bootstrap-select.min.js') ?>"></script>
</script>
<script type="text/javascript" src="<?php echo asset('public/vendor/jquery-validation/jquery.validate.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/js/front.js') ?>"></script>

  </body>

  <script type="text/javascript">
    $('.selectpicker').selectpicker({
      style: 'btn-link',
    });

    $('#store-id').hide();

    $('select[name="role_id"]').on('change', function() {
        if($(this).val() > 2){
            $('select[name="store_id"]').prop('required',true);
            $('#store-id').show();
        }
        else{
            $('select[name="store_id"]').prop('required',false);
            $('#store-id').hide();
        }
    });

  </script>
</html>
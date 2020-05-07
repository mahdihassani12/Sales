<?php $general_setting = DB::table('general_settings')->find(1); ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo e($general_setting->site_title); ?></title>
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
            <div class="logo text-uppercase"><span><img src="<?php echo e(asset('public/logo/logo-home.png')); ?>" style="width:133px;"></span></div>
            <?php if(session()->has('delete_message')): ?>
            <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('delete_message')); ?></div> 
            <?php endif; ?>
            <form method="POST" action="<?php echo e(route('login')); ?>">
              <?php echo csrf_field(); ?>
              <div class="form-group-material">
                <input id="login-username" type="text" name="name" required class="input-material" value="">
                <label for="login-username" class="label-material"><?php echo e(trans('file.UserName')); ?></label>
                <?php if($errors->has('name')): ?>
                    <p>
                        <strong><?php echo e($errors->first('name')); ?></strong>
                    </p>
                <?php endif; ?>
              </div>
              <div class="form-group-material">
                <input id="login-password" type="password" name="password" required class="input-material" value="">
                <label for="login-password" class="label-material"><?php echo e(trans('file.Password')); ?></label>
                <?php if($errors->has('name')): ?>
                    <p>
                        <strong><?php echo e($errors->first('name')); ?></strong>
                    </p>
                <?php endif; ?>
              </div>
              <button type="submit" class="btn btn-primary"><?php echo e(trans('file.LogIn')); ?></button>
              <!-- This should be submit button but I replaced it with <a> for demo purposes-->
            </form>
            <a href="<?php echo e(route('password.request')); ?>" class="forgot-pass"><?php echo e(trans('file.Forgot Password?')); ?></a>
            <p style="display:none"><?php echo e(trans('file.Do not have an account?')); ?></p><a href="<?php echo e(url('register')); ?>" class="signup" style="display:none"><?php echo e(trans('file.Register')); ?></a>
          </div>
          <div class="copyrights text-center">
            <p><?php echo e(trans('file.Developed By')); ?> <a href="http://iraq-soft.info/" class="external">IraqSoft</a></p>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
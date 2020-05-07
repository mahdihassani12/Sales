 <?php $__env->startSection('content'); ?>

<?php if(session()->has('message')): ?>
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message')); ?></div> 
<?php endif; ?>
<?php if(session()->has('not_permitted')): ?>
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('not_permitted')); ?></div> 
<?php endif; ?>
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4><?php echo e(trans('file.General Setting')); ?></h4>
                    </div>
                    <div class="card-body">
                        <p class="italic"><small><?php echo e(trans('file.The field labels marked with * are required input fields')); ?>.</small></p>
                        <?php echo Form::open(['route' => 'setting.generalStore', 'files' => true, 'method' => 'post']); ?>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong><?php echo e(trans('file.Site Title')); ?> *</strong></label>
                                        <input type="text" name="site_title" class="form-control" value="<?php if($ezpos_general_setting_data): ?><?php echo e($ezpos_general_setting_data->site_title); ?><?php endif; ?>" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong><?php echo e(trans('file.Site Logo')); ?></strong></label>
                                        <input type="file" name="site_logo" class="form-control" value=""/>
                                    </div>
                                    <?php if($errors->has('site_logo')): ?>
                                   <span>
                                       <strong><?php echo e($errors->first('site_logo')); ?></strong>
                                    </span>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong><?php echo e(trans('file.Currency')); ?> *</strong></label>
                                        <input type="text" name="currency" class="form-control" value="<?php if($ezpos_general_setting_data): ?><?php echo e($ezpos_general_setting_data->currency); ?><?php endif; ?>" required />
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" value="<?php echo e(trans('file.submit')); ?>" class="btn btn-primary">
                                    </div>
                                </div>
								 <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="zero_balance"><strong><?php echo e(trans('file.allow_user_zero_balance')); ?> </strong></label>
                                        <div class="form-control" style="border:none"><input type="checkbox" name="zero_balance" id="zero_balance"  <?php if($ezpos_general_setting_data): ?> <?php if($ezpos_general_setting_data->zero_balance==1): ?> <?php echo e('checked'); ?> <?php endif; ?> <?php endif; ?>  /></div>
                                    </div>
                                </div> 
                            </div>
                        <?php echo Form::close(); ?>

						<hr>
						   <h3><?php echo e(trans('file.offers')); ?> <?php echo e(trans('file.page')); ?> <?php echo e(trans('file.settings')); ?></h3>
                        <hr>
						
						<?php echo Form::open(['url' => 'setting/offerpage',  'method' => 'post']); ?>						
						<?php 
						$setting=DB::table('general_settings')->where('id',1)->get()[0];
						?>
						<div class="row">
                          <div class="col-md-6">
						    <div class="form-group">
							 <label><?php echo e(trans('file.show_paginate_scroll')); ?></label>
                             <select name="paginate_scroll" class="form-control" style="padding:0px 7px">
							   <?php if($setting->paginate_scrole=="paginate"): ?>
							      <option value="paginate" selected><?php echo e(trans('file.paginate')); ?></option>
							      <option value="scroll"><?php echo e(trans('file.scroll')); ?></option>
    						   <?php else: ?>
							     <option value="paginate"><?php echo e(trans('file.paginate')); ?></option>
							     <option value="scroll" selected><?php echo e(trans('file.scroll')); ?></option>
                               <?php endif; ?>  						   
							 </select>
							</div>
						  </div>
						   <div class="col-md-6">
						      <div class="form-group">
							 <label><?php echo e(trans('file.item_number_per_row')); ?></label>
							  <select name="item_num" class="form-control" style="padding:0px 7px;"> 
							     <option value="1" <?php if($setting->offers_item_number=="1"): echo "selected"; endif;?>>1</option>
							     <option value="2" <?php if($setting->offers_item_number=="2"): echo "selected"; endif;?>>2</option>
							     <option value="4" <?php if($setting->offers_item_number=="4"): echo "selected"; endif;?>>4</option>
							     <option value="6" <?php if($setting->offers_item_number=="6"): echo "selected"; endif;?>>6</option>
							     <option value="8" <?php if($setting->offers_item_number=="8"): echo "selected"; endif;?>>8</option>
							   </select>
							</div>
						   </div>
						   <div class="col-md-6">
                           <div class="form-group">
							  <input type="submit" value="<?php echo e(trans('file.submit')); ?>" class="btn btn-primary">
						   </div>
                         </div>						   
						</div>  
						<?php echo Form::close(); ?>

					<?php echo Form::open(['url' => 'setting/changeDefaultColor',  'method' => 'post']); ?>

                       <div class="row" style="display:none">						
						<div class="col-md-6">
								<div class="form-group">
									<label><strong><?php echo e(trans('file.default_color')); ?> *</strong></label>
									<input type="color" name="color" class="form-control" value="#fff" required style="padding:0px;height:35px" id="color"/>
								</div>
								<div class="form-group">
									<input type="submit" value="<?php echo e(trans('file.chanage_color')); ?>" class="btn btn-primary">
								</div>
                            </div>
						  </div>	
						  <?php echo Form::close(); ?>	
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    var APP_URL = <?php echo json_encode(url('/')); ?>

	
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
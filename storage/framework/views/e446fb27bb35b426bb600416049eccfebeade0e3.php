<?php $__env->startSection('content'); ?>
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4><?php echo e(trans('file.add')); ?> <?php echo e(trans('file.company')); ?></h4>
                    </div>
                    <div class="card-body">
                        <p class="italic"><small><?php echo e(trans('file.The field labels marked with * are required input fields')); ?>.</small></p>
                       <?php echo Form::open(['url' => 'company/store', 'method' => 'get', 'class' => 'form-horizontal main_form form-whitout-modal', 'id'=> 'add_passenger_form', 'enctype'=> 'multipart/form-data']); ?> 
                          <div class="row"> 
						   <div class="col-md-6">
	                            <div class="form-group">
	                                <label><strong><?php echo e(trans('file.company')); ?> <?php echo e(trans('file.name')); ?> *</strong> </label>
	                                <input type="text" name="name" required class="form-control">
                                    <?php if($errors->has('name')): ?>
                                    <span>
                                       <strong><?php echo e($errors->first('name')); ?></strong>
                                    </span>
                                    <?php endif; ?>
	                            </div>
                            </div>
						 
						     <div class="col-md-6">
	                            <div class="form-group">
	                                <label><strong><?php echo e(trans('file.address')); ?>  </strong> </label>
	                                <input type="text" name="address"  class="form-control">
                                    <?php if($errors->has('address')): ?>
                                    <span>
                                       <strong><?php echo e($errors->first('address')); ?></strong>
                                    </span>
                                    <?php endif; ?>
	                            </div>
                            </div>
							 <div class="col-md-6">
	                            <div class="form-group">
	                                <label><strong><?php echo e(trans('file.username')); ?>  *</strong> </label>
	                                <input type="text" name="username" required class="form-control">
                                    <?php if($errors->has('username')): ?>
                                    <span>
                                       <strong><?php echo e($errors->first('username')); ?> </strong>
                                    </span>
                                    <?php endif; ?>
	                            </div>
                            </div>
							<div class="col-md-6">
	                            <div class="form-group">
	                                <label><strong><?php echo e(trans('file.password')); ?> *</strong> </label>
	                                <input type="password" name="password" required class="form-control">
                                    <?php if($errors->has('password')): ?>
                                    <span>
                                       <strong><?php echo e($errors->first('password')); ?></strong>
                                    </span>
                                    <?php endif; ?>
	                            </div>
                            </div>
							<div class="col-md-6">
	                            <div class="form-group">
	                                <label><strong><?php echo e(trans('file.mail')); ?>  *</strong> </label>
	                                <input type="text" name="mail" required class="form-control">
                                    <?php if($errors->has('mail')): ?>
                                    <span>
                                       <strong><?php echo e($errors->first('mail')); ?></strong>
                                    </span>
                                    <?php endif; ?>
	                            </div>
                            </div>
							<div class="col-md-6">
	                            <div class="form-group">
	                                <label><strong><?php echo e(trans('file.phone')); ?> </strong> </label>
	                                <input type="text" name="phone"  class="form-control">
                                    <?php if($errors->has('phone')): ?>
                                    <span>
                                       <strong><?php echo e($errors->first('phone')); ?></strong>
                                    </span>
                                    <?php endif; ?>
	                            </div>
                            </div>
							<div class="col-md-6">
	                            <div class="form-group">
	                                <label><strong><?php echo e(trans('file.extra')); ?> </strong> </label>
	                                <input type="text" name="extra1"  class="form-control">
                                    <?php if($errors->has('name')): ?>
                                    <span>
                                       <strong><?php echo e($errors->first('extra1')); ?></strong>
                                    </span>
                                    <?php endif; ?>
	                            </div>
                            </div>
							<div class="col-md-6">
	                            <div class="form-group">
	                                <label><strong><?php echo e(trans('file.extra')); ?></strong> </label>
	                                <input type="text" name="extra2"  class="form-control">
                                    <?php if($errors->has('extra2')): ?>
                                    <span>
                                       <strong><?php echo e($errors->first('extra2')); ?></strong>
                                    </span>
                                    <?php endif; ?>
	                            </div>
                            </div>
							<div class="col-md-6">
	                            <div class="form-group">
	                                <label><strong><?php echo e(trans('file.extra')); ?></strong> </label>
	                                <input type="text" name="extra3"  class="form-control">
                                    <?php if($errors->has('extra3')): ?>
                                    <span>
                                       <strong><?php echo e($errors->first('extra3')); ?></strong>
                                    </span>
                                    <?php endif; ?>
	                            </div>
                            </div>
							<div class="col-md-6">
							 <div class="form-group">
							 <label><strong style="visibility:hidden">s</strong> </label>
                               <input type="submit" value="<?php echo e(trans('file.submit')); ?>" class="btn form-control btn-primary" style="display:block; width:120px;">
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

    $("ul#product").siblings('a').attr('aria-expanded','true');
    $("ul#product").addClass("show");
    $("ul#product li").eq(2).addClass("active");

    $("#digital").hide();
    $("#promotion_price").hide();
    $("#start_date").hide();
    $("#last_date").hide();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

	$('#genbutton').on("click", function(){
      $.get('gencode', function(data){
        $("input[name='code']").val(data);
      });
    });

    $('.selectpicker').selectpicker({
	  style: 'btn-link',
	});

    tinymce.init({
      selector: 'textarea',
      height: 200,
      plugins: [
        'advlist autolink lists link image charmap print preview anchor textcolor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table contextmenu paste code wordcount'
      ],
      toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat',
      branding:false
    });

    $('select[name="type"]').on('change', function() {
        if($(this).val() == 'digital'){
            $("input[name='cost']").prop('required',false);
            $("select[name='unit_id']").prop('required',false);
            $("input[name='file']").prop('required',true);
            $("#cost").hide();
            $("#unit").hide();
            $("#alert-qty").hide();
            $("#digital").show();
        }
        else if($(this).val() == 'standard'){
            $("input[name='cost']").prop('required',true);
            $("select[name='unit_id']").prop('required',true);
            $("input[name='file']").prop('required',false);
            $("#cost").show();
            $("#unit").show();
            $("#alert-qty").show();
            $("#digital").hide();
        }
    });


    $( "#promotion" ).on( "change", function() {
        if ($(this).is(':checked')) {
            $("#starting_date").val($.datepicker.formatDate('dd-mm-yy', new Date()));
            $("#promotion_price").show();
            $("#start_date").show();
            $("#last_date").show();
        } 
        else {
            $("#promotion_price").hide();
            $("#start_date").hide();
            $("#last_date").hide();
        }
    });

    var starting_date = $('#starting_date');
    starting_date.datepicker({
     format: "dd-mm-yyyy",
     startDate: "<?php echo date('d-m-Y'); ?>",
     autoclose: true,
     todayHighlight: true
     });

    var ending_date = $('#ending_date');
    ending_date.datepicker({
     format: "dd-mm-yyyy",
     startDate: "<?php echo date('d-m-Y'); ?>",
     autoclose: true,
     todayHighlight: true
     });

    $('#product-form').on('submit',function(e){
        var product_code = $("input[name='code']").val();
        var barcode_symbology = $('select[name="barcode_symbology"]').val();
        var exp = /^\d+$/;

        if(!(product_code.match(exp)) && (barcode_symbology == 'UPCA' || barcode_symbology == 'UPCE' || barcode_symbology == 'EAN8' || barcode_symbology == 'EAN13') ) {
            alert('Product code must be numeric.');
            e.preventDefault();
        }
        else if(product_code.match(exp)) {
            if(barcode_symbology == 'UPCA' && product_code.length > 11){
                alert('Product code length must be less than 12');
                e.preventDefault();
            }
            else if(barcode_symbology == 'EAN8' && product_code.length > 7){
                alert('Product code length must be less than 8');
                e.preventDefault();
            }
            else if(barcode_symbology == 'EAN13' && product_code.length > 12){
                alert('Product code length must be less than 13');
                e.preventDefault();
            }
        }
    });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
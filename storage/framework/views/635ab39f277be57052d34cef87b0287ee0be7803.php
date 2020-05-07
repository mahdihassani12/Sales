<?php $__env->startSection('content'); ?>
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4><?php echo e(trans('file.quick_add_product')); ?></h4>
                    </div>
                    <div class="card-body">
                      <div class="checkbox_labels">
                    	  <label>	 
						   الاسم الانكليزي <input type="radio" name="columnType" value="productName">	
						 </label> 
                        
                                                <label>	 
						   الاسم بالعربي<input type="radio" name="columnType" value="productArabicName">	
						 </label> 
						 
						 <label>
						   رمز الباركود<input type="radio" name="columnType" value="productCode">	
						  </label> 
                       </div>
                       <div class="importtextarea col-md-6">
                    	  	 <textarea id="excel_input_text" rows="6" class="form-control"></textarea> <br>
                    	</div>
                    	  <h2 class="total_rows"><?php echo e(trans('file.total_row')); ?> <span>0</span></h2>

                    	  <div class="input_fields_title row"> 
							  <h3 class="rowTitle col-md-4">الاسم الانكليزي</h3>
                                                           <h3 class="rowTitle col-md-4">الاسم بالعربي </h3>
							  <h3 class="rowTitle col-md-4">رمز الباركود</h3>
							  
							</div>
                           <form method="get" action="<?php echo e(asset('product/save_excel_data')); ?>">
							<div class="row">
							  <div class="col-md-4 productNameInputFormArea dataarea" filled="0" >
							  	
							  </div>
							  <div class="col-md-4 productArabicNameInputFormArea dataarea" filled="0">
							  	
							  </div>
							  <div class="col-md-4 productCodeInputFormArea dataarea" filled="0">
							  	
							  </div>
							
							</div>
							<div class="save_form">
							<input type="submit" class="btn" name="" value="<?php echo e(trans('file.save')); ?> +">
							</div>
						  </form>

                    </div>
                 </div> 
                </div>
             </div> 
         </div>
    </section>              	

<style type="text/css">
	input[type="text"]{
		width: 100%;
	}
	label{
		margin-left: 23px;
	}
	label input{
		margin-right:4px;
	}
	.dataarea, .rowTitle{
		/*width: 15%;*/
		/*margin-right:10px;		*/
		display: inline-block;
	}
	.total_rows > span{
		margin-right: 20px;
	}
	.save_form{
		margin-top: 79px;
        border-top: 1px solid #d4d1d1;
		padding-top: 10px; 
	}
	.save_form input{
		background-color: #13cc13;
        color: #fff;
        font-weight: bold;
	}
</style>

<script>


  $("#excel_input_text").blur(function(){
  	var input = new Array();
  	var columnType=$('input[name="columnType"]:checked').val();
  	var allTxts=$(this).val();
    
    if(!columnType){
    	return false; 
    }
   if(allTxts==""){
   	return false; 
   }
  	var datafor="";
  	var feild="";
  	if(columnType=="productName"){
      datafor="productNameInputFormArea";
      feild='txt_product_name';
  	} 
  	else if(columnType=="productCode"){
       datafor="productCodeInputFormArea";
       feild='txt_product_code';
  	}
	else if(columnType=="productArabicName"){
       datafor="productArabicNameInputFormArea";
       feild='txt_product_arabicName';
  	}
  	
    
    var has_data= $('.'+datafor).attr('filled');
  	var rows = allTxts.split("\n");


  	if(has_data =="0"){
      $('.'+datafor).attr('filled','1')
  	}

  	else{
        $('.'+datafor).html("");
  	}
    
    var count=0;
    for(var i=0; i<rows.length; i++){
      //$('.txt'+i).val(rows[i]);
      input[i]=$("<input>");
      input[i].addClass(feild+i+' form-control');
      input[i].val(rows[i]);
      input[i].attr('name',feild+'[]');
      input[i].css("width",'100%');
      
       $("."+datafor).append(input[i]);
      count++; 
    }

    $(".total_rows span").text(count);
  });

  $('input[name="columnType"]').click(function(){
  	$("#excel_input_text").val('');
  	
  })
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
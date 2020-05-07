 <?php $__env->startSection('content'); ?>
<?php if(session()->has('create_message')): ?>
    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('create_message')); ?></div> 
<?php endif; ?>
<?php if(session()->has('edit_message')): ?>
    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('edit_message')); ?></div> 
<?php endif; ?>
<?php if(session()->has('import_message')): ?>
    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('import_message')); ?></div> 
<?php endif; ?>
<?php if(session()->has('not_permitted')): ?>
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('not_permitted')); ?></div> 
<?php endif; ?>
<?php if(session()->has('message')): ?>
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message')); ?></div> 
<?php endif; ?>

<section>
    
    <div class="table-responsive">
	    <button class="btn btn-success" data-toggle="modal" data-target="#addBarcode"><?php echo e(trans('file.add_pincode')); ?></button>
        <table id="product-data-table" class="table table-striped rwd-table" data-autogen-headers="true">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th><?php echo e(trans('file.pincode_no')); ?></th>
                    <th><?php echo e(trans('file.date')); ?></th>
                    <th><?php echo e(trans('file.time')); ?></th>
                    <th><?php echo e(trans('file.amount')); ?></th>
                    <th><?php echo e(trans('file.note')); ?></th>
                    <th><?php echo e(trans('file.user_inserted')); ?></th>
                    <th><?php echo e(trans('file.user_owner')); ?></th>
                    <th><?php echo e(trans('file.software_name')); ?></th>
                    <th><?php echo e(trans('file.status_done')); ?></th>
                    <th><?php echo e(trans('file.status_used')); ?></th>
                    <th class="not-exported"><?php echo e(trans('file.action')); ?></th>
                </tr>
            </thead>
            <tbody>
			   <?php if($data['pincode']): ?>
                <?php $__currentLoopData = $data['pincode']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pn): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
                <tr class="company-link" >
                    <td></td>
					<td><?php echo e($pn->number); ?></td>
					<td><?php echo e($pn->date); ?></td>
					<td><?php echo e($pn->time); ?></td>
					<td><?php echo e($pn->amount); ?></td>
					<td><?php echo e($pn->notes); ?></td>
					<td><?php echo e($pn->user_added); ?></td>
					<td><?php echo e($pn->user_owner); ?></td>
					<td><?php echo e($pn->software_name); ?></td>
					<td>
					   <select class="status_change" type="done" pin_id="<?php echo e($pn->id); ?>">
					     <option value="1" <?php if($pn->status_done=='1'){echo "selected";} ?>><?php echo e(trans('file.active')); ?></option>
					     <option value="0" <?php if($pn->status_done=='0'){echo "selected";} ?>><?php echo e(trans('file.inactive')); ?></option>
					   </select>
					</td>
					<td>
					    <select class="status_change" type="used" pin_id="<?php echo e($pn->id); ?>">
					      <option value="1" <?php if($pn->status_used=='1'){echo "selected";} ?>><?php echo e(trans('file.active')); ?></option>
					      <option value="0" <?php if($pn->status_used=='0'){echo "selected";} ?>><?php echo e(trans('file.inactive')); ?></option>
					   </select>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo e(trans('file.action')); ?>

                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                
								<li>
                                    <a href="#editPincode" data-toggle="modal" class="btn btn-link edit_pin" pin_id="<?php echo e($pn->id); ?>"><i class="fa fa-edit"></i> <?php echo e(trans('file.edit')); ?></a>
                                </li>
								<li class="divider"></li>
								
								<?php echo e(Form::open(['url' => ['pincode/delete', $pn->id], 'method' => 'get'] )); ?>

                                <li>
                                    <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="fa fa-trash"></i> <?php echo e(trans('file.delete')); ?></button>
                                </li>
                                <?php echo e(Form::close()); ?>

                            </ul>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<?php else: ?>
                <tr><td><?php echo e(trans('file.not_found')); ?></td></tr>					
				<?php endif; ?>
				
            </tbody>
        </table>
    </div>
</section>

<div id="addBarcode" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
      <div class="modal-content">
        <?php echo Form::open(['route' => 'pincode.create', 'method' => 'post', 'files' => true]); ?>

        <div class="modal-header">
          <h5 id="exampleModalLabel" class="modal-title"><?php echo e(trans('file.insert')); ?> <?php echo e(trans('file.pincode')); ?></h5>
          <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
             <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label><?php echo e(trans('file.pincode_no')); ?> *</label>
                        <input type="number" class="form-control" name="pincode_no" >
                    </div>
                </div>
				  <div class="col-md-6">
                    <div class="form-group">
                        <label><?php echo e(trans('file.amount')); ?> * </label>
                        <input type="number" class="form-control" name="amount">
                    </div>
                </div>
				  <div class="col-md-6">
                    <div class="form-group">
                        <label><?php echo e(trans('file.user_owner')); ?> </label>
                        <input type="text" class="form-control" name="user_owner">
                    </div>
                </div>
				 <div class="col-md-6">
                    <div class="form-group">
                        <label><?php echo e(trans('file.software_name')); ?> </label>
                        <input type="text" class="form-control" name="software_name">
                    </div>
                </div>
				 <div class="col-md-6">
                    <div class="form-group">
                        <label><?php echo e(trans('file.status_done')); ?> </label>
                        <select class="form-control" name="status_done">
						   <option value="1"><?php echo e(trans('file.active')); ?></option>
						   <option value="0"><?php echo e(trans('file.inactive')); ?></option>
						</select>
                    </div>
                </div>
				 <div class="col-md-6">
                    <div class="form-group">
                        <label><?php echo e(trans('file.status_used')); ?> </label>
                        <select class="form-control" name="status_used">
						   <option value="1"><?php echo e(trans('file.active')); ?></option>
						   <option value="0"><?php echo e(trans('file.inactive')); ?></option>
						</select>
                    </div>
                </div>
				
				 <div class="col-md-12">
                    <div class="form-group">
                        <label><?php echo e(trans('file.note')); ?> </label>
                        <textarea class="form-control" name="note"></textarea>
                    </div>
                </div>
           </div>           
            <?php echo e(Form::submit('Submit', ['class' => 'btn btn-primary'])); ?>

        </div>
        <?php echo Form::close(); ?>

      </div>
    </div>
</div>

<div id="editPincode" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 id="exampleModalLabel" class="modal-title"><?php echo e(trans('file.edit')); ?> <?php echo e(trans('file.pincode')); ?> &nbsp;&nbsp;</h5>
          <button type="button" id="close-btn" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
        </div>
        <div id="product-content" class="modal-body">
			
        </div>
      </div>
    </div>
</div>
<style>
  table.dataTable{
   width:100% !important;
 }
</style>
<script type="text/javascript">
     var APP_URL = <?php echo json_encode(url('/')); ?>

	 
	 $(".edit_pin").click(function(){
		 var pinid=$(this).attr('pin_id');
		 $.ajax({
			 url:APP_URL+'/pincode/edit/'+pinid,
			 type:'get',
			 success:function(response){
				 $("#editPincode .modal-body").html(response);
			 },
			 error:function(){
				 
			 }
		 })
	 });
	 
	$(".status_change").change(function(){
		var type=$(this).attr('type');
		var pin_id=$(this).attr('pin_id');
		var value=$(this).val();
		
		window.location.assign(APP_URL+'/pincode/change_status?type='+type+'&pinid='+pin_id+'&value='+value);
	}) 
	 
    $("ul#product").siblings('a').attr('aria-expanded','true');
    $("ul#product").addClass("show");
    $("ul#product li").eq(1).addClass("active");

	function confirmDelete() {
	    if (confirm("Are you sure want to delete?")) {
	        return true;
	    }
	    return false;
	}

    var store = [];
    var qty = [];
    var htmltext;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $( "#select_all" ).on( "change", function() {
        if ($(this).is(':checked')) {
            $("tbody input[type='checkbox']").prop('checked', true);
        } 
        else {
            $("tbody input[type='checkbox']").prop('checked', false);
        }
    });
    
    $("tr.product-link td:not(:first-child, :last-child)").on("click", function(){
        var product = $(this).parent().data('product');
        var imagedata = $(this).parent().data('imagedata');
        htmltext = '';
        htmltext = '<p><strong><?php echo e(trans("file.Type")); ?>: </strong>'+product[0].toUpperCase()+'</p><p><strong><?php echo e(trans("file.name")); ?>: </strong>'+product[1]+'</p><p><strong><?php echo e(trans("file.Code")); ?>: </strong>'+product[2]+ '</p><strong><?php echo e(trans("file.Barcode")); ?>: </strong><img src="data:image/png;base64,'+imagedata+'" alt="barcode" /></p><p><strong><?php echo e(trans("file.Brand")); ?>: </strong>'+product[3]+'</p><p><strong><?php echo e(trans("file.category")); ?>: </strong>'+product[4]+'</p><p><strong><?php echo e(trans("file.Unit")); ?>: </strong>'+product[5]+'</p><p><strong><?php echo e(trans("file.Quantity")); ?>: </strong>'+product[13]+'</p><p><strong><?php echo e(trans("file.Alert")); ?> <?php echo e(trans("file.Quantity")); ?>: </strong>'+product[10]+'</p><p><strong><?php echo e(trans("file.Cost")); ?>: </strong>'+product[6]+'</p><p><strong><?php echo e(trans("file.Price")); ?>: </strong>'+product[7]+'</p><p><strong><?php echo e(trans("file.Tax")); ?>: </strong>'+product[8]+'</p><p><strong><?php echo e(trans("file.Tax")); ?> <?php echo e(trans("file.Method")); ?>: </strong>'+product[9]+'</p><p><strong><?php echo e(trans("file.product details")); ?>: </strong></p>'+product[11];

        $.get('products/product_store/' + product[12], function(data) {
            $(".product-store-list thead").remove();
            $(".product-store-list tbody").remove();
            
            store = data[0];
            qty = data[1];
            if(store.length != 0){
                var newHead = $("<thead>");
                var newBody = $("<tbody>");
                var newRow = $("<tr>");
                newRow.append('<th><?php echo e(trans("file.Store")); ?></th><th><?php echo e(trans("file.Quantity")); ?></th>');
                newHead.append(newRow);
                $.each(store, function(index){
                    var newRow = $("<tr>");
                    var cols = '';
                    cols += '<td>' + store[index] + '</td>';
                    cols += '<td>' + qty[index] + '</td>';

                    newRow.append(cols);
                    newBody.append(newRow);
                    $("table.product-store-list").append(newHead);
                    $("table.product-store-list").append(newBody);
                });
            }
        });

        $('#product-content').html(htmltext);
        $('#product-details').modal('show');
    });

    $("#print-btn").on("click", function(){
          var divToPrint=document.getElementById('product-details');
          var newWin=window.open('','Print-Window');
          newWin.document.open();
          newWin.document.write('<style type="text/css">@media  print { #print-btn { display: none } #close-btn { display: none } }</style><body onload="window.print()">'+divToPrint.innerHTML+'</body>');
          newWin.document.close();
          setTimeout(function(){newWin.close();},10);
    });

    $('#product-data-table').DataTable( {
        "order": [],
        'columnDefs': [
            {
                "orderable": false,
                'targets': [0, 1, 9]
            },
            {
                'checkboxes': {
                   'selectRow': true
                },
                'targets': 0
            }
        ],
        'select': { style: 'multi',  selector: 'td:first-child'},
        'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
        dom: 'Blfrtip',
        buttons: [
            {
                extend: 'pdf',
                exportOptions: {
                    columns: ':visible:not(.not-exported)',
                    rows: ':visible',
                    stripHtml: false
                },
                customize: function(doc) {
                    for (var i = 1; i < doc.content[1].table.body.length; i++) {
                        if (doc.content[1].table.body[i][0].text.indexOf('<img src=') !== -1) {
                            var imagehtml = doc.content[1].table.body[i][0].text;
                            var regex = /<img.*?src=['"](.*?)['"]/;
                            var src = regex.exec(imagehtml)[1];
                            var tempImage = new Image();
                            tempImage.src = src;
                            var canvas = document.createElement("canvas");
                            canvas.width = tempImage.width;
                            canvas.height = tempImage.height;
                            var ctx = canvas.getContext("2d");
                            ctx.drawImage(tempImage, 0, 0);
                            var imagedata = canvas.toDataURL("image/png");
                            delete doc.content[1].table.body[i][0].text;
                            doc.content[1].table.body[i][0].image = imagedata;
                            doc.content[1].table.body[i][0].fit = [30, 30];
                        }
                    }
                },
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: ':visible:not(.not-exported)',
                    rows: ':visible',
                    format: {
                        body: function ( data, row, column, node ) {
                            if (column === 0 && (data.indexOf('<img src=') !== -1)) {
                                var regex = /<img.*?src=['"](.*?)['"]/;
                                data = regex.exec(data)[1];                 
                            }
                            return data;
                        }
                    }
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible:not(.not-exported)',
                    rows: ':visible',
                    stripHtml: false
                }
            },
            {
                extend: 'colvis',
                columns: ':gt(0)'
            },
        ],
    } );

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
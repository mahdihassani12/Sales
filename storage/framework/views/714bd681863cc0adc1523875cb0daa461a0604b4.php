<?php $__env->startSection('content'); ?>
<?php if($errors->has('name')): ?>
<div class="alert alert-danger alert-dismissible text-center">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e($errors->first('name')); ?></div>
<?php endif; ?>
<?php if(session()->has('message')): ?>
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message')); ?></div> 
<?php endif; ?>
<?php if(session()->has('not_permitted')): ?>
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('not_permitted')); ?></div> 
<?php endif; ?>

<section>
    <div class="container-fluid">
        <a href="#" data-toggle="modal" data-target="#createModal" class="btn btn-info"><i class="fa fa-plus"></i> <?php echo e(trans('file.add')); ?> <?php echo e(trans('file.Store')); ?></a>
    </div>
    <div class="table-responsive">
        <table id="store-table" class="table table-hover rwd-table" data-autogen-headers="true" >
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th><?php echo e(trans('file.Store')); ?></th>
                    <th><?php echo e(trans('file.Phone Number')); ?></th>
                    <th><?php echo e(trans('file.Email')); ?></th>                 
                    <th><?php echo e(trans('file.store_category')); ?></th>                 
                    <th><?php echo e(trans('file.Address')); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $data['stores']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                 <?php
                    $note_sale_store= DB::table('sales')->where('store_id',$store->id)->whereDate('sales.date',date('Y-m-d'))->count();
                     if($note_sale_store==0):
                 ?>
                <tr>
                    <td><?php echo e($key); ?></td>
                    <td><?php echo e($store->name); ?></td>
                    <td><?php echo e($store->phone); ?></td>
                    <td><?php echo e($store->email); ?></td>
                    <td><?php
                        if($store->store_category_id !=null):
                          $cats=explode("-", $store->store_category_id);
                             $all_category="";
                             for($i=0; $i<count($cats); $i++ ):
                             $all_category .= DB::table('store_category')->where('id',$cats[$i])->first()->name." , "; 
                           endfor;
                           echo rtrim($all_category,", ");
                         endif;   
                        ?></td>
                    <td><?php echo e($store->address); ?></td>
                   
                </tr>
            <?php endif;?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</section>


<style>
 .mobile-table td[data-title]:before{
     padding-left:10px;
     padding-right:10px;
 }
</style>
<script type="text/javascript">
 var APP_URL = <?php echo json_encode(url('/')); ?>


  $("ul#setting").siblings('a').attr('aria-expanded','true');
    $("ul#setting").addClass("show");
    $("ul#setting li").eq(1).addClass("active");

  function confirmDelete() {
      if (confirm("Are you sure want to delete?")) {
          return true;
      }
      return false;
  }

    $(document).ready(function() {
        
        $(document).on('click',".open-EditstoreDialog", function() {
          alert("some");
            var url = "/store/";
            var id = $(this).data('id').toString();
            url =APP_URL+ url.concat(id).concat("/edit");

            $.get(url, function(data) {
                $("input[name='name']").val(data['name']);
                $("input[name='phone']").val(data['phone']);
                $("input[name='email']").val(data['email']);
                $("textarea[name='address']").val(data['address']);
              $("input[name='store_id']").val(data['id']);
              // tonight changes
              // var categories=data['store_category_id'];
              // var seperated_cat='';
              // if(categories!=null && categories!="null" && categories!=""){
              //   seperated_cat=categories.split('-');
              // }
              // $(".select_store_category_class").val(seperated_cat);
              // $('.selectpicker').selectpicker('refresh');
            });
        });
  });

  $('#store-table').DataTable( {
        "order": [],
        'columnDefs': [
            {
                "orderable": false,
                'targets': [0, 4]
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
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
            },
            {
                extend: 'colvis',
                columns: ':gt(0)'
            },
        ],
    } );

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

$("#export").on("click", function(e){
    e.preventDefault();
    var store = [];
    $(':checkbox:checked').each(function(i){
      store[i] = $(this).val();
    });
    $.ajax({
       type:'POST',
       url:'/exportstore',
       data:{

            storeArray: store
        },
       success:function(data){
        alert('Exported to CSV file successfully! Click Ok to download file');
        window.location.href = data;
       }
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
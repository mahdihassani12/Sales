 <?php $__env->startSection('content'); ?>
<?php if($errors->has('card_no')): ?>
<div class="alert alert-danger alert-dismissible text-center">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e($errors->first('card_no')); ?></div>
<?php endif; ?>
<?php if(session()->has('message')): ?>
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('message')); ?></div> 
<?php endif; ?>
<?php if(session()->has('not_permitted')): ?>
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo e(session()->get('not_permitted')); ?></div> 
<?php endif; ?>

<section>
    <div class="container-fluid">
        <button class="btn btn-info" data-toggle="modal" data-target="#gift_card-modal"><i class="fa fa-plus"></i> <?php echo e(trans('file.add')); ?> <?php echo e(trans('file.Gift Card')); ?> </button>
    </div>
    <div class="table-responsive">
        <table id="gift_card-table" class="table table-hover">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th><?php echo e(trans('file.Card')); ?> No</th>
                    <th><?php echo e(trans('file.customer')); ?></th>
                    <th><?php echo e(trans('file.Amount')); ?></th>
                    <th><?php echo e(trans('file.Expense')); ?></th>
                    <th><?php echo e(trans('file.Balance')); ?></th>
                    <th><?php echo e(trans('file.Created By')); ?></th>
                    <th><?php echo e(trans('file.Expired Date')); ?></th>
                    <th class="not-exported"><?php echo e(trans('file.action')); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $ezpos_gift_card_all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$gift_card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php 
                    $created_by = DB::table('users')->find($gift_card->created_by);
                ?>
                <tr>
                    <td><?php echo e($key); ?></td>
                    <td><?php echo e($gift_card->card_no); ?></td>
                    <?php if($gift_card->customer_id): ?>
                    <?php $customer = DB::table('customers')->find($gift_card->customer_id); ?>
                    <td><?php echo e($customer->name); ?></td>
                    <?php else: ?>
                    <?php $user = DB::table('users')->find($gift_card->user_id); ?>
                    <td><?php echo e($user->name); ?></td>
                    <?php endif; ?>
                    <td><?php echo e($gift_card->amount); ?></td>
                    <td><?php echo e($gift_card->expense); ?></td>
                    <td><?php echo e($gift_card->amount - $gift_card->expense); ?></td>
                    <td><?php echo e($created_by->name); ?></td>
                    <?php if($gift_card->expired_date >= date("Y-m-d")): ?>
                      <td><div class="badge badge-success"><?php echo e(date('d-m-Y',strtotime($gift_card->expired_date))); ?></div></td>
                    <?php else: ?>
                      <td><div class="badge badge-danger"><?php echo e(date('d-m-Y',strtotime($gift_card->expired_date))); ?></div></td>
                    <?php endif; ?>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo e(trans('file.action')); ?>

                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                <li><button type="button" data-id="<?php echo e($gift_card->id); ?>" class="open-Edit_gift_card_Dialog btn btn-link" data-toggle="modal" data-target="#editModal"><i class="fa fa-edit"></i> <?php echo e(trans('file.edit')); ?></button></li>
                                <li><button type="button" data-id="<?php echo e($gift_card->id); ?>" class="recharge btn btn-link" data-toggle="modal" data-target="#rechargeModal"><i class="fa fa-money"></i> <?php echo e(trans('file.Recharge')); ?></button></li>
                                <li class="divider"></li>
                                <?php echo e(Form::open(['route' => ['gift_cards.destroy', $gift_card->id], 'method' => 'DELETE'] )); ?>

                                <li>
                                    <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="fa fa-trash"></i> <?php echo e(trans('file.delete')); ?></button>
                                </li>
                                <?php echo e(Form::close()); ?>

                            </ul>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
            <tfoot class="tfoot active">
                <th></th>
                <th><?php echo e(trans('file.Total')); ?></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tfoot>
        </table>
    </div>
</section>

<div id="gift_card-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="exampleModalLabel" class="modal-title"><?php echo e(trans('file.add')); ?> <?php echo e(trans('file.Gift Card')); ?></h5>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
              <p class="italic"><small><?php echo e(trans('file.The field labels marked with * are required input fields')); ?>.</small></p>
                <?php echo Form::open(['route' => 'gift_cards.store', 'method' => 'post']); ?>

                <?php 
                  $ezpos_store_list = DB::table('stores')->where('is_active', true)->get();
                ?>
                  <div class="form-group">
                      <label><strong><?php echo e(trans('file.Card')); ?> No *</strong></label>
                      <div class="input-group">
                          <?php echo e(Form::text('card_no',null,array('required' => 'required', 'class' => 'form-control'))); ?>

                          <div class="input-group-append">
                              <button type="button" class="btn btn-default genbutton"><?php echo e(trans('file.Generate')); ?></button>
                          </div>
                      </div>
                  </div>
                  <div class="form-group">
                      <label><strong><?php echo e(trans('file.Amount')); ?> *</strong></label>
                      <input type="number" name="amount" step="any" required class="form-control">
                  </div>
                  <div class="form-group">
                      <label><strong><?php echo e(trans('file.User')); ?> <?php echo e(trans('file.List')); ?></strong></label>&nbsp;
                      <input type="checkbox" id="user" name="user" value="1">
                  </div>
                  <div class="form-group user_list">
                      <label><strong><?php echo e(trans('file.User')); ?> *</strong></label>
                      <select name="user_id" class="selectpicker form-control" required data-live-search="true" data-live-search-style="begins" title="Select User...">
                          <?php $__currentLoopData = $ezpos_user_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <option value="<?php echo e($user->id); ?>"><?php echo e($user->name .' ('.$user->email.')'); ?></option>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </select>
                  </div>
                  <div class="form-group customer_list">
                      <label><strong><?php echo e(trans('file.customer')); ?> *</strong></label>
                      <select name="customer_id" class="selectpicker form-control" required data-live-search="true" data-live-search-style="begins" title="Select Customer...">
                          <?php $__currentLoopData = $ezpos_customer_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <option value="<?php echo e($customer->id); ?>"><?php echo e($customer->name .' ('.$customer->phone_number.')'); ?></option>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </select>
                  </div>
                  <div class="form-group">
                      <label><strong><?php echo e(trans('file.Expired Date')); ?></strong></label>
                      <input type="text" id="expired_date" name="expired_date" class="form-control">
                  </div>
                  <div class="form-group">
                      <button type="submit" class="btn btn-primary"><?php echo e(trans('file.submit')); ?></button>
                  </div>
                <?php echo e(Form::close()); ?>

            </div>
        </div>
    </div>
</div>

<div id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
  <div role="document" class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 id="exampleModalLabel" class="modal-title"><?php echo e(trans('file.update')); ?> <?php echo e(trans('file.Gift Card')); ?></h5>
              <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
          </div>
          <div class="modal-body">
            <p class="italic"><small><?php echo e(trans('file.The field labels marked with * are required input fields')); ?>.</small></p>
              <?php echo Form::open(['route' => ['gift_cards.update', 1], 'method' => 'put']); ?>

              <?php 
                $ezpos_store_list = DB::table('stores')->where('is_active', true)->get();
              ?>
                <div class="form-group">
                    <input type="hidden" name="gift_card_id">
                    <label><strong><?php echo e(trans('file.Card')); ?> No *</strong></label>
                    <div class="input-group">
                        <?php echo e(Form::text('card_no_edit',null,array('required' => 'required', 'class' => 'form-control'))); ?>

                        <div class="input-group-append">
                            <button type="button" class="btn btn-default genbutton"><?php echo e(trans('file.Generate')); ?></button>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label><strong><?php echo e(trans('file.Amount')); ?> *</strong></label>
                    <input type="number" name="amount_edit" step="any" required class="form-control">
                </div>
                <div class="form-group">
                    <label><strong><?php echo e(trans('file.User')); ?> <?php echo e(trans('file.List')); ?></strong></label>&nbsp;
                    <input type="checkbox" id="user_edit" name="user_edit" value="1">
                </div>
                <div class="form-group user_list_edit">
                    <label><strong><?php echo e(trans('file.User')); ?> *</strong></label>
                    <select name="user_id_edit" class="selectpicker form-control" required data-live-search="true" data-live-search-style="begins" title="Select User...">
                        <?php $__currentLoopData = $ezpos_user_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($user->id); ?>"><?php echo e($user->name .' ('.$user->email.')'); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="form-group customer_list_edit">
                    <label><strong><?php echo e(trans('file.customer')); ?> *</strong></label>
                    <select name="customer_id_edit" class="selectpicker form-control" required data-live-search="true" data-live-search-style="begins" title="Select Customer...">
                        <?php $__currentLoopData = $ezpos_customer_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($customer->id); ?>"><?php echo e($customer->name .' ('.$customer->phone_number.')'); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="form-group">
                    <label><strong><?php echo e(trans('file.Expired Date')); ?></strong></label>
                    <input type="text" id="expired_date_edit" name="expired_date_edit" class="form-control">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary"><?php echo e(trans('file.submit')); ?></button>
                </div>
              <?php echo e(Form::close()); ?>

          </div>
      </div>
  </div>
</div>

<div id="rechargeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
  <div role="document" class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 id="exampleModalLabel" class="modal-title"> <?php echo e(trans('file.Card')); ?> No: <span id="card-no"></span></h5>
              <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
          </div>
          <div class="modal-body">
            <p class="italic"><small><?php echo e(trans('file.The field labels marked with * are required input fields')); ?>.</small></p>
              <?php echo Form::open(['route' => ['gift_cards.recharge', 1], 'method' => 'post']); ?>

                <div class="form-group">
                    <input type="hidden" name="gift_card_id">
                    <label><strong><?php echo e(trans('file.Amount')); ?> *</strong></label>
                    <input type="number" name="amount" step="any" required class="form-control">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary"><?php echo e(trans('file.submit')); ?></button>
                </div>
              <?php echo e(Form::close()); ?>

          </div>
      </div>
  </div>
</div>

<script type="text/javascript">

    $("ul#sale").siblings('a').attr('aria-expanded','true');
    $("ul#sale").addClass("show");
    $("ul#sale li").eq(2).addClass("active");

    $("#expired_date").val($.datepicker.formatDate('dd-mm-yy', new Date()));
    $(".user_list").hide();
    $("select[name='user_id']").prop('required',false);

    var expired_date = $('#expired_date');
    expired_date.datepicker({
     format: "dd-mm-yyyy",
     startDate: "<?php echo date('d-m-Y'); ?>",
     autoclose: true,
     todayHighlight: true
     });

    var expired_date = $('#expired_date_edit');
    expired_date.datepicker({
     format: "dd-mm-yyyy",
     startDate: "<?php echo date('d-m-Y'); ?>",
     autoclose: true,
     todayHighlight: true
     });

    $( "#user" ).on("change", function() {
        if ($(this).is(':checked')) {
            $(".user_list").show();
            $(".customer_list").hide();
            $("select[name='user_id']").prop('required',true);
            $("select[name='customer_id']").prop('required',false);
        } 
        else {
            $(".user_list").hide();
            $(".customer_list").show();
            $("select[name='user_id']").prop('required',false);
            $("select[name='customer_id']").prop('required',true);
        }
    });

    $( "#user_edit" ).on("change", function() {
        if ($(this).is(':checked')) {
            $(".user_list_edit").show();
            $(".customer_list_edit").hide();
            $("select[name='user_id_edit']").prop('required',true);
            $("select[name='customer_id_edit']").prop('required',false);
        }
        else {
            $(".user_list_edit").hide();
            $(".customer_list_edit").show();
            $("select[name='user_id_edit']").prop('required',false);
            $("select[name='customer_id_edit']").prop('required',true);
        }
    });

    $('#gift_card-modal .genbutton').on("click", function(){
      $.get('gift_cards/gencode', function(data){
        $("input[name='card_no']").val(data);      
      });
    });

    $('#editModal .genbutton').on("click", function(){
      $.get('gift_cards/gencode', function(data){
        $("#editModal input[name='card_no_edit']").val(data);
      });
    });

    $(document).ready(function() {
        $('.open-Edit_gift_card_Dialog').on('click', function() {
            var url = "gift_cards/"
            var id = $(this).data('id').toString();
            url = url.concat(id).concat("/edit");
            $.get(url, function(data) {
                $("input[name='gift_card_id']").val(data['id']);
                $("input[name='card_no_edit']").val(data['card_no']);
                $("input[name='amount_edit']").val(data['amount']);
                if(data['user_id']){
                  $("#user_edit").prop('checked', true);
                  $("select[name='user_id_edit']").val(data['user_id']);
                  $("select[name='customer_id_edit']").val('');
                  $("select[name='user_id_edit']").prop('required',true);
                  $("select[name='customer_id_edit']").prop('required',false);
                  $(".user_list_edit").show();
                  $(".customer_list_edit").hide();
                }
                else{
                  $("#user_edit").prop('checked', false);
                  $("select[name='customer_id_edit']").val(data['customer_id']);
                  $("select[name='user_id_edit']").val('');
                  $("select[name='user_id_edit']").prop('required',false);
                  $("select[name='customer_id_edit']").prop('required',true);
                  $(".user_list_edit").hide();
                  $(".customer_list_edit").show();
                }
                
                $("input[name='expired_date_edit']").val(data['expired_date']);
                $('.selectpicker').selectpicker('refresh');
            });
        });

        $('.recharge').on('click', function() {
            var id = $(this).data('id').toString();
            $("#rechargeModal input[name='gift_card_id']").val(id);

            var rowindex = $(this).closest('tr').index();
            var card_no = $('#gift_card-table tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(2)').text();
            $('#card-no').text(card_no);
        });
    })

function confirmDelete() {
    if (confirm("Are you sure want to delete?")) {
        return true;
    }
    return false;
}

    $('#gift_card-table').DataTable( {
        "order": [],
        'columnDefs': [
            {
                "orderable": false,
                'targets': [0, 8]
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
                action: function(e, dt, button, config) {
                    datatable_sum(dt, true);
                    $.fn.dataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, button, config);
                    datatable_sum(dt, false);
                },
                footer:true
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    datatable_sum(dt, true);
                    $.fn.dataTable.ext.buttons.csvHtml5.action.call(this, e, dt, button, config);
                    datatable_sum(dt, false);
                },
                footer:true
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    datatable_sum(dt, true);
                    $.fn.dataTable.ext.buttons.print.action.call(this, e, dt, button, config);
                    datatable_sum(dt, false);
                },
                footer:true
            },
            {
                extend: 'colvis',
                columns: ':gt(0)'
            },
        ],
        drawCallback: function () {
            var api = this.api();
            datatable_sum(api, false);
        }
    } );

    function datatable_sum(dt_selector, is_calling_first) {
        if (dt_selector.rows( '.selected' ).any() && is_calling_first) {
            var rows = dt_selector.rows( '.selected' ).indexes();
            $( dt_selector.column( 4 ).footer() ).html(dt_selector.cells( rows, 4, { page: 'current' } ).data().sum().toFixed(2));
            $( dt_selector.column( 5 ).footer() ).html(dt_selector.cells( rows, 5, { page: 'current' } ).data().sum().toFixed(2));
            $( dt_selector.column( 3 ).footer() ).html(dt_selector.cells( rows, 3, { page: 'current' } ).data().sum().toFixed(2));
        }
        else {
            $( dt_selector.column( 4 ).footer() ).html(dt_selector.cells( rows, 4, { page: 'current' } ).data().sum().toFixed(2));
            $( dt_selector.column( 5 ).footer() ).html(dt_selector.cells( rows, 5, { page: 'current' } ).data().sum().toFixed(2));
            $( dt_selector.column( 3 ).footer() ).html(dt_selector.cells( rows, 3, { page: 'current' } ).data().sum().toFixed(2));
        }
    }

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
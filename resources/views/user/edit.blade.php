@extends('layout.main') @section('content')

@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div> 
@endif
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4>{{trans('file.update')}} {{trans('file.User')}}</h4>
                    </div>
                    <div class="card-body">
                        <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
                        {!! Form::open(['route' => ['user.update', $ezpos_user_data->id], 'method' => 'put', 'files' => true]) !!}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>{{trans('file.UserName')}} *</strong> </label>
                                        <input type="text" name="name" required class="form-control" value="{{$ezpos_user_data->name}}">
                                        @if($errors->has('name'))
                                       <span>
                                           <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label><strong>{{trans('file.Change Password')}}</strong> </label>
                                        <div class="input-group">
                                            <input type="password" name="password" class="form-control">
                                            <div class="input-group-append">
                                                <button id="genbutton" type="button" class="btn btn-default">{{trans('file.Generate')}}</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label><strong>{{trans('file.Email')}} *</strong></label>
                                        <input type="email" name="email" placeholder="example@example.com" required class="form-control" value="{{$ezpos_user_data->email}}">
                                        @if($errors->has('email'))
                                       <span>
                                           <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label><strong>{{trans('file.Phone Number')}} *</strong></label>
                                        <input type="text" name="phone" required class="form-control" value="{{$ezpos_user_data->phone}}">
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" value="{{trans('file.submit')}}" class="btn btn-primary">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>{{trans('file.Company Name')}}</strong></label>
                                        <input type="text" name="company_name" class="form-control" value="{{$ezpos_user_data->company_name}}">
                                    </div>
                                    <div class="form-group">
                                        <label><strong>{{trans('file.Role')}} *</strong></label>
                                        <input type="hidden" name="role_id_hidden" value="{{$ezpos_user_data->role_id}}">
                                        <select name="role_id" required class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Role...">
                                          @foreach($ezpos_role_list as $role)
                                              <option value="{{$role->id}}">{{$role->name}}</option>
                                          @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group" id="store-id">
                                        <input type="hidden" name="store_id_hidden" value="{{$ezpos_user_data->store_id}}" />
                                        <label><strong>{{trans('file.Store')}} *</strong></label>

                                      <?php $allstores=explode("-",$ezpos_user_data->store_id);?>
                                       <select id="salesman_store_id"   multiple name="store_id[]"  class="selectpicker form-control store-id" data-live-search="true" data-live-search-style="begins" title="Select store...">
                                          @foreach($ezpos_store_list as $store)
                                              <option  @for($i=0; $i<count($allstores); $i++) @if($store->id==$allstores[$i]) selected @endif  @endfor value="{{$store->id}}">{{$store->name}}</option>
										  @endforeach
                                        </select>
                                    </div>
									
									<div class="form-group" id="branch-id">
                                        <label><strong>{{trans('file.branch')}} *</strong></label>
                                        <select id="branch_admin_id" name="branch_id"  class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Branch..."   >
                                          @foreach($ezpos_branch_list as $branch)
                                              <option value="{{$branch->id}}" @if($branch->id==$ezpos_user_data->branch_id) selected @endif>{{$branch->name}}</option>
                                          @endforeach
                                        </select>
                                    </div>
									
                                    <div class="form-group">
                                        @if($ezpos_user_data->is_active)
                                        <input class="mt-4" type="checkbox" name="is_active" value="1" checked>
                                        @else
                                        <input class="mt-4" type="checkbox" name="is_active" value="1">
                                        @endif
                                        <label class="mt-4"><strong>{{trans('file.Active')}}</strong></label>
                                    </div>
                                </div>                              
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">

    $("ul#people").siblings('a').attr('aria-expanded','true');
    $("ul#people").addClass("show");
    $('#store-id').hide();
    $('#branch-id').hide();
    
    $('.selectpicker').selectpicker({
      style: 'btn-link',
    });

    $('#genbutton').on("click", function(){
      $.get('../genpass', function(data){
        $("input[name='password']").val(data);
      });
    });

    $('select[name=role_id]').val($("input[name='role_id_hidden']").val());
    if($('select[name=role_id]').val() == 6 ){
        $('#store-id').show();
        $('select[name=store_id]').val($("input[name='store_id_hidden']").val());
    }
	if($('select[name=role_id]').val() == 11 ){
        $('#branch-id').show();
    }
    $('.selectpicker').selectpicker('refresh');

    $('select[name="role_id"]').on('change', function() {
        if( $(this).val()==6){
            $('#salesman_store_id').prop('required',true);
            $('#store-id').show();
			
			$('#branch_admin_id').prop('required',false);
            $('#branch-id').hide();
        }
		else if( $(this).val()==11){
            $('#salesman_store_id').prop('required',false);
            $('#store-id').hide();
			
			$('#branch_admin_id').prop('required',true);
            $('#branch-id').show();
        }
        else{
            $('#salesman_store_id').prop('required',false);
            $('.store-id').val(null);
			$('#branch_admin_id').prop('required',false);
            $('#store-id').hide();
            $('.selectpicker').selectpicker('refresh');
            $('#store-id').hide();
        }
    });

</script>
@endsection
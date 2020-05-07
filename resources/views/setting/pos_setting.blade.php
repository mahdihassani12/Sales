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
                        <h4>{{trans('file.POS Setting')}}</h4>
                    </div>
                    <div class="card-body">
                        <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
                        {!! Form::open(['route' => 'setting.posStore', 'method' => 'post']) !!}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>{{trans('file.Default')}} {{trans('file.customer')}} *</strong></label>
                                        @if($ezpos_pos_setting_data)
                                        <input type="hidden" name="customer_id_hidden" value="{{$ezpos_pos_setting_data->customer_id}}">
                                        @endif
                                        <select required name="customer_id" id="customer_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select customer...">
                                            @foreach($ezpos_customer_list as $customer)
                                            <option value="{{$customer->id}}">{{$customer->name . ' (' . $customer->phone_number . ')'}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label><strong>{{trans('file.Displayed Number of Product Row')}} *</strong></label>
                                        <input type="number" name="product_number" class="form-control" value="@if($ezpos_pos_setting_data){{$ezpos_pos_setting_data->product_number}}@endif" required />
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Stripe Publishable key</strong></label>
                                        <input type="text" name="stripe_public_key" class="form-control" value="@if($ezpos_pos_setting_data){{$ezpos_pos_setting_data->stripe_public_key}}@endif" required />
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Paypal Pro API Username</strong></label>
                                        <input type="text" name="paypal_username" class="form-control" value="{{env('PAYPAL_SANDBOX_API_USERNAME')}}" />
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Paypal Pro API Signature</strong></label>
                                        <input type="text" name="paypal_signature" class="form-control" value="{{env('PAYPAL_SANDBOX_API_SECRET')}}" />
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" value="{{trans('file.submit')}}" class="btn btn-primary">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>{{trans('file.Default')}} {{trans('file.Store')}} *</strong></label>
                                        @if($ezpos_pos_setting_data)
                                        <input type="hidden" name="store_id_hidden" value="{{$ezpos_pos_setting_data->store_id}}">
                                        @endif
                                        <select required name="store_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select store...">
                                            @foreach($ezpos_store_list as $store)
                                            <option value="{{$store->id}}">{{$store->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mt-4">
                                        @if($ezpos_pos_setting_data && $ezpos_pos_setting_data->keybord_active)
                                        <input class="mt-4" type="checkbox" name="keybord_active" value="1" checked>
                                        @else
                                        <input class="mt-4" type="checkbox" name="keybord_active" value="1">
                                        @endif
                                        &nbsp;
                                        <label class="mt-4"><strong>{{trans('file.Touchscreen keybord')}}</strong></label>
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Stripe Secret key *</strong></label>
                                        <input type="text" name="stripe_secret_key" class="form-control" value="@if($ezpos_pos_setting_data){{$ezpos_pos_setting_data->stripe_secret_key}}@endif"required />
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Paypal Pro API Password</strong></label>
                                        <input type="password" name="paypal_password" class="form-control" value="{{env('PAYPAL_SANDBOX_API_PASSWORD')}}" />
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

    $("ul#setting").siblings('a').attr('aria-expanded','true');
    $("ul#setting").addClass("show");
    $("ul#setting li").eq(8).addClass("active");

    $('.selectpicker').selectpicker({
      style: 'btn-link',
    });

    $('select[name=customer_id]').val($("input[name='customer_id_hidden']").val());
    $('select[name=biller_id]').val($("input[name='biller_id_hidden']").val());
    $('select[name=store_id]').val($("input[name='store_id_hidden']").val());
    $('.selectpicker').selectpicker('refresh');

</script>
@endsection
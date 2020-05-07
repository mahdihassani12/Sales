  <div class="modal-dialog" style="max-width: 483px;">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">   
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> {{trans('file.orders')}} {{trans('file.process')}} </h4>
      </div>
      <div class="modal-body">
         {{ Form::open(['url' => ['request/change_status_to_process'], 'method' => 'POST'] ) }}
		    <div class="form-group" style='display:none'>
			   <label for="company_shipping">{{trans('file.Shipping')}} {{trans('company')}} </label>
			   <select name="company" id="company_shipping" class="form-control">
			      <option value="">{{trans('file.select')}} {{trans('file.company')}}</option>
				  @foreach($company as $comp)
     			  <option value="{{$comp->company_id}}" com_phone="{{$comp->phone}}">{{$comp->name}}</option>
			      @endforeach
			   </select>
			   <input type="hidden" value="{{$requestId}}" name='request_id'>
			</div>
			
			<div class="form-group" style='display:none'>
			   <label for="com_phone">{{trans('file.company')}} {{trans('file.phone')}}</label>
			   <input type="text" name="com_phone" id='com_phone' class="form-control" value='null'>
			</div>
			
			 <div class="form-group">
			   <label for="from_store"> {{trans('file.From')}} {{trans('file.Store')}} </label>
			   <select name="from_store" id="from_store" class="form-control">
			      <option value="">{{trans('file.select')}} {{trans('file.Store')}}</option>
				  @foreach($stores as $store)
     			  <option value="{{$store->id}}" >{{$store->name}}</option>
			      @endforeach
			   </select>
			   <input type="hidden" value="{{$requestId}}" name='request_id'>
			</div>
             <div class="form-group" style='display:none'>
			   <label for="note">{{trans('file.company')}} {{trans('file.Note')}}</label>
               <textarea rows="5" class="form-control" name="note" id="note" value='null'></textarea>
			 </div>
           <div class="form-group">
			   <input type="submit" name="submit" class="form-control">
			</div>			
		 {{Form::close()}}
      </div>
    </div>

  </div>
  
  
  <script>
	  $('#company_shipping').change(function(){
		  var comPhone=$("#company_shipping option:selected").attr('com_phone');
		  $("#com_phone").val(comPhone);
	  });	
	
  </script>
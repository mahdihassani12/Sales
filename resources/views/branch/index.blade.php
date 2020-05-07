@extends('layout.main') @section('content')
@if(session()->has('message'))
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div> 
@endif
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div> 
@endif
<section>
    <div class="container-fluid">
        <a href="#createNewBranch" data-toggle="modal" class="btn btn-info"><i class="fa fa-plus"></i> {{trans('file.add')}} {{trans('file.branch')}}</a>&nbsp;
    </div>
    <div class="table-responsive">
        <table id="biller-table" class="table table-hover">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>{{trans('file.No')}} </th>
                    <th>{{trans('file.name')}}</th>
                    <th>{{trans('file.Email')}}</th>
                    <th>{{trans('file.Phone Number')}}</th>
                    <th>{{trans('file.Address')}}</th>
                    <th class="not-exported">{{trans('file.action')}}</th>
                </tr>
            </thead>
            <tbody>
			   <?php $counter=1;?>
                @foreach($ezpos_branch_all as $key=>$branch)
                <tr>
                    <td>{{$key}}</td>
                    <td>{{$counter}}</td>
                    <td>{{ $branch->name }}</td>
                    <td>{{ $branch->email}}</td>
                    <td>{{ $branch->phone}}</td>
                    <td>{{ $branch->address}}<td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{trans('file.action')}}
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                <li>
                                    <a href="#updateNewBranch" data-toggle="modal" branch_id="{{$branch->id}}" branch_name="{{$branch->name}}"  branch_email="{{$branch->email}}" branch_phone="{{$branch->phone}}" branch_address="{{$branch->address}}" class="edit_branch btn btn-link"><i class="fa fa-edit"></i> {{trans('file.edit')}}</a> 
                                </li>
                                <li class="divider"></li>
                                {{ Form::open(['route' => ['branch.destroy', $branch->id], 'method' => 'DELETE'] ) }}
                                <li>
                                    <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="fa fa-trash"></i> {{trans('file.delete')}}</button>
                                </li>
                                {{ Form::close() }}
                            </ul>
                        </div>
                    </td>
                </tr>
				 <?php $counter++;?>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

<div id="createNewBranch" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
      <div class="modal-content">
        {!! Form::open(['route' => 'branch.store', 'method' => 'post']) !!}
		<div class="modal-header">
          <h5 id="exampleModalLabel" class="modal-title"></h5>
          <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
          <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label><strong>{{trans('file.branch')}} {{trans('file.name')}}*</strong></label>
                        <input type="text" name="name" class="form-control" required>
					</div>
                </div>
				 <div class="col-md-6">
                    <div class="form-group">
                        <label><strong>{{trans('file.phone')}} *</strong></label>
                        <input type="text" name="phone" class="form-control" required>
					</div>
                </div>
				 <div class="col-md-6">
                    <div class="form-group">
                        <label><strong>{{trans('file.email')}} </strong></label>
                        <input type="email" name="email" class="form-control" >
					</div>
                </div>
				
                <div class="col-md-6">
                    <div class="form-group">
                        <label><strong>{{trans('file.address')}} </strong></label>
                        <textarea name="address" class="form-control" rows="4"></textarea>
					</div>
                </div>
            </div>
            <input type="submit" value="{{trans('file.submit')}}" class="btn btn-primary" id="submit-button">
        </div>
        {!! Form::close() !!}
      </div>
    </div>
</div>


<div id="updateNewBranch" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
      <div class="modal-content">
		 {!! Form::open(['url' =>'branch/update', 'method' => 'post']) !!}
		<div class="modal-header">
          <h5 id="exampleModalLabel" class="modal-title"></h5>
          <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
          <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label><strong>{{trans('file.branch')}} {{trans('file.name')}}*</strong></label>
                        <input type="text" name="name" class="form-control" required>
					    <input type="hidden" name="id">
						
					</div>
                </div>
				 <div class="col-md-6">
                    <div class="form-group">
                        <label><strong>{{trans('file.phone')}} *</strong></label>
                        <input type="text" name="phone" class="form-control" required>
					</div>
                </div>
				 <div class="col-md-6">
                    <div class="form-group">
                        <label><strong>{{trans('file.email')}} </strong></label>
                        <input type="email" name="email" class="form-control" >
					</div>
                </div>
				
                <div class="col-md-6">
                    <div class="form-group">
                        <label><strong>{{trans('file.address')}} </strong></label>
                        <textarea name="address" class="form-control" rows="4"></textarea>
					</div>
                </div>
            </div>
            <input type="submit" value="{{trans('file.submit')}}" class="btn btn-primary" id="submit-button">
        </div>
        {!! Form::close() !!}
      </div>
    </div>
</div>



<script type="text/javascript">
    $(".edit_branch").click(function(){
		var id=$(this).attr('branch_id');
		var name=$(this).attr('branch_name');
		var phone=$(this).attr('branch_phone');
		var email=$(this).attr('branch_email');
		var address=$(this).attr('branch_address');
		
		$("#updateNewBranch input[name='name']").val(name);
		$("#updateNewBranch input[name='phone']").val(phone);
		$("#updateNewBranch input[name='email']").val(email);
		$("#updateNewBranch textarea[name='address']").val(address);
		$("#updateNewBranch input[name='id']").val(id);
	});
    $("ul#people").siblings('a').attr('aria-expanded','true');
    $("ul#people").addClass("show");
    $("ul#people li").eq(4).addClass("active");

    function confirmDelete() {
        if (confirm("Are you sure want to delete?")) {
            return true;
        }
        return false;
    }
    $('#biller-table').DataTable( {
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
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible',
                    format: {
                        body: function ( data, row, column, node ) {
                            if (column === 0 && (data.indexOf('<img src=') != -1)) {
                                var regex = /<img.*?src=['"](.*?)['"]/;
                                data = regex.exec(data)[1];                 
                            }
                            return data;
                        }
                    }
                },
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible',
                    stripHtml: false
                },
            },
            {
                extend: 'colvis',
                columns: ':gt(0)'
            },
        ],
    } );

    $("#export").on("click", function(e){
        e.preventDefault();
        var biller = [];
        $(':checkbox:checked').each(function(i){
          biller[i] = $(this).val();
        });
        $.ajax({
           type:'POST',
           url:'/exportbiller',
           data:{

                billerArray: biller
            },
           success:function(data){
            alert('Exported to CSV file successfully! Click Ok to download file');
            window.location.href = data;
           }
        });
    });
</script>
@endsection
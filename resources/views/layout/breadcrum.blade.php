<div class="breadcrum">
            @if(isset($data['breadcrumb']))
            <p>
                 <a href="{{asset('/home')}}"><span>{{$data['breadcrumb'][0]}}</span></a>
                <strong> - </strong>
                <span>{{$data['breadcrumb'][1]}}</span>
            </p>
            @endif
        </div>
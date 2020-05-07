<h1>Delivery Details</h1>
<h3>Hey {{$customer}}!</h3>
<p>Your Product is {{$status}}.</p>
<p><strong>Sale Reference: </strong>{{$sale_reference}}</p>
<p><strong>Delivery Reference: </strong>{{$delivery_reference}}</p>
<p><strong>Destination: </strong>{{$address}}</p>
@if($delivered_by)
<p><strong>Delivered By: </strong>{{$delivered_by}}</p>
@endif
<p>Thank You</p>
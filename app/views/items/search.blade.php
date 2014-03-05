@section('content')
<div class="row">
<div class="col-xs-8">
<h3>{{ $search }} </h3>
<ul style="list-style: none; padding-left: 0px;">
@foreach ($items as $item)
<li>
<a href="{{ route("item.view", array("id"=>$item->id)) }}">{{$item->name}}</a> 
{{ $item->featureLabels }}
</li>
@endforeach
</ul>
</div>
</div>
@stop

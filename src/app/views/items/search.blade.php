@section('content')
<h3>{{ $search }} </h3>
@foreach ($items as $item)
<div class="row">

<div class="col-md-6">
  <a href="{{ route("item.view", array("id"=>$item->id)) }}">{{$item->name}}</a>
  {{ $item->featureLabels }}
</div>

</div>
@endforeach
@stop

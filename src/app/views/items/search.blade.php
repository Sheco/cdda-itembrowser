<h3>Search: {{ $search }} </h3>
@if (empty($items))
No matches found.
@endif
@foreach ($items as $item)
<div class="row">

<div class="col-md-6">
  {{$item->symbol}} <a href="{{ route("item.view", array("id"=>$item->id)) }}">{{$item->name}}</a>
  {{ $item->featureLabels }}
</div>

</div>
@endforeach

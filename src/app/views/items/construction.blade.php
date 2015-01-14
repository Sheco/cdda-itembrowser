@section('title')
{{{$item->rawName}}} (construction) - Cataclysm: Dark Days Ahead
@endsection
@include('items.menu', array('active'=>'construction'))
<h1>
  {{$item->symbol}} <a href="{{ route("item.view", array("id"=>$item->id)) }}">{{ $item->name }}</a> construction.
</h1>
<div class="row">
<div class="col-md-6">
@foreach ($item->constructionUses as $construction)
{{ link_to_route("construction.view", $construction->description, array($construction->id)) }}
@if($construction->comment!="")
({{ $construction->comment }})
@endif

<br>
@endforeach

</div>

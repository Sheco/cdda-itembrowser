@section('title')
{{{$item->rawName}}} (construction) - Cataclysm: Dark Days Ahead
@endsection
@include('items.menu', array('active'=>'construction'))
<h1>
  {{$item->symbol}} <a href="{{ route("item.view", array("id"=>$item->id)) }}">{{ $item->name }}</a> construction.
</h1>
<div class="row">
<div class="col-md-6">
@include("world._constructionList", array("data"=>$item->constructionUses))
</div>
</div>

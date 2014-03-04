@section('content')
<div class="row">
<div class="col-xs-8">
<h3>{{ $search }} </h3>
<table class="table table-bordered">
<tr>
  <th>Name</th>
  <th>can be crafted</th>
  <th>can be used to craft</th>
  <th>disassembly</th>
</tr>
@foreach ($items as $item)
<Tr>
  <td><a href="{{ route("item.view", array("id"=>$item->id)) }}">{{$item->name}}</a></td>
  <td>{{ count($item->recipes) }}</td>
  <td>{{ count($item->toolFor) }}</td>
  <td>{{ count($item->disassembly) }}</td>
</tr>
@endforeach
</table>
</div>
</div>
@stop

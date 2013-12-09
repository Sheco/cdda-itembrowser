@section('content')
<div class="row">
<div class="col-xs-4">
<h3>{{ $search }} </h3>
<table class="table table-striped table-bordered">
<tr>
  <th>Name</th>
</tr>
@foreach ($items as $item)
<Tr>
  <td>{{ link_to("/$item->id", "$item->name") }} </td>
</tr>
@endforeach
</table>
</div>
</div>
@stop

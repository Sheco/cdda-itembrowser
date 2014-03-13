@section('title')
Melee - Cataclysm: Dark Days Ahead
@endsection
@section('content')
<h4>Items with bashing+cutting damage higher than 10 and to-hit bonus higher than -2</h4>

<table class="table table-bordered table-hover">
  <thead>
  <tr>
    <td>Name</td>
    <td>Material</td>
    <td><span title="Volume">V</span></td>
    <td><span title="Weight">W</span></td>
    <td><span title="Bashing">B</span></td>
    <td><span title="Cutting">C</span></td>
    <td><span title="To-Hit">H</span></td>
  </tr>
</thead>
@foreach($items as $item)
<tr>
  <td><a href="{{route('item.view', $item->id)}}">{{ $item->name }}</a></td>
  <td>{{ $item->materials }}</td>
  <td>{{ $item->volume }}</td>
  <td>{{ $item->weight }}</td>
  <td>{{ $item->bashing }}</td>
  <td>{{ $item->cutting }}</td>
  <td>{{ $item->to_hit }}</td>
</tr>
</tr>
@endforeach
</table>
@endsection

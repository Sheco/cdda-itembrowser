@section('title')
Melee - Cataclysm: Dark Days Ahead
@endsection
@section('content')
<h4>Items with bashing+cutting damage higher than 10 and to-hit bonus higher than -2</h4>

<table class="table table-bordered table-hover tablesorter">
  <thead>
  <tr>
    <th>Name</th>
    <th>Material</th>
    <th><span title="Volume">V</span></th>
    <th><span title="Weight">W</span></th>
    <th><span title="Bashing">B</span></th>
    <th><span title="Cutting">C</span></th>
    <th><span title="To-Hit">H</span></th>
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
<script>
$(function() {
    $(".tablesorter").tablesorter({
      sortList: [[4,1], [5,1]]
      });
});
</script>
@endsection

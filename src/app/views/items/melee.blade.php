@section('title')
Melee - Cataclysm: Dark Days Ahead
@endsection
@section('content')
<h1>Melee</h1>
<p>
Items with bashing+cutting damage higher than 10 and to-hit bonus higher than -2
</p>

<table class="table table-bordered table-hover tablesorter">
  <thead>
  <tr>
    <th></th>
    <th>Name</th>
    <th>Material</th>
    <th><span title="Volume">V</span></th>
    <th><span title="Weight">W</span></th>
    <th><span title="Moves per attack">M/A</span></th>
    <th><span title="Bashing+Cutting">Dmg</span></th>
    <th><span title="Damage per move">dps</span></th>
    <th><span title="To-Hit">H</span></th>
  </tr>
</thead>
@foreach($items as $item)
<tr>
  <td>{{ $item->symbol }}</td>
  <td><a href="{{route('item.view', $item->id)}}">{{ $item->name }}</a></td>
  <td>{{ $item->materials }}</td>
  <td>{{ $item->volume }}</td>
  <td>{{ $item->weight }}</td>
  <td>{{ $item->movesPerAttack }}</td>
  <td>{{ $item->bashing+$item->cutting }}</td>
  <td>{{ $item->damagePerMove }}</td>
  <td>{{ $item->to_hit }}</td>
</tr>
</tr>
@endforeach
</table>
<script>
$(function() {
    $(".tablesorter").tablesorter({
      sortList: [[7,1]]
      });
});
</script>
@endsection

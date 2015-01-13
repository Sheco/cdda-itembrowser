@section('title')
Containers - Cataclysm: Dark Days Ahead
@endsection
<h1>Containers</h1>

<table class="table table-bordered table-hover tablesorter">
  <thead>
  <tr>
    <th></th>
    <th>Name</th>
    <th>Material</th>
    <th><span title="Rigid">R</span></th>
    <th><span title="Resealable">S</span></th>
    <th><span title="Watertight">W</span></th>
    <th><span title="Preserves from spoiling">P</span></th>
    <th><span title="Capacity">C</span></th>
  </tr>
</thead>
@foreach($items as $item)
<tr>
  <td>{{ $item->symbol }}</td>
  <td><a href="{{route('item.view', $item->id)}}">{{ $item->name }}</a></td>
  <td>{{ $item->materials }}</td>
  <td>{{ $item->rigid }}</td>
  <td>{{ $item->seals }}</td>
  <td>{{ $item->watertight }}</td>
  <td>{{ $item->preserves }}</td>
  <td>{{ $item->contains }}</td>
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

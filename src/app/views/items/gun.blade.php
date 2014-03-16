@section('title')
Ranged weapons - Cataclysm: Dark Days Ahead
@endsection
@section('content')
<ul class="nav nav-tabs">
@foreach($skills as $key=>$value)
<li @if($key==$skill) class="active" @endif><a href="{{ route("item.gun", $key) }}">{{{$value}}}</a></li>
@endforeach
</ul>
<table class="table table-bordered table-hover tablesorter">
  <thead>
  <tr>
    <th>Name</th>
    <th><span title="Volume">V</span></th>
    <th><span title="Weight">W</span></th>
    <th><span title="Damage">Dam</span></th>
    <th><span title="Range">Ran</span></th>
    <th><span title="Dispersion">Dis</span></th>
  </tr>
</thead>
<tbody>
@foreach($items as $item)
<tr>
  <td><a href="{{route('item.view', $item->id)}}">{{ $item->name }}</a></td>
  <td>{{ $item->volume }}</td>
  <td>{{ $item->weight }}</td>
  <td>{{ $item->ranged_damage }}</td>
  <td>{{ $item->range }}</td>
  <td>{{ $item->dispersion }}</td>
</tr>
@endforeach
</tbody>
</table>
<script>
$(function() {
    $(".tablesorter").tablesorter({
      sortList: [[3,1]]
      });
});
</script>

@endsection

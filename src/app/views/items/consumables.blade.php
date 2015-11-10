@section('title')
Consumables - Cataclysm: Dark Days Ahead
@endsection
<h1>Consumables</h1>

<ul class="nav nav-tabs">
@foreach($types as $value)
<li @if($value==$type) class="active" @endif><a href="{{ route(Route::currentRouteName(), $value) }}">{{{ucfirst($value)}}}</a></li>
@endforeach
</ul>
<table class="table table-bordered table-hover tablesorter">
  <thead>
  <tr>
    <th></th>
    <th>Name</th>
    <th>Quench</th>
    <th><span title="Nutrition">Nut</span></th>
    <th><span title="Days to spoil">Spo</span></th>
    <th><span title="Stimulant">Sti</span></th>
    <th><span title="Health">Hea</span></th>
    <th><span title="Adiction">Adi</span></th>
    <th>Fun</th>
  </tr>
</thead>
@foreach($items as $item)
<tr>
  <td>{{ $item->symbol }}</td>
  <td><a href="{{route('item.view', $item->id)}}">{{ $item->name }}</a></td>
  <td>{{ $item->quench }}</td>
  <td>{{ $item->nutrition }}</td>
  <td>{{ $item->spoils_in }}</td>
  <td>{{ $item->stim }}</td>
  <td>{{ $item->healthy }}</td>
  <td>{{ $item->addiction_potential }}</td>
  <td>{{ $item->fun }}</td>
</tr>
</tr>
@endforeach
</table>
<script>
$(function() {
    $(".tablesorter").tablesorter({
@if ($type=="drink")
      sortList: [[1,1]]
@elseif ($type=="food")
      sortList: [[2,1]]
@else
      sortList: [[5,1]]
@endif
      });
});
</script>

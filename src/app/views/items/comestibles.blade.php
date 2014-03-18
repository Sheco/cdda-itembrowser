@section('title')
Comestibles - Cataclysm: Dark Days Ahead
@endsection
@section('content')
<h1>Comestibles/Consumables</h1>

<ul class="nav nav-tabs">
@foreach($types as $key=>$value)
<li @if($key==$type) class="active" @endif><a href="{{ route("item.comestibles", $key) }}">{{{$value}}}</a></li>
@endforeach
</ul>
<table class="table table-bordered table-hover tablesorter">
  <thead>
  <tr>
    <th>Name</th>
    <th>Quench</th>
    <th><span title="Nutrition">Nut</span></th>
    <th><span title="Spoils">Spo</span></th>
    <th><span title="Stimulant">Sti</span></th>
    <th><span title="Health">Hea</span></th>
    <th><span title="Adiction">Adi</span></th>
    <th>Fun</th>
  </tr>
</thead>
@foreach($items as $item)
<tr>
  <td><a href="{{route('item.view', $item->id)}}">{{ $item->name }}</a></td>
  <td>{{ $item->quench }}</td>
  <td>{{ $item->nutrition }}</td>
  <td>{{ $item->spoils_in }}</td>
  <td>{{ $item->stim }}</td>
  <td>{{ $item->heal }}</td>
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
@endsection

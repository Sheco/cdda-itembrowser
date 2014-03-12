@section('title')
Armor - Cataclysm: Dark Days Ahead
@endsection
@section('content')
<ul class="nav nav-tabs">
@foreach($parts as $key=>$value)
<li @if($key==$part) class="active" @endif><a href="{{ route("item.armor", $key) }}">{{{$value}}}</a></li>
@endforeach
</ul>
<table class="table table-bordered table-hover">
  <thead>
  <tr>
    <td>Name</td>
    <td>Material</td>
    <td><span title="Volume">V</span></td>
    <td><span title="Weight">W</span></td>
    <td><span title="Encumbrance">E</span></td>
    <td><span title="Bash protection">BP</span></td>
    <td><span title="Cutting protection">CP</span></td>
    <td><span title="Warmth">Wa</span></td>
  </tr>
</thead>
@foreach($items as $item)
<tr>
  <td><a href="{{route('item.view', $item->id)}}">{{ $item->name }}</a></td>
  <td>{{ $item->materials }}</td>
  <td>{{ $item->volume }}</td>
  <td>{{ $item->weight }}</td>
  <td>{{ $item->encumbrance }}</td>
  <td>{{ $item->bashing }}</td>
  <td>{{ $item->cutting }}</td>
  <td>{{ $item->warmth }}</td>
</tr>
</tr>
@endforeach
</table>
@endsection

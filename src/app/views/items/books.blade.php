@section('title')
Books - Cataclysm: Dark Days Ahead
@endsection
<h1>Books</h1>

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
    <th>Skill</th>
    <th><span title="Required Level">RL</span></th>
    <th><span title="Max Level">ML</span></th>
    <th>Time</th>
    <th>Fun</th>
    <th>Recipes</th>
  </tr>
</thead>
@foreach($items as $item)
<tr>
  <td>{{ $item->symbol }}</td>
  <td><a href="{{route('item.view', $item->id)}}">{{ $item->name }}</a></td>
  <td>{{ $item->skill }}</td>
  <td>{{ $item->required_level }}</td>
  <td>{{ $item->max_level }}</td>
  <td>{{ $item->time }}</td>
  <td>{{ $item->fun }}</td>
  <td>{{ $item->count("learn") }}</td>
</tr>
</tr>
@endforeach
</table>
<script>
$(function() {
    $(".tablesorter").tablesorter({
      sortList: [[5,1]]
      });
});
</script>

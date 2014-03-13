@section('title')
Books - Cataclysm: Dark Days Ahead
@endsection
@section('content')
<ul class="nav nav-tabs">
@foreach($types as $key=>$value)
<li @if($key==$type) class="active" @endif><a href="{{ route("item.books", $key) }}">{{{$value}}}</a></li>
@endforeach
</ul>
<table class="table table-bordered table-hover tablesorter">
  <thead>
  <tr>
    <th>Name</th>
    <th>Skill</th>
    <th>Time</th>
    <th>Fun</th>
    <th>Recipes</th>
  </tr>
</thead>
@foreach($items as $item)
<tr>
  <td><a href="{{route('item.view', $item->id)}}">{{ $item->name }}</a></td>
  <td>{{ $item->skill }}</td>
  <td>{{ $item->time }}</td>
  <td>{{ $item->fun }}</td>
  <td>{{ count($item->learn) }}</td>
</tr>
</tr>
@endforeach
</table>
<script>
$(function() {
    $(".tablesorter").tablesorter({
      sortList: [[4,1]]
      });
});
</script>
@endsection

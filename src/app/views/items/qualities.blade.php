@section('title')
Qualities - Cataclysm: Dark Days Ahead
@endsection
@section('content')
<h1>Qualities</h1>

<ul class="nav nav-tabs">
@foreach($qualities as $key=>$quality)
<li @if($key==$id) class="active" @endif><a href="{{ route("item.qualities", $key) }}">{{{$quality->name}}}</a></li>
@endforeach
</ul>
@if (!$id)
Please select a tab
@else
<table class="table table-bordered table-hover tablesorter">
  <thead>
  <tr>
    <th>Name</th>
  </tr>
</thead>
@foreach($items as $item)
<tr>
  <td><a href="{{route('item.view', $item->id)}}">{{ $item->name }}</a></td>
</tr>
</tr>
@endforeach
</table>
<script>
$(function() {
    $(".tablesorter").tablesorter({
      sortList: [[0,1]]
      });
});
</script>
@endif
@endsection

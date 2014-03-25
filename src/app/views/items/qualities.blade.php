@section('title')
Qualities - Cataclysm: Dark Days Ahead
@endsection
@section('content')
<h1>Qualities</h1>

<div class="row">
  <div class="col-md-3">
<ul class="nav nav-pills nav-stacked">
@foreach($qualities as $key=>$quality)
<li class="@if($key==$id) active @endif"><a href="{{ route("item.qualities", $key) }}">{{{$quality->name}}}</a></li>
@endforeach
</ul>
  </div>
  <div class="col-md-9">
@if (!$id)
Please select an entry from the menu on the left.
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
</div>
@endsection

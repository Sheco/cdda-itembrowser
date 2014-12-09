@section('title')
Flags - Cataclysm: Dark Days Ahead
@endsection
@section('content')
<div class="row">
  <div class="col-md-3">
<ul class="nav nav-pills nav-stacked">
@foreach($flags as $key=>$flag)
<li class="@if ($flag==$id) active @endif@"><a href="{{ route("item.flags", $flag) }}">{{{$flag}}}</a></li>
@endforeach
</ul>
  </div>
  <div class="col-md-9">
@if (!$id)
Please select an entry from the menu on the left.
@else
<ul class="list-unstyled">
@foreach($items as $item)
  <li><a href="{{route('item.view', $item->id)}}">{{ $item->name }}</a></li>
@endforeach
</ul>
@endif
</div>
</div>
@stop

@section('title')
Skills - Cataclysm: Dark Days Ahead
@endsection
<div class="row">
  <div class="col-md-3">
<ul class="nav nav-pills nav-stacked">
@foreach($skills as $key=>$_skill)
<li class="@if($_skill==$skill) active @endif"><a href="{{ route(Route::currentRouteName(), array($_skill, $part)) }}">{{{$_skill}}}</a></li>
@endforeach
</ul>
  </div>
  <div class="col-md-3">
<ul class="nav nav-pills nav-stacked">
@foreach($parts as $value)
<li @if($value==$part) class="active" @endif><a href="{{ route(Route::currentRouteName(), array($skill, $value)) }}">{{{$value}}}</a></li>
@endforeach
</ul>
  </div>
  <div class="col-md-6">
<ul class="list-unstyled">
@foreach($mods as $item)
  <li>{{ $item->symbol }} <a href="{{route('item.view', $item->id)}}">{{ $item->name }}</a></li>
@endforeach
</ul>
  </div>
</div>
</div>

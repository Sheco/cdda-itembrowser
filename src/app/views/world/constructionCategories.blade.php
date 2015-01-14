@section('title')
Construction categories - Cataclysm: Dark Days Ahead
@endsection
<h1>Construction categories</h1>

<div class="row">
  <div class="col-md-3">
<ul class="nav nav-pills nav-stacked">
@foreach($categories as $category)
<li class="@if($category==$id) active @endif"><a href="{{ route(Route::currentRouteName(), $category) }}">{{{$category}}}</a></li>
@endforeach
</ul>
  </div>

  <div class="col-md-9">
<ul class="list-unstyled">
@foreach($data as $d) 
 <li>{{ link_to_route("construction.view", $d->description, $d->repo_id); }}
@if($d->comment!="")
({{{$d->comment}}})
@endif
</li>
@endforeach
</ul>
  </div>
</div>


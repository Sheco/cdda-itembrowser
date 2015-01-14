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
<table class="table table-bordered">
<thead>
<tr>
    <th>Construction</th>
    <th></th>
    <th>Source</th>
    <th></th>
    <th>Result</th>
</tr>
</thead>
@foreach($data as $d) 
<tr>
    <td>{{ link_to_route("construction.view", $d->description, $d->repo_id); }}</td>
@if ($d->has_pre_terrain)
    <td>{{$d->pre_terrain->symbol}}</td>
    <td>{{$d->pre_terrain->name}}</td>
@elseif ($d->pre_flags)
    <td></td>
    <td>is:{{$d->pre_flags}}</td>
@else
    <td></td>
    <td></td>
@endif
@if ($d->has_post_terrain) 
    <td>{{$d->post_terrain->symbol}}</td>
    <td>{{$d->post_terrain->name}}</td>
@else
    <td></td>
    <td></td>
@endif
</tr>
@endforeach
</table>
  </div>
</div>


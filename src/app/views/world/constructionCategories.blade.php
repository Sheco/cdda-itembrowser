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
  @include("world._constructionList", array("data"=>$data))
  </div>
</div>


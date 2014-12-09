@section('title')
Monsters species: {{{$id}}} - Cataclysm: Dark Days Ahead
@endsection
@section('description')
Monster species: {{{$id}}}
@endsection
@section('content')
<div class="row">
<div class="col-md-3">
<ul class="nav nav-pills nav-stacked">
@foreach($species as $s)
<li class="@if ($s==$id) active @endif">{{ link_to_route('monster.species', ucfirst(strtolower($s)), array($s)) }}</li>
@endforeach
</ul>
</div>
<div class="col-md-9">
<ul class="list-unstyled">
@foreach ($data as $monster)
<li>{{ link_to_route('monster.view', $monster->niceName, array($monster->id)) }}</li>
@endforeach
</ul>
</div>
</div>
@endsection

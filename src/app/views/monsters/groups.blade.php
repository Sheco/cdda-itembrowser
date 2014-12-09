@section('title')
Monster Groups - Cataclysm: Dark Days Ahead
@endsection
@section('description')
Monster groups
@endsection
@section('content')
<div class="row">
<div class="col-md-3">
<ul class="nav nav-pills nav-stacked">
@foreach($groups as $_group)
<li class="@if ($_group->name==$id) active @endif">{{ link_to_route('monster.groups', $_group->niceName, array($_group->name)) }}</li>
@endforeach
</ul>
</div>
<div class="col-md-9">
<ul class="list-unstyled">
@foreach ($group->uniqueMonsters as $monster)
<li>{{ link_to_route('monster.view', $monster->niceName, array($monster->id)) }}</li>
@endforeach
</ul>
</div>
</div>
@endsection

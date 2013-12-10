@section('content')
<h3>
{{ link_to_route("item.view", $item->name, ["id"=>$item->id]) }} 
@if (count($item->toolFor)>0) 
 can be used to craft following recipes:<br>
@else
 can't be used to craft anything.
@endif
</h3>
<br>
<div class="row">
<div class="col-xs-4">
@foreach ($item->toolFor as $recipe)
{{ link_to_route("item.view", Items::get($recipe->result)->name, ["id"=>$recipe->result]) }}<br>
  Required skills: {{ join(" ", $recipe->skills_required) }} <br>
  Difficulty: {{ $recipe->difficulty }}<br>
  Time to complete: {{ $recipe->time }}<br>
  @if ($recipe->hasTools)
  Tools required: <br>
  @foreach ($recipe->tools as $group)
    &gt; 
    @foreach ($group->items as $item)
      {{ link_to_route("item.view", $item["item"]->name, ["id"=>$item["item"]->id]) }}
      {{ $item["amount"] }}
      @if ($item != end($group->items)) 
        OR
      @endif
    @endforeach
    <br>
  @endforeach
  @endif

  @if ($recipe->hasComponents)
  Components required: <br>
  @foreach ($recipe->components as $group)
    &gt; 
    @foreach ($group->items as $item)
      {{ $item["amount"] }}
      {{ link_to_route("item.view", $item["item"]->name, ["id"=>$item["item"]->id]) }}
      @if ($item != end($group->items)) 
        OR
      @endif
    @endforeach
    <br>
  @endforeach
  @endif
<br>
@endforeach
</div>
</div>
@stop


@section('content')
<h3>
{{ link_to_route("item.view", $item->name, ["id"=>$item->id]) }}
@if (count($item->disassembly)>0)
 can be disassembled to obtain following items.<br>
@else
 can't be disassembled.
@endif
</h3>
<br>
<div class="row">
<div class="col-sm-4">
@foreach ($item->disassembly as $recipe)
  {{link_to_route("item.view", $recipe->result->name, ["id"=>$recipe->result->id])}}<br>
  Skills used: {{ $recipe->skill_used }} <br>
  Required skills: {{ join(" ", $recipe->skills_required) }} <br>
  Difficulty: {{ $recipe->difficulty }}<br>
  Reversible: {{ $recipe->reversible }}<br>
  Learn Automatically: {{ $recipe->autolearn }}<br>
  Time to complete: {{ $recipe->time }}<br>
  @if ($recipe->hasTools)
  Tools required: <br>
  @foreach ($recipe->tools as $group)
    &gt; 
    @foreach ($group->items as $item)
      {{ link_to_route("item.view", $item["item"]->name, ["id"=>$item["item"]->id]) }}
      @if ($item != end($group->items)) 
        OR
      @endif
      {{ $item["amount"] }}
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

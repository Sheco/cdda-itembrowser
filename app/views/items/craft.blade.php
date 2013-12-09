@section('content')
<h3>
{{ link_to("/$item->id", $item->name) }}
@if (count($item->recipes)>0)
 can be crafted with the following recipes<br>
@else
 can't be crafted
@endif
</h3>
<br>
<div class="row">
<div class="col-xs-4">
@foreach ($item->recipes as $recipe)
  Skills used: {{ $recipe->skill_used }} <br>
  Required skills: {{ join(" ", $recipe->skills_required) }} <br>
  Difficulty: {{ $recipe->difficulty }}<br>
  Time to complete: {{ $recipe->time }}<br>
  @if ($recipe->hasTools)
  Tools required: <br>
  @foreach ($recipe->tools as $group)
    &gt; 
    @foreach ($group->items as $item)
      {{ link_to("/{$item["item"]->id}", $item["item"]->name) }}
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
      {{ link_to("/{$item["item"]->id}", $item["item"]->name) }}
      @if ($item != end($group->items)) 
        OR
      @endif
    @endforeach
    <br>
  @endforeach
  @endif

@endforeach
</div>
</div>
@stop

@section('content')
<h3>
{{ link_to("/$item->id", $item->name) }} 
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
{{ link_to("/$recipe->result", Items::get($recipe->result)->name) }}<br>
  Required skills: {{ join(" ", $recipe->skills_required) }} <br>
  Difficulty: {{ $recipe->difficulty }}<br>
  Time to complete: {{ $recipe->time }}<br>
  @if ($recipe->hasTools)
  Tools required: <br>
  @foreach ($recipe->tools as $group)
    &gt; 
    @foreach ($group->items as $item)
      {{ link_to("/{$item["item"]->id}", $item["item"]->name) }}
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
      {{ link_to("/{$item["item"]->id}", $item["item"]->name) }}
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


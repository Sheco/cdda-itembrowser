@section('content')
<h3>
{{ link_to_route("item.view", $item->name, array("id"=>$item->id)) }}
@if (count($item->recipes)>0)
 can be crafted with the following recipes<br>
@else
 can't be crafted
@endif
</h3>
<br>
<div class="row">
<div class="col-sm-4">
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
      {{ link_to_route("item.view", $item["item"]->name, array("id"=>$item["item"]->id)) }}
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
      {{ link_to_route("item.view", $item["item"]->name, array("id"=>$item["item"]->id)) }}
      @if ($item != end($group->items)) 
        OR
      @endif
    @endforeach
    <br>
  @endforeach
  @endif
<br>
@endforeach
@if ($recipe->book_learn)
This recipe can be learned reading the following books:<br>
@foreach($recipe->book_learn as $book)
  <a href="{{ route('item.view', $book[0]) }}">{{ Items::get($book[0])->name }} ({{ $book[1] }})</a><br>
@endforeach
@endif
</div>
</div>
@stop

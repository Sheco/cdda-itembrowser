@section('content')
<h3>
  <a href="{{ route("item.view", array("id"=>$item->id)) }}">{{ $item->name }}</a>
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
  Skill used: {{ $recipe->skill_used }} <br>
  Required skills: {{ $recipe->skillsRequired }} <br>
  Difficulty: {{ $recipe->difficulty }}<br>
  Time to complete: {{ $recipe->time }}<br>
  @if ($recipe->hasTools)
  {{$recipe->tools}}<br>
  @endif

  @if ($recipe->hasComponents)
  {{$recipe->components}}<br>
  @endif
@if ($recipe->book_learn)
This recipe can be learned reading the following books:<br>
@foreach($recipe->book_learn as $book)
  <a href="{{ route('item.view', $book[0]) }}">{{ $itemRepository->find($book[0])->name }} ({{ $book[1] }})</a><br>
@endforeach
@endif
<br>
@endforeach
</div>
  <div class="col-sm-4">
    <div class="list-group">
      {{ link_to_route("item.view", "View item", array("id"=>$item->id), array("class"=>"list-group-item")) }}
      {{ link_to_route("item.recipes", "Recipes", array("id"=>$item->id), array("class"=>"list-group-item")) }}
      {{ link_to_route("item.disassemble", "Disassemble", array("id"=>$item->id), array("class"=>"list-group-item")) }}
    </div>
  </div>
</div>
@stop

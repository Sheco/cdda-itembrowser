@section('content')
<script>
var show_recipe = function(id)
{
  $('.recipes').hide();
  $('#recipe'+id).show();
  return false;
}
</script>
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
  <div class="col-sm-8">
    <div class="navbar navbar-default">
      <ul class="nav navbar-nav">

  @foreach ($categories as $cat)
      <li>{{ link_to_route("item.recipes", substr($cat, 3), 
        ["id"=>$item->id, "category"=>$cat], 
        ["class"=>"list-group-item".($cat==$category?" active": "")]) }}</li>
  @endforeach
      </ul>
    </div>
  </div>
</div>

<div class="row">
<div class="col-sm-4">
@foreach ($recipes as $recipe_id=>$local_recipe)
<a href="#" onclick="return show_recipe('{{$recipe_id}}')">{{ $local_recipe->result->prettyName}}</a>
<br>
@endforeach
</div>

<div class="col-sm-4">
@foreach($recipes as $recipe_id=>$recipe)
<div id="recipe{{$recipe_id}}" class="recipes" style="display: none">
{{ link_to_route("item.view", 
$recipe->result->name, 
["id"=>$recipe->result->id]) }}<br>
  Category: {{ $recipe->category }}<Br>
  SubCategory: {{ $recipe->subcategory }}<br>
  Required skills: {{ join(" ", $recipe->skills_required) }} <br>
  Difficulty: {{ $recipe->difficulty }}<br>
  Time to complete: {{ $recipe->time }}<br>
  @if ($recipe->hasTools)
  Tools required: <br>
  @foreach ($recipe->tools as $group)
    &gt; 
    @foreach ($group->items as $gi)
      {{ link_to_route("item.view", $gi["item"]->name, ["id"=>$gi["item"]->id]) }}
      {{ $gi["amount"] }}
      @if ($gi != end($group->items)) 
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
    @foreach ($group->items as $gi)
      {{ $gi["amount"] }}
      {{ link_to_route("item.view", $gi["item"]->name, ["id"=>$gi["item"]->id]) }}
      @if ($gi != end($group->items)) 
        OR
      @endif
    @endforeach
    <br>
  @endforeach
  @endif
</div>
@endforeach

</div>
</div>
</div>

@stop

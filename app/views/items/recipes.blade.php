@section('content')
<script>
var show_recipe = function(id)
{
  $('.recipes').hide();
  $('#recipe'+id).show();
  var body = $("body");
  $('hmtl, body').animate({
    scrollTop: $("#recipe"+id).offset().top-$(".navbar").height()
  }, 500);
  return false;
}
</script>
<h3>
  <a href="{{ route("item.view", array("id"=>$item->id)) }}">{{ $item->name }}</a>
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
        array("id"=>$item->id, "category"=>$cat), 
        array("class"=>"list-group-item".($cat==$category?" active": ""))) }}</li>
  @endforeach
      </ul>
    </div>
  </div>
</div>

<div class="row">
<div class="col-sm-4">
@foreach($recipes as $recipe_id=>$recipe)
<div id="recipe{{$recipe_id}}" class="recipes" style="display: none">
{{ link_to_route("item.view", 
$recipe->result->name, 
array("id"=>$recipe->result->id)) }}<br>
  Category: {{ $recipe->category }}<Br>
  SubCategory: {{ $recipe->subcategory }}<br>
  Required skills: {{ $recipe->skills_required }} <br>
  Difficulty: {{ $recipe->difficulty }}<br>
  Time to complete: {{ $recipe->time }}<br>
  @if ($recipe->hasTools)
  {{$recipe->tools}}<br>
  @endif

  @if ($recipe->hasComponents)
  {{$recipe->components}}<br>
  @endif
  <hr>
</div>
@endforeach
@foreach ($recipes as $recipe_id=>$local_recipe)
<a href="#" onclick="return show_recipe('{{$recipe_id}}')">{{ $local_recipe->result->name}}</a>
<br>
@endforeach
<br>


</div>

  <div class="col-sm-4">
    <div class="list-group">
      {{ link_to_route("item.craft", "Craft", array("id"=>$item->id), array("class"=>"list-group-item")) }}
      {{ link_to_route("item.view", "View item", array("id"=>$item->id), array("class"=>"list-group-item")) }}
      {{ link_to_route("item.disassemble", "Disassemble", array("id"=>$item->id), array("class"=>"list-group-item")) }}
    </div>
  </div>


</div>
@stop

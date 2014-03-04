@section('content')
<div class="row">
  <div class="col-sm-4">
    {{$item->name}}
    ({{$item->type}})
    <br>
    {{$item->badges}}
    <br>
    <br>
    Volume: {{ $item->volume }} Weight: {{ $item->weight }}<br>
      Bash: {{ $item->bashing }}
      Stab: {{ $item->cutting }}
    To-hit bonus: {{ $item->to_hit }}<br>
    Moves per attack: {{ $item->movesPerAttack }}<br>
    Materials: {{ $item->material1->name }}, 
      {{ $item->material2->name }}<br>
    @if ($item->isComestible)
      Phase: {{ $item->phase }}<br>
      Nutrition: {{ $item->nutrition }}<br>
      Quench: {{ $item->quench }}<br>
      Enjoyability: {{ $item->fun }}<br>
      Spoils in {{ $item->spoilsIn }}<br>
      Heal: {{ $item->heal }} <br>
    @endif
    <br>
    @if ($item->isArmor) 
      Covers: {{ join(". ", $item->covers) }}<br>
      Coverage: {{ $item->coverage }}<br>
      Encumberment: {{ $item->encumbrance }}<br>
      Protection: <br>
      <ul>
      <li>Bash: {{ $item->protection('bash') }} 
      <li>Cut:  {{  $item->protection('cut') }}
      <li>Acid: {{  $item->protection('acid') }}
      <li>Fire: {{  $item->protection('fire') }}
      <li>Elec: {{  $item->protection('elec') }}
      </ul>
      Environmental protection: {{ $item->enviromental_protection }}<br>
      Warmth: {{ $item->warmth }}<br>
      Storage: {{ $item->storage }}<br>
      <br>
    @endif
    @if ($item->learn)
    This book contains {{ count($item->learn) }} crafting recipes:<br>
    @foreach($item->learn as $recipe)
    <a href="{{ route('item.view', $recipeRepository->find($recipe)->result->id) }}">{{ $recipeRepository->find($recipe)->result->name }}</a>,
    @endforeach
    <br>
    @endif
    <br>
    {{ $item->description }}

  </div>
  <div class="col-sm-4">
    <div class="list-group">
      {{ link_to_route("item.craft", "Craft", array("id"=>$item->id), array("class"=>"list-group-item")) }}
      {{ link_to_route("item.recipes", "Recipes", array("id"=>$item->id), array("class"=>"list-group-item")) }}
      {{ link_to_route("item.disassemble", "Disassemble", array("id"=>$item->id), array("class"=>"list-group-item")) }}
    </div>
  </div>
</div>
@stop

@section('content')
<div class="row">
  <div class="col-xs-4">
    {{ $item->name }} ({{$item->type}})<br>
    <br>
    Volume: {{ $item->volume }} Weight: {{ $item->weight }}<br>
      Bash: {{ $item->bashing }}
      Stab: {{ $item->cutting }}
    To-hit bonus: {{ $item->to_hit }}<br>
    Moves per attack: {{ $item->movesPerAttack }}<br>
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
      Materials: {{ Materials::get($item->material[0])->name }}, {{ Materials::get($item->material[1])->name }}<br>
      Environmental protection: {{ $item->enviromental_protection }}<br>
      Warmth: {{ $item->warmth }}<br>
      Storage: {{ $item->storage }}<br>
      <br>
    @endif
    {{ $item->description }}

  </div>
  <div class="col-xs-4">
    <div class="list-group">
      {{ link_to("/craft/$item->id", "Craft", array("class"=>"list-group-item")) }}
      {{ link_to("/recipes/$item->id", "Recipes", array("class"=>"list-group-item")) }}
    </div>
  </div>
</div>
@stop

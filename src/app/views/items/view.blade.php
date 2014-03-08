@section('content')
<div class="row">
  <div class="col-sm-4">
    {{$item->name}}
    ({{{$item->type}}})
    <br>
    {{$item->featureLabels}}
    <br>
    <br>
    Volume: {{{ $item->volume }}} Weight: {{{ $item->weight }}}<br>
      Bash: {{{ $item->bashing }}}
      Stab: {{{ $item->cutting }}}
      To-hit bonus: {{{ $item->to_hit }}}<br>
      Moves per attack: {{{ $item->movesPerAttack }}}<br>
    Materials: {{ $item->materials }}<br>
    @if ($item->canBeCut)
      Can be cut into: {{{ $item->cutResult }}}<br>
    @endif
    @if ($item->isResultOfCutting)
      Can be obtained if you cut items made of {{{ $item->materialToCut }}}<br>
    @endif
    @if ($item->isAmmo)
    Damage: {{{ $item->damage }}}<br>
    Armor-pierce: {{{ $item->pierce }}}<br>
    Range: {{{ $item->range }}}<br>
    Dispersion: {{{ $item->dispersion }}}<br>
    Recoil: {{{ $item->recoil }}}<br>
    Count: {{{ $item->count }}}<br>
    @endif
    @if ($item->isComestible)
      Phase: {{{ $item->phase }}}<br>
      Nutrition: {{{ $item->nutrition }}}<br>
      Quench: {{{ $item->quench }}}<br>
      Enjoyability: {{{ $item->fun }}}<br>
      Spoils in {{{ $item->spoilsIn }}}<br>
      Heal: {{{ $item->heal }}}<br>
    @endif
    @if ($item->isArmor) 
      Covers: {{{ $item->covers }}}<br>
      Coverage: {{{ $item->coverage }}}<br>
      Encumberment: {{{ $item->encumbrance }}}<br>
      Protection: <br>
      <ul>
        <li>Bash: {{{ $item->protection('bash') }}}
        <li>Cut:  {{{  $item->protection('cut') }}}
        <li>Acid: {{{  $item->protection('acid') }}}
        <li>Fire: {{{  $item->protection('fire') }}}
        <li>Elec: {{{  $item->protection('elec') }}}
      </ul>
      Environmental protection: {{{ $item->enviromental_protection }}}<br>
      Warmth: {{{ $item->warmth }}}<br>
      Storage: {{{ $item->storage }}}<br>
      <br>
    @endif
    @if ($item->learn)
    --<br>
    This book contains {{ count($item->learn) }} crafting recipes:<br>
    {{ $item->craftingRecipes }}
    <br>
    @endif
    <br>
    {{{ $item->description }}}

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

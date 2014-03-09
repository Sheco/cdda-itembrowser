@section('title')
{{$item->rawName}} - Cataclysm: Dark Days Ahead
@endsection
@section('content')
@include('items.menu', array('active'=>'view'))
<div class="row">
  <div class="col-md-6">
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
    @if ($item->isTool)
    Maximum {{ $item->max_charges }} charges
    @if ($item->ammo!="NULL")
    of {{ $item->ammo }}
    @endif
    <br>
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
    @if ($item->isBook)
    --<br>
    @if ($item->skill=="none")
    Just for fun.<br>
    @else
    Can bring your {{ $item->skill }} skill to 1<br>
    @if ($item->required_level==0)
    It can be understood by beginners.<br>
    @else
    Requires {{ $item->skill }} level {{ $item->required_level }} to understand.<br>
    @endif
    @endif
    Requires intelligence of {{ $item->intelligence }} to easily read.<br>
    @if ($item->fun!=0)
    Reading this book affects your morale by {{ $item->fun }}<br>
    @endif
    This book takes {{ $item->time }} minutes to read.<br>
    --<br>
    This book contains {{ count($item->learn) }} crafting recipes:<br>
    {{ $item->craftingRecipes }}
    <br>
    @endif
    <br>
    {{{ $item->description }}}

  </div>
</div>
@stop

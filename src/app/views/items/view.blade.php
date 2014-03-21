@section('title')
{{{$item->rawName}}} - Cataclysm: Dark Days Ahead
@endsection
@section('description')
{{{$item->rawName}}} has a volume of {{{ $item->volume }}} and a weight of {{{ $item->weight }}}. It does {{{ $item->bashing }}} bashing damage and {{{ $item->cutting }}} cutting damage. You can find more information here.
@endsection
@section('content')
@include('items.menu', array('active'=>'view'))
<div class="row">
  <div class="col-md-6">
    <h1>{{$item->name}}</h1>
    {{$item->featureLabels}}
    <br>
    <br>
    Volume: {{{ $item->volume }}} Weight: {{ $item->weight }}/{{ $item->weightMetric }}<br>
      Bash: {{{ $item->bashing }}}
      Stab: {{{ $item->cutting }}}
      To-hit bonus: {{{ $item->to_hit }}}<br>
      Moves per attack: {{{ $item->movesPerAttack }}}<br>
      Materials: {{ $item->materials }}<br>
    @if ($item->canBeCut)
    Can be cut into: {{{ $item->cutResultAmount }}} <a href="{{ route('item.view', $item->cutResultItem->id) }}">{{ str_plural($item->cutResultItem->name) }}</a><br>
    @endif
    @if ($item->isResultOfCutting)
    Can be obtained if you cut items made of <a href="{{ route('item.search', array('q'=>$item->materialToCut)) }}">{{{ $item->materialToCut }}}</a><br>
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
    of: {{ $item->ammoTypes }}
    @endif
    @endif
    <br>
    @if($item->isGun)
    Ammunition: {{{ $item->clip_size }}} rounds of {{ $item->ammoTypes }}<br>
    Damage: {{{ $item->ranged_damage }}}<br>
    Range: {{{ $item->range }}}<br>
    Armor-pierce: {{{ $item->pierce }}}<br>
    Dispersion: {{{ $item->dispersion }}}<br>
    Recoil: {{{ $item->recoil }}}<br>
    Reload time: {{{ $item->reload }}}<br>
    @if ($item->burst==0)
    Semi-automatic<br>
    @else
    Burst size: {{{$item->burst}}}
    @endif

    <br>
    @endif
    @if ($item->isComestible)
      Phase: {{{ $item->phase }}}<br>
      Nutrition: {{{ $item->nutrition }}}<br>
      Quench: {{{ $item->quench }}}<br>
      Enjoyability: {{{ $item->fun }}}<br>
      Spoils in {{{ $item->spoils_in }}}<br>
      Heal: {{{ $item->heal }}}<br>
      Stimulant: {{{ $item->stim }}}<br>
      Addiction: {{{ $item->addiction_potential }}}<br>
    @endif
    @if ($item->isArmor) 
      Covers: {{{ $item->covers }}}<br>
      Coverage: {{{ $item->coverage }}}%<br>
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
    @endif
    @if ($item->isBook)
    --<br>
    @if ($item->skill=="none")
    Just for fun.<br>
    @else
    Can bring your {{ $item->skill }} skill to {{ $item->max_level }}<br>

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
    @if ($item->chapters)
    Chapters: {{ $item->chapters }}.<br>
    @endif
    --<br>
    This book contains {{ count($item->learn) }} crafting recipes:<br>
    {{ $item->craftingRecipes }}
    @endif
    <br>
    {{{ $item->description }}}

  </div>
</div>
@stop

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
      @if ($item->hasFlag("SPEAR"))
      Pierce: {{{ $item->cutting }}}
      @elseif ($item->hasFlag("STAB"))
      Stab: {{{ $item->cutting }}}
      @else
      Cut: {{{ $item->cutting }}}
      @endif
      To-hit bonus: {{{ $item->to_hit }}}<br>
      Moves per attack: {{{ $item->movesPerAttack }}}<br>
      Materials: {{ $item->materials }}<br>
      @foreach ($item->qualities as $quality)
      Has level {{{ $quality["level"] }}} <a href="{{ route("item.qualities", $quality["quality"]->id) }}">{{{ $quality["quality"]->name }}}</a> quality.<br>
      @endforeach
    @if ($item->canBeCut)
    Can be cut into: {{{ $item->cutResultAmount }}} <a href="{{ route('item.view', $item->cutResultItem->id) }}">{{ str_plural($item->cutResultItem->name) }}</a><br>
    @endif
    @if ($item->isResultOfCutting)
    Can be obtained if you cut items made of <a href="{{ route('item.materials', $item->materialToCut) }}">{{{ $item->materialToCut }}}</a><br>
    @endif

    @if ($item->count("disassembledFrom"))
    Can be obtained when disassembling: 
    @foreach($item->disassembledFrom as $recipe)
    {{ link_to_route("item.disassemble", $recipe->result->name, $recipe->result->id) }},
    @endforeach
    <br>
    --
    <br>
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
    of: @foreach($item->ammoTypes as $ammo)
      <a href="{{ route("item.view", $ammo->id) }}">{{$ammo->name}}</a>,
    @endforeach
    @endif
    @endif
    <br>
    @if($item->isGun)
    Ammunition: {{{ $item->clip_size }}} rounds of:<br>
    <table>
      <tr>
        <th>Ammo</th>
        <th>Damage</th>
        <th>Noise</th>
      </tr>
    @foreach($item->ammoTypes as $ammo)
    <tr>
      <td><a href="{{ route("item.view", $ammo->id) }}">{{$ammo->name}}</a></td>
      <td class="text-right">{{ $ammo->damage }}</td>
      <td class="text-right">{{ round($item->noise($ammo)) }}</td>
    </tr>
    @endforeach
    </table>
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
      Protection: Bash: 
      {{{ $item->protection('bash') }}}  
      Cut:  {{{  $item->protection('cut') }}}<br>
      Acid: {{{  $item->protection('acid') }}}
      &nbsp;&nbsp;&nbsp;
      Fire: {{{  $item->protection('fire') }}}
      Elec: {{{  $item->protection('elec') }}}<br>
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
    This book contains {{ $item->count("learn") }} crafting recipes:<br>
    {{ $item->craftingRecipes }}
    @endif
    <br>
    {{{ $item->description }}}<br>
    @if ($item->hasFlag("FIT"))
    <br>This piece of clothing fits you perfectly.<br>
    @endif
    @if ($item->hasFlag("SKINTIGHT"))
    <br>This piece of clothing lies close to the skin and layers easily.<br>
    @endif
    @if ($item->hasFlag("POCKETS"))
    <br>This piece of clothing has pockets to warm your hands.<br>
    @endif
    @if ($item->hasFlag("HOOD"))
    <br>This piece of clothing has a hood to keep your head warm.<br>
    @endif
    @if ($item->hasFlag("RAINPROOF"))
    <br>This piece of clothing is designed to keep you dry in the rain.<br>
    @endif
    @if ($item->hasFlag("WATER_FRIENDLY"))
    <br>This piece of clothing performs well even when soaking wet. This can feel good.<br>
    @endif
    @if ($item->hasFlag("WATERPROOF"))
    <br>This piece of clothing won't let water through.  Unless you jump in the river or something like that.<br>
    @endif
    @if ($item->hasFlag("STURDY"))
    <br>This piece of clothing is designed to protect you from harm and withstand a lot of abuse<br>
    @endif
    @if ($item->hasFlag("SWIM_GOGGLES"))
    <br>This piece of clothing allows you to see much further under water.<br>
    @endif

  </div>
</div>
@stop

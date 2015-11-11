@section('title')
{{{$item->rawName}}} - Cataclysm: Dark Days Ahead
@endsection
@section('description')
{{{$item->rawName}}} has a volume of {{{ $item->volume }}} and a weight of {{{ $item->weight }}}. It does {{{ $item->bashing }}} bashing damage and {{{ $item->cutting }}} cutting damage. You can find more information here.
@endsection
@include('items.menu', array('active'=>'view'))
<div class="row">
  <div class="col-md-6">
    <h1>{{$item->symbol}} {{$item->name}}</h1>
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
      Damage per move: {{{ $item->damagePerMove }}}<br>
      Materials: {{ $item->materials }}<br>
      @if ($item->hasFlags)
      Flags: {{ $item->flags }}<br>
      @endif
      @foreach ($item->qualities as $quality)
      Has level {{{ $quality["level"] }}} <a href="{{ route("item.qualities", $quality["quality"]->id) }}">{{{ $quality["quality"]->name }}}</a> quality.<br>
      @endforeach
    @if ($item->canBeCut)
    Can be cut into: 
    @foreach($item->cutResult as $cutResult)
      {{{ $cutResult['amount'] }}} <a href="{{ route('item.view', $cutResult['item']->id) }}">{{ str_plural($cutResult['item']->name) }}</a>,
    @endforeach
    <br>
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
    <table class="tablesorter">
      <thead>
      <tr>
        <th>Ammo</th>
        <th class="text-right">Dmg</th>
        <th style="width: 4em" class="text-right">Noise</th>
      </tr>
      </thead>
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
    @if ($item->isModdable)
      Mod Locations:<br>
      {{ $item->validModLocations }}
    @endif
    @endif

    @if ($item->isGunMod)
    @if ($item->dispersion!=0)
      Dispersion: {{$item->dispersion}}<br>
    @endif

    @if ($item->damageModifier!=0)
      Damage: {{$item->damageModifier}}<br>
    @endif

    @if ($item->clipSizeModifier!=0)
      Magazine: {{$item->clipSizeModifier}}%<br>
    @endif
    @if ($item->recoilModifier!=0)
      Recoil: {{$item->recoilModifier}}<br>
    @endif
    @if ($item->burstModifier!=0)
      Burst: {{$item->burstModifier}}<br>
    @endif
    @if ($item->ammo_modifier!="NULL")
      Ammo: {{$item->ammo_modifier}}<br>
    @endif
      Used on: {{$item->modSkills}}<br>
      Location: {{$item->location}}<br>
    @endif

    <br>
    @if ($item->isConsumable)
      Phase: {{{ $item->phase }}}<br>
      Nutrition: {{{ $item->nutrition }}}<br>
      Quench: {{{ $item->quench }}}<br>
      Enjoyability: {{{ $item->fun }}}<br>
      @if ($item->spoils_in>0)
      Spoils in {{{ $item->spoils_in }}} days<br>
      @endif
      Charges: {{{ $item->charges }}}<br>
      Healthy: {{{ $item->healthy }}}<br>
      Stimulant: {{{ $item->stim }}}<br>
      Addiction: {{{ $item->addiction_potential }}}<br>
    @endif
    @if ($item->isArmor)
      Covers: {{ $item->covers }}<br>
      Coverage: {{{ $item->coverage }}}%<br>
      Encumberment: {{{ $item->encumbrance }}}<br>
      Protection: Bash:
      {{{ $item->protection('bash') }}}
      Cut:  {{{  $item->protection('cut') }}}<br>
      Acid: {{{  $item->protection('acid') }}}
      &nbsp;&nbsp;&nbsp;
      Fire: {{{  $item->protection('fire') }}}
      Elec: {{{  $item->protection('elec') }}}<br>
      Environmental protection: {{{ $item->environmental_protection }}}<br>
      Warmth: {{{ $item->warmth }}}<br>
      Storage: {{{ $item->storage }}}<br>
    @endif

    @if ($item->isContainer)
    @if ($item->rigid=='y')
      This item is rigid.<br>
    @endif
    @if ($item->seals=='y')
      This container can be resealed.<br>
    @endif
    @if ($item->watertight=='y')
      This container is watertight.<br>
    @endif
    @if ($item->preserves=='y')
      This container preserves its contents from spoiling.<br>
    @endif
      This container can store {{ $item->contains }} liters.<br>
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
    @if ($item->hasFlag("OVERSIZE"))
    <br>This piece of clothing is large enough to accommodate mutated anatomy.<br>
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
    @if ($item->hasFlag("SUN_GLASSES"))
    <br>This piece of clothing keeps the glare out of your eyes.<br>
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
    @if ($item->hasFlag("LEAK_DAM") && $item->hasFlag("RADIOACTIVE"))
    <br>The casing of this item has cracked, revealing an ominous green glow. (when damaged).<br>
    @endif
    @if ($item->hasFlag("LEAK_ALWAYS") && $item->hasFlag("RADIOACTIVE"))
    <br>This object is surrounded by a sickly green glow.<br>
    @endif

  </div>
</div>
<script>
$(function() {
  $(".tablesorter").tablesorter({
    sortList: [[1,0]]
  });
});
</script>

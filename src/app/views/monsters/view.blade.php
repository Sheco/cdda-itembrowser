@section('title')
Monster: {{{$monster->name}}} - Cataclysm: Dark Days Ahead
@endsection
@section('description')
Monster: {{{$monster->name}}}
@endsection
<div class="row">
<div class="col-md-6">
<h4>{{ $monster->symbol }} {{$monster->niceName}}</h4>
<p>{{$monster->description}}</p>
Monster ID: {{{$monster->id}}}
<br>
<br>
<table>
<tr>
  <td colspan="2" width="50%"><b>General</b></td>
  <td colspan="2" width="50%"><b>Combat</b></td>
</tr>
<tr>
  <td>HP:</td>
  <td>{{{$monster->hp}}}</td>

  <td>Melee skill:</td>
  <td>{{{$monster->melee_skill}}}</td>
</tr>
<tr>
  <td>Species:</td>
  <td>{{$monster->species}}</td>

  <td>Dodge skill:</td>
  <td>{{{$monster->dodge}}}</td>
</tr>
<tr>
  <td>Size:</td>
  <td>{{$monster->size}}</td>

  <td>Damage:</td>
  <td>{{$monster->damage }}</td>
</tr>
<tr>
  <td>Material:</td>
  <td>{{{$monster->material}}}</td>
</tr>
<tr>
  <td>Speed:</td>
  <td>{{{$monster->speed}}}</td>
</tr>
<tr>
  <td colspan="2"><br><b>Protection</b></td>
  <td colspan="2"><br><b>Triggers</b></td>
</tr>
<tr>
  <td>Bash armor:</td>
  <td>{{{$monster->armor_bash}}}</td>

  <td>Death:</td>
  <td>{{{$monster->death_function}}}</td>
</tr>
<tr>
  <td>Cut armor:</td>
  <td>{{{$monster->armor_cut}}}</td>

  <td valign="top">Attacking:</td>
  <td>{{$monster->special_attacks}}</td>
</tr>
<tr>
  <td></td>
  <td></td>
  <td>When hit:</td>
  <td>{{{$monster->specialWhenHit}}}</td>
</tr>
<tr>
  <td colspan="4"><br><b>Other</b></td>
</tr>
<tr>
  <td>Aggresiveness:</td>
  <td>{{{$monster->aggression}}}</td>
  <td>Morale:</td>
  <td>{{{$monster->morale}}}</td>
</tr>
<tr>
  <td>Difficulty:</td>
  <td>{{{$monster->diff}}}</td>
</tr>
<tr>
  <td valign="top">Flags:</td>
  <td colspan="3">{{{$monster->flags}}}</td>
</tr>
</table>
</div>
</div>

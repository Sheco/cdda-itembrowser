@section('title')
{{$item->rawName}} (disassemble) - Cataclysm: Dark Days Ahead
@endsection
@section('content')
@include('items.menu', array('active'=>'disassemble'))
  <a href="{{ route("item.view", array("id"=>$item->id)) }}">{{ $item->name }}</a>
@if (count($item->disassembly)>0)
 can be disassembled to obtain the components in this recipe.<br>
@else
 can't be disassembled.
@endif
<br>
<div class="row">
<div class="col-md-6">
@foreach ($item->disassembly as $recipe)
  {{link_to_route("item.view", $recipe->result->name, array("id"=>$recipe->result->id))}}<br>
  Skill used: {{{ $recipe->skill_used }}} <br>
  Required skills: {{ $recipe->skillsRequired }} <br>
  Difficulty: {{{ $recipe->difficulty }}}<br>
  Reversible: {{{ $recipe->reversible }}}<br>
  Learn Automatically: {{{ $recipe->autolearn }}}<br>
  Time to complete: {{{ $recipe->time }}}<br>
  @if ($recipe->hasTools)
  {{$recipe->tools}}<br>
  @endif

  @if ($recipe->hasComponents)
  {{$recipe->components}}<br>
  @endif
<br>
@endforeach
</div>

</div>
@stop

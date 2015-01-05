@section('title')
{{{$item->rawName}}} (disassemble) - Cataclysm: Dark Days Ahead
@endsection
@section('description')
@if ($item->count("disassembly")>0)
{{{$item->rawName}}} can be disassembled. You can find more information here.
@else
{{{$item->rawName}}} can't be disassembled.
@endif
@endsection
@include('items.menu', array('active'=>'disassemble'))
<h1>
  {{$item->symbol}} <a href="{{ route("item.view", array("id"=>$item->id)) }}">{{ $item->name }}</a>
@if ($item->count("disassembly")>0)
 can be disassembled to obtain the following components.<br>
@else
 can't be disassembled.
@endif
</h1>
<div class="row">
<div class="col-md-6">
@foreach ($item->disassembly as $recipe)
  @if ($recipe->hasTools || $recipe->hasQualities)
  Tools required:<br>
  @if ($recipe->hasQualities)
  @foreach ($recipe->qualities as $q)
  &gt; {{{$q["amount"]}}} tool with <a href="{{ route("item.qualities", $q["quality"]->id) }}">{{{ $q["quality"]->name }}}</a> quality of {{{ $q["level"] }}}<br>
  @endforeach
  @endif
  @if ($recipe->hasTools)
  {{$recipe->tools}}<br>
  @endif
  @endif

  @if ($recipe->hasComponents)
  Components obtained:<br>
  {{$recipe->components}}<br>
  @endif
  --<br>
<br>
@endforeach
  Note: Components obtained yield only one component per group, if the item was crafted, it yields the component used, otherwise it yields the first component.<br>
</div>

</div>

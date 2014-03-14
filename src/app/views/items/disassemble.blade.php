@section('title')
{{{$item->rawName}}} (disassemble) - Cataclysm: Dark Days Ahead
@endsection
@section('description')
@if (count($item->disassembly)>0)
{{{$item->rawName}}} can be disassembled. You can find more information here.
@else
{{{$item->rawName}}} can't be disassembled.
@endif
@endsection
@section('content')
@include('items.menu', array('active'=>'disassemble'))
  <a href="{{ route("item.view", array("id"=>$item->id)) }}">{{ $item->name }}</a>
@if (count($item->disassembly)>0)
 can be disassembled to obtain the following components.<br>
@else
 can't be disassembled.
@endif
<br>
<div class="row">
<div class="col-md-6">
@foreach ($item->disassembly as $recipe)
  @if ($recipe->hasTools)
  Tools required:<br>
  {{$recipe->tools}}<br>
  @endif
  @if ($recipe->hasComponents)
  Components obtained:<br>
  {{$recipe->components}}<br>
  @endif
  --<br>
<br>
@endforeach
</div>

</div>
@stop

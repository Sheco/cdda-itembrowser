@section('title')
{{{$item->rawName}}} (craft) - Cataclysm: Dark Days Ahead
@endsection
@section('description')
@if (count($item->recipes)>0)
{{{$item->rawName}}} can be crafted. You can find more information here.
@else
{{{$item->rawName}}} can't be crafted.
@endif
@endsection
@section('content')
@include('items.menu', array('active'=>'craft'))
  <a href="{{ route("item.view", array("id"=>$item->id)) }}">{{ $item->name }}</a>
@if (count($item->recipes)>0)
 can be crafted with the following recipes<br>
@else
 can't be crafted
@endif
<br>
<div class="row">
<div class="col-md-6">
@foreach ($item->recipes as $recipe)
  Skill used: {{{ $recipe->skill_used }}} <br>
  Required skills: {{ $recipe->skillsRequired }} <br>
  Difficulty: {{{ $recipe->difficulty }}}<br>
  Time to complete: {{{ $recipe->time }}}<br>
  @if ($recipe->hasTools)
  {{$recipe->tools}}<br>
  @endif

  @if ($recipe->hasComponents)
  {{$recipe->components}}<br>
  @endif
@if ($recipe->book_learn)
--<br>
This recipe can be learned reading the following books:<br>
@foreach($recipe->book_learn as $book)
<a href="{{ route('item.view', $book[0]) }}">{{{ $itemRepository->find($book[0])->name }}} ({{{ $book[1] }}})</a><br>
@endforeach
@endif
<br>
@endforeach
</div>
</div>
@stop

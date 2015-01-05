@section('title')
{{{$item->rawName}}} (craft) - Cataclysm: Dark Days Ahead
@endsection
@section('description')
@if ($item->count("recipes")>0)
{{{$item->rawName}}} can be crafted. You can find more information here.
@else
{{{$item->rawName}}} can't be crafted.
@endif
@endsection
@include('items.menu', array('active'=>'craft'))
<h1>
  {{$item->symbol}} <a href="{{ route("item.view", array("id"=>$item->id)) }}">{{ $item->name }}</a>
@if ($item->count("recipes")>0)
 can be crafted with the following recipes<br>
@else
 can't be crafted
@endif
</h1>
<div class="row">
<div class="col-md-6">
@foreach ($item->recipes as $recipe)
  Skill used: {{{ $recipe->skill_used }}} <br>
  Required skills: {{ $recipe->skillsRequired }} <br>
  Difficulty: {{{ $recipe->difficulty }}}<br>
  Time to complete: {{{ $recipe->time }}}<br>
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
  Components required:<br>
  {{$recipe->components}}<br>
  @endif
@if ($recipe->canBeLearned)
--<br>
This recipe can be found in the following books when {{$recipe->skill_used}} is at least the required level:<br>
@foreach($recipe->booksTeaching as $book)
<a href="{{ route('item.view', $book[0]->id) }}">{{{ $book[0]->name }}} (level {{{ $book[1] }}})</a><br>
@endforeach
@endif
<br>
@endforeach
</div>
</div>

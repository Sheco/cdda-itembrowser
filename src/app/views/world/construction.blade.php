@section("title")
Construction: Cataclysm Dark Days Ahead
@stop
<h3>{{$data->description}}
@if ($data->comment!="")
({{$data->comment}})
@endif
</h3>
Category: {{ link_to_route("construction.categories", $data->category, $data->category) }}<br>
Difficulty: {{$data->difficulty}} ({{$data->skill}})<br>
Time: {{$data->time}} minutes<br>
@if ($data->has_pre_terrain)
Required terrain: {{$data->pre_terrain->symbol}} {{$data->pre_terrain->name}}<br>
@endif
@if ($data->pre_flags)
Required flags: {{$data->pre_flags}}<br>
@endif
@if ($data->has_post_terrain)
Result: {{$data->post_terrain->symbol}} {{$data->post_terrain->name}}<br>
@endif
@if ($data->requiresQualities)
Tools required:<br>
{{$data->qualities}}<br>
@if ($data->requiresTools)
{{$data->tools}}<br>
@endif
@endif
@if ($data->requiresComponents)
Components required:<br>
{{$data->components}}<br>
@endif

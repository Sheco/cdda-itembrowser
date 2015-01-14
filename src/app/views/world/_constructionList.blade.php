<table class="table table-bordered">
<thead>
<tr>
    <th>Construction</th>
    <th></th>
    <th>Source</th>
    <th></th>
    <th>Result</th>
</tr>
</thead>
@foreach($data as $d) 
<tr>
    <td>{{ link_to_route("construction.view", $d->description, $d->repo_id); }}</td>
@if ($d->has_pre_terrain)
    <td>{{$d->pre_terrain->symbol}}</td>
    <td>{{$d->pre_terrain->name}}</td>
@elseif ($d->pre_flags)
    <td></td>
    <td>is:{{$d->pre_flags}}</td>
@else
    <td></td>
    <td></td>
@endif
@if ($d->has_post_terrain) 
    <td>{{$d->post_terrain->symbol}}</td>
    <td>{{$d->post_terrain->name}}</td>
@else
    <td></td>
    <td></td>
@endif
</tr>
@endforeach
</table>


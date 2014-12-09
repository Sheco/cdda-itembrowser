<table class="table table-bordered tablesorter">
<thead>
<tr>
  <th>Name</th>
  <th>HP</th>
  <th>Dmg</th>
  <th>Melee sk</th>
  <th>Dodge sk</th>
</tr>
</thead>
@foreach ($data as $monster)
<tr>
  <td>{{ link_to_route('monster.view', $monster->niceName, array($monster->id)) }}</td>
  <td>{{{ $monster->hp }}}</td>
  <td>{{{ $monster->damage }}}</td>
  <td>{{{ $monster->melee_skill }}}</td>
  <td>{{{ $monster->dodge }}}</td>
</tr>
@endforeach
</table>
<script>
$(function() {
      $(".tablesorter").tablesorter({
            sortList: [[0,0]]
                    });
});
</script>

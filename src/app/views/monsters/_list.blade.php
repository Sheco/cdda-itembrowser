<table class="table table-bordered tablesorter">
<thead>
<tr>
  <th></th>
  <th>Name</th>
  <th>HP</th>
  <th>Dmg</th>
  <th>MaxDmg</th>
  <th>Melee sk</th>
  <th>Dodge sk</th>
</tr>
</thead>
@foreach ($data as $monster)
<tr>
  <td>{{ $monster->symbol }}</td>
  <td><a href="{{ route('monster.view', array($monster->id)) }}">{{ $monster->niceName }}</a></td>
  <td>{{{ $monster->hp }}}</td>
  <td>{{{ $monster->damage }}}</td>
  <td>{{{ $monster->maxDamage }}}</td>
  <td>{{{ $monster->melee_skill }}}</td>
  <td>{{{ $monster->dodge }}}</td>
</tr>
@endforeach
</table>
<script>
$(function() {
      $(".tablesorter").tablesorter({
            sortList: [[1,0]]
                    });
});
</script>

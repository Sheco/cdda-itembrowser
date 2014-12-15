<table class="table table-bordered tablesorter">
<thead>
<tr>
  <th></th>
  <th>Name</th>
  <th>HP</th>
  <th>Dmg</th>
  <th>MaxDmg</th>
  <th>AvgDmg</th>
  <th>Melee sk</th>
  <th>Dodge sk</th>
</tr>
</thead>
@foreach ($data as $monster)
<tr>
  <td>{{ $monster->symbol }}</td>
  <td><a href="{{ route('monster.view', array($monster->id)) }}">{{ $monster->niceName }}</a></td>
  <td class="text-right">{{{ $monster->hp }}}</td>
  <td class="text-right">{{{ $monster->damage }}}</td>
  <td class="text-right">{{{ $monster->maxDamage }}}</td>
  <td class="text-right">{{{ $monster->avgDamage }}}</td>
  <td class="text-right">{{{ $monster->melee_skill }}}</td>
  <td class="text-right">{{{ $monster->dodge }}}</td>
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

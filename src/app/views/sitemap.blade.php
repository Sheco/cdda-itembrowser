{{ '<?xml version="1.0" encoding="UTF-8"?>' }}

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
  xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
    xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">
@foreach ($items as $item)
  <url>
    <loc>{{ route("item.view", $item->id) }}</loc>
  </url>
  <url>
    <loc>{{ route("item.craft", $item->id) }}</loc>
  </url>
  <url>
    <loc>{{ route("item.disassemble", $item->id) }}</loc>
  </url>
@foreach ($item->toolCategories as $category)
  <url>
    <loc>{{ route("item.recipes", array($item->id, $category)) }}</loc>
  </url>
@endforeach
@endforeach
@foreach($armorParts as $i)
  <url>
    <loc>{{ route("item.armors", array($i)) }}</loc>
  </url>
@endforeach
@foreach($gunSkills as $i)
  <url>
    <loc>{{ route("item.guns", array($i)) }}</loc>
  </url>
@endforeach
  <url>
    <loc>{{ route("item.melee") }}</loc>
  </url>
@foreach($bookTypes as $i)
  <url>
    <loc>{{ route("item.books", array($i)) }}</loc>
  </url>
@endforeach
@foreach($qualities as $i)
  <url>
    <loc>{{ route("item.qualities", array($i)) }}</loc>
  </url>
@endforeach
@foreach($materials as $i)
  <url>
    <loc>{{ route("item.materials", array($i)) }}</loc>
  </url>
@endforeach
@foreach($flags as $i)
  <url>
    <loc>{{ route("item.flags", array($i)) }}</loc>
  </url>
@endforeach
@foreach($skills as $i)
@for($j=1; $j<=10; $j++) 
  <url>
    <loc>{{ route("item.skills", array($i, $j)) }}</loc>
  </url>
@endfor
@endforeach
@foreach($consumables as $i)
  <url>
    <loc>{{ route("item.consumables", array($i)) }}</loc>
  </url>
@endforeach
@foreach($monsterGroups as $i)
  <url>
    <loc>{{ route("monster.groups", array($i->name)) }}</loc>
  </url>
@endforeach
@foreach($monsterSpecies as $i)
  <url>
    <loc>{{ route("monster.species", array($i)) }}</loc>
  </url>
@endforeach
@foreach($monsters as $monster)
  <url>
    <loc>{{ route("monster.view", array($monster->id)) }}</loc>
  </url>
@endforeach
</urlset>

@section('content')
<div class="row">
  <div class="col-md-6">
<h1>Item browser</h1>

<p>
Version: {{{ $version }}}
</p>

<p>
This is a simple tool to browse through the items and recipes available in <a href="http://en.cataclysmdda.com">Cataclysm: Dark Days Ahead</a>,
this is done by reading the game's data files and creating an optimized database linking everything together.
</p>

<p>
Crafting could be as simple as looking at your hammer and being able to know what you can do with it.
</p>

<p>
<h2>Common useful items</h2>
It's always nice to make a {{link_to_route('item.recipes', 'fire', array("id"=>"fire")) }}. There are lots of things you can do with an {{link_to_route('item.view', 'integrated toolset', "toolset") }}.<br>
<br>
To repair your armor and clothes, you can cut some 
{{ link_to_route("item.materials", "items made of wood", "wood") }} 
 to obtain 
{{ link_to_route("item.view", "skewers", "skewer") }}, 
 with that you can 
{{ link_to_route("item.craft", "craft a wooden needle", "needle_wood") }}, 
 then you need 
{{ link_to_route("item.view", "thread", "thread") }}
 so you will have to 
{{ link_to_route("item.disassemble", "disassemble a rag", "rag") }}, 
 which can be obtained by cutting 
{{ link_to_route("item.materials", "items made of cotton", "cotton") }}.
<br>
</p>

<h2>There are two copies of the database</h2>
<p>
On the top bar, there are two links, stable and development, each one points to a copy of the database for the latest stable release and an up-to-date git master copy (updated nightly), respectively.
</p>

<hr>
<p>
The source code for this item browser is available at <a href="https://github.com/Sheco/cdda-itembrowser">Github</a>.
</p>
</div>

<div class="col-md-3">
<ul class="nav nav-pills nav-stacked">
<h2>Item catalogs</h2>

<li><a href="{{ route('item.armors') }}">Clothing</a></li>
<li><a href="{{ route("item.melee") }}">Melee</a></li>
<li><a href="{{ route('item.guns') }}">Ranged weapons</a></li>
<li><a href="{{ route('item.consumables') }}">Consumables</a></li>
<li><a href="{{ route('item.books') }}">Books</a></li>
<li><a href="{{ route('item.materials') }}">Materials</a></li>
<li><a href="{{ route('item.qualities') }}">Qualities</a></li>
<li><a href="{{ route("item.flags") }}">Flags</a></li>
<li><a href="{{ route("item.skills") }}">Skills</a></li>
<li><a href="{{ route("item.gunmods", array("rifle", "sights")) }}">Gun mods</a></li>

<h2>Monster catalogs</h2>
<li>{{ link_to_route('monster.groups', 'Groups') }}</li>
<li>{{ link_to_route('monster.species', 'Species') }}</li>
</ul>
</div>
</div>
@stop

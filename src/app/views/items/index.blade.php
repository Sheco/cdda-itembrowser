@section('content')
<div class="row">
  <div class="col-md-6">
<h1>Item browser</h1>

<p>
Version: {{{ $version }}}
</p>

<p>
This is a simple tool to browse through the items and recipes available in <a href="http://en.cataclysmdda.com">Cataclysm: Dark Days Ahead</a>.
</p>

<p>
Crafting could be as simple as looking at your hammer and being able to know what you can do with it.
</p>

<p>
<h2>Common useful items</h2>
{{link_to_route('item.recipes', 'nearby fire', array("id"=>"fire")) }},
{{link_to_route('item.view', 'integrated toolset', "toolset") }}.<br>
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
If you have any requests or if you find a bug, please let me know at <a href="mailto:sduran@estilofusion.com">sduran@estilofusion.com</a>
</p>
</div>

<div class="col-md-3">
<ul class="nav nav-pills nav-stacked">
<h2>Item catalogs</h2>

<li><a href="{{ route('item.armor', 'head') }}">Clothing</a></li>
<li><a href="{{ route("item.melee") }}">Melee</a></li>
<li><a href="{{ route('item.gun', 'archery') }}">Ranged weapons</a></li>
<li><a href="{{ route('item.comestibles', 'drink') }}">Comestibles/Consumables</a></li>
<li><a href="{{ route('item.books', 'engineering') }}">Books</a></li>
<li><a href="{{ route('item.materials') }}">Materials</a></li>
<li><a href="{{ route('item.qualities') }}">Qualities</a></li>
</ul>
</div>
</div>
@stop

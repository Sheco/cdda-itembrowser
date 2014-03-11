@section('content')
<h3>Crafting browser</h3>

<p>
This is a simple tool to browse through the items and recipes available in <a href="http://en.cataclysmdda.com">Cataclysm: Dark Days Ahead</a>.
</p>

<p>
Crafting could be as simple as looking at your hammer and being able to know what you can do with it.
</p>

<p>
<h4>Common useful items</h4>
{{link_to_route('item.view', 'stone hammer', "primitive_hammer") }}, 
{{link_to_route('item.view', 'stone axe', "primitive_axe") }}, 
{{link_to_route('item.view', 'wood axe', "ax") }}, 
{{link_to_route('item.view', 'stone knife', "primitive_knife") }}, 
{{link_to_route('item.search', 'survivor items', array("q"=>"survivor")) }},
{{link_to_route('item.recipes', 'nearby fire', array("id"=>"fire")) }} 
and 
{{link_to_route('item.recipes', 'integrated toolset', array("id"=>"toolset")) }}.
</p>


<p>
<h4>Material search</h4>
For example: {{ link_to_route('item.search', 'wood', array('q'=>'wood')) }},
{{ link_to_route('item.search', 'hard steel', array('q'=>'hard steel')) }},
{{ link_to_route('item.search', 'iron', array('q'=>'iron')) }},
{{ link_to_route('item.search', 'cotton', array('q'=>'cotton')) }},
{{ link_to_route('item.search', 'bone', array("q"=>"bone")) }}, 
{{ link_to_route('item.search', 'kevlar', array("q"=>"kevlar")) }}.
</p>

<p>
On the top bar, there are two links, stable and development, each one points to a copy of the database for the latest stable release and an up-to-date git master copy (updated nightly), respectively.
</p>

<hr>
<p>
If you have any requests or if you find a bug, please let me know at <a href="mailto:sduran@estilofusion.com">sduran@estilofusion.com</a>
</p>

@stop

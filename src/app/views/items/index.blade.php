@section('content')
<h3>Crafting browser</h3>

<p>
This is a simple tool to browse through the items and recipies available in Cataclysm: Dark Days Ahead.
</p>

<p class="alert alert-info">
March 2014: Now you can search for materials, for example:
{{ link_to_route('item.search', 'wood', array('q'=>'wood')) }},
{{ link_to_route('item.search', 'hard steel', array('q'=>'hard steel')) }},
{{ link_to_route('item.search', 'iron', array('q'=>'iron')) }},
{{ link_to_route('item.search', 'cotton', array('q'=>'cotton')) }}.
</p>

<p>
Please use the search field on the top right corner of this page to look for an item. You can check the 
item's properties, then check how it can be crafted and even see what can craft using that item.
</p>

<p>
On the top bar, there are two links, stable and development, each one points to a copy of the database for the latest stable release and an up-to-date git master copy (updated nightly), respectively.
</p>

<p>
Try it, you can search for 
{{link_to_route('item.search', 'Hammers', array("q"=>"hammer")) }}, 
{{link_to_route('item.search', 'Bones', array("q"=>"bone")) }}, 
{{link_to_route('item.search', 'Kevlar', array("q"=>"kevlar")) }}.
Some other useful items to look at are 
{{link_to_route('item.recipes', 'nearby fire', array("id"=>"fire")) }} 
and 
{{link_to_route('item.recipes', 'integrated toolset', array("id"=>"toolset")) }}.
</p>

<p>
You can also search by the item's symbol, for example 
{{link_to_route('item.search', '% is Food', array("q"=>"%")) }}, 
{{link_to_route('item.search', '? are Books', array("q"=>"?"))}}
</p>


<p>
Crafting could be as "simple" as looking at your hammer and being able to see what you can do with it.
</p>

<hr>
<p>
If you have any requests or if you find a bug, please let me know at <a href="mailto:sduran@estilofusion.com">sduran@estilofusion.com</a>
</p>

@stop

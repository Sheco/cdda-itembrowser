@section('content')
<h3>Crafting browser</h3>

<p>
This is a simple tool to browse through the items and recipies available in Cataclysm: Dark Days Ahead.
</p>

<p>
It's something of a mockup of an idea to improve the user interface.
</p>

<p>
Please use the search field on the top right corner of this page to look for an item. You can check the 
item's properties, then check how it can be crafted and even see what can craft using that item.
</p>

<p>
Try it, you can search for 
{{link_to_route('item.search', 'Hammers', ["q"=>"hammer"]) }}, 
{{link_to_route('item.search', 'Bones', ["q"=>"bone"]) }}, 
{{link_to_route('item.search', 'Kevlar', ["q"=>"kevlar"]) }}.
Some other useful items to look at are 
{{link_to_route('item.recipes', 'nearby fire', ["id"=>"fire"]) }} 
and 
{{link_to_route('item.recipes', 'integrated toolset', ["id"=>"toolset"]) }}.
</p>

<p>
You can also search by the item's symbol, for example 
{{link_to_route('item.search', 'Food', ["q"=>"%"]) }}, 
{{link_to_route('item.search', 'Books', ["q"=>"?"])}}
</p>


<p>
Crafting could be as "simple" as looking at your hammer and being able to see what you can do with it.
</p>

<p>
Beware, this is just a prototype, it's definitely not optimized, nor thoroughly tested.
</p>

@stop

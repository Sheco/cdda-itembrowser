<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#item-menu">
        <span class="sr-only">Toggle menu</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      {{ link_to_route($areas["view"]["route"], "Menu", array("id"=>$item->id), array("class"=>"navbar-brand")) }}
    </div>

    <div class="collapse navbar-collapse" id="item-menu">
      <ul class="nav navbar-nav">
        @foreach($areas as $area=>$data)
        <li{{ $area==$active?' class="active"':''}}>{{ link_to_route($data["route"], $data["label"], array("id"=>$item->id)) }}
        @endforeach
      </ul>
    </div>
  </div>
</nav>

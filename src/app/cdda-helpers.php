<?php
function colorToCSS($color) {
  $assoc = array(
    ""=>"black",
    "ltgray"=>"LightGray",
    "ltgreen"=>"LightGreen",
    "ltblue"=>"DodgerBlue",
    "dkgray"=>"DarkGray",
    "ltcyan"=>"Cyan",
    "cyan"=>"DarkCyan",
    "ltred"=>"LightCoral",
    "magenta"=>"DarkMagenta",
    "pink"=>"HotPink",
  );
  if(isset($assoc[$color]))
    return $assoc[$color];
  return $color;
}

function colorPairToCSS($color)
{
  if($color[1]=="_")
    $color = substr($color, 2);

  $color = explode("_", "{$color}_");
  $foreground = $color[0];
  $background = $color[1];

  return array(
    colorToCSS($foreground),
    colorToCSS($background)
  );
}


<?php
namespace Presenters;

class Terrain extends \Robbo\Presenter\Presenter
{
    public function presentSymbol()
    {
        list($fg, $bg) = colorPairToCSS($this->object->color);
        return "<span style=\"color: $fg; background: $bg\">{$this->object->symbol}</span>";
    }
}

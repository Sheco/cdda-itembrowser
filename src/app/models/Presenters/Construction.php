<?php

namespace Presenters;

class Construction extends \Robbo\Presenter\Presenter
{
    public function presentQualities()
    {
        $out = array();
        foreach($this->object->qualities as $group) {
            $group = array_map(function($q) {
                $link = link_to_route("item.qualities", $q->quality->name, $q->id);
                return "1 tool with $link quality of $q->level or more";
            }, $group);
            $out[] = "> ".join(" <strong>OR</strong> ", $group);
        }
        return implode("<br> ", $out);
    }

    public function presentTools()
    {
        $out = array();
        foreach($this->object->tools as $group) {
            $group = array_map(function($t) {
                $link = link_to_route("item.view", $t->item->name, $t->item->id);
                return $link. ($t->charges!=0? " ({$t->charges} charges)": "");
            }, $group);
            $out[] = "> ". join(" <strong>OR</strong> ", $group);
        }
        return implode("<br>", $out);
    }

    public function presentComponents()
    {
        $out = array();
        foreach($this->object->components as $group) {
            $group = array_map(function($c) {
                $link = link_to_route("item.view", $c->item->name, $c->item->id);
                return "$c->amount $link";
            }, $group);
            $out[] = "> ". join(" <strong>OR</strong> ", $group);
        }
        return implode("<br> ", $out);
    }
}

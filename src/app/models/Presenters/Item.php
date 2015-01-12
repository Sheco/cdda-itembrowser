<?php
namespace Presenters;

class Item extends \Robbo\Presenter\Presenter
{
    public function presentSymbol()
    {
        $symbol = $this->object->symbol;
        if ($symbol == " ") {
            return "&nbsp;";
        }

        return "<span style=\"color: $this->color\">".htmlspecialchars($symbol)."</span>";
    }

    public function presentRawName()
    {
        return ucfirst($this->object->name);
    }

    public function presentVolume()
    {
        return $this->object->volume === null ? "N/A" : $this->object->volume;
    }

    public function presentWeight()
    {
        $weight = $this->object->weight;
        if ($weight === null) {
            return;
        }

        return number_format($weight/453.6, 2)." lbs";
    }

    public function presentWeightMetric()
    {
        $weight = $this->object->weight;
        if ($weight === null) {
            return;
        }

        return number_format($weight/1000, 2).' kg';
    }

    public function presentBashing()
    {
        return $this->object->bashing ?: "0";
    }

    public function presentCutting()
    {
        return $this->object->cutting ?: "0";
    }

    public function presentToHit()
    {
        return $this->object->to_hit ?: "N/A";
    }

    public function presentMovesPerAttack()
    {
        return $this->object->moves_per_attack ?: "N/A";
    }

    public function presentRecipes()
    {
        return array_map(function ($recipe) {
            return $recipe->getPresenter();
        }, $this->object->recipes);
    }

    public function presentDisassembly()
    {
        return array_map(function ($recipe) {
            return $recipe->getPresenter();
        }, $this->object->disassembly);
    }

    public function presentMaterials()
    {
        return implode(", ", array_map(function ($material) {
            return link_to_route("item.materials", $material->name, $material->ident);
        }, $this->object->materials));
    }

    public function presentFlags()
    {
        $invert = array_flip($this->object->flags);

        if (empty($invert)) {
            return "None";
        }

        return implode(", ", array_map(function ($flag) {
            return link_to_route("item.flags", $flag, $flag);
        }, $invert));
    }

    public function presentFeatureLabels()
    {
        $badges = array();
        if ($this->count("toolFor")) {
            $badges[] = '<a href="'.route("item.recipes", $this->object->id).'"><span class="label label-success">recipes: '.$this->count("toolFor").'</span></a>';
        }
        if ($this->count("disassembly")) {
            $badges[] = '<a href="'.route("item.disassemble", $this->object->id).'"><span class="label label-info">disassemble</span></a>';
        }
        if ($this->count("recipes")) {
            $badges[] = '<a href="'.route("item.craft", $this->object->id).'"><span class="label label-default">craft</span></a>';
        }

        return implode(" ", $badges);
    }

    public function presentCutResultAmount()
    {
        $cutresult = $this->object->cutResult;

        return $cutresult[0];
    }

    public function presentCutResultItem()
    {
        $cutresult = $this->object->cutResult;

        return $cutresult[1];
    }

    public function presentCraftingRecipes()
    {
        $recipes = array();
        foreach ($this->object->learn as $recipe) {
            $recipes[] = link_to_route('item.view', $recipe->result->name, $recipe->result->id);
        }

        return implode(", ", $recipes);
    }

    public function presentCovers()
    {
        if (!$this->object->covers) {
            return "none";
        }

        return implode(", ", array_map(function($cover) {
            return link_to_route('item.armors', strtolower($cover), strtolower($cover));
        }, $this->object->covers));
    }

    public function presentSpoilsIn()
    {
        return number_format($this->object->spoils_in/24, 2)." days";
    }

    public function presentStim()
    {
        return ($this->object->stim*5)." mins";
    }

    public function presentValidModLocations()
    {
        $ret = array();
        $parts = $this->object->valid_mod_locations;
        foreach ($parts as $part) {
            $ret[] = "$part[1] ".link_to_route("item.gunmods", $part[0], array($this->object->skill, $part[0]));
        }

        return implode("; ", $ret);
    }

    public function presentModSkills()
    {
        $ret = array();
        foreach ($this->mod_targets as $target) {
            $ret[] = link_to_route("item.guns", $target, $target);
        }

        return implode(", ", $ret);
    }

    public function presentClipSizeModifier()
    {
        return sprintf("%+d", $this->object->clip_size_modifier);
    }

    public function presentDamageModifier()
    {
        return sprintf("%+d", $this->object->damage_modifier);
    }

    public function presentBurstModifier()
    {
        return sprintf("%+d", $this->object->burst_modifier);
    }

    public function presentRecoilModifier()
    {
        return sprintf("%+d", $this->object->recoil_modifier);
    }
}

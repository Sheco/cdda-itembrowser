<?php

trait MagicModel
{
    public function __get($name)
    {
        $method = "get".str_replace(" ", "", ucwords(str_replace("_", " ", $name)));

        if (method_exists($this, $method)) {
            return $this->{$method}();
        }

        if (isset($this->data->$name)) {
            return $this->data->$name;
        }

        return;
    }
}

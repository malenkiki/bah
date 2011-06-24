<?php

class a
{
    private $count = 0;

    public function __construct($arr = array())
    {
        $this->value = $arr;
        $this->count = count($arr);
    }

    public function length()
    {
        return new n($this->count);
    }

    public function has($thing)
    {
        return in_array($thing, $this->value);
    }

    public function add($thing)
    {
        $this->value[] = $thing;
        $this->count++;
    }

    public function implode($sep = '')
    {
        // TODO test if each object has toString method or is simple string
        return new s(implode($sep, $this->value));
    }

    public function __toString()
    {
        return (string) $this->count;
    }
}

<?php

namespace Malenki\Bah;

class A implements \Iterator
{
    private $count = 0;
    private $position = null;

    public function __construct($arr = array())
    {
        $this->value = $arr;
        $this->count = count($arr);
        $this->position = new n(0);
    }

    public function current()
    {
        return $this->value[$this->position->value];
    }
    public function key()
    {
        return $this->position;
    }
    public function next()
    {
        $this->position->incr();
    }
    public function rewind()
    {
        $this->position->value = 0;
    }
    public function valid()
    {
        return isset($this->value[$this->position->value]);
    }

    public function length()
    {
        return new N($this->count);
    }

    public function take($idx)
    {
        return $this->value[$idx];
    }

    //TODO: add method lastButOne()
    public function last()
    {
        return $this->value[$this->length()->p()->value];
    }
    
    public function first()
    {
        return $this->value[0];
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
        return new S(implode($sep, $this->value));
    }

    public function __toString()
    {
        return (string) $this->count;
    }
}

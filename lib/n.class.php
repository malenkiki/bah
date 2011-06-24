<?php

class n
{
    public function __construct($num = 0)
    {
        $this->value = $num;
    }

    public function n()
    {
        return new self($this->value + 1);
    }

    public function p()
    {
        return new self($this->value - 1);
    }

    public function plus()
    {
    }

    public function minus()
    {
    }

    public function divide()
    {
    }

    public function roman()
    {
    }

    public function greek()
    {
    }

    public function arabian()
    {
    }

    public function hebrew()
    {
    }

    public function hex()
    {
    }

    public function oct()
    {
    }

    public function bin()
    {
    }

    public function h()
    {
        return $this->hex();
    }

    public function o()
    {
        return $this->oct();
    }

    public function b()
    {
        return $this->bin();
    }

    public function __toString()
    {
        return "{$this->value}";
    }
}

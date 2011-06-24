<?php

class s extends o
{
    public function __construct($str = '')
    {
        $this->value = $str;
    }

    public function bytes()
    {
        //TODO: return a collection of bytes
    }

    public function length()
    {
        return new n(mb_strlen($this, o::ENCODING));
    }

    public function n($after = true)
    {
        if($after)
        {
            return new self($this . "\n");
        }
        else
        {
            return new self("\n" . $this);
        }
    }
    public function r($after = true)
    {
        if($after)
        {
            return new self($this . "\r");
        }
        else
        {
            return new self("\r" . $this);
        }
    }
}

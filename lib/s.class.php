<?php

namespace Malenki\Bah;

class S extends O
{
    public function __construct($str = '')
    {
        $this->value = $str;
    }

    public function chars()
    {
        if(!isset($this->chars))
        {
            $a = new A();
            $i = new N(0);

            while($i->less($this->length()))
            {
                $a->add($this->sub($i->value));
                $i->incr();
            }

            $this->chars = $a;
        }
        return $this->chars;
    }

    public function bytes()
    {
        if(!isset($this->bytes))
        {
            $a = new A();

            while($this->chars()->valid())
            {
                $bytes = $this->chars()->current()->bytes();

                while($bytes->valid())
                {
                    $a->add($bytes->current());
                    $bytes->next();
                }

                $this->chars()->next();
            }
            $this->bytes = $a;
        }

        return $this->bytes;
    }

    public function sub($offset = 0, $limit = 1)
    {
        return new S(mb_substr($this->value, $offset, $limit, C::ENCODING));
    }

    public function charAt($idx)
    {
        return new C(mb_substr($this->value, $idx, 1, C::ENCODING));
    }

    public function length()
    {
        return new N(mb_strlen($this, C::ENCODING));
    }
    
    public function upper()
    {
        return new self(mb_convert_case($this, MB_CASE_UPPER, C::ENCODING));
    }
    
    public function lower()
    {
        return new self(mb_convert_case($this, MB_CASE_LOWER, C::ENCODING));
    }
    
    public function title()
    {
        return new self(mb_convert_case($this, MB_CASE_TITLE, C::ENCODING));
    }

    public function times($n = 1)
    {
        return new self(str_repeat($this, $n));
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

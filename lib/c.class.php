<?php
include('o.class.php');
include('n.class.php');
include('a.class.php');
class c extends o
{
    const ENCODING = 'UTF-8';

    public function __construct($char = '')
    {
        // TODO: test if it is really a char.
        $this->value = $char;
    }

    public static function createFromCode($char, $encoding = c::ENCODING)
    {
    }

    public static function createFromEntity()
    {
    }

    public static function createFromLatex()
    {
    }

    public static function encodings()
    {
        return new a(mb_list_encodings());
    }

    public function bytes()
    {
        $i = 0;
        $a = new a();

        while($i < strlen($this))
        {
            $a->add(new n(ord($this->value{$i})));
            $i++;
        }

        return $a;
    }

    public function upper()
    {
        return new self(mb_strtoupper($this, c::ENCODING));
    }
    
    public function lower()
    {
        return new self(mb_strtolower($this, c::ENCODING));
    }
}

$c = new c('’');

print(c::encodings());

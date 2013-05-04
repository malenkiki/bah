<?php

namespace Malenki\Bah;

include('o.class.php');
include('n.class.php');
include('a.class.php');
include('s.class.php');
class C extends O
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
        return new A(mb_list_encodings());
    }

    public function bytes()
    {
        if(!isset($this->bytes))
        {
            $i = 0;
            $a = new A();

            while($i < strlen($this))
            {
                $a->add(new N(ord($this->value{$i})));
                $i++;
            }
            $this->bytes = $a;
        }

        return $this->bytes;
    }

    public function upper()
    {
        return new self(mb_convert_case($this, MB_CASE_UPPER, C::ENCODING));
        // return new self(mb_strtoupper($this, c::ENCODING));
    }
    
    public function lower()
    {
        return new self(mb_convert_case($this, MB_CASE_LOWER, C::ENCODING));
        //return new self(mb_strtolower($this, c::ENCODING));
    }

    public function isLetter()
    {
    }

    public function isDigit()
    {
    }

    public function isWhitespace()
    {
    }

    public function isLowerCase()
    {
    }

    public function directionality()
    {
    }

    public function isMirrored()
    {
    }

    public function translit()
    {
    }
}

/*
 * TODO: http://en.wikipedia.org/wiki/Mapping_of_Unicode_characters
 * http://en.wikipedia.org/wiki/Basic_Multilingual_Plane#Basic_Multilingual_Plane
 * http://www.unicode.org/roadmaps/
 */
$s = new S('C’est cool !');
$c = new C("€");
//print($s->chars()->last());
while($c->bytes()->valid())
{
    echo $c->bytes()->current()->b()->upper()->n();
    $c->bytes()->next();
}

$greek = new S('Τα ελληνικά σου είναι καλύτερα απο τα Γαλλικά μου!');
echo $greek->n();
echo $greek->upper()->n();
echo $greek->lower()->n();
echo $greek->title()->n();
echo $greek->length()->s()->n();
echo $greek->sub(4)->n();

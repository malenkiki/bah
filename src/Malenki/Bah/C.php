<?php
/*
Copyright (c) 2013 Michel Petit <petit.michel@gmail.com>

Permission is hereby granted, free of charge, to any person obtaining
a copy of this software and associated documentation files (the
"Software"), to deal in the Software without restriction, including
without limitation the rights to use, copy, modify, merge, publish,
distribute, sublicense, and/or sell copies of the Software, and to
permit persons to whom the Software is furnished to do so, subject to
the following conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/


namespace Malenki\Bah;

/*
 * TODO: http://en.wikipedia.org/wiki/Mapping_of_Unicode_characters
 * http://en.wikipedia.org/wiki/Basic_Multilingual_Plane#Basic_Multilingual_Plane
 * http://www.unicode.org/roadmaps/
 */
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


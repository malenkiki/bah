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

/**
 * @package Malenki\Bah
 * @license MIT
 * @property-read Malenki\Bah\A $bytes A collection of Malenki\Bah\N objects
 *
 * @todo http://en.wikipedia.org/wiki/Mapping_of_Unicode_characters
 * @todo http://en.wikipedia.org/wiki/Basic_Multilingual_Plane#Basic_Multilingual_Plane
 * @todo http://www.unicode.org/roadmaps/
 */
class C extends O
{
    const ENCODING = 'UTF-8';

    protected $bytes = null;

    public function __construct($char = '')
    {
        // TODO: test if it is really a char.
        $this->value = $char;
    }



    public function __get($name)
    {
        if($name == 'bytes')
        {
            if(is_null($this->bytes))
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
        return is_numeric($this->value);
    }



    public function isWhitespace()
    {
    }



    /**
     * Tests whether current character is in lower case. 
     * 
     * @access public
     * @return boolean
     */
    public function isLowerCase()
    {
        return mb_strtolower($this->value, C::ENCODING) === $this->value;
    }



    /**
     * Tests whether current character is in upper case. 
     * 
     * @access public
     * @return boolean
     */
    public function isUpperCase()
    {
        return mb_strtoupper($this->value, C::ENCODING) === $this->value;
    }



    /**
     * Tests whether the current character has other cases or not. 
     * 
     * @access public
     * @return boolean
     */
    public function hasCase()
    {
        return !($this->isLowerCase() && $this->isUpperCase());
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


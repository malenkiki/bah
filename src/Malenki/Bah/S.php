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
 * String class.
 *
 * @package Malenki\Bah
 * @property-read Malenki\Bah\A $chars A collection of Malenki\Bah\C objects
 * @property-read Malenki\Bah\A $bytes A collection of Malenki\bah\N objects
 * @property-read Malenki\Bah\N $length The strings length
 * @license MIT
 */
class S extends O implements \Countable
{
    /**
     * Stocks characters when a call is done for that.
     *
     * @var Malenki\Bah\A
     */
    protected $chars = null;

    /**
     * Stocks string's bytes.
     *
     * @var Malenki\Bah\A
     */
    protected $bytes = null;

    /**
     * Stocks string's length.
     *
     * @var Malenki\Bah\N
     */
    protected $length = null;

    protected function _chars()
    {
        $a = new A();
        $i = new N(0);

        while($i->less($this->length))
        {
            $a->add(new C($this->sub($i->value)->value));
            $i->incr();
        }

        $this->chars = $a;

        return $this->chars;
    }

    protected function _bytes()
    {
        $a = new A();

        $this->_chars();

        while($this->chars->valid())
        {
            //$bytes = $this->chars->current()->bytes;

            while($this->chars->current()->bytes->valid())
            {
                $a->add($this->chars->current()->bytes->current());
                $this->chars->current()->bytes->next();
            }

            $this->chars->next();
        }
        $this->bytes = $a;

        return $this->bytes;
    }

    protected function _length()
    {
        $this->length = new N(mb_strlen($this, C::ENCODING));
        return $this->length;
    }

    public static function concat()
    {
        $args = func_get_args();

        $str_out = '';

        foreach($args as $s)
        {
            if($s instanceof \Malenki\Bah\S)
            {
                $str_out .= $s->__toString();
            }
            elseif(is_string($s))
            {
                $str_out .= $s;
            }
            else
            {
                throw new \Exception('All args must be string or Malenki\Bah\S instance!');
            }
        }

        return new self($str_out);
    }

    public function __construct($str = '')
    {
        $this->value = $str;
    }

    /**
     * @params string $name
     */
    public function __get($name)
    {
        if(in_array($name, array('chars', 'bytes', 'length')))
        {
            if($name == 'length')
            {
                if(is_null($this->length))
                {
                    $this->_length();
                }

                return $this->length;
            }

            if($name == 'chars')
            {
                if(is_null($this->chars))
                {
                    $this->_chars();
                }
                return $this->chars;
            }

            if($name == 'bytes')
            {
                if(is_null($this->bytes))
                {
                    $this->_bytes();
                }

                return $this->bytes;
            }
        }
    }

    /**
     * Get substring from the original string.
     *
     * By default, returns the first character as a substring.
     *
     * @param integer $offset Where to start the substring, 0 by default
     * @param integer $limit Size of the substring, 1 by default
     *
     * @return Malenki\Bah\S
     */
    public function sub($offset = 0, $limit = 1)
    {
        return new S(mb_substr($this->value, $offset, $limit, C::ENCODING));
    }

    public function first()
    {
        return $this->sub();
    }

    public function last()
    {
        return $this->sub($this->_length()->value - 1, 1);
    }

    public function startsWith($str)
    {
    }

    public function endsWith($str)
    {
    }

    public function match($expr)
    {
        return preg_match($expr, $this->value);
    }


    public function upperCaseWords()
    {
    }

    public function upperCaseFirst()
    {
        if(!$this->isVoid())
        {
            $first_char = $this->first()->upper();
            $other_chars = $this->sub(1, $this->length->value);
            return self::concat($first_char, $other_chars);
        }

        return $this;
    }

    /**
     * Get character at the given position.
     *
     * @param integer $idx The index where the cahracter is.
     *
     * @return Malenki\Bah\C
     */
    public function charAt($idx)
    {
        return new C(mb_substr($this->value, $idx, 1, C::ENCODING));
    }


    /**
     * Implements Countable interface.
     *
     * @see \Countable
     */
    public function count()
    {
        return $this->length->value;
    }

    public function isVoid()
    {
        return $this->length->value == 0;
    }



    /**
     * Returns new string object converted to uppercase.
     *
     * @return Malenki\Bah\S
     */
    public function upper()
    {
        return new self(mb_convert_case($this, MB_CASE_UPPER, C::ENCODING));
    }



    /**
     * Returns new string object converted to lowercase.
     *
     * @return Malenki\Bah\S
     */
    public function lower()
    {
        return new self(mb_convert_case($this, MB_CASE_LOWER, C::ENCODING));
    }



    /**
     * Returns new String object with capital letters
     *
     * @return Malenki\Bah\S
     */
    public function title()
    {
        return new self(mb_convert_case($this, MB_CASE_TITLE, C::ENCODING));
    }


    /**
     * Returns current string as an new string object repeated N times.
     *
     * @param integer $n
     * @return Malenki\Bah\S
     */
    public function times($n = 1)
    {
        return new self(str_repeat($this, $n));
    }


    /**
     *
     * @param boolean $after
     * @return Malenki\Bah\S
     */
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

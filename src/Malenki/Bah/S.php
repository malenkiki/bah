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
        if(is_null($this->chars))
        {
            $a = new A();
            $i = new N(0);

            while($i->less($this->_length()))
            {
                $a->add(new C($this->sub($i->value)->value));
                $i->incr;
            }

            $this->chars = $a;
        }

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
            //TODO: allow object having __toString method
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
        if(in_array($name, array('string', 'chars', 'bytes', 'length', 'title', 'first', 'last', 'upper', 'lower', 'n', 'r', 'ucw', 'ucf', 'a', 'trans')))
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
                return $this->_chars();
            }

            if($name == 'bytes')
            {
                if(is_null($this->bytes))
                {
                    $this->_bytes();
                }

                return $this->bytes;
            }

            if(in_array($name, array('n', 'r')))
            {
                return $this->$name();
            }

            if($name == 'ucw')
            {
                return $this->_upperCaseWords();
            }

            if($name == 'ucf')
            {
                return $this->_upperCaseFirst();
            }

            if(in_array($name, array('string', 'title', 'upper', 'lower', 'n', 'r', 'first', 'last', 'a', 'trans')))
            {
                $str_method = '_' . $name;
                return $this->$str_method();
            }
        }
    }



    protected function _string()
    {
        return (string) $this->value;
    }


    protected function _a()
    {
        $a = new A();
        $i = new N(0);

        while($i->less($this->_length()))
        {
            $a->add($this->sub($i->value));
            $i->incr;
        }

        return  $a;
    }



    protected function _trans()
    {
        if(!extension_loaded('intl'))
        {
            throw new \RuntimeException('Missing Intl extension. This is required to use ' . __CLASS__);
        }

        $str = transliterator_transliterate(
            "Any-Latin; NFD; [:Nonspacing Mark:] Remove; NFC;",
            $this->value
        );

        return new self($str);
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

    protected function _first()
    {
        return $this->sub();
    }

    protected function _last()
    {
        return $this->sub($this->_length()->value - 1, 1);
    }



    /**
     * Checks that current string starts with the given string or not 
     * 
     * @param mixed $str S or primitive string
     * @access public
     * @return boolean
     */
    public function startsWith($str)
    {
        $str = preg_quote($str, '/');
        return (boolean) preg_match("/^$str/", $this->value);
    }



    /**
     * Checks that current string ends with the given string or not 
     * 
     * @param mixed $str S or primitive string
     * @access public
     * @return boolean
     */
    public function endsWith($str)
    {
        $str = preg_quote($str, '/');
        return (boolean) preg_match("/$str\$/", $this->value);
    }

    
    
    /**
     * Check whether current string match the given regular expression. 
     * 
     * @param mixed $expr S or primitive string
     * @access public
     * @return boolean
     */
    public function match($expr)
    {
        return (boolean) preg_match($expr, $this->value);
    }


    protected function _upperCaseWords()
    {
        $str_prov = mb_convert_case(
            mb_strtolower(
                mb_strtolower($this->value, 'UTF-8'),
                'UTF-8'
            ),
            MB_CASE_TITLE,
            'UTF-8'
        );

        $str_out  = $str_prov;
        $int_length  = mb_strlen($str_prov, 'UTF-8');

        $prev_idx = null;
        $arr_to_change = array();


        for($i = 0; $i < $int_length; $i++)
        {
            $letter = mb_substr($str_prov, $i, 1, 'UTF-8');

            if($letter == "'"){
                $prev_idx = $i;
            }

            if(!is_null($prev_idx) && ($i == $prev_idx + 1)){
                $arr_to_change[$i] = $letter;
            }
        }

        foreach($arr_to_change as $idx => $letter)
        {
            $str_tmp  = mb_substr($str_out, 0, $idx, 'UTF-8'); // On prend ce qu’il y a avant le caractère sans modification
            $str_tmp .= mb_strtoupper($letter, 'UTF-8'); // On met en majuscule la lettre
            $str_tmp .= mb_substr($str_out, $idx + 1, $int_length, 'UTF-8'); // On prend le reste de la chaîne…

            $str_out = $str_tmp;
        }

        return new self($str_out);
    }



    public function _upperCaseFirst()
    {
        if(!$this->isVoid())
        {
            $first_char = $this->_first()->_upper();
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
        return $this->_length()->int;
    }

    public function isVoid()
    {
        return $this->_length()->zero;
    }



    /**
     * Returns new string object converted to uppercase.
     *
     * @return Malenki\Bah\S
     */
    protected function _upper()
    {
        return new self(mb_convert_case($this, MB_CASE_UPPER, C::ENCODING));
    }



    /**
     * Returns new string object converted to lowercase.
     *
     * @return Malenki\Bah\S
     */
    protected function _lower()
    {
        return new self(mb_convert_case($this, MB_CASE_LOWER, C::ENCODING));
    }



    /**
     * Returns new String object with capital letters
     *
     * @return Malenki\Bah\S
     */
    protected function _title()
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
     * Wrap the string to have given width. 
     * 
     * @param integer $width Width the text must have
     * @param string $cut Optional string to put at each linebreak
     * @access public
     * @return S
     */
    public function wrap($width, $cut = "\n")
    {
        $arr_lines = array();

        if(strlen($this->value) === mb_strlen($this->value, 'UTF-8'))
        {
            $arr_lines = explode(
                $cut,
                wordwrap(
                    $this->value, 
                    $width, 
                    $cut
                )
            );
        }
        else
        {
            //Thanks to: http://www.php.net/manual/fr/function.wordwrap.php#104811
            $str_prov = $this->value;
            $int_length = mb_strlen($str_prov, 'UTF-8');
            $int_width = $width;

            if ($int_length <= $int_width)
            {
                return new self($str_prov);
            }

            $int_last_space = 0;
            $i = 0;

            do
            {
                if (mb_substr($str_prov, $i, 1, 'UTF-8') == ' ')
                {
                    $int_last_space = $i;
                }

                if ($i > $int_width)
                {
                    if($int_last_space == 0)
                    {
                        $int_last_space = $int_width;
                    }

                    $arr_lines[] = trim(
                        mb_substr(
                            $str_prov,
                            0,
                            $int_last_space,
                            'UTF-8')
                        );

                    $str_prov = mb_substr(
                        $str_prov,
                        $int_last_space,
                        $int_length,
                        'UTF-8'
                    );

                    $int_length = mb_strlen($str_prov, 'UTF-8');

                    $i = 0;
                }

                $i++;
            }
            while ($i < $int_length);

            $arr_lines[] = trim($str_prov);
        }

        return new self(implode($cut, $arr_lines));
    }



    /**
     * Ad margin to the text. By default left, but right and alinea are possible too.
     * 
     * @param int $int_left Margin left
     * @param int $int_right Margin right, optional
     * @param int $int_alinea First line, optional
     * @access public
     * @return S
     */
    public function margin($int_left = 5, $int_right = 0, $int_alinea = 0)
    {
        $arr = explode("\n", $this->value);
        
        foreach($arr as $k => $v)
        {
            $int_margin_left = $int_left;
            $int_margin_right = $int_right;

            if($k == 0)
            {
                $int_margin_left = $int_left + $int_alinea;

                if($int_margin_left < 0)
                {
                    $int_margin_left = 0;
                }
            }

            $arr[$k] = str_repeat(' ', $int_margin_left);
            $arr[$k] .= $v . str_repeat(' ', $int_margin_right);
        }

        return new self(implode("\n", $arr));
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

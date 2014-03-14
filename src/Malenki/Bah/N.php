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

class N
{
    public function __get($name)
    {
        if(in_array($name, array('hex','oct','bin','h', 'o', 'b', 's', 'n', 'p', 'incr', 'decr', 'negative', 'zero', 'positive', 'roman', 'int', 'float', 'double')))
        {
            $str_method = '_' . $name;
            return $this->$str_method();
        }

        if($name == 'greek')
        {
            return $this->greek();
        }
    }



    public function __construct($num = 0)
    {
        $this->value = $num;
    }

    protected function _int()
    {
        return (integer) $this->value;
    }

    protected function _float()
    {
        return (float) $this->value;
    }

    protected function _double()
    {
        return (double) $this->value;
    }

    protected function _incr()
    {
        $this->value++;
    }

    protected function _decr()
    {
        $this->value--;
    }

    protected function _n()
    {
        return new self($this->value + 1);
    }

    protected function _p()
    {
        return new self($this->value - 1);
    }

    public function less($num)
    {
        if(is_numeric($num))
        {
            $n = new self($num);
        }
        else
        {
            $n = $num;
        }

        return $this->value < $n->value;
    }

    public function greater($num)
    {
        if(is_numeric($num))
        {
            $n = new self($num);
        }
        else
        {
            $n = $num;
        }

        return $this->value > $n->value;
    }

    public function _negative()
    {
        return $this->value < 0;
    }

    public function _zero()
    {
        return $this->value == 0;
    }

    public function _positive()
    {
        return $this->value > 0;
    }


    public function equal($num)
    {
        if(is_numeric($num))
        {
            $n = new self($num);
        }
        else
        {
            $n = $num;
        }

        return $this->value == $n->value;
    }

    public function plus($number)
    {
        if(is_numeric($number) || $number instanceof N)
        {
            if(is_numeric($number))
            {
                return new self($this->value + $number);
            }
            else
            {
                return new self($this->value + $number->value);
            }
        }
        else
        {
            throw new \InvalidArgumentException('To addition a value, you must use number or \Malenki\Bah\N instance.');
        }
    }

    public function minus($number)
    {
        if(is_numeric($number) || $number instanceof N)
        {
            if(is_numeric($number))
            {
                return new self($this->value - $number);
            }
            else
            {
                return new self($this->value - $number->value);
            }
        }
        else
        {
            throw new \InvalidArgumentException('To substract a value, you must use number or \Malenki\Bah\N instance.');
        }
    }

    public function divide($number)
    {
        if(is_numeric($number) || $number instanceof N)
        {
            if(is_object($number))
            {
                $number = $number->value;
            }

            if($number == 0)
            {
                throw new \InvalidArgumentException('You cannot divide by zero!');
            }
            
            return new self($this->value / $number);
        }
        else
        {
            throw new \InvalidArgumentException('To addition a value, you must use number or \Malenki\Bah\N instance.');
        }
    }

    protected function _roman()
    {
        $arr_numerals = array(
            (object) array(
                'integer' => 1000,
                'roman' => 'm'
            ),
            (object) array(
                'integer' => 900,
                'roman' => 'cm'
            ),
            (object) array(
                'integer' => 500,
                'roman' => 'd'
            ),
            (object) array(
                'integer' => 400,
                'roman' => 'cd'
            ),
            (object) array(
                'integer' => 100,
                'roman' => 'c'
            ),
            (object) array(
                'integer' => 90,
                'roman' => 'xc'
            ),
            (object) array(
                'integer' => 50,
                'roman' => 'l'
            ),
            (object) array(
                'integer' => 40,
                'roman' => 'xl'
            ),
            (object) array(
                'integer' => 10,
                'roman' => 'x'
            ),
            (object) array(
                'integer' => 9,
                'roman' => 'ix'
            ),
            (object) array(
                'integer' => 5,
                'roman' => 'v'
            ),
            (object) array(
                'integer' => 4,
                'roman' => 'iv'
            ),
            (object) array(
                'integer' => 1,
                'roman' => 'i'
            )
        );
        
        $int_number  = $this->value;
        $str_numeral = '';
        $str_least   = '';

        $int_count_numerals = count($arr_numerals);

        for($i = 0; $i < $int_count_numerals; $i++)
        {
            while($int_number >= $arr_numerals[$i]->integer)
            {
                $str_least .= $arr_numerals[$i]->roman;
                $int_number  -= $arr_numerals[$i]->integer;
            }
        }

        return new S($str_numeral . $str_least);
    }



    /**
     * greek 
     * 
     * If digamma is false, use stigma instead.
     *
     * Max number: 9999.
     *
     * @todo add myriad to have more number after 9999.
     * @param boolean $digamma 
     * @access public
     * @return s object
     */
    public function greek($digamma = true)
    {

        if($this->value > 9999)
        {
            throw new \InvalidArgumentException(
                'Numbers over 9999 are not yet available for greek format.'
            );
        }

        $keraia = 'ʹ';

        $arr_greek = array(
            1 => 'α',
            2 => 'β',
            3 => 'γ',
            4 => 'δ',
            5 => 'ε',
            6 => 'ϝ',
            7 => 'ζ',
            8 => 'η',
            9 => 'θ',
            10 => 'ι',
            20 => 'κ',
            30 => 'λ',
            40 => 'μ',
            50 => 'ν',
            60 => 'ξ',
            70 => 'ο',
            80 => 'π',
            90 => 'ϟ',
            100 => 'ρ',
            200 => 'σ',
            300 => 'τ',
            400 => 'υ',
            500 => 'φ',
            600 => 'χ',
            700 => 'ψ',
            800 => 'ω',
            900 => 'ϡ',
            1000 => 'ͺα',
            2000 => 'ͺβ',
            3000 => 'ͺγ',
            4000 => 'ͺδ',
            5000 => 'ͺε',
            6000 => 'ͺϛ',
            7000 => 'ͺζ',
            8000 => 'ͺη',
            9000 => 'ͺθ'
        );

        if(!$digamma)
        {
            $arr_greek[6] = 'ϛ';
        }

        $str_value = strrev((string) $this->value);

        $arr_out = array();

        for($i = 0; $i < strlen($str_value); $i++)
        {
            if($str_value[$i] > 0)
            {
                $arr_out[] = $arr_greek[pow(10, $i) * $str_value[$i]];
            }
        }

        return new S(implode('', array_reverse($arr_out)));
    }

    public function arabian()
    {
    }

    public function hebrew()
    {
    }

    protected function _hex()
    {
        return new S(dechex($this->value));
    }

    protected function _oct()
    {
        return new S(decoct($this->value));
    }

    protected function _bin()
    {
        return new S(decbin($this->value));
    }

    protected function _h()
    {
        return $this->_hex();
    }

    protected function _o()
    {
        return $this->_oct();
    }

    protected function _b()
    {
        return $this->_bin();
    }

    protected function _s()
    {
        return new S($this->__toString());
    }

    public function __toString()
    {
        return "{$this->value}";
    }
}

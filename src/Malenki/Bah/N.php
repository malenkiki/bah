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
    public function __construct($num = 0)
    {
        $this->value = $num;
    }

    public function incr()
    {
        $this->value++;
    }

    public function decr()
    {
        $this->value--;
    }

    public function n()
    {
        return new self($this->value + 1);
    }

    public function p()
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
            1000 => '͵α',
            2000 => '͵β',
            3000 => '͵γ',
            4000 => '͵δ',
            5000 => '͵ε',
            6000 => '͵ϛ',
            7000 => '͵ζ',
            8000 => '͵η',
            9000 => '͵θ'
        );

        if(!$digamma)
        {
            $arr_greek[6] = 'ϛ';
        }
    }

    public function arabian()
    {
    }

    public function hebrew()
    {
    }

    public function hex()
    {
        return new S(dechex($this->value));
    }

    public function oct()
    {
        return new S(decoct($this->value));
    }

    public function bin()
    {
        return new S(decbin($this->value));
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

    public function s()
    {
        return new S($this->__toString());
    }

    public function __toString()
    {
        return "{$this->value}";
    }
}

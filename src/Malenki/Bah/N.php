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
 * Defines numbers.
 *
 * @property-read $hex Get hexadecimal form as S class
 * @property-read $oct Get octogonal form as S class
 * @property-read $bin Get binary form as S class
 * @property-read $h Shorthand for $hex
 * @property-read $o Shorthand for $o
 * @property-read $b Shorthand for $b
 * @property-read $s Get number as S class
 * @property-read $n
 * @property-read $p
 * @property-read $incr Get increment number
 * @property-read $decr Get decrement number
 * @property-read $negative Check if number is negative or not
 * @property-read $sign Check if number is negative, positive or null
 * @property-read $zero Check if number is nul
 * @property-read $prime Check if number is prime number or not
 * @property-read $abs Gets absolute value
 * @property-read $absolute Gets absolute value
 * @property-read $opposite Gets its opposite number
 * @property-read $inverse Gets its inverse number
 * @property-read $divisors Gets divisors
 * @property-read $square Gets square number
 * @property-read $ln Gets neperian logarithm
 * @property-read $sqrt Gets neperian logarithm
 * @property-read $factorial Gets factorial
 * @property-read $triangular Gets triangular number (1+2+3+4… to current number)
 * @property-read $fact Gets factorial
 * @property-read $positive Check if number is positive
 * @property-read $hindi Get hindi number as S class.
 * @property-read $roman Get roman number as S class.
 * @property-read $greek Get greek number as S class.
 * @property-read $chinese Get chinese mandarin number as S class.
 * @property-read $mandarin Get chinese mandarin number as S class.
 * @property-read $putonghua Get chinese mandarin number as S class.
 * @property-read $chinese_other_zero Get chinese mandarin number as S class (other way to print zero).
 * @property-read $mandarin_other_zero Get chinese mandarin number as S class (other way to print zero).
 * @property-read $putonghua_other_zero Get chinese mandarin number as S class (other way to print zero).
 * @property-read $int Get as primitive integer
 * @property-read $float Get as primitive float
 * @property-read $double Get as primitive double
 * @copyright 2014 Michel PETIT
 * @author Michel Petit <petit.michel@gmail.com>
 * @license MIT
 */
class N
{
    public function __get($name)
    {
        if (in_array($name, array('hex','oct','bin','h', 'o', 'b', 's', 'n', 'p', 'incr', 'decr', 'negative', 'zero', 'sign', 'prime', 'divisors', 'positive', 'roman', 'int', 'float', 'double', 'decimal', 'even', 'odd', 'abs', 'absolute', 'opposite', 'square', 'cube', 'ln', 'sqrt', 'fact', 'factorial', 'triangular', 'inverse'))) {
            $str_method = '_' . $name;

            return $this->$str_method();
        }

        if ($name == 'greek') {
            return $this->greek();
        }
        
        if ($name == 'hindi') {
            return $this->hindi();
        }
        
        if (in_array($name, array('chinese', 'mandarin', 'putonghua'))) {
            return $this->chinese();
        }

        if (
            in_array(
                $name, 
                array(
                    'chinese_other_zero',
                    'mandarin_other_zero',
                    'putonghua_other_zero'
                )
            )
        ) {
            return $this->chinese(true);
        }

        if (in_array($name, array('arabic', 'perso_arabic', 'persian'))) {
            return $this->_arabic($name);
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

    /**
     * Checks whether current number is less than given one.
     *
     * @throw \InvalidArgumentException If argument is not numeric or N class
     * @param  mixed   $num N or primitive numeric value
     * @access public
     * @return boolean
     */
    public function less($num)
    {
        if (is_numeric($num)) {
            $n = $num;
        } elseif ($num instanceof N) {
            $n = $num->value;
        } else {
            throw new \InvalidArgumentException(
                'Testing must be done with numeric value or N object!'
            );
        }

        return $this->value < $n;
    }

    /**
     * Shorthand for less() method
     *
     * @throw \InvalidArgumentException If argument is not numeric or N class
     * @param  mixed   $num N or numeric value
     * @access public
     * @return boolean
     */
    public function lt($num)
    {
        return $this->less($num);
    }

    /**
     * Tests whether current number is less than or equal to given one.
     *
     * @throw \InvalidArgumentException If argument is not numeric or N class
     * @param  mixed   $num N or numeric value
     * @access public
     * @return boolean
     */
    public function lte($num)
    {
        if (is_numeric($num)) {
            $n = $num;
        } elseif ($num instanceof N) {
            $n = $num->value;
        } else {
            throw new \InvalidArgumentException(
                'Testing must be done with numeric value or N object!'
            );
        }

        return $this->value <= $n;
    }

    public function le($num)
    {
        return $this->lte($num);
    }

    /**
     * Tests whether current number is greater than given one.
     *
     * @throw \InvalidArgumentException If argument is not numeric or N class
     * @param  mixed   $num N or numeric value.
     * @access public
     * @return boolean
     */
    public function greater($num)
    {
        if (is_numeric($num)) {
            $n = $num;
        } elseif ($num instanceof N) {
            $n = $num->value;
        } else {
            throw new \InvalidArgumentException(
                'Testing must be done with numeric value or N object!'
            );
        }

        return $this->value > $n;
    }

    /**
     * Shorthand of greater() method
     *
     * @throw \InvalidArgumentException If argument is not numeric or N class
     * @param  mixed   $num N or numeric value
     * @access public
     * @return boolean
     */
    public function gt($num)
    {
        return $this->greater($num);
    }

    /**
     * Tests whether current number is greater than or equal to the given number.
     *
     * @throw \InvalidArgumentException If argument is not numeric or N class
     * @param  mixed   $num N or numeric value
     * @access public
     * @return boolean
     */
    public function gte($num)
    {
        if (is_numeric($num)) {
            $n = $num;
        } elseif ($num instanceof N) {
            $n = $num->value;
        } else {
            throw new \InvalidArgumentException(
                'Testing must be done with numeric value or N object!'
            );
        }

        return $this->value >= $n;
    }

    public function ge($num)
    {
        return $this->gte($num);
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

    protected function _abs()
    {
        return new N(abs($this->value));
    }

    protected function _absolute()
    {
        return $this->_abs();
    }

    protected function _opposite()
    {
        return new N(-1 * $this->value);
    }

    protected function _inverse()
    {
        if ($this->_zero()) {
            throw new \RuntimeException('Cannot get inverse number of zero!');
        }

        return new N(1 / $this->value);
    }

    public function mod($mod)
    {
        if (!is_numeric($mod) && !($mod instanceof N)) {
            throw new \InvalidArgumentException('Divisor must be a valid number or N object!');
        }

        if ($mod instanceof N) {
            $mod = $mod->double;
        }

        if ($mod == 0) {
            throw new \RuntimeException('Cannot divide by 0!');
        }

        return new N(fmod($this->value, $mod));
    }

    public function modulo($mod)
    {
        return $this->mod($mod);
    }

    protected function _prime()
    {
        if ($this->value < 2) {
            return false;
        }

        if (!$this->_decimal()->zero) {
            return false;
        }

        $ok = true;
        $max = floor(sqrt($this->value));

        for ($i = 2; $i <= $max; $i++) {
            if ($this->value % $i == 0) {
                return false;
            }
        }

        return true;
    }

    /**
     * Gets divisors for the current integer numbers.
     *
     * If current number is negative, divisors will be based on its positive
     * version.
     *
     * @throw \RuntimeException If current number is not an integer
     * @access protected
     * @return A Instance of A class
     */
    protected function _divisors()
    {
        if (!$this->_decimal()->zero) {
            throw new \RuntimeException('You can only get divisors from integers!');
        }

        $n = abs($this->value);
        $a = new A();

        for ($i = 1; $i <= $n; $i++) {
            if ($n % $i == 0) {
                $a->add(new self($i));
            }
        }

        return $a;
    }

    public function pow($num)
    {
        if (is_numeric($num)) {
            $n = $num;
        } elseif ($num instanceof N) {
            $n = $num->value;
        } else {
            throw new \InvalidArgumentException(
                'Power calculus must be done with numeric value or N object!'
            );
        }

        return new N(pow($this->value, $n));
    }

    public function power($num)
    {
        return $this->pow($num);
    }

    protected function _square()
    {
        return $this->pow(2);
    }

    protected function _cube()
    {
        return $this->pow(3);
    }

    public function log($base = M_E)
    {
        if (is_numeric($base)) {
            $n = $base;
        } elseif ($base instanceof N) {
            $n = $base->value;
        } else {
            throw new \InvalidArgumentException(
                'Log base must be numeric value or N object!'
            );
        }

        if ($n == 1 || $n <= 0) {
            throw new \InvalidArgumentException('Log base must be positive number different of one.');
        }

        return new N(log($this->value, $n));
    }

    protected function _ln()
    {
        return $this->log();
    }

    public function root($num)
    {
        if (is_numeric($num)) {
            $n = $num;
        } elseif ($num instanceof N) {
            $n = $num->value;
        } else {
            throw new \InvalidArgumentException(
                'Root must be numeric value or N object!'
            );
        }

        if ($n == 0) {
            throw new \InvalidArgumentException('Root must be not nul');
        }

        return new N(pow($this->value, 1 / $n));
    }

    protected function _sqrt()
    {
        return $this->root(2);
    }

    protected function _factorial()
    {
        if ($this->_zero()) {
            return new N(1);
        }

        if ($this->value < 0) {
            throw new \RuntimeException('Cannot get factorial of negative number!');
        }

        if (!$this->_decimal()->zero) {
            throw new \RuntimeException('Cannot get factorial of non integer!');
        }

        return new N(array_product(range(1, $this->value)));
    }

    protected function _triangular()
    {
        if ($this->value < 0) {
            throw new \RuntimeException('Cannot get triangular number of negative number!');
        }

        if (!$this->_decimal()->zero) {
            throw new \RuntimeException('Cannot get triangular number of non integer!');
        }

        return new N(($this->value * ($this->value + 1)) / 2);
    }

    protected function _fact()
    {
        return $this->_factorial();
    }

    protected function _sign()
    {
        if ($this->value == 0) {
            return new N(0);
        } elseif ($this->value > 0) {
            return new N(1);
        } else {
            return new N(-1);
        }
    }

    /**
     * Checks if current number is equal to given argument.
     *
     * @throw \InvalidArgumentException If argument is not numeric or N class
     * @param  mixed   $num N or numeric value.
     * @access public
     * @return boolean
     */
    public function equal($num)
    {
        if (is_numeric($num)) {
            $n = $num;
        } elseif ($num instanceof N) {
            $n = $num->value;
        } else {
            throw new \InvalidArgumentException(
                'Testing equality must be done with numeric value or N object!'
            );
        }

        return $this->value == $n;
    }

    public function notEqual($num)
    {
        return !$this->equal($num);
    }

    public function eq($num)
    {
        return $this->equal($num);
    }

    public function neq($num)
    {
        return $this->notEqual($num);
    }

    public function _decimal()
    {
        $sign = 1;

        if ($this->_negative()) {
            $sign = -1;
        }

        return new N($sign * (abs($this->value) - floor(abs($this->value))));
    }

    protected function _odd()
    {
        if (!$this->_decimal()->_zero()) {
            throw new \RuntimeException('Testing if number is odd only if it is an integer!');
        }

        return (boolean) ($this->value & 1);
    }

    protected function _even()
    {
        if (!$this->_decimal()->_zero()) {
            throw new \RuntimeException('Testing if number is even only if it is an integer!');
        }

        return !$this->_odd();
    }

    public function test($what)
    {
        if (is_string($what) || $what instanceof S) {
            $arr = array();

            if(
                preg_match(
                    '/^(<|>|<=|>=|=|==|eq\s+|!=|<>|no\s+|neq\s+|le\s+|ge\s+|lt\s+|gt\s+)\s*([-]{0,1}[0-9]+)$/i',
                    trim($what),
                    $arr
                )
            )
            {
                $operator = strtolower(trim($arr[1]));
                $num = (int) $arr[2];

                if (in_array($operator, array('<','lt'))) {
                    return $this->lt($num);
                }

                if (in_array($operator, array('>','gt'))) {
                    return $this->gt($num);
                }

                if (in_array($operator, array('<=','le'))) {
                    return $this->le($num);
                }

                if (in_array($operator, array('>=','ge'))) {
                    return $this->ge($num);
                }

                if (in_array($operator, array('=', '==', 'eq'))) {
                    return $this->eq($num);
                }

                if (in_array($operator, array('!=', '<>', 'no', 'neq'))) {
                    return $this->neq($num);
                }
            } else {
                throw new \RuntimeException('Not valid test expression.');
            }
        } else {
            throw new \InvalidArgumentException('Test argument must be a string or a S object.');
        }
    }

    /**
     * Create new N having the sum of given argument with current number
     *
     * @throw \InvalidArgumentException If argument is not N or numeric value.
     * @param  mixed $number N or numeric value
     * @access public
     * @return N
     */
    public function plus($number)
    {
        if (is_numeric($number) || $number instanceof N) {
            if (is_numeric($number)) {
                return new self($this->value + $number);
            } else {
                return new self($this->value + $number->value);
            }
        } else {
            throw new \InvalidArgumentException('To addition a value, you must use number or \Malenki\Bah\N instance.');
        }
    }

    /**
     * Creates new N having the substraction of given argument with current number
     *
     * @throw \InvalidArgumentException If argument is not N or numeric value.
     * @param  mixed $number N or numeric value
     * @access public
     * @return N
     */
    public function minus($number)
    {
        if (is_numeric($number) || $number instanceof N) {
            if (is_numeric($number)) {
                return new self($this->value - $number);
            } else {
                return new self($this->value - $number->value);
            }
        } else {
            throw new \InvalidArgumentException('To substract a value, you must use number or \Malenki\Bah\N instance.');
        }
    }

    /**
     * Creates new N by multipling the current to the given one
     *
     * @throw \InvalidArgumentException If argument is not N or numeric value.
     * @param  mixed $number N or numeric value
     * @access public
     * @return N
     */
    public function multiply($number)
    {
        if (is_numeric($number) || $number instanceof N) {
            if (is_numeric($number)) {
                return new self($this->value * $number);
            } else {
                return new self($this->value * $number->value);
            }
        } else {
            throw new \InvalidArgumentException('To substract a value, you must use number or \Malenki\Bah\N instance.');
        }
    }

    /**
     * Divide current number with given argument.
     *
     * @throw \InvalidArgumentException If given argument is zero
     * @throw \InvalidArgumentException If given argument is not N or numeric value.
     * @param  mixed $number N or numeric value
     * @access public
     * @return N
     */
    public function divide($number)
    {
        if (is_numeric($number) || $number instanceof N) {
            if (is_object($number)) {
                $number = $number->value;
            }

            if ($number == 0) {
                throw new \InvalidArgumentException('You cannot divide by zero!');
            }

            return new self($this->value / $number);
        } else {
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

        for ($i = 0; $i < $int_count_numerals; $i++) {
            while ($int_number >= $arr_numerals[$i]->integer) {
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
     * @param  boolean $digamma
     * @access public
     * @return s       object
     */
    public function greek($digamma = true)
    {

        if ($this->value > 9999) {
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

        if (!$digamma) {
            $arr_greek[6] = 'ϛ';
        }

        $str_value = strrev((string) $this->value);

        $arr_out = array();

        for ($i = 0; $i < strlen($str_value); $i++) {
            if ($str_value[$i] > 0) {
                $arr_out[] = $arr_greek[pow(10, $i) * $str_value[$i]];
            }
        }

        return new S(implode('', array_reverse($arr_out)));
    }


    public function hindi($use_sep = false)
    {
        $arr = array(
            0 => '०', 
            1 => '१', 
            2 => '२', 
            3 => '३',
            4 => '४',
            5 => '५',
            6 => '६',
            7 => '७',
            8 => '८',
            9 => '९'
        );
        $str = strtr((string) $this->value, $arr);

        if($use_sep && mb_strlen($str, 'UTF-8') > 3){
            $mb_strrev = function($str){
                preg_match_all('/./us', $str, $ar);
                return join('',array_reverse($ar[0]));
            };

            $str = $mb_strrev($str);
            $str_first = mb_substr($str, 0, 3, 'UTF-8');
            $str_last = mb_substr($str, 3, mb_strlen($str, 'UTF-8'), 'UTF-8');

            $str_last = implode(
                ',',
                array_map(
                    function($a){return implode('', $a);},
                    array_chunk(
                        preg_split(
                            '//u', $str_last, -1, PREG_SPLIT_NO_EMPTY
                        ),
                        2
                    )
                )
            );
            $str = $mb_strrev($str_first .','.$str_last);
        }

        return new S($str);
    }

    protected function _arabic($type = 'arabic')
    {
        $arr = array(
            0 => '٠',
            1 => '١',
            2 => '٢',
            3 => '٣',
            4 => '٤',
            5 => '٥',
            6 => '٦',
            7 => '٧',
            8 => '٨',
            9 => '٩'
        );

        if($type == 'perso_arabic' || $type == 'persian'){
            $arr = array(
                0 => '۰',
                1 => '۱',
                2 => '۲',
                3 => '۳',
                4 => '۴',
                5 => '۵',
                6 => '۶',
                7 => '۷',
                8 => '۸',
                9 => '۹'
            );
        }
        
        return new S(strtr((string) $this->value, $arr));
    }

    public function chinese($use_simple_zero = false)
    {
        // n myriads, so indexed using that.
        $arr_myriads = array('兆', '吉', '太', '拍', '艾', '泽', '尧');
        $arr_multiplicators = array('千', '百', '十');
        $arr_units = array('零', '一', '二', '三', '四', '五', '六', '七', '八', '九');

        if($use_simple_zero){
            $arr_units[0] = '〇';
        }

        if($this->_decimal()->zero){
            $arr_groups = str_split(strrev((string) abs($this->value)), 4); // split into reversed myriads
            $arr_groups = array_values(array_reverse($arr_groups));

            // reordering all
            foreach($arr_groups as $k => $v){
                $arr_groups[$k] = strrev($v);
            }

            $out = '';
            $int_count = count($arr_groups) - 2;


            // ok, we have our divisions, so, let's do it into chinese!
            foreach($arr_groups as $k => $v){


                $out_prov = '';
                $int_abslen = strlen(abs($v));

                for($i = 0; $i < $int_abslen; $i++){
                    $out_prov .= $arr_units[(int) $v[$i]];

                    if($v[$i] == '0') continue;

                    if($i < 3){
                        $arr_prov = $arr_multiplicators;

                        if($int_abslen != 4){
                            $arr_prov = array_slice($arr_multiplicators, 4 - $int_abslen);
                        }

                        if(isset($arr_prov[$i])){
                            $out_prov .= $arr_prov[$i];
                        }
                    }
                }

                if(in_array((int) ltrim($v, 0), range(11, 19))){
                    $out_prov = preg_replace('/一十/ui', '十', $out_prov);
                }

                if(mb_strlen($out_prov, 'UTF-8') > 1){
                    $out_prov = preg_replace('/'.$arr_units[0].'+$/ui', '', $out_prov);
                }

                $out .= preg_replace('/'.$arr_units[0].'+/ui', $arr_units[0], $out_prov);



                
                if($int_count >= 0){
                    if(isset($arr_myriads[$int_count])){
                        $out .= $arr_myriads[$int_count];
                    } else {
                        throw new \RuntimeException('Myriads for this number does not exists, cannot create number!');
                    }

                    $int_count--;
                }
            }

        } else {
            $part_int = new N(floor(abs($this->value)));
            $part_decimal = substr((string) abs($this->_decimal()->float), 2);

            $out = $part_int->chinese($use_simple_zero) . '点' . strtr($part_decimal, $arr_units);
        }
        
        if($this->value < 0){
            $out = '负' . $out;
        }
        
        return new S($out);
    }


    /**
     * Convert to arabian string number (equiv of roman)
     *
     * @todo to implement
     * @access public
     * @return S
     */
    public function abjad()
    {
    }

    /**
     * Convert to hebrew string number
     *
     * @todo to implement
     * @access public
     * @return S
     */
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

    public function base($n)
    {
        if(!$this->_decimal()->zero) {
            throw new \RuntimeException('Cannot get decimal numbers into another base.');
        }

        if ($n instanceof N) {
            $n = $n->int;
        }

        if (!is_numeric($n) || $n < 2 || $n > 36) {
            throw new \InvalidArgumentException('Base must be a integer or N value from 2 to 36 inclusive.');
        }

        return new S(base_convert($this->value, 10, $n));
    }

    public function __toString()
    {
        return "{$this->value}";
    }
}

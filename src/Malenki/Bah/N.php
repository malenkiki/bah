<?php
/**
 * Copyright (c) 2013 Michel Petit <petit.michel@gmail.com>
 * 
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 * 
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
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
 *
 * @property-read $to_s Get as \Malenki\Bah\S object
 * @property-read $to_c Get as \Malenki\Bah\C object (if possible)
 * @property-read $string Get as primitive string
 * @property-read $str Get as primitive string
 * @property-read $integer Get as primitive integer
 * @property-read $int Get as primitive integer
 * @property-read $float Get as primitive float
 * @property-read $double Get as primitive double
 * @copyright 2014 Michel PETIT
 * @author Michel Petit <petit.michel@gmail.com>
 * @license MIT
 */
class N extends O
{
    public function __get($name)
    {
        if (
            $name === 'hex'
            ||
            $name === 'oct'
            ||
            $name === 'bin'
            ||
            $name === 'h' 
            ||
            $name === 'o' 
            ||
            $name === 'b' 
            ||
            $name === 'n' 
            ||
            $name === 'p' 
            ||
            $name === 'incr' 
            ||
            $name === 'decr' 
            ||
            $name === 'negative' 
            ||
            $name === 'zero' 
            ||
            $name === 'sign' 
            ||
            $name === 'prime' 
            ||
            $name === 'divisors' 
            ||
            $name === 'positive' 
            ||
            $name === 'roman'
            ||
            $name === 'string'
            ||
            $name === 'str'
            ||
            $name === 'int'
            ||
            $name === 'integer' 
            ||
            $name === 'float'
            ||
            $name === 'double'
            ||
            $name === 'decimal'
            ||
            $name === 'even'
            ||
            $name === 'odd'
            ||
            $name === 'abs'
            ||
            $name === 'absolute' 
            ||
            $name === 'opposite' 
            ||
            $name === 'square' 
            ||
            $name === 'cube'
            ||
            $name === 'ln'
            ||
            $name === 'sqrt'
            ||
            $name === 'fact'
            ||
            $name === 'factorial'
            ||
            $name === 'triangular' 
            ||
            $name === 'inverse'
            ||
            $name === 'ceil' 
            ||
            $name === 'floor' 
            ||
            $name === 'cos' 
            ||
            $name === 'sin' 
            ||
            $name === 'tan' 
            ||
            $name === 'cosh'
            ||
            $name === 'sinh' 
            ||
            $name === 'tanh' 
            ||
            $name === 'acos' 
            ||
            $name === 'asin'
            ||
            $name === 'atan'
            ||
            $name === 'acosh'
            ||
            $name === 'asinh'
            ||
            $name === 'atanh'
            ||
            $name === 'arabic'
        ) {
            $str_method = '_' . $name;

            return $this->$str_method();
        } elseif($name === 'to_s'){
            return new S((string) $this->value);
        } elseif($name === 'to_c'){
            if(
                $this->value < 0 
                ||
                $this->value > 9
                ||
                !$this->_decimal()->zero
            ){
                throw new \RuntimeException(
                    'Cannot convert \Malenki\Bah\N object to \Malenki\Bah\Ci'
                   .' object if it is not single digit.'
                );
            }
            return new C($this->value);
        } elseif(
            $name === 'nan'
            ||
            $name === 'is_nan'
            ||
            $name === 'is_not_a_number'
        ){
            return is_nan($this->value);
        } elseif($name === 'finite' || $name === 'is_finite'){
            return is_finite($this->value);
        } elseif($name === 'infinite' || $name === 'is_infinite'){
            return is_infinite($this->value);
        } elseif($name === 'exp' || $name === 'exponent'){
            return new static(exp($this->value));
        } elseif (
            $name === 'round'
            ||
            $name === 'greek'
            ||
            $name === 'hindi'
            ||
            $name === 'chinese'
        ){
            return $this->$name();
        } elseif ($name === 'mandarin' || $name === 'putonghua'){
            return $this->chinese();
        } elseif (
            $name === 'chinese_other_zero'
            ||
            $name === 'mandarin_other_zero'
            ||
            $name === 'putonghua_other_zero'
        ) {
            return $this->chinese(true);
        } elseif ($name === 'perso_arabic' || $name === 'persian') {
            return $this->_arabic($name);
        }

        $arr = array();
        if(preg_match('/round_(up|down|even|odd)/', $name, $arr)){
            $m = 'round' . ucfirst($arr[1]);
            return $this->$m();
        }

        return parent::__get($name);
    }

    public function __construct($num = 0)
    {
        self::mustBeNumeric($num);

        if(is_object($num)){
            $num = $num->value;
        }

        $this->value = $num;
    }
    protected function _string()
    {
        return (string) $this->value;
    }

    protected function _str()
    {
        return $this->_string();
    }

    protected function _integer()
    {
        return (integer) $this->value;
    }

    protected function _int()
    {
        return $this->_integer();
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

        return $this;
    }

    protected function _decr()
    {
        $this->value--;

        return $this;
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
     * @return boolean
     */
    public function less($num)
    {
        self::mustBeNumeric($num, 'Tested number');

        if(is_object($num)){
            return $this->value < $num->value;
        } else {
            return $this->value < $num;
        }
    }

    /**
     * Shorthand for less() method
     *
     * @throw \InvalidArgumentException If argument is not numeric or N class
     * @param  mixed   $num N or numeric value
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
     * @return boolean
     */
    public function lte($num)
    {
        self::mustBeNumeric($num, 'Tested number');

        if(is_object($num)){
            return $this->value <= $num->value;
        } else {
            return $this->value <= $num;
        }
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
     * @return boolean
     */
    public function greater($num)
    {
        self::mustBeNumeric($num, 'Tested number');

        if(is_object($num)){
            return $this->value > $num->value;
        } else {
            return $this->value > $num;
        }
    }

    /**
     * Shorthand of greater() method
     *
     * @throw \InvalidArgumentException If argument is not numeric or N class
     * @param  mixed   $num N or numeric value
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
     * @return boolean
     */
    public function gte($num)
    {
        self::mustBeNumeric($num, 'Tested number');

        if(is_object($num)){
            return $this->value >= $num->value;
        } else {
            return $this->value >= $num;
        }
    }

    public function ge($num)
    {
        return $this->gte($num);
    }

    protected function _negative()
    {
        return $this->value < 0;
    }

    protected function _zero()
    {
        return $this->value == 0;
    }

    protected function _positive()
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

    /**
     * Computes modulo of current number 
     * 
     * Computes modulo of current number using given number as divisor. Unlike 
     * `mod()` function, this can use integer or float value, into primitive 
     * PHP type or into `\Malenki\Bah\N` object.
     *
     * Example:
     *
     *     $n = new N(2001);
     *     echo $n->mod(5); // '1';
     *     echo $n->mod(3); // '0'
     *
     * @param int|float|double|N $mod Divisor as an integer/float/double-like 
     * value
     * @return N
     * @throws \InvalidArgumentException If given number is not valid type
     * @throws \InvalidArgumentException If given number is zero
     */
    public function mod($mod)
    {
        self::mustBeNumeric($mod, 'Divisor');

        if ($mod instanceof N) {
            $mod = $mod->double;
        }

        if ($mod == 0) {
            throw new \InvalidArgumentException('Cannot divide by 0!');
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
     * @throws \RuntimeException If current number is not an integer
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
        self::mustBeNumeric($num, 'Power calculus');

        return new N(
            pow(
                $this->value, 
                is_object($num) ? $num->value : $num
            )
        );
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
        self::mustBeNumeric($base, 'Log base');

        $n = is_object($base) ? $base->value : $base;

        if ($n == 1 || $n <= 0) {
            throw new \InvalidArgumentException(
                'Log base must be positive number different of one.'
            );
        }

        return new N(log( $this->value, $n));
    }

    protected function _ln()
    {
        return $this->log();
    }

    public function root($num)
    {
        self::mustBeNumeric($num, 'Root');
        
        $n = is_object($num) ? $num->value : $num;

        if ($n == 0) {
            throw new \InvalidArgumentException('Root must be not nul');
        }

        return new N(pow($this->value, 1 / $n));
    }

    protected function _sqrt()
    {
        return $this->root(2);
    }

    /**
     * Computes the factorial of current number.
     *
     * Computes the factorial of current number, the product form 1 to current 
     * integer number.
     *
     *     $n = new N(1);
     *     echo $n->factorial; // 1
     *     echo $n->incr->factorial; // 2
     *     echo $n->incr->factorial; // 6
     *     echo $n->incr->factorial; // 24
     *     echo $n->incr->factorial; // 120
     *     echo $n->incr->factorial; // 720
     * 
     * This method is the runtime part of magic getter `\Malenki\Bah\N::$factorial`;
     *
     * @see S::$factorial The magic getter `S::$factorial`
     * @see S::$fact Magic getter alias `S::$fact`
     * @return N
     * @throws \RuntimeException If current number is negative or is not an 
     * integer.
     */
    protected function _factorial()
    {
        if ($this->value == 0) {
            return new N(1);
        }

        if ($this->value < 0) {
            throw new \RuntimeException(
                'Cannot get factorial of negative number!'
            );
        }

        if (!$this->_decimal()->zero) {
            throw new \RuntimeException(
                'Cannot get factorial of non integer!'
            );
        }

        return new N(array_product(range(1, $this->value)));
    }

    /**
     * Get factorial number (Alias). 
     * 
     * @see S::$factorial The magic getter `S::$factorial` (original)
     * @see S::$fact Magic getter alias `S::$fact`
     * @see S::_factorial() Original method
     * @return N
     * @throws \RuntimeException If current number is negative or is not an 
     * integer.
     */
    protected function _fact()
    {
        return $this->_factorial();
    }


    protected function _triangular()
    {
        if ($this->value < 0) {
            throw new \RuntimeException(
                'Cannot get triangular number of negative number!'
            );
        }

        if (!$this->_decimal()->zero) {
            throw new \RuntimeException(
                'Cannot get triangular number of non integer!'
            );
        }

        return new N(($this->value * ($this->value + 1)) / 2);
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
     * @return boolean
     */
    public function equal($num)
    {
        self::mustBeNumeric($num, 'Test of equality');

        if(is_object($num)){
            return $this->value == $num->value;
        } else {
            return $this->value == $num;
        }
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

    protected function _ceil()
    {
        return new N(ceil($this->value));
    }


    protected function _floor()
    {
        return new N(floor($this->value));
    }

    public function round($precision = 0, $mode = PHP_ROUND_HALF_UP)
    {
        self::mustBeInteger($precision, 'Precision');

        if(
            !in_array(
                $mode, 
                array(
                    PHP_ROUND_HALF_UP,
                    PHP_ROUND_HALF_DOWN,
                    PHP_ROUND_HALF_EVEN,
                    PHP_ROUND_HALF_ODD
                )
            )
        ){
            throw new \InvalidArgumentException(
                'Mode must be one of this values: PHP_ROUND_HALF_UP,  '
                .'PHP_ROUND_HALF_DOWN, PHP_ROUND_HALF_EVEN, PHP_ROUND_HALF_ODD'
            );
        }

        return new N(round($this->value, $precision, $mode));
    }

    public function roundUp($precision = 0)
    {
        return $this->round($precision, PHP_ROUND_HALF_UP);
    }

    public function roundDown($precision = 0)
    {
        return $this->round($precision, PHP_ROUND_HALF_DOWN);
    }

    public function roundEven($precision = 0)
    {
        return $this->round($precision, PHP_ROUND_HALF_EVEN);
    }

    public function roundOdd($precision = 0)
    {
        return $this->round($precision, PHP_ROUND_HALF_ODD);
    }

    protected function _decimal()
    {
        $sign = 1;

        if ($this->value < 0) {
            $sign = -1;
        }

        return new N($sign * (abs($this->value) - floor(abs($this->value))));
    }

    /**
     * Tests whether current number is odd. 
     * 
     * Tests whether current integer number is odd or not. If current number is 
     * not an integer, then raises an `\RuntimeException`.
     *
     * This is used as runtime part of magic getter `S::$odd`.
     *
     * Example:
     *
     *     $n = new N(3);
     *     $n->odd; // true
     *     $n = new N(4);
     *     $n->odd; // false
     *     $n = new N(3.14);
     *     $n->odd; // raises eception
     *
     * @see S::$odd The magic getter `S::$odd`
     * $see S::_even() The opposite implementation for even number
     * @return boolean
     * @throws \RuntimeException If current number is not an integer
     */
    protected function _odd()
    {
        if((abs($this->value) - floor(abs($this->value))) != 0){
            throw new \RuntimeException(
                'Testing if number is odd or even only if it is an integer!'
            );
        }

        return (boolean) ($this->value & 1);
    }


    /**
     * Tests whether current number is even. 
     * 
     * Tests whether current integer number is even or not. If current number is 
     * not an integer, then raises an `\RuntimeException`.
     *
     * This is used as runtime part of magic getter `S::$even`.
     *
     * Example:
     *
     *     $n = new N(4);
     *     $n->even; // true
     *     $n = new N(5);
     *     $n->even; // false
     *     $n = new N(3.14);
     *     $n->even; // raises eception
     *
     * @see S::$even The magic getter `S::$even`
     * $see S::_odd() The opposite implementation for odd number
     * @return boolean
     * @throws \RuntimeException If current number is not an integer
     */
    protected function _even()
    {
        return !$this->_odd();
    }

    public function test($what)
    {
        self::mustBeString($what, 'Test argument');
        
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
    }

    /**
     * Adds current number to given argument.
     *
     * Create new `\Malenki\Bah\N` having the sum of given argument with 
     * current number
     *
     * @param  mixed $number Numeric-like value
     * @return N
     * @throws \InvalidArgumentException If argument is not N or numeric value.
     */
    public function plus($number)
    {
        self::mustBeNumeric($number, 'Value to add');
        
        $number = is_object($number) ? $number->value : $number;

        return new self($this->value + $number);
    }

    /**
     * Substract current number with other.
     *
     * Creates new `\Malenki\Bah\N` having the substraction of given argument 
     * with current number
     *
     * @param  mixed $number N or numeric value
     * @return N
     * @throws \InvalidArgumentException If argument is not N or numeric value.
     */
    public function minus($number)
    {
        self::mustBeNumeric($number, 'Value to substract');
        
        $number = is_object($number) ? $number->value : $number;
        
        return new self($this->value - $number);
    }

    /**
     * Creates new N by multipling the current to the given one
     *
     * @throw \InvalidArgumentException If argument is not N or numeric value.
     * @param  mixed $number N or numeric value
     * @return N
     */
    public function multiply($number)
    {
        self::mustBeNumeric($number, 'Value to multiply');
        
        $number = is_object($number) ? $number->value : $number;
        
        return new self($this->value * $number);
    }

    /**
     * Divide current number with given argument.
     *
     * @throw \InvalidArgumentException If given argument is zero
     * @throw \InvalidArgumentException If given argument is not N or numeric value.
     * @param  mixed $number N or numeric value
     * @return N
     */
    public function divide($number)
    {
        self::mustBeNumeric($number, 'Value to divide');
        
        $number = is_object($number) ? $number->value : $number;
        
        if ($number == 0) {
            throw new \InvalidArgumentException('You cannot divide by zero!');
        }

        return new self($this->value / $number);
    }

    /**
     * Converts current number to roman number. 
     * 
     * This converts current positive integer to roman numerals, returning 
     * `\Malenki\Bah\S` object.
     *
     * Example:
     *
     *     $n = new N(1979);
     *     echo $n->roman; // 'mcmlxxix'
     *     echo $n->roman->upper; // 'MCMLXXIX'
     *
     * @return S
     * @throws \RuntimeException If current number is not an positive integer.
     */
    protected function _roman()
    {
        if(!$this->_decimal()->zero || $this->value < 0){
            throw new \RuntimeException(
                'Converting into roman numerals uses only positive integers.'
            );
        }

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
     * @return s       object
     */
    public function greek($digamma = true)
    {
        if(!$this->_decimal()->zero || $this->value < 0){
            throw new \InvalidArgumentException(
                'Converting into greek uses only positive integers.'
            );
        }

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
        $arr_myriads = array(
            '兆', '吉', '太', '拍', '艾', '泽', '尧'
        );
        $arr_multiplicators = array(
            '千', '百', '十'
        );
        $arr_units = array(
            '零', '一', '二', '三', '四', '五', '六', '七', '八', '九'
        );

        if($use_simple_zero){
            $arr_units[0] = '〇';
        }

        if($this->_decimal()->zero){
            // split into reversed myriads
            $arr_groups = str_split(strrev((string) abs($this->value)), 4); 
            $arr_groups = array_values(array_reverse($arr_groups));

            $int_groups_cnt = count($arr_groups);

            // reordering all
            for($i = 0; $i < $int_groups_cnt; $i++){
                $arr_groups[$i] = strrev($arr_groups[$i]);
            }

            $out = '';
            $int_count = $int_groups_cnt - 2;


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
                            $arr_prov = array_slice(
                                $arr_multiplicators,
                                4 - $int_abslen
                            );
                        }

                        if(isset($arr_prov[$i])){
                            $out_prov .= $arr_prov[$i];
                        }
                    }
                }

                if(in_array((int) ltrim($v, 0), range(11, 19))){
                    $out_prov = preg_replace(
                        '/一十/ui', 
                        '十', 
                        $out_prov
                    );
                }

                if(mb_strlen($out_prov, 'UTF-8') > 1){
                    $out_prov = preg_replace(
                        '/'.$arr_units[0].'+$/ui', 
                        '',
                        $out_prov
                    );
                }

                $out .= preg_replace(
                    '/'.$arr_units[0].'+/ui',
                    $arr_units[0],
                    $out_prov
                );



                
                if($int_count >= 0){
                    if(isset($arr_myriads[$int_count])){
                        $out .= $arr_myriads[$int_count];
                    } else {
                        throw new \RuntimeException(
                            'Myriads for this number does not exists, cannot '
                            .'create number!'
                        );
                    }

                    $int_count--;
                }
            }

        } else {
            $part_int = new N(floor(abs($this->value)));
            $part_decimal = substr((string) abs($this->_decimal()->float), 2);

            $out = $part_int->chinese($use_simple_zero);
            $out .= '点' . strtr($part_decimal, $arr_units);
        }
        
        if($this->value < 0){
            $out = '负' . $out;
        }
        
        return new S($out);
    }


    /**
     * Convert to arabic string number (equiv of roman)
     *
     * @todo to implement
     * @return S
     */
    public function abjad()
    {
    }

    /**
     * Convert to hebrew string number
     *
     * @todo to implement
     * @return S
     */
    public function hebrew()
    {
    }


    /**
     * Converts to hexadecimal number.
     *
     * Returns current integer number converted to hexadecimal as 
     * `\Malenki\Bah\S` object.
     *
     * Example:
     *
     *     $n = new N(2001);
     *     echo $n->hex; // '7d1'
     *
     * This is runtime part of its associated magic getter.
     * 
     * @see N::$hex Magic getter `N::$hex`
     * @see N::_h() Alias
     * @return S
     * @throws \RuntimeException If current number is not an integer.
     */
    protected function _hex()
    {
        if(!$this->_decimal()->zero) {
            throw new \RuntimeException(
                'Cannot get hexadecimal numbers from non integer.'
            );
        }

        return new S(dechex($this->value));
    }

    /**
     * Converts to octal number.
     *
     * Returns current integer number converted to octal as `\Malenki\Bah\S` 
     * object.
     *
     * Example:
     *
     *     $n = new N(2001);
     *     echo $n->oct; // '3721'
     *
     * This is runtime part of its associated magic getter.
     * 
     * @see N::$oct Magic getter `N::$oct`
     * @see N::_o() Alias
     * @return S
     * @throws \RuntimeException If current number is not an integer.
     */
    protected function _oct()
    {
        if(!$this->_decimal()->zero) {
            throw new \RuntimeException(
                'Cannot get octal numbers from non integer.'
            );
        }

        return new S(decoct($this->value));
    }


    /**
     * Converts to binary number.
     *
     * Returns current integer number converted to binary as `\Malenki\Bah\S` 
     * object.
     *
     * Example:
     *
     *     $n = new N(2001);
     *     echo $n->bin; // '11111010001'
     *
     * This is runtime part of its associated magic getter.
     * 
     * @see N::$bin Magic getter `N::$bin`
     * @see N::_b() Alias
     * @return S
     * @throws \RuntimeException If current number is not an integer.
     */
    protected function _bin()
    {
        if(!$this->_decimal()->zero) {
            throw new \RuntimeException(
                'Cannot get binary numbers from non integer.'
            );
        }

        return new S(decbin($this->value));
    }

    /**
     * Converts to hexadecial number (Alias).
     *
     * This is runtime part of its associated magic getter.
     *
     * Example:
     *
     *     $n = new N(2001);
     *     echo $n->h; // '7d1'
     *     echo $n->hex; // '7d1'
     *
     *
     * @see N::$h Magic getter `N::$h`
     * @see N::_hex() Original runtime
     * @return S
     * @throws \RuntimeException If current number is not an integer.
     */
    protected function _h()
    {
        return $this->_hex();
    }


    /**
     * Converts to octal number (Alias).
     *
     * This is runtime part of its associated magic getter.
     *
     * Example:
     *
     *     $n = new N(2001);
     *     echo $n->o; // '3721'
     *     echo $n->oct; // '3721'
     *
     *
     * @see N::$o Magic getter `N::$o`
     * @see N::_oct() Original runtime
     * @return S
     * @throws \RuntimeException If current number is not an integer.
     */
    protected function _o()
    {
        return $this->_oct();
    }


    /**
     * Converts to binary number (Alias)
     *
     * This is runtime part of its associated magic getter.
     *
     * Example:
     *
     *     $n = new N(2001);
     *     echo $n->b; // '11111010001'
     *     echo $n->bin; // '11111010001'
     *
     *
     * @see N::$b Magic getter `N::$b`
     * @see N::_bin() Original runtime
     * @return S
     * @throws \RuntimeException If current number is not an integer.
     */
    protected function _b()
    {
        return $this->_bin();
    }

    public function base($n)
    {
        if(!$this->_decimal()->zero) {
            throw new \RuntimeException(
                'Cannot get decimal numbers into another base.'
            );
        }

        self::mustBeInteger($n, 'Base');

        $n = is_object($n) ? $n->int : $n;

        if (!is_numeric($n) || $n < 2 || $n > 36) {
            throw new \InvalidArgumentException(
                'Base must be a integer or N value from 2 to 36 inclusive.'
            );
        }

        return new S(base_convert($this->value, 10, $n));
    }


    public function times($callback)
    {
        self::mustBeCallable($callback);

        if(!$this->_decimal()->zero) {
            throw new \RuntimeException(
                'Cannot iterate given callback when number is not integer.'
            );
        }

        if($this->value == 0){
            throw new \RuntimeException(
                'Cannot iterate given callback on a void range.'
            );
        }

        if($this->value > 0){
            $arr_range = range(0, $this->value - 1);
        } else {
            $arr_range = range($this->value + 1, 0);
        }

        $a = new A();

        foreach($arr_range as $idx){
            $idx = new N($idx);
            $a->add($callback($idx));
        }

        return $a;
    }

    protected function _cos()
    {
        return new static(cos($this->value));
    }

    protected function _sin()
    {
        return new static(sin($this->value));
    }

    protected function _tan()
    {
        return new static(tan($this->value));
    }


    protected function _cosh()
    {
        return new static(cosh($this->value));
    }

    protected function _sinh()
    {
        return new static(sinh($this->value));
    }

    protected function _tanh()
    {
        return new static(tanh($this->value));
    }





    protected function _acos()
    {
        return new static(acos($this->value));
    }

    protected function _asin()
    {
        return new static(asin($this->value));
    }

    protected function _atan()
    {
        return new static(atan($this->value));
    }


    protected function _acosh()
    {
        return new static(acosh($this->value));
    }

    protected function _asinh()
    {
        return new static(asinh($this->value));
    }

    protected function _atanh()
    {
        return new static(atanh($this->value));
    }




    public function __toString()
    {
        return "{$this->value}";
    }
}

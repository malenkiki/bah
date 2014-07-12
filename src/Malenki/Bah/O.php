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
 * Base object, mother of all classes of this package.
 *
 * It contains some validation processes, basic magic getter to get internal 
 * value and `__toString()` feature.
 *
 * @package Malenki\Bah
 * @license MIT
 * @author Michel Petit aka "Malenki" <petit.michel@gmail.com>
 */
class O
{

    /**
     * @var mixed Primitive value
     */
    protected $value = null;


    /**
     * Checks whether given value is string-like or scalar type. 
     * 
     * Value must be of string-like type (string or object having 
     * `__toString()` method) or a basic scalar type.
     *
     * The aim of this method is only to raise `\InvalidArgumentException` if 
     * given value has not the good type.
     *
     * @param mixed $arg The value to test.
     * @param string $arg_name Optional name of the value, used into exception’s message.
     * @return void
     * @throws \InvalidArgumentException If value’s type is not valid
     */
    protected static function mustBeStringOrScalar($arg, $arg_name = null)
    {
        if (
            !is_scalar($arg)
            &&
            !(is_object($arg) && method_exists($arg, '__toString'))
        ) {
            throw new \InvalidArgumentException(
                sprintf(
                    '%s must be a primitive scalar PHP type or object '
                    .'having `__toString()` method',
                    is_null($arg_name) ? 'Argument' : $arg_name
                    )
            );
        }
    }





    /**
     * Checks whether given value is string-like type. 
     * 
     * A string-like value is string or object having `__toString()` method.
     *
     * The aim of this method is only to raise `\InvalidArgumentException` if 
     * given value has not the good type.
     *
     * @param mixed $arg The value to test.
     * @param string $arg_name Optional name of the value, used into exception’s message.
     * @return void
     * @throws \InvalidArgumentException If value’s type is not valid
     */
    protected static function mustBeString($arg, $arg_name = null)
    {
        if (
            !is_string($arg)
            &&
            !(is_object($arg) && method_exists($arg, '__toString'))
        ) {
            throw new \InvalidArgumentException(
                sprintf(
                    '%s must be a primitive string PHP type or object '
                    .'having `__toString()` method',
                    is_null($arg_name) ? 'Argument' : $arg_name
                    )
            );
        }
    }




    /**
     * Checks whether given value is integer-like type. 
     * 
     * An integer-like value is integer or `\Malenki\Bah\N` object.
     *
     * The aim of this method is only to raise `\InvalidArgumentException` if 
     * given value has not the good type.
     *
     * @param mixed $arg The value to test.
     * @param string $arg_name Optional name of the value, used into exception’s message.
     * @return void
     * @throws \InvalidArgumentException If value’s type is not valid
     */
    protected static function mustBeInteger($arg, $arg_name = null)
    {
        if(!is_integer($arg) && !($arg instanceof N)){
            throw new \InvalidArgumentException(
                sprintf(
                    '%s must be a primitive integer PHP type or '
                    .'object \Malenki\Bah\N',
                    is_null($arg_name) ? 'Argument' : $arg_name
                )
            );
        }
    }




    /**
     * Checks whether given value is float-like type. 
     * 
     * A float-like value is float or `\Malenki\Bah\N` object.
     *
     * The aim of this method is only to raise `\InvalidArgumentException` if 
     * given value has not the good type.
     *
     * @param mixed $arg The value to test.
     * @param string $arg_name Optional name of the value, used into exception’s message.
     * @return void
     * @throws \InvalidArgumentException If value’s type is not valid
     */
    protected static function mustBeFloat($arg, $arg_name = null)
    {
        if(!is_float($arg) && !($arg instanceof N)){
            throw new \InvalidArgumentException(
                sprintf(
                    '%s must be a primitive float PHP type or '
                    .'object \Malenki\Bah\N',
                    is_null($arg_name) ? 'Argument' : $arg_name
                )
            );
        }
    }




    /**
     * Checks whether given value is double-like type. 
     * 
     * A double-like value is string or `\Malenki\Bah\N` object.
     *
     * The aim of this method is only to raise `\InvalidArgumentException` if 
     * given value has not the good type.
     *
     * @param mixed $arg The value to test.
     * @param string $arg_name Optional name of the value, used into exception’s message.
     * @return void
     * @throws \InvalidArgumentException If value’s type is not valid
     */
    protected static function mustBeDouble($arg, $arg_name = null)
    {
        if(!is_double($arg) && !($arg instanceof N)){
            throw new \InvalidArgumentException(
                sprintf(
                    '%s must be a primitive double PHP type or '
                    .'object \Malenki\Bah\N',
                    is_null($arg_name) ? 'Argument' : $arg_name
                )
            );
        }
    }




    /**
     * Checks whether given value is numeric-like type. 
     * 
     * A numeric-like value is numeric (integer, float or double) or 
     * `\Malenki\Bah\N` object.
     *
     * The aim of this method is only to raise `\InvalidArgumentException` if 
     * given value has not the good type.
     *
     * @param mixed $arg The value to test.
     * @param string $arg_name Optional name of the value, used into exception’s message.
     * @return void
     * @throws \InvalidArgumentException If value’s type is not valid
     */
    protected static function mustBeNumeric($arg, $arg_name = null)
    {
        if(!is_numeric($arg) && !($arg instanceof N)){
            throw new \InvalidArgumentException(
                sprintf(
                    '%s must be a primitive numeric PHP type or '
                    .'object \Malenki\Bah\N',
                    is_null($arg_name) ? 'Argument' : $arg_name
                )
            );
        }
    }




    /**
     * Checks whether given value is an array-like type. 
     * 
     * A array-like value is an array or `\Malenki\Bah\A` object.
     *
     * The aim of this method is only to raise `\InvalidArgumentException` if 
     * given value has not the good type.
     *
     * @param mixed $arg The value to test.
     * @param string $arg_name Optional name of the value, used into exception’s message.
     * @return void
     * @throws \InvalidArgumentException If value’s type is not valid
     */
    protected static function mustBeArray($arg, $arg_name = null)
    {
        $msg = sprintf(
            '%s must be a primitive integer indexed array PHP type or '
            .'object \Malenki\Bah\A',
            is_null($arg_name) ? 'Argument' : $arg_name
        );

        if(!is_array($arg) && !($arg instanceof A)){
            throw new \InvalidArgumentException($msg);
        }

        if(is_array($arg)){
            foreach(array_keys($arg) as $ak){
                if(!is_integer($ak)){
                    throw new \InvalidArgumentException($msg);
                }
            }
        }
    }


    /**
     * Checks whether given value is a hash-like type. 
     * 
     * A hash-like value is an array having named-index or `\Malenki\Bah\H` object.
     *
     * The aim of this method is only to raise `\InvalidArgumentException` if 
     * given value has not the good type.
     *
     * @param mixed $arg The value to test.
     * @param string $arg_name Optional name of the value, used into exception’s message.
     * @return void
     * @throws \InvalidArgumentException If value’s type is not valid
     */
    protected static function mustBeHash($arg, $arg_name = null)
    {
        $msg = sprintf(
            '%s must be a primitive named indexed array PHP type or '
            .'object \Malenki\Bah\A',
            is_null($arg_name) ? 'Argument' : $arg_name
        );


        if(!is_array($arg) && !($arg instanceof H)){
            throw new \InvalidArgumentException($msg);
        }

        if(is_array($arg)){
            foreach(array_keys($arg) as $ak){
                if(!is_string($ak)){
                    throw new \InvalidArgumentException($msg);
                }
            }
        }
    }




    /**
     * Magic getters engine.
     *
     * By default, return internal `O::$value` attribute. 
     * 
     * @param string $name Magic getter's name.
     * @return mixed
     */
    public function __get($name)
    {
        if ($name == 'value') {
            return $this->value;
        }
    }



    /**
     * Convert current object into string when this is in string context. 
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->value;
    }
}

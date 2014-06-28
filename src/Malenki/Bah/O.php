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
 * @package Malenki\Bah
 * @license MIT
 */
class O
{

    /**
     * @var mixed Primitive value
     */
    protected $value = null;


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




    public function __get($name)
    {
        if ($name == 'value') {
            return $this->value;
        }
    }

    public function __toString()
    {
        return $this->value;
    }
}

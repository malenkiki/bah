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

class H implements \Countable
{
    private $count = 0;
    private $value = array();



    public function __get($name)
    {
        if(in_array($name, array('array', 'length', 'keys', 'values')))
        {
            $str_method = '_' . $name;
            return $this->$str_method();
        }
    }



    public function __set($name, $value)
    {
        if(in_array($name, array('array', 'length', 'keys', 'values')))
        {
            throw new \RuntimeException($name . ' is not allowed as key name.');
        }

        $this->set($name, $value);
    }


    public function __isset($name)
    {
        return $this->exist($name);
    }



    public function __unset($name)
    {
        if(!$this->exist($name))
        {
            throw new \RuntimeException($name . ' does not exist and cannot be deleted.');
        }

        return $this->delete($name);
    }



    public function __construct($arr = array())
    {
        foreach($arr as $k => $v)
        {
            if(is_numeric($k))
            {
                throw new \RuntimeException('Array must have all keys defined as string.');
            }
        }

        $this->value = $arr;
        $this->count = count($arr);
    }



    protected function _array()
    {
        return $this->value;
    }


    protected function _length()
    {
        return new N($this->count);
    }

    protected function _keys()
    {
        return new A(array_keys($this->value));
    }


    protected function _values()
    {
        return new A(array_values($this->value));
    }


    public function exist($key)
    {
        return array_key_exists($key, $this->value);
    }


    public function has($thing)
    {
        return in_array($thing, $this->value);
    }


    public function set($key, $value)
    {
        $this->value[$key] = $value;
        $this->count = count($this->value);
    }


    public function take($key)
    {
        if(!$this->exist($key))
        {
            throw new \RuntimeException('Given key '. $key . ' does not exist!');
        }

        return $this->value[$key];
    }

    public function get($key)
    {
        return $this->take($key);
    }
    
    public function delete($key)
    {
        if(!$this->exist($key))
        {
            throw new \RuntimeException('Given key '. $key . ' does not exist!');
        }

        unset($this->value[$key]);
        $this->count--;
    }
    


    public function count()
    {
        return $this->count;
    }

}

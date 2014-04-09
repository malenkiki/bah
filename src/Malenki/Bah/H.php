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

class H implements \Iterator, \Countable
{
    private $count = 0;
    private $value = array();
    private $position = null;



    public function __get($name)
    {
        if(in_array($name, array('array', 'length', 'keys', 'values', 'reverse', 'sort')))
        {
            $str_method = '_' . $name;
            return $this->$str_method();
        }
        elseif(in_array($name, array('current', 'key', 'next', 'rewind', 'valid')))
        {
            return $this->$name();
        }
        elseif($this->exist($name))
        {
            return $this->get($name);
        }
    }



    public function __set($name, $value)
    {
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
        if(!is_array($arr))
        {
            if($arr instanceof H)
            {
                $arr = $arr->array;
            }
            else
            {
                throw new \InvalidArgumentException('Constructor must have array or Class H instance.');
            }
        }
        foreach($arr as $k => $v)
        {
            if(is_numeric($k))
            {
                throw new \RuntimeException('Array must have all keys defined as string.');
            }
            else
            {
                $this->set($k, $v);
            }
        }

        $this->count = count($arr);
        $this->position = new N(0);
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


    public function current()
    {
        $out = new \stdClass();
        $out->key = $this->_keys()->take($this->position->value);
        $out->value = $this->_values()->take($this->position->value);

        return $out;
    }

    public function key()
    {
        return $this->position;
    }
    
    public function next()
    {
        $this->position->incr;

        return $this;
    }
    public function rewind()
    {
        $this->position->value = 0;

        return $this;
    }

    public function valid()
    {
        return $this->_values()->exist($this->position->value);
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
        if(
            in_array(
                $key,
                array(
                    'array', 
                    'length', 
                    'keys',
                    'values',
                    'current',
                    'key',
                    'next',
                    'rewind',
                    'valid'
                )
            )
        )
        {
            throw new \RuntimeException($key . ' is not allowed as key name.');
        }

        $this->value[$key] = $value;
        $this->count = count($this->value);

        return $this;
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

        return $this;
    }



    protected function _reverse()
    {
        return new self(array_reverse($this->value, true));
    }



    protected function _sort()
    {
        $arr = $this->value;
        asort($arr);
        return new self($arr);
    }



    public function count()
    {
        return $this->count;
    }

    public function map($func)
    {
        $arr = array_map($func, $this->_keys()->array, $this->value);

        $out = new self();

        foreach($this->_keys()->array as $k => $v)
        {
            $out->set($v, $arr[$k]);
        }

        return $out;
    }

}

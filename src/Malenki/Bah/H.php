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

class H extends O implements \Countable, \IteratorAggregate
{
    protected $count = 0;
    protected $position = null;

    public function __get($name)
    {
        if (in_array($name, array('array', 'arr', 'length', 'keys', 'values', 'reverse', 'sort', 'unique'))) {
            $str_method = '_' . $name;

            return $this->$str_method();
        } elseif (in_array($name, array('current', 'key', 'next', 'rewind', 'valid'))) {
            return $this->$name();
        } elseif ($this->exist($name)) {
            return $this->get($name);
        } elseif($name == 'to_a'){
            return new A(array_values($this->value));
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
        if (!$this->exist($name)) {
            throw new \RuntimeException($name . ' does not exist and cannot be deleted.');
        }

        return $this->delete($name);
    }

    public function __construct($arr = array())
    {
        if (!is_array($arr)) {
            if ($arr instanceof H) {
                $arr = $arr->array;
            } else {
                throw new \InvalidArgumentException('Constructor must have array or Class H instance.');
            }
        }
        foreach ($arr as $k => $v) {
            if (is_numeric($k)) {
                throw new \RuntimeException('Array must have all keys defined as string.');
            } else {
                $this->set($k, $v);
            }
        }

        $this->count = count($arr);
        $this->position = new N(0);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->value);
    }


    protected function _array()
    {
        return $this->value;
    }

    protected function _arr()
    {
        return $this->_array();
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
        if(is_object($key) && method_exists($key, '__toString()')){
            $key = "$key";
        }

        if(!is_string($key)){
            throw new \InvalidArgumentException(
                'Key’s name to use while setting new key/value pair must be string.'
            );
        }

        if(
            in_array(
                $key,
                array(
                    'array',
                    'length',
                    'keys',
                    'values',
                    'reverse',
                    'sort',
                    'unique',
                    'current',
                    'key',
                    'next',
                    'rewind',
                    'valid',
                    'to_a'
                )
            )
        )
        {
            throw new \RuntimeException($key . ' is not allowed as key name.');
        }

        if(is_null($this->value)){
            $this->value = array();
        }

        $this->value[$key] = $value;
        $this->count = count($this->value);

        return $this;
    }

    public function take($key)
    {
        if (!$this->exist($key)) {
            throw new \RuntimeException('Given key '. $key . ' does not exist!');
        }

        return $this->value[$key];
    }

    public function get($key)
    {
        return $this->take($key);
    }

    public function at($key)
    {
        return $this->take($key);
    }

    public function delete($key)
    {
        if (!$this->exist($key)) {
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

    protected function _unique()
    {
        return new self(array_unique($this->value, SORT_REGULAR));
    }

    public function chunk($size)
    {
        self::mustBeInteger($size, 'Size');

        if ($size instanceof N) {
            $size = $size->int;
        }

        if ($size < 1) {
            throw new \InvalidArgumentException('Chunk cannot have null size, please use number equal or greater than one.');
        }

        $arr = array_chunk($this->value, $size, true);

        foreach ($arr as $k => $v) {
            $arr[$k] = new self($v);
        }

        return new A($arr);
    }

    public function count()
    {
        return $this->count;
    }

    public function map($func)
    {
        self::mustBeCallable($func);

        $arr = array_map($func, $this->_keys()->array, $this->value);

        $out = new self();

        foreach ($this->_keys()->array as $k => $v) {
            $out->set($v, $arr[$k]);
        }

        return $out;
    }

    public function walk($func, $other = null)
    {
        self::mustBeCallable($func);
        
        $arr = $this->value;

        array_walk($arr, $func, $other);

        return new self($arr);
    }


    /**
     * Search index of the given element.
     *
     * This will return the first index found for the given element if there are several identical.
     *
     * If no element found, then return null.
     *
     * If element is found, then S object is returned.
     *
     * @param  mixed $foo The element to find
     * @return mixed
     */
    public function search($foo)
    {

        if (in_array($foo, $this->value)) {
            return new S(array_search($foo, $this->value, true));
        } else {
            return null;
        }
    }

    public function find($pattern)
    {
        self::mustBeString($pattern, 'Pattern');

        if (strlen($pattern) == 0) {
            throw new \InvalidArgumentException('Pattern must be a not null string.');
        }

        $h = new self();

        foreach ($this->value as $k => $v) {
            if (preg_match($pattern, $k)) {
                $h->set($k, $v);
            }
        }

        return $h;
    }

    public function slice($offset, $length = null)
    {
        self::mustBeInteger($offset, 'Offset');

        if(!is_null($length)){
            self::mustBeInteger($length, 'Length');
        }

        if ($offset instanceof N) {
            $offset = $offset->int;
        }

        if ($length instanceof N) {
            $length = $length->int;
        }

        return new self(array_slice($this->value, $offset, $length, true));
    }

    public function merge($arr)
    {
        if ($arr instanceof A) {
            throw new \InvalidArgumentException('Class \Malenki\Bah\H cannot merge its content with \Malenki\Bah\A class.');
        }

        if (is_array($arr)) {
            foreach ($arr as $k => $v) {
                if (is_numeric($k)) {
                    throw new \RuntimeException('Array must have all keys defined as string.');
                }
            }
        }

        if ($arr instanceof H) {
            $arr = $arr->array;
        }

        return new self(array_merge($this->value, $arr));
    }

    public function __toString()
    {
        return (string) count($this);
    }
}

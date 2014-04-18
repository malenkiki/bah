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
 * Enhanced array. 
 * 
 * @property-read $array Gets content as primitive array
 * @property-read $index Gets current index
 * @property-read $length Number of elements included into the collection
 * @property-read $last Gets last element
 * @property-read $first Gets the first element
 * @property-read $lastButOne Gets the last but one element
 * @property-read $shift Takes the first element and remove it from the collection
 * @property-read $pop Takes the last element and remove it from the collection
 * @property-read $random Gets randomly one element
 * @property-read $shuffle Gets new collection with the same content as current one, but into shuffle order.
 * @property-read $join Concatenate all element into a string if each element has toString ethod or are primitive type.
 * @property-read $implode Same as join magic attribute
 * @property-read $current Gets current element
 * @property-read $key Gets index of current element
 * @property-read $next Place index on the next element
 * @property-read $rewind Rewind :-)
 * @property-read $valid Is there another element after current one?
 * @copyright 2014 Michel Petit
 * @author Michel Petit <petit.michel@gmail.com> 
 * @license MIT
 */
class A implements \Iterator, \Countable
{
    private $count = 0;
    private $position = null;


    public function __get($name)
    {
        if(in_array($name, array('array', 'index', 'length', 'last', 'first', 'lastButOne', 'shift', 'pop', 'random', 'shuffle', 'join', 'implode', 'current', 'key', 'next', 'rewind', 'valid', 'reverse', 'sort', 'unique')))
        {
            if($name == 'index')
            {
                return $this->key();
            }
            elseif($name == 'random')
            {
                return $this->random(1);
            }
            elseif(in_array($name, array('implode', 'join')))
            {
                return $this->implode();
            }
            elseif(in_array($name, array('current', 'key', 'next', 'rewind', 'valid')))
            {
                return $this->$name();
            }
            elseif(in_array($name, array('array', 'length', 'last', 'first', 'lastButOne', 'shift', 'pop', 'shuffle', 'reverse', 'sort', 'unique')))
            {
                $str_method = '_' . $name;
                return $this->$str_method();
            }
            else
            {
                return $this->$name();
            }
        }
    }

    public function __construct($arr = array())
    {
        if(!is_array($arr))
        {
            if($arr instanceof A || $arr instanceof H)
            {
                $arr = $arr->array;
            }
            else
            {
                throw new \InvalidArgumentException('Constructor must have array, Class A or Class H instance.');
            }
        }

        $this->value = $arr;
        $this->count = count($arr);
        $this->position = new N(0);
    }

    public function current()
    {
        return $this->value[$this->position->value];
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
        return isset($this->value[$this->position->value]);
    }

    protected function _length()
    {
        return new N($this->count);
    }

    public function count()
    {
        return $this->count;
    }

    /**
     * Gets item having given index. Shorthand for `take` method.
     * 
     * @param mixed $idx N or integer
     * @access public
     * @return mixed
     */
    public function take($idx)
    {
        if($idx instanceof N)
        {
            $idx = $idx->int;
        }

        if(!$this->exist($idx))
        {
            throw new \OutOfRangeException('Given '. $idx .' index does not exist!');
        }

        return $this->value[$idx];
    }

    /**
     * Gets item having given index. Shorthand for `take` method.
     * 
     * @param mixed $idx N or integer
     * @access public
     * @return mixed
     */
    public function get($idx)
    {
        return $this->take($idx);
    }

    public function exist($idx)
    {
        if($idx instanceof N)
        {
            $idx = $idx->int;
        }

        return array_key_exists($idx, $this->value);
    }

    protected function _lastButOne()
    {
        if($this->count < 2)
        {
            throw new \RuntimeException(_('This collection is too small to have last but one value.'));
        }
        return $this->value[$this->count - 2];
    }

    protected function _last()
    {
        return $this->value[$this->_length()->p->value];
    }

    protected function _first()
    {
        return $this->value[0];
    }

    public function has($thing)
    {
        return in_array($thing, $this->value);
    }

    public function add($thing)
    {
        $this->value[] = $thing;
        $this->count++;

        return $this;
    }


    protected function _unique()
    {
        return new self(array_unique($this->value, SORT_REGULAR));
    }



    public function delete($idx)
    {
        if($idx instanceof N)
        {
            $idx = $idx->int;
        }

        if(!$this->exist($idx))
        {
            throw new \OutOfRangeException('Given '. $idx .' index does not exist!');
        }

        unset($this->value[$idx]);
        $this->count--;

        return $this;
    }
    

    protected function _shift()
    {
        if($this->count() == 0)
        {
            throw new \RuntimeException('Cannot take element from void collection!');
        }

        $this->count--;
        return array_shift($this->value);
    }
    
    protected function _pop()
    {
        if($this->count() == 0)
        {
            throw new \RuntimeException('Cannot take element from void collection!');
        }

        $this->count--;
        return array_pop($this->value);
    }


    public function replace($idx, $thing)
    {
        if($idx instanceof N)
        {
            $idx = $idx->int;
        }

        if(!$this->exist($idx))
        {
            throw new \OutOfRangeException('Given '. $idx .' index does not exist!');
        }

        $this->value[$idx] = $thing;

        return $this;
    }

    public function implode($sep = '')
    {
        $arr = $this->value;

        foreach($this->value as $idx => $item)
        {
            if(
                is_scalar($item)
                ||
                $item instanceof S
                ||
                $item instanceof A
                ||
                (is_object($item) && method_exists($item, '__toString'))
            )
            {
                if($item instanceof A)
                {
                    $arr[$idx] = $item->join($sep);
                }
                else
                {
                    continue;
                }
            }
            else
            {
                throw new \RuntimeException('Cannot convert this item to string');
            }
        }
        return new S(implode($sep, $arr));
    }

    public function join($sep = '')
    {
        return $this->implode($sep);
    }

    public function _array()
    {
        $arr = array_values($this->value);

        foreach($arr as $k => $v)
        {
            if($v instanceof A || $v instanceof H)
            {
                $arr[$k] = $v->array;
            }
        }

        return $arr;
    }


    protected function _shuffle()
    {
        $arr = $this->value;

        shuffle($arr);

        return new self($arr);
    }



    protected function _reverse()
    {
        return new self(array_reverse($this->value));
    }


    protected function _sort()
    {
        $arr = $this->value;
        sort($arr);
        return new self($arr);
    }



    public function pad($size, $value = null)
    {
        if($size instanceof N)
        {
            $size = $size->int;
        }

        return new self(array_pad($this->value, $size, $value));
    }



    public function map($func)
    {
        return new self(array_map($func, $this->value));
    }

    public function filter($func)
    {
        return new self(array_filter($this->value, $func));
    }

    public function random($n = 1)
    {
        if($n instanceof N)
        {
            $n = $n->int;
        }

        if(!is_numeric($n) || $n < 1)
        {
            throw new \InvalidArgumentException('Random items amount must be an integer greater than or equal one.');
        }

        if($n > $this->count())
        {
            throw new \RuntimeException('Cannot take more random elements than amount contained into the collection.');
        }

        $mix = array_rand($this->value, $n);

        if(is_integer($mix))
        {
            return $this->value[$mix];
        }

        $out = new self();

        foreach($mix as $idx)
        {
            $out->add($this->value[$idx]);
        }

        return $out;
    }



    public function diff($arr)
    {
        if($arr instanceof A)
        {
            $arr = $arr->array;
        }
        
        if($arr instanceof H)
        {
            $arr = $arr->array;
        }

        return new self(array_values(array_diff($this->value, $arr)));
    }



    public function inter($arr)
    {
        if($arr instanceof A)
        {
            $arr = $arr->array;
        }
        
        if($arr instanceof H)
        {
            $arr = $arr->array;
        }

        return new self(array_values(array_intersect($this->value, $arr)));
    }


    public function merge($arr)
    {
        if($arr instanceof A)
        {
            $arr = $arr->array;
        }
        
        if($arr instanceof H)
        {
            $arr = $arr->array;
        }

        return new self(array_values(array_merge($this->value, $arr)));
    }

    public function chunk($size)
    {
        if($size instanceof N)
        {
            $size = $size->int;
        }

        if($size < 1)
        {
            throw new \InvalidArgumentException('Chunk cannot have null size, please use number equal or greater than one.');
        }

        $arr = array_chunk($this->value, $size);

        foreach($arr as $k => $v)
        {
            if(is_array($v))
            {
                $arr[$k] = new self($v);
            }
        }

        return new self($arr);
    }



    public function slice($offset, $length = null)
    {
        if($offset instanceof N)
        {
            $offset = $offset->int;
        }

        if($length instanceof N)
        {
            $length = $length->int;
        }


        return new self(array_slice($this->value, $offset, $length, false));
    }


    /**
     * Search index of the given element.
     *
     * This will return the first index found for the given element if there are several identical.
     * 
     * If no element found, then return null.
     *
     * If element is found, then N object is returned.
     *
     * @param mixed $foo The element to find
     * @access public
     * @return mixed
     */
    public function search($foo)
    {
        
        if(in_array($foo, $this->value))
        {
            return new N(array_search($foo, $this->value, true));
        }
        else
        {
            return null;
        }
    }


    public function __toString()
    {
        return (string) $this->count;
    }
}

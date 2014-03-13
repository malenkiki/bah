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

class A implements \Iterator, \Countable
{
    private $count = 0;
    private $position = null;


    public function __get($name)
    {
        if(in_array($name, array('index', 'length', 'last', 'first', 'lastButOne')))
        {
            if($name == 'index')
            {
                return $this->key();
            }
            elseif(in_array($name, array('length', 'last', 'first', 'lastButOne')))
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
    }
    public function rewind()
    {
        $this->position->value = 0;
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

    public function take($idx)
    {
        if(!$this->exist($idx))
        {
            throw new \OutOfRangeException('Given '. $idx .' index does not exist!');
        }

        return $this->value[$idx];
    }

    public function exist($idx)
    {
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
    }

    public function replace($idx, $thing)
    {
        if(!$this->exist($idx))
        {
            throw new \OutOfRangeException('Given '. $idx .' index does not exist!');
        }

        $this->value[$idx] = $thing;
    }

    public function implode($sep = '')
    {
        foreach($this->value as $item)
        {
            if(
                is_scalar($item)
                ||
                $item instanceof S
                ||
                (is_object($item) && method_exists($item, '__toString'))
            )
            {
                continue;
            }
            else
            {
                throw new \RuntimeException('Todo');
            }
        }
        return new S(implode($sep, $this->value));
    }



    public function __toString()
    {
        return (string) $this->count;
    }
}

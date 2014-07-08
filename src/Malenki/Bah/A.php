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
 * @property-read $key_X Gets content at key X
 * @property-read $index_X Gets content at key X
 * @property-read $array Gets content as primitive array
 * @property-read $index Gets current index
 * @property-read $length Number of elements included into the collection
 * @property-read $is_last Tests if it is the last element (while context)
 * @property-read $is_first Tests if it is the first element (while context)
 * @property-read $is_last_but_one Tests if it is the last but one element (while context)
 * @property-read $last Gets last element
 * @property-read $first Gets the first element
 * @property-read $last_but_one Gets the last but one element
 * @property-read $shift Takes the first element and remove it from the collection
 * @property-read $pop Takes the last element and remove it from the collection
 * @property-read $random Gets randomly one element
 * @property-read $shuffle Gets new collection with the same content as current one, but into shuffle order.
 * @property-read $join Concatenate all element into a string if each element has toString ethod or are primitive type.
 * @property-read $implode Same as join magic attribute
 * @property-read $max Gets max numeric value contained into collection
 * @property-read $min Gets min numeric value contained into collection
 * @property-read $current Gets current element
 * @property-read $key Gets index of current element
 * @property-read $next Place index on the next element
 * @property-read $rewind Rewind :-)
 * @property-read $valid Is there another element after current one?
 * @copyright 2014 Michel Petit
 * @author Michel Petit <petit.michel@gmail.com>
 * @license MIT
 */
class A extends O implements \Countable, \IteratorAggregate
{
    protected $count = 0;
    protected $position = null;

    public function __get($name)
    {

        if ($name == 'index') {
            return $this->key();
        } elseif ($name == 'random') {
            return $this->random(1);
        } elseif ($name == 'last_but_one') {
            return $this->_lastButOne();
        } elseif (in_array($name, array('implode', 'join'))) {
            return $this->implode();
        } elseif (in_array($name, array('current', 'key', 'next', 'rewind', 'valid'))) {
            return $this->$name();
        } elseif (in_array($name, array('min', 'max'))) {
            return $this->_maxOrMin($name);
        } elseif (in_array($name, array('array', 'arr', 'length', 'last', 'first', 'shift', 'pop', 'shuffle', 'reverse', 'sort', 'unique'))) {
            $str_method = '_' . $name;

            return $this->$str_method();
        } elseif(in_array($name, array('is_first', 'is_last', 'is_last_but_one'))){
            $m = '_is' . implode(
                array_map(
                    'ucfirst',
                    explode('_', preg_replace('/^is_/', '', $name))
                )
            );
            return $this->$m();
        } elseif(preg_match('/^(index|key)_[0-9]+$/', $name)){
            $arr = explode('_', $name);
            return $this->take((int) $arr[1]);
        } else {
            return $this->$name();
        }
    }
    
    public function __set($name, $value)
    {
        if(preg_match('/^(index|key)_[0-9]+$/', $name)){
            $arr = explode('_', $name);
            $this->replace((int) $arr[1], $value);
        }
    }
     


    public function __construct($arr = array())
    {
        if (!is_array($arr)) {
            if ($arr instanceof A || $arr instanceof H) {
                $arr = $arr->array;
            } else {
                throw new \InvalidArgumentException('Constructor must have array, Class A or Class H instance.');
            }
        }

        $this->value = $arr;
        $this->count = count($arr);
        $this->position = new N(0);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->value);
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
     * @param  mixed $idx N or integer
     * @access public
     * @return mixed
     */
    public function take($idx)
    {
        self::mustBeInteger($idx, 'Index');

        if ($idx instanceof N) {
            $idx = $idx->int;
        }

        if (!$this->exist($idx)) {
            throw new \OutOfRangeException('Given '. $idx .' index does not exist!');
        }

        return $this->value[$idx];
    }

    /**
     * Gets item having given index. Shorthand for `take` method.
     *
     * @param  mixed $idx N or integer
     * @access public
     * @return mixed
     */
    public function get($idx)
    {
        return $this->take($idx);
    }



    /**
     * Alias of take() method 
     * 
     * @param mixed $idx N or integer
     * @access public
     * @return mixed
     */
    public function at($idx)
    {
        return $this->take($idx);
    }

    public function exist($idx)
    {
        self::mustBeInteger($idx);

        if ($idx instanceof N) {
            $idx = $idx->int;
        }

        return array_key_exists($idx, $this->value);
    }
    
    protected function _isLastButOne()
    {
        if ($this->count < 2) {
            return false;
        }

        return ($this->count - 2) == $this->position->int;
    }

    protected function _isLast()
    {
        return $this->_length()->p->eq($this->position);
    }

    protected function _isFirst()
    {
        return $this->position->zero;
    }

    protected function _lastButOne()
    {
        if (count($this) <= 2) {
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

    public function push($thing)
    {
        return $this->add($thing);
    }

    protected function _unique()
    {
        return new self(array_unique($this->value, SORT_REGULAR));
    }

    public function delete($idx)
    {
        self::mustBeInteger($idx);

        if ($idx instanceof N) {
            $idx = $idx->int;
        }

        if (!$this->exist($idx)) {
            throw new \OutOfRangeException('Given '. $idx .' index does not exist!');
        }

        unset($this->value[$idx]);
        $this->count--;

        return $this;
    }

    public function remove($idx)
    {
        return $this->delete($idx);
    }

    public function rm($idx)
    {
        return $this->delete($idx);
    }

    public function del($idx)
    {
        return $this->delete($idx);
    }

    protected function _shift()
    {
        if ($this->count() == 0) {
            throw new \RuntimeException('Cannot take element from void collection!');
        }

        $this->count--;

        return array_shift($this->value);
    }

    protected function _pop()
    {
        if ($this->count() == 0) {
            throw new \RuntimeException('Cannot take element from void collection!');
        }

        $this->count--;

        return array_pop($this->value);
    }

    public function replace($idx, $thing)
    {
        self::mustBeInteger($idx, 'Index');

        if ($idx instanceof N) {
            $idx = $idx->int;
        }

        if (!$this->exist($idx)) {
            throw new \OutOfRangeException('Given '. $idx .' index does not exist!');
        }

        $this->value[$idx] = $thing;

        return $this;
    }

    public function implode($sep = '')
    {
        self::mustBeString($sep, 'Separator');

        $arr = $this->value;

        foreach ($this->value as $idx => $item) {
            if(
                is_scalar($item)
                ||
                $item instanceof A
                ||
                (is_object($item) && method_exists($item, '__toString'))
            )
            {
                if ($item instanceof A) {
                    $arr[$idx] = $item->join($sep);
                } else {
                    continue;
                }
            } else {
                throw new \RuntimeException('Cannot convert this item to string');
            }
        }

        return new S(implode($sep, $arr));
    }

    public function join($sep = '')
    {
        return $this->implode($sep);
    }

    protected function _maxOrMin($type = 'max')
    {
        $arr = array();

        foreach ($this->value as $v) {
            if (is_numeric($v) || $v instanceof N) {
                //is_numeric can be a string, so cast to double
                $arr[] = is_object($v) ? $v->value : (double) $v;
            }
        }

        if (count($arr) == 0) {
            return null;
        }

        return new N($type($arr));
    }

    protected function _array()
    {
        $arr = array_values($this->value);

        $cnt = count($arr);

        for ($i = 0; $i < $cnt; $i++) {
            $v = $arr[$i];

            if ($v instanceof A || $v instanceof H) {
                $arr[$i] = $v->array;
            }
        }

        return $arr;
    }

    protected function _arr()
    {
        return $this->_array();
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
        self::mustBeInteger($size, 'Size');

        if ($size instanceof N) {
            $size = $size->int;
        }

        return new self(array_pad($this->value, $size, $value));
    }

    public function find($what)
    {
        self::mustBeString($what, 'Find expression');

        $a = new self();

        $what = strtolower(trim($what));

        foreach ($this->value as $k => $v) {
            $k = new N($k);

            if (in_array($what, array('odd', 'even'))) {
                if ($k->$what) {
                    $a->add($v);
                }
            } elseif ($k->test($what)) {
                if (preg_match('/-[0-9]+$/', $what)) {
                    throw new \InvalidArgumentException('Cannot test against negative integer, because their are not negative index.');
                }
                $a->add($v);
            }
        }

        return $a;
    }

    public function map($func)
    {
        //TODO check callable type
        return new self(array_map($func, $this->value));
    }

    public function walk($func, $other = null)
    {
        //TODO check callable type
        $arr = $this->value;

        array_walk($arr, $func, $other);

        return new self($arr);
    }

    public function filter($func)
    {
        //TODO check callable type
        return new self(array_filter($this->value, $func));
    }

    public function random($n = 1)
    {
        self::mustBeInteger($n, 'Number of random items');

        if ($n instanceof N) {
            $n = $n->int;
        }

        if (!is_numeric($n) || $n < 1) {
            throw new \InvalidArgumentException('Random items amount must be an integer greater than or equal one.');
        }

        if ($n > $this->count()) {
            throw new \RuntimeException('Cannot take more random elements than amount contained into the collection.');
        }

        $mix = array_rand($this->value, $n);

        if (is_integer($mix)) {
            return $this->value[$mix];
        }

        $out = new self();

        foreach ($mix as $idx) {
            $out->add($this->value[$idx]);
        }

        return $out;
    }

    public function diff($arr)
    {
        //TODO check types
        if ($arr instanceof A) {
            $arr = $arr->array;
        }

        if ($arr instanceof H) {
            $arr = $arr->array;
        }

        return new self(array_values(array_diff($this->value, $arr)));
    }

    public function inter($arr)
    {
        //TODO check types
        if ($arr instanceof A) {
            $arr = $arr->array;
        }

        if ($arr instanceof H) {
            $arr = $arr->array;
        }

        return new self(array_values(array_intersect($this->value, $arr)));
    }

    public function merge($arr)
    {
        //TODO check types
        if ($arr instanceof A) {
            $arr = $arr->array;
        }

        if ($arr instanceof H) {
            $arr = $arr->array;
        }

        return new self(array_values(array_merge($this->value, $arr)));
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

        $arr = array_chunk($this->value, $size);

        $cnt = count($arr);

        for ($i = 0; $i < $cnt; $i++) {
            $v = $arr[$i];

            if (is_array($v)) {
                $arr[$i] = new self($v);
            }
        }

        return new self($arr);
    }

    public function slice($offset, $length = null)
    {
        self::mustBeInteger($offset);
        
        if(!is_null($length)){
            self::mustBeInteger($length);
        }

        if ($offset instanceof N) {
            $offset = $offset->int;
        }

        if ($length instanceof N) {
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
     * @param  mixed $foo The element to find
     * @access public
     * @return mixed
     */
    public function search($foo)
    {

        if (in_array($foo, $this->value)) {
            return new N(array_search($foo, $this->value, true));
        } else {
            return null;
        }
    }


    public function hasRange($arr)
    {
        if(is_array($arr)){
            if(empty($arr)){
                throw new \RuntimeException(
                    'Cannot used empty range to detect it into collection!'
                );
            }
        } elseif ($arr instanceof A) {
            $arr = $arr->array;
        } else {
            throw new \InvalidArgumentException(
                'Range to detected must be array or A object!'
            );
        }

        if(count($arr) > count($this->value)){
            return false;
        }

        $arr_idx = array();

        foreach($this->value as $k => $v){
            if($v === $arr[0]){
                $arr_idx[] = $k;
            }
        }

        if(count($arr_idx) == 0){
            return false;
        } else {
            foreach($arr_idx as $idx){
                $j = 1;
                $cnt = (count($arr) + $idx);
                for($i = $idx + 1; $i < $cnt; $i++){
                    if(!array_key_exists($i, $this->value)){
                        return false;
                    }
                    
                    if($this->value[$i] !== $arr[$j]){
                        return false;
                    }

                    $j++;
                }

                return true;
            }
        }

        return false;
    }

    public function __toString()
    {
        return (string) $this->count;
    }
}

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
 * Enhanced array.
 *
 * @property-read $key_X Gets content at key X
 * @property-read $index_X Gets content at key X
 * @property-read $array Gets content as primitive array
 * @property-read $index Gets current index
 * @property-read $length Number of elements included into the collection
 * @property-read $is_last Tests if it is the last element (while context)
 * @property-read $is_first Tests if it is the first element (while context)
 * @property-read $is_last_but_one Tests if it is the last but one element 
 * (while context)
 * @property-read $last Gets last element
 * @property-read $first Gets the first element
 * @property-read $last_but_one Gets the last but one element
 * @property-read $shift Takes the first element and remove it from the collection
 * @property-read $pop Takes the last element and remove it from the collection
 * @property-read $random Gets randomly one element
 * @property-read $shuffle Gets new collection with the same content as current 
 * one, but into shuffle order.
 * @property-read $join Concatenate all element into a string if each element 
 * has toString ethod or are primitive type.
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
    protected $position = 0;

    public function __get($name)
    {

        if ($name === 'index') {
            return $this->key();
        } elseif ($name === 'random') {
            return $this->random(1);
        } elseif ($name === 'last_but_one') {
            return $this->_lastButOne();
        } elseif ($name === 'implode' || $name === 'join') {
            return $this->implode();
        } elseif (
            $name === 'current' 
            ||
            $name === 'key'
            ||
            $name === 'next'
            ||
            $name === 'rewind'
            ||
            $name === 'valid'
        ) {
            return $this->$name();
        } elseif (in_array($name, array('min', 'max'))) {
            return $this->_maxOrMin($name);
        } elseif (
            $name === 'array' 
            ||
            $name === 'arr' 
            ||
            $name === 'length'
            ||
            $name === 'last'
            ||
            $name === 'first'
            ||
            $name === 'shift'
            ||
            $name === 'pop'
            ||
            $name === 'shuffle'
            ||
            $name === 'reverse' 
            ||
            $name === 'sort'
            ||
            $name === 'unique'
            ||
            $name === 'uniq'
            ||
            $name === 'flatten'
            ||
            $name === 'flat'
        ) {
            $str_method = '_' . $name;

            return $this->$str_method();
        } elseif(
            $name === 'is_first'
            ||
            $name === 'is_last'
            ||
            $name === 'is_last_but_one'
        ){
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
                throw new \InvalidArgumentException(
                    'Constructor must have array, Class A or Class H instance.'
                );
            }
        }

        $this->value = $arr;
        $this->count = count($arr);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->value);
    }

    public function current()
    {
        return $this->value[$this->position];
    }
    public function key()
    {
        return new N($this->position);
    }
    public function next()
    {
        $this->position++;

        return $this;
    }
    public function rewind()
    {
        $this->position = 0;

        return $this;
    }

    public function valid()
    {
        return isset($this->value[$this->position]);
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
     * @return mixed
     */
    public function take($idx)
    {
        self::mustBeInteger($idx, 'Index');

        if ($idx instanceof N) {
            $idx = $idx->int;
        }

        if (!$this->exist($idx)) {
            throw new \OutOfRangeException(
                'Given '. $idx .' index does not exist!'
            );
        }

        return $this->value[$idx];
    }

    /**
     * Gets item having given index. Shorthand for `take` method.
     *
     * @param  mixed $idx N or integer
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
     * @return mixed
     */
    public function at($idx)
    {
        return $this->take($idx);
    }

    /**
     * Tests whether given index exists. 
     * 
     * This checks if given index exists into the collection.
     *
     *     $a = new A();
     *     $a->add('foo');
     *     $a->add('bar');
     *     $a->add('thing');
     *     $a->exist(6); // false
     *     $a->exist(2); // true
     *
     * @param mixed $idx Value of index, as integer-like
     * @return boolean
     * @throws \InvalidArgumentException If given index is not integer-like value.
     */
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
            throw new \RuntimeException(
                'This collection is too small to have last but one value.'
            );
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

    /**
     * Removes any duplicate entries. 
     * 
     * This method removes all duplicate entries, so resulting collection has 
     * only unique items.
     *
     * Example:
     *
     *     $a = new A();
     *     $a->add('foo');
     *     $a->add('bar');
     *     $a->add('foo');
     *     $a->add('thing');
     *     var_dump($a->unique->array); // has: 'foo', 'bar', 'thing'
     *
     * @see A::_uniq() An alias
     * @see A::$unique The magic getter way
     * @return A
     */
    protected function _unique()
    {
        return new self(array_unique($this->value, SORT_REGULAR));
    }

    /**
     * Removes any duplicate entries (Alias). 
     * 
     * @see A::_unique() Original method
     * @see A::$uniq The magic getter way
     * @return A
     */
    protected function _uniq()
    {
        return $this->_unique();
    }

    public function delete($idx)
    {
        self::mustBeInteger($idx);

        if ($idx instanceof N) {
            $idx = $idx->int;
        }

        if (!$this->exist($idx)) {
            throw new \OutOfRangeException(
                'Given '. $idx .' index does not exist!'
            );
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
            throw new \RuntimeException(
                'Cannot take element from void collection!'
            );
        }

        $this->count--;

        return array_shift($this->value);
    }

    protected function _pop()
    {
        if ($this->count() == 0) {
            throw new \RuntimeException(
                'Cannot take element from void collection!'
            );
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
            throw new \OutOfRangeException(
                'Given '. $idx .' index does not exist!'
            );
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
                throw new \RuntimeException(
                    'Cannot convert this item to string'
                );
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

    /**
     * Converts current collection as a simple array, recursively. 
     * 
     * This method converts all current collection as a simple array primitive 
     * type, and all sub-collectionis included into current one are also 
     * converted to array: this is recursive.
     *
     * Example:
     *
     *     $a = new A();
     *     $a->add('foo')->add('bar');
     *     $a->add(new A(array('other', 'thing'))) // works with H too
     *     $a->array; // array('foo', 'bar', array('other', 'thing'))
     *
     * @see A::_arr() An alias
     * @see A::$array Magic getter way
     * @return array
     */
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

    /**
     * Converts current collection as a simple array, recursively (Alias). 
     * 
     * @see A::_array() Original method
     * @see A::$arr Magic getter way
     * @return array
     */
    protected function _arr()
    {
        return $this->_array();
    }

    /**
     * Returns a shuffled copy of the current collection. 
     * 
     * This runtime part of magic getter `A::$shuffle` randomize collection’s 
     * content to a new collection object.
     *
     * Example:
     *
     *     $a = new A(array('one', 'two', 'three'));
     *     echo $a->shuffle->join(', '); // 'three, one, two' or other order…
     * @see A::$shuffle Magic getter way.
     * @return A
     */
    protected function _shuffle()
    {
        $arr = $this->value;

        shuffle($arr);

        return new self($arr);
    }

    /**
     * Reverses items’ order as new collection.
     *
     * Returns new collection having current items’ order reversed.
     *
     * Example:
     *
     *     $a = new A();
     *     $a->add('one')->add('two')->add('three');
     *     var_dump($a->reverse->array); // 'three', 'two', 'one'
     * 
     * This is runtime par of magic getter.
     *
     * @see A::$reverse Magic getter way
     * @return A
     */
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
                    throw new \InvalidArgumentException(
                        'Cannot test against negative integer, because their'
                        .' are not negative index.'
                    );
                }
                $a->add($v);
            }
        }

        return $a;
    }

    public function map($func)
    {
        self::mustBeCallable($func);

        return new self(array_map($func, $this->value));
    }

    public function walk($func, $other = null)
    {
        self::mustBeCallable($func);

        $arr = $this->value;

        array_walk($arr, $func, $other);

        return new self($arr);
    }

    public function filter($func)
    {
        self::mustBeCallable($func);

        return new self(array_filter($this->value, $func));
    }

    public function random($n = 1)
    {
        self::mustBeInteger($n, 'Number of random items');

        if ($n instanceof N) {
            $n = $n->int;
        }

        if (!is_numeric($n) || $n < 1) {
            throw new \InvalidArgumentException(
                'Random items amount must be an integer greater '
                .'than or equal one.'
            );
        }

        if ($n > $this->count()) {
            throw new \RuntimeException(
                'Cannot take more random elements than amount '
                .'contained into the collection.'
            );
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
        self::mustBeArrayOrHash($arr);

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
        self::mustBeArrayOrHash($arr);

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
        self::mustBeArrayOrHash($arr);

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
            throw new \InvalidArgumentException(
                'Chunk cannot have null size, please use number equal or '
                .'greater than one.'
            );
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
     * This will return the first index found for the given element if there 
     * are several identical.
     *
     * If no element found, then returns null.
     *
     * If element is found, then N object is returned.
     *
     * @param  mixed $foo The element to find
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

    /**
     * Flatten the current collection.
     *
     * If collection contains other arrays or A objects or H objects, then this 
     * method will take all this content to create unqiue collection having one 
     * dimension. 
     *
     * Example:
     *
     *     $a = new A(array('one', array('two', 'three', new A(array('four', 'five')))));
     *     var_dump($a->flatten->array); // has: 'one', 'two', 'three', 'four', 'five'
     * 
     * @see A::$flatten Magic getter way
     * @see A::_flat() Alias
     * @return A
     */
    protected function _flatten()
    {
        $arr = array();

        foreach ($this->value as $idx => $item) {
            if(is_array($item)){
                $item = new A($item);
            } elseif($item instanceof H){
                $item = $item->to_a;
            }

            if ($item instanceof A) {
                $arr_prov = $item->flatten->array;
                foreach($arr_prov as $v){
                    $arr[] = $v;
                }
            } else {
                $arr[] = $item;
            }
        }

        return new self($arr);
    }

    /**
     * Flatten the current collection (Alias).
     * 
     * @see A::_flatten() Original method
     * @see A::$flat Alias
     * @return A
     */
    protected function _flat()
    {
        return $this->_flatten();
    }


    public function zip()
    {
        $args = func_get_args();
        $int_max = 0;

        foreach($args as $item){
            self::mustBeArrayOrHash($item);

            if(count($item) > $int_max){
                $int_max = count($item);
            }
        }

        $arr = array();

        for($i = 0; $i < $int_max; $i++){
            $arr_prov = array();

            foreach($args as $item){
                if(is_object($item)){
                    $item = array_values($item->array);
                }

                if(array_key_exists($i, $item)){
                    $arr_prov[] = $item[$i];
                } else {
                    $arr_prov[] = null;
                }
            }

            $arr[] = new A($arr_prov);
        }

        return new A($arr);
    }

    public function __toString()
    {
        return (string) $this->count;
    }
}

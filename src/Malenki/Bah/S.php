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
 * String class.
 *
 * @package Malenki\Bah
 * @property-read Malenki\Bah\A $chars A collection of Malenki\Bah\C objects
 * @property-read Malenki\Bah\A $bytes A collection of Malenki\bah\N objects
 * @property-read Malenki\Bah\N $length The strings length
 * @license MIT
 */
class S extends O implements \Countable
{
    /**
     * Stocks characters when a call is done for that.
     *
     * @var Malenki\Bah\A
     */
    protected $chars = null;

    /**
     * Stocks string's bytes.
     *
     * @var Malenki\Bah\A
     */
    protected $bytes = null;

    /**
     * Stocks string's length.
     *
     * @var Malenki\Bah\N
     */
    protected $length = null;

    protected function _chars()
    {
        if (is_null($this->chars)) {
            $a = new A();
            $i = new N(0);

            while ($i->less($this->_length())) {
                $a->add(new C($this->sub($i->value)->value));
                $i->incr;
            }

            $this->chars = $a;
        }

        return $this->chars;
    }

    protected function _bytes()
    {
        $a = new A();

        $this->_chars();

        while ($this->chars->valid()) {
            //$bytes = $this->chars->current()->bytes;

            while ($this->chars->current()->bytes->valid()) {
                $a->add($this->chars->current()->bytes->current());
                $this->chars->current()->bytes->next();
            }

            $this->chars->next();
        }
        $this->bytes = $a;

        return $this->bytes;
    }

    protected function _length()
    {
        $this->length = new N(mb_strlen($this, C::ENCODING));

        return $this->length;
    }

    public static function concat()
    {
        $args = func_get_args();

        $str_out = '';

        foreach ($args as $s) {
            if (is_object($s) && method_exists($s, '__toString')) {
                $str_out .= $s;
            } elseif (is_string($s)) {
                $str_out .= $s;
            } else {
                throw new \Exception('All args must be string or Malenki\Bah\S instance!');
            }
        }

        return new S($str_out);
    }

    public function __construct($str = '')
    {
        $this->value = $str;
    }

    /**
     * @params string $name
     */
    public function __get($name)
    {
        if ($name == 'length') {
            if (is_null($this->length)) {
                $this->_length();
            }

            return $this->length;
        }

        if ($name == 'chars') {
            return $this->_chars();
        }

        if ($name == 'bytes') {
            if (is_null($this->bytes)) {
                $this->_bytes();
            }

            return $this->bytes;
        }

        if (in_array($name, array('n', 'r'))) {
            return $this->$name();
        }

        if (in_array($name, array('center', 'wrap'))) {
            return $this->$name();
        }

        if (in_array($name, array('void', 'empty'))) {
            return $this->isVoid();
        }

        if (in_array($name, array('strip', 'lstrip', 'rstrip'))) {
            return $this->$name();
        }


        if ($name == 'chunk') {
            return $this->chunk();
        }

        if ($name == 'underscore' || $name == '_') {
            return $this->_underscore();
        }


        if ($name == 'ucw') {
            return $this->_upperCaseWords();
        }

        if ($name == 'ucf') {
            return $this->_upperCaseFirst();
        }

        if (in_array($name, array('string', 'title', 'upper', 'lower', 'n', 'r', 'first', 'last', 'a', 'trans', 'rtl', 'ltr', 'md5', 'sha1'))) {
            $str_method = '_' . $name;

            return $this->$str_method();
        }

        if(in_array($name, array('is_ltr', 'left_to_right', 'is_left_to_right'))){
            return $this->_ltr();
        }
        
        if(in_array($name, array('is_rtl', 'right_to_left', 'is_right_to_left'))){
            return $this->_rtl();
        }
        
        if(in_array($name, array('has_mixed_direction', 'mixed_direction', 'is_rtl_and_ltr', 'rtl_and_ltr', 'is_ltr_and_rtl', 'ltr_and_rtl'))){
            return $this->_hasMixedDirection();
        }
        
        if(in_array($name, array('lower_camel_case', 'lcc'))){
            return $this->camelCase();
        }
        
        
        if(in_array($name, array('upper_camel_case', 'ucc'))){
            return $this->camelCase(true);
        }
        
        if($name == 'swap_case' || $name == 'swapcase' || $name == 'swap'){
            return $this->_swapCase();
        }

        if(in_array($name, array('left', 'left_justify', 'left_align', 'ljust'))){
            return $this->left();
        }

        if(in_array($name, array('right', 'right_justify', 'right_align', 'rjust'))){
            return $this->right();
        }

        if($name == 'justify' || $name == 'just'){
            return $this->justify();
        }
    }

    protected function _string()
    {
        return (string) $this->value;
    }

    protected function _a()
    {
        $a = new A();
        $i = new N(0);

        while ($i->less($this->_length())) {
            $a->add($this->sub($i->value));
            $i->incr;
        }

        return  $a;
    }

    protected function _trans()
    {
        if (!extension_loaded('intl')) {
            throw new \RuntimeException('Missing Intl extension. This is required to use ' . __CLASS__);
        }

        $str = transliterator_transliterate(
            "Any-Latin; NFD; [:Nonspacing Mark:] Remove; NFC;",
            $this->value
        );

        return new self($str);
    }

    protected function _swapCase()
    {
        $coll_upper = $this->_upper()->chunk();
        $coll_original = $this->chunk();

        $out = '';

        while($coll_original->valid()){
            $c_upper = $coll_upper->take($coll_original->key);
            $c_orig = $coll_original->current();

            if($c_upper->string === $c_orig->string){
                $out .= $c_orig->lower;
            } else {
                $out .= $c_upper;
            }

            $coll_original->next();
        }

        return new S($out);
    }

    public function strip($str = null)
    {
        if(is_array($str)){
            $str = new A($str);
        }

        if($str instanceof A) {
            return new S(trim($this->value, $str->join));
        }
    
        if(is_string($str) || (is_object($str) && method_exists($str, '__toString'))){
            return new S(trim($this->value, $str));
        }

    
        return new S(trim($this->value));
    }


    public function lstrip($str = null)
    {
        if(is_array($str)){
            $str = new A($str);
        }


        if($str instanceof A) {
            return new S(ltrim($this->value, $str->join));
        }
        
        if(is_string($str) || (is_object($str) && method_exists($str, '__toString'))){
            return new S(ltrim($this->value, $str));
        }

    
        return new S(ltrim($this->value));
    }

    public function rstrip($str = null)
    {
        if(is_array($str)){
            $str = new A($str);
        }


        if($str instanceof A) {
            return new S(rtrim($this->value, $str->join));
        }
    
        if(is_string($str) || (is_object($str) && method_exists($str, '__toString'))){
            return new S(rtrim($this->value, $str));
        }

    
        return new S(rtrim($this->value));
    }


    public function append($str)
    {
        return static::concat($this, $str);
    }

    public function prepend($str)
    {
        return static::concat($str, $this);
    }

    public function insert($str, $pos)
    {
        if(
            !is_string($str) 
            &&
            !(is_object($str) && method_exists($str, '__toString'))
        ){
            throw new \InvalidArgumentException(
                'String to insert must be string or object having __toString method.'
            );
        }
        if(!is_integer($pos) && !($pos instanceof N)){
            throw new \InvalidArgumentException(
                'To insert a string, position valud must be integer or N instance.'
            );
        }

        if($pos instanceof N){
            $pos = $pos->int;
        }

        if($pos < 0){
            throw new \InvalidArgumentException(
                'Position must be positive or null integer.'
            );
        }

        if($pos > count($this)){
            throw new \InvalidArgumentException(
                'Position must not be greater than length of current string.'
            );
        }

        if($pos == count($this)){
            return $this->append($str);
        }

        if($pos == 0){
            return $this->prepend($str);
        }

        $str1 = $this->sub(0, $pos);
        $str2 = $this->sub($pos, count($this) - 1);

        
        return static::concat($str1, $str, $str2);
    }

    public function _underscore()
    {
        return $this->strip()
            ->lower
            ->replace('/[\s]+/', '_')
            ->replace('/[^\p{Ll}\p{Lu}0-9_]/u', '')
            ->replace('/_+/', '_')
            ->strip('_')
            ;
    }


    public function camelCase($is_upper = false)
    {
        $func = function(&$v, $k, $is_upper){
            $c = $v->chunk;
            if($is_upper || $k != 0) {
                $first = $c->key_0->upper;
            } else {
                $first = $c->key_0->lower;
            }

            $c->replace(0, $first);

            $v = $c->join;
        };

        return $this->strip()
            ->replace('/[\s]+/', '_')
            ->replace('/[^\p{Ll}\p{Lu}0-9_]/u', '')
            ->replace('/_+/', '_')
            ->strip('_')
            ->split('/_/')
            ->walk($func, $is_upper)->join
            ;
    }

    public function lowerCamelCase()
    {
        return $this->camelCase();
    }

    public function upperCamelCase()
    {
        return $this->camelCase(true);
    }

    /**
     * Get substring from the original string.
     *
     * By default, returns the first character as a substring.
     *
     * @param mixed $offset Where to start the substring, 0 by default, as N or integer
     * @param mixed $limit  Size of the substring, 1 by default, as N or integer
     *
     * @return S
     */
    public function sub($offset = 0, $limit = 1)
    {
        if($offset instanceof N) $offset = $offset->int;
        if($limit instanceof N) $limit = $limit->int;

        if ($offset < 0) {
            throw new \InvalidArgumentException('Offset must be a null or positive integer');
        }

        if ($limit < 1) {
            throw new \InvalidArgumentException('Limit must be an intger equal to or greater than one.');
        }

        return new S(mb_substr($this->value, $offset, $limit, C::ENCODING));
    }

    protected function _first()
    {
        return $this->sub();
    }

    protected function _last()
    {
        return $this->sub($this->_length()->value - 1, 1);
    }

    /**
     * Checks that current string starts with the given string or not
     *
     * @param  mixed   $str primitive string or object havin __toString method
     * @access public
     * @return boolean
     */
    public function startsWith($str)
    {
        if(
            is_string($str)
            ||
            (is_object($str) && method_exists($str, '__toString'))
        ) {
            $str = preg_quote($str, '/');

            return (boolean) preg_match("/^$str/", $this->value);
        } else {
            throw new \InvalidArgumentException(
                'Searched starting string must be string or object having __toString method'
            );
        }
    }

    /**
     * Checks that current string ends with the given string or not
     *
     * @param  mixed   $str primitive string or object havin __toString method
     * @access public
     * @return boolean
     */
    public function endsWith($str)
    {
        if(
            is_string($str)
            ||
            (is_object($str) && method_exists($str, '__toString'))
        ) {
            $str = preg_quote($str, '/');

            return (boolean) preg_match("/$str\$/", $this->value);
        } else {
            throw new \InvalidArgumentException(
                'Searched ending string must be string or object having __toString method'
            );
        }
    }

    /**
     * Check whether current string match the given regular expression.
     *
     * @param  mixed   $expr primitive string or object having __toString method
     * @access public
     * @return boolean
     */
    public function match($expr)
    {
        if(
            is_string($expr)
            ||
            (is_object($expr) && method_exists($expr, '__toString'))
        ) {
            return (boolean) preg_match($expr, $this->value);
        } else {
            throw new \InvalidArgumentException('Expression must be string or object having __toString method');
        }
    }

    /**
     * Shorthand for match method
     *
     * @param  mixed   $expr primitive string or object having __toString method
     * @access public
     * @return boolean
     */
    public function regexp($expr)
    {
        return $this->match($expr);
    }

    /**
     * Shorthand for match method
     *
     * @param  mixed   $expr primitive string or object having __toString method
     * @access public
     * @return boolean
     */
    public function re($expr)
    {
        return $this->match($expr);
    }

    public function test($str)
    {
        if(
            is_scalar($str)
            ||
            (is_object($str) && method_exists($str, '__toString'))
        )
        {
            return (boolean) preg_match($this->value, $str);
        }

        return false;
    }

    protected function _upperCaseWords()
    {
        $str_prov = mb_convert_case(
            mb_strtolower(
                mb_strtolower($this->value, 'UTF-8'),
                'UTF-8'
            ),
            MB_CASE_TITLE,
            'UTF-8'
        );

        $str_out  = $str_prov;
        $int_length  = mb_strlen($str_prov, 'UTF-8');

        $prev_idx = null;
        $arr_to_change = array();

        for ($i = 0; $i < $int_length; $i++) {
            $letter = mb_substr($str_prov, $i, 1, 'UTF-8');

            if ($letter == "'") {
                $prev_idx = $i;
            }

            if (!is_null($prev_idx) && ($i == $prev_idx + 1)) {
                $arr_to_change[$i] = $letter;
            }
        }

        foreach ($arr_to_change as $idx => $letter) {
            $str_tmp  = mb_substr($str_out, 0, $idx, 'UTF-8'); // On prend ce qu’il y a avant le caractère sans modification
            $str_tmp .= mb_strtoupper($letter, 'UTF-8'); // On met en majuscule la lettre
            $str_tmp .= mb_substr($str_out, $idx + 1, $int_length, 'UTF-8'); // On prend le reste de la chaîne…

            $str_out = $str_tmp;
        }

        return new self($str_out);
    }

    protected function _upperCaseFirst()
    {
        if (!$this->isVoid()) {
            $first_char = $this->_first()->_upper();
            $other_chars = $this->sub(1, $this->length->value);

            return self::concat($first_char, $other_chars);
        }

        return $this;
    }

    /**
     * Get character at the given position.
     *
     * @param mixed $idx The index where the cahracter is, as N or integer.
     *
     * @return C
     */
    public function charAt($idx)
    {
        if ($idx instanceof N) {
            $idx = $idx->int;
        }

        return new C(mb_substr($this->value, $idx, 1, C::ENCODING));
    }



    /**
     * Alias of charAt() method 
     * 
     * @see charAt()
     * @param mixed $idx 
     * @access public
     * @return C
     */
    public function take($idx)
    {
        return $this->charAt($idx);
    }



    /**
     * Alias of charAt() method 
     * 
     * @see charAt()
     * @param mixed $idx 
     * @access public
     * @return C
     */
    public function at($idx)
    {
        return $this->charAt($idx);
    }


    /**
     * Implements Countable interface.
     *
     * @see \Countable
     */
    public function count()
    {
        return $this->_length()->int;
    }

    public function isVoid()
    {
        return $this->_length()->zero;
    }

    /**
     * Returns new string object converted to uppercase.
     *
     * @return Malenki\Bah\S
     */
    protected function _upper()
    {
        return new self(mb_convert_case($this, MB_CASE_UPPER, C::ENCODING));
    }

    /**
     * Returns new string object converted to lowercase.
     *
     * @return Malenki\Bah\S
     */
    protected function _lower()
    {
        return new self(mb_convert_case($this, MB_CASE_LOWER, C::ENCODING));
    }

    /**
     * Returns new String object with capital letters
     *
     * @return Malenki\Bah\S
     */
    protected function _title()
    {
        return new self(mb_convert_case($this, MB_CASE_TITLE, C::ENCODING));
    }

    /**
     * Returns current string as an new string object repeated N times.
     *
     * @param  mixed         $n N or integer
     * @return Malenki\Bah\S
     */
    public function times($n = 1)
    {
        if($n instanceof N) $n = $n->int;

        return new self(str_repeat($this, $n));
    }

    /**
     * Wrap the string to have given width.
     *
     * @param  integer $width Width the text must have
     * @param  mixed   $cut   Optional string to put at each linebreak, as string or S
     * @access public
     * @return S
     */
    public function wrap($width = 79, $cut = PHP_EOL)
    {

        if(is_object($cut)){
            if(!method_exists($cut, '__toString')){
                throw new \InvalidArgumentException(
                    'Cut as object must have __toString method.'
                );
            }

            $cut = "$cut";
        } elseif(!is_string($cut)){
            throw new \InvalidArgumentException(
                'Cut must be a string or object having __toString method'
            );
        }

        $arr_lines = array();

        if (strlen($this->value) === mb_strlen($this->value, 'UTF-8')) {
            $arr_lines = explode(
                $cut,
                wordwrap(
                    $this->value,
                    $width,
                    $cut
                )
            );
        } else {
            //Thanks to: http://www.php.net/manual/fr/function.wordwrap.php#104811
            $str_prov = $this->value;
            $int_length = mb_strlen($str_prov, 'UTF-8');
            $int_width = $width;

            if ($int_length <= $int_width) {
                return new self($str_prov);
            }

            $int_last_space = 0;
            $i = 0;

            do {
                if (mb_substr($str_prov, $i, 1, 'UTF-8') == ' ') {
                    $int_last_space = $i;
                }

                if ($i > $int_width) {
                    if ($int_last_space == 0) {
                        $int_last_space = $int_width;
                    }

                    $arr_lines[] = trim(
                        mb_substr(
                            $str_prov,
                            0,
                            $int_last_space,
                            'UTF-8')
                        );

                    $str_prov = mb_substr(
                        $str_prov,
                        $int_last_space,
                        $int_length,
                        'UTF-8'
                    );

                    $int_length = mb_strlen($str_prov, 'UTF-8');

                    $i = 0;
                }

                $i++;
            } while ($i < $int_length);

            $arr_lines[] = trim($str_prov);
        }

        return new self(implode($cut, $arr_lines));
    }

    /**
     * Adds margin to the text. By default left, but right and alinea are possible too.
     *
     * @throw \InvalidArgumentException If Margin left and/or right are negative
     * @throw \InvalidArgumentException If alinea is greater than margin left
     * @param  mixed $left   Margin left (N or integer)
     * @param  mixed $right  Margin right, optional (N or integer)
     * @param  mixed $alinea First line, optional (N or integer)
     * @access public
     * @return S
     */
    public function margin($left = 5, $right = 0, $alinea = 0)
    {
        $int_left = $left;
        $int_right = $right;
        $int_alinea = $alinea;

        if($left instanceof N) $int_left = $left->int;
        if($right instanceof N) $int_right = $right->int;
        if($alinea instanceof N) $int_alinea = $alinea->int;

        if ($int_left < 0 || $int_right < 0) {
            throw new \InvalidArgumentException('Margins must be null or positive numbers!');
        }

        if (abs($int_alinea) > $int_left) {
            throw new \InvalidArgumentException('Alinea must be equal or less than margin left');
        }

        $arr = explode("\n", $this->value);

        foreach ($arr as $k => $v) {
            $int_margin_left = $int_left;
            $int_margin_right = $int_right;

            if ($k == 0) {
                $int_margin_left = $int_left + $int_alinea;

                if ($int_margin_left < 0) {
                    $int_margin_left = 0;
                }
            }

            $arr[$k] = str_repeat(' ', $int_margin_left);
            $arr[$k] .= $v . str_repeat(' ', $int_margin_right);
        }

        return new self(implode("\n", $arr));
    }




    public function center($width = 79, $cut = PHP_EOL)
    {
        if(!($width instanceof N) && !is_integer($width)){
            throw new \InvalidArgumentException('Width must be N instance or integer.');
        }


        if(is_object($cut)){
            if(!method_exists($cut, '__toString')){
                throw new \InvalidArgumentException(
                    'Cut as object must have __toString method.'
                );
            }

            $cut = "$cut";
        } elseif(!is_string($cut)){
            throw new \InvalidArgumentException(
                'Cut must be a string or object having __toString method'
            );
        }

        if(is_object($width)){
            $width = $width->int;
        }

        $a = $this->strip()->wrap($width, $cut)->split('/'.$cut.'/u');

        $s = '';

        while($a->valid()){
            $diff = new N(($width - count($a->current)) / 2);

            if($diff->decimal->zero){
                $left = $right = $diff->int;
            } else {
                if($a->index->odd){
                    $left = $diff->ceil;
                    $right = $diff->floor;
                } else {
                    $left = $diff->floor;
                    $right = $diff->ceil;
                }
            }
            $s .= $a->current->margin($left, $right);

            if(!$a->is_last){
                $s .= $cut;
            }
            $a->next();
        }

        return new S($s);
    }


    protected function _leftOrRightJustify($type = 'left', $width = 79, $cut = PHP_EOL)
    {
        if(!($width instanceof N) && !is_integer($width)){
            throw new \InvalidArgumentException(
                'Width must be N instance or integer.'
            );
        }

        if(is_object($cut)){
            if(!method_exists($cut, '__toString')){
                throw new \InvalidArgumentException(
                    'Cut as object must have __toString method.'
                );
            }

            $cut = "$cut";
        } elseif(!is_string($cut)){
            throw new \InvalidArgumentException(
                'Cut must be a string or object having __toString method'
            );
        }

        if(is_object($width)){
            $width = $width->int;
        }

        $a = $this->strip()->wrap($width, $cut)->split('/'.$cut.'/u');

        $s = '';

        $pad = new N($width - count($a->current));

        while($a->valid()){
            if($type == 'left'){
                $s .= $a->current->margin(0, $pad);
            } else {
                $s .= $a->current->margin($pad);
            }

            if(!$a->is_last){
                $s .= $cut;
            }

            $a->next();
        }

        return new S($s);
    }


    public function left($width = 79, $cut = PHP_EOL)
    {
        return $this->_leftOrRightJustify('left', $width, $cut);
    }

    public function ljust($width = 79, $cut = PHP_EOL)
    {
        return $this->left($width, $cut);
    }


    public function leftAlign($width = 79, $cut = PHP_EOL)
    {
        return $this->left($width, $cut);
    }


    public function leftJustify($width = 79, $cut = PHP_EOL)
    {
        return $this->left($width, $cut);
    }


    public function right($width = 79, $cut = PHP_EOL)
    {
        return $this->_leftOrRightJustify('right', $width, $cut);
    }

    public function rjust($width = 79, $cut = PHP_EOL)
    {
        return $this->right($width, $cut);
    }


    public function rightAlign($width = 79, $cut = PHP_EOL)
    {
        return $this->right($width, $cut);
    }


    public function rightJustify($width = 79, $cut = PHP_EOL)
    {
        return $this->right($width, $cut);
    }
    
    public function justify($width = 79, $last_line = 'left', $cut = PHP_EOL)
    {
        if(!($width instanceof N) && !is_integer($width)){
            throw new \InvalidArgumentException('Width must be N instance or integer.');
        }


        if(is_object($width)){
            $width = $width->int;
        }

        $a = $this->strip()->wrap($width, $cut)->split('/'.$cut.'/u');

        $s = '';
        $sp = new S(' ');

        if(count($a) == 1){
            unset($a);
            return $this->$last_line($width, $cut);
        }

        while($a->valid()){
            if($a->is_last){
                $s .= $a->current->$last_line($width, $cut);
            } else {
                $line = $a->current->strip->replace('/\s+/', ' ');
                $diff = new N($width - count($line));
                $words = $line->split('/\s/u');
                $nb_spaces = count($words) - 1 + $diff->int;

                $div = new N($nb_spaces / (count($words) - 1));
                $div_floor = $div->floor->int;

                $missing = new N((count($words) - 1) * ($div->double - $div_floor));
                $sp_pad = $sp->times($div_floor);

                while($words->valid()){
                    if(!$words->is_last && count($sp_pad)){
                        $s .= $words->current->append($sp_pad);

                        if($missing->test('> 0')){
                            $s .= $sp;
                            $missing->decr;
                        }
                    } else {
                        $s .= $words->current;
                    }
                    $words->next();
                }
                $s .= $cut;
            }
            $a->next();
        }

        return new S($s);
    }

    public function explode($sep)
    {
        if (
            is_string($sep)
            ||
            (is_object($sep) && method_exists($sep, '__toString'))
        ) {
            if (is_object($sep)) {
                $sep = (string) $sep;
            }

            if (strlen($sep) == 0) {
                throw new \InvalidArgumentException(
                    'Separator regexp must be a not null string or S instance.'
                );
            }

            $arr = preg_split($sep, $this->value);

            foreach ($arr as $k => $str) {
                $arr[$k] = new S($str);
            }

            return new A($arr);
        } else {
            throw new \InvalidArgumentException(
                'Separator regexp must be a string or S object'
            );
        }
    }

    public function split($sep)
    {
        return $this->explode($sep);
    }

    public function cut($sep)
    {
        return $this->explode($sep);
    }

    public function chunk($size = 1)
    {
        if(!is_integer($size) && !($size instanceof N)){
            throw new \InvalidArgumentException('Chunk’s size must be integer or N iobject.');
        }

        if($size instanceof N) $size = $size->int;
        
        if($size < 1) {
            throw new \InvalidArgumentException('Chunk’s size must be equal at least to 1.');
        }

        $a = new A();

        for($i = 0; $i < count($this); $i += $size){
            $a->add($this->sub($i, $size));
        }

        return $a;
    }


    public function replace($pattern, $string)
    {
        if (!is_string($pattern) && (is_object($pattern) && !method_exists($pattern, '__toString'))) {
            throw new \InvalidArgumentException('Pattern must be a string or object having __toString() method or S instance');
        }

        if (!is_string($string) && (is_object($string) && !method_exists($string, '__toString'))) {
            throw new \InvalidArgumentException('Replacement string must be a string or object having __toString() method or S instance');
        }

        return new S(preg_replace($pattern, $string, $this->value));
    }
    
    public function change($pattern, $string)
    {
        return $this->replace($pattern, $string);
    }


    protected function _rtl()
    {
        $this->_chars()->rewind();

        while($this->_chars()->valid){
            if($this->_chars()->current()->ltr) return false;
            $this->_chars()->next;
        }

        return true;
    }

    protected function _ltr()
    {
        $this->_chars()->rewind();

        while($this->_chars()->valid){
            if($this->_chars()->current()->rtl) return false;
            $this->_chars()->next;
        }

        return true;
    }

    protected function _hasMixedDirection()
    {
        return !$this->_rtl() && !$this->_ltr();
    }

    protected function _md5()
    {
        return new S(md5($this->value));
    }


    protected function _sha1()
    {
        return new S(sha1($this->value));
    }

    /**
     *
     * @param  boolean       $after
     * @return Malenki\Bah\S
     */
    public function n($after = true)
    {
        if ($after) {
            return new self($this . "\n");
        } else {
            return new self("\n" . $this);
        }
    }

    public function r($after = true)
    {
        if ($after) {
            return new self($this . "\r");
        } else {
            return new self("\r" . $this);
        }
    }
}

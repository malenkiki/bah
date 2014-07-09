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
 * @property-read Malenki\Bah\A $chars A collection of Malenki\Bah\C objects.
 * @property-read Malenki\Bah\A $bytes A collection of Malenki\bah\N objects
 * @property-read Malenki\Bah\N $length The strings length
 * @property-read Malenki\Bah\C $to_c If string as only one character, convert it to \Malenki\Bah\C object.
 * @property-read Malenki\Bah\N $to_n If string contents numeric value, try to export it to \Malenki\Bah\N object.
 * @property-read Malenki\Bah\S $n Return itself + new line '\n'
 * @property-read Malenki\Bah\S $r Return itself + new line '\r'
 * @property-read boolean $is_void Tests whether the current string is void or not.
 * @property-read boolean $void Tests whether the current string is void or not.
 * @property-read boolean $is_empty Tests whether the current string is void or not.
 * @property-read boolean $empty Tests whether the current string is void or not.
 * @property-read \Malenki\Bah\S $strip Remove white spaces surrounding the string. See \Malenki\Bah\S::strip() for more actions.
 * @property-read \Malenki\Bah\S $lstrip Remove white spaces at the left of the string. See \Malenki\Bah\S::lstrip() for more actions.
 * @property-read \Malenki\Bah\S $rstrip Remove white spaces at the right of the string. See \Malenki\Bah\S::rstrip() for more actions.
 * @property-read \Malenki\Bah\S $sub Take first character as string. See \Malenki\Bah\S::sub() for more actions.
 * @property-read \Malenki\Bah\S $chunk Get exploded string as collection of characters. See \Malenki\Bah\S::chunk() for more actions.
 * @property-read \Malenki\Bah\S $delete Remove first character. See \Malenki\Bah\S::delete() for more actions.
 * @property-read \Malenki\Bah\S $remove Remove first character. See \Malenki\Bah\S::delete() for more actions.
 * @property-read \Malenki\Bah\S $del Remove first character. See \Malenki\Bah\S::delete() for more actions.
 * @property-read \Malenki\Bah\S $rm Remove first character. See \Malenki\Bah\S::delete() for more actions.
 *
 * @property-read Malenki\Bah\S $center Center the string on line having width of 79 chars.
 * @property-read Malenki\Bah\S $left Align on left the string on line having width of 79 chars.
 * @property-read Malenki\Bah\S $left_justify Align on left the string on line having width of 79 chars.
 * @property-read Malenki\Bah\S $left_align Align on left the string on line having width of 79 chars.
 * @property-read Malenki\Bah\S $ljust Align on left the string on line having width of 79 chars.
 * @property-read Malenki\Bah\S $right Align on right the string on line having width of 79 chars.
 * @property-read Malenki\Bah\S $right_justify Align on right the string on line having width of 79 chars.
 * @property-read Malenki\Bah\S $right_align Align on right the string on line having width of 79 chars.
 * @property-read Malenki\Bah\S $rjust Align on right the string on line having width of 79 chars.
 * @property-read Malenki\Bah\S $justify Justify the string on line having width of 79 chars.
 * @property-read Malenki\Bah\S $just Justify the string on line having width of 79 chars.
 *
 * @property-read Malenki\Bah\S $wrap Get wrapped version of the string, width of 79 chars
 *
 * @property-read Malenki\Bah\S $underscore Get underscorized version (`some_words_into_sentence`)
 * @property-read Malenki\Bah\S $_ Get underscorized version (`some_words_into_sentence`)
 * @property-read Malenki\Bah\S $dash Get dashrized version (`some-words-into-sentence`)
 * @property-read Malenki\Bah\S $upper_camel_case Get lower camel case version
 * @property-read Malenki\Bah\S $lower_camel_case Get upper camel case version
 * @property-read Malenki\Bah\S $cc Get camel case versioni (lower case for first letter)
 * @property-read Malenki\Bah\S $lcc Get lower camel case version
 * @property-read Malenki\Bah\S $ucc Get upper camel case version
 * @property-read Malenki\Bah\S $lower Get string into lower case
 * @property-read Malenki\Bah\S $upper Get string into upper case
 * @property-read Malenki\Bah\S $first Get first character
 * @property-read Malenki\Bah\S $last Get last character
 * @property-read Malenki\Bah\S $title Get "title" version of the string
 * @property-read Malenki\Bah\S $trans Get translitterated version of the string
 * @property-read Malenki\Bah\S $md5 Get MD5 sum of the string
 * @property-read Malenki\Bah\S $sha1 Get SHA1 sum of the string
 * @property-read Malenki\Bah\S $swap_case Get swapped case version
 * @property-read Malenki\Bah\S $swapcase Get swapped case version
 * @property-read Malenki\Bah\S $swap Get swapped case version
 * @property-read Malenki\Bah\S $squeeze Remove duplicates sequences of characters. See \Malenki\Bah\S::squeeze() methods to have other features
 * @property-read Malenki\Bah\S $ucw Get upper case words
 * @property-read Malenki\Bah\S $ucf Get upper case first
 * @property-read string $string Get current string as primitive PHP type string
 * @property-read string $str Get current string as primitive PHP type string
 * @property-read integer $integer Get current string as primitive PHP type integer, if possible.
 * @property-read integer $int Get current string as primitive PHP type integer, if possible.
 * @property-read float $float Get current string as primitive PHP type float, if possible.
 * @property-read double $double Get current string as primitive PHP type double, if possible.
 * @license MIT
 */
class S extends O implements \Countable, \IteratorAggregate
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

    protected $position = 0;

    /**
     * Concatenates string or object having toString feature together.
     *
     * This can take any number of arguments. You can mix string primitive type
     * and oject having `toString()` method implemented, like `\Malenki\Bah\S`
     * or other classes…
     *
     * The returned object is from `\Malenki\Bah\S` class.
     *
     * @throws \Exception     If one of the arguments is not string or object having `__toString()` method.
     * @return S
     * @todo allow use of array-like as one arg to set collection of elements to concatenate.
     */
    public static function concat()
    {
        $args = func_get_args();

        $str_out = '';

        foreach ($args as $s) {
            if (
                (is_object($s)
                &&
                method_exists($s, '__toString')) || is_string($s)
            ) {
                $str_out .= $s;
            } else {
                throw new \Exception(
                    'All args must be string or Malenki\Bah\S instance!'
                );
            }
        }

        return new S($str_out);
    }

    /**
     * Manage available magic getters.
     *
     * @params string $name
     * @return mixed
     */
    public function __get($name)
    {

        if ($name == 'to_c' || $name == 'to_n') {
            return $this->_to($name);
        } elseif (
            in_array(
                $name,
                array(
                    'is_void',
                    'void',
                    'is_empty',
                    'empty'
                )
            )
        ) {
            return $this->_isVoid();
        } elseif (
            in_array(
                $name,
                array(
                    'strip',
                    'lstrip',
                    'rstrip',
                    'sub',
                    'chunk',
                    'delete',
                    'remove',
                    'del',
                    'rm',
                    'center',
                    'wrap',
                    'n',
                    'r',
                    'squeeze',
                    'current',
                    'key',
                    'next',
                    'rewind',
                    'valid',
                    'left',
                    'right',
                    'justify'
                )
            )
        ) {
            return $this->$name();
        } elseif ($name == '_') {
            return $this->_underscore();
        } elseif ($name == 'ucw') {
            return $this->_upperCaseWords();
        } elseif ($name == 'ucf') {
            return $this->_upperCaseFirst();
        } elseif (
            in_array(
                $name,
                array(
                    'length',
                    'chars',
                    'bytes',
                    'dash',
                    'underscore',
                    'string',
                    'str',
                    'integer',
                    'int',
                    'float',
                    'double',
                    'title',
                    'upper',
                    'lower',
                    'n',
                    'r',
                    'first',
                    'last',
                    'trans',
                    'rtl',
                    'ltr',
                    'md5',
                    'sha1'
                )
            )
        ) {
            $str_method = '_' . $name;

            return $this->$str_method();
        } elseif(
            in_array(
                $name,
                array(
                    'is_ltr',
                    'left_to_right',
                    'is_left_to_right'
                )
            )
        ){
            return $this->_ltr();
        } elseif(
            in_array(
                $name,
                array(
                    'is_rtl',
                    'right_to_left',
                    'is_right_to_left'
                )
            )
        ){
            return $this->_rtl();
        } elseif(
            in_array(
                $name,
                array(
                    'has_mixed_direction',
                    'mixed_direction',
                    'is_rtl_and_ltr',
                    'rtl_and_ltr',
                    'is_ltr_and_rtl',
                    'ltr_and_rtl'
                )
            )
        ){
            return $this->_hasMixedDirection();
        } elseif(
            in_array(
                $name,
                array(
                    'lower_camel_case',
                    'lcc',
                    'cc'
                )
            )
        ){
            return $this->camelCase();
        } elseif(
            in_array(
                $name,
                array(
                    'upper_camel_case',
                    'ucc'
                )
            )
        ){
            return $this->camelCase(true);
        } elseif(
            in_array(
                $name,
                array(
                    'swap_case',
                    'swapcase',
                    'swap'
                )
            )
        ){
            return $this->_swapCase();
        } elseif(
            in_array(
                $name,
                array(
                    'left_justify',
                    'left_align',
                    'ljust'
                )
            )
        ){
            return $this->left();
        } elseif(
            in_array(
                $name,
                array(
                    'right_justify',
                    'right_align',
                    'rjust'
                )
            )
        ){
            return $this->right();
        } elseif ($name == 'just') {
            return $this->justify();
        }

        return parent::__get($name);
    }

    /**
     * Create new S object.
     *
     * @param  string $str
     * @throw \InvalidArgumentException If argument if not valid UTF-8 string.
     * @see \Malenki\Bah\O::mustBeStringOrScalar() To check if string is string or scalar or \Malenki\Bah\S
     * @access public
     * @return void
     */
    public function __construct($str = '')
    {
        self::mustBeStringOrScalar($str);

        if (!mb_check_encoding($str, C::ENCODING)) {
            throw new \InvalidArgumentException(
                '`\Malenki\Bah\S` must be instanciated using valid UTF-8 string!'
            );
        }

        $this->value = (string) $str;
    }

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
            unset($a);
            unset($i);
        }

        return $this->chars;
    }

    protected function _bytes()
    {
        if (is_null($this->bytes)) {
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
            unset($a);
        }

        return $this->bytes;
    }

    protected function _length()
    {
        if (is_null($this->length)) {
            $this->length = new N(mb_strlen($this, C::ENCODING));
        }

        return $this->length;
    }

    protected function _to($name)
    {
        if ($name == 'to_c') {
            if (count($this) != 1) {
                throw new \RuntimeException(
                    'Cannot converting S object having length not equal to one to C object.'
                );
            }

            return new C($this->value);
        }

        if ($name == 'to_n') {
            return new N((double) $this->value);
        }
    }

    protected function _string()
    {
        return (string) $this->value;
    }

    protected function _str()
    {
        return $this->_string();
    }

    protected function _integer()
    {
        if (!is_numeric($this->value)) {
            throw new \RuntimeException('Current string has not numeric content: cannot cast it to integer!');
        }

        return (int) $this->value;
    }

    protected function _int()
    {
        return $this->_integer();
    }

    protected function _float()
    {
        if (!is_numeric($this->value)) {
            throw new \RuntimeException('Current string has not numeric content: cannot cast it to float!');
        }

        return (float) $this->value;
    }

    protected function _double()
    {
        if (!is_numeric($this->value)) {
            throw new \RuntimeException('Current string has not numeric content: cannot cast it to double!');
        }

        return (double) $this->value;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->_chars()->array);
    }

    public function current()
    {
        return $this->charAt($this->position);
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
        return $this->position >= 0
            &&
            $this->position < count($this);
    }

    protected function _trans()
    {
        if (!extension_loaded('intl')) {
            throw new \RuntimeException(
                'Missing Intl extension. This is required to use ' . __CLASS__
            );
        }

        $str = \transliterator_transliterate(
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

        while ($coll_original->valid()) {
            $c_upper = $coll_upper->take($coll_original->key);
            $c_orig = $coll_original->current();

            if ($c_upper->string === $c_orig->string) {
                $out .= $c_orig->lower;
            } else {
                $out .= $c_upper;
            }

            $coll_original->next();
        }

        return new S($out);
    }

    /**
     * Get an excerpt from the string surrounding by some additionnal characters.
     *
     * If searched string is into the string, the returned excerpt will have
     * the searched string surrounded by some additional chars on its left and
     * on its right. But if the string is closed to the beginning or to the
     * end, then, number of character may be less than you want or even be
     * zero. This two last cases are rare, because excerpt method is used into
     * big string.
     *
     * @param  mixed                     $phrase The searched string
     * @param  mixed                     $radius Numbers of characters to display in addition of the searched string, on the left, and on the right.
     * @access public
     * @return S
     * @throws \InvalidArgumentException If searched string is not string or object having `__toString()` method
     * @throws \InvalidArgumentException If radius is not either integer of \Malenki\Bah\N object.
     */
    public function excerpt($phrase, $radius = 100)
    {
        self::mustBeString($phrase, 'String to detect');
        self::mustBeInteger($radius, 'Excerpt’s radius');

        $phrase_len = mb_strlen($phrase, C::ENCODING);

        $pos = mb_strpos(
            $this->_lower()->string,
            mb_strtolower($phrase, C::ENCODING),
            0,
            C::ENCODING
        );

        if ($pos === false) {
            return $this->sub(0, $radius);
        }

        $start_pos = $pos - $radius;

        if ($start_pos < 0) {
            $start_pos = 0;
        }

        $end_pos = $pos + $phrase_len + $radius;

        if ($end_pos >= count($this)) {
            $end_pos = count($this);
        }

        return mb_substr(
            $this->value,
            $start_pos,
            $end_pos - $start_pos,
            C::ENCODING
        );
    }

    /**
     * Removes duplicate sequance of characters.
     *
     * This method changes, for example, `aazzzzerrtyy`  to `azerty`. Without
     * argument, it removes all found duplicates. If argument is provided, then
     * only given characters will be removed.
     *
     * Argument can be a string, an object having `__toString()` method, an
     * array, a \Malenki\Bah\A or \Malenki\Bah\H objects.
     *
     * If a collection is choosen, then each item must has size of one character.
     *
     * If a string-like is provided, then the string will be explode to get
     * each characters independently.
     *
     * @param  mixed $seq Optionnal set of characters to squeeze
     * @access public
     * @return S
     */
    public function squeeze($seq = null)
    {
        $str_pattern = '/(.)\1+/';

        if (!is_null($seq)) {
            if (is_array($seq)) {
                $seq = new A($seq);
                $seq = $seq->join;
            } elseif ($seq instanceof A) {
                $seq = $seq->join;
            } elseif ($seq instanceof H) {
                $seq = $seq->to_a->join;
            } elseif(
                (is_object($seq) && method_exists($seq, '__toString'))
                ||
                is_scalar($seq)
            )
            {
                $seq = (string) $seq;
            } else {
                throw new \InvalidArgumentException(
                    'Bad type provided for squeeze method!'
                );
            }

            $str_pattern = sprintf('/([%s])\1+/', preg_quote($seq, '/'));
        }

        return new S(preg_replace($str_pattern,'$1',$this->value));
    }

    /**
     * Trim the string, by default removing white spaces on the left and on the
     * right.
     *
     * You can give as argument string-like or collection-like to set
     * character(s) to strip.
     *
     * @param  mixed $str Optionnal set of characters to strip.
     * @access public
     * @return S
     */
    public function strip($str = null)
    {
        if (is_array($str)) {
            $str = new A($str);
        }

        if ($str instanceof A) {
            return new S(trim($this->value, $str->join));
        }

        if (is_string($str) || (is_object($str) && method_exists($str, '__toString'))) {
            return new S(trim($this->value, $str));
        }

        return new S(trim($this->value));
    }

    /**
     * Trim the string, by default removing white spaces on the left.
     *
     * You can give as argument string-like or collection-like to set
     * character(s) to strip.
     *
     * @param  mixed $str Optional set of characters to strip.
     * @access public
     * @return S
     */
    public function lstrip($str = null)
    {
        if (is_array($str)) {
            $str = new A($str);
        }

        if ($str instanceof A) {
            return new S(ltrim($this->value, $str->join));
        }

        if (is_string($str) || (is_object($str) && method_exists($str, '__toString'))) {
            return new S(ltrim($this->value, $str));
        }

        return new S(ltrim($this->value));
    }

    /**
     * Trim the string on its right side, by default removing white spaces.
     *
     * You can give as argument string-like or collection-like to set
     * character(s) to strip.
     *
     * @param  mixed $str Optional set of characters to strip.
     * @access public
     * @return S
     */
    public function rstrip($str = null)
    {
        if (is_array($str)) {
            $str = new A($str);
        }

        if ($str instanceof A) {
            return new S(rtrim($this->value, $str->join));
        }

        if (is_string($str) || (is_object($str) && method_exists($str, '__toString'))) {
            return new S(rtrim($this->value, $str));
        }

        return new S(rtrim($this->value));
    }

    /**
     * Adds string content to the end of current string.
     *
     * @param  mixed $str String-like content
     * @access public
     * @return S
     */
    public function append($str)
    {
        return static::concat($this, $str);
    }

    /**
     * Adds content after the string.
     *
     * This is an alias for \Malenki\Bah\S::append() method.
     *
     * @see S::append() Original method of this alias.
     * @param  mixed $str
     * @return S
     */
    public function after($str)
    {
        return $this->append($str);
    }

    /**
     * Adds string content to the beginning of current string.
     *
     * @param  mixed $str String-like content
     * @access public
     * @return S
     */
    public function prepend($str)
    {
        return static::concat($str, $this);
    }

    /**
     * Adds content before the string.
     *
     * This is an alias for \Malenki\Bah\S::prepend() method.
     *
     * @see S::prepend() Original method of this alias.
     * @param  mixed $str
     * @return S
     */
    public function before($str)
    {
        return $this->prepend($str);
    }

    /**
     * Insert new content at given position.
     *
     * @param  mixed                     $str String-like content
     * @param  mixed                     $pos Integer-like content (integer or \Malenki\Bah\N object)
     * @return S
     * @throws \InvalidArgumentException If given position is not valid.
     */
    public function insert($str, $pos)
    {
        self::mustBeString($str, 'String to insert');
        self::mustBeInteger($pos, 'Position');

        if ($pos instanceof N) {
            $pos = $pos->int;
        }

        if ($pos < 0) {
            throw new \InvalidArgumentException(
                'Position must be positive or null integer.'
            );
        }

        if ($pos > count($this)) {
            throw new \InvalidArgumentException(
                'Position must not be greater than length of current string.'
            );
        }

        if ($pos == count($this)) {
            return $this->append($str);
        }

        if ($pos == 0) {
            return $this->prepend($str);
        }

        $str1 = $this->sub(0, $pos);
        $str2 = $this->sub($pos, count($this) - 1);

        return static::concat($str1, $str, $str2);
    }

    protected function _underscore()
    {
        return $this->strip()
            ->lower
            ->replace('/[\s]+/', '_')
            ->replace('/[^\p{Ll}\p{Lu}0-9_]/u', '_')
            ->replace('/_+/', '_')
            ->strip('_')
            ;
    }

    protected function _dash()
    {
        return $this->strip()
            ->lower
            ->replace('/[\s]+/', '-')
            ->replace('/[^\p{Ll}\p{Lu}0-9-]/u', '-')
            ->replace('/-+/', '-')
            ->strip('-')
            ;
    }

    /**
     * Convert current string in camelCase or CamelCase.
     *
     * By default, this will create new string as lower camel case. But if
     * argument is `true`, then returned string will be in upper camel case.
     *
     * Examples:
     * 
     *     $s = new S('Helloi World!');
     *     echo $s->camelCase(); // 'helloWorld'
     *     echo $s->camelCase(true); // 'HelloWorld'
     *
     * __Note:__ This does not convert characters having diacritic, to to that, 
     * call `S::$trans` magic getter before:
     *
     *     $s = new S('Écrit en français !');
     *     echo $s->lcc; // 'écritEnFrançais'
     *     echo $s->trans->lcc; // 'ecritEnFrancais'
     *
     * In this previous example, I used one magic getter alias `lcc` of this 
     * method.
     *
     * @see S::$cc Magic getter alias to get default camel case version
     * @see S::upperCamelCase() Method alias to have upper camel case version
     * @see S::lowerCamelCase() Method alias to have lower camel case version
     * @see S::$upper_camel_case Magic getter alias to get upper camel case version
     * @see S::$ucc Other magic getter alias to get upper camel case version
     * @see S::$lower_camel_case Magic getter alias to get lower camel case version
     * @see S::$lcc Other magic getter alias to get lower camel case version
     * @param  boolean $is_upper `true` to have upper camel case, `false` to have lower camel case. Optional.
     * @return S
     */
    public function camelCase($is_upper = false)
    {
        $func = function (&$v, $k, $is_upper) {
            $c = $v->chunk;
            if ($is_upper || $k != 0) {
                $first = $c->key_0->upper;
            } else {
                $first = $c->key_0->lower;
            }

            $c->replace(0, $first);

            $v = $c->join;
        };

        return $this->strip()
            ->replace('/[\s]+/', '_')
            ->replace('/[^\p{Ll}\p{Lu}0-9_]/u', '_')
            ->replace('/_+/', '_')
            ->strip('_')
            ->split('/_/')
            ->walk($func, $is_upper)
            ->join
            ;
    }

    /**
     * Gets string converted in lower camel case.
     *
     * This is an alias of `\Malenki\Bah\S::camelCase()`.
     *
     * @see S::camelCase() Orignal method of this alias
     * @see S::$cc Magic getter alias to get default camel case version
     * @see S::lowerCamelCase() Method alias to have lower camel case version
     * @see S::$lower_camel_case Magic getter alias to get lower camel case version
     * @see S::$lcc Other magic getter alias to get lower camel case version
     * @return S
     */
    public function lowerCamelCase()
    {
        return $this->camelCase();
    }

    /**
     * Gets string converted in upper camel case.
     *
     * This is an alias of \Malenki\Bah\S::camelCase()true.
     *
     * @see S::camelCase() This calls original method with argument `true`
     * @see S::upperCamelCase() Method alias to have upper camel case version
     * @see S::$upper_camel_case Magic getter alias to get upper camel case version
     * @see S::$ucc Other magic getter alias to get upper camel case version
     * @return S
     */
    public function upperCamelCase()
    {
        return $this->camelCase(true);
    }

    /**
     * Get substring from the original string.
     *
     * By default, returns the first character as a substring.
     *
     * @param mixed $offset Where to start the substring, 0 by default, as N or
     *                      integer
     * @param mixed $limit  Size of the substring, 1 by default, as N or
     *                      integer
     * @todo Missing exception for offset too big
     *
     * @return S
     */
    public function sub($offset = 0, $limit = 1)
    {
        self::mustBeInteger($offset, 'Offset');
        self::mustBeInteger($limit, 'Limit');

        if($offset instanceof N) $offset = $offset->int;
        if($limit instanceof N) $limit = $limit->int;

        if ($offset < 0) {
            throw new \InvalidArgumentException(
                'Offset must be a null or positive integer'
            );
        }

        if ($limit < 1) {
            throw new \InvalidArgumentException(
                'Limit must be an intger equal to or greater than one.'
            );
        }

        return new S(mb_substr($this->value, $offset, $limit, C::ENCODING));
    }

    /**
     * Gets all available positions of given string needle.
     *
     * Unlike its PHP equivalent function, it returns __all__ found positions
     * as a \Malenki\Bah\A object. If no position found, this return object has
     * void collection.
     *
     * @param  mixed $needle The searched string-like content
     * @return A
     */
    public function position($needle)
    {
        self::mustBeString($needle, 'Needle');

        if (is_object($needle)) {
            $needle = "$needle";
        }

        if (empty($needle)) {
            throw new \InvalidArgumentException('Needle must be not empty!');
        }

        $length = mb_strlen($needle, C::ENCODING);
        $offset = 0;

        $a = new A();

        $cnt = count($this);
        while ($offset < $cnt) {
            $pos = mb_strpos($this->value, $needle, $offset, C::ENCODING);

            if ($pos !== false) {
                $a->add(new N($pos));
            } else {
                break;
            }

            $offset = $pos + $length;
        }

        return $a;
    }

    /**
     * Gets all available positions of given string needle (Alias).
     *
     * @see S::position() Original method of this alias
     * @param  mixed $needle The searched string-like content
     * @return A
     */
    public function pos($needle)
    {
        return $this->position($needle);
    }

    /**
     * Removes string part using offset and limit size.
     *
     * @param  mixed $offset Integer-like offset
     * @param  mixed $limit  Integer-like limit size
     * @return S
     */
    public function delete($offset = 0, $limit = 1)
    {
        self::mustBeInteger($offset, 'Offset');
        self::mustBeInteger($limit, 'Limit');

        if($offset instanceof N) $offset = $offset->int;
        if($limit instanceof N) $limit = $limit->int;

        if ($offset < 0) {
            throw new \InvalidArgumentException(
                'Offset must be a null or positive integer'
            );
        }

        if ($limit < 1) {
            throw new \InvalidArgumentException(
                'Limit must be an intger equal to or greater than one.'
            );
        }

        $s = new S('');

        $a = $this->chunk(1);

        while ($a->valid) {
            if ($a->key->gte($offset) && $limit > 0) {
                $limit--;
            } else {
                $s = $s->append($a->current);
            }

            $a->next;
        }

        return $s;
    }

    /**
     * Removes string part using offset and limit size (Alias).
     *
     * @see S::delete() Original method of this alias
     * @param  mixed $offset Integer-like offset
     * @param  mixed $limit  Integer-like limit size
     * @return S
     */
    public function del($offset = 0, $limit = 1)
    {
        return $this->delete($offset, $limit);
    }

    /**
     * Removes string part using offset and limit size (Alias).
     *
     * @see S::delete() Original method of this alias
     * @param  mixed $offset Integer-like offset
     * @param  mixed $limit  Integer-like limit size
     * @return S
     */
    public function remove($offset = 0, $limit = 1)
    {
        return $this->delete($offset, $limit);
    }

    /**
     * Removes string part using offset and limit size (Alias).
     *
     * @see S::delete() Original method of this alias
     * @param  mixed $offset Integer-like offset
     * @param  mixed $limit  Integer-like limit size
     * @return S
     */
    public function rm($offset = 0, $limit = 1)
    {
        return $this->delete($offset, $limit);
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
        self::mustBeString($str, 'Searched starting string');

        $str = preg_quote($str, '/');

        return (boolean) preg_match("/^$str/", $this->value);
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
        self::mustBeString($str, 'Searched ending string');

        $str = preg_quote($str, '/');

        return (boolean) preg_match("/$str\$/", $this->value);
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
        self::mustBeString($expr, 'Expression');

        return (boolean) preg_match($expr, $this->value);
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
     * @return boolean
     */
    public function re($expr)
    {
        return $this->match($expr);
    }

    /**
     * test 
     * 
     * @param mixed $str 
     * @return boolean
     */
    public function test($str)
    {
        self::mustBeStringOrScalar($str, 'String to test');

        return (boolean) preg_match($this->value, $str);
    }

    protected function _upperCaseWords()
    {
        $str_prov = mb_convert_case(
            mb_strtolower(
                mb_strtolower($this->value, C::ENCODING),
                C::ENCODING
            ),
            MB_CASE_TITLE,
            C::ENCODING
        );

        $str_out  = $str_prov;
        $int_length  = mb_strlen($str_prov, C::ENCODING);

        $prev_idx = null;
        $arr_to_change = array();

        for ($i = 0; $i < $int_length; $i++) {
            $letter = mb_substr($str_prov, $i, 1, C::ENCODING);

            if ($letter == "'") {
                $prev_idx = $i;
            }

            if (!is_null($prev_idx) && ($i == $prev_idx + 1)) {
                $arr_to_change[$i] = $letter;
            }
        }

        foreach ($arr_to_change as $idx => $letter) {
            $str_tmp  = mb_substr($str_out, 0, $idx, C::ENCODING);
            $str_tmp .= mb_strtoupper($letter, C::ENCODING);
            $str_tmp .= mb_substr($str_out, $idx+1, $int_length, C::ENCODING);

            $str_out = $str_tmp;
            unset($str_tmp);
        }

        return new self($str_out);
    }

    protected function _upperCaseFirst()
    {
        if (!$this->_isVoid()) {
            $first_char = $this->_first()->_upper();
            $other_chars = $this->sub(1, $this->length->value);

            return self::concat($first_char, $other_chars);
        }

        return $this;
    }

    /**
     * Get character at the given position.
     *
     * @param mixed $idx The index where the character is, as N or integer.
     *
     * @return C
     */
    public function charAt($idx)
    {
        self::mustBeInteger($idx, 'Index');

        if ($idx instanceof N) {
            $idx = $idx->int;
        }

        return new C(mb_substr($this->value, $idx, 1, C::ENCODING));
    }

    /**
     * Alias of charAt() method
     *
     * @uses S::charAt()
     * @param  mixed $idx Position as integer-like
     * @return C
     */
    public function take($idx)
    {
        return $this->charAt($idx);
    }

    /**
     * Alias of charAt() method
     *
     * @uses S::charAt()
     * @param  mixed $idx Position as integer-like
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
     *
     * @return integer
     */
    public function count()
    {
        return $this->_length()->int;
    }

    protected function _isVoid()
    {
        return mb_strlen($this->value, C::ENCODING) == 0;
    }

    /**
     * Returns new string object converted to uppercase.
     *
     * @return S
     */
    protected function _upper()
    {
        return new self(mb_convert_case($this, MB_CASE_UPPER, C::ENCODING));
    }

    /**
     * Returns new string object converted to lowercase.
     *
     * @return S
     */
    protected function _lower()
    {
        return new self(mb_convert_case($this, MB_CASE_LOWER, C::ENCODING));
    }

    /**
     * Returns new String object with capital letters
     *
     * @return S
     */
    protected function _title()
    {
        return new self(mb_convert_case($this, MB_CASE_TITLE, C::ENCODING));
    }

    /**
     * Repeats N times current string.
     *
     * @param  mixed Integer-like value
     * @return S
     */
    public function times($n = 1)
    {
        self::mustBeInteger($n, 'Number of repetition');

        if($n instanceof N) $n = $n->int;

        return new self(str_repeat($this, $n));
    }

    /**
     * Wraps the string to fit given width.
     *
     * @param  mixed $width Width the text must have
     * @param  mixed $cut   Optional string to put at each linebreak, as
     *                      string or S
     * @access public
     * @return S
     */
    public function wrap($width = 79, $cut = PHP_EOL)
    {
        self::mustBeInteger($width, 'Width');
        self::mustBeString($cut, 'Cut');

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
            $str_prov = preg_replace('/\s+/', ' ', trim($this->value));
            $int_length = mb_strlen($str_prov, C::ENCODING);
            $int_width = $width;

            if ($int_length <= $int_width) {
                return new self($str_prov);
            }

            $int_last_space = 0;
            $i = 0;

            do {
                if (mb_substr($str_prov, $i, 1, c::ENCODING) == ' ') {
                    $int_last_space = $i;
                }

                if ($i >= $int_width) {
                    if ($int_last_space == 0) {
                        $int_last_space = $int_width;
                    }

                    $arr_lines[] = trim(
                        mb_substr(
                            $str_prov,
                            0,
                            $int_last_space,
                            C::ENCODING
                        )
                    );

                    $str_prov = mb_substr(
                        $str_prov,
                        $int_last_space,
                        $int_length,
                        C::ENCODING
                    );

                    $int_length = mb_strlen($str_prov, C::ENCODING);

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
     * @return S
     */
    public function margin($left = 5, $right = 0, $alinea = 0)
    {
        self::mustBeInteger($left, 'Left margin');
        self::mustBeInteger($right, 'Right margin');
        self::mustBeInteger($alinea, 'Alinea');

        $int_left = $left;
        $int_right = $right;
        $int_alinea = $alinea;

        if($left instanceof N) $int_left = $left->int;
        if($right instanceof N) $int_right = $right->int;
        if($alinea instanceof N) $int_alinea = $alinea->int;

        if ($int_left < 0 || $int_right < 0) {
            throw new \InvalidArgumentException(
                'Margins must be null or positive numbers!'
            );
        }

        if (abs($int_alinea) > $int_left) {
            throw new \InvalidArgumentException(
                'Alinea must be equal or less than margin left'
            );
        }

        $arr = explode("\n", $this->value);

        $cnt = count($arr);

        for ($i = 0; $i < $cnt; $i++) {
            $v = $arr[$i];

            $int_margin_left = $int_left;
            $int_margin_right = $int_right;

            if ($i == 0) {
                $int_margin_left = $int_left + $int_alinea;

                if ($int_margin_left < 0) {
                    $int_margin_left = 0;
                }
            }

            $arr[$i] = str_repeat(' ', $int_margin_left);
            $arr[$i] .= $v . str_repeat(' ', $int_margin_right);
        }

        return new self(implode("\n", $arr));
    }

    public function center($width = 79, $cut = PHP_EOL)
    {
        self::mustBeInteger($width, 'Width');
        self::mustBeString($cut, 'Cut character');

        if (is_object($width)) {
            $width = $width->int;
        }

        $a = $this->strip()->wrap($width, $cut)->split('/'.$cut.'/u');

        $s = '';

        while ($a->valid()) {
            $diff = new N(($width - count($a->current)) / 2);

            if ($diff->decimal->zero) {
                $left = $right = $diff->int;
            } else {
                if ($a->index->odd) {
                    $left = $diff->ceil;
                    $right = $diff->floor;
                } else {
                    $left = $diff->floor;
                    $right = $diff->ceil;
                }
            }
            $s .= $a->current->margin($left, $right);

            if (!$a->is_last) {
                $s .= $cut;
            }
            $a->next();
        }

        return new S($s);
    }



    /**
     * Justify text on the left or on the right, to fit on given width padding with spaces. 
     * This is usefull for pure text output (email, console, content on `PRE` HTML tag…)
     * 
     * @param string $type Must be either `left` or `right`
     * @param int $width Width to fit. If not given, default used is 79 chars width.
     * @param string $cut Optional string at end of line to use. Default is `PHP_EOL`.
     * @return S
     * @throws \InvalidArgumentException If given type is not `left` or `right`.
     * @throws \InvalidArgumentException If width is not an integer-like.
     * @throws \InvalidArgumentException If width is negative or null.
     * @throws \InvalidArgumentException If cut end of line string is not string-like.
     */
    protected function _leftOrRightJustify($type = 'left', $width = 79, $cut = PHP_EOL)
    {
        self::mustBeInteger($width, 'Width');
        self::mustBeString($cut, 'Cut character');

        if (!in_array($type, array('left', 'right'))) {
            throw new \InvalidArgumentException(
                'Alignment must be "left" or "right"'
            );
        }

        if (is_object($width)) {
            $width = $width->int;
        }

        if($width <= 0){
            throw new \InvalidArgumentException('Width cannot be null!');
        }

        $a = $this->strip()->wrap($width, $cut)->split('/'.$cut.'/u');

        $s = '';


        while ($a->valid()) {
            if ($type == 'left') {
                $pad = $width - count($a->current);
                $s .= $a->current->margin(0, $pad);
            } else {
                $pad = $width - count($a->current->strip);
                $s .= $a->current->strip->margin($pad);
            }

            if (!$a->is_last) {
                $s .= $cut;
            }

            $a->next();
        }

        return new S($s);
    }

    /**
     * Left aligns text to fit it into the given width.
     *
     * If width is not set, then width is set to 79 characters.
     *
     * Gap is filled with spaces.
     *
     * An optional string can be set to have 
     * different end of line, by default, `PHP_EOL` is used. 
     * 
     * This method is usefull for text into console, pure text output or 
     * content to place into `PRE` balise in HTML.
     *
     * @see S::right() To align text on the right
     * @see S::justify() To justify text
     * @see S::ljust() Alias
     * @see S::leftAlign() Other alias
     * @see S::leftJustify() Last but not the least alias :)
     *
     * @param mixed $width Width to fit in, an integer-like. Default is 79. 
     * @param mixed $cut String at the end of each line, by default it is `PHP_EOL`.
     * @return S
     * @throws \InvalidArgumentException If Width is not an integer-like.
     * @throws \InvalidArgumentException If width is negative or null.
     * @throws \InvalidArgumentException If cut end of line string is not string-like.
     */
    public function left($width = 79, $cut = PHP_EOL)
    {
        return $this->_leftOrRightJustify('left', $width, $cut);
    }


    /**
     * Left aligns text to fit it into the given width (alias).
     *
     * @see S::right() To align text on the right
     * @see S::justify() To justify text
     * @see S::left() Original method of this alias.
     *
     * @param mixed $width Width to fit in, an integer-like. Default is 79. 
     * @param mixed $cut String at the end of each line, by default it is `PHP_EOL`.
     * @return S
     * @throws \InvalidArgumentException If Width is not an integer-like.
     * @throws \InvalidArgumentException If width is negative or null.
     * @throws \InvalidArgumentException If cut end of line string is not string-like.
     */
    public function ljust($width = 79, $cut = PHP_EOL)
    {
        return $this->left($width, $cut);
    }



    /**
     * Left aligns text to fit it into the given width (alias).
     *
     * @see S::right() To align text on the right
     * @see S::justify() To justify text
     * @see S::left() Original method of this alias.
     *
     * @param mixed $width Width to fit in, an integer-like. Default is 79. 
     * @param mixed $cut String at the end of each line, by default it is `PHP_EOL`.
     * @return S
     * @throws \InvalidArgumentException If Width is not an integer-like.
     * @throws \InvalidArgumentException If width is negative or null.
     * @throws \InvalidArgumentException If cut end of line string is not string-like.
     */
    public function leftAlign($width = 79, $cut = PHP_EOL)
    {
        return $this->left($width, $cut);
    }



    /**
     * Left aligns text to fit it into the given width (alias).
     *
     * @see S::right() To align text on the right
     * @see S::justify() To justify text
     * @see S::left() Original method of this alias.
     *
     * @param mixed $width Width to fit in, an integer-like. Default is 79. 
     * @param mixed $cut String at the end of each line, by default it is `PHP_EOL`.
     * @return S
     * @throws \InvalidArgumentException If Width is not an integer-like.
     * @throws \InvalidArgumentException If width is negative or null.
     * @throws \InvalidArgumentException If cut end of line string is not string-like.
     */
    public function leftJustify($width = 79, $cut = PHP_EOL)
    {
        return $this->left($width, $cut);
    }


    /**
     * Right aligns text to fit it into the given width.
     *
     * If width is not set, then width is set to 79 characters.
     *
     * Gap is filled with spaces.
     *
     * An optional string can be set to have 
     * different end of line, by default, `PHP_EOL` is used. 
     * 
     * This method is usefull for text into console, pure text output or 
     * content to place into `PRE` balise in HTML.
     *
     * One example of string output by this method using width of 40 could be:
     *
     *     Tous les êtres humains naissent libres
     *      et égaux en dignité et en droits. Ils
     *      sont doués de raison et de conscience
     *         et doivent agir les uns envers les
     *       autres dans un esprit de fraternité.
     *
     * @see S::left() To align text on the left
     * @see S::justify() To justify text
     * @see S::rjust() Alias
     * @see S::rightAlign() Other alias
     * @see S::rightJustify() Last but not the least alias :)
     *
     * @param mixed $width Width to fit in, an integer-like. Default is 79. 
     * @param mixed $cut String at the end of each line, by default it is `PHP_EOL`.
     * @return S
     * @throws \InvalidArgumentException If Width is not an integer-like.
     * @throws \InvalidArgumentException If width is negative or null.
     * @throws \InvalidArgumentException If cut end of line string is not string-like.
     */
    public function right($width = 79, $cut = PHP_EOL)
    {
        return $this->_leftOrRightJustify('right', $width, $cut);
    }

    /**
     * Right aligns text to fit it into the given width (alias).
     *
     * @see S::left() To align text on the left
     * @see S::justify() To justify text
     * @see S::right() Original method of this alias.
     *
     * @param mixed $width Width to fit in, an integer-like. Default is 79. 
     * @param mixed $cut String at the end of each line, by default it is `PHP_EOL`.
     * @return S
     * @throws \InvalidArgumentException If Width is not an integer-like.
     * @throws \InvalidArgumentException If width is negative or null.
     * @throws \InvalidArgumentException If cut end of line string is not string-like.
     */
    public function rjust($width = 79, $cut = PHP_EOL)
    {
        return $this->right($width, $cut);
    }


    /**
     * Right aligns text to fit it into the given width (alias).
     *
     * @see S::left() To align text on the left
     * @see S::justify() To justify text
     * @see S::right() Original method of this alias.
     *
     * @param mixed $width Width to fit in, an integer-like. Default is 79. 
     * @param mixed $cut String at the end of each line, by default it is `PHP_EOL`.
     * @return S
     * @throws \InvalidArgumentException If Width is not an integer-like.
     * @throws \InvalidArgumentException If width is negative or null.
     * @throws \InvalidArgumentException If cut end of line string is not string-like.
     */
    public function rightAlign($width = 79, $cut = PHP_EOL)
    {
        return $this->right($width, $cut);
    }


    /**
     * Right aligns text to fit it into the given width (alias).
     *
     * @see S::left() To align text on the left
     * @see S::justify() To justify text
     * @see S::right() Original method of this alias.
     *
     * @param mixed $width Width to fit in, an integer-like. Default is 79. 
     * @param mixed $cut String at the end of each line, by default it is `PHP_EOL`.
     * @return S
     * @throws \InvalidArgumentException If Width is not an integer-like.
     * @throws \InvalidArgumentException If width is negative or null.
     * @throws \InvalidArgumentException If cut end of line string is not string-like.
     */
    public function rightJustify($width = 79, $cut = PHP_EOL)
    {
        return $this->right($width, $cut);
    }

    /**
     * Justify text, into given width.
     *
     * This allows you to justify text. To do that, you can call it without any 
     * argument, so, the default width is 79 characters, last line is align on 
     * the left and line end is `PHP_EOL`.
     *
     * If you want customize the justifying, then, width is an integer-like, 
     * last line type must be either `left` or `right`, and end of line can be 
     * any string-like you want.
     *
     * Spaces are added to reproduce this justifying effect. Very great for 
     * non-HTML text ouputs, like email, text file, log, console…
     *
     * One example with a long string justifying into width of 40 chars:
     *
     *     Tous  les  êtres humains naissent libres
     *     et  égaux  en  dignité et en droits. Ils
     *     sont  doués  de  raison et de conscience
     *     et  doivent  agir  les  uns  envers  les
     *     autres dans un esprit de fraternité. 
     * 
     * @param mixed $width Width as integer-like to fit resulting string in. 
     * Optional, default is 79 characters.
     * @param string $last_line Last line type as string-like. Optional, by 
     * default set to `left`
     * @param mixed $cut End of line string-like. Optional, set by default at 
     * `PHP_EOL`
     * @return S
     * @throws \InvalidArgumentException If given type is not `left` or `right`.
     * @throws \InvalidArgumentException If width is not an integer-like.
     * @throws \InvalidArgumentException If width is negative or null.
     * @throws \InvalidArgumentException If cut end of line string is not string-like.
     */
    public function justify($width = 79, $last_line = 'left', $cut = PHP_EOL)
    {
        self::mustBeInteger($width, 'Width');
        self::mustBeString($cut, 'Cut character');

        if (!in_array($last_line, array('left', 'right'))) {
            throw new \InvalidArgumentException(
                'Alignment of last line must be "left" or "right"'
            );
        }

        if (is_object($width)) {
            $width = $width->int;
        }

        if($width <= 0){
            throw new \InvalidArgumentException('Width cannot be null or negative!');
        }


        $a = $this
            ->strip()
            ->replace('/\s+/', ' ')
            ->wrap($width, $cut)
            ->split('/'.preg_quote($cut, '/').'/u');

        $s = '';
        $sp = new S(' ');

        if (count($a) == 1) {
            unset($a);

            return $this->$last_line($width, $cut);
        } while ($a->valid()) {
            if ($a->is_last) {
                $s .= $a->current->$last_line($width, $cut);
            } else {
                $line = $a->current->strip;
                $diff = new N($width - count($line));
                $words = $line->split('/\s/u');
                $nb_spaces = count($words) - 1 + $diff->int;
                $div = new N($nb_spaces / (count($words) - 1));
                $div_floor = $div->floor->int;

                $missing = new N((count($words) - 1) * ($div->double - $div_floor));
                $sp_pad = $sp->times($div_floor);

                while ($words->valid()) {
                    if (!$words->is_last && count($sp_pad)) {
                        $s .= $words->current->append($sp_pad);

                        if ($missing->test('> 0')) {
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
        self::mustBeString($sep, 'Separator regexp');

        if (is_object($sep)) {
            $sep = (string) $sep;
        }

        if (strlen($sep) == 0) {
            throw new \InvalidArgumentException(
                'Separator regexp must be a not null string or S instance.'
            );
        }

        $arr = preg_split($sep, $this->value);

        $cnt = count($arr);
        for ($i = 0; $i < $cnt; $i++) {
            $arr[$i] = new S($arr[$i]);
        }

        return new A($arr);
    }

    public function split($sep)
    {
        return $this->explode($sep);
    }

    public function cut($sep)
    {
        return $this->explode($sep);
    }

    /**
     * Cuts the string as a set of substrings having given size.
     *
     * Each substring is a `\Malenki\Bah\S` object. The set of this objects is 
     * put into an `\Malenki\Bah\A` object.
     *
     * So, let's chunk a string to see what we get:
     *
     *     $s = new S('azertyuiop');
     *     var_dump($s->chunk(3)->array);
     *
     * This will give an array having the following set of `\Malenki\Bah\S`: 
     * `aze`, `rty`, `uio` and `p`.
     *
     * __Note:__ This method can be used as magic getter too. In this case, it 
     * will split the string into substring having one character. Example:
     *
     *     $s = new S('azerty');
     *     echo $s->chunk->join(','); // 'a,z,e,r,t,y'
     * 
     * @see S::$chunk Magic getter version
     * @param int|N $size If not given, its default value is 1.
     * @return A
     * @throws \InvalidArgumentException If size is not an integer-like.
     * @throws \InvalidArgumentException If chunk's size is less than one.
     */
    public function chunk($size = 1)
    {
        self::mustBeInteger($size, 'Chunk’s size');

        if($size instanceof N) $size = $size->int;

        if ($size < 1) {
            throw new \InvalidArgumentException(
                'Chunk’s size must be equal at least to 1.'
            );
        }

        $a = new A();

        $cnt = count($this);
        for ($i = 0; $i < $cnt; $i += $size) {
            $a->add($this->sub($i, $size));
        }

        return $a;
    }

    /**
     * Replace some parts of current string using Regexp
     *
     * This acts like `preg_replace()` function. The first argument is the 
     * pattern to match, the second is the replacement string. 
     *
     * Example:
     *
     *     $s = new S('azerty');
     *     echo $s->replace('/aey/', '!'); // '!z!rt!'
     * 
     * Each param can be string or object having `__toString()` method.
     *
     * @see S::change() An alias for this method.
     * @param mixed $pattern Pattern to match. A string-like type.
     * @param mixed $string String to put in place of matching parts.
     * @return S
     * @throws \InvalidArgumentException If one of the arguments is not a 
     * string-like type.
     */
    public function replace($pattern, $string)
    {
        self::mustBeString($pattern, 'Pattern');
        self::mustBeString($string, 'Replacement string');

        return new S(preg_replace($pattern, $string, $this->value));
    }

    /**
     * Change matching parts of the string using Regexp (Alias). 
     * 
     * @see S::replace() Original method of this alias.
     * @param mixed $pattern Pattern to match. A string-like type.
     * @param mixed $string String to put in place of matching parts.
     * @return S
     * @throws \InvalidArgumentException If one of the arguments is not a 
     * string-like type.
     */
    public function change($pattern, $string)
    {
        return $this->replace($pattern, $string);
    }

    /**
     * Use current string as format for given params, it is a `sprintf`-like
     * 
     * This method acts as `sprintf()`, using current string as format string. 
     * So, it can take any number of arguments of any "stringable" type. But 
     * you can also use one argument if this is a set of params. So, you have 
     * two different ways to use it.
     *
     * A litle example to show it in action:
     *
     *     $s = new S('I will have %s data to %s.');
     *     echo $s->format('some', new S('show')); // 'I will have some data to show.'
     *     // or
     *     $s = new S('I will have %s data to %s.');
     *     $params = array('some', new S('show')); // or A or H object too
     *     echo $s->format($params); // 'I will have some data to show.'
     *
     * __Note:__ Object of type `\Malenki\Bah\N` can be used too.
     *
     *     $n = new N(M_PI);
     *     $s = new S('I am pi: %1.3f')
     *     echo $s->format($n); // 'I am pi: 3.142'
     *
     * @param mixed $params Named of set of params to use if you want use other way than multi params. 
     * @return S
     * @throws \InvalidArgumentException If at least one argument is not a 
     * scalar or an object having `__toString()` method.
     */
    public function format($params = null)
    {
        $args_cnt = func_num_args();
        $args = func_get_args();

        if(!is_null($params)){
            if($params instanceof A || $params instanceof H){
                $args = array_values($params->array); //beware of H case
                $args_cnt = count($args);
            } elseif(is_array($params)){
                $args = $params;
                $args_cnt = count($args);
            } 
        }

        for ($i = 0; $i < $args_cnt; $i++) {
            $v = $args[$i];

            if ($v instanceof N) {
                $args[$i] = $v->value;
            } elseif (is_object($v) && method_exists($v, '__toString')) {
                $args[$i] = "$v";
            } elseif (!is_scalar($v)) {
                throw new \InvalidArgumentException(
                    'Arguments to use with S::format() must be scalar values i'
                    .'or object having __toString() method.'
                );
            }
        }

        array_unshift($args, $this->value);

        return new self(call_user_func_array('sprintf', $args));
    }

    /**
     * Sets one character at given position.
     *
     * This change one character of the string. Example:
     *
     *     $s = new S('azerty');
     *     echo $s->set(1, 'b'); // aberty
     * 
     * @param int|N $idx Index of an existing position, as integer-like
     * @param mixed $char New character to set, as string-like.
     * @return S
     * @throws \InvalidArgumentException If index is not an integer-like.
     * @throws \RuntimeException If index does not exist.
     * @throws \InvalidArgumentException If New character is not a string-like type.
     * @throws \InvalidArgumentException If new character is not a string-like having a size of one.
     */
    public function set($idx, $char)
    {
        self::mustBeInteger($idx, 'Index');

        if($idx instanceof N) $idx = $idx->int;

        if ($idx < 0 || $idx >= count($this)) {
            throw new \RuntimeException(
                sprintf('Index %d is not defined into this string!', $idx)
            );
        }

        self::mustBeString($char, 'New character');

        if (mb_strlen($char, C::ENCODING) != 1) {
            throw new \InvalidArgumentException(
                'Given string must be a only ONE character.'
            );
        }

        return $this->_chars()->replace($idx, $char)->join;
    }

    protected function _rtl()
    {
        $this->_chars()->rewind();

        while ($this->_chars()->valid) {
            if($this->_chars()->current()->ltr) return false;
            $this->_chars()->next;
        }

        return true;
    }

    protected function _ltr()
    {
        $this->_chars()->rewind();

        while ($this->_chars()->valid) {
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
     * Add new line '\n'.
     * @param  boolean  $after If false, put new line before the string
     * @return S
     */
    public function n($after = true)
    {
        if ($after) {
            return new self($this . "\n");
        } else {
            return new self("\n" . $this);
        }
    }


    /**
     * Add new line '\r'.
     * @param  boolean  $after If false, put new line before the string
     * @return S
     */
    public function r($after = true)
    {
        if ($after) {
            return new self($this . "\r");
        } else {
            return new self("\r" . $this);
        }
    }
}

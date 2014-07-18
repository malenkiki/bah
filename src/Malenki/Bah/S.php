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
 * Play with Strings!
 *
 * ## Checking
 *
 * ### Starts or ends with…
 *
 * You can check whether string start or end by given another string. This is 
 * as simple as that following example:
 *
 *     $s = new S('Hello!');
 *     var_dump($s->startsWith('He')); // true
 *     var_dump($s->endsWith('yo!')); // false
 * 
 * ### Checking whether the string is void
 *
 * You can use either `S::$void` or `S::$empty` magic getters to check whether 
 * the string is void or not. This returns `boolean`:
 *
 *     $s = new S('');
 *     var_dump($s->void); // true
 *     var_dump($s->empty); // true
 *
 *     $s = new S('foo');
 *     var_dump($s->void); // false
 *     var_dump($s->empty); // false
 *
 *     $s = new S('   ');
 *     var_dump($s->void); // false
 *     var_dump($s->empty); // false
 * 
 * ### LTR, RTL or both?
 *
 * Some language use other direction while writting words. For example, in 
 * english, we write words form left to right (or LTR), and in arabic 
 * languages, or in hebrew, we write words from right to left (or RTL).
 *
 * Sometimes, you can have text mixing both directions. So, `\Malenki\Bah\S` 
 * class allow you to test directionality of the string using some magic 
 * getters and their aliases, returning `boolean`.
 *
 * Let’s check whether the given string is LTR:
 *
 *     $s = new S('Ceci est du français tout à fait banal.');
 *     var_dump($s->ltr);
 *     var_dump($s->is_ltr);
 *     var_dump($s->is_left_to_right);
 *     var_dump($s->left_to_right)
 *
 * All previous lines into code sample will return `true`.
 *
 * Now, let’s check whether the given string is RTL or not:
 *
 *     $s = new S('أبجد');
 *     var_dump($s->rtl);
 *     var_dump($s->is_rtl);
 *     var_dump($s->is_right_to_left);
 *     var_dump($s->right_to_left);
 * 
 * Again, all lines will produce `true`.
 *
 * Now, let’s see how to check whether string has both directions:
 *
 *     $s = new S('Ceci est du français contenant le mot arabe أبجد qui veut dire "abjad".');
 *     var_dump($s->has_mixed_direction);
 *     var_dump($s->mixed_direction); 
 *     var_dump($s->is_ltr_and_rtl); 
 *     var_dump($s->ltr_and_rtl); 
 *     var_dump($s->is_rtl_and_ltr); 
 *     var_dump($s->rtl_and_ltr);
 *
 * All should be `true`!
 *
 * ## Getting informations
 *
 * ### Counts
 *
 * You can get counts of chars or of bytes contained into the string using 3 ways:
 *
 *  - the `count()` function (`\Malenki\Bah\S` implements `\Countable` 
 *  interface), returns __number of characters__ as __primitive integer__ value
 *  - the `S::$length` magic getter, returns number of characters as 
 *  `\Malenki\Bah\N` object
 *  - the `S::$bytes` magic getter returns an `\Malenki\Bah\A` object, so you 
 *  can get number of bytes using length magic getter call or this object or 
 *  calling `count()` with this object as argument.
 *
 * Now, a little example:
 *
 *     $s = new S('Je suis écrit en français.');
 *     // using count() function
 *     var_dump(count($s->bytes));
 *     var_dump(count($s));
 *     //using objects
 *     var_dump($s->bytes->length);
 *     var_dump($s->length);
 * 
 * This previous code sample should produce following output:
 *
 *     int(28)
 *     int(26)
 *     class Malenki\Bah\N#35 (1) {
 *       public $value =>
 *         int(28)
 *     }
 *     class Malenki\Bah\N#114 (1) {
 *       public $value =>
 *         int(26)
 *     }
 *
 * ### Finger prints
 *
 * Magic getters for `\Malenki\Bah\S::$md5` and `\Malenki\Bah\S::$sha1` are 
 * available, and return another `\Malenki\Bah\S` object.
 * 
 *     $s = new S('Hello!');
 *     print($s->md5); // '952d2c56d0485958336747bcdd98590d'
 *     print($s->sha1); // '69342c5c39e5ae5f0077aecc32c0f81811fb8193' 
 *
 * ## Getting parts
 *
 * ### Getting character(s)
 *
 * You can get one or more characters using a method to take one character 
 * using its position or by calling magic getters to have a collection of 
 * characters.
 *
 * So, to get one characters, you have the choice within 3 brother methods:
 *
 *     $s = new S('azerty');
 *     echo $s->take(1); // 'z'
 *     // or
 *     echo $s->charAt(1);
 *     // or
 *     echo $s->at(1);
 *
 * To get a collection of characters as `\malenki\Bah\A` object, use following 
 * magic getter:
 *
 *     $s = new S('azerty');
 *     $s->chars; // collection of characters a, z, e, r, t, and  y
 *
 *
 * ### Getting substring(s)
 *
 * You have many ways to get substrings, you can explode the string, take range 
 * of characters, take some part matching some regexp…
 *
 * #### Explode everything!
 *
 * You have two different ways to explode your string into simple manner.
 *
 *  - By using a given regexp as separator
 *  - By cutting each N characters.
 *
 * So, for each way, you get a `\Malenki\Bah\A` object having many 
 * `\Malenki\Bah\S` objects.
 *
 * Using a regular expression is easy, you have 3 brother methods to do that, 
 * so, look this examples (using `join()` method of `\Malenki\Bah\A` returned 
 * object as guest star):
 *
 *     $s = new S('1940-06-18 20:00:00');
 *     echo $s->explode('/[\s:-]/')->join(', '); // '1940, 06, 18, 20, 00, 00'
 *     // or
 *     echo $s->split('/[\s:-]/')->join(', ');
 *     // or
 *     echo $s->cut('/[\s:-]/')->join(', ');
 *
 * To split the string each N characters, use this:
 *
 *     $s = new S('abcdefghijklmnopqrstuvwxyz');
 *     $s->chunk(2)->join(','); // 'ab,cd,ef,gh,ij,kl,mn,op,qr,st,uv,wx,yz'
 *
 * #### Classical substring way…
 *
 * You can extract substring by given start position and the length of the 
 * substring.
 *
 *     $s = new S('azerty');
 *     echo $s->sub(1, 3); // 'zer'
 *
 *
 * ## Adding content to it
 *
 * ### Prepend, append
 *
 * Prepending or appending piece of string is as simple as this:
 *
 *     $s = new S('World');
 *     echo $s->prepend('Hello ')->append('!');
 *     // or
 *     echo $s->prepend(new S('Hello '))->append(new S('!'));
 *                  
 * You must get `Hello World!` as resulting string.
 *
 * ### Inserting string
 *
 * You can insert inside the string other string.
 *
 * To insert string, you must have the string or object having `__toString()` 
 * method, and the position as integer (object or primitive type).
 *
 *     $s = new S('Hello!');
 *     echo $s->insert(' World', 5); // print 'Hello World!'
 *     // or
 *     echo $s->insert(new S(' World'), 5);
 *     // or
 *     echo $s->insert(' World', new N(5));
 *     // or
 *     echo $s->insert(new S(' World'), new N(5));
 *
 * ### Repeat again and again…
 *
 * You can repeat the string how many times you wish. You have just to call `S::times()` method:
 *
 *     $s = new S('Hi!');
 *     echo $s->append(' ')->times(3)->strip;
 * 
 * You should get `Hi! Hi! Hi!`. Note I used some other features to add/remove spaces too.       
 *
 * ### Adding new line
 *
 * You could add LF (`"\n"`) or CR (`"\r"`) or CRLF (`"\r\n"`) quickly using magic getters… `S::$n` and `S::$r` and orthers…
 *
 *     $s = new S('Something');
 *     echo $s->n; // print "Something\n"
 *     echo $s->r; // print "Something\r"
 *     echo $s->r->n; // print "Something\r\n"
 *     echo $s->rn; // print "Something\r\n"
 *     echo $s->eol; // print "Something\n" if PHP_EOL is '\n'
 *
 * This shorthand can be called as method taking one boolean argument to place 
 * new line character after (default, `true`) or before the string (`false`):
 *
 *     $s = new S('Something');
 *     echo $s->n(); // print "Something\n"
 *     echo $s->n(true); // print "Something\n"
 *     echo $s->n(false); // print "\nSomething"
 *     echo $s->r(); // print "Something\r"
 *     echo $s->r(true); // print "Something\r"
 *     echo $s->r(false); // print "\rSomething"
 *
 * ### Join several strings together
 *
 * To concatenate strings and/or objects having `__toString()` method, then use 
 * static method `S::concat()`. This method takes any number of arguments and 
 * returns `\Malenki\Bah\S` object.
 *
 *     echo S::concat('Ceci est', new S(' une '), ' chaîne');
 *     // print 'Ceci est une chaîne'
 *     echo S::concat('Ceci est', new S(' une '), ' chaîne')->upper;
 *     // print 'CECI EST UNE CHAÎNE'
 *
 * ## Changing some parts
 *
 * Soon…
 *
 * ## Removing some parts
 *
 * Some features are dédicated to removing part of the string, but more 
 * advanced removal can be performed using Regexp features, so, read chapter 
 * about Regexp too!
 *
 * ### Stripping
 *
 * You can strip left and right sides (`S::strip`), just left side 
 * (`S::lstrip`) or just right side (`S::rstrip`).
 *
 * You can strip string either by using methods or by using magic getters.
 *
 * By using methods, you can change default character to strip. If you use 
 * magic getter or methods without arguments, then stripping feature removes 
 * only white space. To remove other characters, you must provide them using 
 * array, string, `\Malenki\Bah\S` or `\MAlenki\Bah\A` objects:
 *
 *     $s = new S('   I have some white spaces   ');
 *     $s->strip;
 *     // or
 *     $s->strip();
 *     $s = new S('~~.~~~I have some custom chars to remove~~~...~~');
 *     $s->strip('.~');
 *     // or
 *     $s->strip(new S('.~'));
 *     // or
 *     $s->strip(array('.', '~'));
 *     // or
 *     $s->strip(new A(array('.', '~')));
 *
 * ### Deleting using ranges
 *
 * You can delete some parts using range like you do it while getting substring:
 *
 *     $s = new S('azerty');
 *     echo $s->delete(1, 3); // 'aty'
 *     // or
 *     echo $s->del(1, 3); // 'aty'
 *     // or
 *     echo $s->remove(1, 3); // 'aty'
 *     // or
 *     echo $s->rm(1, 3); // 'aty'
 *
 * ## Regular expression
 *
 * This class can use regex in different manners. For example, maching string 
 * can be done using two ways: the current string can be the regexp or the 
 * string to test.
 *
 * First, current string is tested:
 *
 *     $s = new S('azerty');
 *     var_dump($s->match('/ty$/')); // true
 *     // or
 *     var_dump($s->match('/ty$/')); // true
 *     // or
 *     var_dump($s->match('/ty$/')); // true
 *
 * Second, current string is the pattern:
 *
 *     $s = new S('/ze/');
 *     var_dump($s->test('azerty')); // true
 *
 *
 *
 * ## Casting
 *
 * You can cast to two different types: objects of primitive PHP types.
 *
 * ### Casting to objects
 *
 * To cast to object, only `Malenki\Bah\C` and `\Malenki\Bah\N` are available 
 * but under some conditions:
 *
 *  - To cast to `\Malenki\Bah\C`, string’s length must have exactly one character.
 *  - To cast to `\Malenki\Bah\N`, string must have numeric value inside it
 *
 * Examples:
 *
 *     $s = new S('a');
 *     $s->to_c; // casts to \Malenki\Bah\C possible
 *     $s->to_n; // casts to \Malenki\Bah\N not possible: exception
 * 
 *     $s = new S('azerty');
 *     $s->to_c; // casts to \Malenki\Bah\C not possible: exception
 *     $s->to_n; // casts to \Malenki\Bah\N not possible: exception
 *
 *     $s = new S('3');
 *     $s->to_c; // casts to \Malenki\Bah\C possible
 *     $s->to_n; // casts to \Malenki\Bah\N possible
 *
 *     $s = new S('3.14');
 *     $s->to_c; // casts to \Malenki\Bah\C not possible: exception
 *     $s->to_n; // casts to \Malenki\Bah\N possible
 *
 * ### Casting to primitive types
 *
 * You can cast to primitive PHP types like `integer`, `string` and so on. But 
 * like you have seen into previous section, the current string must follow 
 * some conditions to do that:
 *
 *  - to integer: string must contain numeric value
 *  - to float/double: string must have numeric value
 *
 * ## Looping
 *
 * You can use two different ways to get characters into loop:
 *  - the fake `\Iterator` way
 *  - the `\IteratorAggregate` way
 *
 * So, for the first case, you will do:
 *
 *      $s = new S('azerty');
 *
 *      while($s->valid()){
 *          $s->current(); // do something with it…
 *          $s->next();
 *      }
 *
 * For the second case, you will do:
 *
 *      $s = new S('azerty');
 *
 *      foreach($s as $c){
 *          $c; // do what you want with it…
 *      }
 *
 * @package Malenki\Bah
 * @property-read A $chars A collection of Malenki\Bah\C objects.
 * @property-read A $bytes A collection of Malenki\bah\N objects
 * @property-read N $length The strings length
 * @property-read C $to_c If string as only one character, convert it to \Malenki\Bah\C object.
 * @property-read N $to_n If string contents numeric value, try to export it to \Malenki\Bah\N object.
 * @property-read S $n Return itself + LF '\n'
 * @property-read S $r Return itself + CR '\r'
 * @property-read S $rn Return itself + CRLF '\r\n'
 * @property-read S $eol Return itself + PHP_EOL
 * @property-read boolean $is_void Tests whether the current string is void or not.
 * @property-read boolean $void Tests whether the current string is void or not.
 * @property-read boolean $is_empty Tests whether the current string is void or not.
 * @property-read boolean $empty Tests whether the current string is void or not.
 * @property-read S $strip Remove white spaces surrounding the string. See \Malenki\Bah\S::strip() for more actions.
 * @property-read S $lstrip Remove white spaces at the left of the string. See \Malenki\Bah\S::lstrip() for more actions.
 * @property-read S $rstrip Remove white spaces at the right of the string. See \Malenki\Bah\S::rstrip() for more actions.
 * @property-read S $trim Remove white spaces surrounding the string. Alias of \Malenki\Bah\S::strip().
 * @property-read S $ltrim Remove white spaces at the left of the string. Alias of \Malenki\Bah\S::lstrip().
 * @property-read S $rtrim Remove white spaces at the right of the string. Alias of \Malenki\Bah\S::rstrip().
 * @property-read S $sub Take first character as string. See \Malenki\Bah\S::sub() for more actions.
 * @property-read S $chunk Get exploded string as collection of characters. See \Malenki\Bah\S::chunk() for more actions.
 * @property-read S $delete Remove first character. See \Malenki\Bah\S::delete() for more actions.
 * @property-read S $remove Remove first character. See \Malenki\Bah\S::delete() for more actions.
 * @property-read S $del Remove first character. See \Malenki\Bah\S::delete() for more actions.
 * @property-read S $rm Remove first character. See \Malenki\Bah\S::delete() for more actions.
 *
 * @property-read S $center Center the string on line having width of 79 chars.
 * @property-read S $left Align on left the string on line having width of 79 chars.
 * @property-read S $left_justify Align on left the string on line having width of 79 chars.
 * @property-read S $left_align Align on left the string on line having width of 79 chars.
 * @property-read S $ljust Align on left the string on line having width of 79 chars.
 * @property-read S $right Align on right the string on line having width of 79 chars.
 * @property-read S $right_justify Align on right the string on line having width of 79 chars.
 * @property-read S $right_align Align on right the string on line having width of 79 chars.
 * @property-read S $rjust Align on right the string on line having width of 79 chars.
 * @property-read S $justify Justify the string on line having width of 79 chars.
 * @property-read S $just Justify the string on line having width of 79 chars.
 *
 * @property-read S $wrap Get wrapped version of the string, width of 79 chars
 *
 * @property-read S $underscore Get underscorized version (`some_words_into_sentence`) 
 * @property-read S $_ Get underscorized version (`some_words_into_sentence`)
 * @property-read S $dash Get dashrized version (`some-words-into-sentence`)
 * @property-read S $upper_camel_case Get lower camel case version
 * @property-read S $lower_camel_case Get upper camel case version
 * @property-read S $cc Get camel case versioni (lower case for first letter)
 * @property-read S $lcc Get lower camel case version
 * @property-read S $ucc Get upper camel case version
 * @property-read S $lower Get string into lower case
 * @property-read S $upper Get string into upper case
 * @property-read S $first Get first character
 * @property-read S $last Get last character
 * @property-read S $title Get "title" version of the string like ucwords does
 * @property-read S $ucw Get upper case words
 * @property-read S $ucwords Get upper case words
 * @property-read S $upper_case_words Get upper case words
 * @property-read S $trans Get translitterated version of the string
 * @property-read S $md5 Get MD5 sum of the string
 * @property-read S $sha1 Get SHA1 sum of the string
 * @property-read S $swap_case Get swapped case version
 * @property-read S $swapcase Get swapped case version
 * @property-read S $swap Get swapped case version
 * @property-read S $squeeze Remove duplicates sequences of characters. See 
 * \Malenki\Bah\S::squeeze() methods to have other features
 * @property-read S $ucf Get upper case first
 * @property-read S $ucfirst Get upper case first
 * @property-read S $upper_case_first Get upper case first
 * @property-read string $string Get current string as primitive PHP type string
 * @property-read string $str Get current string as primitive PHP type string
 * @property-read integer $integer Get current string as primitive PHP type 
 * integer, if possible.
 * @property-read integer $int Get current string as primitive PHP type 
 * integer, if possible.
 * @property-read float $float Get current string as primitive PHP type float, 
 * if possible.
 * @property-read double $double Get current string as primitive PHP type 
 * double, if possible.
 * @license MIT
 * @author Michel Petit aka "Malenki" <petit.michel@gmail.com>
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

    /**
     * Quicker access to count 
     * 
     * @var int
     */
    protected $int_count = null;

    /**
     * Current position while using methods for loop while.
     *
     * @var int
     */
    protected $position = 0;

    /**
     * Concatenates string or object having toString feature together.
     *
     * This can take any number of arguments. You can mix string primitive type
     * and oject having `toString()` method implemented, like `\Malenki\Bah\S`
     * or other classes… But, you can use several arguments into a collection. 
     * As you wish!
     *
     * The returned object is from `\Malenki\Bah\S` class.
     *
     * If one arg is used as collection, the collection type must be `array`, 
     * `\Malenki\Bah\A` object or `\Malenki\Bah\H` object.
     *
     * Examples:
     *
     *     S::concat('az', 'er', 'ty'); // S object 'azerty'
     *     // or
     *     S::concat(array('az', 'er', 'ty')); // S object 'azerty'
     *
     * @param array|A|H $params Named of set of params to use if you want use 
     * other way than multi params. 
     * @return S
     * @throws \InvalidArgumentException     If one of the arguments is not 
     * string or object having `__toString()` method.
     */
    public static function concat($params = null)
    {
        $args = func_get_args();

        if(!is_null($params)){
            if($params instanceof A || $params instanceof H){
                $args = array_values($params->array); //beware of H case
            } elseif(is_array($params)){
                $args = $params;
            } 
        }
        $str_out = '';

        foreach ($args as $s) {
            self::mustBeStringOrScalar($s);
            $str_out .= $s;
        }

        return new S($str_out);
    }

    /**
     * Manage available magic getters.
     *
     * @param string $name Attribute’s name
     * @return mixed
     */
    public function __get($name)
    {

        if ($name === 'to_c' || $name === 'to_n') {
            return $this->_to($name);
        } elseif (
            $name === 'is_void'
            ||
            $name === 'void'
            ||
            $name === 'is_empty'
            ||
            $name === 'empty'
        ) {
            return $this->_isVoid();
        } elseif (
            $name === 'strip'
            ||
            $name === 'lstrip'
            ||
            $name === 'rstrip'
            ||
            $name === 'trim'
            ||
            $name === 'ltrim'
            ||
            $name === 'rtrim'
            ||
            $name === 'title'
            ||
            $name === 'sub'
            ||
            $name === 'chunk'
            ||
            $name === 'delete'
            ||
            $name === 'remove'
            ||
            $name === 'del'
            ||
            $name === 'rm'
            ||
            $name === 'center'
            ||
            $name === 'wrap'
            ||
            $name === 'n'
            ||
            $name === 'r'
            ||
            $name === 'rn'
            ||
            $name === 'eol'
            ||
            $name === 'squeeze'
            ||
            $name === 'current'
            ||
            $name === 'key'
            ||
            $name === 'next'
            ||
            $name === 'rewind'
            ||
            $name === 'valid'
            ||
            $name === 'left'
            ||
            $name === 'right'
            ||
            $name === 'justify'
        ) {
            return $this->$name();
        } elseif ($name == '_') {
            return $this->_underscore();
        } elseif (
            $name === 'ucw'
            ||
            $name === 'ucwords'
            ||
            $name === 'upper_case_words'
        ) {
            return $this->title();
        } elseif (
            $name === 'ucf'
            ||
            $name === 'ucfirst'
            ||
            $name === 'upper_case_first'
        ) {
            return $this->_upperCaseFirst();
        } elseif (
            $name === 'length'
            ||
            $name === 'chars'
            ||
            $name === 'bytes'
            ||
            $name === 'dash'
            ||
            $name === 'underscore'
            ||
            $name === 'string'
            ||
            $name === 'str'
            ||
            $name === 'integer'
            ||
            $name === 'int'
            ||
            $name === 'float'
            ||
            $name === 'double'
            ||
            $name === 'upper'
            ||
            $name === 'lower'
            ||
            $name === 'n'
            ||
            $name === 'r'
            ||
            $name === 'first'
            ||
            $name === 'last'
            ||
            $name === 'trans'
            ||
            $name === 'rtl'
            ||
            $name === 'ltr'
            ||
            $name === 'md5'
            ||
            $name === 'sha1'
        ) {
            $str_method = '_' . $name;

            return $this->$str_method();
        } elseif(
            $name === 'is_ltr'
            ||
            $name === 'left_to_right'
            ||
            $name === 'is_left_to_right'
        ){
            return $this->_ltr();
        } elseif(
            $name === 'is_rtl'
            ||
            $name === 'right_to_left'
            ||
            $name === 'is_right_to_left'
        ){
            return $this->_rtl();
        } elseif(
            $name === 'has_mixed_direction'
            ||
            $name === 'mixed_direction'
            ||
            $name === 'is_rtl_and_ltr'
            ||
            $name === 'rtl_and_ltr'
            ||
            $name === 'is_ltr_and_rtl'
            ||
            $name === 'ltr_and_rtl'
        ){
            return $this->_hasMixedDirection();
        } elseif(
            $name === 'lower_camel_case'
            ||
            $name === 'lcc'
            ||
            $name === 'cc'
        ){
            return $this->camelCase();
        } elseif(
            $name === 'upper_camel_case'
            ||
            $name === 'ucc'
        ){
            return $this->camelCase(true);
        } elseif(
            $name === 'swap_case'
            ||
            $name === 'swapcase'
            ||
            $name === 'swap'
        ){
            return $this->_swapCase();
        } elseif(
            $name === 'left_justify'
            ||
            $name === 'left_align'
            ||
            $name === 'ljust'
        ){
            return $this->left();
        } elseif(
            $name === 'right_justify'
            ||
            $name === 'right_align'
            ||
            $name === 'rjust'
        ){
            return $this->right();
        } elseif ($name === 'just') {
            return $this->justify();
        }

        return parent::__get($name);
    }

    /**
     * Create new S object.
     *
     * @param  scalar $str Scalar value to defined as string object.
     * @throw \InvalidArgumentException If argument if not valid UTF-8 string.
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
        $this->count();
    }

    /**
     * Create \Malenki\Bah\C collection from the string
     * 
     * This explode the string into characters, each of them is instanciated as 
     * `\Malenki\Bah\C` object into `\Malenki\Bah\A` collection.
     *
     * This method is the back side of magic getter `\Malenki\Bah\S::$chars`
     *
     * @see S::$chars Magic getter `S::$chars`
     * @return A
     */
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

    /**
     * Create bytes collection from the string.
     *
     * This create collection of bytes as `\Malenki\Bah\N` object stored into 
     * `\Malenki\Bah\A` collection. 
     *
     * This method is the back side of magic getter `\Malenki\Bah\S::$bytes`
     * 
     * @see S::$bytes Magic getter `S::$bytes`
     * @return A
     */
    protected function _bytes()
    {
        if (is_null($this->bytes)) {
            $a = new A();

            $this->_chars();

            while ($this->chars->valid()) {

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

    /**
     * Compute the string’s length as \Malenki\Bah\N object 
     *
     * Defines the magic getter `\Malenki\BahS::$length` to have quick access 
     * to characters' number contained into the string as `\Malenki\Bah\N` 
     * object.
     * 
     * __Note:__ This is equivalent of `\Malenki\Bah\S::count()` defined by 
     * `\Countable` interface, but here, `\Malenki\Bah\N` object is returned, 
     * not an `int`.
     *
     * @see S::$length Magic getter `S::$length`
     * @see S::count() Same method but returns `int`
     * @return A
     */
    protected function _length()
    {
        if (is_null($this->length)) {
            $this->length = new N(mb_strlen($this, C::ENCODING));
        }

        return $this->length;
    }

    /**
     * Convert current object to other object type. 
     * 
     * You can only convert to `\Malenki\Bah\C` object or `\Malenki\Bah\N` 
     * object.
     *
     * @param string $name Either `to_c` or `to_n` 
     * @return C|N
     * @throws \RuntimeException If you try converting to \Malenki\Bah\C object 
     * a string having more than one character.
     * @throws \RuntimeException If you try cinverting string having not 
     * numeric value to \Malenki\Bah\N object.
     */
    protected function _to($name)
    {
        if ($name == 'to_c') {
            if (count($this) != 1) {
                throw new \RuntimeException(
                    'Cannot converting \Malenki\Bah\S object having length '
                    .'not equal to one to C object.'
                );
            }

            return new C($this->value);
        }

        if ($name == 'to_n') {
            if(!is_numeric($this->value)){
                throw new \RuntimeException(
                    'Cannot converting \Malenki\Bah\S object to \Malenki\Bah\N'
                   .' object, because no numeric value were found inside it!'
                );
            }

            return new N((double) $this->value);
        }
    }

    /**
     * Converts current string object to string php primitive type. 
     * 
     * This is runtime part of magic getter `\Malenki\Bah\S::$string`.
     *
     * @see S::_str() Alias
     * @see S::$string Magic getter `S::$string`
     * @return string
     */
    protected function _string()
    {
        return (string) $this->value;
    }


    /**
     * Converts current string object to string php primitive type (Alias). 
     * 
     * This is runtime part of magic getter `\Malenki\Bah\S::$str`.
     *
     * @see S::_string() Original method
     * @see S::$str Magic getter `S::$str`
     * @return string
     */
    protected function _str()
    {
        return $this->_string();
    }

    /**
     * Converts current string object to integer primitive type. 
     * 
     * This method is the runtime part of magic getter 
     * `\Malenki\Bah\S::$integer`.
     *
     * This works only if the string has numeric value inside it. If this is 
     * not the case, then it raises `\RuntimeException`.
     *
     *     $s = new S('12');
     *     var_dump($s->integer); // type 'int'
     *
     * If numeric value is float, then returns only its integer part.
     *
     *     $s = new S('3.14');
     *     var_dump($s->integer); // 3
     *
     * @see S::$integer The magic getter version `S::$integer`
     * @see S::_int() An alias
     *
     * @return integer
     * @throws \RuntimeException If current string has not numeric value.
     */
    protected function _integer()
    {
        if (!is_numeric($this->value)) {
            throw new \RuntimeException(
                'Current string has not numeric content:'
                .' cannot cast it to integer!'
            );
        }

        return (int) $this->value;
    }

    /**
     * Converts current string object to integer primitive type. 
     * 
     * This runtime for magic getter is the shorter version of 
     * `\Malenki\Bah\S::$integer` magic getter. 
     *
     * @see S::$int The magic getter version `S::$integer`
     * @see S::_integer() The original method of this alias
     *
     * @return integer
     * @throws \RuntimeException If current string has not numeric value.
     */
    protected function _int()
    {
        return $this->_integer();
    }

    /**
     * Converts current string object to float primitive type. 
     * 
     * This method is the runtime part of magic getter 
     * `\Malenki\Bah\S::$float`.
     *
     * This works only if the string has numeric value inside it. If this is 
     * not the case, then it raises `\RuntimeException`.
     *
     *     $s = new S('3.14');
     *     var_dump($s->float); // 3.14
     *
     * @see S::$float The magic getter version `S::$float`
     *
     * @return integer
     * @throws \RuntimeException If current string has not numeric value.
     */
    protected function _float()
    {
        if (!is_numeric($this->value)) {
            throw new \RuntimeException(
                'Current string has not numeric content: '
                .'cannot cast it to float!'
            );
        }

        return (float) $this->value;
    }


    /**
     * Converts current string object to double primitive type. 
     * 
     * This method is the runtime part of magic getter 
     * `\Malenki\Bah\S::$float`.
     *
     * This works only if the string has numeric value inside it. If this is 
     * not the case, then it raises `\RuntimeException`.
     *
     *     $s = new S('3.14');
     *     var_dump($s->double); // 3.14
     *
     * @see S::$double The magic getter version `S::$double`
     *
     * @return integer
     * @throws \RuntimeException If current string has not numeric value.
     */
    protected function _double()
    {
        if (!is_numeric($this->value)) {
            throw new \RuntimeException(
                'Current string has not numeric content: '
                .'cannot cast it to double!'
            );
        }

        return (double) $this->value;
    }

    /**
     * Implements the \IteratorAggregate interface 
     * 
     * This is mandatory to allow use of `foreach` loop on current object. So, 
     * each item is a `\Malenki\Bah\C` object.
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->_chars()->array);
    }

    /**
     * Current character get into while loop using fake \Iterator way.
     *
     * The current class does not implement `\Iterator` interface due to 
     * conflict with `\IteratorAggregate`, but `current()` feature and its 
     * friend are implemented without the need of implement the interface! 
     * 
     * @see S::key() Get the current index number as `\Malenki\Bah\N` object
     * @see S::next() Put cursor to next item
     * @see S::rewind() Rewind, so we can loop from the start, again
     * @see S::valid() False is at the end of the sequence.
     * @return C
     */
    public function current()
    {
        return $this->charAt($this->position);
    }


    /**
     * Gets current item’s key into while loop using fake \Iterator way.
     *
     * The current class does not implement `\Iterator` interface due to 
     * conflict with `\IteratorAggregate`, but `key()` feaure is implemented 
     * with its friends without the use of the interface! 
     * 
     * @see S::current() Get the current char as `\Malenki\Bah\C` object
     * @see S::next() Put cursor to next item
     * @see S::rewind() Rewind, so we can loop from the start, again
     * @see S::valid() False is at the end of the sequence.
     * @return N
     */
    public function key()
    {
        return new N($this->position);
    }

    /**
     * Place cursor to the next item into while loop using fake \Iterator way.
     *
     * The current class does not implement `\Iterator` interface due to 
     * conflict with `\IteratorAggregate`, but `next()` feature is implemented 
     * with its friend without the interface! 
     * 
     * @see S::current() Get the current char as `\Malenki\Bah\C` object
     * @see S::key() Get the current index number as `\Malenki\Bah\N` object
     * @see S::rewind() Rewind, so we can loop from the start, again
     * @see S::valid() False is at the end of the sequence.
     * @return S
     */
    public function next()
    {
        $this->position++;

        return $this;
    }


    /**
     * Re-initialize the counter for while loop using fake \Iterator way.
     *
     * Rewinds, so we can loop from the start, again.
     *
     * The current class does not implement `\Iterator` interface due to 
     * conflict with `\IteratorAggregate`, but `rewind()` feature is 
     * implemented with its friends!
     * 
     * @see S::current() Get the current char as `\Malenki\Bah\C` object
     * @see S::key() Get the current index number as `\Malenki\Bah\N` object
     * @see S::next() Put cursor to next item
     * @see S::valid() False is at the end of the sequence.
     * @return S
     */
    public function rewind()
    {
        $this->position = 0;

        return $this;
    }


    /**
     * Tests whether loop using fake \Iterator way is at the end or not.
     *
     * The current class does not implement `\Iterator` interface due to conflict 
     * with `\IteratorAggregate`. But `valid()` feature is implemented with its 
     * friends!
     * 
     * @see S::current() Get the current char as `\Malenki\Bah\C` object
     * @see S::key() Get the current index number as `\Malenki\Bah\N` object
     * @see S::next() Put cursor to next item
     * @see S::rewind() Rewind, so we can loop from the start, again
     * @return boolean
     */
    public function valid()
    {
        return $this->position >= 0
            &&
            $this->position < count($this);
    }

    /**
     * Transliterates the string.
     *
     * This transforms the string to remove all its diacritics, to have as 
     * result a string containing only ASCII-like characters.
     *
     * This feature is called by using magic getter version only.
     *
     * Example:
     *
     *     $s = new S('C’est écrit en français !');
     *     echo $s->trans; // 'C’est ecrit en francais !'
     * 
     * __Warning:__ This requires the __Intl PHP extension__! If you try to use 
     * this method without it, you will get an `\RuntimeException`. Please see 
     * [Intl section](http://php.net/manual/en/intro.intl.php) on the PHP 
     * official website if you have not this extension installed yet.
     *
     * __Warning 2:__ This cannot work on PHP version < 5.4.0! Even if Intl is 
     * installed, this provided translitterated feature only into PHP 5.4.0+
     *
     * @see S::$trans Magic getter version `S::$trans`
     * @return S
     * @throws \RuntimeException If this is called and intl extension is not 
     * installed.
     * @throws \RuntimeException If intl extension is installed but that uses 
     * PHP version prior to 5.4.0.
     */
    protected function _trans()
    {
        if (!extension_loaded('intl')) {
            throw new \RuntimeException(
                'Missing Intl extension. This is required to use ' . __CLASS__ . '::trans'
            );
        }

        if(!function_exists('\transliterator_transliterate')){
            throw new \RuntimeException(
                'Intl extension does not provide transliterate feature '
                .'prior PHP 5.4.0!'
            );
        }

        $str = \transliterator_transliterate(
            "Any-Latin; NFD; [:Nonspacing Mark:] Remove; NFC;",
            $this->value
        );

        return new self($str);
    }

    /**
     * Swaps cases.
     *
     * This converts lower cases to upper cases and _vice versa_.
     *
     * This is used only into magic getter context.
     *
     * Example:
     *
     *     $s = new S('AzeRtY');
     *     echo $s->swap; // 'aZErTy'
     * 
     * @see S::$swap Magic getter `S::$swap`
     * @see S::$swap_case Magic getter `S::$swap_case`
     * @see S::$swapcase Magic getter `S::$swapcase`
     * @return S
     */
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
     * @param  int|N                     $radius Numbers of characters to display in addition of the searched string, on the left, and on the right.
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
     * array, a `\Malenki\Bah\A` or `\Malenki\Bah\H` objects.
     *
     *     $s = new S('aazzzerrtyy');
     *     echo $s->squeeze(); // azerty
     *     echo $s->squeeze('az'); // azerrtyy
     *     echo $s->squeeze(new S('az')); // azerrtyy
     *     echo $s->squeeze(array('a','z')); // azerrtyy
     *
     * If a collection is choosen, then each item must has size of one character.
     *
     * If a string-like is provided, then the string will be exploded to get
     * each characters independently.
     *
     * @see S::$squeeze Magic getter version.
     * @param  mixed $seq Optionnal set of characters to squeeze
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
     * Trims the string, by default removing white spaces on the left and on 
     * the right sides.
     *
     * You can give as argument string-like or collection-like to set
     * character(s) to strip.
     *
     * Examples:
     *
     *     $s = new S('   azerty   ');
     *     echo $s->strip(); // 'azerty'
     
     *     $s = new S(__._.__azerty___.___');
     *     $a = array('_', '.');
     *     $h = array('foo' => '_', 'bar' => '.');
     *     echo $s->strip('_.'); // 'azerty'
     *     echo $s->strip($a); // 'azerty'
     *     echo $s->strip($h); // 'azerty'
     *
     * @see S::lstrip() To remove only on the left side
     * @see S::rstrip() To remove only on the right side
     * @see S::$strip The magic getter version
     * @param  mixed $str Optionnal set of characters to strip.
     * @param  mixed $type Optionnal type of strip, `left`, `right` or `both`. 
     * By default strip on the two sides.
     * @return S
     * @throws \InvalidArgumentException If str type is not allowed
     * @throws \InvalidArgumentException If given optional type is not a 
     * string-like value.
     * @throws \InvalidArgumentException If type does not exist
     */
    public function strip($str = null, $type = null)
    {

        $func = 'trim';

        if(!is_null($type)){
            self::mustBeString($type, 'Type');
            $type = "$type";

            if(!in_array($type, array('left', 'right', 'both'))){
                throw new \InvalidArgumentException(
                    'Type of strip must be `left`, `right` or `both`'
                );
            }

            if($type == 'left'){
                $func = 'ltrim';
            }

            if($type == 'right'){
                $func = 'rtrim';
            }
        }


        if(!is_null($str)){
            if (is_array($str)) {
                $str = new A($str);
            }

            if ($str instanceof A) {
                return new S($func($this->value, $str->join));
            }
            
            if ($str instanceof H) {
                return new S($func($this->value, $str->to_a->join));
            }


            if (
                is_string($str) 
                ||
                (is_object($str) && method_exists($str, '__toString'))
            ) {
                return new S($func($this->value, $str));
            }

            throw new \InvalidArgumentException(
                'Invalid type given for collection of characters to strip.'
            );
        }

        return new S($func($this->value));
    }

    /**
     * Trim the string, by default removing white spaces on the left.
     *
     * You can give as argument string-like or collection-like to set
     * character(s) to strip.
     *
     * @see S::strip() To remove both on the left and on the right.
     * @see S::rstrip() To remove only on the right side.
     * @see S::$lstrip The magic getter version to remove white space on the left
     * @param  mixed $str Optional set of characters to strip.
     * @return S
     * @throws \InvalidArgumentException If str type is not allowed
     */
    public function lstrip($str = null)
    {
        return $this->strip($str, 'left');
    }

    /**
     * Trim the string on its right side, by default removing white spaces.
     *
     * You can give as argument string-like or collection-like to set
     * character(s) to strip.
     *
     * @see S::strip() To remove both on the left and on the right.
     * @see S::lstrip() To remove only on the left side.
     * @see S::$rstrip The magic getter version to remove white space on the right
     * @param  mixed $str Optional set of characters to strip.
     * @return S
     * @throws \InvalidArgumentException If str type is not allowed
     */
    public function rstrip($str = null)
    {
        return $this->strip($str, 'right');
    }

    /**
     * Trims the string (Alias).
     *
     * @see S::strip() The original method of this alias
     * @see S::ltrim() To remove only on the left side
     * @see S::rtrim() To remove only on the right side
     * @see S::$trim The magic getter version
     * @param  mixed $str Optionnal set of characters to strip.
     * @param  mixed $type Optionnal type of strip, `left`, `right` or `both`. 
     * By default strip on the two sides.
     * @return S
     * @throws \InvalidArgumentException If given optional type is not a 
     * string-like value.
     * @throws \InvalidArgumentException If type does not exist
     * @throws \InvalidArgumentException If str type is not allowed
     */
    public function trim($str = null, $type = null)
    {
        return $this->strip($str, $type);
    }


    /**
     * Trims the string on the left (Alias).
     *
     * @see S::lstrip() The original method of this alias
     * @see S::rtrim() To remove only on the right side
     * @see S::ltrim Magic getter alias
     * @see S::$trim The magic getter version
     * @param  mixed $str Optionnal set of characters to strip.
     * @return S
     * @throws \InvalidArgumentException If str type is not allowed
     */
    public function ltrim($str = null)
    {
        return $this->strip($str, 'left');
    }


    /**
     * Trims the string on the right (Alias).
     *
     * @see S::rstrip() The original method of this alias
     * @see S::ltrim() To remove only on the right side
     * @see S::rtrim Magic getter alias
     * @see S::$trim The magic getter version
     * @param  mixed $str Optionnal set of characters to strip.
     * @return S
     * @throws \InvalidArgumentException If str type is not allowed
     */
    public function rtrim($str = null)
    {
        return $this->strip($str, 'right');
    }

    /**
     * Adds string content to the end of current string.
     *
     * Given argument, a string-like value, is put at the end of the string.
     *
     *     $s = new S('Tagada');
     *     echo $s->append(' tsointsoin'); // 'Tagada tsointsoin'
     *
     * @see S::after() An alias
     * @param  mixed $str String-like content
     * @return S
     * @throws \Exception If given string is not… a string-like value.
     */
    public function append($str)
    {
        return static::concat($this, $str);
    }

    /**
     * Adds content after the string (Alias).
     *
     * @see S::append() Original method of this alias.
     * @param  mixed $str A string-like value to add
     * @return S
     * @throws \Exception If given string is not… a string-like value.
     */
    public function after($str)
    {
        return $this->append($str);
    }

    /**
     * Adds string content to the beginning of current string.
     *
     * Given argument, a string-like value, is put at the beginning of the string.
     *
     *     $s = new S('tsointsoin !');
     *     echo $s->prepend('Tagada '); // 'Tagada tsointsoin !'
     *
     * @see S::before() An alias
     * @param  mixed $str String-like content
     * @return S
     * @throws \Exception If given string is not… a string-like value.
     */
    public function prepend($str)
    {
        return static::concat($str, $this);
    }

    /**
     * Adds content before the string.
     *
     * @see S::prepend() Original method of this alias.
     * @param  mixed $str String-like content
     * @return S
     * @throws \Exception If given string is not… a string-like value.
     */
    public function before($str)
    {
        return $this->prepend($str);
    }




    /**
     * Inserts new content at given position.
     *
     * It is very easy to insert string into current one, if you cannot use 
     * `S::prepend()` or `S::append()`, then, `S::insert()` method is what you 
     * need.
     *
     * Let’s see an example:
     *
     *     $s = new S('abcghi');
     *     echo $s->insert('def', 3); // 'abcdefghi'
     *
     * @see S::put() An alias
     * @param  mixed $str String-like content
     * @param  mixed $pos Integer-like content (integer or \Malenki\Bah\N object)
     * @return S
     * @throws \InvalidArgumentException If given string is not valid
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
    
    
    
    /**
     * Inserts new content at given position (Alias).
     *
     * @see S::insert() Original method
     * @param  mixed $str String-like content
     * @param  mixed $pos Integer-like content
     * @return S
     * @throws \InvalidArgumentException If given string is not valid
     * @throws \InvalidArgumentException If given position is not valid.
     */
    public function put($str, $pos)
    {
        return $this->insert($str, $pos);
    }

    /**
     * Convert string using underscore 
     *
     * The string is converted to lower cases, each character that is not a 
     * letter, a digit or an underscore is replaced by underscore and then 
     * duplicate underscores are removed. Heading and trailing underscores 
     * are removed.
     * 
     * This method is used only to implement magic getter versions.
     *
     * Example:
     *
     *     $s = new S('Je suis écrit en français !');
     *     echo $s->underscore; // 'je_suis_écrit_en_français'
     *     echo $s->_; // 'je_suis_écrit_en_français'
     *
     * @see S::$underscore Magic getter version `S::$underscore`
     * @see S::$_ Other magic getter version `S::$_`
     * @return S
     */
    protected function _underscore()
    {
        return new self(
            trim(
                preg_replace(
                    '/_+/',
                    '_',
                    preg_replace(
                        '/[^\p{Ll}\p{Lu}0-9_]/u',
                        '_',
                        preg_replace(
                            '/[\s]+/u',
                            '_',
                            mb_strtolower(trim($this->value), C::ENCODING)
                        )
                    )
                ),
                '_'
            )
        );
    }


    /**
     * Convert string using dashes 
     *
     * The string is converted to lower cases, each character that is not a 
     * letter, a digit or a dash is replaced by dash and then 
     * duplicate dashes are removed. Heading and trailing dashes are 
     * removed.
     *
     * This is hyphen version of `\Malenki\Bah\S::_underscore()`.
     * 
     * This method is used only to implement magic getter versions.
     *
     * Example:
     *
     *     $s = new S('Je suis écrit en français !');
     *     echo $s->dash; // 'je-suis-écrit-en-français'
     *
     * @see S::$dash Magic getter version `S::$dash`
     * @return S
     */
    protected function _dash()
    {
        return new self(
            trim(
                preg_replace(
                    '/-+/',
                    '-',
                    preg_replace(
                        '/[^\p{Ll}\p{Lu}0-9-]/u',
                        '-',
                        preg_replace(
                            '/[\s]+/u',
                            '-',
                            mb_strtolower(trim($this->value), C::ENCODING)
                        )
                    )
                ),
                '-'
            )
        );
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
            $v = new S($v);
            $c = $v->chunk;
            if ($is_upper || $k != 0) {
                $first = $c->key_0->upper;
            } else {
                $first = $c->key_0->lower;
            }

            $c->replace(0, $first);

            $v = $c->join;
        };

        $a = new A(
            explode(
                '_',
                trim(
                    preg_replace(
                        '/_+/',
                        '_',
                        preg_replace(
                            '/[^\p{Ll}\p{Lu}0-9_]/u',
                            '_',
                            preg_replace(
                                '/[\s]+/u',
                                '_',
                                trim($this->value)
                            )
                        )
                    ),
                    '_'
                )
            )
        );
        return $a->walk($func, $is_upper)->join;
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
     * Getting substring is simple. First, set the starting point, an index 
     * from 0 to length of the string less one. Seconde, set the size, if not 
     * given, it is one character.
     *
     * Example:
     *
     *     $s = new S('azerty');
     *     echo $s->sub(); // 'a'
     *     echo $s->sub(1, 3); // 'zer'
     *
     * @see S::$sub Magic getter to get first character
     * @param mixed $offset Where to start the substring, 0 by default, as N or
     *                      integer
     * @param mixed $limit  Size of the substring, 1 by default, as N or
     *                      integer
     *
     * @return S
     * @throws \InvalidArgumentException If offset is not an Integer-like
     * @throws \InvalidArgumentException If offset is not valid
     * @throws \InvalidArgumentException If limit is not an Integer-like
     * @throws \InvalidArgumentException If limit is negative
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

        if ($offset >= count($this)) {
            throw new \InvalidArgumentException(
                'Offset cannot greater than the last index of the string'
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
     * as a `\Malenki\Bah\A` object. If no position found, this returns object as
     * void collection.
     *
     * Example:
     *
     *     $s = new S('Tagada tsointsoin !');
     *     $s->position('tsoin'); // Collection having 7 and 12 as \Malenki\Bah\N
     *
     * @see S::pos() Alias
     * @param  mixed $needle The searched string-like content
     * @return A
     * @throws \InvalidArgumentException If needle is not a string-like value
     * @throws \InvalidArgumentException If needle is empty
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

        $a = array();

        while ($offset < $this->int_count) {
            $pos = mb_strpos($this->value, $needle, $offset, C::ENCODING);

            if ($pos !== false) {
                $a[] = new N($pos);
            } else {
                break;
            }

            $offset = $pos + $length;
        }

        return new A($a);
    }

    /**
     * Gets all available positions of given string needle (Alias).
     *
     * @see S::position() Original method of this alias
     * @param  mixed $needle The searched string-like content
     * @return A
     * @throws \InvalidArgumentException If needle is not a string-like value
     * @throws \InvalidArgumentException If needle is empty
     */
    public function pos($needle)
    {
        return $this->position($needle);
    }

    /**
     * Removes string part using offset and limit size.
     *
     * To delete string part, you must give index from where to start, thinking 
     * about the starting point of the string is zero. Then, you must define 
     * the length of the part to remove.
     *
     * A little example show you how to do that:
     *
     *     $s = new S('This string will loose some parts…');
     *     $s->delete(4, 7); // 'This will loose some parts…'
     *
     * @see S::del() An alias
     * @see S::remove() Another alias
     * @see S::rm() Last alias
     * @param int|N $offset Integer-like offset
     * @param int|N $limit  Integer-like limit size
     * @return S
     * @throws \InvalidArgumentException If offset is not an integer-like
     * @throws \InvalidArgumentException If offset is negative
     * @throws \InvalidArgumentException If limite is not an integer-like
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


        if ($offset >= count($this)) {
            throw new \InvalidArgumentException(
                'Offset cannot greater than the last index of the string'
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
     * @throws \InvalidArgumentException If offset is not an integer-like
     * @throws \InvalidArgumentException If offset is negative
     * @throws \InvalidArgumentException If limite is not an integer-like
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
     * @throws \InvalidArgumentException If offset is not an integer-like
     * @throws \InvalidArgumentException If offset is negative
     * @throws \InvalidArgumentException If limite is not an integer-like
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
     * @throws \InvalidArgumentException If offset is not an integer-like
     * @throws \InvalidArgumentException If offset is negative
     * @throws \InvalidArgumentException If limite is not an integer-like
     */
    public function rm($offset = 0, $limit = 1)
    {
        return $this->delete($offset, $limit);
    }

    /**
     * Gets the first character as \Malenki\Bah\S object.
     *
     * This is runtime part of magic getter `\Malenki\Bah\S::$first`.
     *
     *     $s = new S('azerty');
     *     echo $s->first; // print 'a'
     *
     * If you want first character as `\Malenki\Bah\C` object, then, do one of the followings:
     *
     *     $s = new S('azerty');
     *     $s->chars->first; // first \Malenki\Bah\C
     *     // or
     *     $s->first->to_c; // casting \Malenki\Bah\S to \Malenki\Bah\C
     * 
     * @return S
     */
    protected function _first()
    {
        return $this->sub();
    }


    /**
     * Gets the last character as \Malenki\Bah\S object.
     *
     * This is runtime part of magic getter `\Malenki\Bah\S::$last`.
     *
     *     $s = new S('azerty');
     *     echo $s->last; // print 'y'
     *
     * If you want last character as `\Malenki\Bah\C` object, then, do one of the followings:
     *
     *     $s = new S('azerty');
     *     $s->chars->last; // last \Malenki\Bah\C
     *     // or
     *     $s->last->to_c; // casting \Malenki\Bah\S to \Malenki\Bah\C
     * 
     * @return S
     */
    protected function _last()
    {
        return $this->sub($this->int_count - 1, 1);
    }

    /**
     * Checks that current string starts with the given string or not
     *
     * @param  mixed   $str primitive string or object havin __toString method
     * @return boolean
     * @throws \InvalidArgumentException If str is not string-like value
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
     * @return boolean
     * @throws \InvalidArgumentException If str is not string-like value
     */
    public function endsWith($str)
    {
        self::mustBeString($str, 'Searched ending string');

        $str = preg_quote($str, '/');

        return (boolean) preg_match("/$str\$/", $this->value);
    }

    /**
     * Checks string using Regexp
     *
     * Checks whether current string match the given regular expression.
     *
     * Example:
     *
     *     $s = new S('azerty');
     *     var_dump($s->match('/ty$/')); // true
     *
     * @see S::regexp() An alias for this method
     * @see S::re() Another alias for this method
     * @param  mixed $expr primitive string or object having __toString method
     * @return boolean
     * @throws \InvalidArgumentException If regexp pattern is not a string-like 
     * value.
     */
    public function match($expr)
    {
        self::mustBeString($expr, 'Expression');

        return (boolean) preg_match($expr, $this->value);
    }

    /**
     * Alias of match method
     *
     * @see S::match() The original method of this alias
     * @param  mixed   $expr primitive string or object having __toString method
     * @return boolean
     * @throws \InvalidArgumentException If regexp pattern is not a string-like 
     * value.
     */
    public function regexp($expr)
    {
        return $this->match($expr);
    }

    /**
     * Alias of match method
     *
     * @see S::match() The original method of this alias
     * @param  mixed   $expr primitive string or object having __toString method
     * @return boolean
     * @throws \InvalidArgumentException If regexp pattern is not a string-like 
     * value.
     */
    public function re($expr)
    {
        return $this->match($expr);
    }

    /**
     * Tests given string using regex pattern stored into current string. 
     * 
     * Acts as current string is regex pattern, then, string passed to the 
     * argument of this method will be tested using current string.
     *
     * Example:
     *
     *     $s = new S('/ze/');
     *     var_dump($s->test('azerty')); // true
     *
     *
     * @param mixed $str A string-like to test
     * @return boolean
     * @throws \InvalidArgumentException If argument is not a string-like or a 
     * scalar.
     */
    public function test($str)
    {
        self::mustBeStringOrScalar($str, 'String to test');

        return (boolean) preg_match($this->value, $str);
    }

    /**
     * Converts the string to upper case words. 
     * 
     * This is equivalent of basic PHP function `ucwords()` But enhances for 
     * UTF-8 and use of additionnal separators to split string into words.
     *
     * So, this feature can use magic getter or method way, and some alias are 
     * available too.
     *
     * Examples:
     *
     *     $s = new S("C'est du français !"); // note the apos after this example…
     *     echo $s->title; // 'C'est Du Français !'
     *     echo $s->title("'"); // 'C'Est Du Français !'
     *
     * @see S::ucw() Method alias `S::ucw()`
     * @see S::ucwords() Method alias `S::ucwords()`
     * @see S::upperCaseWords() Method alias `S::upperCaseWords()`
     * @see S::$ucw Magic getter alias `S::$ucw`
     * @see S::$ucwords Magic getter alias `S::$ucwords`
     * @see S::$upper_case_words Magic getter alias `S::$upper_case_words`
     * @param mixed $sep Optionnal sequence of additionnal separators.
     * @return S
     * @throws \InvalidArgumentException If not null sep has not right type or 
     * contains bad type.
     */
    public function title($sep = null)
    {
        if(is_null($sep)){
            return  new self(
                mb_convert_case($this->value, MB_CASE_TITLE, C::ENCODING)
            );
        }

        $str_prov = mb_convert_case(
            mb_strtolower(
                mb_strtolower($this->value, C::ENCODING),
                C::ENCODING
            ),
            MB_CASE_TITLE,
            C::ENCODING
        );
        

        if($sep instanceof A || $sep instanceof H){
            $arrs = array_values($sep->array); //beware of H case
        } elseif(is_array($sep)){
            $arrs = $sep;
        } elseif($sep instanceof S){
            $arrs = preg_split('//ui', $sep->string);
        } elseif(is_scalar($sep)){
            $arrs = preg_split('//ui', $sep);
        } else {
            throw \InvalidArgumentException(
                'Given seperator has not good type.'
            );
        }

        $str_out  = $str_prov;
        $int_length  = mb_strlen($str_prov, C::ENCODING);

        $prev_idx = null;
        $arr_to_change = array();

        for ($i = 0; $i < $int_length; $i++) {
            $letter = mb_substr($str_prov, $i, 1, C::ENCODING);

            foreach($arrs as $new_sep){
                if ($letter == "$new_sep") {
                    $prev_idx = $i;
                    break;
                }
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


    /**
     * Converts the string to upper case words (Alias). 
     *
     * @see S::ucwords() Method alias `S::ucwords()`
     * @see S::upperCaseWords() Method alias `S::upperCaseWords()`
     * @see S::$ucw Magic getter alias `S::$ucw`
     * @see S::$ucwords Magic getter alias `S::$ucwords`
     * @see S::$upper_case_words Magic getter alias `S::$upper_case_words`
     * @param mixed $sep Optionnal sequence of additionnal separators.
     * @return S
     * @throws \InvalidArgumentException If not null sep has not right type or 
     * contains bad type.
     */
    public function ucw($sep = null)
    {
        return $this->title($sep);
    }



    /**
     * Converts the string to upper case words (Alias). 
     *
     * @see S::ucw() Method alias `S::ucw()`
     * @see S::upperCaseWords() Method alias `S::upperCaseWords()`
     * @see S::$ucw Magic getter alias `S::$ucw`
     * @see S::$ucwords Magic getter alias `S::$ucwords`
     * @see S::$upper_case_words Magic getter alias `S::$upper_case_words`
     * @param mixed $sep Optionnal sequence of additionnal separators.
     * @return S
     * @throws \InvalidArgumentException If not null sep has not right type or 
     * contains bad type.
     */
    public function ucwords($sep = null)
    {
        return $this->title($sep);
    }



    /**
     * Converts the string to upper case words (Alias). 
     *
     * @see S::ucw() Method alias `S::ucw()`
     * @see S::ucwords() Method alias `S::upperCaseWords()`
     * @see S::$ucw Magic getter alias `S::$ucw`
     * @see S::$ucwords Magic getter alias `S::$ucwords`
     * @see S::$upper_case_words Magic getter alias `S::$upper_case_words`
     * @param mixed $sep Optionnal sequence of additionnal separators.
     * @return S
     * @throws \InvalidArgumentException If not null sep has not right type or 
     * contains bad type.
     */
    public function upperCaseWords($sep = null)
    {
        return $this->title($sep);
    }



    /**
     * Converts to upper case first.
     * 
     * Converts the first character to upper case.
     *
     * @see S::$ucf Magic getter `S::$ucf`
     * @see S::$ucfirst Magic getter `S::$ucfirst`
     * @see S::$upper_case_first Magic getter `S::$upper_case_first`
     *
     * @return S
     */
    protected function _upperCaseFirst()
    {
        if (!$this->_isVoid()) {
            $first_char = $this->_first()->_upper();
            $other_chars = $this->sub(1, $this->int_count);

            return self::concat($first_char, $other_chars);
        }

        return $this;
    }

    /**
     * Get character at the given position.
     *
     * Position start from 0 to end at string’s length less one.
     *
     * __Note:__ Returned object is not a `\Malenki\Bah\S` object, but a 
     * `\Malenki\Bah\C` object, to deal with all character’s features.
     *
     *     $s = new S('abc');
     *     $s->charAt(0)->unicode; // print unicode value of the char 'a'
     * 
     * @see S::take() An alias
     * @see S::at() Another alias
     * @param int|N $idx The index where the character is, as N or integer.
     * @return C
     * @throws \InvalidArgumentException If index is not an integer-like.
     * @throws \InvalidArgumentException If index does not exist.
     */
    public function charAt($idx)
    {
        self::mustBeInteger($idx, 'Index');

        if ($idx instanceof N) {
            $idx = $idx->int;
        }

        if($idx < 0 || $idx >= count($this)){
            throw new \InvalidArgumentException(
                'Cannot get chars at non-existing position!'
            );
        }

        return new C(mb_substr($this->value, $idx, 1, C::ENCODING));
    }

    /**
     * Alias of charAt() method
     *
     * @see S::charAt() Original method
     * @param  int|N $idx Position as integer-like
     * @return C
     */
    public function take($idx)
    {
        return $this->charAt($idx);
    }

    /**
     * Alias of charAt() method
     *
     * @see S::charAt() Original method
     * @param int|N $idx Position as integer-like
     * @return C
     */
    public function at($idx)
    {
        return $this->charAt($idx);
    }

    /**
     * Implements Countable interface.
     *
     * __Note:__ This method does not returns an `\Malenki\Bah\N` object, but
     * a primitive integer, to have same behaviour as its interface definition.
     *
     * @see \Countable
     * @return integer
     */
    public function count()
    {
        if(is_null($this->int_count)){
            $this->int_count = mb_strlen($this->value, C::ENCODING);
        }

        return $this->int_count;
    }

    /**
     * Test whether the current string is void or not. 
     * 
     * This is runtime part of some magic getters.
     *
     * Examples:
     *
     *     $s = new S('foo');
     *     var_dump($s->void); // false
     *
     *     $s = new S('');
     *     var_dump($s->void); // true
     *
     * @see S::$is_void Magic getter `S::$is_void`
     * @see S::$void Magic getter `S::$void`
     * @see S::$is_empty Magic getter `S::$is_empty`
     * @see S::$empty Magic getter `S::$empty`
     * @return boolean
     */
    protected function _isVoid()
    {
        return $this->int_count == 0;
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
     * Repeats N times current string.
     *
     * Repeats N times current string. Number of times can be zero to, so 
     * resulting string is void.
     *
     * Example:
     *
     *     $s = new S('Hello!');
     *     echo $s->append(' ')->times(3)->strip; // 'Hello! Hello! Hello!'
     *     echo $s->times(0); // '' (empty string)
     *
     * @see S::repeat() Alias of this method
     * @param mixed $n Integer-like value
     * @return S
     * @throws \InvalidArgumentException If N is not an integer-like.
     * @throws \InvalidArgumentException If N is negative
     */
    public function times($n)
    {
        self::mustBeInteger($n, 'Number of repetition');

        if($n instanceof N) $n = $n->int;

        if($n < 0){
            throw new \InvalidArgumentException(
                'Number of repeats cannot be negative'
            );
        }

        return new self(str_repeat($this, $n));
    }


    /**
     * Repeats N times current string (Alias).
     *
     * @see S::times() Original method of this alias
     * @param  mixed $n Integer-like value
     * @return S
     * @throws \InvalidArgumentException If N is not an integer-like.
     * @throws \InvalidArgumentException If N is negative
     */
    public function repeat($n)
    {
        return $this->times($n);
    }

    /**
     * Wraps the string to fit given width.
     *
     * If the curent string’s size equals or is less than size to fit the 
     * result, then nothing appens. If the string is greater than wanted with, 
     * then the string is wrapped.
     *
     * An example resulti using this method could be:
     *
     *     Tous les êtres
     *     humains naissent
     *     libres et égaux en
     *     dignité et en
     *     droits. Ils sont
     *     doués de raison et
     *     de conscience et
     *     doivent agir les
     *     uns envers les
     *     autres dans un
     *     esprit de
     *     fraternité.
     *
     * @param  int|N $width Width the text must have
     * @param  mixed $cut   Optional string to put at each linebreak, as
     *                      string-like
     * @return S
     * @throws \InvalidArgumentException If width is not an integer-like
     * @throws \InvalidArgumentException If cut is not a string-like
     */
    public function wrap($width = 79, $cut = PHP_EOL)
    {
        self::mustBeInteger($width, 'Width');
        self::mustBeString($cut, 'Cut');

        $arr_lines = array();

        if (strlen($this->value) === count($this)) {
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
     * This is greet for raw text outputs.
     *
     * This is a good complement of `S::wrap()` method.
     *
     * Example using all arguments, to have idea of available possibilities
     *
     *     $s = new S('Tous les…'); // long text
     *     echo 'First: ';
     *     echo $s->wrap(40)->margin(10, 0, -7);
     *
     * This example will print:
     *
     *     First:    Tous les êtres humains naissent libres
     *               et égaux en dignité et en droits. Ils
     *               sont doués de raison et de conscience
     *               et doivent agir les uns envers les
     *               autres dans un esprit de fraternité.
     *
     *
     * @param  mixed $left   Margin left (N or integer)
     * @param  mixed $right  Margin right, optional (N or integer)
     * @param  mixed $alinea First line, optional (N or integer)
     * @return S
     * @throws \InvalidArgumentException If margin left, margin right or alinea is not an integer-like.
     * @throws \InvalidArgumentException If margin left and/or right are negative
     * @throws \InvalidArgumentException If alinea is greater than margin left
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



    /**
     * Centers text to fit on given width, padding with spaces. 
     *
     * This is usefull for pure text output (email, console, content on `PRE` HTML tag…)
     * 
     * Example result:
     *
     *      Tous les êtres humains naissent libres 
     *       et égaux en dignité et en droits. Ils 
     *      sont doués de raison et de conscience  
     *        et doivent agir les uns envers les   
     *       autres dans un esprit de fraternité.  
     *
     *
     * @param int|N $width Width to fit. If not given, default used is 79 chars width.
     * @param mixed $cut Optional string-like at end of line to use. Default is `PHP_EOL`.
     * @return S
     * @throws \InvalidArgumentException If width is not an integer-like.
     * @throws \InvalidArgumentException If width is negative or null.
     * @throws \InvalidArgumentException If cut end of line string is not string-like.
     */
    public function center($width = 79, $cut = PHP_EOL)
    {
        self::mustBeInteger($width, 'Width');
        self::mustBeString($cut, 'Cut character');

        if (is_object($width)) {
            $width = $width->int;
        }

        if($width <= 0){
            throw new \InvalidArgumentException('Width cannot be null or negative!');
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
            throw new \InvalidArgumentException('Width cannot be null or negative!');
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
                $diff = $width - count($line);
                $words = $line->split('/\s/u');
                $nb_spaces = count($words) - 1 + $diff;
                $div = (double) $nb_spaces / (count($words) - 1);
                $div_floor = (int) floor($div);

                $missing = (count($words) - 1) * ($div - $div_floor);
                $sp_pad = $sp->times($div_floor);

                while ($words->valid()) {
                    if (!$words->is_last && count($sp_pad)) {
                        $s .= $words->current->append($sp_pad);

                        if ($missing > 0) {
                            $s .= $sp;
                            $missing--;
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

    /**
     * Splits the string using Regexp.
     *
     * Argument is a string-like value containing regexp matching the separator 
     * sued to split the string.
     *
     * Example:
     *
     *     $s = new S('This is a string to split');
     *     $s->explode('/\s+/'); // 'This', 'is', 'a', 'string', 'to' and ' split'
     * 
     * @see S::split() An alias
     * @see S::cut() Another alias
     * @param mixed $sep String-like regex 
     * @return A
     * @throws \InvalidArgumentException Regexp is void
     */
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


    /**
     * Splits the string using Regexp.
     *
     * @see S::explode() Original method
     * @param mixed $sep String-like regex 
     * @return A
     * @throws \InvalidArgumentException Regexp is void
     */
    public function split($sep)
    {
        return $this->explode($sep);
    }


    /**
     * Splits the string using Regexp.
     *
     * @see S::explode() Original method
     * @param mixed $sep String-like regex 
     * @return A
     * @throws \InvalidArgumentException Regexp is void
     */
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
     * _formatEngine 
     * 
     * @see S::format() Format feature is based on it
     * @see S::fmt() Format alias feature is based on it
     * @see S::sprintf() Format alias feature is based on it
     * @param mixed $args 
     * @return S
     */
    private function _formatEngine($args){
        $args_cnt = count($args);

        for ($i = 0; $i < $args_cnt; $i++) {
            $v = $args[$i];

            if ($v instanceof N) {
                $args[$i] = $v->value;
            } elseif (is_object($v) && method_exists($v, '__toString')) {
                $args[$i] = "$v";
            } elseif (!is_scalar($v)) {
                throw new \InvalidArgumentException(
                    'Arguments to use with S::format() must be scalar values '
                    .'or object having __toString() method.'
                );
            }
        }

        array_unshift($args, $this->value);

        return new self(call_user_func_array('sprintf', $args));
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
     * @see S::sprintf() Alias method
     * @see S::fmt() Other alias method
     * @param array|A|H $params Named of set of params to use if you want use other way than multi params. 
     * @return S
     * @throws \InvalidArgumentException If at least one argument is not a 
     * scalar or an object having `__toString()` method.
     */
    public function format($params = null)
    {
        $args = func_get_args();

        if(!is_null($params)){
            if($params instanceof A || $params instanceof H){
                $args = array_values($params->array); //beware of H case
            } elseif(is_array($params)){
                $args = $params;
            } 
        }

        return $this->_formatEngine($args);
    }


    /**
     * Use current string as format for given params, it is a `sprintf`-like (Alias).
     * 
     * @see S::format() Original method
     * @param array|A|H $params Named of set of params to use if you want use other way than multi params. 
     * @return S
     * @throws \InvalidArgumentException If at least one argument is not a 
     * scalar or an object having `__toString()` method.
     */
    public function sprintf($params = null)
    {
        $args = func_get_args();

        if(!is_null($params)){
            if($params instanceof A || $params instanceof H){
                $args = array_values($params->array); //beware of H case
            } elseif(is_array($params)){
                $args = $params;
            } 
        }

        return $this->_formatEngine($args);
    }


    /**
     * Use current string as format for given params, it is a `sprintf`-like (Alias).
     * 
     * @see S::format() Original method
     * @param array|A|H $params Named of set of params to use if you want use other way than multi params. 
     * @return S
     * @throws \InvalidArgumentException If at least one argument is not a 
     * scalar or an object having `__toString()` method.
     */
    public function fmt($params = null)
    {
        $args = func_get_args();

        if(!is_null($params)){
            if($params instanceof A || $params instanceof H){
                $args = array_values($params->array); //beware of H case
            } elseif(is_array($params)){
                $args = $params;
            } 
        }

        return $this->_formatEngine($args);
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

    /**
     * Checks whether the whole string is right to left.
     *
     * Some languages, like Arabic language, writes their sentences from right 
     * to left. 
     *
     * This method allows you to check is whole content of the string is 
     * written right to left.
     *
     * This method is used only throught magic getters. Let’s see some examples:
     *
     *     $s = new S('أبجد');
     *     var_dump($s->rtl); // true
     *     var_dump($s->is_rtl); // true
     *     var_dump($s->is_right_to_left); // true
     *     var_dump($s->right_to_left); // true
     *     
     * @see S::$rtl Magic getter `S::$rtl`
     * @see S::$is_rtl Magic getter `S::$is_rtl`
     * @see S::$is_right_to_left Magic getter `S::$is_right_to_left`
     * @see S::$right_to_left Magic getter `S::$right_to_left`
     *
     * @see S::_ltr() The opposite case, left to right.
     *
     * @return boolean
     */
    protected function _rtl()
    {
        $this->_chars()->rewind();

        while ($this->_chars()->valid) {
            if($this->_chars()->current()->ltr) return false;
            $this->_chars()->next;
        }

        return true;
    }


    /**
     * Checks whether the whole string is written from the left to the right.
     *
     * Many languages are written from left or right, but some other not. So, 
     * this method tests if the current string is LTR.
     *
     * This method is used only throught magic getters. Let’s see some examples:
     *
     *     $s = new S('Je suis écrit en français !');
     *     var_dump($s->ltr); // true
     *     var_dump($s->is_ltr); // true
     *     var_dump($s->is_left_to_right); // true
     *     var_dump($s->left_to_right); // true
     *     
     * @see S::$ltr Magic getter `S::$ltr`
     * @see S::$is_ltr Magic getter `S::$is_ltr`
     * @see S::$is_left_to_right Magic getter `S::$is_left_to_right`
     * @see S::$left_to_right Magic getter `S::$left_to_right`
     *
     * @see S::_rtl() The opposite case, right to left.
     *
     * @return boolean
     */
    protected function _ltr()
    {
        $this->_chars()->rewind();

        while ($this->_chars()->valid) {
            if($this->_chars()->current()->rtl) return false;
            $this->_chars()->next;
        }

        return true;
    }

    /**
     * Tests whether the current string has both RTL and LTR parts
     *
     * This is runtime version for some magic getters. This returns `true` if, 
     * for example, the string contains both french and arabic text.
     *
     *     $s = new S(
     *         'Ceci est du français contenant le mot '
     *         .'arabe أبجد qui veut dire "abjad".'
     *         );
     *     var_dump($s->has_mixed_direction); // true
     *     var_dump($s->mixed_direction); // true
     *     var_dump($s->is_ltr_and_rtl); // true
     *     var_dump($s->ltr_and_rtl); // true
     *     var_dump($s->is_rtl_and_ltr); // true
     *     var_dump($s->rtl_and_ltr); // true 
     *
     * @see S::_rtl() Checks whether it is right to left
     * @see S::_ltr() Checks whether it is left to right
     * @see S::$has_mixed_direction Magic getters `S::$has_mixed_direction`
     * @see S::$mixed_direction Magic getters `S::$mixed_direction`
     * @see S::$is_ltr_and_rtl Magic getters `S::$is_ltr_and_rtl`
     * @see S::$ltr_and_rtl Magic getters `S::$ltr_and_rtl Magic getters`
     * @see S::$is_rtl_and_ltr Magic getters `S::$is_rtl_and_ltr`
     * @see S::$rtl_and_ltr Magic getters `S::$rtl_and_ltr`
     *
     * @return boolean
     */
    protected function _hasMixedDirection()
    {
        return !$this->_rtl() && !$this->_ltr();
    }

    /**
     * Compute the MD5 sum of the string.
     *
     * This method compute the MD5 sum of its internal value and returns the 
     * result as a `\Malenki\Bah\S` object.
     *
     * Example:
     *
     *     $s = new S('Hello!');
     *     print($s->md5); // '952d2c56d0485958336747bcdd98590d'
     *
     * @see http://php.net/manual/en/function.md5.php Orignal md5() PHP function
     * @see S::$md5 Defines the magic getter `S::$md5`
     * @return S
     */
    protected function _md5()
    {
        return new S(md5($this->value));
    }


    /**
     * Compute the SHA1 sum of the string.
     *
     * This method compute the SHA1 sum of its internal value and returns the 
     * result as a `\Malenki\Bah\S` object.
     *
     * Example:
     *
     *     $s = new S('Hello!');
     *     print($s->sha1); // '69342c5c39e5ae5f0077aecc32c0f81811fb8193'
     *
     * @see http://php.net/manual/en/function.sha1.php Orignal sha1() PHP function
     * @see S::$sha1 Defines the magic getter `S::$sha1`
     * @return S
     */
    protected function _sha1()
    {
        return new S(sha1($this->value));
    }

    /**
     * Add new CR, LF, CRLF or PHP_EOL before or after the string.
     *
     * This is used as engine for several methods and magic getters into this class.
     *
     * As first argument, it takes string to define the new line: `\n`, `\r`, 
     * `\r\n` or `PHP_EOL`. The second argument is boolean: `true` (default) 
     * puts the new line after the string, `false` puts he new line at the 
     * beginning of the string.
     * 
     * @param string $type One of this string: `\n`, `\r`, `\r\n` or `PHP_EOL`.
     * @param boolean $after Set to `false` to put new line before rather than 
     * after as default.
     * @return S
     */
    private function _nl($type, $after = true)
    {
        if ($after) {
            return new self($this->value . $type);
        } else {
            return new self($type . $this->value);
        }
    }

    /**
     * Add new line as LF.
     *
     * This is shorthand to avoid concatenating Line Feed character to the 
     * current string.
     *
     * It can be used as magic getter to, in this case, appending way is used.
     *
     * Examples:
     *
     *     $s = new S('azerty');
     *     echo "$s\n"; // "azerty\n"
     *     echo $s . "\n"; // "azerty\n"
     *     echo $s->n; // "azerty\n"
     *     echo $s->n(false); // "\nazerty"
     *
     * @see S::$n Magic getter version
     * @see S::r() Its brother CR
     * @see S::eol() Its brother PHP_EOL
     * @see S::rn() Its brother CRLF
     * @param  boolean  $after If false, put new line before the string
     * @return S
     */
    public function n($after = true)
    {
        return $this->_nl("\n", $after);
    }


    /**
     * Add new line as CR.
     *
     * This is shorthand to avoid concatenating CR aka Cariage Return to the 
     * current string.
     *
     * It can be used as magic getter to, in this case, appending way is used.
     *
     * Examples:
     *
     *     $s = new S('azerty');
     *     echo "$s\r"; // "azerty\r"
     *     echo $s . "\r"; // "azerty\r"
     *     echo $s->r; // "azerty\r"
     *     echo $s->r(false); // "\razerty"
     *
     * @see S::$r Magic getter version
     * @see S::n() Its brother LF
     * @see S::eol() Its brother PHP_EOL
     * @see S::rn() Its brother CRLF
     * @param  boolean  $after If false, put new line before the string
     * @return S
     */
    public function r($after = true)
    {
        return $this->_nl("\r", $after);
    }

    
    /**
     * Add PHP_EOL at the end or at the beginning. 
     * 
     * This is shorthand to avoid concatenating PHP_EOL used by the system 
     * to the current string.
     *
     * It can be used as magic getter to, in this case, appending way is used.
     *
     * Examples (`PHP_EOL == "\n"`):
     *
     *     $s = new S('azerty');
     *     echo $s . PHP_EOL; // "azerty\n"
     *     echo $s->eol; // "azerty\n"
     *     echo $s->eol(false); // "\nazerty"
     *
     * @see S::$eol Magic getter version
     * @see S::n() Its brother LF
     * @see S::r() Its brother CR
     * @see S::rn() Its brother CRLF
     * @param  boolean  $after If false, put new line before the string
     * @return S
     */
    public function eof($after = true)
    {
        return $this->_nl(PHP_EOL, $after);
    }
    
    /**
     * Add CRLF sequence at the end or at the beginning. 
     * 
     * This is shorthand to avoid concatenating CRLF aka Cariage Return Line 
     * Feed to the current string.
     *
     * It can be used as magic getter to, in this case, appending way is used.
     *
     * Examples:
     *
     *     $s = new S('azerty');
     *     echo "$s\r\n"; // "azerty\r\n"
     *     echo $s . "\r\n"; // "azerty\r\n"
     *     echo $s->rn; // "azerty\r\n"
     *     echo $s->rn(false); // "\r\nazerty"
     *
     * @see S::$rn Magic getter version
     * @see S::n() Its brother LF
     * @see S::r() Its brother CR
     * @see S::eol() Its brother PHP_EOL
     * @param  boolean  $after If false, put new line before the string
     * @return S
     */
    public function rn($after = true)
    {
        return $this->_nl("\r\n", $after);
    }

}

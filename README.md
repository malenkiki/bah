# BAH!

[![Build Status](https://travis-ci.org/malenkiki/bah.svg?branch=master)](https://travis-ci.org/malenkiki/bah) [![Latest Stable Version](https://poser.pugx.org/malenki/bah/v/stable.svg)](https://packagist.org/packages/malenki/bah) [![Total Downloads](https://poser.pugx.org/malenki/bah/downloads.svg)](https://packagist.org/packages/malenki/bah) [![Latest Unstable Version](https://poser.pugx.org/malenki/bah/v/unstable.svg)](https://packagist.org/packages/malenki/bah) [![License](https://poser.pugx.org/malenki/bah/license.svg)](https://packagist.org/packages/malenki/bah)<a href="https://flattr.com/submit/auto?user_id=malenki&url=https%3A%2F%2Fgithub.com%2Fmalenkiki%2Fbah" target="_blank"><img src="//api.flattr.com/button/flattr-badge-large.png" alt="Flattr this" title="Flattr this" border="0"></a>

Bah! It is just a little set of simple PHP classes to play with **strings**, **numbers**, **characters**, **arrays** and **hashes**.

Each class is designed to be used in many different ways, using **magic getters**, **magic setters**, or **methods**.

When it is possible, **chaining methods** (and then **magic getters** too) are available.


## Play with strings

Better than long blahblah, a small example is better to understand feature or class `S`.

Implementation, simple, just put a string as argument:

```php
$greek = new S('Τα ελληνικά σου είναι καλύτερα απο τα Γαλλικά μου!');
```

Shorthand method to have return at the end of the string:

```php
echo $greek; // 'Τα ελληνικά σου είναι καλύτερα απο τα Γαλλικά μου!'
```

Uppercases:

```php
echo $greek->upper; // ΤΑ ΕΛΛΗΝΙΚΆ ΣΟΥ ΕΊΝΑΙ ΚΑΛΎΤΕΡΑ ΑΠΟ ΤΑ ΓΑΛΛΙΚΆ ΜΟΥ!
```

Lowercases:

```php
echo $greek->lower; // τα ελληνικά σου είναι καλύτερα απο τα γαλλικά μου!
```

Capitalize first letter of each words:

```php
echo $greek->title; // Τα Ελληνικά Σου Είναι Καλύτερα Απο Τα Γαλλικά Μου!
```

Swap cases from previous returned string:
```php
echo $greek->title->swap; // τΑ εΛΛΗΝΙΚΆ σΟΥ εΊΝΑΙ κΑΛΎΤΕΡΑ αΠΟ τΑ γΑΛΛΙΚΆ μΟΥ!
```

Get string length. The returned object is \Malenki\Bah\N having `toString()` method, so can be used too into string context:

```php
echo $greek->length; // 50
```

Get lower Camel Case:
```php
echo $greek->lcc; // ταΕλληνικάΣουΕίναιΚαλύτεραΑποΤαΓαλλικάΜου
```

Get Upper Camel Case:
```php
echo $greek->ucc; // ΤαΕλληνικάΣουΕίναιΚαλύτεραΑποΤαΓαλλικάΜου
```

Get dashed version:
```php
echo $greek->dash; // τα-ελληνικά-σου-είναι-καλύτερα-απο-τα-γαλλικά-μου
```

Get underscore version:
```php
echo $greek->underscore; // τα_ελληνικά_σου_είναι_καλύτερα_απο_τα_γαλλικά_μου
```

Get transliterated version:
```php
$greek->trans; // Ta ellenika sou einai kalytera apo ta Gallika mou!
```

Get some combined previous effects together:
```php
echo $greek->lcc->trans; // taEllenikaSouEinaiKalyteraApoTaGallikaMou 
```

Get first character:
```php
echo $greek->first; // Τ
```

Get last character:
```php
echo $greek->last; // !
```

Squeeze duplicate characters:
```php
$s = new S('azzertyy');
echo $s->squeeze; // azerty
```

Choose characters to squeeze:
```php
$s = new S('aaazzertyy');
echo $s->squeeze('za'); // azertyy
```


Takes first four chars and add new line:

```php
echo $greek->sub(4)->n;
```

Characters amount, as a string, new line added:

```php
echo $greek->chars->length->to_s->n;
```

Bytes amount, as a string, new line added:

```php
echo $greek->bytes->length->to_s->n;
```

Wrapping and margin a long string:

```php
$long = new S('Put a very long string here…');
echo $long->wrap(20)->n->n;
echo $long->wrap(30)->n->n;
echo $long->wrap(40)->n->n;
echo $long->wrap(80)->n->n;
echo $long->wrap(80)->ucw->n->n; // with upper case words
echo 'First: ';
// margin left 10 chars length, right 0, first -7 to place the previous string "First: "
echo $long->wrap(40)->margin(10, 0, -7)->n->n;
echo $long->wrap(40)->margin(10)->n->n; // same as previous, but only left margin
```

You can transliterate string to simple one:

```php
$s = new S('Τα ελληνικά σου είναι καλύτερα απο τα Γαλλικά μου!');
echo $s->trans->n; // Ta ellenika sou einai kalytera apo ta Gallika mou!
```

You can test if string is full RTL (Right To Left):

```php
$s = new S('أبجد');
var_dump($s->rtl); // true
var_dump($s->is_rtl); // true
var_dump($s->is_right_to_left); // true
var_dump($s->right_to_left); // true
```

You can test if string is full LTR (Left To Right):

```php
$s = new S('Ceci est du français tout à fait banal.');
var_dump($s->ltr); // true
var_dump($s->is_ltr); // true
var_dump($s->is_left_to_right); // true
var_dump($s->left_to_right); // true
```

You can test if string has part in LTR and part in RTL:

```php
$s = new S('Ceci est du français contenant le mot arabe أبجد qui veut dire "abjad".');
var_dump($s->has_mixed_direction); // true
var_dump($s->mixed_direction); // true
var_dump($s->is_ltr_and_rtl); // true
var_dump($s->ltr_and_rtl); // true
var_dump($s->is_rtl_and_ltr); // true
var_dump($s->rtl_and_ltr); // true
```

## Play with characters

You can play with characters too:

```php
$c = new C("€");
while($c->bytes->valid())
{
    // for each bytes, print it as binary string and add new line
    echo $c->bytes->current()->b->n;
    $c->bytes->next();
}
```

Get all chars of the unicode block of the current char, joined by comma:

```php
$c = new C("Œ");
echo $c->family->join(', ');
/*
Ā, ā, Ă, ă, Ą, ą, Ć, ć, Ĉ, ĉ, Ċ, ċ, Č, č, Ď, ď, Đ, đ, Ē, ē,
Ĕ, ĕ, Ė, ė, Ę, ę, Ě, ě, Ĝ, ĝ, Ğ, ğ, Ġ, ġ, Ģ, ģ, Ĥ, ĥ, Ħ, ħ,
Ĩ, ĩ, Ī, ī, Ĭ, ĭ, Į, į, İ, ı, Ĳ, ĳ, Ĵ, ĵ, Ķ, ķ, ĸ, Ĺ, ĺ, Ļ,
ļ, Ľ, ľ, Ŀ, ŀ, Ł, ł, Ń, ń, Ņ, ņ, Ň, ň, ŉ, Ŋ, ŋ, Ō, ō, Ŏ, ŏ,
Ő, ő, Œ, œ, Ŕ, ŕ, Ŗ, ŗ, Ř, ř, Ś, ś, Ŝ, ŝ, Ş, ş, Š, š, Ţ, ţ,
Ť, ť, Ŧ, ŧ, Ũ, ũ, Ū, ū, Ŭ, ŭ, Ů, ů, Ű, ű, Ų, ų, Ŵ, ŵ, Ŷ, ŷ,
Ÿ, Ź, ź, Ż, ż, Ž, ž, ſ
*/
```

Get Unicode Block name of the current char:

```php
$c = new C("Œ");
echo $c->block; // Latin Extended-A
```

You can transliterate character to simple one:

```php
$s = new C('λ');
echo $C->trans; // "l"
```

You can test whether character ir right to left or left to right (RTL/LTR):

```php
$c = new C('ش');
var_dump($c->rtl); // true
var_dump($c->is_rtl); // true
var_dump($c->is_right_to_left); // true
var_dump($c->right_to_left); // true
var_dump($c->ltr); // false
var_dump($c->is_ltr); // false
var_dump($c->is_left_to_right); // false
var_dump($c->left_to_right); // false
```

## Play with Array

Get count of an array and get the last but one easily:

```php
$a = new A(array('un', 'deux', 'trois', 'quatre'));
var_dump(count($a));
var_dump($a->last_but_one);
```

Getting Some content is simple, using method or magick getters:

```php
$a = new A(array('zéro', 'un', 'deux', 'trois', 'quatre'));
echo $a->take(2); // 'deux'
// or
echo $a->index_2;
// or
echo $a->key_2;
```

Get new collection from existing one but into other order:

```php
$a = new A(array('un', 'deux', 'trois', 'quatre'));
var_dump($a->shuffle); //randomize
var_dump($a->sort); //sort ascendently
var_dump($a->reverse); //reverse order
var_dump($a->sort->reverse); // sort and then reverse it
```

Get new collection following some criterias for its indexes, using the same way as used into `test()` method of N class (excepted `odd` and `even` added here):
```php
$a = new A('foo', 'bar', 'thing', 'other');
$a->find('>= 2'); // has 'thing' and 'other'
$a->find('odd'); // has 'bar' and 'other'
```

Get random element from a collection:

```php
$a = new A(array('un', 'deux', 'trois', 'quatre'));
var_dump($a->random);
// or
var_dump($a->random(1));
```

Get several random elements from a collection:

```php
$a = new A(array('un', 'deux', 'trois', 'quatre'));
var_dump($a->random(2));
```

Concatenate elements into a string object from class S:

```php
$a = new A(array('un', 'deux', 'trois', 'quatre'));
var_dump($a->join);
//or
var_dump($a->implode);
```

Concatenate elements into a string object from class S using custom separator:

```php
$a = new A(array('un', 'deux', 'trois', 'quatre'));
var_dump($a->join(', '));
//or
var_dump($a->implode(', '));
```

Take value one by one is easy:

```php
$a = new A(array('un', 'deux', 'trois', 'quatre'));

while($a->valid) // you can use method call too
{
    echo $a->current . "\n";
    $a->next;
}
```



## Play with numbers

Instanciate number, add, sub, div…

```php
$five = new N(5);
$two = new N(2);

echo $five->plus(2); // native number or N object
echo $five->minus($two);
echo $five->divide(2);
```

Test whether number is positive, negative or zero:

```php
$five = new N(5);
$two = new N(2);

var_dump($two->minus($five)->negative); //should be true
var_dump($two->minus(2)->zero); //should be true
var_dump($two->positive); //should be true
```

Get number (as integer) into another base as S object:

```php
$n = new N(1979);

echo $n->base(2); // get "11110111011"
echo $n->base(3); // get "2201022"
echo $n->base(34); // get "1o7"
```

For base convert, you have some shorthands for **binary**, **octal** and **hexadecimal**:

```php
$n = new N(1979);

// binary
echo $n->bin;
// or
echo $n->b;

// octal
echo $n->oct;
// or
echo $n->o;

// hexadecimal
echo $n->hex;
// or
echo $n->h;


```

Odd or even?

```php
$n = new N(3);
var_dump($n->odd);
var_dump($n->even);
$n = new N(4);
var_dump($n->odd);
var_dump($n->even);
```

Testing numbers, many ways:

```php
$n = new N(5);
var_dump($n->gt(3)); // true
var_dump($n->lt(3)); // false
var_dump($n->eq(5)); // true
var_dump($n->neq(3)); // true
var_dump($n->test('>= 3')); // true
```
For very last previous example, `test()` method can use all following operators:
 - `<`, `>`, `lt` and `gt` for _less than_ or _greater than_
 -  `<=`, `>=`, `le` and `ge` for _less than or equal_ or _greater than or equal_
 -  `=`, `==`, `eq` for _equal_
 - `!=`, `<>`, `no`, `neq` for _not equal_

Get decimal part:
```php
$n = new N(4.3);
var_dump($n->decimal); // N object having 0.3 as value
```

You can get roman or greek form:

```php
$five = new N(5);

print($five->roman);
print($five->greek);
```

Some more other numeral systems are available as bonus. For example Chinese Mandarin numerals for integer or decimal, negative or positive nimbers is ready to use (Simplified Chinese only yet):

```php
$n = new N(123456); // will be '十二兆三千四百五十六'
echo $n->chinese();
// or
echo $n->chinese;
// or
echo $n->mandarin;
// or
echo $n->putonghua;
```

Decimal numbers as example now:

```php
$n = new N(16.98); // Will be '十六点九八'
echo $n->chinese;
```

Negative numbers now:

```php
$n = new N(-16.98); // Will be '负十六点九八'
echo $n->chinese;
```

In Mandarin, you have two ways to display Zero: **零** or **〇**. To use the second form, just call `chinese()` method with argument `true` or use some modified magic getters:

```php
$n = new N(208);
echo  $n->chinese(true); // Will be '二百〇八'
echo  $n->chinese_other_zero; // Will be '二百〇八'
echo  $n->mandarin_other_zero; // Will be '二百〇八'
echo  $n->putonghua_other_zero; // Will be '二百〇八'
// but:
echo  $n->chinese(); // Will be '二百零八'
echo  $n->chinese; // Will be '二百零八'
echo  $n->mandarin; // Will be '二百零八'
echo  $n->putonghua; // Will be '二百零八'
```

## Play with Hash

You can use Hash, an array with named keys.

Setting value can be done using two different ways:

```php
$h = new H();
$h->set('my_key', 'My Value');
// or
$y->my_key = 'My Value';
```
Getting value use same ways:

```php
$h->get('my_key'); // 'My Value'
// or
echo $h->my_key; // 'My Value'
```

Deleting too:

```php
$h->delete('my_key');
// or
unset($h->my_key);
```

Parsing content is simple, it is like A class, but with a little add to have key too:

```php
$h = new H(array('one' => 1, 'two' => 2, 'three' => 3, 'four' => 4));

while($h->valid)
{
    printf(
        "key: %s => value: %d\n",
        $h->current->key,
        $h->current->value
    );
    $h->next;
}
```

Finding contents having key matching some pattern:

```php
$h = new H(array('one' => 1, 'two' => 2, 'three' => 3, 'four' => 4));

$arr = $h->find('/[o]+/');
var_dump($arr); // array('one' => 1, 'two' => 2, 'four' => 4)
```


## Converting to primitive types

Very easy, a magic getter is available to get more meaning type for each class, so:

 - class `Malenki\Bah\N` has `int`, `float` and `double`
 - class `Malenki\Bah\S` has `string`
 - class `Malenki\Bah\A` has `array`
 - class `Malenki\Bah\H` has `array`
 - class `Malenki\Bah\C` has `string`

Quick example:

```php
$s = new S('This is a string');
var_dump($s->length); // object N
var_dump($s->length->int); // integer
```

## More

See `example.php` and run it to understand many of the available features.

## MIT Open Source License

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

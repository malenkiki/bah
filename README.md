# BAH!

Bah! It is just a little set of simple PHP classes to play with collections of strings, numbers and characters.


## Play with strings

Better than long blahblah, a small example is better to understand feature or class `S`.

Implementation, simple, just put a string as argument:

```php
$greek = new S('Τα ελληνικά σου είναι καλύτερα απο τα Γαλλικά μου!');
```

Shorthand method to have return at the end of the string:

```php
echo $greek->n;
```

Uppercases + new line:

```php
echo $greek->upper->n;
```

Lowercases + new line:

```php
echo $greek->lower->n;
```

Capitalize first letter of each words + new line:

```php
echo $greek->title->n;
```

Get string length, convert to string and then add new line:

```php
echo $greek->length->s()->n;
```

Takes first four chars and add new line:

```php
echo $greek->sub(4)->n;
```

Characters amount, as a string, new line added:

```php
echo $greek->chars->length->s()->n;
```

Bytes amount, as a string, new line added:

```php
echo $greek->bytes->length->s()->n;
```

Wrapping and margin a long string:

```php
$long = new S('Put a very long string here…');
echo $long->wrap(20)->n->n;
echo $long->wrap(30)->n->n;
echo $long->wrap(40)->n->n;
echo $long->wrap(80)->n->n;
echo $long->wrap(80)->upperCaseWords()->n->n;
echo 'First: ';
// margin left 10 chars length, right 0, first -7 to math the previous string "First: "
echo $long->wrap(40)->margin(10, 0, -7)->n->n;
```

## Play with characters

You can play with characters too:

```php
$c = new C("€");
while($c->bytes->valid())
{
    // for each bytes, print it as binary string and add new line
    echo $c->bytes->current()->b()->n;
    $c->bytes->next();
}
```

Get all chars of the unicode block of the current char:

```php
$c = new C("Œ");
$all = $c->allCharsOfItsBlock();

while($all->valid())
{
    echo $all->current();
    echo ' ';
    $all->next();
}
```

Get Unicode Block name of the current char:

```php
$c = new C("Œ");
echo $c->block->n;
```

## Play with Array

Get count of an array and get the last but one easily:

```php
$a = new A(array('un', 'deux', 'trois', 'quatre'));
var_dump(count($a));
var_dump($a->lastButOne);
```

See `example.php` and run it to understand all methods.

More blahblah soon…

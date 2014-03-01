# BAH!

Bah! It is just a little set of simple PHP classes to play with collections of strings, numbers and characters.


## Play with strings

Better than long blahblah, a small example is better to understand feature or class `S`:

```php
//implementation, simple, just put a string as argument
$greek = new S('Τα ελληνικά σου είναι καλύτερα απο τα Γαλλικά μου!');

// Shorthand method to have return at the end of the string
echo $greek->n();

// Uppercases + new line
echo $greek->upper()->n();

// lowercases + new line
echo $greek->lower()->n();

// Capitalize first letters of each words + new line
echo $greek->title()->n();

// Get string length, convert to string and then add new line:
echo $greek->length->s()->n();

// Takes first four chars and add new line
echo $greek->sub(4)->n();

// Characters amount, as a string, new line added
echo $greek->chars->length()->s()->n();

// Bytes amount, as a string, new line added.
echo $greek->bytes->length()->s()->n();
```

## Play with characters

You can play with characters too:

```php
$c = new C("€");
while($c->bytes->valid())
{
    // for each bytes, print it as binary string and add new line
    echo $c->bytes->current()->b()->upper()->n();
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
echo $c->block()->n();
```

More blahblah soon…

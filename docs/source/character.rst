Characters as object with C class
=================================


Bytes
~~~~~

Characters are composed of bytes, you can get them as `\\Malenki\\Bah\\N`
(Number objects) through an iterable collection like this:

.. code-block:: php

   $c = new C("€");
   while($c->bytes->valid())
   {
     // for each bytes, print it as binary string and add new line
     echo $c->bytes->current()->b . PHP_EOL;
     $c->bytes->next();
   }
   
   /*
   11100010
   10000010
   10101100
   */


Family
~~~~~~

In UTF8, a character belongs a family, or a block. You can get all available
characters of the unicode block of the current character. To be more readable
in output, the result is joined by comma:

.. code-block:: php

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


In addition to get all characters of an Unicode Block, you can get the name of
the current family:

.. code-block:: php

   $c = new C("Œ");
   echo $c->block;
   // Latin Extended-A


Transliteration
~~~~~~~~~~~~~~~

You can transliterate character to simple one:

.. code-block:: php

   $s = new C('λ');
   echo $C->trans;
   // "l"


RTL or LTR?
~~~~~~~~~~~

You can test whether character is right to left or left to right (RTL/LTR):

.. code-block:: php

   $c = new C('ش');
   var_dump($c->rtl); // true
   var_dump($c->is_rtl); // true
   var_dump($c->is_right_to_left); // true
   var_dump($c->right_to_left); // true
   var_dump($c->ltr); // false
   var_dump($c->is_ltr); // false
   var_dump($c->is_left_to_right); // false
   var_dump($c->left_to_right); // false



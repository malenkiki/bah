Play with strings using S class
===============================

Cases
~~~~~

One thing you do often with strings, is to changes their cases. Sometimes you
want titlize, sometimes you want put all characters in uppercase, ou lowercase!
So, let's see what we can do with the following strarting point using greek
sentence.

.. code-block:: php

   $greek = new S('Τα ελληνικά σου είναι καλύτερα απο τα Γαλλικά μου!');

Converting all the string in uppercases is as simple as calling this:

.. code-block:: php

   echo $greek->upper;
   // ΤΑ ΕΛΛΗΝΙΚΆ ΣΟΥ ΕΊΝΑΙ ΚΑΛΎΤΕΡΑ ΑΠΟ ΤΑ ΓΑΛΛΙΚΆ ΜΟΥ!

Using the same way, you get lowercases:

.. code-block:: php

   echo $greek->lower;
   // τα ελληνικά σου είναι καλύτερα απο τα γαλλικά μου!

If the string need to be capitalized, just do it:

.. code-block:: php

   echo $greek->title;
   // Τα Ελληνικά Σου Είναι Καλύτερα Απο Τα Γαλλικά Μου!

So, it is time to have some fun, we can swap case!

.. code-block:: php

   echo $greek->title->swap;
   // τΑ εΛΛΗΝΙΚΆ σΟΥ εΊΝΑΙ κΑΛΎΤΕΡΑ αΠΟ τΑ γΑΛΛΙΚΆ μΟΥ!

Slug
~~~~

Slugs can have multiple definitions: Differents cases (Camel cases), all lower
and word separated by underscore or hyphen, transliteration enabled or not, and
others.

So, classical slug, all in lower case, words separated by **hyphen**, is as simple
as this:

.. code-block:: php

   echo $greek->dash;
   // τα-ελληνικά-σου-είναι-καλύτερα-απο-τα-γαλλικά-μου

The same way you get version using **underscores**:

.. code-block:: php

   echo $greek->underscore;
   // τα_ελληνικά_σου_είναι_καλύτερα_απο_τα_γαλλικά_μου

.. note::

   To have real slug, without non ascii characters, you can chain with `trans`.


Length
~~~~~~

Get length of the string, in other word, the *number of characters* used to
composed the string, and not number of bytes used in memory.

.. code-block:: php

   echo $greek->length;
   // 50

.. attention::
   The returned value is not in integer as PHP internal type, but an object
   `\\Malenki\\Bah\\N` dedicated to numeric values, display here because of its
   `__toString()` method.

To get bytes used, you can simply do that:

.. code-block:: php

   echo $greek->bytes->length;
   
Is it RTL or LTR?
~~~~~~~~~~~~~~~~~

Some languages, like Arab or Hebrew, write text from right to left (RTL), while
other like english, write text from left to right (LTR). This is important to
know in some context, so, it may be very usefull to guess whether a text is RTL
or not.

First, you can test if a string is **full right to left**:

.. code-block:: php

   $s = new S('أبجد');
   var_dump($s->rtl); // true
   var_dump($s->is_rtl); // true
   var_dump($s->is_right_to_left); // true
   var_dump($s->right_to_left); // true
   
Second, you can check if a string is **full left to right**:

.. code-block:: php

   $s = new S('Ceci est du français tout à fait banal.');
   var_dump($s->ltr); // true
   var_dump($s->is_ltr); // true
   var_dump($s->is_left_to_right); // true
   var_dump($s->left_to_right); // true
   
Third, you can check if a string contains **both directions**, left to right and right to left:

.. code-block:: php

   $s = new S('Ceci est du français contenant le mot arabe أبجد qui veut dire "abjad".');
   var_dump($s->has_mixed_direction); // true
   var_dump($s->mixed_direction); // true
   var_dump($s->is_ltr_and_rtl); // true
   var_dump($s->ltr_and_rtl); // true
   var_dump($s->is_rtl_and_ltr); // true
   var_dump($s->rtl_and_ltr); // true
   
HTML rendering helper
~~~~~~~~~~~~~~~~~~~~~

You can quickly create text surrounded by XML tag using notation ala jQuery:

.. code-block:: php

   $s = new S('Foo');
   echo $s->tag('p strong.bar');
   // '<p><strong class="bar">Foo</strong></p>'
   


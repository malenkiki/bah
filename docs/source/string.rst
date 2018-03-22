Play with strings using S class
===============================

Cases
~~~~~

One thing you do often with strings, is to changes their cases. Sometimes you
want titlize, sometimes you want put all characters in uppercase, ou lowercase!
So, let's see what we can do with the following strarting point using greek
sentence.

.. code-block:: php

   <?php
   $greek = new S('Τα ελληνικά σου είναι καλύτερα απο τα Γαλλικά μου!');

Converting all the string in uppercases is as simple as calling this:

.. code-block:: php

   <?php
   echo $greek->upper;
   // ΤΑ ΕΛΛΗΝΙΚΆ ΣΟΥ ΕΊΝΑΙ ΚΑΛΎΤΕΡΑ ΑΠΟ ΤΑ ΓΑΛΛΙΚΆ ΜΟΥ!

Using the same way, you get lowercases:

.. code-block:: php

   <?php
   echo $greek->lower;
   // τα ελληνικά σου είναι καλύτερα απο τα γαλλικά μου!

If the string need to be capitalized, just do it:

.. code-block:: php

   <?php
   echo $greek->title;
   // Τα Ελληνικά Σου Είναι Καλύτερα Απο Τα Γαλλικά Μου!

So, it is time to have some fun, we can swap case!

.. code-block:: php

   <?php
   echo $greek->title->swap;
   // τΑ εΛΛΗΝΙΚΆ σΟΥ εΊΝΑΙ κΑΛΎΤΕΡΑ αΠΟ τΑ γΑΛΛΙΚΆ μΟΥ!

Slug
~~~~

Slugs can have multiple definitions.

Length
~~~~~~

Get length of the string, in other word, the number of characters used to
composed the string, and no number of bytes used in memory.

.. code-block:: php

   <?php
   echo $greek->length;
   // 50

.. attention::
   The returned value is not in integer as PHP internal type, but an object
   `\\Malenki\\Bah\\N` dedicated to numeric values, display here because of its
   `__toString()` method.



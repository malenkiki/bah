Numbers are fun with N class
=============================

Calculus
~~~~~~~~

TODO

Testing
~~~~~~~

Testing numbers, many ways:

.. code-block:: php

   $n = new N(5);
   var_dump($n->gt(3)); // true
   var_dump($n->lt(3)); // false
   var_dump($n->eq(5)); // true
   var_dump($n->neq(3)); // true
   var_dump($n->test('>= 3')); // true


For very last previous example, `test()` method can use all following operators:

======================= =====================
Code                    Meaning
======================= =====================
`<`, `lt`               less than
`>`, `gt`               greater than
`<=`, `le`              less than or equal
`>=`, `ge`              greater than or equal
`=`, `==`, `eq`         equal
`!=`, `<>`, `no`, `neq` not equal
======================= =====================

Base convertions
~~~~~~~~~~~~~~~~

Get number (as integer) into **another base** as String object:

.. code-block:: php

   $n = new N(1979);

   echo $n->base(2); // get "11110111011"
   echo $n->base(3); // get "2201022"
   echo $n->base(34); // get "1o7"


For base convert, you have some shorthands for **binary**, **octal** and
**hexadecimal**:

.. code-block:: php

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

Other representations
~~~~~~~~~~~~~~~~~~~~~

TODO

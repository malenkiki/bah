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

include('src/Malenki/Bah/O.php');
include('src/Malenki/Bah/N.php');
include('src/Malenki/Bah/A.php');
include('src/Malenki/Bah/S.php');
include('src/Malenki/Bah/C.php');

use Malenki\Bah\O;
use Malenki\Bah\N;
use Malenki\Bah\A;
use Malenki\Bah\S;
use Malenki\Bah\C;

$s = new S('C’est cool !');
$c = new C("€");
//print($s->chars()->last());
while($c->bytes->valid())
{
    echo $c->bytes->current()->b()->upper()->n();
    $c->bytes->next();
}

$greek = new S('Τα ελληνικά σου είναι καλύτερα απο τα Γαλλικά μου!');
echo $greek->n();
echo $greek->upper()->n();
echo $greek->lower()->n();
echo $greek->title()->n();
echo $greek->length()->s()->n();
echo $greek->sub(4)->n();
echo $greek->chars->length()->s()->n();
echo $greek->bytes->length()->s()->n();

$a = new A(array('un', 'deux', 'trois', 'quatre'));
var_dump(count($a));
var_dump($a->lastButOne());

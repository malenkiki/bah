<?php


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
while($c->bytes()->valid())
{
    echo $c->bytes()->current()->b()->upper()->n();
    $c->bytes()->next();
}

$greek = new S('Τα ελληνικά σου είναι καλύτερα απο τα Γαλλικά μου!');
echo $greek->n();
echo $greek->upper()->n();
echo $greek->lower()->n();
echo $greek->title()->n();
echo $greek->length()->s()->n();
echo $greek->sub(4)->n();

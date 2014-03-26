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

(@include_once __DIR__ . '/vendor/autoload.php') || @include_once __DIR__ . '/../../autoload.php';

use \Malenki\Bah\O;
use \Malenki\Bah\N;
use \Malenki\Bah\A;
use \Malenki\Bah\S;
use \Malenki\Bah\C;


$s = new S('C’est cool !');
$c = new C("€");
//print($s->chars()->last());
while($c->bytes->valid)
{
    echo $c->bytes->current->b->n;
    $c->bytes->next;
}

$greek = new S('Τα ελληνικά σου είναι καλύτερα απο τα Γαλλικά μου!');
echo $greek->n;
echo $greek->upper->n;
echo $greek->lower->n;
echo $greek->title->n;
echo $greek->length->s->n;
echo $greek->sub(4)->n;
echo $greek->chars->length->s->n;
echo $greek->bytes->length->s->n;

$a = new A(array('un', 'deux', 'trois', 'quatre'));
var_dump(count($a));
var_dump($a->random);
var_dump($a->random(2));
var_dump($a->lastButOne);
var_dump($a->shuffle->join(', ')->string);
var_dump($a->shuffle->join->string);
$abc = new S('abcdefghijklmnopqrstuvwxyz');
echo $abc->first->n;
echo $abc->last->n;
echo $abc->ucf->n;



$long = new S('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sit amet ante ut sapien porta interdum vel non risus. Aenean nec tincidunt lorem. Cras eu metus non nunc dictum condimentum vel vulputate lectus. Maecenas bibendum massa et metus tempor mattis. Sed risus diam, dignissim eget erat ut, egestas adipiscing purus. Duis nunc quam, suscipit eu lorem ut, placerat dapibus dui. Sed adipiscing tempor diam, non egestas odio gravida vestibulum.');
echo $long->wrap(30)->n->n;

$long = new S('Tous les êtres humains naissent libres et égaux en dignité et en droits. Ils sont doués de raison et de conscience et doivent agir les uns envers les autres dans un esprit de fraternité.');
echo $long->wrap(20)->n->n;
echo $long->wrap(40)->n->n;
echo $long->wrap(80)->n->n;
echo $long->wrap(80)->ucw->n->n;
echo 'First: ';
echo $long->wrap(40)->margin(10, 0, -7)->n->n;

$c = new C("Œ");
$all = $c->allCharsOfItsBlock();

while($all->valid)
{
    echo $all->current;
    echo ' ';
    $all->next;
}
echo $c->block->n(false)->n;

$filter_vowel = function($item)
{
    if(in_array($item, array('a', 'e', 'y', 'u', 'i', 'o')))
    {
        return "I am vowel $item!";
    }
};
$filter_upper_consons = function($item)
{
    if(!in_array($item, array('a', 'e', 'y', 'u', 'i', 'o')))
    {
        return 'I am prout to be a '.strtoupper($item);
    }
    else
    {
        return 'I am just simple vowel '.$item;
    }
};
$s = new S('abcdef');
var_dump($s->a->filter($filter_vowel));
var_dump($s->a->map($filter_upper_consons));

$s = new S('C’est rigolo d’écrire en français !');
echo $s->trans->n;
$s = new S('Τα ελληνικά σου είναι καλύτερα απο τα Γαλλικά μου!');
echo $s->trans->n;

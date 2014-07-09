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
use \Malenki\Bah\H;
use \Malenki\Bah\S;
use \Malenki\Bah\C;

$underline = new S('=');

$title = new S('Play With Strings');
echo $title->n;
echo $underline->times(count($title))->n;


$greek = new S('Τα ελληνικά σου είναι καλύτερα απο τα Γαλλικά μου!');
echo $greek->n;
echo $greek->upper->n;
echo $greek->lower->n;
echo $greek->title->n;
echo $greek->title->swap->n;
echo $greek->length->to_s->n;
echo $greek->lcc->n;
echo $greek->ucc->n;
echo $greek->dash->n;
echo $greek->underscore->n;
echo $greek->trans->n;
echo $greek->lcc->trans->n;
echo $greek->sub(4)->n;
echo $greek->chars->length->to_s->n;
echo $greek->bytes->length->to_s->n;

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

echo $long->left(40)->n->n;
echo $long->right(40)->n->n;
echo $long->justify(40)->n->n;

$pi = new N(M_PI);

$format = new S('I am pi: %1.3f');
echo $format->format($pi)->n->n;

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
echo $s->chunk->filter($filter_vowel)->join("\n")->n;
echo $s->chunk->map($filter_upper_consons)->join("\n")->n;

$s = new S('C’est rigolo d’écrire en français !');
echo $s->trans->n;
$s = new S('Τα ελληνικά σου είναι καλύτερα απο τα Γαλλικά μου!');
echo $s->trans->n;

$s = new S('a/zerty');
var_dump($s->startsWith(new S('a/ze')));
var_dump($s->endsWith('ty'));
var_dump($s->match('/ze/'));
var_dump($s->match(new S('/ze/')));





$title = new S('Play With Characters');
echo $title->n;
echo $underline->times(count($title))->n;


$c = new C("€");
while($c->bytes->valid)
{
    echo $c->bytes->current->b->n;
    $c->bytes->next;
}

$c = new C("Œ");
$all = $c->family;
echo $c->family->join(', ')->n;

while($all->valid)
{
    echo $all->current;
    echo ' ';
    $all->next;
}
echo $c->block->n(false)->n;


$s = new S('Τα ελληνικά σου είναι καλύτερα απο τα Γαλλικά μου!');

while($s->chars->valid)
{
    printf(
        "%s => %s\n",
        $s->chars->current,
        $s->chars->current->trans
    );
    $s->chars->next;
}

$s = new S('abcdefgh');
var_dump($s->chars->has('c'));
var_dump($s->chars->has('z'));
$s = new S('ΑΒΓΔΕΖΗΘΙΚΛΜΝΞΟΠΡΣΤΥΦΧΨΩΪΫάέήίΰαβγδεζηθικλμνξοπρςστυφχψωϊϋόύώϐϑϒ');
echo $s->trans->n;

while($s->chars->valid)
{
    printf(
        "%s => %s\n",
        $s->chars->current,
        $s->chars->current->is_upper_case ? $s->chars->current->trans->title : $s->chars->current->trans
    );
    $s->chars->next;
}





$title = new S('Play With Numbers');
echo $title->n;
echo $underline->times(count($title))->n;


$n = new N(4);
var_dump($n->gt(2));
var_dump($n->gte(4));
var_dump($n->lt(2));
var_dump($n->lte(4));
echo $n->roman->n;
echo $n->greek->n;
echo $n->bin->n;
echo $n->oct->n;
echo $n->hex->n;






$title = new S('Play With Arrays');
echo $title->n;
echo $underline->times(count($title))->n;

$a = new A(array('un', 'deux', 'trois', 'quatre'));
var_dump(count($a));
var_dump($a->random);
echo $a->random(2)->join(', ')->n;
var_dump($a->last_but_one);
echo $a->shuffle->join(', ')->n;
echo $a->shuffle->join->n;
echo $a->sort->join(', ')->n;
echo $a->sort->reverse->join(', ')->n;

$a = new A(array('un', 'deux', 'deux', 'trois', 'quatre'));
echo $a->unique->join(', ')->n;

$a = new A(array('one', 'two', 'three', 'four', 'five'));
echo $a->chunk(2)->take(1)->join(', ')->n;
var_dump($a->search('three')->int);
echo $a->slice(1,3)->join(', ')->n;






$title = new S('Play With Hashes');
echo $title->n;
echo $underline->times(count($title))->n;

$h = new H(array('one' => 1, 'two' => 2, 'three' => 3, 'four' => 4, 'five' => 5));

while($h->valid)
{
    printf(
        "key: %s => value: %d\n",
        $h->current->key,
        $h->current->value
    );
    $h->next;
}

$nh = $h->map(function($k,$v){return "Key $k has value $v\n";});

while($nh->valid)
{
    echo $nh->current->value;
    $nh->next;
}

$h = new H(array('one' => 'un', 'two' => 'deux', 'three' => 'trois', 'four' => 'quatre', 'five' => 'cinq'));
var_dump($h->reverse->array);
var_dump($h->sort->array);
var_dump($h->sort->reverse->array);
var_dump($h->chunk(2)->array);
var_dump($h->search('trois')->string);
var_dump($h->slice(1,3));
$h = new H(array('one' => 'un', 'two' => 'deux', 'three' => 'trois', 'four' => 'quatre', 'five' => 'cinq', 'six' => 'deux'));
var_dump($h->unique->array);

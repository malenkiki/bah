<?php
/*
Copyright (c) 2014 Michel Petit <petit.michel@gmail.com>

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

use \Malenki\Bah\N;
use \Malenki\Bah\A;
use \Malenki\Bah\H;
use \Malenki\Bah\S;

class ATest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInstanciateWithBadTypeShouldRaiseException()
    {
        $a = new A('foo');
    }

    public function testInstanciateWithArrayShouldSuccess()
    {
        $a = new A(array('foo', 'bar'));
        $this->assertInstanceOf('\Malenki\Bah\A', $a);
    }

    public function testInstanciateWithAClassShouldSuccess()
    {
        $a = new A(new A(array('foo', 'bar')));
        $this->assertInstanceOf('\Malenki\Bah\A', $a);
    }

    public function testInstanciateWithHClassShouldSuccess()
    {
        $a = new A(new H(array('foo' => 'something', 'bar' => 'thing')));
        $this->assertInstanceOf('\Malenki\Bah\A', $a);
    }

    public function testGettingNumberOfItem()
    {
        $a = new A();
        $this->assertEquals(0, $a->length->value);
        $this->assertEquals(0, $a->length->int);
        $this->assertEquals(0, count($a));

        $a = new A(array('one', 'two', 'three', 'four', 'five'));
        $this->assertEquals(5, $a->length->value);
        $this->assertEquals(5, $a->length->int);
        $this->assertEquals(5, count($a));
    }

    public function testAddingValueAndCheckingCountMustBeOk()
    {
        $a = new A();
        $a->add('one');
        $this->assertEquals(1, count($a));
        $this->assertEquals(1, $a->length->value);
        $this->assertEquals(1, $a->length->int);
        $a->add('two');
        $this->assertEquals(2, count($a));
        $this->assertEquals(2, $a->length->value);
        $this->assertEquals(2, $a->length->int);
        $a->push('three');
        $this->assertEquals(3, count($a));
        $this->assertEquals(3, $a->length->value);
        $this->assertEquals(3, $a->length->int);
        $a->push('four')->add('five');
        $this->assertEquals(5, count($a));
        $this->assertEquals(5, $a->length->value);
        $this->assertEquals(5, $a->length->int);
    }

    public function testDeletingValueWithSuccess()
    {
        $a = new A(array('one', 'two', 'three', 'four', 'five'));
        $a->delete(3);
        $this->assertCount(4, $a);
        $this->assertEquals(4, $a->length->value);
        $this->assertEquals(4, $a->length->int);
        $a->remove(2);
        $this->assertCount(3, $a);
        $this->assertEquals(3, $a->length->value);
        $this->assertEquals(3, $a->length->int);
        $a->rm(1);
        $this->assertCount(2, $a);
        $this->assertEquals(2, $a->length->value);
        $this->assertEquals(2, $a->length->int);
        $a->del(0);
        $this->assertCount(1, $a);
        $this->assertEquals(1, $a->length->value);
        $this->assertEquals(1, $a->length->int);
    }

    /**
     * @expectedException \OutOfRangeException
     */
    public function testDeletingNonExistingValueShouldRaiseException()
    {
        $a = new A(array('one', 'two', 'three', 'four', 'five'));
        $a->delete(6);
    }

    public function testShiftingValueWithSuccess()
    {
        $a = new A(array('one', 'two', 'three', 'four', 'five'));
        $value = $a->shift;
        $this->assertEquals('one', $value);
        $this->assertEquals(4, count($a));
        $this->assertEquals(4, $a->length->value);
        $this->assertEquals(4, $a->length->int);
        $value = $a->shift;
        $this->assertEquals('two', $value);
        $this->assertEquals(3, count($a));
        $this->assertEquals(3, $a->length->value);
        $this->assertEquals(3, $a->length->int);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testShiftingValueFromVoidCollectionShouldRaiseException()
    {
        $a = new A();
        $value = $a->shift;
    }

    public function testPopingValueWithSuccess()
    {
        $a = new A(array('one', 'two', 'three', 'four', 'five'));
        $value = $a->pop;
        $this->assertEquals('five', $value);
        $this->assertEquals(4, count($a));
        $this->assertEquals(4, $a->length->value);
        $this->assertEquals(4, $a->length->int);
        $value = $a->pop;
        $this->assertEquals('four', $value);
        $this->assertEquals(3, count($a));
        $this->assertEquals(3, $a->length->value);
        $this->assertEquals(3, $a->length->int);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testPopingValueFromVoidCollectionShouldRaiseException()
    {
        $a = new A();
        $value = $a->pop;
    }

    public function testConvertingObjectToPrimitiveArrayShouldReturnArray()
    {
        $a = new A(array('foo', 'bar'));
        $this->assertInternalType('array', $a->array);
    }


    public function testConvertingObjectToPrimitiveArrayUsingShortFormShouldReturnArray()
    {
        $a = new A(array('foo', 'bar'));
        $this->assertInternalType('array', $a->arr);
    }

    public function testConvertingObjectToPrimitiveArrayShouldSuccess()
    {
        $arr = array('one', 'two', 'three', 'four', 'five');
        $a = new A($arr);
        $this->assertEquals($arr, $a->array);
        $this->assertEquals($arr, $a->arr);
    }

    public function testGettingOneAvailableItem()
    {
        $a = new A(array('one', 'two', 'three', 'four', 'five'));
        $this->assertEquals('one', $a->take(0));
        $this->assertEquals('two', $a->take(1));
        $this->assertEquals('three', $a->take(2));
        $this->assertEquals('four', $a->take(3));
        $this->assertEquals('five', $a->take(4));
        $this->assertEquals('one', $a->get(0));
        $this->assertEquals('two', $a->get(1));
        $this->assertEquals('three', $a->get(2));
        $this->assertEquals('four', $a->get(3));
        $this->assertEquals('five', $a->get(4));
        $this->assertEquals('one', $a->at(0));
        $this->assertEquals('two', $a->at(1));
        $this->assertEquals('three', $a->at(2));
        $this->assertEquals('four', $a->at(3));
        $this->assertEquals('five', $a->at(4));
    }

    /**
     * @expectedException \OutOfRangeException
     */
    public function testGettingOneNonAvailableItemShouldRaiseException()
    {
        $a = new A(array('one', 'two', 'three', 'four', 'five'));
        $this->assertEquals('one', $a->take(5));
    }

    public function testGettingFirstAndLastItem()
    {
        $a = new A(array('one', 'two', 'three', 'four', 'five'));
        $this->assertEquals('one', $a->first);
        $this->assertEquals('five', $a->last);

        $a->add('six');
        $this->assertEquals('six', $a->last);
    }

    public function testGettingLastButOneItem()
    {
        $a = new A(array('one', 'two', 'three', 'four', 'five'));
        $this->assertEquals('four', $a->last_but_one);

        $a->add('six');
        $this->assertEquals('five', $a->last_but_one);

    }

    /**
     * @expectedException \RuntimeException
     */
    public function testGettingLastButOneItemShouldRaiseException()
    {
        $a = new A(array('one', 'two'));
        $a->last_but_one;

    }

    public function testLoopingUsingIteratorAggregateShouldSuccess()
    {
        $a = new A(array('foo', 'bar'));

        foreach($a as $k => $v){
            $this->assertEquals($a->take($k), $v);
        }
    }


    public function testGettingCollectionJoinIntoStringShouldReturnSObject()
    {
        $a = new A(array('one', 'two', new S('three'), 'four', 'five'));
        $this->assertInstanceOf('\Malenki\Bah\S', $a->implode());
    }


    public function testGettingCollectionJoinIntoStringShouldSuccess()
    {
        $a = new A(array('one', 'two', new S('three'), 'four', 'five'));
        $this->assertEquals('onetwothreefourfive', $a->implode());
        $this->assertEquals('one, two, three, four, five', $a->implode(', '));

        $a = new A(
            array(
                array('one', 'two'),
                new A(array('three', 'four')),
                'five'
            )
        );
        $this->assertEquals('onetwothreefourfive', $a->implode());
        $this->assertEquals('one, two, three, four, five', $a->implode(', '));
        
        $a = new A(
            array(
                array('one', 'two'),
                new H(array('a' => 'three', 'b' => 'four')),
                'five'
            )
        );
        $this->assertEquals('onetwothreefourfive', $a->implode());
        $this->assertEquals('one, two, three, four, five', $a->implode(', '));
    }

    public function testGettingCollectionJoinIntoStringUsingAliasShouldHaveSameResult()
    {
        $a = new A(array('one', 'two', new S('three'), 'four', 'five'));
        $this->assertEquals($a->implode(), $a->join());
        $this->assertEquals($a->implode(', '), $a->join(', '));
        
        $a = new A(
            array(
                array('one', 'two'),
                new A(array('three', 'four')),
                'five'
            )
        );
        $this->assertEquals($a->implode(), $a->join());
        $this->assertEquals($a->implode(', '), $a->join(', '));

        $a = new A(
            array(
                array('one', 'two'),
                new H(array('a' => 'three', 'b' => 'four')),
                'five'
            )
        );
        $this->assertEquals($a->implode(), $a->join());
        $this->assertEquals($a->implode(', '), $a->join(', '));
    }


    public function testGettingCollectionJoinIntoStringUsingMagicGetterShouldSuccess()
    {
        $a = new A(array('one', 'two', new S('three'), 'four', 'five'));
        $this->assertEquals('onetwothreefourfive', $a->implode);
    }


    public function testGettingCollectionJoinIntoStringUsingMagicGetterAliasShouldSuccess()
    {
        $a = new A(array('one', 'two', new S('three'), 'four', 'five'));
        $this->assertEquals('onetwothreefourfive', $a->join);
    }

    public function testAvailabilityOfContentAndIndex()
    {
        $a = new A(array('one', 'two', 'three', 'four', 'five'));
        $this->assertTrue($a->has('two'));
        $this->assertFalse($a->has('six'));
        $this->assertTrue($a->exist(1));
        $this->assertFalse($a->exist(7));
        $this->assertTrue($a->exist(new N(1)));
        $this->assertFalse($a->exist(new N(7)));
    }

    public function testReplacingItem()
    {
        $a = new A(array('one', 'two', 'three', 'four', 'five'));
        $a->replace(1, 'deux');
        $this->assertEquals('deux', $a->take(1));
        $this->assertEquals('deux', $a->take(new N(1)));
    }

    /**
     * @expectedException \OutOfRangeException
     */
    public function testReplacingNonExistingItemShouldRaiseOutOfRangeException()
    {
        $a = new A(array('one', 'two', 'three', 'four', 'five'));
        $a->replace(5, 'six');
    }

    public function testFilteringValuesShouldSuccess()
    {
        $even = function ($n) {return !($n & 1);};
        $odd = function ($n) {return $n & 1;};

        $a = new A(range(0, 10));
        $this->assertEquals(array(0, 2, 4, 6, 8, 10), $a->filter($even)->array);
        $this->assertEquals(array(1, 3, 5, 7, 9), $a->filter($odd)->array);
    }

    public function testMappingValuesShouldSuccess()
    {
        $cube = function ($n) {return $n * $n * $n;};

        $a = new A(range(1, 5));
        $this->assertEquals(array(1, 8, 27, 64, 125), $a->map($cube)->array);
    }


    public function testWalkingValuesShouldSuccess()
    {
        $foo = function (&$v, $k, $n) {
            if($k & 1){
                $v = -1 * (pow($v, 3)  + $n);
            } else {
                $v = pow($v, 2)  + $n;
            }
        };

        $a = new A(range(1, 5));
        $this->assertEquals(array(4, -11, 12, -67, 28), $a->walk($foo, 3)->array);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testFilteringUsingNotCallableArgShouldFail()
    {
        $a = new A(range(0, 10));

        $a->filter(array());
    }



    /**
     * @expectedException \InvalidArgumentException
     */
    public function testMappingUsingNotCallableArgShouldFail()
    {
        $a = new A(range(0, 10));

        $a->map(array());
    }



    /**
     * @expectedException \InvalidArgumentException
     */
    public function testWalkingUsingNotCallableArgShouldFail()
    {
        $a = new A(range(0, 10));
        
        $a->walk(array());
    }

    public function testReversingOrderShouldSuccess()
    {
        $a = new A(array('one', 'two', 'three', 'four', 'five'));
        $this->assertEquals(array('five', 'four', 'three', 'two', 'one'), $a->reverse->array);
        $this->assertEquals($a->array, $a->reverse->reverse->array);
    }

    public function testDiffWithArrayShouldSuccess()
    {
        $fr = array('blue', 'white', 'red');
        $it = array('green', 'white', 'red');
        $a = new A($it);
        $this->assertEquals(array('green'), $a->diff($fr)->array);
        $a = new A($fr);
        $this->assertEquals(array('blue'), $a->diff($it)->array);
    }

    public function testDiffWithClassAShouldSuccess()
    {
        $fr = new A(array('blue', 'white', 'red'));
        $it = new A(array('green', 'white', 'red'));
        $this->assertEquals(array('green'), $it->diff($fr)->array);
        $this->assertEquals(array('blue'), $fr->diff($it)->array);
    }
    
    public function testIntersectWithArrayshouldReturnAObject()
    {
        $a1 = array('blue', 'white', 'red');
        $a2 = array('green', 'white', 'red');
        $a = new A($a2);
        $this->assertInstanceOf('\Malenki\Bah\A', $a->inter($a1));
    }


    public function testIntersectWithArrayshouldSuccess()
    {
        $a1 = array('blue', 'white', 'red');
        $a2 = array('green', 'white', 'red');
        $a = new A($a2);
        $this->assertEquals(array('white', 'red'), $a->inter($a1)->array);
        $a = new A($a1);
        $this->assertEquals(array('white', 'red'), $a->inter($a2)->array);
    }

    public function testIntersectWithAClassShouldSuccess()
    {
        $a1 = new A(array('blue', 'white', 'red'));
        $a2 = new A(array('green', 'white', 'red'));
        $this->assertEquals(array('white', 'red'), $a2->inter($a1)->array);
        $this->assertEquals(array('white', 'red'), $a1->inter($a2)->array);
    }


    public function testIntersectWithHClassShouldSuccess()
    {
        $a = new A(array('blue', 'white', 'red'));
        $h = new H(array('a' => 'green', 'b' => 'white', 'c' => 'red'));
        $this->assertEquals(array('white', 'red'), $a->inter($h)->array);
    }

    public function testSortingShouldSuccess()
    {
        $fr = new A(array('blue', 'white', 'red'));
        $this->assertEquals(array('blue', 'red', 'white'), $fr->sort->array);
        $this->assertEquals(array('blue', 'white', 'red'), $fr->array);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testDiffUsingBadValueTypeShouldFail()
    {
        $a = new A(array('blue', 'white', 'red'));
        $foo = 'foo';
        $a->diff($foo);
    }



    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInterUsingBadValueTypeShouldFail()
    {
        $a = new A(array('blue', 'white', 'red'));
        $foo = 'foo';
        $a->inter($foo);
    }



    /**
     * @expectedException \InvalidArgumentException
     */
    public function testMergeUsingBadValueTypeShouldFail()
    {
        $a = new A(array('blue', 'white', 'red'));
        $foo = 'foo';
        $a->merge($foo);
    }

    public function testPaddingValuesShouldSuccess()
    {
        $a = new A(array('one', 2, 'something'));
        $this->assertEquals(7, count($a->pad(7)));
        $this->assertEquals(array('one', 2, 'something','foo', 'foo', 'foo', 'foo'), $a->pad(7, 'foo')->array);
        $this->assertEquals(array('one', 2, 'something',null, null, null, null), $a->pad(7)->array);
    }

    public function testRemovingDuplicateEntryShouldReturnAObject()
    {
        $a = new A(array('one', 'two', 'two', 'three', 'two', 12, 13, 12));
        $this->assertInstanceOf('\Malenki\Bah\A', $a->unique);
    }

    public function testRemovingDuplicateEntryShouldSuccess()
    {
        $a = new A(array('one', 'two', 'two', 'three', 'two', 12, 13, 12));
        $this->assertEquals(array('one', 'two', 'three', 12, 13), $a->unique->array);
    }


    public function testRemovingDuplicateEntryUsingAliasShouldHaveSameResultAsOriginal()
    {
        $a = new A(array('one', 'two', 'two', 'three', 'two', 12, 13, 12));
        $this->assertEquals($a->unique, $a->uniq);
    }
    public function testMakingChunkShouldSuccess()
    {
        $a = new A(array('one', 'two', 'three', 'four', 'five'));
        $result = array(array('one', 'two'), array('three', 'four'), array('five'));
        $this->assertEquals($result, $a->chunk(2)->array);
        $this->assertEquals($result, $a->chunk(new N(2))->array);
    }

    public function testSearchingValuesIndexShouldSuccess()
    {
        $a = new A(array('one', 'two', 'three', 'four', 'five'));
        $this->assertEquals(2, $a->search('three')->int);
    }

    public function testSearchingiNonExistingValuesIndexShouldSuccess()
    {
        $a = new A(array('one', 'two', 'three', 'four', 'five'));
        $this->assertNull($a->search('six'));
    }

    public function testExtractingSliceShouldSuccess()
    {
        $a = new A(array('one', 'two', 'three', 'four', 'five'));
        $this->assertEquals(array('two', 'three', 'four'), $a->slice(1, 3)->array);
        $this->assertEquals(array('two', 'three', 'four'), $a->slice(new N(1), new N(3))->array);
    }

    public function testMergingShouldReturnAObject()
    {
        $a = new A(array('un', 'deux', 'trois'));
        $b = new A(array('quatre', 'cinq'));

        $this->assertInstanceOf('\Malenki\Bah\A', $a->merge($b));
    }


    public function testMergingUsingShouldSuccess()
    {
        $a = new A(array('un', 'deux', 'trois'));
        $b = new A(array('quatre', 'cinq'));
        $c = new A(array('six', 'sept', 'huit'));

        $this->assertEquals(array('un', 'deux', 'trois', 'quatre', 'cinq'), $a->merge($b)->array);
        $this->assertEquals(array('un', 'deux', 'trois', 'quatre', 'cinq', 'six', 'sept', 'huit'), $a->merge($b, $c)->array);

        $b = new H(array('four' => 'quatre', 'five' => 'cinq'));

        $this->assertEquals(array('un', 'deux', 'trois', 'quatre', 'cinq'), $a->merge($b)->array);
        $this->assertEquals(array('un', 'deux', 'trois', 'quatre', 'cinq', 'six', 'sept', 'huit'), $a->merge($b, $c)->array);
    }

    public function testMergingUsingAliasShouldHaveSameResultAsOriginal()
    {
        $a = new A(array('un', 'deux', 'trois'));
        $b = new A(array('quatre', 'cinq'));

        $this->assertEquals($a->merge($b), $a->concat($b));
    }

    public function testfindingKeysValuesUsingKeyTest()
    {
        $a = new A(array('foo', 'bar', 'thing', 'other'));
        $this->assertEquals(array('bar', 'other'), $a->find('odd')->array);
        $this->assertEquals(array('foo', 'thing'), $a->find('even')->array);
        $this->assertEquals(array('thing', 'other'), $a->find('>=2')->array);
        $this->assertEquals(array('foo', 'bar'), $a->find('< 2')->array);
        $this->assertEquals(array('foo', 'bar'), $a->find('<= 1')->array);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testfindingKeysValuesUsingKeyTestWithNegativeNumberShouldFail()
    {
        $a = new A(array('foo', 'bar', 'thing', 'other'));
        $a->find('>= -5');
    }

    public function testGettingMinOrMaxShouldSuccess()
    {
        $a = new A(array('1bar', 'foo', 1, 7, '6', new N(10), '0'));

        $this->assertInstanceOf('\Malenki\Bah\N', $a->max);
        $this->assertInstanceOf('\Malenki\Bah\N', $a->min);
        $this->assertTrue($a->max->equal(10));
        $this->assertTrue($a->min->equal(0));

        $a = new A(array(4));

        $this->assertInstanceOf('\Malenki\Bah\N', $a->max);
        $this->assertInstanceOf('\Malenki\Bah\N', $a->min);
        $this->assertTrue($a->max->equal(4));
        $this->assertTrue($a->min->equal(4));
        $this->assertEquals($a->min->equal(4), $a->max->equal(4));

        $a->add(-4);

        $this->assertInstanceOf('\Malenki\Bah\N', $a->max);
        $this->assertInstanceOf('\Malenki\Bah\N', $a->min);
        $this->assertTrue($a->max->equal(4));
        $this->assertTrue($a->min->equal(-4));
    }

    public function testGettingMinOrMaxShouldGiveNoResult()
    {
        $a = new A(array('some', 'non', 'numeric', 'strings'));
        $this->assertNull($a->max);
        $this->assertNull($a->min);
    }

    public function testGettingValueUsingMagicGettersShouldSuccess()
    {
        $a = new A(array('foo', 'bar', 'thing'));
        $this->assertEquals('foo', $a->key_0);
        $this->assertEquals('foo', $a->index_0);
        $this->assertEquals('bar', $a->key_1);
        $this->assertEquals('bar', $a->index_1);
        $this->assertEquals('thing', $a->key_2);
        $this->assertEquals('thing', $a->index_2);
    }

    public function testReplacingValueUsingMagicSettersShouldSuccess()
    {
        $a = new A(array('foo', 'bar', 'thing'));
        $a->key_0 = 'truc';
        $a->index_1 = 'machin';
        $a->key_2 = 'bidule';

        $this->assertEquals(array('truc', 'machin', 'bidule'), $a->array);
    }



    public function testDetectingWhetherGivenArrayRangeExistOrNotShouldSuccess()
    {
        $a = new A(array('foo', 'bar', 'thing', 'other', 'bar', 'again'));

        $this->assertTrue($a->hasRange(array('bar', 'thing')));
        $this->assertFalse($a->hasRange(array('thing', 'bar')));

        $obj = new \stdClass();
        $obj->truc_un = 'thing';
        $obj->truc_deux = 'thing again';

        $a = new A(array('foo', 'bar', $obj, 'other', 'bar', 'again'));

        $this->assertTrue($a->hasRange(array('bar', $obj)));
        $this->assertFalse($a->hasRange(array($obj, 'bar')));
    }

    public function testDetectingWhetherGivenARangeExistOrNotShouldSuccess()
    {
        $a = new A(array('foo', 'bar', 'thing', 'other'));

        $this->assertTrue($a->hasRange(new A(array('bar', 'thing'))));
        $this->assertFalse($a->hasRange(new A(array('thing', 'bar'))));
        
        $obj = new \stdClass();
        $obj->truc_un = 'thing';
        $obj->truc_deux = 'thing again';

        $a = new A(array('foo', 'bar', $obj, 'other', 'bar', 'again'));

        $this->assertTrue($a->hasRange(new A(array('bar', $obj))));
        $this->assertFalse($a->hasRange(new A(array($obj, 'bar'))));
    }

    public function testDetectingWhetherGivenTooBigArrayRangeExistOrNotShouldReturnFalse()
    {
        $a = new A(array('foo', 'bar'));

        $this->assertFalse($a->hasRange(array('foo', 'bar', 'thing','other')));
        $this->assertFalse($a->hasRange(array('bar', 'thing', 'other')));
    }


    /**
     * @expectedException \InvalidArgumentException
     */
    public function testDetectingRangeWithBadTypeValueShouldFail()
    {
        $a = new A(array('foo', 'bar', 'thing', 'other'));
        $a->hasRange('foo');
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testDetectingRangeWithVoidRangeShouldFail()
    {
        $a = new A(array('foo', 'bar', 'thing', 'other'));
        $a->hasRange(array());
    }


    public function testGettingFlatVersionShouldReturnAObject()
    {
        $a = new A(array('foo', 'bar', array('thing', 'other')));

        $this->assertInstanceOf('\Malenki\Bah\A', $a->flatten);
    }

    public function testGettingFlattenVersionUsingOnlyArrayShouldSuccess()
    {
        $a = new A(array('foo', 'bar', array('thing', 'other', array('one', 'two', 'three'))));

        $this->assertEquals(
            new A(array('foo', 'bar', 'thing', 'other', 'one', 'two', 'three')),
            $a->flatten
        );
    }


    public function testGettingFlattenVersionUsingAObjectsShouldSuccess()
    {
        $a = new A(array('Foo', 'Bar', new A(array('Thing', 'Other', new A(array('One', 'Two', 'Three'))))));

        $this->assertEquals(
            new A(array('Foo', 'Bar', 'Thing', 'Other', 'One', 'Two', 'Three')),
            $a->flatten
        );
    }


    public function testGettingFlattenVersionUsingHObjectsShouldSuccess()
    {
        $a = new A(array('Foo', 'Bar', new H(array('a' => 'Thing', 'b' => 'Other', 'c' => new H(array('c' => 'One', 'd' => 'Two', 'e' => 'Three'))))));

        $this->assertEquals(
            new A(array('Foo', 'Bar', 'Thing', 'Other', 'One', 'Two', 'Three')),
            $a->flatten
        );
    }

    public function testGettingFlatVersionUsingAliasShouldHaveSameResultAsOriginal()
    {
        $a = new A(array('foo', 'bar', array('thing', 'other')));
        $this->assertEquals($a->flatten, $a->flat);
    }

    public function testGettingZippedAObjectsShouldReturnAObject()
    {
        $a = new A(array('un', 'deux', 'trois'));
        $b = new A(array('a', 'b', 'c'));
        $c = new A(array(1, 2, 3));

        $this->assertInstanceOf('\Malenki\Bah\A', $a->zip($b, $c));
    }

    public function testGettingZippedArraysHavingSameSizeShouldSuccess()
    {
        $a = new A(array('un', 'deux', 'trois'));
        $b = array('a', 'b', 'c');
        $c = array(1, 2, 3);
        $should = new A();
        $should->add(new A(array('un', 'a', 1)));
        $should->add(new A(array('deux', 'b', 2)));
        $should->add(new A(array('trois', 'c', 3)));

        $this->assertEquals($should, $a->zip($b, $c));
    }

    public function testGettingZippedArraysHavingDifferentSizesShouldSuccess()
    {
        $a = new A(array('un', 'deux', 'trois'));
        $b = array('a', 'b');
        $c = array(1, 2, 3);
        $should = new A();
        $should->add(new A(array('un', 'a', 1)));
        $should->add(new A(array('deux', 'b', 2)));
        $should->add(new A(array('trois', null, 3)));

        $this->assertEquals($should, $a->zip($b, $c));
    }


    public function testGettingZippedAObjectsHavingSameSizeShouldSuccess()
    {
        $a = new A(array('un', 'deux', 'trois'));
        $b = new A(array('a', 'b', 'c'));
        $c = new A(array(1, 2, 3));
        $should = new A();
        $should->add(new A(array('un', 'a', 1)));
        $should->add(new A(array('deux', 'b', 2)));
        $should->add(new A(array('trois', 'c', 3)));

        $this->assertEquals($should, $a->zip($b, $c));
    }

    public function testGettingZippedAObjectsiHavingDifferentSizesShouldSuccess()
    {
        $a = new A(array('un', 'deux', 'trois'));
        $b = new A(array('a', 'b'));
        $c = new A(array(1, 2, 3));
        $should = new A();
        $should->add(new A(array('un', 'a', 1)));
        $should->add(new A(array('deux', 'b', 2)));
        $should->add(new A(array('trois', null, 3)));

        $this->assertEquals($should, $a->zip($b, $c));
    }


    public function testGettingOnlyOneRandomElementsShouldReturnMixedValue()
    {
        $a = new A();
        $a->add('foo')->add('bar')->add('thing');

        $this->assertInternalType('string', $a->random(1));
    }


    public function testGettingMoreThanOneRandomElementsShouldReturnAObject()
    {
        $a = new A();
        $a->add('foo')->add('bar')->add('thing');

        $this->assertInstanceOf('\Malenki\Bah\A', $a->random(2));
    }

    public function testGettingRandomElementsShouldHaveRightNumberOfElements()
    {
        $a = new A();
        $a->add('foo')->add('bar')->add('thing')->add('other');

        $this->assertCount(2, $a->random(2)->array);
        $this->assertCount(3, $a->random(3)->array);
    }

    public function testGettingRandomElementsUsingNObjectShouldHaveRightNumberOfElements()
    {
        $a = new A();
        $a->add('foo')->add('bar')->add('thing')->add('other');

        $this->assertCount(2, $a->random(new N(2))->array);
        $this->assertCount(3, $a->random(new N(3))->array);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testGettingMoreRandomElementsThanCollectionSizeShouldFail()
    {
        $a = new A();
        $a->add('foo')->add('bar')->add('thing');

        $a->random(4);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGettingRandomElementsUsingBadValueArgShouldFail()
    {
        $a = new A();
        $a->add('foo')->add('bar')->add('thing');

        $a->random('q');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGettingRandomElementUsingNumberLessThanOneShouldFail()
    {
        $a = new A();
        $a->add('foo')->add('bar')->add('thing');

        $a->random(0);
    }
}

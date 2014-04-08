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
        $this->assertEquals(0, count($a));

        $a = new A(array('one', 'two', 'three', 'four', 'five'));
        $this->assertEquals(5, $a->length->value);
        $this->assertEquals(5, count($a));
    }


    public function testAddingValueAndCheckingCountMustBeOk()
    {
        $a = new A();
        $a->add('one');
        $this->assertEquals(1, count($a));
        $this->assertEquals(1, $a->length->value);
        $a->add('two');
        $this->assertEquals(2, count($a));
        $this->assertEquals(2, $a->length->value);
        $a->add('three');
        $this->assertEquals(3, count($a));
        $this->assertEquals(3, $a->length->value);
    }

    public function testDeletingValueWithSuccess()
    {
        $a = new A(array('one', 'two', 'three', 'four', 'five'));
        $a->delete(3);
        $this->assertEquals(4, count($a));
        $a->delete(2);
        $this->assertEquals(3, count($a));
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
        $value = $a->shift;
        $this->assertEquals('two', $value);
        $this->assertEquals(3, count($a));
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
        $value = $a->pop;
        $this->assertEquals('four', $value);
        $this->assertEquals(3, count($a));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testPopingValueFromVoidCollectionShouldRaiseException()
    {
        $a = new A();
        $value = $a->pop;
    }

    public function testConvertingObjectToPrimitiveArray()
    {
        $arr = array('one', 'two', 'three', 'four', 'five');
        $a = new A($arr);
        $this->assertEquals($arr, $a->array);
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
        $this->assertEquals('four', $a->lastButOne);

        $a->add('six');
        $this->assertEquals('five', $a->lastButOne);

    }

    public function testGettingLastButOneItemShouldRaiseException()
    {
        $a = new A(array('one', 'two'));
        $a->lastButOne;

    }

    public function testGettingCollectionJoinIntoString()
    {
        $a = new A(array('one', 'two', new S('three'), 'four', 'five'));
        $this->assertEquals('onetwothreefourfive', $a->implode());
        $this->assertEquals('one, two, three, four, five', $a->implode(', '));
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
        $even = function($n){return !($n & 1);};
        $odd = function($n){return $n & 1;};

        $a = new A(range(0, 10));
        $this->assertEquals(array(0, 2, 4, 6, 8, 10), $a->filter($even)->array);
        $this->assertEquals(array(1, 3, 5, 7, 9), $a->filter($odd)->array);
    }


    public function testMappingValuesShouldSuccess()
    {
        $cube = function($n){return $n * $n * $n;};
        
        $a = new A(range(1, 5));
        $this->assertEquals(array(1, 8, 27, 64, 125), $a->map($cube)->array);
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

    public function testIntersectWithArrayshouldSuccess()
    {
        $fr = array('blue', 'white', 'red');
        $it = array('green', 'white', 'red');
        $a = new A($it);
        $this->assertEquals(array('white', 'red'), $a->inter($fr)->array);
        $a = new A($fr);
        $this->assertEquals(array('white', 'red'), $a->inter($it)->array);
    }
    
    public function testIntersectWithAClassShouldSuccess()
    {
        $fr = new A(array('blue', 'white', 'red'));
        $it = new A(array('green', 'white', 'red'));
        $this->assertEquals(array('white', 'red'), $it->inter($fr)->array);
        $this->assertEquals(array('white', 'red'), $fr->inter($it)->array);
    }
}

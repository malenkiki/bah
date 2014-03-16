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


class ATest extends PHPUnit_Framework_TestCase
{
    public function testGettingNumberOfItem()
    {
        $a = new Malenki\Bah\A();
        $this->assertEquals(0, $a->length->value);
        $this->assertEquals(0, count($a));

        $a = new Malenki\Bah\A(array('one', 'two', 'three', 'four', 'five'));
        $this->assertEquals(5, $a->length->value);
        $this->assertEquals(5, count($a));
    }


    public function testAddingValueAndCheckingCountMustBeOk()
    {
        $a = new Malenki\Bah\A();
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
        $a = new Malenki\Bah\A(array('one', 'two', 'three', 'four', 'five'));
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
        $a = new Malenki\Bah\A(array('one', 'two', 'three', 'four', 'five'));
        $a->delete(6);
    }


    public function testShiftingValueWithSuccess()
    {
        $a = new Malenki\Bah\A(array('one', 'two', 'three', 'four', 'five'));
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
        $a = new Malenki\Bah\A();
        $value = $a->shift;
    }



    public function testPopingValueWithSuccess()
    {
        $a = new Malenki\Bah\A(array('one', 'two', 'three', 'four', 'five'));
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
        $a = new Malenki\Bah\A();
        $value = $a->pop;
    }

    public function testConvertingObjectToPrimitiveArray()
    {
        $arr = array('one', 'two', 'three', 'four', 'five');
        $a = new Malenki\Bah\A($arr);
        $this->assertEquals($arr, $a->array);
    }
    

    public function testGettingOneAvailableItem()
    {
        $a = new Malenki\Bah\A(array('one', 'two', 'three', 'four', 'five'));
        $this->assertEquals('one', $a->take(0));
        $this->assertEquals('two', $a->take(1));
        $this->assertEquals('three', $a->take(2));
        $this->assertEquals('four', $a->take(3));
        $this->assertEquals('five', $a->take(4));
    }
    

    /**
     * @expectedException \OutOfRangeException
     */
    public function testGettingOneNonAvailableItemShouldRaiseException()
    {
        $a = new Malenki\Bah\A(array('one', 'two', 'three', 'four', 'five'));
        $this->assertEquals('one', $a->take(5));
    }
    
    public function testGettingFirstAndLastItem()
    {
        $a = new Malenki\Bah\A(array('one', 'two', 'three', 'four', 'five'));
        $this->assertEquals('one', $a->first);
        $this->assertEquals('five', $a->last);

        $a->add('six');
        $this->assertEquals('six', $a->last);
    }

    public function testGettingLastButOneItem()
    {
        $a = new Malenki\Bah\A(array('one', 'two', 'three', 'four', 'five'));
        $this->assertEquals('four', $a->lastButOne);

        $a->add('six');
        $this->assertEquals('five', $a->lastButOne);

    }

    public function testGettingLastButOneItemShouldRaiseException()
    {
        $a = new Malenki\Bah\A(array('one', 'two'));
        $a->lastButOne;

    }

    public function testGettingCollectionJoinIntoString()
    {
        $a = new Malenki\Bah\A(array('one', 'two', new \Malenki\Bah\S('three'), 'four', 'five'));
        $this->assertEquals('onetwothreefourfive', $a->implode());
        $this->assertEquals('one, two, three, four, five', $a->implode(', '));
    }

    public function testAvailabilityOfContentAndIndex()
    {
        $a = new Malenki\Bah\A(array('one', 'two', 'three', 'four', 'five'));
        $this->assertTrue($a->has('two'));
        $this->assertFalse($a->has('six'));
        $this->assertTrue($a->exist(1));
        $this->assertFalse($a->exist(7));
    }

    public function testReplacingItem()
    {
        $a = new Malenki\Bah\A(array('one', 'two', 'three', 'four', 'five'));
        $a->replace(1, 'deux');
        $this->assertEquals('deux', $a->take(1));
    }


    /**
     * @expectedException \OutOfRangeException
     */
    public function testReplacingNonExistingItemShouldRaiseOutOfRangeException()
    {
        $a = new Malenki\Bah\A(array('one', 'two', 'three', 'four', 'five'));
        $a->replace(5, 'six');
    }
}

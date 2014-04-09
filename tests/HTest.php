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

use \Malenki\Bah\A;
use \Malenki\Bah\H;
use \Malenki\Bah\S;
use \Malenki\Bah\N;

class HTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInstanciateWithBadTypeShouldRaiseException()
    {
        $a = new H('foo');
    }
    
    /**
     * @expectedException \RuntimeException
     */
    public function testInstanciateWithNumberingIndexedArrayShouldRaiseException()
    {
        $a = new H(array('foo', 'bar'));
    }

    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInstanciateWithAClassShouldRaiseException()
    {
        $a = new H(new A(array('foo', 'bar')));
    }

    public function testInstanciateWithHClassShouldSuccess()
    {
        $a = new H(new H(array('foo' => 'something', 'bar' => 'thing')));
        $this->assertInstanceOf('\Malenki\Bah\H', $a);
    }

    public function testInstanciateWithStringIndexedArrayShouldSuccess()
    {
        $a = new H(array('foo' => 'something', 'bar' => 'thing'));
        $this->assertInstanceOf('\Malenki\Bah\H', $a);
    }

    public function testGettingNumberOfItem()
    {
        $h = new H();
        $this->assertEquals(0, $h->length->value);
        $this->assertEquals(0, count($h));

        $h = new H(array('one' => 1, 'two' => 2, 'three' => 3, 'four' => 4, 'five' => 5));
        $this->assertEquals(5, $h->length->value);
        $this->assertEquals(5, count($h));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testInstanciatingWhithArrayHavingNonStringKeysShouldRaiseException()
    {
        $h = new H(array('one', 'two', 2 => 'three', 'four', 'five'));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testInstanciatingWhithArrayHavingNotAllowedKeysShouldRaiseException()
    {
        $h = new H(array('one' => 1, 'keys' => 'something'));
    }


    public function testGettingValueUsingMethodShouldSuccess()
    {
        $h = new H(array('one' => 1, 'two' => 2, 'twenty-one' => 21, 'fourty_two' => 42));
        $this->assertEquals(1, $h->get('one'));
        $this->assertEquals(1, $h->take('one'));
        $this->assertEquals(21, $h->get('twenty-one'));
        $this->assertEquals(21, $h->take('twenty-one'));
        $this->assertEquals(42, $h->get('fourty_two'));
        $this->assertEquals(42, $h->take('fourty_two'));
    }

    public function testGettingValueUsingMagicGetterShouldSuccess()
    {
        $h = new H(array('one' => 1, 'two' => 2, 'twenty-one' => 21, 'fourty_two' => 42));
        $this->assertEquals(1, $h->one);
        $this->assertEquals(21, $h->{'twenty-one'});
        $this->assertEquals(42, $h->fourty_two);
    }


    public function testWhetherKeyExistsUsingMethodShouldSuccess()
    {
        $h = new H(array('one' => 1, 'two' => 2, 'three' => 3, 'four' => 4, 'five' => 5));
        $this->assertTrue($h->exist('one'));
        $this->assertTrue($h->exist('four'));
        $this->assertFalse($h->exist('six'));
        $this->assertFalse($h->exist('ten'));
    }

    public function testWhetherKeyExistsUsingIssetShouldSuccess()
    {
        $h = new H(array('one' => 1, 'two' => 2, 'three' => 3, 'four' => 4, 'five' => 5));
        $this->assertTrue(isset($h->one));
        $this->assertTrue(isset($h->four));
        $this->assertFalse(isset($h->six));
        $this->assertFalse(isset($h->ten));
    }

    public function testDeletingValueUsingMethodShouldSuccess()
    {
        $h = new H(array('one' => 1, 'two' => 2, 'three' => 3, 'four' => 4, 'five' => 5));
        $h->delete('three');
        $this->assertEquals(4, count($h));
        $h->delete('four');
        $this->assertEquals(3, count($h));
    }

    public function testDeletingValueUsingUnsetShouldSuccess()
    {
        $h = new H(array('one' => 1, 'two' => 2, 'three' => 3, 'four' => 4, 'five' => 5));
        unset($h->three);
        $this->assertEquals(4, count($h));
        unset($h->four);
        $this->assertEquals(3, count($h));
    }

    public function testSettingValueUsingMethodShouldSuccess()
    {
        $h = new H();
        $h->set('one', 1);
        $h->set('two', 2);
        $h->set('three', 3);
        $this->assertEquals(1, $h->get('one'));
        $this->assertEquals(2, $h->get('two'));
        $this->assertEquals(3, $h->get('three'));
        $this->assertEquals(3, count($h));
    }

    public function testSettingValueUsingValidMagicSetterShouldSuccess()
    {
        $h = new H();
        $h->one =  1;
        $h->two = 2;
        $h->three = 3;
        $this->assertEquals(1, $h->get('one'));
        $this->assertEquals(2, $h->get('two'));
        $this->assertEquals(3, $h->get('three'));
        $this->assertEquals(3, count($h));
    }

    public function testMappingValuesShouldSuccess()
    {
        $h = new H();
        $h->set('one', 'un');
        $h->set('two', 'deux');
        $h->set('three', 'trois');

        $blahblah = function($k, $v){
            return sprintf('English word "%s" is "%s" in french.', $k, $v);
        };

        $this->assertEquals('English word "one" is "un" in french.', $h->map($blahblah)->one);
        $this->assertEquals('English word "two" is "deux" in french.', $h->map($blahblah)->two);
        $this->assertEquals('English word "three" is "trois" in french.', $h->map($blahblah)->three);
    }

    public function testReversingShouldSuccess()
    {
        $h = new H();
        $h->set('one', 'un');
        $h->set('two', 'deux');
        $h->set('three', 'trois');
        $this->assertEquals(array('three' => 'trois','two' => 'deux','one' => 'un'), $h->reverse->array);
        $this->assertEquals($h->array, $h->reverse->reverse->array);
    }



    public function testSortingValuesShouldSuccess()
    {
        $h = new H();
        $h->set('one', 'un');
        $h->set('two', 'deux');
        $h->set('three', 'trois');

        $this->assertEquals(array('two' => 'deux', 'three' => 'trois', 'one' => 'un'), $h->sort->array);
        $this->assertEquals(array('one' => 'un', 'two' => 'deux', 'three' => 'trois'), $h->array);
    }



    public function testRemovingDuplicateEntries()
    {
        $h = new H();
        $h->set('one', 'un');
        $h->set('two', 'deux');
        $h->set('three', 'deux');
        
        $this->assertEquals(array('one' => 'un', 'two' => 'deux'), $h->unique->array);
    }


    public function testSearchingValuesIndexShouldSuccess()
    {
        $h = new H();
        $h->set('one', 'un');
        $h->set('two', 'deux');
        $h->set('three', 'trois');

        $this->assertEquals('two', $h->search('deux')->string);
    }
    
    public function testSearchingiNonExistingValuesIndexShouldSuccess()
    {
        $h = new H();
        $h->set('one', 'un');
        $h->set('two', 'deux');
        $h->set('three', 'trois');

        $this->assertNull($h->search('quatre'));
    }
    
    public function testExtractingSliceShouldSuccess()
    {
        $h = new H();
        $h->set('one', 'un');
        $h->set('two', 'deux');
        $h->set('three', 'trois');
        $h->set('four', 'quatre');
        $h->set('five', 'cinq');

        $this->assertEquals(array('two' => 'deux', 'three' => 'trois', 'four' => 'quatre'), $h->slice(1, 3)->array);
        $this->assertEquals(array('two' => 'deux', 'three' => 'trois', 'four' => 'quatre'), $h->slice(new N(1), new N(3))->array);
    }
}

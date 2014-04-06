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

class HTest extends PHPUnit_Framework_TestCase
{
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

}

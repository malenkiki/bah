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

use \Malenki\Bah\N;
use \Malenki\Bah\S;
use \Malenki\Bah\A;
use \Malenki\Bah\H;
use \Malenki\Bah\C;

class NTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testDivideByZeroAsObjectShouldRaiseException()
    {
        $five = new N(5);
        $zero = new N(0);
        $result = $five->divide($zero);
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testDivideByZeroAsIntegerShouldRaiseException()
    {
        $five = new N(5);
        $result = $five->divide(0);
    }


    public function testNumbersThatShouldBePositive()
    {
        $five = new N(5);
        $this->assertTrue($five->positive);

        $two = $five->minus(3);
        $this->assertTrue($two->positive);
    }

    public function testNumbersThatShouldBeNegative()
    {
        $five = new N(-5);
        $this->assertTrue($five->negative);

        $two = $five->plus(3);
        $this->assertTrue($two->negative);
    }

    public function testNumbersThatShouldBeZero()
    {
        $zero = new N(0);
        $this->assertTrue($zero->zero);
        
        $five = new N(-5);
        $zero = $five->plus(5);
        $this->assertTrue($zero->zero);
    }

    public function testObjectConvertedToPrimitiveInteger()
    {
        $three = new N(3);
        $this->assertEquals(3, $three->int);
        $three = new N(3.0);
        $this->assertEquals(3, $three->int);
    }

    public function testObjectConvertedToPrimitiveFloat()
    {
        $three = new N(3);
        $this->assertEquals(3.0, $three->float);
        $three = new N(3.0);
        $this->assertEquals(3.0, $three->float);
    }

    public function testObjectConvertedToPrimitiveDouble()
    {
        $three = new N(3);
        $this->assertEquals((double) 3.0, $three->double);
        $three = new N(3.0);
        $this->assertEquals((double) 3.0, $three->double);
    }

    public function testGreaterThanShouldBeTrue()
    {
        $n = new N(4);
        $this->assertTrue($n->gt(2));
        $this->assertTrue($n->gt(new N(2)));
        $this->assertTrue($n->gte(4));
        $this->assertTrue($n->gte(new N(4)));
    }

    public function testGreaterThanShouldBeFalse()
    {
        $n = new N(4);
        $this->assertFalse($n->gt(5));
        $this->assertFalse($n->gt(new N(5)));
        $this->assertFalse($n->gte(6));
        $this->assertFalse($n->gte(new N(6)));
    }

    public function testLessThanShouldBeTrue()
    {
        $n = new N(4);
        $this->assertTrue($n->lt(6));
        $this->assertTrue($n->lt(new N(6)));
        $this->assertTrue($n->lte(4));
        $this->assertTrue($n->lte(new N(4)));
    }

    public function testLessThanShouldBeFalse()
    {
        $n = new N(4);
        $this->assertFalse($n->lt(2));
        $this->assertFalse($n->lt(new N(-5)));
        $this->assertFalse($n->lte(-6));
        $this->assertFalse($n->lte(new N(0)));
    }
    public function testGreekNumerals()
    {
        // single digit
        $one = new N(1);
        $this->assertEquals('α', $one->greek());

        // ten and followers…
        $ten = new N(10);
        $this->assertEquals('ι', $ten->greek());
        
        $hundred = new N(100);
        $this->assertEquals('ρ', $hundred->greek());
        
        $thousand = new N(1000);
        $this->assertEquals('ͺα', $thousand->greek());

        $number269 = new N(269);
        $this->assertEquals('σξθ', $number269->greek());

        //now, as magic getter
        // single digit
        $one = new N(1);
        $this->assertEquals('α', $one->greek);

        // ten and followers…
        $ten = new N(10);
        $this->assertEquals('ι', $ten->greek);
        
        $hundred = new N(100);
        $this->assertEquals('ρ', $hundred->greek);
        
        $thousand = new N(1000);
        $this->assertEquals('ͺα', $thousand->greek);

        $number269 = new N(269);
        $this->assertEquals('σξθ', $number269->greek);
    }

    public function testRomanNumerals()
    {
        $one = new N(1);
        $this->assertEquals('i', $one->roman);
        
        $two = new N(2);
        $this->assertEquals('ii', $two->roman);
        
        $three = new N(3);
        $this->assertEquals('iii', $three->roman);
        
        $four = new N(4);
        $this->assertEquals('iv', $four->roman);
        
        $five = new N(5);
        $this->assertEquals('v', $five->roman);
        
        $six = new N(6);
        $this->assertEquals('vi', $six->roman);
        
        $seven = new N(7);
        $this->assertEquals('vii', $seven->roman);
        
        $eight = new N(8);
        $this->assertEquals('viii', $eight->roman);
        
        $nine = new N(9);
        $this->assertEquals('ix', $nine->roman);

        $ten = new N(10);
        $this->assertEquals('x', $ten->roman);
        
        $number269 = new N(269);
        $this->assertEquals('cclxix', $number269->roman);
        
        $number1978 = new N(1978);
        $this->assertEquals('mcmlxxviii', $number1978->roman);
    }


    public function testTestingConditionsShouldSuccess()
    {
        $n = new N(5);

        $this->assertTrue($n->test('>= 2'));
        $this->assertTrue($n->test(new S(' >= 2 ')));
        $this->assertTrue($n->test('> 2'));
        $this->assertTrue($n->test('> -2'));
        $this->assertTrue($n->test('ge 2'));
        $this->assertTrue($n->test('gt 2'));
        $this->assertTrue($n->test('GE 2'));
        $this->assertTrue($n->test('GT 2'));
        $this->assertTrue($n->test('= 5'));
        $this->assertTrue($n->test('== 5'));
        $this->assertTrue($n->test('eq 5'));
        $this->assertTrue($n->test('neq 10'));
        $this->assertTrue($n->test('no 10'));
        $this->assertTrue($n->test('!=10'));
        $this->assertTrue($n->test('<>10'));
        $this->assertTrue($n->test('<10'));
        $this->assertTrue($n->test('<=10'));
        $this->assertTrue($n->test('lt 10'));
        $this->assertTrue($n->test('le 10'));
    }


    /**
     * @expectedException \RuntimeException
     */
    public function testTestingMalformedConditionsShouldFail()
    {
        $n = new N(5);
        $n->test('< = 10');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testTestingConditionsWithBadArgTypeShouldFail()
    {
        $n = new N(5);
        $n->test(45);
    }

    public function testIfNumberIsOddShouldSuccess()
    {
        $n = new N(1);
        $this->assertTrue($n->odd);
        $n = new N(3);
        $this->assertTrue($n->odd);
        $n = new N(5);
        $this->assertTrue($n->odd);
        $n = new N(7);
        $this->assertTrue($n->odd);
        $n = new N(9);
        $this->assertTrue($n->odd);
        $n = new N(-1);
        $this->assertTrue($n->odd);
        $n = new N(-3);
        $this->assertTrue($n->odd);
        $n = new N(-5);
        $this->assertTrue($n->odd);
        $n = new N(-7);
        $this->assertTrue($n->odd);
        $n = new N(-9);
        $this->assertTrue($n->odd);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testIfNumberIsOddShouldFail()
    {
        $n = new N(5.1);
        $n->odd;
    }

    public function testIfNumberIsEvenShouldSuccess()
    {
        $n = new N(2);
        $this->assertTrue($n->even);
        $n = new N(4);
        $this->assertTrue($n->even);
        $n = new N(6);
        $this->assertTrue($n->even);
        $n = new N(8);
        $this->assertTrue($n->even);
        $n = new N(10);
        $this->assertTrue($n->even);
        $n = new N(-2);
        $this->assertTrue($n->even);
        $n = new N(-4);
        $this->assertTrue($n->even);
        $n = new N(-6);
        $this->assertTrue($n->even);
        $n = new N(-8);
        $this->assertTrue($n->even);
        $n = new N(-10);
        $this->assertTrue($n->even);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testIfNumberIsEvenShouldFail()
    {
        $n = new N(4.1);
        $n->even;
    }



    public function testNumberGetDecimalPart()
    {
        $n = new N(4.0);
        $this->assertEquals(0, $n->decimal->float);
        $n = new N(4.1);
        $this->assertEquals(0.1, $n->decimal->float);
        $n = new N(4.2);
        $this->assertEquals(0.2, $n->decimal->float);
        $n = new N(4.3);
        $this->assertEquals(0.3, $n->decimal->float);
        $n = new N(4.4);
        $this->assertEquals(0.4, $n->decimal->float);
        $n = new N(4.5);
        $this->assertEquals(0.5, $n->decimal->float);
        $n = new N(4.6);
        $this->assertEquals(0.6, $n->decimal->float);
        $n = new N(4.7);
        $this->assertEquals(0.7, $n->decimal->float);
        $n = new N(4.8);
        $this->assertEquals(0.8, $n->decimal->float);
        $n = new N(4.9);
        $this->assertEquals(0.9, $n->decimal->float);
        $n = new N(-4.0);
        $this->assertEquals(0, $n->decimal->float);
        $n = new N(-4.1);
        $this->assertEquals(-0.1, $n->decimal->float);
        $n = new N(-4.2);
        $this->assertEquals(-0.2, $n->decimal->float);
        $n = new N(-4.3);
        $this->assertEquals(-0.3, $n->decimal->float);
        $n = new N(-4.4);
        $this->assertEquals(-0.4, $n->decimal->float);
        $n = new N(-4.5);
        $this->assertEquals(-0.5, $n->decimal->float);
        $n = new N(-4.6);
        $this->assertEquals(-0.6, $n->decimal->float);
        $n = new N(-4.7);
        $this->assertEquals(-0.7, $n->decimal->float);
        $n = new N(-4.8);
        $this->assertEquals(-0.8, $n->decimal->float);
        $n = new N(-4.9);
        $this->assertEquals(-0.9, $n->decimal->float);
    }


    public function testIfNumberIsPrimeOrNotShouldSuccess()
    {
        $n = new N(2);
        $this->assertTrue($n->prime);
        $n = new N(3);
        $this->assertTrue($n->prime);
        $n = new N(5);
        $this->assertTrue($n->prime);
        $n = new N(7);
        $this->assertTrue($n->prime);
        $n = new N(11);
        $this->assertTrue($n->prime);
        $n = new N(13);
        $this->assertTrue($n->prime);
        $n = new N(17);
        $this->assertTrue($n->prime);
        $n = new N(19);
        $this->assertTrue($n->prime);
        $n = new N(23);
        $this->assertTrue($n->prime);
        $n = new N(29);
        $this->assertTrue($n->prime);
        $n = new N(1187);
        $this->assertTrue($n->prime);
        $n = new N(5711);
        $this->assertTrue($n->prime);

        $n = new N(4);
        $this->assertFalse($n->prime);
        $n = new N(1188);
        $this->assertFalse($n->prime);
        $n = new N(30);
        $this->assertFalse($n->prime);
    }
}

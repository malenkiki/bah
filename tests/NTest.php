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

    public function testAddNumberShouldSuccess()
    {
        $n = new N(2.3);
        $this->assertEquals((float) 5.4, $n->plus(3.1)->float);
        $n = new N(2.3);
        $this->assertEquals((float) 5.4, $n->plus(new N(3.1))->float);
    }

    public function testMinusNumberShouldSuccess()
    {
        $n = new N(5);
        $this->assertEquals(0, $n->minus(5)->int);
        $n = new N(5);
        $this->assertEquals(0, $n->minus(new N(5))->int);
    }

    public function testMultiplyNumberShouldSuccess()
    {
        $n = new N(5);
        $this->assertEquals(20, $n->multiply(4)->int);
        $n = new N(5);
        $this->assertEquals(20, $n->multiply(new N(4))->int);
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

    public function testGettingHindiNumeralsShouldSuccess()
    {
        $n = new N(0);
        $this->assertEquals('०', $n->hindi);
        $this->assertEquals('०', $n->hindi());
        $n = new N(1);
        $this->assertEquals('१', $n->hindi);
        $n = new N(2);
        $this->assertEquals('२', $n->hindi);
        $n = new N(3);
        $this->assertEquals('३', $n->hindi);
        $n = new N(4);
        $this->assertEquals('४', $n->hindi);
        $n = new N(5);
        $this->assertEquals('५', $n->hindi);
        $n = new N(6);
        $this->assertEquals('६', $n->hindi);
        $n = new N(7);
        $this->assertEquals('७', $n->hindi);
        $n = new N(8);
        $this->assertEquals('८', $n->hindi);
        $n = new N(9);
        $this->assertEquals('९', $n->hindi);
        $n = new N(10);
        $this->assertEquals('१०', $n->hindi);
        $n = new N(20);
        $this->assertEquals('२०', $n->hindi);
        $n = new N(30);
        $this->assertEquals('३०', $n->hindi);
        $n = new N(40);
        $this->assertEquals('४०', $n->hindi);
        $n = new N(50);
        $this->assertEquals('५०', $n->hindi);
        $n = new N(60);
        $this->assertEquals('६०', $n->hindi);
        $n = new N(70);
        $this->assertEquals('७०', $n->hindi);
        $n = new N(80);
        $this->assertEquals('८०', $n->hindi);
        $n = new N(90);
        $this->assertEquals('९०', $n->hindi);
        $n = new N(100);
        $this->assertEquals('१००', $n->hindi);
        $n = new N(1000);
        $this->assertEquals('१०००', $n->hindi);
        $n = new N(123456789);
        $this->assertEquals('१२३४५६७८९', $n->hindi);
    }

    public function testGettingHindiNumeralsUsingSeparatorShouldSuccess()
    {
        $n = new N(1000);
        $this->assertEquals('१,०००', $n->hindi(true));
        $n = new N(10000);
        $this->assertEquals('१०,०००', $n->hindi(true));
        $n = new N(100000);
        $this->assertEquals('१,००,०००', $n->hindi(true));
        $n = new N(1000000);
        $this->assertEquals('१०,००,०००', $n->hindi(true));
        $n = new N(10000000);
        $this->assertEquals('१,००,००,०००', $n->hindi(true));
        $n = new N(123456789);
        $this->assertEquals('१२,३४,५६,७८९', $n->hindi(true));
    }
    
    public function testGettingEasterArabicNumeralsShouldSuccess()
    {
        $n = new N(0);
        $this->assertEquals('٠', $n->arabic);
        $n = new N(1);
        $this->assertEquals('١', $n->arabic);
        $n = new N(2);
        $this->assertEquals('٢', $n->arabic);
        $n = new N(3);
        $this->assertEquals('٣', $n->arabic);
        $n = new N(4);
        $this->assertEquals('٤', $n->arabic);
        $n = new N(5);
        $this->assertEquals('٥', $n->arabic);
        $n = new N(6);
        $this->assertEquals('٦', $n->arabic);
        $n = new N(7);
        $this->assertEquals('٧', $n->arabic);
        $n = new N(8);
        $this->assertEquals('٨', $n->arabic);
        $n = new N(9);
        $this->assertEquals('٩', $n->arabic);
        $n = new N(10);
        $this->assertEquals('١٠', $n->arabic);
        $n = new N(1979);
        $this->assertEquals('١٩٧٩', $n->arabic);
    }
    
    public function testGettingPersoArabicNumeralsShouldSuccess()
    {
        $n = new N(0);
        $this->assertEquals('۰', $n->perso_arabic);
        $n = new N(1);
        $this->assertEquals('۱', $n->persian);
        $n = new N(2);
        $this->assertEquals('۲', $n->perso_arabic);
        $n = new N(3);
        $this->assertEquals('۳', $n->persian);
        $n = new N(4);
        $this->assertEquals('۴', $n->perso_arabic);
        $n = new N(5);
        $this->assertEquals('۵', $n->persian);
        $n = new N(6);
        $this->assertEquals('۶', $n->perso_arabic);
        $n = new N(7);
        $this->assertEquals('۷', $n->persian);
        $n = new N(8);
        $this->assertEquals('۸', $n->perso_arabic);
        $n = new N(9);
        $this->assertEquals('۹', $n->perso_arabic);
        $n = new N(10);
        $this->assertEquals('۱۰', $n->perso_arabic);
        $n = new N(1979);
        $this->assertEquals('۱۹۷۹', $n->perso_arabic);
    }


    public function testGettingChineseIntegersShouldSuccess()
    {
        $n = new N(0);
        $this->assertEquals('零', $n->chinese());
        $n = new N(1);
        $this->assertEquals('一', $n->chinese());
        $n = new N(12);
        $this->assertEquals('一十二', $n->chinese());
        $n = new N(123);
        $this->assertEquals('一百二十三', $n->chinese());
        $n = new N(1234);
        $this->assertEquals('一千二百三十四', $n->chinese());
        $n = new N(12345);
        $this->assertEquals('一兆二千三百四十五', $n->chinese());
        $n = new N(123456);
        $this->assertEquals('一十二兆三千四百五十六', $n->chinese());
        $n = new N(1234567);
        $this->assertEquals('一百二十三兆四千五百六十七', $n->chinese());
        $n = new N(12345678);
        $this->assertEquals('一千二百三十四兆五千六百七十八', $n->chinese());
        $n = new N(123456789);
        $this->assertEquals('一吉二千三百四十五兆六千七百八十九', $n->chinese());
        
        $n = new N(60);
        $this->assertEquals('六十', $n->chinese());
        $n = new N(20);
        $this->assertEquals('二十', $n->chinese());
        $n = new N(200);
        $this->assertEquals('二百', $n->chinese());
        $n = new N(2000);
        $this->assertEquals('二千', $n->chinese());
        $n = new N(45);
        $this->assertEquals('四十五', $n->chinese());
        $n = new N(2362);
        $this->assertEquals('二千三百六十二', $n->chinese());
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

    public function testGettingDivisorsShouldSuccess()
    {
        $n = new N(3);
        $this->assertEquals(array(new N(1), new N(3)), $n->divisors->array);
        $this->assertCount(2, $n->divisors);

        $n = new N(4);
        $this->assertEquals(array(new N(1), new N(2), new N(4)), $n->divisors->array);
        $this->assertCount(3, $n->divisors);

        $n = new N(5);
        $this->assertEquals(array(new N(1), new N(5)), $n->divisors->array);
        $this->assertCount(2, $n->divisors);

        $n = new N(6);
        $this->assertEquals(array(new N(1), new N(2), new N(3), new N(6)), $n->divisors->array);
        $this->assertCount(4, $n->divisors);

        $n = new N(7);
        $this->assertEquals(array(new N(1), new N(7)), $n->divisors->array);
        $this->assertCount(2, $n->divisors);

        $n = new N(8);
        $this->assertEquals(array(new N(1), new N(2), new N(4), new N(8)), $n->divisors->array);
        $this->assertCount(4, $n->divisors);

        $n = new N(9);
        $this->assertEquals(array(new N(1), new N(3), new N(9)), $n->divisors->array);
        $this->assertCount(3, $n->divisors);

        $n = new N(-3);
        $this->assertEquals(array(new N(1), new N(3)), $n->divisors->array);
        $this->assertCount(2, $n->divisors);

        $n = new N(-4);
        $this->assertEquals(array(new N(1), new N(2), new N(4)), $n->divisors->array);
        $this->assertCount(3, $n->divisors);

        $n = new N(-5);
        $this->assertEquals(array(new N(1), new N(5)), $n->divisors->array);
        $this->assertCount(2, $n->divisors);

        $n = new N(-6);
        $this->assertEquals(array(new N(1), new N(2), new N(3), new N(6)), $n->divisors->array);
        $this->assertCount(4, $n->divisors);

        $n = new N(-7);
        $this->assertEquals(array(new N(1), new N(7)), $n->divisors->array);
        $this->assertCount(2, $n->divisors);

        $n = new N(-8);
        $this->assertEquals(array(new N(1), new N(2), new N(4), new N(8)), $n->divisors->array);
        $this->assertCount(4, $n->divisors);

        $n = new N(-9);
        $this->assertEquals(array(new N(1), new N(3), new N(9)), $n->divisors->array);
        $this->assertCount(3, $n->divisors);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testGettingDivisorsShouldFail()
    {
        $n = new N(3.3);
        $n->divisors;
    }

    public function testGettingAbsoluteValueShouldSuccess()
    {
        $n = new N(-6);
        $this->assertEquals(6, $n->abs->int);
        $n = new N(6);
        $this->assertEquals(6, $n->abs->int);
        $n = new N(-6.4);
        $this->assertEquals((float) 6.4, $n->abs->float);
        $n = new N(6.4);
        $this->assertEquals((float) 6.4, $n->abs->float);
        $n = new N(-6);
        $this->assertEquals(6, $n->absolute->int);
        $n = new N(6);
        $this->assertEquals(6, $n->absolute->int);
        $n = new N(-6.4);
        $this->assertEquals((float) 6.4, $n->absolute->float);
        $n = new N(6.4);
        $this->assertEquals((float) 6.4, $n->absolute->float);
    }

    public function testGettingOppositeValueShouldSuccess()
    {
        $n = new N(-6);
        $this->assertEquals(6, $n->opposite->int);
        $n = new N(6);
        $this->assertEquals(-6, $n->opposite->int);
        $n = new N(-6.4);
        $this->assertEquals((float) 6.4, $n->opposite->float);
        $n = new N(6.4);
        $this->assertEquals((float) -6.4, $n->opposite->float);
        $n = new N(0);
        $this->assertEquals(0, $n->opposite->int);
    }

    public function testGettingModuloShouldSuccess()
    {
        $n = new N(3);
        $this->assertEquals(1, $n->mod(2)->int);
        $this->assertEquals(1, $n->modulo(2)->int);

        $n = new N(3.3);
        $this->assertEquals((double) 1.3, $n->mod(2)->double);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testGettingModuloDividingByZeroShouldFail()
    {
        $n = new N(3);
        $n->mod(0);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGettingModuloDividingNonNumericShouldFail()
    {
        $n = new N(3);
        $n->mod("one");
    }

    public function testGettingPowerShouldsuccess()
    {
        $n = new N(3);
        $this->assertEquals(9, $n->pow(2)->int);
        $this->assertEquals(9, $n->square->int);
        $this->assertEquals(81, $n->pow(2)->pow(2)->int);
        $this->assertEquals(81, $n->square->square->int);
        $this->assertEquals(27, $n->pow(3)->int);
        $this->assertEquals(27, $n->cube->int);

        $n = new N(-3);
        $this->assertEquals(9, $n->pow(2)->int);
        $this->assertEquals(9, $n->square->int);
        $this->assertEquals(81, $n->pow(2)->pow(2)->int);
        $this->assertEquals(81, $n->square->square->int);
        $this->assertEquals(-27, $n->pow(3)->int);
        $this->assertEquals(-27, $n->cube->int);

        $n = new N(2);
        $this->assertEquals(4, $n->pow(2)->int);
        $this->assertEquals(4, $n->square->int);
        $this->assertEquals(8, $n->cube->int);

        $n = new N(-2);
        $this->assertEquals(4, $n->pow(2)->int);
        $this->assertEquals(4, $n->square->int);
        $this->assertEquals(-8, $n->cube->int);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGettingPowerShouldFail()
    {
        $n = new N(3);
        $n->pow('4n');
    }

    public function testLnShouldSuccess()
    {
        $n = new N(1);
        $this->assertTrue($n->ln->zero);
        $this->assertTrue($n->log()->zero);
        $n = new N(M_E);
        $this->assertEquals(1, $n->ln->int);
        $this->assertEquals(1, $n->log()->int);

    }

    public function testLogShouldSuccess()
    {
        $n = new N(1);
        $this->assertTrue($n->log(10)->zero);
        $n = new N(10);
        $this->assertEquals(1, $n->log(10)->int);

        $n = new N(1);
        $this->assertTrue($n->log(2)->zero);
        $n = new N(2);
        $this->assertEquals(1, $n->log(2)->int);

        $n = new N(1);
        $this->assertTrue($n->log(0.5)->zero);
        $n = new N(0.5);
        $this->assertEquals(1, $n->log(0.5)->int);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testLogHavingBaseEqualsToOneShouldFail()
    {
        $n = new N(5);

        $n->log(1);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testLogHavingNegativeBaseShouldFail()
    {
        $n = new N(5);

        $n->log(-3);
    }

    public function testGettingRootShouldSuccess()
    {
        $n = new N(8);

        $this->assertEquals(2, $n->root(3)->int);
        $this->assertEquals(2, $n->root(new N(3))->int);
        $this->assertEquals(8, $n->root(1)->int);
        $this->assertEquals(8, $n->root(new N(1))->int);

        $n = new N(9);

        $this->assertEquals(3, $n->sqrt->int);
        $this->assertEquals(3, $n->root(new N(2))->int);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGettingRootShouldFail()
    {
        $n = new N(8);
        $n->root(0);
    }

    public function testGetSignShouldSuccess()
    {
        $n = new N(0);
        $this->assertEquals(0, $n->sign->int);
        $n = new N(-4);
        $this->assertEquals(-1, $n->sign->int);
        $n = new N(5.98);
        $this->assertEquals(1, $n->sign->int);
    }

    public function testFactorialShouldSuccess()
    {
        $n = new N(0);
        $this->assertEquals(1, $n->factorial->int);
        $this->assertEquals(1, $n->fact->int);
        $n = new N(5);
        $this->assertEquals(120, $n->factorial->int);
        $this->assertEquals(120, $n->fact->int);
        $n = new N(4);
        $this->assertEquals(24, $n->factorial->int);
        $this->assertEquals(24, $n->fact->int);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testFactorialShouldFail()
    {
        $n = new N(-5);
        $n->factorial;
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testFactorialFromNonIntegerShouldFail()
    {
        $n = new N(5.6);
        $n->factorial;
    }

    public function testGettingTriangularNumberShouldSuccess()
    {
        $n = new N(0);
        $this->assertEquals(0, $n->triangular->int);
        $n = new N(5);
        $this->assertEquals(15, $n->triangular->int);
        $n = new N(10);
        $this->assertEquals(55, $n->triangular->int);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testTriangularForNegativeNumberShouldFail()
    {
        $n = new N(-5);
        $n->triangular;
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testTriangularFromNonIntegerShouldFail()
    {
        $n = new N(5.6);
        $n->triangular;
    }

    public function testGettingInverseNumberShouldSuccess()
    {
        $n = new N(2);
        $this->assertEquals((float) 0.5, $n->inverse->float);
        $this->assertEquals((float) 1, $n->inverse->multiply($n)->value);
        $n = new N(4);
        $this->assertEquals((float) 0.25, $n->inverse->float);
        $this->assertEquals((float) 1, $n->inverse->multiply($n)->value);
        $n = new N(-2);
        $this->assertEquals((float) -0.5, $n->inverse->float);
        $this->assertEquals((float) 1, $n->inverse->multiply($n)->value);
        $n = new N(-4);
        $this->assertEquals((float) -0.25, $n->inverse->float);
        $this->assertEquals((float) 1, $n->inverse->multiply($n)->value);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testGettingInverseFromZeroShouldFail()
    {
        $n = new N(0);
        $n->inverse;
    }
}

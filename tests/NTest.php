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
    public function testConvertingToSObjectShouldSuccess()
    {
        $n = new N(101);
        $this->assertEquals(new S('101'), $n->to_s);
    }

    public function testConvertingToCObjectShouldSuccess()
    {
        $n = new N(9);
        $this->assertEquals(new C('9'), $n->to_c);
    }

    public function testConvertingObjectToPrimitiveStringShouldSuccess()
    {
        $c = new N(42);
        $this->assertInternalType('string', $c->string);
        $this->assertEquals('42', $c->string);
    }


    public function testConvertingObjectToPrimitiveStringUsingShortFormShouldSuccess()
    {
        $c = new N(42);
        $this->assertInternalType('string', $c->str);
        $this->assertEquals('42', $c->str);
    }


    public function testConvertingObjectToPrimitiveIntegerShouldSuccess()
    {
        $c = new N(42);
        $this->assertInternalType('integer', $c->integer);
        $this->assertEquals(42, $c->integer);
    }


    public function testConvertingObjectToPrimitiveIntegerUsingShortFormShouldSuccess()
    {
        $c = new N(42);
        $this->assertInternalType('integer', $c->int);
        $this->assertEquals(42, $c->int);
    }

    public function testConvertingObjectToPrimitiveFloatShouldSuccess()
    {
        $c = new N(12.34);
        $this->assertInternalType('float', $c->float);
        $this->assertEquals(12.34, $c->float);
    }


    public function testConvertingObjectToPrimitiveDoubleShouldSuccess()
    {
        $c = new N(12.34);
        $this->assertEquals((double) 12.34, $c->double);
    }


    /**
     * @expectedException \RuntimeException
     */
    public function testConvertingToCObjectUsingFloatNumberShouldFail()
    {
        $n = new N(1.5);
        $n->to_c;
    }


    /**
     * @expectedException \RuntimeException
     */
    public function testConvertingToCObjectUsingNumberGreaterThanNineShouldFail()
    {
        $n = new N(10);
        $n->to_c;
    }


    public function testIncrementNumberShouldReturnNObject()
    {
        $n = new N(3);

        $this->assertInstanceOf('\Malenki\Bah\N', $n->incr);
    }

    public function testIncrementNumberShouldChangeOriginalValue()
    {
        $n = new N(3);
        $n->incr;
        $this->assertEquals(4, $n->int);
        $this->assertEquals(5, $n->incr->int);
    }

    public function testDecrementNumberShouldReturnNObject()
    {
        $n = new N(3);

        $this->assertInstanceOf('\Malenki\Bah\N', $n->decr);
    }

    public function testDecrementNumberShouldChangeOriginalValue()
    {
        $n = new N(3);
        $n->decr;
        $this->assertEquals(2, $n->int);
        $this->assertEquals(1, $n->decr->int);
    }

    public function testGettingNextNumberShouldReturnNObject()
    {
        $n = new N(1);
        $this->assertInstanceOf('\Malenki\Bah\N', $n->n);
    }


    public function testGettingPreviousNumberShouldReturnNObject()
    {
        $n = new N(1);
        $this->assertInstanceOf('\Malenki\Bah\N', $n->p);
    }

    public function testGettingNextNumberShouldSuccess()
    {
        $n = new N(1);
        $this->assertEquals(new N(2), $n->n);
    }


    public function testGettingPreviousNumberShouldSuccess()
    {
        $n = new N(1);
        $this->assertEquals(new N(0), $n->p);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testGettingNextNumberUsingFloatShoouldFail()
    {
        $n = new N(M_PI);
        $n->n;
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testGettingPreviousNumberUsingFloatShoouldFail()
    {
        $n = new N(M_PI);
        $n->p;
    }


    public function testGettingNextNumberUsingAliasShouldHaveSameResultAsOriginal()
    {
        $n = new N(1);
        $this->assertEquals($n->n, $n->next);
    }

    public function testGettingPreviousNumberUsingAliasShouldHaveSameResultAsOriginal()
    {
        $n = new N(1);
        $this->assertEquals($n->p, $n->previous);
    }


    public function testDivisioniUsingPrimitivePHPTypeShouldReturnNObject()
    {
        $six = new N(6);

        $this->assertInstanceOf('\Malenki\Bah\N', $six->divide(2));
    }

    public function testDivisionUsingOnlyObjectsShouldReturnNObject()
    {
        $six = new N(6);
        $two = new N(2);

        $this->assertInstanceOf('\Malenki\Bah\N', $six->divide($two));
    }

    public function testDivisionUsingObjectOrPRimitiveTypeShouldReturnSameResult()
    {
        $six = new N(6);
        $two = new N(2);

        $this->assertEquals($six->divide($two), $six->divide(2));
        $this->assertEquals(new N(3), $six->divide(2));
    }

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

    public function testAddingNumberUsingObjectShouldReturnNObject()
    {
        $two = new N(2);
        $this->assertInstanceOf('\Malenki\Bah\N', $two->plus(new N(5)));
    }


    public function testAddingNumberUsingPrimitiveTypeShouldReturnNObject()
    {
        $two = new N(2);
        $this->assertInstanceOf('\Malenki\Bah\N', $two->plus(5));
    }

    public function testIfAddingNumberUsingObjectOrPrimitiveTypeReturnsSameResult()
    {
        $two = new N(2);
        $this->assertEquals($two->plus(new N(5)), $two->plus(5));
        $this->assertEquals(new N(7), $two->plus(5));
    }

    public function testAddNumberUsingPrimitiveTypesShouldSuccess()
    {
        $n = new N(2.3);
        $this->assertEquals((float) 5.4, $n->plus(3.1)->float);
    }

    public function testAddNumberUsingObjectsShouldSuccess()
    {
        $n = new N(2.3);
        $this->assertEquals((float) 5.4, $n->plus(new N(3.1))->float);
    }

    public function testMinusNumberUsingPrimitiveTypesShouldSuccess()
    {
        $n = new N(5);
        $this->assertEquals(0, $n->minus(5)->int);
    }

    public function testMinusNumberUsingObjectsShouldSuccess()
    {
        $n = new N(5);
        $this->assertEquals(0, $n->minus(new N(5))->int);
    }

    public function testMultiplyNumberUsingPrimitiveTypesShouldSuccess()
    {
        $n = new N(5);
        $this->assertEquals(20, $n->multiply(4)->int);
    }

    public function testMultiplyNumberiUsingObjectsShouldSuccess()
    {
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
        $this->assertInternalType('integer', $three->int);
        $three = new N(3.0);
        $this->assertEquals(3, $three->int);
        $this->assertInternalType('integer', $three->int);
    }

    public function testObjectConvertedToPrimitiveFloat()
    {
        $three = new N(3);
        $this->assertEquals(3.0, $three->float);
        $this->assertInternalType('float', $three->float);
        $three = new N(3.0);
        $this->assertEquals(3.0, $three->float);
        $this->assertInternalType('float', $three->float);
    }
    
    public function testGreaterThanUsingPrimitiveTypesShouldBeTrue()
    {
        $n = new N(4);
        $this->assertTrue($n->gt(2));
        $this->assertTrue($n->gte(4));
    }

    public function testGreaterThanUsingObjectsShouldBeTrue()
    {
        $n = new N(4);
        $this->assertTrue($n->gt(new N(2)));
        $this->assertTrue($n->gte(new N(4)));
    }

    public function testGreaterThanUsingPrimitiveTypeShouldBeFalse()
    {
        $n = new N(4);
        $this->assertFalse($n->gt(5));
        $this->assertFalse($n->gte(6));
    }

    public function testGreaterThanUsingObjectShouldBeFalse()
    {
        $n = new N(4);
        $this->assertFalse($n->gt(new N(5)));
        $this->assertFalse($n->gte(new N(6)));
    }

    public function testLessThanUsingPrimitiveTypeShouldBeTrue()
    {
        $n = new N(4);
        $this->assertTrue($n->lt(6));
        $this->assertTrue($n->lte(4));
    }


    public function testLessThanUsingObjectShouldBeTrue()
    {
        $n = new N(4);
        $this->assertTrue($n->lt(new N(6)));
        $this->assertTrue($n->lte(new N(4)));
    }

    public function testLessThanUsingPrimitiveTypeShouldBeFalse()
    {
        $n = new N(4);
        $this->assertFalse($n->lt(2));
        $this->assertFalse($n->lte(-6));
    }

    public function testLessThanUsingObjectShouldBeFalse()
    {
        $n = new N(4);
        $this->assertFalse($n->lt(new N(-5)));
        $this->assertFalse($n->lte(new N(0)));
    }



    public function testGettingGreekNumeralsUsingMethodShouldReturnSObject()
    {
        $one = new N(1);
        $this->assertInstanceOf('\Malenki\Bah\S', $one->greek());
    }


    public function testGettingGreekNumeralsUsingMagicGetterShouldReturnSObject()
    {
        $one = new N(1);
        $this->assertInstanceOf('\Malenki\Bah\S', $one->greek);
    }

    //TODO create test that use one arg into the method
    public function testGettingGreekNumeralsUsingMethodShouldSuccess()
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
    }

    public function testGettingGreekNumeralsUsingMagicGetterShouldSuccess()
    {
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

    /**
     * @expectedException \RuntimeException
     */
    public function testGettingGreekNumeralsUsingNegativeValueShouldFail()
    {
        $n = new N(-42);
        $n->greek;
    }


    /**
     * @expectedException \RuntimeException
     */
    public function testGettingGreekNumeralsUsingValueGreaterThan9999ShouldFail()
    {
        $n = new N(10000);
        $n->greek;
    }

    public function testGettingGreekumeralsFromMagicGetterShouldHaveSameResultAsFromMethodWay()
    {
        // single digit
        $one = new N(1);
        $this->assertEquals($one->greek(), $one->greek);

        // ten and followers…
        $ten = new N(10);
        $this->assertEquals($ten->greek(), $ten->greek);

        $hundred = new N(100);
        $this->assertEquals($hundred->greek(), $hundred->greek);

        $thousand = new N(1000);
        $this->assertEquals($thousand->greek(), $thousand->greek);

        $number269 = new N(269);
        $this->assertEquals($number269->greek(), $number269->greek);
    }


    public function testGettingRomanNumeralsShouldReturnSObject()
    {
        $one = new N(1);
        $this->assertInstanceOf('\Malenki\Bah\S', $one->roman);
    }


    public function testGettingRomanNumeralsShouldSuccess()
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

    /**
     * @expectedException \RuntimeException
     */
    public function testGettingRomanNumeralsUsingNegativeIntegerShouldFail()
    {
        $n = new N(-5);
        $n->roman;
    }



    /**
     * @expectedException \RuntimeException
     */
    public function testGettingRomanNumeralsUsingFloatShouldFail()
    {
        $n = new N(M_PI);
        $n->roman;
    }

    public function testGettingHindiNumeralsUsingMethodShouldReturnSObject()
    {
        $n = new N(0);
        $this->assertInstanceOf('\Malenki\Bah\S', $n->hindi());
    }


    public function testGettingHindiNumeralsUsingMagicGetterShouldReturnSObject()
    {
        $n = new N(0);
        $this->assertInstanceOf('\Malenki\Bah\S', $n->hindi);
    }

    public function testGettingHindiNumeralsShouldSuccess()
    {
        $n = new N(0);
        $this->assertEquals('०', $n->hindi);
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


    public function testGettingHindiNumeralsUsingMagicGetterShouldHaveSameResultAsUsingMethodWithoutAnyArg()
    {
        $n = new N(0);
        $this->assertEquals($n->hindi(), $n->hindi);
        $n = new N(1);
        $this->assertEquals($n->hindi(), $n->hindi);
        $n = new N(2);
        $this->assertEquals($n->hindi(), $n->hindi);
        $n = new N(3);
        $this->assertEquals($n->hindi(), $n->hindi);
        $n = new N(4);
        $this->assertEquals($n->hindi(), $n->hindi);
        $n = new N(5);
        $this->assertEquals($n->hindi(), $n->hindi);
        $n = new N(6);
        $this->assertEquals($n->hindi(), $n->hindi);
        $n = new N(7);
        $this->assertEquals($n->hindi(), $n->hindi);
        $n = new N(8);
        $this->assertEquals($n->hindi(), $n->hindi);
        $n = new N(9);
        $this->assertEquals($n->hindi(), $n->hindi);
        $n = new N(10);
        $this->assertEquals($n->hindi(), $n->hindi);
        $n = new N(20);
        $this->assertEquals($n->hindi(), $n->hindi);
        $n = new N(30);
        $this->assertEquals($n->hindi(), $n->hindi);
        $n = new N(40);
        $this->assertEquals($n->hindi(), $n->hindi);
        $n = new N(50);
        $this->assertEquals($n->hindi(), $n->hindi);
        $n = new N(60);
        $this->assertEquals($n->hindi(), $n->hindi);
        $n = new N(70);
        $this->assertEquals($n->hindi(), $n->hindi);
        $n = new N(80);
        $this->assertEquals($n->hindi(), $n->hindi);
        $n = new N(90);
        $this->assertEquals($n->hindi(), $n->hindi);
        $n = new N(100);
        $this->assertEquals($n->hindi(), $n->hindi);
        $n = new N(1000);
        $this->assertEquals($n->hindi(), $n->hindi);
        $n = new N(123456789);
        $this->assertEquals($n->hindi(), $n->hindi);
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


    public function testGettingChinesePositiveIntegersShouldSuccess()
    {
        $n = new N(0);
        $this->assertEquals('零', $n->chinese());
        $n = new N(1);
        $this->assertEquals('一', $n->chinese());
        $n = new N(12);
        $this->assertEquals('十二', $n->chinese());
        $n = new N(123);
        $this->assertEquals('一百二十三', $n->chinese());
        $n = new N(1234);
        $this->assertEquals('一千二百三十四', $n->chinese());
        $n = new N(12345);
        $this->assertEquals('一兆二千三百四十五', $n->chinese());
        $n = new N(123456);
        $this->assertEquals('十二兆三千四百五十六', $n->chinese());
        $n = new N(1234567);
        $this->assertEquals('一百二十三兆四千五百六十七', $n->chinese());
        $n = new N(12345678);
        $this->assertEquals('一千二百三十四兆五千六百七十八', $n->chinese());
        $n = new N(123456789);
        $this->assertEquals('一吉二千三百四十五兆六千七百八十九', $n->chinese());
        
        $n = new N(14);
        $this->assertEquals('十四', $n->chinese);
        $n = new N(208);
        $this->assertEquals('二百零八', $n->mandarin);
        $n = new N(2008);
        $this->assertEquals('二千零八', $n->putonghua);

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

    public function testGettingChineseNegativeIntegersShouldSuccess()
    {
        $n = new N(-1158);
        $this->assertEquals('负一千一百五十八', $n->chinese());
        $n = new N(-60);
        $this->assertEquals('负六十', $n->chinese());
        $n = new N(-20);
        $this->assertEquals('负二十', $n->chinese());
        $n = new N(-200);
        $this->assertEquals('负二百', $n->chinese());
        $n = new N(-2000);
        $this->assertEquals('负二千', $n->chinese());
        $n = new N(-45);
        $this->assertEquals('负四十五', $n->chinese());
        $n = new N(-2362);
        $this->assertEquals('负二千三百六十二', $n->chinese());
    }


    public function testGettingChinesePositiveDecimalNumbersShouldSuccess()
    {
        $n = new N(16.98);
        $this->assertEquals('十六点九八', $n->chinese());
        $n = new N(75.4025);
        $this->assertEquals('七十五点四零二五', $n->chinese());
        $n = new N(0.1);
        $this->assertEquals('零点一', $n->chinese());
    }


    public function testGettingChineseNegativeDecimalNumbersShouldSuccess()
    {
        $n = new N(-16.98);
        $this->assertEquals('负十六点九八', $n->chinese());
        $n = new N(-75.4025);
        $this->assertEquals('负七十五点四零二五', $n->chinese());
        $n = new N(-0.1);
        $this->assertEquals('负零点一', $n->chinese());
    }

    public function testGettingChineseNumbersUsingSimplifiedZeroShouldSuccess()
    {
        $n = new N(0);
        $this->assertEquals('〇', $n->chinese(true));
        $this->assertEquals('〇', $n->chinese_other_zero);
        $this->assertEquals('〇', $n->mandarin_other_zero);
        $this->assertEquals('〇', $n->putonghua_other_zero);
        $n = new N(208);
        $this->assertEquals('二百〇八', $n->chinese(true));
        $n = new N(-75.4025);
        $this->assertEquals('负七十五点四〇二五', $n->chinese(true));
        $n = new N(-0.1);
        $this->assertEquals('负〇点一', $n->chinese(true));
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
    
    public function testGettingDecimalPartShouldReturnNObject()
    {
        $n = new N(4.0);
        $this->assertInstanceOf('\Malenki\Bah\N', $n->decimal);
    }

    public function testNumberGetDecimalPartShouldSuccess()
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

    public function testGettingDivisorsShouldReturnAObject()
    {
        $n = new N(3);
        $this->assertInstanceOf('\Malenki\Bah\A', $n->divisors);
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


    public function testGettingAbsoluteValueShouldReturnNObject()
    {
        $n = new N(-6);

        $this->assertInstanceOf('\Malenki\Bah\N', $n->abs);
    }


    public function testGettingAbsoluteValueAliasShouldReturnNObject()
    {
        $n = new N(-6);

        $this->assertInstanceOf('\Malenki\Bah\N', $n->absolute);
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
    }


    public function testGettingAbsoluteValueUsingAliasShouldHaveSameResultAsOriginalOne()
    {
        $n = new N(-6);
        $this->assertEquals($n->absolute, $n->abs);
        $n = new N(6);
        $this->assertEquals($n->absolute, $n->abs);
        $n = new N(-6.4);
        $this->assertEquals($n->absolute, $n->abs);
        $n = new N(6.4);
        $this->assertEquals($n->absolute, $n->abs);
    }

    public function testGettingOppositeValueShouldReturnNObject()
    {
        $n = new N(-6);

        $this->assertInstanceOf('\Malenki\Bah\N', $n->opposite);
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

    public function testGettingModuloUsingPrimitiveTypeShouldReturnNobject()
    {
        $n = new N(3);
        $this->assertInstanceOf('\Malenki\Bah\N', $n->mod(2));
    }


    public function testGettingModuloUsingObjectShouldReturnNobject()
    {
        $n = new N(3);
        $this->assertInstanceOf('\Malenki\Bah\N', $n->mod(new N(2)));
    }


    public function testGettingModuloAliasUsingPrimitiveTypeShouldReturnNobject()
    {
        $n = new N(3);
        $this->assertInstanceOf('\Malenki\Bah\N', $n->modulo(2));
    }


    public function testGettingModuloAliasUsingObjectShouldReturnNobject()
    {
        $n = new N(3);
        $this->assertInstanceOf('\Malenki\Bah\N', $n->modulo(new N(2)));
    }

    public function testGettingModuloShouldSuccess()
    {
        $n = new N(3);
        $this->assertEquals(1, $n->mod(2)->int);
        $this->assertEquals(1, $n->modulo(2)->int);

        $n = new N(3.3);
        $this->assertEquals((double) 1.3, $n->mod(2)->double);
    }

    public function testWhetherModuloAliasHasSameResultsAsOriginalOne()
    {
        $n = new N(3);
        $this->assertEquals($n->modulo(2), $n->mod(2));
        $this->assertEquals($n->modulo(new N(2)), $n->mod(new N(2)));

        $n = new N(3.3);
        $this->assertEquals($n->modulo(2), $n->mod(2));
        $this->assertEquals($n->modulo(new N(2)), $n->mod(new N(2)));

    }


    /**
     * @expectedException \InvalidArgumentException
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

    public function testGettingPowerUsingPrimitiveTypeShouldReturnNObject()
    {
        $n = new N(3);
        $this->assertInstanceOf('\Malenki\Bah\N', $n->pow(2));
    }


    public function testGettingPowerUsingObjectShouldReturnNObject()
    {
        $n = new N(3);
        $this->assertInstanceOf('\Malenki\Bah\N', $n->pow(new N(2)));
    }

    public function testGettingSquareShouldReturnNObject()
    {
        $n = new N(3);
        $this->assertInstanceOf('\Malenki\Bah\N', $n->square);
    }


    public function testGettingCubeShouldReturnNObject()
    {
        $n = new N(3);
        $this->assertInstanceOf('\Malenki\Bah\N', $n->cube);
    }


    public function testGettingPowerShouldsuccess()
    {
        $n = new N(3);
        $this->assertEquals(9, $n->pow(2)->int);
        $this->assertEquals(81, $n->pow(2)->pow(2)->int);
        $this->assertEquals(27, $n->pow(3)->int);

        $n = new N(-3);
        $this->assertEquals(9, $n->pow(2)->int);
        $this->assertEquals(81, $n->pow(2)->pow(2)->int);
        $this->assertEquals(-27, $n->pow(3)->int);

        $n = new N(2);
        $this->assertEquals(4, $n->pow(2)->int);

        $n = new N(-2);
        $this->assertEquals(4, $n->pow(2)->int);
    }
    
    
    public function testWhetherPowerHasSameResultAsItsAlias()
    {
        $n = new N(3);
        $this->assertEquals($n->square, $n->pow(2));
        $this->assertEquals($n->square->square, $n->pow(2)->pow(2));
        $this->assertEquals($n->cube, $n->pow(3));
        $this->assertEquals($n->cube->cube, $n->pow(3)->pow(3));

        $n = new N(-3);
        $this->assertEquals($n->square, $n->pow(2));
        $this->assertEquals($n->square->square, $n->pow(2)->pow(2));
        $this->assertEquals($n->cube, $n->pow(3));
        $this->assertEquals($n->cube->cube, $n->pow(3)->pow(3));

        $n = new N(2);
        $this->assertEquals($n->square, $n->pow(2));
        $this->assertEquals($n->square->square, $n->pow(2)->pow(2));
        $this->assertEquals($n->cube, $n->pow(3));
        $this->assertEquals($n->cube->cube, $n->pow(3)->pow(3));

        $n = new N(-2);
        $this->assertEquals($n->square, $n->pow(2));
        $this->assertEquals($n->square->square, $n->pow(2)->pow(2));
        $this->assertEquals($n->cube, $n->pow(3));
        $this->assertEquals($n->cube->cube, $n->pow(3)->pow(3));
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

    public function testGettingRootUsingPrimitiveTypeShouldReturnNObject()
    {
        $n = new N(8);
        $this->assertInstanceOf('\Malenki\Bah\N', $n->root(3));
    }

    public function testGettingRootUsingObjectShouldReturnNObject()
    {
        $n = new N(8);
        $this->assertInstanceOf('\Malenki\Bah\N', $n->root(new N(3)));
    }


    public function testGettingRootShouldSuccess()
    {
        $n = new N(8);

        $this->assertEquals(2, $n->root(3)->int);
        $this->assertEquals(2, $n->root(new N(3))->int);
        $this->assertEquals(8, $n->root(1)->int);
        $this->assertEquals(8, $n->root(new N(1))->int);

        $n = new N(9);

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

    public function testGettingSignShouldSuccess()
    {
        $n = new N(0);
        $this->assertEquals(0, $n->sign->int);
        $n = new N(-4);
        $this->assertEquals(-1, $n->sign->int);
        $n = new N(5.98);
        $this->assertEquals(1, $n->sign->int);
    }


    public function testFactorialShouldReturnNObject()
    {
        $n = new N(0);
        $this->assertInstanceOf('\Malenki\Bah\N', $n->factorial);
    }


    public function testFactorialAliasShouldReturnNObject()
    {
        $n = new N(0);
        $this->assertInstanceOf('\Malenki\Bah\N', $n->fact);
    }

    public function testFactorialShouldSuccess()
    {
        $n = new N(0);
        $this->assertEquals(1, $n->factorial->int);
        $n = new N(5);
        $this->assertEquals(120, $n->factorial->int);
        $n = new N(4);
        $this->assertEquals(24, $n->factorial->int);
    }

    public function testFactorialAliasShouldHaveSameResultAsOriginal()
    {
        $n = new N(0);
        $this->assertEquals($n->fact, $n->factorial);
        $n = new N(5);
        $this->assertEquals($n->fact, $n->factorial);
        $n = new N(4);
        $this->assertEquals($n->fact, $n->factorial);
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
    
    public function testGettingTriangularNumberShouldReturnNObject()
    {
        $n = new N(0);
        $this->assertInstanceOf('\Malenki\Bah\N', $n->triangular);
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

    public function testGettingInverseNumberShouldReturnNObject()
    {
        $n = new N(2);
        $this->assertInstanceOf('\Malenki\Bah\N', $n->inverse);
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

    public function TestGettingNumberIntoAnotherBaseUsingPrimitiveIntegerShouldReturnSObject()
    {
        $n = new N(19);
        $this->assertInstanceOf('\Malenki\Bah\S', $n->base(20));
    }


    public function TestGettingNumberIntoAnotherBaseUsingObjectShouldReturnSObject()
    {
        $n = new N(19);
        $this->assertInstanceOf('\Malenki\Bah\S', $n->base(new N(20)));
    }

    public function TestGettingNumberIntoAnotherBaseUsingPrimitiveIntegerShouldSuccess()
    {
        $n = new N(19);
        $this->assertEquals('j', $n->base(20));
        $n = new N(21);
        $this->assertEquals('11', $n->base(20));
        $n = new N(1979);
        $this->assertEquals('4ij', $n->base(20));
        $n = new N(1979);
        $this->assertEquals('1iz', $n->base(36));
    }

    public function TestGettingNumberIntoAnotherBaseUsingNegativeIntegerShouldSuccess()
    {
        $n = new N(-19);
        $this->assertEquals('-j', $n->base(20));
        $n = new N(-21);
        $this->assertEquals('-11', $n->base(20));
        $n = new N(-1979);
        $this->assertEquals('-4ij', $n->base(20));
        $n = new N(-1979);
        $this->assertEquals('-1iz', $n->base(36));
    }
    
    
    public function TestGettingNumberIntoAnotherBaseUsingNObjectShouldSuccess()
    {
        $n = new N(19);
        $n20 = new N(20);
        $n2 = new N(2);
        $n36 = new N(36);

        $this->assertEquals('j', $n->base($n20));
        $n = new N(21);
        $this->assertEquals('11', $n->base($n20));
        $n = new N(1979);
        $this->assertEquals('4ij', $n->base($n20));
        $n = new N(1979);
        $this->assertEquals('1iz', $n->base($n36));
    }


    /**
     * @expectedException \RuntimeException
     */
    public function TestGettingNumberIntoAnotherBaseWhenItIsDecimalShouldFail()
    {
        $n = new N(3.4);
        $n->base(2);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function TestGettingNumberIntoAnotherBaseUsingArgumentLessThanTwoShouldFail()
    {
        $n = new N(42);
        $n->base(1);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function TestGettingNumberIntoAnotherBaseUsingArgumentGreaterThanThirtySixShouldFail()
    {
        $n = new N(42);
        $n->base(37);
    }

    public function testGettingHexadecimalShouldReturnsSObject()
    {
        $n = new N(42);
        $this->assertInstanceOf('\Malenki\Bah\S', $n->hex);
    }


    public function testGettingOctalShouldReturnsSObject()
    {
        $n = new N(42);
        $this->assertInstanceOf('\Malenki\Bah\S', $n->oct);
    }


    public function testGettingBinaryShouldReturnsSObject()
    {
        $n = new N(42);
        $this->assertInstanceOf('\Malenki\Bah\S', $n->bin);
    }

    public function testGettingHexadecimalShouldSuccess()
    {
        $n = new N(42);
        $this->assertEquals('2a', $n->hex);
        $this->assertEquals(new S('2a'), $n->hex);
    }


    public function testGettingOctalShouldSuccess()
    {
        $n = new N(42);
        $this->assertEquals('52', $n->oct);
        $this->assertEquals(new S('52'), $n->oct);
    }


    public function testGettingBinaryShouldSuccess()
    {
        $n = new N(42);
        $this->assertEquals('101010', $n->bin);
        $this->assertEquals(new S('101010'), $n->bin);
    }


    public function testGettingHexadecimalUsingNegativeNumberShouldSuccess()
    {
        $n = new N(-42);
        $this->assertEquals('-2a', $n->hex);
        $this->assertEquals(new S('-2a'), $n->hex);
    }


    public function testGettingOctalUsingNegativeNumberShouldSuccess()
    {
        $n = new N(-42);
        $this->assertEquals('-52', $n->oct);
        $this->assertEquals(new S('-52'), $n->oct);
    }


    public function testGettingBinaryUsingNegativeNumberShouldSuccess()
    {
        $n = new N(-42);
        $this->assertEquals('-101010', $n->bin);
        $this->assertEquals(new S('-101010'), $n->bin);
    }

    public function testGettingHexadecimalNumberUsingAliasShouldHaveSameResultHasOriginal()
    {
        $n = new N(42);
        $this->assertEquals($n->hex, $n->h);
    }


    public function testGettingOctalNumberUsingAliasShouldHaveSameResultHasOriginal()
    {
        $n = new N(42);
        $this->assertEquals($n->oct, $n->o);
    }


    public function testGettingBinaryNumberUsingAliasShouldHaveSameResultHasOriginal()
    {
        $n = new N(42);
        $this->assertEquals($n->bin, $n->b);
    }


    /**
     * @expectedException \RuntimeException
     */
    public function testGettingHexadecimalUsingNonIntegerValueShouldFail()
    {
        $n = new N(M_PI);
        $n->hex;
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testGettingOctalUsingNonIntegerValueShouldFail()
    {
        $n = new N(M_PI);
        $n->oct;
    }


    /**
     * @expectedException \RuntimeException
     */
    public function testGettingBinaryUsingNonIntegerValueShouldFail()
    {
        $n = new N(M_PI);
        $n->bin;
    }


    public function testGettingHexadecimalShouldHaveSameResultAsBase()
    {
        $n = new N(42);
        $this->assertEquals($n->base(16), $n->hex);
    }


    public function testGettingOctalShouldHaveSameResultAsBase()
    {
        $n = new N(42);
        $this->assertEquals($n->base(8), $n->oct);
    }


    public function testGettingBinaryShouldHaveSameResultAsBase()
    {
        $n = new N(42);
        $this->assertEquals($n->base(2), $n->bin);
    }

    public function testGettingFloorValueShouldSuccess()
    {
        $n = new N(7.8);
        $seven = new N(7);
        $this->assertEquals($seven, $n->floor);
        $n = new N(7.1);
        $this->assertEquals($seven, $n->floor);
    }

    public function testGettingCeilValueShouldSuccess()
    {
        $n = new N(6.8);
        $seven = new N(7);
        $this->assertEquals($seven, $n->ceil);
        $n = new N(6.1);
        $this->assertEquals($seven, $n->ceil);
    }

    public function testGettingRoundValueShouldSuccess()
    {
        $n = new N(7.8);
        $seven = new N(7);
        $height = new N(8);
        $this->assertEquals($height, $n->round);
        $n = new N(7.1);
        $this->assertEquals($seven, $n->round);

        $n = new N(3.4);
        $this->assertEquals(new N(3), $n->round);

        $n = new N(3.5);
        $this->assertEquals(new N(4), $n->round);

        $n = new N(3.6);
        $this->assertEquals(new N(4), $n->round);

        $n = new N(3.6);
        $this->assertEquals(new N(4), $n->round(0));
        
        $n = new N(1.95583);
        $this->assertEquals(new N(1.96), $n->round(2));

        $n = new N(1241757);
        $this->assertEquals(new N(1242000), $n->round(-3));

        $n = new N(5.045);
        $this->assertEquals(new N(5.05), $n->round(2));

        $n = new N(5.055);
        $this->assertEquals(new N(5.06), $n->round(2));
    }

    public function testGettingRoundUpValueShouldSuccess()
    {
        $n = new N(1.5);
        $this->assertEquals(new N(2), $n->roundUp());
        $this->assertEquals(new N(2), $n->round_up);
        
        $n = new N(-1.5);
        $this->assertEquals(new N(-2), $n->roundUp());
        $this->assertEquals(new N(-2), $n->round_up);
        
        $n = new N(1.55);
        $this->assertEquals(new N(1.6), $n->roundUp(1));
        $n = new N(1.54);
        $this->assertEquals(new N(1.5), $n->roundUp(1));
        $n = new N(-1.55);
        $this->assertEquals(new N(-1.6), $n->roundUp(1));
        $n = new N(-1.54);
        $this->assertEquals(new N(-1.5), $n->roundUp(1));
    }
    
    public function testGettingRoundDownValueShouldSuccess()
    {
        $n = new N(1.5);
        $this->assertEquals(new N(1), $n->roundDown());
        $this->assertEquals(new N(1), $n->round_down);
        
        $n = new N(-1.5);
        $this->assertEquals(new N(-1), $n->roundDown());
        $this->assertEquals(new N(-1), $n->round_down);
        
        $n = new N(1.55);
        $np = new N(1.5);
        $this->assertEquals($np, $n->roundDown(1));
        $n = new N(1.54);
        $this->assertEquals($np, $n->roundDown(1));
        $n = new N(-1.55);
        $np = new N(-1.5);
        $this->assertEquals($np, $n->roundDown(1));
        $n = new N(-1.54);
        $this->assertEquals($np, $n->roundDown(1));
    }

    public function testGettingRoundEvenValueShouldSuccess()
    {
        $n = new N(9.5);
        $ten = new N(10);
        $this->assertEquals($ten, $n->roundEven());
        $this->assertEquals($ten, $n->round_even);
        
        $n = new N(8.5);
        $n8 = new N(8);
        $this->assertEquals($n8, $n->roundEven());
        $this->assertEquals($n8, $n->round_even);
        
        
        $n = new N(1.55);
        $n16 = new N(1.6);
        $n15 = new N(1.5);
        $this->assertEquals($n16, $n->roundEven(1));
        $n = new N(1.54);
        $this->assertEquals($n15, $n->roundEven(1));
        $n = new N(-1.55);
        $n16 = new N(-1.6);
        $n15 = new N(-1.5);
        $this->assertEquals($n16, $n->roundEven(1));
        $n = new N(-1.54);
        $this->assertEquals($n15, $n->roundEven(1));
    }

    public function testGettingRoundOddValueShouldSuccess()
    {
        $n = new N(9.5);
        $nine = new N(9);
        $this->assertEquals($nine, $n->roundOdd());
        $this->assertEquals($nine, $n->round_odd);
        
        $n = new N(8.5);
        $this->assertEquals($nine, $n->roundOdd());
        $this->assertEquals($nine, $n->round_odd);
        
        
        $n = new N(1.55);
        $n16 = new N(1.6);
        $n15 = new N(1.5);
        $this->assertEquals($n15, $n->roundOdd(1));
        $n = new N(1.54);
        $this->assertEquals($n15, $n->roundOdd(1));
        $n = new N(-1.55);
        $n16 = new N(-1.6);
        $n15 = new N(-1.5);
        $this->assertEquals($n15, $n->roundOdd(1));
        $n = new N(-1.54);
        $this->assertEquals($n15, $n->roundOdd(1));
    }

    public function testExecuteNTimesCallbackShouldSuccess()
    {
        $n = new N(7);

        $func = function($i){
            if($i->odd){
                return true;
            }

            return false;
        };

        $this->assertInstanceOf('\Malenki\Bah\A', $n->times($func));
        $this->assertCount(7, $n->times($func));
        $this->assertEquals(
            array(false, true, false, true, false, true, false), 
            $n->times($func)->array
        );
    }


    /**
     * @expectedException \RuntimeException
     */
    public function testExecuteNTimesCallbackWithNEqualsZeroShouldFail()
    {
        $n = new N(0);

        $func = function($i){
            if($i->odd){
                return true;
            }

            return false;
        };
        
        $n->times($func);

    }



    /**
     * @expectedException \RuntimeException
     */
    public function testExecuteNTimesCallbackWithNNonIntegerShouldFail()
    {
        $n = new N(2.3);

        $func = function($i){
            if($i->odd){
                return true;
            }

            return false;
        };
        
        $n->times($func);
    }
    


    /**
     * @expectedException \InvalidArgumentException
     */
    public function testExecuteNTimesCallbackWithNotCallableFunctionShouldFail()
    {
        $n = new N(3);

        $func = null;
        
        $n->times($func);
    }

    public function testIfItIsNotANumberShouldSuccess()
    {
        $n = new N(acos(M_PI));
        $this->assertTrue($n->nan);
        $this->assertTrue($n->is_nan);
        $this->assertTrue($n->is_not_a_number);
        
        $n = new N(42);
        $this->assertFalse($n->nan);
        $this->assertFalse($n->is_nan);
        $this->assertFalse($n->is_not_a_number);
    }


    public function testGettingCosineShouldReturnNObject()
    {
        $n = new N(0);
        $this->assertInstanceOf('\Malenki\Bah\N', $n->cos);
    }

    public function testGettingCosineShouldSuccess()
    {
        $n = new N(0);
        $this->assertEquals((double) cos(0), $n->cos->double);
        $n = new N(M_PI);
        $this->assertEquals((double) cos(M_PI), $n->cos->double);
        $n = new N(M_PI / 2);
        $this->assertEquals((double) cos(M_PI / 2), $n->cos->double);
    }
    

    public function testGettingSineShouldReturnNObject()
    {
        $n = new N(0);
        $this->assertInstanceOf('\Malenki\Bah\N', $n->sin);
    }

    public function testGettingSineShouldSuccess()
    {
        $n = new N(0);
        $this->assertEquals((double) sin(0), $n->sin->double);
        $n = new N(M_PI);
        $this->assertEquals((double) sin(M_PI), $n->sin->double);
        $n = new N(M_PI / 2);
        $this->assertEquals((double) sin(M_PI / 2), $n->sin->double);
    }
    

    public function testGettingTangentShouldReturnNObject()
    {
        $n = new N(0);
        $this->assertInstanceOf('\Malenki\Bah\N', $n->tan);
    }

    public function testGettingTangentShouldSuccess()
    {
        $n = new N(0);
        $this->assertEquals((double) tan(0), $n->tan->double);
        $n = new N(M_PI);
        $this->assertEquals((double) tan(M_PI), $n->tan->double);
        $n = new N(M_PI / 2);
        $this->assertEquals((double) tan(M_PI / 2), $n->tan->double);
    }

    public function testGettingHyperbolicCosineShouldReturnNObject()
    {
        $n = new N(0);
        $this->assertInstanceOf('\Malenki\Bah\N', $n->cosh);
    }
    

    public function testGettingHyperbolicCosineShouldSuccess()
    {
        $n = new N(0);
        $this->assertEquals((double) cosh(0), $n->cosh->double);
        $n = new N(M_PI);
        $this->assertEquals((double) cosh(M_PI), $n->cosh->double);
        $n = new N(M_PI / 2);
        $this->assertEquals((double) cosh(M_PI / 2), $n->cosh->double);
    }
    

    public function testGettingHyperbolicSineShouldReturnNObject()
    {
        $n = new N(0);
        $this->assertInstanceOf('\Malenki\Bah\N', $n->sinh);
    }

    public function testGettingHyperbolicSineShouldSuccess()
    {
        $n = new N(0);
        $this->assertEquals((double) sinh(0), $n->sinh->double);
        $n = new N(M_PI);
        $this->assertEquals((double) sinh(M_PI), $n->sinh->double);
        $n = new N(M_PI / 2);
        $this->assertEquals((double) sinh(M_PI / 2), $n->sinh->double);
    }
    

    public function testGettingHyperbolicTangentShouldReturnNObject()
    {
        $n = new N(0);
        $this->assertInstanceOf('\Malenki\Bah\N', $n->tanh);
    }

    public function testGettingHyperbolicTangentShouldSuccess()
    {
        $n = new N(0);
        $this->assertEquals((double) tanh(0), $n->tanh->double);
        $n = new N(M_PI);
        $this->assertEquals((double) tanh(M_PI), $n->tanh->double);
        $n = new N(M_PI / 2);
        $this->assertEquals((double) tanh(M_PI / 2), $n->tanh->double);
    }
    

    public function testGettingArcCosineShouldReturnNObject()
    {
        $n = new N(0);
        $this->assertInstanceOf('\Malenki\Bah\N', $n->acos);
    }

    public function testGettingArcCosineShouldSuccess()
    {
        $n = new N(0);
        $this->assertEquals((double) acos(0), $n->acos->double);
        $n = new N(M_PI);
        $this->assertTrue($n->acos->nan); //NaN
        $n = new N(M_PI / 2);
        $this->assertTrue($n->acos->nan);
    }
    

    public function testGettingArcSineShouldReturnNObject()
    {
        $n = new N(0);
        $this->assertInstanceOf('\Malenki\Bah\N', $n->asin);
    }

    public function testGettingArcSineShouldSuccess()
    {
        $n = new N(0);
        $this->assertEquals((double) asin(0), $n->asin->double);
        $n = new N(M_PI);
        $this->assertTrue($n->asin->nan); // NaN
        $n = new N(M_PI / 2);
        $this->assertTrue($n->asin->nan);
    }
    

    public function testGettingArcTangentShouldReturnNObject()
    {
        $n = new N(0);
        $this->assertInstanceOf('\Malenki\Bah\N', $n->atan);
    }

    public function testGettingArcTangentShouldSuccess()
    {
        $n = new N(0);
        $this->assertEquals((double) atan(0), $n->atan->double);
        $n = new N(M_PI);
        $this->assertEquals((double) atan(M_PI), $n->atan->double);
        $n = new N(M_PI / 2);
        $this->assertEquals((double) atan(M_PI / 2), $n->atan->double);
    }
    
    public function testGettingInverseHyperbolicCosineShouldReturnNObject()
    {
        $n = new N(0);
        $this->assertInstanceOf('\Malenki\Bah\N', $n->acosh);
    }

    public function testGettingInverseHyperbolicCosineShouldSuccess()
    {
        $n = new N(0);
        $this->assertTrue($n->acosh->nan); //NaN
        $n = new N(M_PI);
        $this->assertEquals((double) acosh(M_PI), $n->acosh->double);
        $n = new N(M_PI / 2);
        $this->assertEquals((double) acosh(M_PI / 2), $n->acosh->double);
    }
    
    public function testGettingInverseHyperbolicSineShouldReturnNObject()
    {
        $n = new N(0);
        $this->assertInstanceOf('\Malenki\Bah\N', $n->asinh);
    }

    public function testGettingInverseHyperbolicSineShouldSuccess()
    {
        $n = new N(0);
        $this->assertEquals((double) asinh(0), $n->asinh->double);
        $n = new N(M_PI);
        $this->assertEquals((double) asinh(M_PI), $n->asinh->double);
        $n = new N(M_PI / 2);
        $this->assertEquals((double) asinh(M_PI / 2), $n->asinh->double);
    }
    

    public function testGettingInverseHyperbolicTangentShouldreturnNObject()
    {
        $n = new N(0);
        $this->assertInstanceOf('\Malenki\Bah\N', $n->atanh);
    }

    public function testGettingInverseHyperbolicTangentShouldSuccess()
    {
        $n = new N(0);
        $this->assertEquals((double) atanh(0), $n->atanh->double);
        $n = new N(M_PI);
        $this->assertTrue($n->atanh->nan); //NaN
        $n = new N(M_PI / 2);
        $this->assertTrue($n->atanh->nan);
    }

    public function testGettingExponentialShouldReturnNObject()
    {
        $n = new N(1);
        $this->assertInstanceOf('\Malenki\Bah\N', $n->exp);
    }

    public function testGettingExponentialUsingAliasShouldReturnNObject()
    {
        $n = new N(1);
        $this->assertInstanceOf('\Malenki\Bah\N', $n->exponent);
    }

    public function testWhetherEpxonentialFeatureAndItsAliasAreSameResults()
    {
        $n = new N(1);
        $this->assertEquals($n->exponent->double, $n->exp->double);
        $n = new N(0);
        $this->assertEquals($n->exponent->double, $n->exp->double);
    }

    public function testGettingExponentialShouldSucces()
    {
        $n = new N(1);
        $this->assertEquals(M_E, $n->exp->double);
        $n = new N(0);
        $this->assertEquals((double) 1, $n->exp->double);
    }

    public function testIfNumberIsFiniteShouldSuccess()
    {
        $n = new N(42);
        $this->assertTrue($n->exp->finite);
        $this->assertTrue($n->exp->is_finite);
        
        $n = new N(90000000);
        $this->assertFalse($n->exp->finite);
        $this->assertFalse($n->exp->is_finite);
    }
    
    public function testIfNumberIsInfiniteShouldSuccess()
    {
        $n = new N(42);
        $this->assertFalse($n->exp->infinite);
        $this->assertFalse($n->exp->is_infinite);
        
        $n = new N(90000000);
        $this->assertTrue($n->exp->infinite);
        $this->assertTrue($n->exp->is_infinite);
    }
}

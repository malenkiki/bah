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

use Malenki\Bah\S;
use Malenki\Bah\N;
use Malenki\Bah\C;
use Malenki\Bah\A;
use Malenki\Bah\H;

class STest extends PHPUnit_Framework_TestCase
{
    public function testUsingToStringFeatureShouldSuccess()
    {
        $s = new S('I am a string!');
        $this->assertEquals('I am a string!', $s->string);
        $this->assertEquals('I am a string!', $s);
        $this->assertEquals('I am a string!', "$s");
    }

    public function testConvertingObjectToPrimitiveStringShouldSuccess()
    {
        $c = new S('abc');
        $this->assertInternalType('string', $c->string);
        $this->assertEquals('abc', $c->string);
    }


    public function testConvertingObjectToPrimitiveStringUsingShortFormShouldSuccess()
    {
        $c = new S('abc');
        $this->assertInternalType('string', $c->str);
        $this->assertEquals('abc', $c->str);
    }


    public function testConvertingObjectToPrimitiveIntegerShouldSuccess()
    {
        $c = new S('42');
        $this->assertInternalType('integer', $c->integer);
        $this->assertEquals(42, $c->integer);
    }


    public function testConvertingObjectToPrimitiveIntegerUsingShortFormShouldSuccess()
    {
        $c = new S('42');
        $this->assertInternalType('integer', $c->int);
        $this->assertEquals(42, $c->int);
    }

    public function testConvertingObjectToPrimitiveFloatShouldSuccess()
    {
        $c = new S('12.34');
        $this->assertInternalType('float', $c->float);
        $this->assertEquals(12.34, $c->float);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testConvertingObjectToIntegerShouldFail()
    {
        $c = new S('Le 31 décembre.');
        $c->integer;
    }


    /**
     * @expectedException \RuntimeException
     */
    public function testConvertingObjectToIntegerUsingAliasShouldFail()
    {
        $c = new S('Le 31 décembre.');
        $c->int;
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testConvertingObjectToFloatShouldFail()
    {
        $c = new S('Le 31 décembre.');
        $c->float;
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testConvertingObjectTodoubleShouldFail()
    {
        $c = new S('Le 31 décembre.');
        $c->double;
    }



    public function testConvertingObjectToPrimitiveDoubleShouldSuccess()
    {
        $c = new S('12.34');
        $this->assertEquals((double) 12.34, $c->double);
    }


    public function testConvertingStringHavingOneCharToCObjectShouldSuccess()
    {
        $s = new S('ç');

        $this->assertEquals(new C('ç'), $s->to_c);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testConvertingStringHavingMoreThanOneCharactersToCObjectShouldFail()
    {
        $s = new S('Hello!');
        $s->to_c;
    }


    public function testConvertingStringToNObjectShouldSuccess()
    {
        $s = new S('42');

        $this->assertEquals(new N(42), $s->to_n);
    }


    public function testConvertingStringHavingFloatToNObjectShouldSuccess()
    {
        $s = new S('3.14');

        $this->assertEquals(new N(3.14), $s->to_n);
    }


    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSInstanciatingUsingNotUTF8StringShouldFail()
    {
        $s = new S(chr(0xA4)); // € in ISO-8859-15
    }

    public function testGettingCountFromInterfaceShouldSuccess()
    {
        $s = new S('J’écris en français !');
        $this->assertEquals(21, count($s));
        $s = new S('J\'ecris en francais !');
        $this->assertEquals(21, count($s));
    }

    public function testGettingCountUsingObjectShouldSuccess()
    {
        $s = new S('J’écris en français !');
        $this->assertEquals(21, $s->length->int);
        $s = new S('J\'ecris en francais !');
        $this->assertEquals(21, $s->length->int);
    }

    public function testGettingCountFromInterfaceOrObjectShouldHasEqualResults()
    {
        $s = new S('J’écris en français !');
        $this->assertEquals(count($s), $s->length->int);
        $s = new S('J\'ecris en francais !');
        $this->assertEquals(count($s), $s->length->int);
    }

    public function testGettingUppercaseValueShouldBeSObject()
    {
        $s = new S('Je suis une chaîne !');
        $this->assertInstanceOf('\Malenki\Bah\S', $s->upper);
    }


    public function testGettingLowercaseValueShouldBeSObject()
    {
        $s = new S('Je suis une chaîne !');
        $this->assertInstanceOf('\Malenki\Bah\S', $s->lower);
    }

    public function testGettingUppercaseShouldSuccess()
    {
        $s = new S('Je suis une chaîne !');
        $this->assertEquals('JE SUIS UNE CHAÎNE !', $s->upper);
        $s = new S('JE SUIS UNE CHAÎNE !');
        $this->assertEquals('JE SUIS UNE CHAÎNE !', $s->upper);
    }

    public function testGettingLowercaseShouldSuccess()
    {
        $s = new S('Je suis une chaîne !');
        $this->assertEquals('je suis une chaîne !', $s->lower);
        $s = new S('JE SUIS UNE CHAÎNE !');
        $this->assertEquals('je suis une chaîne !', $s->lower);
        $s = new S('je suis une chaîne !');
        $this->assertEquals('je suis une chaîne !', $s->lower);
    }


    public function testGettingTitleValueShouldBeSObject()
    {
        $s = new S('Je suis une chaîne !');
        $this->assertInstanceOf('\Malenki\Bah\S', $s->title);
    }

    public function testGettingTitleShouldSuccess()
    {
        $s = new S('Je suis une chaîne !');
        $this->assertEquals('Je Suis Une Chaîne !', $s->title);
        $s = new S('JE SUIS UNE CHAÎNE !');
        $this->assertEquals('Je Suis Une Chaîne !', $s->title);
        $s = new S('je suis une chaîne !');
        $this->assertEquals('Je Suis Une Chaîne !', $s->title);
    }

    public function testCheckingStringShouldBeVoidOrNotShouldSuccess()
    {
        $s = new S('');
        $this->assertTrue($s->void);
        $this->assertTrue($s->is_void);
        $this->assertTrue($s->empty);
        $this->assertTrue($s->is_empty);

        $s = new S('something');
        $this->assertFalse($s->void);
        $this->assertFalse($s->empty);
        $this->assertFalse($s->is_void);
        $this->assertFalse($s->is_empty);
    }

    public function testStringMatchingUsingStringShouldBeTrue()
    {
        $s = new S('az/erty');
        $this->assertTrue($s->startsWith('az/'));
        $this->assertTrue($s->endsWith('ty'));
        $this->assertTrue($s->match('/ert/'));
        $this->assertTrue($s->regexp('/ert/'));
        $this->assertTrue($s->re('/ert/'));
    }

    public function testStringMatchingUsingSObjectShouldBeTrue()
    {
        $s = new S('az/erty');
        $this->assertTrue($s->startsWith(new S('az/')));
        $this->assertTrue($s->endsWith(new S('ty')));
        $this->assertTrue($s->match(new S('/ert/')));
        $this->assertTrue($s->regexp(new S('/ert/')));
        $this->assertTrue($s->re(new S('/ert/')));
    }

    public function testStringMatchingUsingStringShouldBeFalse()
    {
        $s = new S('az/erty');
        $this->assertFalse($s->startsWith('z/'));
        $this->assertFalse($s->endsWith('t'));
        $this->assertFalse($s->match('/ern/'));
        $this->assertFalse($s->regexp('/ern/'));
        $this->assertFalse($s->re('/ern/'));
    }

    public function testStringMatchingUsingSObjectShouldBeFalse()
    {
        $s = new S('az/erty');
        $this->assertFalse($s->startsWith(new S('z/')));
        $this->assertFalse($s->endsWith(new S('t')));
        $this->assertFalse($s->match(new S('/ern/')));
        $this->assertFalse($s->regexp(new S('/ern/')));
        $this->assertFalse($s->re(new S('/ern/')));
    }

    public function testGettingCharsCollectionShouldReturnAObject()
    {
        $s = new S('Je suis une chaîne !');
        $this->assertInstanceOf('\Malenki\Bah\A', $s->chars);
    }


    public function testGettingCharsCountShouldBeNObject()
    {
        $s = new S('Je suis une chaîne !');
        $this->assertInstanceOf('\Malenki\Bah\N', $s->chars->length);
    }

    public function testWhetherCharsCountIsSameAsStringLength()
    {
        $s = new S('Je suis une chaîne !');
        $this->assertEquals($s->length, $s->chars->length);
        $this->assertEquals(count($s), $s->chars->length->int);
        $this->assertEquals(count($s), count($s->chars));
    }

    public function testWhetheriExtractedCharsFromStringAreCObjects()
    {
        $s = new S('Je suis une chaîne !');
        $this->assertInstanceOf('\Malenki\Bah\C', $s->chars->first);
        $this->assertInstanceOf('\Malenki\Bah\C', $s->chars->last);
        $this->assertInstanceOf('\Malenki\Bah\C', $s->chars->last_but_one);
        $this->assertInstanceOf('\Malenki\Bah\C', $s->chars->take(3));
    }

    public function testGettingSomeCharsAtSomeIndexMustBeSameAsStringIndex()
    {
        $s = new S('Je suis une chaîne !');
        $this->assertEquals($s->charAt(0), $s->chars->first);
        $this->assertEquals($s->charAt(19), $s->chars->last);
        $this->assertEquals($s->charAt(18), $s->chars->last_but_one);
        $this->assertEquals($s->charAt(3), $s->chars->take(3));
    }

    public function testiGettingSubstringShouldReturnSObject()
    {
        $s = new S('Je suis une chaîne !');
        $this->assertInstanceOf('\Malenki\Bah\S', $s->sub(0, 7));
    }

    public function testiGettingSubstringUsingIntegerAsParamsShouldSuccess()
    {
        $s = new S('Je suis une chaîne !');
        $this->assertEquals('Je suis', $s->sub(0, 7));
        $this->assertEquals('suis', $s->sub(3, 4));
    }

    public function testiGettingSubstringUsingNObjectsAsParamsShouldSuccess()
    {
        $s = new S('Je suis une chaîne !');
        $this->assertEquals('Je suis', $s->sub(new N(0), new N(7)));
        $this->assertEquals('suis', $s->sub(new N(3), new N(4)));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSubstringWithNegativeOffsetShouldRaiseException()
    {
        $s = new S('Je suis une chaîne !');
        $this->assertEquals('Je suis', $s->sub(-3, 7));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSubstringWithNegativeLimitShouldRaiseException()
    {
        $s = new S('Je suis une chaîne !');
        $this->assertEquals('Je suis', $s->sub(0, -7));
    }
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSubstringWithNegativeOffsetAsObjectShouldRaiseException()
    {
        $s = new S('Je suis une chaîne !');
        $this->assertEquals('Je suis', $s->sub(new N(-3), new N(7)));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSubstringWithNegativeLimitAsObjectShouldRaiseException()
    {
        $s = new S('Je suis une chaîne !');
        $this->assertEquals('Je suis', $s->sub(new N(0), new N(-7)));
    }

    public function testGettingMarginShouldReturnSObject()
    {
        //TODO: test multiline and alinea
        $s = new S('something');
        $this->assertInstanceOf('\Malenki\Bah\S', $s->margin(5));
    }

    public function testGettingLeftMarginUsingIntegerArgsShouldSuccess()
    {
        //TODO: test multiline and alinea
        $s = new S('something');
        $this->assertEquals('     something', $s->margin(5));
    }

    public function testGettingLeftMarginUsingNObjectsAsArgsShouldSuccess()
    {
        //TODO: test multiline and alinea
        $s = new S('something');
        $this->assertEquals('     something', $s->margin(new N(5)));
    }

    public function testGettingRightMarginUsingIntegerArgsShouldSuccess()
    {
        //TODO: test multiline and alinea
        $s = new S('something');
        $this->assertEquals('something     ', $s->margin(0, 5));
    }

    public function testGettingRightMarginUsingNObjectAsArgsShouldSuccess()
    {
        //TODO: test multiline and alinea
        $s = new S('something');
        $this->assertEquals('something     ', $s->margin(new N(0), new N(5)));
    }

    public function testGettingLeftAndRightMarginsUsingIntegerArgsShouldSuccess()
    {
        //TODO: test multiline and alinea
        $s = new S('something');
        $this->assertEquals('     something     ', $s->margin(5, 5));
        $this->assertEquals('     something          ', $s->margin(5, 10));
    }

    public function testGettingLeftAndRightMarginsUsingNOjectsAsArgsShouldSuccess()
    {
        //TODO: test multiline and alinea
        $s = new S('something');
        $this->assertEquals('     something     ', $s->margin(new N(5), new N(5)));
        $this->assertEquals('     something          ', $s->margin(new N(5), new N(10)));
    }

    public function testWhetherSplitingStringReturnsAObject()
    {
        $s = new S('one, two, three, four');
        $this->assertInstanceOf('\Malenki\Bah\A', $s->split('/[\s,]+/'));
    }

    public function testWhetherSplittingStringReturnsCollectionOfSObjects()
    {
        $s = new S('one, two, three, four');
        $a = $s->split('/[\s,]+/');
        $this->assertInstanceOf('\Malenki\Bah\S', $a->first);
        $this->assertInstanceOf('\Malenki\Bah\S', $a->take(2));
        $this->assertInstanceOf('\Malenki\Bah\S', $a->last_but_one);
        $this->assertInstanceOf('\Malenki\Bah\S', $a->last);
    }

    public function testSplitingStringShouldSuccess()
    {
        $s = new S('one, two, three, four');
        $this->assertEquals(
            array(new S('one'), new S('two'), new S('three'), new S('four')),
            $s->split('/[\s,]+/')->array
        );
        $this->assertEquals(
            array(new S('one'), new S('two'), new S('three'), new S('four')),
            $s->cut('/[\s,]+/')->array
        );
        $this->assertEquals(
            array(new S('one'), new S('two'), new S('three'), new S('four')),
            $s->explode('/[\s,]+/')->array
        );
        $this->assertEquals(
            array(new S('one'), new S('two'), new S('three'), new S('four')),
            $s->split(new S('/[\s,]+/'))->array
        );
        $this->assertEquals(
            array(new S('one'), new S('two'), new S('three'), new S('four')),
            $s->cut(new S('/[\s,]+/'))->array
        );
        $this->assertEquals(
            array(new S('one'), new S('two'), new S('three'), new S('four')),
            $s->explode(new S('/[\s,]+/'))->array
        );
    }





    public function testStringActAsRegexpShouldSuccess()
    {
        $s = new S('/\s+/');
        $this->assertTrue($s->test('one string with spaces'));
        $this->assertFalse($s->test('one_string_w/o_spaces'));
        $this->assertTrue($s->test(new S('one string with spaces')));
        $this->assertFalse($s->test(new S('one_string_w/o_spaces')));
        $s = new S('/’/');
        $this->assertTrue($s->test('C’est OK'));
        $this->assertFalse($s->test("C'est KO"));
        $s = new S('/[0-9]+/');
        $this->assertTrue($s->test('1 digit'));
        $this->assertTrue($s->test('1'));
        $this->assertTrue($s->test(1));
        $this->assertTrue($s->test(new N(1)));
        $this->assertFalse($s->test("no digit"));
    }

    public function testUsingMethodToGetChunksAsAObjectShouldSuccess()
    {
        $s = new S('abcde');
        $this->assertInstanceOf('\Malenki\Bah\A', $s->chunk());
    }


    public function testUsingMagicGetterToGetChunksAsAObjectShouldSuccess()
    {
        $s = new S('abcde');
        $this->assertInstanceOf('\Malenki\Bah\A', $s->chunk);
    }

    public function testGettingChunkWithoutArgShouldBeEqualToUseMagicGetter()
    {
        $s = new S('abcde');
        $this->assertEquals($s->chunk(), $s->chunk);
    }
    
    public function testWhetherGettingChunksReturnsCollectionOfSObjects()
    {
        $s = new S('abc');
        $this->assertInstanceOf('\Malenki\Bah\S', $s->chunk->first);
        $this->assertInstanceOf('\Malenki\Bah\S', $s->chunk->last_but_one);
        $this->assertInstanceOf('\Malenki\Bah\S', $s->chunk->last);
    }


    public function testGettingChunksWithoutArgShouldReturnCollectionOfOneLetterStrings()
    {
        $s = new S('abcde');
        $must = new A();
        $must->add(new S('a'));
        $must->add(new S('b'));
        $must->add(new S('c'));
        $must->add(new S('d'));
        $must->add(new S('e'));
        $this->assertEquals($must, $s->chunk());
    }

    public function testGettingChunksUsingMagicGetterShouldReturnCollectionOfOneLetterStrings()
    {
        $s = new S('abcde');
        $must = new A();
        $must->add(new S('a'));
        $must->add(new S('b'));
        $must->add(new S('c'));
        $must->add(new S('d'));
        $must->add(new S('e'));
        $this->assertEquals($must, $s->chunk);
    }

    public function testGettingChunksShouldSuccess()
    {
        $s = new S('C’est une chaîne qu’on va découper !');
        $must = new A();
        $must->add(new S('C’est u'));
        $must->add(new S('ne chaî'));
        $must->add(new S('ne qu’o'));
        $must->add(new S('n va dé'));
        $must->add(new S('couper '));
        $must->add(new S('!'));
        $this->assertEquals($must, $s->chunk(7));
    }


    public function testGettingChunksUsingArgAsObjectShouldSuccess()
    {
        $s = new S('C’est une chaîne qu’on va découper !');
        $must = new A();
        $must->add(new S('C’est u'));
        $must->add(new S('ne chaî'));
        $must->add(new S('ne qu’o'));
        $must->add(new S('n va dé'));
        $must->add(new S('couper '));
        $must->add(new S('!'));
        $this->assertEquals($must, $s->chunk(new N(7)));
    }

    public function testGettingChunksUsingIntOrObjectArgShouldGiveSameResult()
    {
        $s = new S('C’est une chaîne qu’on va découper !');
        $this->assertEquals($s->chunk(7), $s->chunk(new N(7)));
    }

    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGettingChunksHavingBadSizeAsIntegerShouldFail()
    {
        $s = new S('abcde');
        $s->chunk(0);
    }

    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGettingChunksHavingBadSizeAsObjectShouldFail()
    {
        $s = new S('abcde');
        $s->chunk(new N(0));
    }

    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGettingChunksHavingBadSizeTypeShouldFail()
    {
        $s = new S('abcde');
        $s->chunk("zero");
    }




    public function testIfUsingChangeFeatureReturnsSObject()
    {
        $s = new S('This string must change a little');
        $this->assertInstanceOf('\Malenki\Bah\S', $s->change('/ a little$/', '!'));
    }

    public function testIfUsingChangeFeatureAliasReturnsSObject()
    {
        $s = new S('This string must change a little');
        $this->assertInstanceOf('\Malenki\Bah\S', $s->replace('/ a little$/', '!'));
    }


    public function testGettingReplacementStringUsingStringShouldSuccess()
    {
        $s = new S('This string must change a little');
        $this->assertEquals('This string must change!', $s->change('/ a little$/', '!'));
        $this->assertEquals('This string must change!', $s->replace('/ a little$/', '!'));
    }
    
    public function testGettingReplacementStringUsingSObjectShouldSuccess()
    {
        $s = new S('This string must change a little');
        $this->assertEquals('This string must change!', $s->change(new S('/ a little$/'), new S('!')));
        $this->assertEquals('This string must change!', $s->replace(new S('/ a little$/'), new S('!')));
    }
    
    public function testGettingReplacementStringUsingObjectHavingToStringShouldSuccess()
    {
        $s = new S('This string must change a little');
        $this->assertEquals('This string must change!', $s->change(new S('/ a little$/'), new C('!')));
        $this->assertEquals('This string must change!', $s->replace(new S('/ a little$/'), new C('!')));
    }



    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGettingReplacementStringWithNonStringPatternShouldFail()
    {
        $s = new S('This string must change a little');
        $s->change(array('/ a little$/'), '!');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGettingReplacementStringWithNonStringReplacementShouldFail()
    {
        $s = new S('This string must change a little');
        $s->change('/ a little$/', null);
    }






    public function testIfStringIsFullLeftToRightShouldSuccess()
    {
        $s = new S('Ceci est du français tout à fait banal.');
        $this->assertTrue($s->ltr);
        $this->assertTrue($s->is_ltr);
        $this->assertTrue($s->is_left_to_right);
        $this->assertTrue($s->left_to_right);
    }
    
    public function testIfStringIsFullRightToLeftShouldSuccess()
    {
        $s = new S('أبجد');
        $this->assertTrue($s->rtl);
        $this->assertTrue($s->is_rtl);
        $this->assertTrue($s->is_right_to_left);
        $this->assertTrue($s->right_to_left);
    }

    public function testIfStringHasBothRtlAndLtrPartsShouldSuccess()
    {
        $s = new S('Ceci est du français contenant le mot arabe أبجد qui veut dire "abjad".');
        $this->assertTrue($s->has_mixed_direction);
        $this->assertTrue($s->mixed_direction);
        $this->assertTrue($s->is_ltr_and_rtl);
        $this->assertTrue($s->ltr_and_rtl);
        $this->assertTrue($s->is_rtl_and_ltr);
        $this->assertTrue($s->rtl_and_ltr);
    }

    public function testIfStringHasNotBothRtlAndLtrPartsShouldSuccess()
    {
        $s = new S('Ceci est du français tout à fait banal.');
        $this->assertFalse($s->has_mixed_direction);
        $this->assertFalse($s->mixed_direction);
        $this->assertFalse($s->is_ltr_and_rtl);
        $this->assertFalse($s->ltr_and_rtl);
        $this->assertFalse($s->is_rtl_and_ltr);
        $this->assertFalse($s->rtl_and_ltr);
        
        $s = new S('أبجد');
        $this->assertFalse($s->has_mixed_direction);
        $this->assertFalse($s->mixed_direction);
        $this->assertFalse($s->is_ltr_and_rtl);
        $this->assertFalse($s->ltr_and_rtl);
        $this->assertFalse($s->is_rtl_and_ltr);
        $this->assertFalse($s->rtl_and_ltr);
    }

    public function testStringHavingTwoDirectionsShouldNotBeRtl()
    {
        $s = new S('Ceci est du français contenant le mot arabe أبجد qui veut dire "abjad".');
        $this->assertFalse($s->rtl);
        $this->assertFalse($s->is_rtl);
        $this->assertFalse($s->is_right_to_left);
        $this->assertFalse($s->right_to_left);
    }

    public function testStringHavingTwoDirectionsShouldNotBeLtr()
    {
        $s = new S('Ceci est du français contenant le mot arabe أبجد qui veut dire "abjad".');
        $this->assertFalse($s->ltr);
        $this->assertFalse($s->is_ltr);
        $this->assertFalse($s->is_left_to_right);
        $this->assertFalse($s->left_to_right);
    }



    public function testIfRightStripCallReturnsSObject()
    {
        $s = new S('I have some spaces                 ');
        $this->assertInstanceOf('\Malenki\Bah\S', $s->rstrip());
    }


    public function testIfLeftStripCallReturnsSObject()
    {
        $s = new S('             I have some spaces');
        $this->assertInstanceOf('\Malenki\Bah\S', $s->lstrip());
    }


    public function testIfStripCallReturnsSObject()
    {
        $s = new S('        I have some spaces                 ');
        $this->assertInstanceOf('\Malenki\Bah\S', $s->strip());
    }


    public function testRemovingTrailingWhitespaceFromTheStringShouldSuccess()
    {
        $s = new S('I have some spaces                 ');
        $this->assertEquals('I have some spaces', $s->rstrip());
        $this->assertEquals('I have some spaces', $s->rstrip);
    }

    public function testRemovingLeadingWhitespaceFromTheStringShouldSuccess()
    {
        $s = new S("    \t   \t     I have some spaces");
        $this->assertEquals('I have some spaces', $s->lstrip());
        $this->assertEquals('I have some spaces', $s->lstrip);
    }

    public function testRemovingBothLeadingAndTrailingWhitespaceFromTheStringShouldSuccess()
    {
        $s = new S("    \t   \t     I have some spaces   \t \t   ");
        $this->assertEquals('I have some spaces', $s->strip());
        $this->assertEquals('I have some spaces', $s->strip);
        $this->assertEquals($s->lstrip->rstrip, $s->strip);
    }
    
    public function testRemovingTrailingCustomCharsFromTheStringShouldSuccess()
    {
        $s = new S('I have some...');
        $this->assertEquals('I have some', $s->rstrip('.'));
        $this->assertEquals('I have some', $s->rstrip(new S('.')));
        $this->assertEquals('I have some', $s->rstrip(new C('.')));

        $s = new S('I have some...!?');
        $a = new A();
        $a->add(new C('.'));
        $a->add('!');
        $a->add(new S('?'));
        $this->assertEquals('I have some', $s->rstrip('.!?'));
        $this->assertEquals('I have some', $s->rstrip(new S('.!?')));
        $this->assertEquals('I have some', $s->rstrip($a));
        $this->assertEquals('I have some', $s->rstrip(array('.', '!', '?')));
        $this->assertEquals('I have some', $s->rstrip(array(new S('.'), '!', new C('?'))));
    }

    public function testRemovingLeadingCustomCharsFromTheStringShouldSuccess()
    {
        $s = new S("--------------I have something");
        $this->assertEquals('I have something', $s->lstrip('-'));
        $this->assertEquals('I have something', $s->lstrip(new S('-')));
        $this->assertEquals('I have something', $s->lstrip(new C('-')));
        $s = new S("-----__--_----I have something");
        $a = new A();
        $a->add(new C('-'));
        $a->add('_');
        $this->assertEquals('I have something', $s->lstrip('-_'));
        $this->assertEquals('I have something', $s->lstrip(new S('-_')));
        $this->assertEquals('I have something', $s->lstrip($a));
        $this->assertEquals('I have something', $s->lstrip(array('-', '_')));
        $this->assertEquals('I have something', $s->lstrip(array(new S('-'), new C('_'))));
    }

    public function testRemovingBothLeadingAndTrailingCustomCharsFromTheStringShouldSuccess()
    {
        $s = new S("---==--==---I have some spaces---=--=-=-=");
        $a = new A();
        $a->add(new C('-'));
        $a->add('=');
        $this->assertEquals('I have some spaces', $s->strip('-='));
        $this->assertEquals('I have some spaces', $s->strip(new S('-=')));
        $this->assertEquals('I have some spaces', $s->strip($a));
        $this->assertEquals($s->lstrip('-=')->rstrip('-='), $s->strip('-='));
        $this->assertEquals($s->lstrip($a)->rstrip('-='), $s->strip('-='));
        $this->assertEquals($s->lstrip('-=')->rstrip($a), $s->strip('-='));
        $this->assertEquals($s->lstrip('-=')->rstrip('-='), $s->strip($a));
        $a = array('-', '=');
        $this->assertEquals($s->lstrip($a)->rstrip('-='), $s->strip('-='));
        $this->assertEquals($s->lstrip('-=')->rstrip($a), $s->strip('-='));
        $this->assertEquals($s->lstrip('-=')->rstrip('-='), $s->strip($a));
        $a = array(new S('-'), new C('='));
        $this->assertEquals($s->lstrip($a)->rstrip('-='), $s->strip('-='));
        $this->assertEquals($s->lstrip('-=')->rstrip($a), $s->strip('-='));
        $this->assertEquals($s->lstrip('-=')->rstrip('-='), $s->strip($a));
    }

    public function testAppendingStringShouldReturnSObject()
    {
        $s = new S('foo');
        $this->assertInstanceOf('\Malenki\Bah\S', $s->append(' bar'));
    }

    public function testAppendingStringiUsingPrimitivesTypeShouldSuccess()
    {
        $s = new S('foo');
        $this->assertEquals('foo bar', $s->append(' bar'));
        $this->assertEquals('foo bar', $s->append(' ')->append('bar'));
    }

    public function testAppendingStringiUsingObjectsShouldSuccess()
    {
        $s = new S('foo');
        $this->assertEquals('foo bar', $s->append(new S(' bar')));
        $this->assertEquals('foo bar', $s->append(new S(' '))->append(new S('bar')));
        $this->assertEquals('foo bar', $s->append(new C(' '))->append(new S('bar')));
    }

    public function testPrependingStringShouldReturnSObject()
    {
        $s = new S('foo');
        $this->assertInstanceOf('\Malenki\Bah\S', $s->prepend('bar '));
    }


    public function testPrependingStringUsingPrimitiveTypesShouldSuccess()
    {
        $s = new S('bar');
        $this->assertEquals('foo bar', $s->prepend('foo '));
        $this->assertEquals('foo bar', $s->prepend(' ')->prepend('foo'));
    }

    public function testPrependingStringUsingObjectsShouldSuccess()
    {
        $s = new S('bar');
        $this->assertEquals('foo bar', $s->prepend(new S('foo ')));
        $this->assertEquals('foo bar', $s->prepend(new S(' '))->prepend(new S('foo')));
        $this->assertEquals('foo bar', $s->prepend(new C(' '))->prepend(new S('foo')));
    }

    public function testPutContentBeforeShouldReturnSObject()
    {
        $s = new S('bar');
        $this->assertInstanceOf('\Malenki\Bah\S', $s->before('foo '));
    }
    

    public function testPutContentBeforeUsingStringShouldSuccess()
    {
        $s = new S('bar');
        $this->assertEquals('foo bar', $s->before('foo '));
    }
    

    public function testPutContentBeforeUsingObjectShouldSuccess()
    {
        $s = new S('bar');
        $this->assertEquals('foo bar', $s->before(new S('foo ')));
    }
    
    public function testPutContentBeforeShouldHaveSameResultAsPrependFeadure()
    {
        $s = new S('bar');
        $this->assertEquals($s->prepend('foo '), $s->before('foo '));
    }


    public function testPutContentAfterShouldReturnSObject()
    {
        $s = new S('bar');
        $this->assertInstanceOf('\Malenki\Bah\S', $s->after(' foo'));
    }

    public function testPutContentAfterUsingStringShouldSuccess()
    {
        $s = new S('bar');
        $this->assertEquals('bar foo', $s->after(' foo'));
    }
    

    public function testPutContentAfterUsingObjectShouldSuccess()
    {
        $s = new S('bar');
        $this->assertEquals('bar foo', $s->after(new S(' foo')));
    }
    
    public function testPutContentAfterShouldHaveSameResultAsappendFeadure()
    {
        $s = new S('bar');
        $this->assertEquals($s->append(' foo'), $s->after(' foo'));
    }


    public function testInsertingStringShouldReturnSObject()
    {
        $s = new S('abcghi');
        $this->assertInstanceOf('\Malenki\Bah\S', $s->insert(' def', 3));
    }


    public function testInsertingStringUsingPrimitiveTypesShouldSuccess()
    {
        $s = new S('abcghi');
        $this->assertEquals('abcdefghi', $s->insert('def', 3));
    }

    public function testInsertingStringUsingObjectsShouldSuccess()
    {
        $s = new S('abcghi');
        $this->assertEquals('abcdefghi', $s->insert(new S('def'), new N(3)));
    }





    public function testConvertStringToUnderscoreNotationShouldReturnSObject()
    {
        $s = new S('I will be translated to UnderScore notation!');
        $this->assertInstanceOf('\Malenki\Bah\S', $s->underscore);
    }

    public function testConvertStringToUnderscoreNotationiUsingAliasShouldReturnSObject()
    {
        $s = new S('I will be translated to UnderScore notation!');
        $this->assertInstanceOf('\Malenki\Bah\S', $s->_);
    }

    public function testConvertStringToUnderscoreNotationShouldSuccess()
    {
        $s = new S('I will be translated to UnderScore notation!');
        $this->assertEquals('i_will_be_translated_to_underscore_notation', $s->underscore);
        
        $s = new S('cos(1/exp(pi^2)) result is: 0.99999999866236');
        $this->assertEquals('cos_1_exp_pi_2_result_is_0_99999999866236', $s->underscore);
    }

    public function testConvertStringToUnderscoreNotationUsingAliasShouldSuccess()
    {
        $s = new S('I will be translated to UnderScore notation!');
        $this->assertEquals('i_will_be_translated_to_underscore_notation', $s->_);
    }


    public function testIfConvertingStringToUnderscoreNotationUsingAliasOrNotShouldHaveSameResult()
    {
        $s = new S('I will be translated to UnderScore notation!');
        $this->assertEquals($s->underscore, $s->_);
    }




    public function testConvertStringToDashNotationShouldReturnSObject()
    {
        $s = new S('I will be translated to dash notation!');
        $this->assertInstanceOf('\Malenki\Bah\S', $s->dash);
    }

    public function testConvertStringToDashNotationShouldSuccess()
    {
        $s = new S('I will be translated to dash notation!');
        $this->assertEquals('i-will-be-translated-to-dash-notation', $s->dash);
        
        $s = new S('cos(1/exp(pi^2)) result is: 0.99999999866236');
        $this->assertEquals('cos-1-exp-pi-2-result-is-0-99999999866236', $s->dash);
    }



    public function testConvertintStringToLowerCamelCaseShouldReturnSObject()
    {
        $s = new S('Je vais être en « lowerCamelCase »');
        $this->assertInstanceOf('\Malenki\Bah\S', $s->camelCase());
    }

    public function testConvertingStringToLowerCamelCaseUsingAliasShouldReturnSObject()
    {
        $s = new S('Je vais être en « lowerCamelCase »');
        $this->assertInstanceOf('\Malenki\Bah\S', $s->lowerCamelCase());
    }

    public function testConvertStringToLowerCamelCaseiUsingAliasOrNotShouldReturnSameResult()
    {
        $s = new S('Je vais être en « lowerCamelCase »');
        $this->assertEquals($s->lowerCamelCase(), $s->camelCase());
    }
    
    public function testConvertStringToLowerCamelCaseiUsingMagicGettersShouldHaveSameResultAsMethodWay()
    {
        $s = new S('Je vais être en « lowerCamelCase »');
        $this->assertEquals($s->lowerCamelCase(), $s->lower_camel_case);
        $this->assertEquals($s->lowerCamelCase(), $s->lcc);
    }

    public function testConvertStringTolowerCamelCaseShouldSuccess()
    {
        $s = new S('Je vais être en « lowerCamelCase »');
        $this->assertEquals('jeVaisÊtreEnLowerCamelCase', $s->lcc);
        
        $s = new S('cos(1/exp(pi^2)) result is: 0.99999999866236');
        $this->assertEquals('cos1ExpPi2ResultIs099999999866236', $s->lcc);
    }




    public function testConvertintStringToUpperCamelCaseShouldReturnSObject()
    {
        $s = new S('Je vais être en « UpperCamelCase »');
        $this->assertInstanceOf('\Malenki\Bah\S', $s->camelCase(true));
    }

    public function testConvertingStringToUpperCamelCaseUsingAliasShouldReturnSObject()
    {
        $s = new S('Je vais être en « UpperCamelCase »');
        $this->assertInstanceOf('\Malenki\Bah\S', $s->upperCamelCase());
    }

    public function testConvertStringToUpperCamelCaseiUsingAliasOrNotShouldReturnSameResult()
    {
        $s = new S('Je vais être en « UpperCamelCase »');
        $this->assertEquals($s->upperCamelCase(), $s->camelCase(true));
    }
    
    public function testConvertStringToUpperCamelCaseiUsingMagicGettersShouldHaveSameResultAsMethodWay()
    {
        $s = new S('Je vais être en « UpperCamelCase »');
        $this->assertEquals($s->upperCamelCase(), $s->upper_camel_case);
        $this->assertEquals($s->upperCamelCase(), $s->ucc);
    }

    public function testConvertStringToUpperCamelCaseShouldSuccess()
    {
        $s = new S('Je vais être en « UpperCamelCase »');
        $this->assertEquals('JeVaisÊtreEnUpperCamelCase', $s->ucc);
        
        $s = new S('cos(1/exp(pi^2)) result is: 0.99999999866236');
        $this->assertEquals('Cos1ExpPi2ResultIs099999999866236', $s->ucc);
    }





    public function testSwapingCaseShouldReturnSObject()
    {
        $s = new S('Je SuiS aVec dEs maJuScUleS eT Des MinUScUles !');

        $this->assertInstanceOf('\Malenki\Bah\S', $s->swap_case);
    }

    public function testSwapingCaseShouldSuccess()
    {
        $s = new S('Je SuiS aVec dEs maJuScUleS eT Des MinUScUles !');
        $should = new S('jE sUIs AvEC DeS MAjUsCuLEs Et dES mINusCuLES !');

        $this->assertEquals($should, $s->swap_case);
    }

    public function testWhetherSwapAliasesReturnSObject()
    {
        $s = new S('Je SuiS aVec dEs maJuScUleS eT Des MinUScUles !');

        $this->assertInstanceOf('\Malenki\Bah\S', $s->swapcase);
        $this->assertInstanceOf('\Malenki\Bah\S', $s->swap);
    }

    public function testSwappingCasesUsingAliasShouldHaveSameResultAsOriginal()
    {
        $s = new S('Je SuiS aVec dEs maJuScUleS eT Des MinUScUles !');

        $this->assertEquals($s->swap_case, $s->swapcase);
        $this->assertEquals($s->swap_case, $s->swap);
    }


    
    public function testSqueezingCharactersShouldReturnSObject()
    {
        $s = new S('I havve some doubllle characterss!');
        $this->assertInstanceOf('\Malenki\Bah\S', $s->squeeze);
    }


    public function testSqueezingCharactersShouldSuccess()
    {
        $s = new S('I havve some doubllle characterss!');
        $this->assertEquals('I have some double characters!', $s->squeeze);
    }


    public function testSqueezingCharactersUsingPrimitiveStringSequenceShouldSuccess()
    {
        $s = new S('I havve some doubllle characterss!');
        $this->assertEquals('I have some doubllle characters!', $s->squeeze('vs'));
    }


    public function testSqueezingCharactersUsingSObjectOrObjectHavingToStringMethodSequenceShouldSuccess()
    {
        $s = new S('I havve some doubllle characterss!');
        $this->assertEquals('I have some doubllle characters!', $s->squeeze(new S('vs')));
        $this->assertEquals('I havve some doubllle characters!', $s->squeeze(new C('s')));
    }


    public function testSqueezingCharactersUsingArrayOfStringSequenceShouldSuccess()
    {
        $s = new S('I havve some doubllle characterss!');
        $this->assertEquals('I have some doubllle characters!', $s->squeeze(array('v','s')));
    }


    public function testSqueezingCharactersUsingArrayOfObjectsHavingToStringMethodSequenceShouldSuccess()
    {
        $s = new S('I havve some doubllle characterss!');
        $this->assertEquals('I have some doubllle characters!', $s->squeeze(array(new S('v'), new C('s'))));
    }


    public function testSqueezingCharactersUsingAObjectHavingStringSequenceShouldSuccess()
    {
        $s = new S('I havve some doubllle characterss!');
        $this->assertEquals('I have some doubllle characters!', $s->squeeze(new A(array('v','s'))));
    }


    public function testSqueezingCharactersUsingAObjectHavingObjectWithToStringMethodSequenceShouldSuccess()
    {
        $s = new S('I havve some doubllle characterss!');
        $this->assertEquals('I have some doubllle characters!', $s->squeeze(new A(array(new S('v'), new C('s')))));
        
        $s = new S('aazzerr//tyyy');
        $this->assertEquals('azzerr/ty', $s->squeeze(new A(array(new S('a'), new C('/'), 'y'))));
    }



    public function testSqueezingCharactersUsingHObjectHavingStringSequenceShouldSuccess()
    {
        $s = new S('I havve some doubllle characterss!');
        $this->assertEquals('I have some doubllle characters!', $s->squeeze(new H(array('foo' => 'v', 'bar' => 's'))));
    }


    public function testSqueezingCharactersUsingHObjectHavingObjectWithToStringMethodSequenceShouldSuccess()
    {
        $s = new S('I havve some doubllle characterss!');
        $this->assertEquals('I have some doubllle characters!', $s->squeeze(new H(array('foo' => new S('v'), 'bar' => new C('s')))));
        
        $s = new S('aazzerr//tyyy');
        $this->assertEquals('azzer/ty', $s->squeeze(new H(array('foo' => new S('ar'), 'bar' => new C('/'), 'thing' => 'y'))));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSqueezingUsingNotValidArgumentShouldFail()
    {
        $s = new S('aazzerr//tyyy');
        $o = new \stdClass();
        $o->foo = 'a';
        $o->bar = 'z';

        $s->squeeze($o);
    }





    public function testCenteringStringShouldReturnSObject()
    {
        $s = new S('foo');
        $this->assertInstanceOf('\Malenki\Bah\S', $s->center(20));
    }

    public function testCenteringStringUsingPrimitiveTypeShouldSuccess()
    {
        $s = new S('foo');
        $should = new S('  foo   ');
        $this->assertEquals($should, $s->center(8));
        $sp = new S('             foo        ');
        $this->assertEquals($should, $sp->center(8));

        $s = new S("foo\nbar\nthing");
        $should = new S('  foo   '."\n".'   bar  '. "\n". ' thing  ');
        $this->assertEquals($should, $s->center(8));
        
    }


    public function testCenteringWithoutArgShouldReturnsStringHavingLengthOf79Chars()
    {
        $s = new S('I will be centered!');
        $should = new S('                              I will be centered!                              ');
        $this->assertEquals($should, $s->center());
    }

    public function testIfCenteringWorksUsingMagicGetterLikeMethodCallWithoutArg()
    {
        $s = new S('I will be centered!');
        $should = new S('                              I will be centered!                              ');
        $this->assertEquals($should, $s->center);
    }

    public function testCenteringStringUsingNObjectShouldSuccess()
    {
        $s = new S('foo');
        $should = new S('  foo   ');
        $this->assertEquals($should, $s->center(new N(8)));
        $sp = new S('             foo        ');
        $this->assertEquals($should, $sp->center(new N(8)));

        $s = new S("foo\nbar\nthing");
        $should = new S('  foo   '."\n".'   bar  '. "\n". ' thing  ');
        $this->assertEquals($should, $s->center(new N(8)));
    }

    public function testLeftJustifyingStringShouldSuccess()
    {
        $s = new S('Je vais être alignée sur la gauche !');
        $sp = new S('        Je vais être alignée sur la gauche !         ');
        $should = new S('Je vais être alignée sur la gauche !                                           ');
        $shouldPad = new S('Je vais être alignée sur la gauche !    ');
        
        $this->assertEquals($should, $s->left);
        $this->assertEquals($should, $s->left_justify);
        $this->assertEquals($should, $s->left_align);
        $this->assertEquals($should, $s->ljust);
        $this->assertEquals($should, $s->leftJustify());
        $this->assertEquals($should, $s->leftAlign());
        $this->assertEquals($should, $s->ljust());
        $this->assertEquals($should, $s->left());
        
        $this->assertEquals($shouldPad, $s->leftJustify(40));
        $this->assertEquals($shouldPad, $s->leftAlign(new N(40)));
        $this->assertEquals($shouldPad, $s->ljust(40));
        $this->assertEquals($shouldPad, $s->left(new N(40)));
        
        $this->assertEquals($should, $sp->left);
        $this->assertEquals($should, $sp->left_justify);
        $this->assertEquals($should, $sp->left_align);
        $this->assertEquals($should, $sp->ljust);
        $this->assertEquals($should, $sp->leftJustify());
        $this->assertEquals($should, $sp->leftAlign());
        $this->assertEquals($should, $sp->ljust());
        $this->assertEquals($should, $sp->left());
        
        $this->assertEquals($shouldPad, $sp->leftJustify(40));
        $this->assertEquals($shouldPad, $sp->leftAlign(new N(40)));
        $this->assertEquals($shouldPad, $sp->ljust(40));
        $this->assertEquals($shouldPad, $sp->left(new N(40)));
    }


    /**
     * @expectedException \InvalidArgumentException
     */
    public function testLeftJustifyingUsingBadWidthTypeShouldFail()
    {
        $s = new S('Je ne vais pas être alignée sur la gauche !');
        $s->left(null);
    }


    /**
     * @expectedException \InvalidArgumentException
     */
    public function testLeftJustifyingUsingNegativeWidthShouldFail()
    {
        $s = new S('Je ne vais pas être alignée sur la gauche !');
        $s->left(-10);
    }


    /**
     * @expectedException \InvalidArgumentException
     */
    public function testLeftJustifyingUsingZeroWidthShouldFail()
    {
        $s = new S('Je ne vais pas être alignée sur la gauche !');
        $s->left(0);
    }


    public function testRightJustifyingStringShouldSuccess()
    {
        $s = new S('Je vais être alignée sur la droite !');
        $sp = new S('        Je vais être alignée sur la droite !         ');
        $should = new S('                                           Je vais être alignée sur la droite !');
        $shouldPad = new S('    Je vais être alignée sur la droite !');
        
        $this->assertEquals($should, $s->right);
        $this->assertEquals($should, $s->right_justify);
        $this->assertEquals($should, $s->right_align);
        $this->assertEquals($should, $s->rjust);
        $this->assertEquals($should, $s->rightJustify());
        $this->assertEquals($should, $s->rightAlign());
        $this->assertEquals($should, $s->rjust());
        $this->assertEquals($should, $s->right());
        
        $this->assertEquals($shouldPad, $s->rightJustify(40));
        $this->assertEquals($shouldPad, $s->rightAlign(new N(40)));
        $this->assertEquals($shouldPad, $s->rjust(40));
        $this->assertEquals($shouldPad, $s->right(new N(40)));
        
        $this->assertEquals($should, $sp->right);
        $this->assertEquals($should, $sp->right_justify);
        $this->assertEquals($should, $sp->right_align);
        $this->assertEquals($should, $sp->rjust);
        $this->assertEquals($should, $sp->rightJustify());
        $this->assertEquals($should, $sp->rightAlign());
        $this->assertEquals($should, $sp->rjust());
        $this->assertEquals($should, $sp->right());
        
        $this->assertEquals($shouldPad, $sp->rightJustify(40));
        $this->assertEquals($shouldPad, $sp->rightAlign(new N(40)));
        $this->assertEquals($shouldPad, $sp->rjust(40));
        $this->assertEquals($shouldPad, $sp->right(new N(40)));
    }


    /**
     * @expectedException \InvalidArgumentException
     */
    public function testRightJustifyingUsingBadWidthTypeShouldFail()
    {
        $s = new S('Je ne vais pas être alignée sur la gauche !');
        $s->right(null);
    }


    /**
     * @expectedException \InvalidArgumentException
     */
    public function testRightJustifyingUsingNegativeWidthShouldFail()
    {
        $s = new S('Je ne vais pas être alignée sur la gauche !');
        $s->right(-10);
    }


    /**
     * @expectedException \InvalidArgumentException
     */
    public function testRightJustifyingUsingZeroWidthShouldFail()
    {
        $s = new S('Je ne vais pas être alignée sur la gauche !');
        $s->right(0);
    }

    public function testJustifyingStringShouldSuccess()
    {
        $s = new S('Cogito ergo sum, alea jacta est !?');

        $should = new S('Cogito ergo sum, alea jacta est !?                                             ');
        $this->assertEquals($should, $s->justify());
        $this->assertEquals($should, $s->justify);
        $should = new S('Cogito     ergo' . PHP_EOL .
            'sum, alea jacta' . PHP_EOL .
            'est !?         ');

        $this->assertEquals($should, $s->justify(15));
        $this->assertEquals($should, $s->justify(15, 'left'));

        $should = new S('Cogito     ergo' . PHP_EOL .
            'sum, alea jacta' . PHP_EOL .
            '         est !?');

        $this->assertEquals($should, $s->justify(15, 'right'));
    }



    /**
     * @expectedException \InvalidArgumentException
     */
    public function testJustifyingUsingBadWidthTypeShouldFail()
    {
        $s = new S('Je ne vais pas être alignée sur la gauche !');
        $s->justify(null);
    }


    /**
     * @expectedException \InvalidArgumentException
     */
    public function testJustifyingUsingNegativeWidthShouldFail()
    {
        $s = new S('Je ne vais pas être alignée sur la gauche !');
        $s->justify(-10);
    }


    /**
     * @expectedException \InvalidArgumentException
     */
    public function testJustifyingUsingZeroWidthShouldFail()
    {
        $s = new S('Je ne vais pas être alignée sur la gauche !');
        $s->justify(0);
    }


    /**
     * @expectedException \InvalidArgumentException
     */
    public function testJustifyingUsingBadLastLineAlignTypeShouldFail()
    {
        $s = new S('Je ne vais pas être alignée sur la gauche !');
        $s->justify(50, 'foo');
    }





    public function testGettingMd5SumShouldReturnSObject()
    {
        $s = new S('I am not a number! I am free man!');
        $this->assertInstanceOf('\Malenki\Bah\S', $s->md5);
    }

    public function testGettingMd5SumShouldReturnSObjectHavingSizeOf32Characters()
    {
        $s = new S('I am not a number! I am free man!');
        $this->assertCount(32, $s->md5);
    }

    public function testGettingMd5SumShouldHaveOnlyHexadecimalCharacters()
    {
        $s = new S('I am not a number! I am free man!');
        $this->assertRegExp('/^[a-f0-9]{32}$/', $s->md5->string);
    }

    public function testGettingMd5SumShouldHaveSameResultAsNativePHPFunction()
    {
        $s = new S('I am not a number! I am free man!');
        $this->assertEquals(md5('I am not a number! I am free man!'), $s->md5->string);
    }

    public function testGettingSha1SumShouldReturnSObject()
    {
        $s = new S('I am not a number! I am free man!');
        $this->assertInstanceOf('\Malenki\Bah\S', $s->sha1);
    }

    public function testGettingSha1SumShouldReturnSObjectHaving40Characters()
    {
        $s = new S('I am not a number! I am free man!');
        $this->assertCount(40, $s->sha1);
    }

    public function testGettingSha1SumShouldHaveOnlyHexadecimalCharacters()
    {
        $s = new S('I am not a number! I am free man!');
        $this->assertRegExp('/^[a-f0-9]{40}$/', $s->sha1->string);
    }

    public function testGettingSha1SumShouldHaveSameResultAsNativePHPFunction()
    {
        $s = new S('I am not a number! I am free man!');
        $this->assertEquals(sha1('I am not a number! I am free man!'), $s->sha1->string);
    }






    public function testSettingCharacterUsingPrimitiveTypesShouldSuccess()
    {
        $s = new S('abcdef');
        $this->assertEquals('abCdef', $s->set(2, 'C'));
    }
    
    public function testSettingCharacterShouldReturnSObject()
    {
        $s = new S('abcdef');
        $this->assertInstanceOf('\Malenki\Bah\S', $s->set(2, 'C'));
    }
    
    public function testSettingCharacterUsingIndexAsNObjectShouldSuccess()
    {
        $s = new S('abcdef');
        $this->assertEquals('abCdef', $s->set(new N(2), 'C'));
    }

    public function testSettingCharacterUsingIndexAsNObjectAndCharacterAsSObjectShouldSuccess()
    {
        $s = new S('abcdef');
        $this->assertEquals('abCdef', $s->set(new N(2), new S('C')));
    }


    public function testSettingCharacterUsingIndexAsNObjectAndCharacterAsObjectHavingToStringShouldSuccess()
    {
        $s = new S('abcdef');
        $this->assertEquals('ab9def', $s->set(new N(2), new N(9)));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSettingCharacterUsingVoidCahracterShouldFail()
    {
        $s = new S('abcdef');
        $s->set(array(2), '');
    }
    

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSettingCharacterUsingBadIndexTypeShouldFail()
    {
        $s = new S('abcdef');
        $s->set(array(2), 'C');
    }
    

    /**
     * @expectedException \RuntimeException
     */
    public function testSettingCharacterUsingNegativeIndexShouldFail()
    {
        $s = new S('abcdef');
        $s->set(-2, 'C');
    }
    


    /**
     * @expectedException \RuntimeException
     */
    public function testSettingCharacterUsingOutOfBoundIndexShouldFail()
    {
        $s = new S('abcdef');
        $s->set(8, 'C');
    }
    
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSettingCharacterUsingBadCharacterTypeShouldFail()
    {
        $s = new S('abcdef');
        $s->set(2, array('C'));
    }

    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSettingCharacterUsingMoreThanOneCharacterShouldFail()
    {
        $s = new S('abcdef');
        $s->set(2, 'CC');
    }


    public function testGettingFormatedStringShouldSuccess()
    {
        $s = new S('This will have %s value');

        $this->assertEquals('This will have formated value', $s->format('formated')->string);
        
        $fmt = 'This will have %d formated %s';
        $s = new S($fmt);

        $this->assertEquals(sprintf($fmt, 2, 'values'), $s->format(2, 'values')->string);
        $this->assertEquals(sprintf($fmt, 2, 'values'), $s->format(new N(2), new S('values'))->string);

        $fmt = 'Pi is %.2f';
        $s = new S($fmt);
        $this->assertEquals(sprintf($fmt, M_PI), $s->format(M_PI)->string);
        $this->assertEquals(sprintf($fmt, M_PI), $s->format(new N(M_PI))->string);
    }




    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGettingFormatedStringUsingNonScalarORAllowedObjectShouldFail()
    {
        $s = new S('This will have %s value');

        $this->assertEquals('This will have formated value', $s->format(array('formated'))->string);
    }
        


    public function testGettingExcerptShouldSuccess()
    {
        $s = new S('Ceci est une phrase assez longue à partir de laquelle un extrait va être pris avec un radius de 10.');
        $this->assertEquals(' longue à partir de laquel', $s->excerpt('partir', 10));
        $this->assertEquals('Ceci est une p', $s->excerpt('Ceci', 10));
        $this->assertEquals('radius de 10.', $s->excerpt('10.', 10));
        $this->assertEquals('Ceci est une phrase as', $s->excerpt('est une', 10));
        $this->assertEquals('s avec un radius de 10.', $s->excerpt('radius', 10));
    }
    


    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGettingExcerptUsingBadPhraseArgumentTypeShouldFail()
    {
        $s = new S('Ceci est une phrase assez longue à partir de laquelle un extrait va être pris avec un radius de 10.');
        $s->excerpt(array('est'), 10);
    }


    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGettingExcerptUsingBadRadiusArgumentTypeShouldFail()
    {
        $s = new S('Ceci est une phrase assez longue à partir de laquelle un extrait va être pris avec un radius de 10.');
        $s->excerpt('est', 10.5);
    }




    public function testDeletingPartsFromTheStringShouldSuccess()
    {
        $s = new S('This string will loose some parts…');
        $this->assertEquals('This will loose some parts…', $s->delete(4, 7));
    }
    
    public function testDeletingPartsFromTheStringUsingNoArgsShouldRemoveFirstCharWithSuccess()
    {
        $s = new S('This string will loose some parts…');
        $this->assertEquals('his string will loose some parts…', $s->delete());
    }
    
    public function testDeletingPartsFromTheStringUsingMagicGetterShouldRemoveFirstCharWithSuccess()
    {
        $s = new S('This string will loose some parts…');
        $this->assertEquals('his string will loose some parts…', $s->delete);
    }
    
    public function testDeletingPartsFromTheStringUsingTooBigLengthShouldSuccess()
    {
        $s = new S('This string will loose some parts…');
        $this->assertEquals('This string will loose some', $s->delete(27, 10));
    }


    public function testDeletingPartsFromTheStringUsingAliasDelShouldSuccess()
    {
        $s = new S('This string will loose some parts…');
        $this->assertEquals('This will loose some parts…', $s->del(4, 7));
    }


    public function testDeletingPartsFromTheStringUsingAliasRemoveShouldSuccess()
    {
        $s = new S('This string will loose some parts…');
        $this->assertEquals('This will loose some parts…', $s->remove(4, 7));
    }
    
    
    public function testDeletingPartsFromTheStringUsingAliasRmShouldSuccess()
    {
        $s = new S('This string will loose some parts…');
        $this->assertEquals('This will loose some parts…', $s->rm(4, 7));
    }

    public function testDeletingPartsUsingAliasShouldHaveSameBehaviourAsOriginal()
    {
        $s = new S('This string will loose some parts…');
        $this->assertEquals($s->delete(4, 7), $s->del(4, 7));
        $this->assertEquals($s->delete(), $s->del());
        $this->assertEquals($s->delete(27, 10), $s->del(27, 10));
        $this->assertEquals($s->delete(4, 7), $s->remove(4, 7));
        $this->assertEquals($s->delete(), $s->remove());
        $this->assertEquals($s->delete(27, 10), $s->remove(27, 10));
        $this->assertEquals($s->delete(4, 7), $s->rm(4, 7));
        $this->assertEquals($s->delete(), $s->rm());
        $this->assertEquals($s->delete(27, 10), $s->rm(27, 10));
    }

    public function testDeletingPartsUsingMagicGetterShouldHaveSameBehaviourAsOriginal()
    {
        $s = new S('This string will loose some parts…');
        $this->assertEquals($s->delete(), $s->delete);
        $this->assertEquals($s->del(), $s->del);
        $this->assertEquals($s->remove(), $s->remove);
        $this->assertEquals($s->rm(), $s->rm);
    }


    /**
     * @expectedException \InvalidArgumentException
     */
    public function testDeletingSubStringUsingNonIntegerAsOffsetShouldFail()
    {
        $s = new S('This string will loose some parts…');
        $s->delete(1.2, 4);
    }


    /**
     * @expectedException \InvalidArgumentException
     */
    public function testDeletingSubStringUsingNonIntegerAsLengthShouldFail()
    {
        $s = new S('This string will loose some parts…');
        $s->delete(1, 4.3);
    }
    
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testDeletingSubStringUsingNegativeOffsetShouldFail()
    {
        $s = new S('This string will loose some parts…');
        $s->delete(-3, 4);
    }

    
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testDeletingSubStringUsingLessThanOneLengthShouldFail()
    {
        $s = new S('This string will loose some parts…');
        $s->delete(3, 0);
    }


    public function testGettingPositionFromVoidStringShouldReturnVoidCollection()
    {
        $s = new S('');
        $this->assertCount(0, $s->position('me'));
    }



    public function testGettingPositionsOfOneOccurenceShouldSuccess()
    {
        $s = new S('Catch me if you can!');
        $this->assertInstanceOf('\Malenki\Bah\A', $s->position('me'));
        $this->assertCount(1, $s->position('me'));
        $this->assertEquals(6, $s->position('me')->first->int);
    }
    
    public function testGettingPositionsOfSeveralOccurencesShouldSuccess()
    {
        $s = new S('Catch me if you can!');
        $this->assertInstanceOf('\Malenki\Bah\A', $s->position('a'));
        $this->assertCount(2, $s->position('a'));
        $this->assertEquals(1, $s->position('a')->first->int);
        $this->assertEquals(17, $s->position('a')->last->int);
    }


    public function testGettingPositionUsingItsAliasShouldSuccess()
    {
        $s = new S('Catch me if you can!');
        $this->assertInstanceOf('\Malenki\Bah\A', $s->pos('me'));
    }

    public function testGettingpositionUsingItsAliasShouldHaveSameResult()
    {
        $s = new S('Catch me if you can!');
        $this->assertEquals(count($s->position('me')), count($s->pos('me')));
        $this->assertEquals($s->position('me')->first, $s->pos('me')->first);
        $this->assertEquals(count($s->position('a')), count($s->pos('a')));
        $this->assertEquals($s->position('a')->first, $s->pos('a')->first);
        $this->assertEquals($s->position('a')->last, $s->pos('a')->last);
    }
    
    
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGettingPositionsUsingBadArgumentTypeShouldFail()
    {
        $s = new S('Catch me if you can!');
        $s->position(null);
    }
    
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGettingPositionsUsingVoidNeedleShouldFail()
    {
        $s = new S('Catch me if you can!');
        $s->position('');
    }

    public function testLoopingUsingIteratorAggregateShouldSuccess()
    {
        $s = new S('abc');

        foreach($s as $k => $v){
            $this->assertEquals($s->charAt($k), $v);
        }
    }


    public function testLoopingUsingIteratorMethodsShouldSuccess()
    {
        $s = new S('abc');

        while($s->valid()){
            $this->assertEquals($s->charAt($s->key()), $s->current());
            $s->next();
        }
    }


    public function testLoopingUsingIteratorMagicGettersShouldSuccess()
    {
        $s = new S('abc');

        while($s->valid){
            $this->assertEquals($s->charAt($s->key), $s->current);
            $s->next;
        }
    }
}

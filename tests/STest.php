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

class STest extends PHPUnit_Framework_TestCase
{
    public function testBasis()
    {
        $s = new S('Je suis une chaîne !');
        $this->assertEquals((string) $s, 'Je suis une chaîne !');
        $this->assertEquals((string) $s->title, 'Je Suis Une Chaîne !');

        $s = new S('!');
        $this->assertEquals((string) $s->times(3), '!!!');

        $s = new S('I am a string!');
        $this->assertEquals('I am a string!', $s->string);
    }

    public function testSCountShouldBeRight()
    {
        $s = new S('J’écris en français !');
        $this->assertEquals(21, count($s));
        $this->assertEquals(21, $s->length->int);
        $s = new S('J\'ecris en francais !');
        $this->assertEquals(21, count($s));
        $this->assertEquals(21, $s->length->int);
    }

    public function testUppercaseMustBeOk()
    {
        $s = new S('Je suis une chaîne !');
        $this->assertEquals('JE SUIS UNE CHAÎNE !', (string) $s->upper);
        $s = new S('JE SUIS UNE CHAÎNE !');
        $this->assertEquals('JE SUIS UNE CHAÎNE !', (string) $s->upper);
    }

    public function testLowercaseMustBeOk()
    {
        $s = new S('Je suis une chaîne !');
        $this->assertEquals('je suis une chaîne !', (string) $s->lower);
        $s = new S('JE SUIS UNE CHAÎNE !');
        $this->assertEquals('je suis une chaîne !', (string) $s->lower);
        $s = new S('je suis une chaîne !');
        $this->assertEquals('je suis une chaîne !', (string) $s->lower);
    }

    public function testCheckingStringShouldBeVoidOrNot()
    {
        $s = new S('');
        $this->assertTrue($s->isVoid());
        $this->assertTrue($s->void);
        $this->assertTrue($s->empty);

        $s = new S('something');
        $this->assertFalse($s->isVoid());
        $this->assertFalse($s->void);
        $this->assertFalse($s->empty);
    }

    public function testStringMatchingShouldBeTrue()
    {
        $s = new S('az/erty');
        $this->assertTrue($s->startsWith('az/'));
        $this->assertTrue($s->endsWith('ty'));
        $this->assertTrue($s->match('/ert/'));
        $this->assertTrue($s->regexp('/ert/'));
        $this->assertTrue($s->re('/ert/'));
        $this->assertTrue($s->startsWith(new S('az/')));
        $this->assertTrue($s->endsWith(new S('ty')));
        $this->assertTrue($s->match(new S('/ert/')));
        $this->assertTrue($s->regexp(new S('/ert/')));
        $this->assertTrue($s->re(new S('/ert/')));
    }

    public function testStringMatchingShouldBeFalse()
    {
        $s = new S('az/erty');
        $this->assertFalse($s->startsWith('z/'));
        $this->assertFalse($s->endsWith('t'));
        $this->assertFalse($s->match('/ern/'));
        $this->assertFalse($s->regexp('/ern/'));
        $this->assertFalse($s->re('/ern/'));
        $this->assertFalse($s->startsWith(new S('z/')));
        $this->assertFalse($s->endsWith(new S('t')));
        $this->assertFalse($s->match(new S('/ern/')));
        $this->assertFalse($s->regexp(new S('/ern/')));
        $this->assertFalse($s->re(new S('/ern/')));
    }

    public function testChars()
    {
        $s = new S('Je suis une chaîne !');
        $this->assertEquals(new N(20), $s->chars->length);
        $this->assertEquals($s->length, $s->chars->length);
        $this->assertEquals("20", $s->chars->length->s);
        $this->assertEquals(20, $s->chars->length->int);
        $this->assertEquals(new C('J'), $s->chars->first);
        $this->assertEquals(new C('!'), $s->chars->last);
        $this->assertEquals(new C(' '), $s->chars->lastButOne);
        $this->assertEquals(new C('s'), $s->charAt(3));
        $this->assertEquals(new C('s'), $s->charAt(new N(3)));
    }

    public function testSubstringShouldSuccess()
    {
        $s = new S('Je suis une chaîne !');
        $this->assertEquals('Je suis', $s->sub(0, 7));
        $this->assertEquals('suis', $s->sub(3, 4));
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

    public function testLeftMarginShouldBeOk()
    {
        //TODO: test multiline and alinea
        $s = new S('something');
        $this->assertEquals('     something', $s->margin(5));
        $this->assertEquals('     something', $s->margin(new N(5)));
        $this->assertEquals('something     ', $s->margin(0, 5));
        $this->assertEquals('something     ', $s->margin(new N(0), new N(5)));
        $this->assertEquals('     something     ', $s->margin(5, 5));
        $this->assertEquals('     something     ', $s->margin(new N(5), new N(5)));
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

    public function testGettingChunksShouldSuccess()
    {
        $s = new S('abcde');
        $must = new A();
        $must->add(new S('a'));
        $must->add(new S('b'));
        $must->add(new S('c'));
        $must->add(new S('d'));
        $must->add(new S('e'));
        $this->assertEquals($must, $s->chunk());
        $this->assertEquals($must, $s->chunk);

        $s = new S('C’est une chaîne qu’on va découper !');
        $must = new A();
        $must->add(new S('C’est u'));
        $must->add(new S('ne chaî'));
        $must->add(new S('ne qu’o'));
        $must->add(new S('n va dé'));
        $must->add(new S('couper '));
        $must->add(new S('!'));
        $this->assertEquals($must, $s->chunk(7));
        $this->assertEquals($must, $s->chunk(new N(7)));
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGettingChunksiHavingBadSizeShouldFail()
    {
        $s = new S('abcde');
        $s->chunk(0);
    }

    public function testGettingReplacemendStringUsingStringShouldSuccess()
    {
        $s = new S('This string must change a little');
        $this->assertEquals('This string must change!', $s->change('/ a little$/', '!'));
    }
    
    public function testGettingReplacemendStringShouldSuccess()
    {
        $s = new S('This string must change a little');
        $this->assertInstanceOf('\Malenki\Bah\S', $s->change('/ a little$/', '!'));
    }
    
    public function testGettingReplacemendStringUsingSObjectShouldSuccess()
    {
        $s = new S('This string must change a little');
        $this->assertEquals('This string must change!', $s->change(new S('/ a little$/'), new S('!')));
    }
    
    public function testGettingReplacemendStringUsingObjectHavingToStringShouldSuccess()
    {
        $s = new S('This string must change a little');
        $this->assertEquals('This string must change!', $s->change(new S('/ a little$/'), new C('!')));
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

    public function testAppendingStringShouldSuccess()
    {
        $s = new S('foo');
        $this->assertEquals('foo bar', $s->append(' bar'));
        $this->assertEquals('foo bar', $s->append(' ')->append('bar'));
        $this->assertEquals('foo bar', $s->append(new S(' bar')));
        $this->assertEquals('foo bar', $s->append(new S(' '))->append(new S('bar')));
        $this->assertEquals('foo bar', $s->append(new C(' '))->append(new S('bar')));
    }

    public function testPrependingStringShouldSuccess()
    {
        $s = new S('bar');
        $this->assertEquals('foo bar', $s->prepend('foo '));
        $this->assertEquals('foo bar', $s->prepend(' ')->prepend('foo'));
        $this->assertEquals('foo bar', $s->prepend(new S('foo ')));
        $this->assertEquals('foo bar', $s->prepend(new S(' '))->prepend(new S('foo')));
        $this->assertEquals('foo bar', $s->prepend(new C(' '))->prepend(new S('foo')));
    }

    public function testConvertStringTolowerCamelCaseShouldSuccess()
    {
        $s = new S('Je vais être en « lowerCamelCase »');
        $this->assertEquals('jeVaisÊtreEnLowerCamelCase', $s->camelCase());
        $this->assertEquals('jeVaisÊtreEnLowerCamelCase', $s->lowerCamelCase());
        $this->assertEquals('jeVaisÊtreEnLowerCamelCase', $s->lower_camel_case);
        $this->assertEquals('jeVaisÊtreEnLowerCamelCase', $s->lcc);
    }

    public function testConvertStringToUpperCamelCaseShouldSuccess()
    {
        $s = new S('Je vais être en « UpperCamelCase »');
        $this->assertEquals('JeVaisÊtreEnUpperCamelCase', $s->camelCase(true));
        $this->assertEquals('JeVaisÊtreEnUpperCamelCase', $s->upperCamelCase());
        $this->assertEquals('JeVaisÊtreEnUpperCamelCase', $s->upper_camel_case);
        $this->assertEquals('JeVaisÊtreEnUpperCamelCase', $s->ucc);
    }

    public function testCenteringStringShouldSuccess()
    {
        $s = new S('foo');
        $should = new S('  foo   ');
        $this->assertEquals($should, $s->center(8));
        $sp = new S('             foo        ');
        $this->assertEquals($should, $sp->center(8));

        $s = new S("foo\nbar\nthing");
        $should = new S('  foo   '."\n".'   bar  '. "\n". ' thing  ');
        $this->assertEquals($should, $s->center(8));
        
        $s = new S('I will be centered!');
        $should = new S('                              I will be centered!                              ');
        $this->assertEquals($should, $s->center);
        
    }

    public function testSwapingCaseShouldSuccess()
    {
        $s = new S('Je SuiS aVec dEs maJuScUleS eT Des MinUScUles !');
        $should = new S('jE sUIs AvEC DeS MAjUsCuLEs Et dES mINusCuLES !');

        $this->assertEquals($should, $s->swap_case);
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

    public function testJustifyingStringShouldSuccess()
    {
        $this->markTestIncomplete();
        $s = new S('Cogito ergo sum, alea jacta est !?');
        //var_dump($s->justify()->string);
        //var_dump($s->justify(15)->string);
    }
}

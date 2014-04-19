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
}



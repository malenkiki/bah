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
use \Malenki\Bah\A;
use \Malenki\Bah\S;
use \Malenki\Bah\C;

class CTest extends PHPUnit_Framework_TestCase
{

    public function testConvertingObjectToPrimitiveString()
    {
        $c = new C('a');
        $this->assertEquals('a', $c->string);
    }

    public function testInstanciateFromCode()
    {
        $n = new N(948);
        $c = new C($n);

        $this->assertEquals('δ', $c->string);
    }

    public function testInstanciateFormHtmlEntityShouldSuccess()
    {
        $c = new C('&eacute;');
        $this->assertEquals('é', $c->string);

        $c = new C('&nbsp;');
        $this->assertEquals(' ', $c->string);

        $c = new C('&quot;');
        $this->assertEquals('"', $c->string);

        $c = new C('&apos;');
        $this->assertEquals("'", $c->string);

        $c = new C('&amp;');
        $this->assertEquals('&', $c->string);

        $c = new C('&lt;');
        $this->assertEquals('<', $c->string);

        $c = new C('&gt;');
        $this->assertEquals('>', $c->string);
    }

    public function testCaseDetection()
    {
        $c = new C('a');
        $this->assertTrue($c->hasCase());
        $this->assertTrue($c->isLowerCase());
        $this->assertFalse($c->isUpperCase());

        $c = new C('A');
        $this->assertTrue($c->hasCase());
        $this->assertFalse($c->isLowerCase());
        $this->assertTrue($c->isUpperCase());

        $c = new C('à');
        $this->assertTrue($c->hasCase());
        $this->assertTrue($c->isLowerCase());
        $this->assertFalse($c->isUpperCase());

        $c = new C('À');
        $this->assertTrue($c->hasCase());
        $this->assertFalse($c->isLowerCase());
        $this->assertTrue($c->isUpperCase());

        $c = new C('=');
        $this->assertFalse($c->hasCase());
        $this->assertTrue($c->isLowerCase());
        $this->assertTrue($c->isUpperCase());

        $c = new C('ب');
        $this->assertFalse($c->hasCase());
        $this->assertTrue($c->isLowerCase());
        $this->assertTrue($c->isUpperCase());

        $c = new C('5');
        $this->assertFalse($c->hasCase());
        $this->assertTrue($c->isLowerCase());
        $this->assertTrue($c->isUpperCase());

        $c = new C('');
        $this->assertFalse($c->hasCase());
        $this->assertTrue($c->isLowerCase());
        $this->assertTrue($c->isUpperCase());
    }

    public function testLetterDetection()
    {
        $c = new C('œ');
        $this->assertTrue($c->isLetter());
        $c = new C('a');
        $this->assertTrue($c->isLetter());
        $c = new C('ç');
        $this->assertTrue($c->isLetter());
        $c = new C('é');
        $this->assertTrue($c->isLetter());
        $c = new C(' ');
        $this->assertFalse($c->isLetter());
        $c = new C('-');
        $this->assertFalse($c->isLetter());
        $c = new C('.');
        $this->assertFalse($c->isLetter());
        $c = new C('/');
        $this->assertFalse($c->isLetter());
    }

    public function testDigitDetection()
    {
        $c = new C('0');
        $this->assertTrue($c->isDigit());

        $c = new C('8');
        $this->assertTrue($c->isDigit());
    }

    public function testPunctuationDetection()
    {
        $c = new C('.');
        $this->assertTrue($c->isPunctuation());

        $c = new C(',');
        $this->assertTrue($c->isPunctuation());

        $c = new C('…');
        $this->assertTrue($c->isPunctuation());

        $c = new C('–');
        $this->assertTrue($c->isPunctuation());

        $c = new C('。');
        $this->assertTrue($c->isPunctuation());

        $c = new C('【');
        $this->assertTrue($c->isPunctuation());
    }

    public function testSeparatorDetection()
    {
        $c = new C(' ');
        $this->assertTrue($c->isSeparator());

        $c = new C(' '); // nbsp
        $this->assertTrue($c->isSeparator());

        $c = new C("　"); // ideographic space
        $this->assertTrue($c->isSeparator());

        $c = new C(" "); // EM space
        $this->assertTrue($c->isSeparator());

    }

    public function testFormatDetection()
    {
        $this->markTestSkipped("Must find right caracters to test with");
        $c = new C(new N(0x9B));
        $this->assertTrue($c->isFormat());
    }

    public function testUnassignedDetection()
    {
        /*FIXME:This fails now on Travis for PHP 5.5, but before has worked fine… WTF???
        $c = new C('⁧');
        $this->assertTrue($c->isUnassigned());
         */
        $c = new C(new N(0x7B9));
        $this->assertTrue($c->isUnassigned());
        $c = new C(new N(0x89A));
        $this->assertTrue($c->isUnassigned());
    }

    public function testPrivateUseDetection()
    {
        $c = new C('󰀴');
        $this->assertTrue($c->isPrivateUse());
        $c = new C('􀁕');
        $this->assertTrue($c->isPrivateUse());
    }

    public function testSurrogateDetection()
    {
        $this->markTestSkipped("Must find right caracters to test with");
        $c = new C();
        $this->assertTrue($c->isSurrogate());
    }

    public function testControlDetection()
    {
        $c = new C("\n");
        $this->assertTrue($c->isControl());

        $c = new C("\t");
        $this->assertTrue($c->isControl());

    }

    public function testSymbolDetection()
    {
        $c = new C('$');
        $this->assertTrue($c->isSymbol());

        $c = new C('£');
        $this->assertTrue($c->isSymbol());

        $c = new C('€');
        $this->assertTrue($c->isSymbol());

        $c = new C('+');
        $this->assertTrue($c->isSymbol());

        $c = new C('×');
        $this->assertTrue($c->isSymbol());

        $c = new C('÷');
        $this->assertTrue($c->isSymbol());

        $c = new C('∀');
        $this->assertTrue($c->isSymbol());

        $c = new C('∁');
        $this->assertTrue($c->isSymbol());

        $c = new C('∃');
        $this->assertTrue($c->isSymbol());

        $c = new C('∈');
        $this->assertTrue($c->isSymbol());
    }

    public function testUnicodeCodePoint()
    {
        $c = new C('é');
        $n = new N(233);
        $this->assertEquals($n, $c->unicode);

        $c = new C('€');
        $n = new N(8364);
        $this->assertEquals($n, $c->unicode);

        $c = new C('æ');
        $n = new N(230);
        $this->assertEquals($n, $c->unicode);
    }

    /**
     * testBlock
     * @access public
     * @return void
     */
    public function testBlock()
    {
        $c = new C('z');
        $this->assertEquals($c->block, new S('Basic Latin'));

        $c = new C('Œ');
        $this->assertEquals($c->block, new S('Latin Extended-A'));
        $c = new C('Ȁ');
        $this->assertEquals($c->block, new S('Latin Extended-B'));
        $c = new C('α');
        $this->assertEquals($c->block, new S('Greek and Coptic'));
        $c = new C('Ю');
        $this->assertEquals($c->block, new S('Cyrillic'));

        $c = new C('Ꙛ');
        $this->assertEquals($c->block, new S('Cyrillic Extended-B'));
        $c = new C('Ֆ');
        $this->assertEquals($c->block, new S('Armenian'));
        $c = new C('ش');
        $this->assertEquals($c->block, new S('Arabic'));
        $c = new C('א');
        $this->assertEquals($c->block, new S('Hebrew'));
        $c = new C('ܐ');
        $this->assertEquals($c->block, new S('Syriac'));

        $c = new C('Ḫ');
        $this->assertEquals($c->block, new S('Latin Extended Additional'));

        $c = new C('Ɐ');
        $this->assertEquals($c->block, new S('Latin Extended-C'));
        $c = new C('Ⲁ');
        $this->assertEquals($c->block, new S('Coptic'));

        $c = new C('Ꜧ');
        $this->assertEquals($c->block, new S('Latin Extended-D'));

        $c = new C('𐅃');
        $this->assertEquals($c->block, new S('Ancient Greek Numbers'));

        $c = new C('𐌍');
        $this->assertEquals($c->block, new S('Old Italic'));
        $c = new C('𐌰');
        $this->assertEquals($c->block, new S('Gothic'));

        $c = new C('𒀧');
        $this->assertEquals($c->block, new S('Cuneiform'));

        $c = new C('𓂈');
        $this->assertEquals($c->block, new S('Egyptian Hieroglyphs'));

    }
}

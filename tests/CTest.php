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


class CTest extends PHPUnit_Framework_TestCase
{



    public function testCaseDetection()
    {
        $c = new Malenki\Bah\C('a');
        $this->assertTrue($c->hasCase());
        $this->assertTrue($c->isLowerCase());
        $this->assertFalse($c->isUpperCase());

        $c = new Malenki\Bah\C('A');
        $this->assertTrue($c->hasCase());
        $this->assertFalse($c->isLowerCase());
        $this->assertTrue($c->isUpperCase());

        $c = new Malenki\Bah\C('à');
        $this->assertTrue($c->hasCase());
        $this->assertTrue($c->isLowerCase());
        $this->assertFalse($c->isUpperCase());

        $c = new Malenki\Bah\C('À');
        $this->assertTrue($c->hasCase());
        $this->assertFalse($c->isLowerCase());
        $this->assertTrue($c->isUpperCase());
        
        $c = new Malenki\Bah\C('=');
        $this->assertFalse($c->hasCase());
        $this->assertTrue($c->isLowerCase());
        $this->assertTrue($c->isUpperCase());
        
        $c = new Malenki\Bah\C('ب');
        $this->assertFalse($c->hasCase());
        $this->assertTrue($c->isLowerCase());
        $this->assertTrue($c->isUpperCase());
        
        $c = new Malenki\Bah\C('5');
        $this->assertFalse($c->hasCase());
        $this->assertTrue($c->isLowerCase());
        $this->assertTrue($c->isUpperCase());
        
        $c = new Malenki\Bah\C('');
        $this->assertFalse($c->hasCase());
        $this->assertTrue($c->isLowerCase());
        $this->assertTrue($c->isUpperCase());
    }



    public function testDigitDetection()
    {
        $c = new Malenki\Bah\C('0');
        $this->assertTrue($c->isDigit());
        
        $c = new Malenki\Bah\C('a');
        $this->assertFalse($c->isDigit());
        
        $c = new Malenki\Bah\C(' ');
        $this->assertFalse($c->isDigit());
        
        $c = new Malenki\Bah\C(',');
        $this->assertFalse($c->isDigit());
    }



    public function testUnicodeCodePoint()
    {
        $c = new Malenki\Bah\C('é');
        $n = new Malenki\Bah\N(233);
        $this->assertEquals($n, $c->unicode());
        
        $c = new Malenki\Bah\C('€');
        $n = new Malenki\Bah\N(8364);
        $this->assertEquals($n, $c->unicode());
        
        $c = new Malenki\Bah\C('æ');
        $n = new Malenki\Bah\N(230);
        $this->assertEquals($n, $c->unicode());
    }


    /**
     * testBlock 
     * @todo Finish that!
     * @access public
     * @return void
     */
    public function testBlock()
    {
        $c = new Malenki\Bah\C('z');
        $this->assertEquals($c->block, new Malenki\Bah\S('Basic Latin'));

        $c = new Malenki\Bah\C('Œ');
        $this->assertEquals($c->block, new Malenki\Bah\S('Latin Extended-A'));
        $c = new Malenki\Bah\C('Ȁ');
        $this->assertEquals($c->block, new Malenki\Bah\S('Latin Extended-B'));
        $c = new Malenki\Bah\C('α');
        $this->assertEquals($c->block, new Malenki\Bah\S('Greek and Coptic'));
        $c = new Malenki\Bah\C('Ю');
        $this->assertEquals($c->block, new Malenki\Bah\S('Cyrillic'));
        
        $c = new Malenki\Bah\C('Ꙛ');
        $this->assertEquals($c->block, new Malenki\Bah\S('Cyrillic Extended-B'));
        $c = new Malenki\Bah\C('Ֆ');
        $this->assertEquals($c->block, new Malenki\Bah\S('Armenian'));
        $c = new Malenki\Bah\C('ش');
        $this->assertEquals($c->block, new Malenki\Bah\S('Arabic'));
        $c = new Malenki\Bah\C('א');
        $this->assertEquals($c->block, new Malenki\Bah\S('Hebrew'));
        $c = new Malenki\Bah\C('ܐ');
        $this->assertEquals($c->block, new Malenki\Bah\S('Syriac'));

        $c = new Malenki\Bah\C('Ḫ');
        $this->assertEquals($c->block, new Malenki\Bah\S('Latin Extended Additional'));

        $c = new Malenki\Bah\C('Ɐ');
        $this->assertEquals($c->block, new Malenki\Bah\S('Latin Extended-C'));
        $c = new Malenki\Bah\C('Ⲁ');
        $this->assertEquals($c->block, new Malenki\Bah\S('Coptic'));

        $c = new Malenki\Bah\C('Ꜧ');
        $this->assertEquals($c->block, new Malenki\Bah\S('Latin Extended-D'));

        $c = new Malenki\Bah\C('𐅃');
        $this->assertEquals($c->block, new Malenki\Bah\S('Ancient Greek Numbers'));

        $c = new Malenki\Bah\C('𐌍');
        $this->assertEquals($c->block, new Malenki\Bah\S('Old Italic'));
        $c = new Malenki\Bah\C('𐌰');
        $this->assertEquals($c->block, new Malenki\Bah\S('Gothic'));

        $c = new Malenki\Bah\C('𒀧');
        $this->assertEquals($c->block, new Malenki\Bah\S('Cuneiform'));

        $c = new Malenki\Bah\C('𓂈');
        $this->assertEquals($c->block, new Malenki\Bah\S('Egyptian Hieroglyphs'));

    }
}

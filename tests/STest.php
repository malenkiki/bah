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



class STest extends PHPUnit_Framework_TestCase
{
    public function testBasis()
    {
        $s = new Malenki\Bah\S('Je suis une chaîne !');
        $this->assertEquals((string) $s, 'Je suis une chaîne !');
        $this->assertEquals((string) $s->upper, 'JE SUIS UNE CHAÎNE !');
        $this->assertEquals((string) $s->lower, 'je suis une chaîne !');
        $this->assertEquals((string) $s->title, 'Je Suis Une Chaîne !');
        $this->assertEquals(count($s), 20);
        $this->assertFalse($s->isVoid());
        
        $s = new Malenki\Bah\S('');
        $this->assertTrue($s->isVoid());

        $s = new Malenki\Bah\S('!');
        $this->assertEquals((string) $s->times(3), '!!!');
    }



    public function testChars()
    {
        /*
        $s = new Malenki\Bah\S('Je suis une chaîne !');
        $this->assertEquals(count($s->chars()), 20);
         */
    }
}



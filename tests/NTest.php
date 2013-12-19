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



class N extends PHPUnit_Framework_TestCase
{
    public function testGreekNumerals()
    {
        // single digit
        $one = new Malenki\Bah\N(1);
        $this->assertEquals('α', $one->greek());

        // ten and followers…
        $ten = new Malenki\Bah\N(10);
        $this->assertEquals('ι', $ten->greek());
        
        $hundred = new Malenki\Bah\N(100);
        $this->assertEquals('ρ', $hundred->greek());
        
        $thousand = new Malenki\Bah\N(1000);
        $this->assertEquals('ͺα', $thousand->greek());

        $number269 = new Malenki\Bah\N(269);
        $this->assertEquals('σξθ', $number269->greek());
    }

    public function testRomanNumerals()
    {
        $one = new Malenki\Bah\N(1);
        $this->assertEquals('i', $one->roman());
        
        $two = new Malenki\Bah\N(2);
        $this->assertEquals('ii', $two->roman());
        
        $three = new Malenki\Bah\N(3);
        $this->assertEquals('iii', $three->roman());
        
        $four = new Malenki\Bah\N(4);
        $this->assertEquals('iv', $four->roman());
        
        $five = new Malenki\Bah\N(5);
        $this->assertEquals('v', $five->roman());
        
        $six = new Malenki\Bah\N(6);
        $this->assertEquals('vi', $six->roman());
        
        $seven = new Malenki\Bah\N(7);
        $this->assertEquals('vii', $seven->roman());
        
        $eight = new Malenki\Bah\N(8);
        $this->assertEquals('viii', $eight->roman());
        
        $nine = new Malenki\Bah\N(9);
        $this->assertEquals('ix', $nine->roman());

        $ten = new Malenki\Bah\N(10);
        $this->assertEquals('x', $ten->roman());
        
        $number269 = new Malenki\Bah\N(269);
        $this->assertEquals('cclxix', $number269->roman());
        
        $number1978 = new Malenki\Bah\N(1978);
        $this->assertEquals('mcmlxxviii', $number1978->roman());
    }
}

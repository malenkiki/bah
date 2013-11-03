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


include_once('src/Malenki/Bah/O.php');
include_once('src/Malenki/Bah/A.php');
include_once('src/Malenki/Bah/C.php');
include_once('src/Malenki/Bah/S.php');


class C extends PHPUnit_Framework_TestCase
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
        $this->assertEquals($c->block(), new Malenki\Bah\S('Basic Latin'));
        /*
Latin-1 Supplement
             */

        $c = new Malenki\Bah\C('Œ');
        $this->assertEquals($c->block(), new Malenki\Bah\S('Latin Extended-A'));
        $c = new Malenki\Bah\C('Ȁ');
        $this->assertEquals($c->block(), new Malenki\Bah\S('Latin Extended-B'));
        /*
IPA Extensions
Spacing Modifier Letters
Combining Diacritical Marks
Cyrillic Supplement
         */
        $c = new Malenki\Bah\C('α');
        $this->assertEquals($c->block(), new Malenki\Bah\S('Greek and Coptic'));
        $c = new Malenki\Bah\C('Ю');
        $this->assertEquals($c->block(), new Malenki\Bah\S('Cyrillic'));
        
        //$c = new Malenki\Bah\C('');
        //$this->assertEquals($c->block(), new Malenki\Bah\S('Cyrillic Extended-A'));
        $c = new Malenki\Bah\C('Ꙛ');
        $this->assertEquals($c->block(), new Malenki\Bah\S('Cyrillic Extended-B'));
        $c = new Malenki\Bah\C('Ֆ');
        $this->assertEquals($c->block(), new Malenki\Bah\S('Armenian'));
        $c = new Malenki\Bah\C('ش');
        $this->assertEquals($c->block(), new Malenki\Bah\S('Arabic'));
        //$c = new Malenki\Bah\C('');
        //$this->assertEquals($c->block(), new Malenki\Bah\S('Arabic Supplement'));
        $c = new Malenki\Bah\C('א');
        $this->assertEquals($c->block(), new Malenki\Bah\S('Hebrew'));
        $c = new Malenki\Bah\C('ܐ');
        $this->assertEquals($c->block(), new Malenki\Bah\S('Syriac'));
            /*
Thaana
NKo
Samaritan
Mandaic
Arabic Extended-A
Devanagari
Bengali
Gurmukhi
Gujarati
Oriya
Tamil
Telugu
Kannada
Malayalam
Sinhala
Thai
Lao
Tibetan
Myanmar
Georgian
Hangul Jamo
Ethiopic
Ethiopic Supplement
Cherokee
Unified Canadian Aboriginal Syllabics
Ogham
Runic
Tagalog
Hanunoo
Buhid
Tagbanwa
Khmer
Mongolian
Unified Canadian Aboriginal Syllabics Extended
Limbu
Tai Le
New Tai Lue
Khmer Symbols
Buginese
Tai Tham
Balinese
Sundanese
Batak
Lepcha
Ol Chiki
Sundanese Supplement
Vedic Extensions
Phonetic Extensions
Phonetic Extensions Supplement
Combining Diacritical Marks Supplement
             */

        $c = new Malenki\Bah\C('Ḫ');
        $this->assertEquals($c->block(), new Malenki\Bah\S('Latin Extended Additional'));
        /*
Greek Extended
General Punctuation
Superscripts and Subscripts
Currency Symbols
Combining Diacritical Marks for Symbols
Letterlike Symbols
Number Forms
Arrows
Mathematical Operators
Miscellaneous Technical
Control Pictures
Optical Character Recognition
Enclosed Alphanumerics
Box Drawing
Block Elements
Geometric Shapes
Miscellaneous Symbols
Dingbats
Miscellaneous Mathematical Symbols-A
Supplemental Arrows-A
Braille Patterns
Supplemental Arrows-B
Miscellaneous Mathematical Symbols-B
Supplemental Mathematical Operators
Miscellaneous Symbols and Arrows
Glagolitic
             */

        $c = new Malenki\Bah\C('Ɐ');
        $this->assertEquals($c->block(), new Malenki\Bah\S('Latin Extended-C'));
        $c = new Malenki\Bah\C('Ⲁ');
        $this->assertEquals($c->block(), new Malenki\Bah\S('Coptic'));
        /*
Georgian Supplement
Tifinagh
Ethiopic Extended
Cyrillic Extended-A
Supplemental Punctuation
CJK Radicals Supplement
Kangxi Radicals
Ideographic Description Characters
CJK Symbols and Punctuation
Hiragana
Katakana
Bopomofo
Hangul Compatibility Jamo
Kanbun
Bopomofo Extended
CJK Strokes
Katakana Phonetic Extensions
Enclosed CJK Letters and Months
CJK Compatibility
CJK Unified Ideographs Extension A
Yijing Hexagram Symbols
CJK Unified Ideographs
Yi Syllables
Yi Radicals
Lisu
Vai
Cyrillic Extended-B
Bamum
Modifier Tone Letters
             */

        $c = new Malenki\Bah\C('Ꜧ');
        $this->assertEquals($c->block(), new Malenki\Bah\S('Latin Extended-D'));
        /*
Syloti Nagri
Common Indic Number Forms
Phags-pa
Saurashtra
Devanagari Extended
Kayah Li
Rejang
Hangul Jamo Extended-A
Javanese
Cham
Myanmar Extended-A
Tai Viet
Meetei Mayek Extensions
Ethiopic Extended-A
Meetei Mayek
Hangul Syllables
Hangul Jamo Extended-B
High Surrogates
High Private Use Surrogates
Low Surrogates
Private Use Area
CJK Compatibility Ideographs
Alphabetic Presentation Forms
Arabic Presentation Forms-A
Variation Selectors
Vertical Forms
Combining Half Marks
CJK Compatibility Forms
Small Form Variants
Arabic Presentation Forms-B
Halfwidth and Fullwidth Forms
Specials
Linear B Syllabary
Linear B Ideograms
Aegean Numbers
         */

        $c = new Malenki\Bah\C('𐅃');
        $this->assertEquals($c->block(), new Malenki\Bah\S('Ancient Greek Numbers'));
        /*
Ancient Symbols
Phaistos Disc
Lycian
Carian
         */

        $c = new Malenki\Bah\C('𐌍');
        $this->assertEquals($c->block(), new Malenki\Bah\S('Old Italic'));
        $c = new Malenki\Bah\C('𐌰');
        $this->assertEquals($c->block(), new Malenki\Bah\S('Gothic'));
        /*

Ugaritic
Old Persian
Deseret
Shavian
Osmanya
Cypriot Syllabary
Imperial Aramaic
Phoenician
Lydian
Meroitic Hieroglyphs
Meroitic Cursive
Kharoshthi
Old South Arabian
Avestan
Inscriptional Parthian
Inscriptional Pahlavi
Old Turkic
Rumi Numeral Symbols
Brahmi
Kaithi
Sora Sompeng
Chakma
Sharada
Takri
         */

        $c = new Malenki\Bah\C('𒀧');
        $this->assertEquals($c->block(), new Malenki\Bah\S('Cuneiform'));
        /*

Cuneiform Numbers and Punctuation
         */

        $c = new Malenki\Bah\C('𓂈');
        $this->assertEquals($c->block(), new Malenki\Bah\S('Egyptian Hieroglyphs'));
        /*
Bamum Supplement
Miao
Kana Supplement
Byzantine Musical Symbols
Musical Symbols
Ancient Greek Musical Notation
Tai Xuan Jing Symbols
Counting Rod Numerals
Mathematical Alphanumeric Symbols
Arabic Mathematical Alphabetic Symbols
Mahjong Tiles
Domino Tiles
Playing Cards
Enclosed Alphanumeric Supplement
Enclosed Ideographic Supplement
Miscellaneous Symbols And Pictographs
Emoticons
Transport And Map Symbols
Alchemical Symbols
CJK Unified Ideographs Extension B
CJK Unified Ideographs Extension C
CJK Unified Ideographs Extension D
CJK Compatibility Ideographs Supplement
Tags
Variation Selectors Supplement
Supplementary Private Use Area-A
Supplementary Private Use Area-B
         */

    }
}

<?php
/**
 * Copyright (c) 2013 Michel Petit <petit.michel@gmail.com>
 * 
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 * 
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace Malenki\Bah;

/**
 * Define a single character.
 *
 * Unlike other classes of Bah library, this class is not equivalent of a PHP 
 * primitive type, but it can be very useful to deal with characters and their 
 * UTF-8 properties.
 *
 * So, you can tests some characters properties, such as "is ti punctuation?"; 
 * "is it lowercase?"; "is it right to left character?" and many others…
 *
 * You can get all characters from family of given one (from same unicode 
 * block), you can get unicode code point and block name for each character.
 *
 * @package Malenki\Bah
 * @property-read Malenki\Bah\A $bytes A collection of Malenki\Bah\N objects
 * @property-read Malenki\Bah\S $to_s Converted version of character as Malenki\Bah\S object.
 * @property-read Malenki\Bah\N $to_n Converted version of character as Malenki\Bah\N object. Be careful: if it is not a digit, then this raises an exception.
 * @property-read string $string Cast to primitive string
 * @property-read string $str Cast to primitive string
 * @property-read integer $integer Cast to primitive integer, if possible
 * @property-read integer $int Cast to primitive integer, if possible
 * @property-read C $upper Convert current character to uppercase
 * @property-read C $lower Convert current character to lowercase
 * @property-read N $unicode Gets unicode code point
 * @property-read boolean $rtl True if it is a right to left character
 * @property-read boolean $is_rtl True if it is a right to left character
 * @property-read boolean $right_to_left True if it is a right to left character
 * @property-read boolean $is_right_to_left True if it is a right to left character
 * @property-read boolean $ltr True if it is a left to right character
 * @property-read boolean $is_ltr True if it is a left to right character
 * @property-read boolean $left_to_right True if it is a left to right character
 * @property-read boolean $is_left_to_right True if it is a left to right character
 * @property-read A Collection of all characters of the same unicode block of current character.
 *
 * @todo http://en.wikipedia.org/wiki/Mapping_of_Unicode_characters
 * @todo http://en.wikipedia.org/wiki/Basic_Multilingual_Plane#Basic_Multilingual_Plane
 * @todo http://www.unicode.org/roadmaps/
 * @license MIT
 * @author Michel Petit aka "Malenki" <petit.michel@gmail.com>
 */
class C extends O
{
    const ENCODING = 'UTF-8';

    protected static $arr_blocks = array(
        array('start' => 0x0000, 'end' => 0x007F, 'name' => 'Basic Latin'),
        array('start' => 0x0080, 'end' => 0x00FF, 'name' => 'Latin-1 Supplement'),
        array('start' => 0x0100, 'end' => 0x017F, 'name' => 'Latin Extended-A'),
        array('start' => 0x0180, 'end' => 0x024F, 'name' => 'Latin Extended-B'),
        array('start' => 0x0250, 'end' => 0x02AF, 'name' => 'IPA Extensions'),
        array('start' => 0x02B0, 'end' => 0x02FF, 'name' => 'Spacing Modifier Letters'),
        array('start' => 0x0300, 'end' => 0x036F, 'name' => 'Combining Diacritical Marks'),
        array('start' => 0x0370, 'end' => 0x03FF, 'name' => 'Greek and Coptic'),
        array('start' => 0x0400, 'end' => 0x04FF, 'name' => 'Cyrillic'),
        array('start' => 0x0500, 'end' => 0x052F, 'name' => 'Cyrillic Supplement'),
        array('start' => 0x0530, 'end' => 0x058F, 'name' => 'Armenian'),
        array('start' => 0x0590, 'end' => 0x05FF, 'name' => 'Hebrew'),
        array('start' => 0x0600, 'end' => 0x06FF, 'name' => 'Arabic'),
        array('start' => 0x0700, 'end' => 0x074F, 'name' => 'Syriac'),
        array('start' => 0x0750, 'end' => 0x077F, 'name' => 'Arabic Supplement'),
        array('start' => 0x0780, 'end' => 0x07BF, 'name' => 'Thaana'),
        array('start' => 0x07C0, 'end' => 0x07FF, 'name' => 'NKo'),
        array('start' => 0x0800, 'end' => 0x083F, 'name' => 'Samaritan'),
        array('start' => 0x0840, 'end' => 0x085F, 'name' => 'Mandaic'),
        array('start' => 0x0900, 'end' => 0x097F, 'name' => 'Devanagari'),
        array('start' => 0x0980, 'end' => 0x09FF, 'name' => 'Bengali'),
        array('start' => 0x0A00, 'end' => 0x0A7F, 'name' => 'Gurmukhi'),
        array('start' => 0x0A80, 'end' => 0x0AFF, 'name' => 'Gujarati'),
        array('start' => 0x0B00, 'end' => 0x0B7F, 'name' => 'Oriya'),
        array('start' => 0x0B80, 'end' => 0x0BFF, 'name' => 'Tamil'),
        array('start' => 0x0C00, 'end' => 0x0C7F, 'name' => 'Telugu'),
        array('start' => 0x0C80, 'end' => 0x0CFF, 'name' => 'Kannada'),
        array('start' => 0x0D00, 'end' => 0x0D7F, 'name' => 'Malayalam'),
        array('start' => 0x0D80, 'end' => 0x0DFF, 'name' => 'Sinhala'),
        array('start' => 0x0E00, 'end' => 0x0E7F, 'name' => 'Thai'),
        array('start' => 0x0E80, 'end' => 0x0EFF, 'name' => 'Lao'),
        array('start' => 0x0F00, 'end' => 0x0FFF, 'name' => 'Tibetan'),
        array('start' => 0x1000, 'end' => 0x109F, 'name' => 'Myanmar'),
        array('start' => 0x10A0, 'end' => 0x10FF, 'name' => 'Georgian'),
        array('start' => 0x1100, 'end' => 0x11FF, 'name' => 'Hangul Jamo'),
        array('start' => 0x1200, 'end' => 0x137F, 'name' => 'Ethiopic'),
        array('start' => 0x1380, 'end' => 0x139F, 'name' => 'Ethiopic Supplement'),
        array('start' => 0x13A0, 'end' => 0x13FF, 'name' => 'Cherokee'),
        array('start' => 0x1400, 'end' => 0x167F, 'name' => 'Unified Canadian Aboriginal Syllabics'),
        array('start' => 0x1680, 'end' => 0x169F, 'name' => 'Ogham'),
        array('start' => 0x16A0, 'end' => 0x16FF, 'name' => 'Runic'),
        array('start' => 0x1700, 'end' => 0x171F, 'name' => 'Tagalog'),
        array('start' => 0x1720, 'end' => 0x173F, 'name' => 'Hanunoo'),
        array('start' => 0x1740, 'end' => 0x175F, 'name' => 'Buhid'),
        array('start' => 0x1760, 'end' => 0x177F, 'name' => 'Tagbanwa'),
        array('start' => 0x1780, 'end' => 0x17FF, 'name' => 'Khmer'),
        array('start' => 0x1800, 'end' => 0x18AF, 'name' => 'Mongolian'),
        array('start' => 0x18B0, 'end' => 0x18FF, 'name' => 'Unified Canadian Aboriginal Syllabics Extended'),
        array('start' => 0x1900, 'end' => 0x194F, 'name' => 'Limbu'),
        array('start' => 0x1950, 'end' => 0x197F, 'name' => 'Tai Le'),
        array('start' => 0x1980, 'end' => 0x19DF, 'name' => 'New Tai Lue'),
        array('start' => 0x19E0, 'end' => 0x19FF, 'name' => 'Khmer Symbols'),
        array('start' => 0x1A00, 'end' => 0x1A1F, 'name' => 'Buginese'),
        array('start' => 0x1A20, 'end' => 0x1AAF, 'name' => 'Tai Tham'),
        array('start' => 0x1B00, 'end' => 0x1B7F, 'name' => 'Balinese'),
        array('start' => 0x1B80, 'end' => 0x1BBF, 'name' => 'Sundanese'),
        array('start' => 0x1BC0, 'end' => 0x1BFF, 'name' => 'Batak'),
        array('start' => 0x1C00, 'end' => 0x1C4F, 'name' => 'Lepcha'),
        array('start' => 0x1C50, 'end' => 0x1C7F, 'name' => 'Ol Chiki'),
        array('start' => 0x1CD0, 'end' => 0x1CFF, 'name' => 'Vedic Extensions'),
        array('start' => 0x1D00, 'end' => 0x1D7F, 'name' => 'Phonetic Extensions'),
        array('start' => 0x1D80, 'end' => 0x1DBF, 'name' => 'Phonetic Extensions Supplement'),
        array('start' => 0x1DC0, 'end' => 0x1DFF, 'name' => 'Combining Diacritical Marks Supplement'),
        array('start' => 0x1E00, 'end' => 0x1EFF, 'name' => 'Latin Extended Additional'),
        array('start' => 0x1F00, 'end' => 0x1FFF, 'name' => 'Greek Extended'),
        array('start' => 0x2000, 'end' => 0x206F, 'name' => 'General Punctuation'),
        array('start' => 0x2070, 'end' => 0x209F, 'name' => 'Superscripts and Subscripts'),
        array('start' => 0x20A0, 'end' => 0x20CF, 'name' => 'Currency Symbols'),
        array('start' => 0x20D0, 'end' => 0x20FF, 'name' => 'Combining Diacritical Marks for Symbols'),
        array('start' => 0x2100, 'end' => 0x214F, 'name' => 'Letterlike Symbols'),
        array('start' => 0x2150, 'end' => 0x218F, 'name' => 'Number Forms'),
        array('start' => 0x2190, 'end' => 0x21FF, 'name' => 'Arrows'),
        array('start' => 0x2200, 'end' => 0x22FF, 'name' => 'Mathematical Operators'),
        array('start' => 0x2300, 'end' => 0x23FF, 'name' => 'Miscellaneous Technical'),
        array('start' => 0x2400, 'end' => 0x243F, 'name' => 'Control Pictures'),
        array('start' => 0x2440, 'end' => 0x245F, 'name' => 'Optical Character Recognition'),
        array('start' => 0x2460, 'end' => 0x24FF, 'name' => 'Enclosed Alphanumerics'),
        array('start' => 0x2500, 'end' => 0x257F, 'name' => 'Box Drawing'),
        array('start' => 0x2580, 'end' => 0x259F, 'name' => 'Block Elements'),
        array('start' => 0x25A0, 'end' => 0x25FF, 'name' => 'Geometric Shapes'),
        array('start' => 0x2600, 'end' => 0x26FF, 'name' => 'Miscellaneous Symbols'),
        array('start' => 0x2700, 'end' => 0x27BF, 'name' => 'Dingbats'),
        array('start' => 0x27C0, 'end' => 0x27EF, 'name' => 'Miscellaneous Mathematical Symbols-A'),
        array('start' => 0x27F0, 'end' => 0x27FF, 'name' => 'Supplemental Arrows-A'),
        array('start' => 0x2800, 'end' => 0x28FF, 'name' => 'Braille Patterns'),
        array('start' => 0x2900, 'end' => 0x297F, 'name' => 'Supplemental Arrows-B'),
        array('start' => 0x2980, 'end' => 0x29FF, 'name' => 'Miscellaneous Mathematical Symbols-B'),
        array('start' => 0x2A00, 'end' => 0x2AFF, 'name' => 'Supplemental Mathematical Operators'),
        array('start' => 0x2B00, 'end' => 0x2BFF, 'name' => 'Miscellaneous Symbols and Arrows'),
        array('start' => 0x2C00, 'end' => 0x2C5F, 'name' => 'Glagolitic'),
        array('start' => 0x2C60, 'end' => 0x2C7F, 'name' => 'Latin Extended-C'),
        array('start' => 0x2C80, 'end' => 0x2CFF, 'name' => 'Coptic'),
        array('start' => 0x2D00, 'end' => 0x2D2F, 'name' => 'Georgian Supplement'),
        array('start' => 0x2D30, 'end' => 0x2D7F, 'name' => 'Tifinagh'),
        array('start' => 0x2D80, 'end' => 0x2DDF, 'name' => 'Ethiopic Extended'),
        array('start' => 0x2DE0, 'end' => 0x2DFF, 'name' => 'Cyrillic Extended-A'),
        array('start' => 0x2E00, 'end' => 0x2E7F, 'name' => 'Supplemental Punctuation'),
        array('start' => 0x2E80, 'end' => 0x2EFF, 'name' => 'CJK Radicals Supplement'),
        array('start' => 0x2F00, 'end' => 0x2FDF, 'name' => 'Kangxi Radicals'),
        array('start' => 0x2FF0, 'end' => 0x2FFF, 'name' => 'Ideographic Description Characters'),
        array('start' => 0x3000, 'end' => 0x303F, 'name' => 'CJK Symbols and Punctuation'),
        array('start' => 0x3040, 'end' => 0x309F, 'name' => 'Hiragana'),
        array('start' => 0x30A0, 'end' => 0x30FF, 'name' => 'Katakana'),
        array('start' => 0x3100, 'end' => 0x312F, 'name' => 'Bopomofo'),
        array('start' => 0x3130, 'end' => 0x318F, 'name' => 'Hangul Compatibility Jamo'),
        array('start' => 0x3190, 'end' => 0x319F, 'name' => 'Kanbun'),
        array('start' => 0x31A0, 'end' => 0x31BF, 'name' => 'Bopomofo Extended'),
        array('start' => 0x31C0, 'end' => 0x31EF, 'name' => 'CJK Strokes'),
        array('start' => 0x31F0, 'end' => 0x31FF, 'name' => 'Katakana Phonetic Extensions'),
        array('start' => 0x3200, 'end' => 0x32FF, 'name' => 'Enclosed CJK Letters and Months'),
        array('start' => 0x3300, 'end' => 0x33FF, 'name' => 'CJK Compatibility'),
        array('start' => 0x3400, 'end' => 0x4DBF, 'name' => 'CJK Unified Ideographs Extension A'),
        array('start' => 0x4DC0, 'end' => 0x4DFF, 'name' => 'Yijing Hexagram Symbols'),
        array('start' => 0x4E00, 'end' => 0x9FFF, 'name' => 'CJK Unified Ideographs'),
        array('start' => 0xA000, 'end' => 0xA48F, 'name' => 'Yi Syllables'),
        array('start' => 0xA490, 'end' => 0xA4CF, 'name' => 'Yi Radicals'),
        array('start' => 0xA4D0, 'end' => 0xA4FF, 'name' => 'Lisu'),
        array('start' => 0xA500, 'end' => 0xA63F, 'name' => 'Vai'),
        array('start' => 0xA640, 'end' => 0xA69F, 'name' => 'Cyrillic Extended-B'),
        array('start' => 0xA6A0, 'end' => 0xA6FF, 'name' => 'Bamum'),
        array('start' => 0xA700, 'end' => 0xA71F, 'name' => 'Modifier Tone Letters'),
        array('start' => 0xA720, 'end' => 0xA7FF, 'name' => 'Latin Extended-D'),
        array('start' => 0xA800, 'end' => 0xA82F, 'name' => 'Syloti Nagri'),
        array('start' => 0xA830, 'end' => 0xA83F, 'name' => 'Common Indic Number Forms'),
        array('start' => 0xA840, 'end' => 0xA87F, 'name' => 'Phags-pa'),
        array('start' => 0xA880, 'end' => 0xA8DF, 'name' => 'Saurashtra'),
        array('start' => 0xA8E0, 'end' => 0xA8FF, 'name' => 'Devanagari Extended'),
        array('start' => 0xA900, 'end' => 0xA92F, 'name' => 'Kayah Li'),
        array('start' => 0xA930, 'end' => 0xA95F, 'name' => 'Rejang'),
        array('start' => 0xA960, 'end' => 0xA97F, 'name' => 'Hangul Jamo Extended-A'),
        array('start' => 0xA980, 'end' => 0xA9DF, 'name' => 'Javanese'),
        array('start' => 0xAA00, 'end' => 0xAA5F, 'name' => 'Cham'),
        array('start' => 0xAA60, 'end' => 0xAA7F, 'name' => 'Myanmar Extended-A'),
        array('start' => 0xAA80, 'end' => 0xAADF, 'name' => 'Tai Viet'),
        array('start' => 0xAB00, 'end' => 0xAB2F, 'name' => 'Ethiopic Extended-A'),
        array('start' => 0xABC0, 'end' => 0xABFF, 'name' => 'Meetei Mayek'),
        array('start' => 0xAC00, 'end' => 0xD7AF, 'name' => 'Hangul Syllables'),
        array('start' => 0xD7B0, 'end' => 0xD7FF, 'name' => 'Hangul Jamo Extended-B'),
        array('start' => 0xD800, 'end' => 0xDB7F, 'name' => 'High Surrogates'),
        array('start' => 0xDB80, 'end' => 0xDBFF, 'name' => 'High Private Use Surrogates'),
        array('start' => 0xDC00, 'end' => 0xDFFF, 'name' => 'Low Surrogates'),
        array('start' => 0xE000, 'end' => 0xF8FF, 'name' => 'Private Use Area'),
        array('start' => 0xF900, 'end' => 0xFAFF, 'name' => 'CJK Compatibility Ideographs'),
        array('start' => 0xFB00, 'end' => 0xFB4F, 'name' => 'Alphabetic Presentation Forms'),
        array('start' => 0xFB50, 'end' => 0xFDFF, 'name' => 'Arabic Presentation Forms-A'),
        array('start' => 0xFE00, 'end' => 0xFE0F, 'name' => 'Variation Selectors'),
        array('start' => 0xFE10, 'end' => 0xFE1F, 'name' => 'Vertical Forms'),
        array('start' => 0xFE20, 'end' => 0xFE2F, 'name' => 'Combining Half Marks'),
        array('start' => 0xFE30, 'end' => 0xFE4F, 'name' => 'CJK Compatibility Forms'),
        array('start' => 0xFE50, 'end' => 0xFE6F, 'name' => 'Small Form Variants'),
        array('start' => 0xFE70, 'end' => 0xFEFF, 'name' => 'Arabic Presentation Forms-B'),
        array('start' => 0xFF00, 'end' => 0xFFEF, 'name' => 'Halfwidth and Fullwidth Forms'),
        array('start' => 0xFFF0, 'end' => 0xFFFF, 'name' => 'Specials'),
        array('start' => 0x10000, 'end' => 0x1007F, 'name' => 'Linear B Syllabary'),
        array('start' => 0x10080, 'end' => 0x100FF, 'name' => 'Linear B Ideograms'),
        array('start' => 0x10100, 'end' => 0x1013F, 'name' => 'Aegean Numbers'),
        array('start' => 0x10140, 'end' => 0x1018F, 'name' => 'Ancient Greek Numbers'),
        array('start' => 0x10190, 'end' => 0x101CF, 'name' => 'Ancient Symbols'),
        array('start' => 0x101D0, 'end' => 0x101FF, 'name' => 'Phaistos Disc'),
        array('start' => 0x10280, 'end' => 0x1029F, 'name' => 'Lycian'),
        array('start' => 0x102A0, 'end' => 0x102DF, 'name' => 'Carian'),
        array('start' => 0x10300, 'end' => 0x1032F, 'name' => 'Old Italic'),
        array('start' => 0x10330, 'end' => 0x1034F, 'name' => 'Gothic'),
        array('start' => 0x10380, 'end' => 0x1039F, 'name' => 'Ugaritic'),
        array('start' => 0x103A0, 'end' => 0x103DF, 'name' => 'Old Persian'),
        array('start' => 0x10400, 'end' => 0x1044F, 'name' => 'Deseret'),
        array('start' => 0x10450, 'end' => 0x1047F, 'name' => 'Shavian'),
        array('start' => 0x10480, 'end' => 0x104AF, 'name' => 'Osmanya'),
        array('start' => 0x10800, 'end' => 0x1083F, 'name' => 'Cypriot Syllabary'),
        array('start' => 0x10840, 'end' => 0x1085F, 'name' => 'Imperial Aramaic'),
        array('start' => 0x10900, 'end' => 0x1091F, 'name' => 'Phoenician'),
        array('start' => 0x10920, 'end' => 0x1093F, 'name' => 'Lydian'),
        array('start' => 0x10A00, 'end' => 0x10A5F, 'name' => 'Kharoshthi'),
        array('start' => 0x10A60, 'end' => 0x10A7F, 'name' => 'Old South Arabian'),
        array('start' => 0x10B00, 'end' => 0x10B3F, 'name' => 'Avestan'),
        array('start' => 0x10B40, 'end' => 0x10B5F, 'name' => 'Inscriptional Parthian'),
        array('start' => 0x10B60, 'end' => 0x10B7F, 'name' => 'Inscriptional Pahlavi'),
        array('start' => 0x10C00, 'end' => 0x10C4F, 'name' => 'Old Turkic'),
        array('start' => 0x10E60, 'end' => 0x10E7F, 'name' => 'Rumi Numeral Symbols'),
        array('start' => 0x11000, 'end' => 0x1107F, 'name' => 'Brahmi'),
        array('start' => 0x11080, 'end' => 0x110CF, 'name' => 'Kaithi'),
        array('start' => 0x12000, 'end' => 0x123FF, 'name' => 'Cuneiform'),
        array('start' => 0x12400, 'end' => 0x1247F, 'name' => 'Cuneiform Numbers and Punctuation'),
        array('start' => 0x13000, 'end' => 0x1342F, 'name' => 'Egyptian Hieroglyphs'),
        array('start' => 0x16800, 'end' => 0x16A3F, 'name' => 'Bamum Supplement'),
        array('start' => 0x1B000, 'end' => 0x1B0FF, 'name' => 'Kana Supplement'),
        array('start' => 0x1D000, 'end' => 0x1D0FF, 'name' => 'Byzantine Musical Symbols'),
        array('start' => 0x1D100, 'end' => 0x1D1FF, 'name' => 'Musical Symbols'),
        array('start' => 0x1D200, 'end' => 0x1D24F, 'name' => 'Ancient Greek Musical Notation'),
        array('start' => 0x1D300, 'end' => 0x1D35F, 'name' => 'Tai Xuan Jing Symbols'),
        array('start' => 0x1D360, 'end' => 0x1D37F, 'name' => 'Counting Rod Numerals'),
        array('start' => 0x1D400, 'end' => 0x1D7FF, 'name' => 'Mathematical Alphanumeric Symbols'),
        array('start' => 0x1F000, 'end' => 0x1F02F, 'name' => 'Mahjong Tiles'),
        array('start' => 0x1F030, 'end' => 0x1F09F, 'name' => 'Domino Tiles'),
        array('start' => 0x1F0A0, 'end' => 0x1F0FF, 'name' => 'Playing Cards'),
        array('start' => 0x1F100, 'end' => 0x1F1FF, 'name' => 'Enclosed Alphanumeric Supplement'),
        array('start' => 0x1F200, 'end' => 0x1F2FF, 'name' => 'Enclosed Ideographic Supplement'),
        array('start' => 0x1F300, 'end' => 0x1F5FF, 'name' => 'Miscellaneous Symbols And Pictographs'),
        array('start' => 0x1F600, 'end' => 0x1F64F, 'name' => 'Emoticons'),
        array('start' => 0x1F680, 'end' => 0x1F6FF, 'name' => 'Transport And Map Symbols'),
        array('start' => 0x1F700, 'end' => 0x1F77F, 'name' => 'Alchemical Symbols'),
        array('start' => 0x20000, 'end' => 0x2A6DF, 'name' => 'CJK Unified Ideographs Extension B'),
        array('start' => 0x2A700, 'end' => 0x2B73F, 'name' => 'CJK Unified Ideographs Extension C'),
        array('start' => 0x2B740, 'end' => 0x2B81F, 'name' => 'CJK Unified Ideographs Extension D'),
        array('start' => 0x2F800, 'end' => 0x2FA1F, 'name' => 'CJK Compatibility Ideographs Supplement'),
        array('start' => 0xE0000, 'end' => 0xE007F, 'name' => 'Tags'),
        array('start' => 0xE0100, 'end' => 0xE01EF, 'name' => 'Variation Selectors Supplement'),
        array('start' => 0xF0000, 'end' => 0xFFFFF, 'name' => 'Supplementary Private Use Area-A'),
        array('start' => 0x100000, 'end' => 0x10FFFF, 'name' => 'Supplementary Private Use Area-B')
    );

    protected $col_bytes = null;

    /**
     * Store whether the current character is surrogate or not.
     *
     * This exists only to avoid PHP bug with `preg_match()` function and 
     * `\p{Cs}` pattern.
     * 
     * @var boolean
     */
    protected $bool_is_surrogate = false; // due to PHP issue about \p{Cs}…

    /**
     * Instanciates new character.
     *
     * Creates new character object using 3 different ways.
     *
     * You can instanciate it using:
     *
     *  - a `\Malenki\Bah\N` object. In this case, given object is read to be 
     *  the UTF-8 code point of the character. So, The Bah Number must be in 
     *  `[0, 0x10FFFF]` range to be valid.
     *  - a string-like value having more than one characters must be an HTML entity
     *  - a single char string-like.
     * 
     * Examples:
     *
     *     // Unicode code point way
     *     $n = new N(948);
     *     $c = new C($n);
     *     echo $c; //'δ'
     *
     *     // XML entity way
     *     $c = new C('&eacute;');
     *     echo $c; // 'é'
     *
     *     // direct way
     *     $c = new C('z');
     *     echo $c; // 'z'
     *
     * @param mixed $char A string-like or `\Malenki\Bah\N` object 
     * @throws \InvalidArgumentException If given Bah Number is not into the valid UTF-8 range.
     * @throws \InvalidArgumentException If given HTML entity is not valid.
     * @throws \InvalidArgumentException If given char is not valid UTF-8 char.
     */
    public function __construct($char = '')
    {
        if ($char instanceof N) {

            if($char->negative || $char->gt(0x10FFFF)){
                throw new \InvalidArgumentException(
                    'This character is not a valid UTF-8 code point!'
                );
            }

            if($char->gte(0xD800) && $char->lte(0xDFFF)){
                $this->bool_is_surrogate = true;
            }
            // Clean way found here: http://ftzdomino.blogspot.fr/2009/06/php-utf-8-chr-and-ord-equivalents.html
            $char = mb_convert_encoding(
                pack('n', $char->int),
                self::ENCODING,
                'UTF-16BE'
            );
        }

        if (mb_strlen($char, self::ENCODING) > 1) {
            // tests whether use string for XML entity
            if (preg_match('/^&.+;$/', $char)) {
                $char = str_replace('&apos;', "'", $char); //workaround for php > 5.4
                $char = html_entity_decode($char, ENT_COMPAT, self::ENCODING);
            } else {
                throw new \InvalidArgumentException('Invalid character!');
            }
        }

        if(!mb_check_encoding($char, self::ENCODING)){
            throw new \InvalidArgumentException('This character is not a valid UTF-8 character!');
        }

        $this->value = $char;
    }

    public function __get($name)
    {
        if ($name === 'bytes') {
            if (is_null($this->col_bytes)) {
                $i = 0;
                $a = array();

                while ($i < strlen($this)) {
                    $a[] = new N(ord($this->value{$i}));
                    $i++;
                }

                $this->col_bytes = new A($a);
            }

            return $this->col_bytes;
        }

        if($name === 'to_s'){
            return new S($this->value);
        }


        if($name === 'to_n'){
            if(!is_numeric($this->value)){
                throw new \RuntimeException(
                    'Cannot cast `\Malenki\Bah\C` object to `\Malenki\Bah\N` '
                    .'object if characters does not stand for integer.'
                );
            }

            return new N((integer) $this->value);
        }


        if (
            $name === 'string'
            ||
            $name === 'str'
            ||
            $name === 'integer'
            ||
            $name === 'int'
            ||
            $name === 'upper'
            ||
            $name === 'lower'
            ||
            $name === 'block'
            ||
            $name === 'trans'
            ||
            $name === 'unicode'
            ||
            $name === 'rtl'
            ||
            $name === 'ltr'
            ||
            $name === 'family'
        ) {
            $name = '_'.$name;

            return $this->$name();
        }

        if(
            $name === 'is_rtl'
            ||
            $name === 'right_to_left'
            ||
            $name === 'is_right_to_left'
        ){
            return $this->_rtl();
        }

        if(
            $name === 'is_ltr'
            ||
            $name === 'left_to_right'
            ||
            $name === 'is_left_to_right'
        ){
            return $this->_ltr();
        }
        
        if(preg_match('/^is_/', $name)){
            $m = '_is' . implode(
                array_map(
                    'ucfirst',
                    explode('_', preg_replace('/^is_/', '', $name))
                )
            );
            return $this->$m();
        }
        
        if(preg_match('/^has_/', $name)){
            $m = '_has' . implode(
                array_map(
                    'ucfirst',
                    explode('_', preg_replace('/^has_/', '', $name))
                )
            );
            return $this->$m();
        }


        return parent::__get($name);
    }

    /**
     * Casts current character to primitive string type.
     * 
     * Casts current character as simple string PHP primitive type.
     *
     * Example:
     *
     *     $c = new C('f');
     *     var_dump($c->string); // string(1)
     *
     * @see C::$string Magic getter way
     * @see C::_str() Alias
     * @return string
     */
    protected function _string()
    {
        return (string) $this->value;
    }


    /**
     * Casts current character to primitive string type (Alias).
     *
     * @see C::$str Magic getter way
     * @see C::_string() Original method
     * @return string
     */
    protected function _str()
    {
        return $this->_string();
    }

    /**
     * Casts current character to integer primitive type.
     *
     * If current character is digit form 0 to 9, then it can be casted to 
     * integer php primitive type.
     *
     * Example:
     *
     *     $c = new C('5');
     *     var_dump($c->integer); // int(5)
     * 
     * @see C::$integer Magic getter way
     * @see C::_int() Alias
     * @return integer
     * @throws \RuntimeException If current character is not numeric.
     */
    protected function _integer()
    {
        if(!is_numeric($this->value)){
            throw new \RuntimeException(
                'Cannot cast C object to primitive integer if characters does not stand for integer.'
            );
        }

        return (integer) $this->value;
    }


    /**
     * Casts current character to integer primitive type (Alias).
     *
     * @see C::$int Magic getter way
     * @see C::_integer() Original method
     * @return integer
     * @throws \RuntimeException If current character is not numeric.
     */
    protected function _int()
    {
        return $this->_integer();
    }

    /**
     * Transliterate current character.
     *
     * Current character is transliterated to `\Malenki\Bah\S` object.
     *
     * Example:
     *
     *     $c = new C('ç');
     *     echo $c->trans; // 'c'
     * 
     * Note: Returned object is not `\Malenki\Bah\C` object, but 
     * `\Malenki\Bah\S` object, because translierated character can give more 
     * than one new characters.
     *
     * @see C::$trans Magic getter way
     * @return S
     * @throws \RuntimeException If Intl PHP extension is not available
     * @throws \RuntimeException If Intl is available, but PHP version is less 
     * than 5.4.0. Transliterating feature is available since PHP 5.4.0.
     */
    protected function _trans()
    {
        if (!extension_loaded('intl')) {
            throw new \RuntimeException(
                'Missing Intl extension. This is required to use ' . __CLASS__ . '::trans'
            );
        }

        if(!function_exists('\transliterator_transliterate')){
            throw new \RuntimeException(
                'Intl extension does not provide transliterate feature '
                .'prior PHP 5.4.0!'
            );
        }


        $str = \transliterator_transliterate(
            "Any-Latin; NFD; [:Nonspacing Mark:] Remove; NFC;",
            $this->value
        );

        // S and no C, because can have more than One characters
        return new S($str);
    }

    /**
     * Lists all available encodings.
     * 
     * List all available encodings, as collection of `\Malenki\Bah\S` objects.
     *
     * @return A
     */
    public static function encodings()
    {
        return new A(
            array_map(
                function($v){
                    return new S($v);
                },
                mb_list_encodings()
            )
        );
    }

    /**
     * Transforms to uppercase.
     *
     * Returns new character object translated to uppercase, if any. If no 
     * uppercase exists, returns same character.
     *
     * Example:
     *
     *     $c = new C('œ');
     *     echo $c->upper; // 'Œ'
     *     $c = new C('9');
     *     echo $c->upper; // '9'
     * 
     * @see C::$upper Magic getter form C::$upper
     * @see C::$lower Its opposite: to lower case
     * @return C
     */
    protected function _upper()
    {
        return new self(mb_convert_case($this, MB_CASE_UPPER, C::ENCODING));
    }


    /**
     * Transforms to lowercase.
     *
     * Returns new character object translated to lowercase, if any. If no 
     * lowercase exists, returns same character.
     *
     * Example:
     *
     *     $c = new C('A');
     *     echo $c->lower; // 'a'
     *     $c = new C('9');
     *     echo $c->lower; // '9'
     * 
     * @see C::$lower Magic getter form C::$lower
     * @see C::$upper Its opposite: to upper case
     * @return C
     */
    protected function _lower()
    {
        return new self(mb_convert_case($this, MB_CASE_LOWER, C::ENCODING));
    }


    /**
     * Checks whether current character is a letter.
     * 
     * Checks if current character represents a letter, and only a letter.
     *
     * Example:
     *
     *     $c = new C('5');
     *     var_dump($c->is_letter); // false
     *     $c = new C('r');
     *     var_dump($c->is_letter); // true
     *
     * @see C::$is_letter Magic getter C::$is_letter
     * @return boolean
     */
    protected function _isLetter()
    {
        return (boolean) preg_match("/^\p{L}+$/ui", $this->value);
    }

    /**
     * Checks whether current character is a digit.
     * 
     * Checks if current character represents a digit, so, a value form 0 to 9.
     *
     * Example:
     *
     *     $c = new C('5');
     *     var_dump($c->is_digit); // true
     *     $c = new C('r');
     *     var_dump($c->is_digit); // false
     *
     * @see C::$is_digit Magic getter C::$is_digit
     * @return boolean
     */
    protected function _isDigit()
    {
        return is_numeric($this->value);
    }

    protected function _isControl()
    {
        return (boolean) preg_match("/^\p{Cc}+$/ui", $this->value);
    }

    protected function _isFormat()
    {
        if(defined('HHVM_VERSION') || PHP_OS === 'Darwin'){
            $int_code = $this->_unicode()->value;

            if($int_code == 0xAD){
                return true;
            } elseif(in_array($int_code, range(0x600, 0x604))){
                return true;
            } elseif(in_array($int_code, range(0x200B, 0x200F))){
                return true;
            } elseif(in_array($int_code, range(0x202A, 0x202E))){
                return true;
            } elseif(in_array($int_code, range(0x2060, 0x2064))){
                return true;
            } elseif(in_array($int_code, range(0x206A, 0x206F))){
                return true;
            }

            return false;
        }

        return (boolean) preg_match("/^\p{Cf}+$/ui", $this->value);
    }

    protected function _isUnassigned()
    {
        return (boolean) preg_match("/^\p{Cn}+$/ui", $this->value);
    }

    /**
     * Checks if character is for private use only.
     * 
     * Checks whether current character must be use only for private uses or 
     * not.
     *
     * Some UTF-8 characters can be used as you want, for example to have 
     * custom identicon. An example of private use is FontAwesome.
     *
     * Example:
     *
     *     $c = new C(new N(0xe62e));
     *     var_dump($c->is_private_use); // true
     *
     * @see C::$is_private_use Magic getter way
     * @return boolean
     */
    protected function _isPrivateUse()
    {
        return (boolean) preg_match("/^\p{Co}+$/ui", $this->value);
    }

    protected function _isSurrogate()
    {
        // Stupid PHP bug, \p{Cs} just doesn't work at all!
        //return (boolean) preg_match("/^\p{Cs}+$/ui", $this->value);
        return $this->bool_is_surrogate;
    }

    /**
     * @todo doc and unit test!
     */
    protected function _isMark()
    {
        return (boolean) preg_match("/^\p{M}+$/ui", $this->value);
    }

    /**
     * Tests if character is separator. 
     * 
     * Tests whether current character is a separator, like no-break-space, 
     * space, ideographic space and so on.
     *
     * Example:
     *
     *     $c = new C(' ');
     *     var_dump($c->is_separator); // true
     
     *     $c = new C("\t");
     *     var_dump($c->is_separator); // false
     *
     * @see C::$is_separator Magic getter way
     * @return boolean
     */
    protected function _isSeparator()
    {
        return (boolean) preg_match("/^\p{Z}+$/ui", $this->value);
    }

    /**
     * Tests if character is a punctuation.
     * 
     * Tests whether current character is punctuation or not, like comma, dot, 
     * parentethis and so on…
     *
     * Examples:
     *     
     *     $c = new C('.');
     *     var_dump($c->is_punctuation); // true
     *
     *     $c = new C(',');
     *     var_dump($c->is_punctuation); // true
     *
     *     $c = new C('…');
     *     var_dump($c->is_punctuation); // true
     *
     *     $c = new C('–');
     *     var_dump($c->is_punctuation); // true
     *
     *     $c = new C('。');
     *     var_dump($c->is_punctuation); // true
     *
     *     $c = new C('【');
     *     var_dump($c->is_punctuation); // true
     *
     *
     * @see C::$is_punctuation Magic getter way
     * @return boolean
     */
    protected function _isPunctuation()
    {
        return (boolean) preg_match("/^\p{P}+$/ui", $this->value);
    }

    /**
     * Tests if character is a symbol.
     *
     * Tests whether current character stands for a symbol.
     *
     * Example:
     *
     *     $euro = new C('€');
     *     $a = new C('a');
     *     var_dump($euro->is_symbol); // true
     *     var_dump($a->is_symbol); // false
     * 
     * @see C::$is_symbol Magic getter way.
     *
     * @return boolean
     */
    protected function _isSymbol()
    {
        return (boolean) preg_match("/^\p{S}+$/ui", $this->value);
    }

    /**
     * Tests whether current character is in lower case.
     *
     * This is runtime part of some magic getters to test whether current 
     * character is in lower case or not.
     *
     * Example:
     *
     *     $c = new C('a');
     *     var_dump($c->is_lower_case); // true
     *     var_dump($c->is_lower); // true
     *
     *     $c = new C('A');
     *     var_dump($c->is_lower_case); // false
     *     var_dump($c->is_lower); // false
     *
     * _Note_: Not to be confused with `C::lower`! This convert current 
     * character to another character into lower case.
     *
     * @see C::$is_lower_case Magic getter way
     * @see C::$is_lower Shorter magic getter way
     *
     * @return boolean
     */
    protected function _isLowerCase()
    {
        return mb_strtolower($this->value, C::ENCODING) === $this->value;
    }

    /**
     * Tests whether current character is in lower case (Alias).
     *
     * @see C::_isLowerCase() Original method
     * @return boolean
     */
    protected function _isLower()
    {
        return $this->_isLowerCase();
    }

    /**
     * Tests whether current character is in upper case.
     *
     * If current characters can be in lower or uppercase, then this tests if 
     * current character is upper case.
     *
     * Example:
     *
     *     $c = new C('À');
     *     var_dump($c->is_upper_case); // true
     *     var_dump($c->is_upper); // true
     *
     *     $c = new C('à');
     *     var_dump($c->is_upper_case); // false
     *     var_dump($c->is_upper); // false
     *
     * @see C::$is_upper_case Magic getter version `C::$is_upper_case`
     * @see C::isUpper() An alias
     *
     * @return boolean
     */
    protected function _isUpperCase()
    {
        return mb_strtoupper($this->value, C::ENCODING) === $this->value;
    }


    /**
     * Tests whether current character is in upper case (Alias).
     *
     * @see C::_isUpperCase() Original method
     * @see C::$is_upper An alias
     *
     * @return boolean
     */
    protected function _isUpper()
    {
        return $this->_isUpperCase();
    }


    /**
     * Tests if current character is from ASCII set or not. 
     * 
     * UTF-8 characters are compatible with ASCII characters. ASCII characters 
     * are defined into the range `[0x0, 0x7F]`.
     *
     * Example:
     *
     *     $c = new C('a');
     *     var_dump($c->is_ascii); // true
     *
     *     $c = new C('œ');
     *     var_dump($c->is_ascii); // false
     *
     *
     * @see C::$is_ascii The magic getter version `C::$is_ascii`
     * @return boolean
     */
    protected function _isAscii()
    {
        return (boolean) preg_match('/^([\x00-\x7F])*$/', $this->value);
    }


    /**
     * Tests if character has other cases or not.
     *
     * Tests whether the current character has other cases or not.
     *
     * Example:
     *
     *     $c = new C('a');
     *     var_dump($c->has_case); //  true
     *     $c = new C('!');
     *     var_dump($c->has_case); //  false
     *
     * @see C::$has_case magic getter way
     * @return boolean
     */
    protected function _hasCase()
    {
        return !($this->_isLowerCase() && $this->_isUpperCase());
    }

    /**
     * Gets unicode block’s name
     *
     * Returns unicode block’s name of current characters as a `\Malenki\Bah\S` 
     * object.
     *
     * Example:
     *
     *     $c = new C('a');
     *     $c->block; // 'Basic Latin'
     * 
     * This methods is the runtime part of magic getter `\Malenki\Bah\C::$block`
     *
     * @see C::$block The magic getter `C::$block`
     * @see C::$family To get all chars of current block 
     * @return S
     * @throws \Exception If current character is not into unicode block
     */
    protected function _block()
    {
        $int_code = $this->_unicode()->value;

        foreach (self::$arr_blocks as $b) {
            if ($int_code >= $b['start'] && $int_code <= $b['end']) {
                return new S($b['name']);
            }
        }

        throw new \Exception('Invalid character, it is unavailable in any unicode block.');
    }


    /**
     * For current character, gets all characters of its unicode block. 
     * 
     * All characters of the same block of current character are returned into 
     * an `\Malenki\Bah\A` collection of `\Malenki\Bah\C` objects.
     *
     * Example:
     *
     *     $c = new \Malenki\Bah\C(new N(0x2191));
     *     echo $c->family->join(',');
     *     // print '←,↑,→,↓,↔,↕,↖,↗,↘,↙,↚,↛,↜,↝,↞,↟,↠,↡,↢,↣,↤,↥,↦,↧,↨,↩,↪,↫,
     *     // ↬,↭,↮,↯,↰,↱,↲,↳,↴,↵,↶,↷,↸,↹,↺,↻,↼,↽,↾,↿,⇀,⇁,⇂,⇃,⇄,⇅,⇆,⇇,⇈,⇉,⇊,⇋,
     *     //⇌,⇍,⇎,⇏,⇐,⇑,⇒,⇓,⇔,⇕,⇖,⇗,⇘,⇙,⇚,⇛,⇜,⇝,⇞,⇟,⇠,⇡,⇢,⇣,⇤
     *
     * This methods is the runtime part of magic getter `\Malenki\Bah\C::$family`
     *
     * @see C::$family The magic getter `C::$family`
     * @see C::$block To get block’s name
     * @return A
     * @throws \Exception If current character is not into unicode block
     */
    protected function _family()
    {
        $arr = array();
        $int_code = $this->_unicode()->value;

        foreach (self::$arr_blocks as $b) {
            if ($int_code >= $b['start'] && $int_code <= $b['end']) {
                $arr = range($b['start'], $b['end']);

                foreach ($arr as $k => $v) {
                    $arr[$k] = new self(new N($v));
                }

                break;
            }
        }

        if (count($arr)) {
            return new A($arr);
        }

        throw new \Exception('Invalid character, it is unavailable in any unicode block.');
    }

    /**
     * Get unicode code point for the current character.
     *
     * Returns unicode code point of current character as `\Malenki\Bah\N` 
     * object, so you can deal with different numeric systems.
     *
     * This is runtime part of magic getter having same name.
     *
     * Example:
     *
     *     $c = new C('€');
     *     echo $c->unicode; // '8364'
     *     echo $c->unicode->bin; // '10000010101100'
     *     echo $c->unicode->oct; // '20254'
     *     echo $c->unicode->hex; // '20ac'
     *
     * _Note_: To get UTF8 bytes, use `C::$bytes` instead.
     *
     *     $c = new C('€');
     *     echo $c->bytes->join(', '); // 226, 130, 172
     *
     * @see C::$bytes To get bytes' values
     *
     * @return N
     */
    protected function _unicode()
    {
        $str_unicode = '';

        $this->__get('bytes');
        $this->col_bytes->rewind();
        $int_nb_bytes = count($this->col_bytes);

        foreach ($this->col_bytes as $k => $src) {

            if (is_string($src)) {
                $str_bin = (string) decbin(hexdec($src));
            } else {
                $str_bin = (string) decbin($src->value);
            }

            if ($int_nb_bytes > 1) {
                if ($k == 0) {
                    $str_unicode .= substr($str_bin, $int_nb_bytes + 1);
                } else {
                    $str_unicode .= substr($str_bin, 2);
                }
            } else {
                $str_unicode .= substr($str_bin, 0);
            }
        }

        return new N(bindec($str_unicode));
    }

    
    /**
     * Checks if current character is RTL.
     *
     * Checks whether current character is RTL, understand _Right To Left_, 
     * like you can see into Arabic or Hebrew language for examples (but other 
     * langauges exist too).
     * 
     * Example:
     *
     *     $c = new C('ش');
     *     var_dump($c->rtl); // true
     *     var_dump($c->is_rtl); // true
     *     var_dump($c->is_right_to_left); // true
     *     var_dump($c->right_to_left); // true
     *
     *     $c = new C('a');
     *     var_dump($c->rtl); // false
     *     var_dump($c->is_rtl); // false
     *     var_dump($c->is_right_to_left); // false
     *     var_dump($c->right_to_left); // false
     *
     * @see C::_ltr() Its opposite test
     * @see C::$rtl Main magic getter way to call it
     * @see C::$is_rtl Another magic getter way
     * @see C::$right_to_left Another magic getter way
     * @see C::$is_right_to_left Another magic getter way
     *
     * @return boolean
     */
    protected function _rtl()
    {
        $cp = $this->_unicode()->value;

        // generated from script into "bin/" directory
        if($cp == 0x5be) return true;
        elseif($cp == 0x5c0) return true;
        elseif($cp == 0x5c3) return true;
        elseif($cp == 0x5c6) return true;
        elseif(0x5d0 <= $cp && $cp <= 0x5ea) return true;
        elseif(0x5f0 <= $cp && $cp <= 0x5f4) return true;
        elseif($cp == 0x608) return true;
        elseif($cp == 0x60b) return true;
        elseif($cp == 0x60d) return true;
        elseif($cp == 0x61b) return true;
        elseif(0x61e <= $cp && $cp <= 0x64a) return true;
        elseif(0x66d <= $cp && $cp <= 0x66f) return true;
        elseif(0x671 <= $cp && $cp <= 0x6d5) return true;
        elseif(0x6e5 <= $cp && $cp <= 0x6e6) return true;
        elseif(0x6ee <= $cp && $cp <= 0x6ef) return true;
        elseif(0x6fa <= $cp && $cp <= 0x70d) return true;
        elseif($cp == 0x710) return true;
        elseif(0x712 <= $cp && $cp <= 0x72f) return true;
        elseif(0x74d <= $cp && $cp <= 0x7a5) return true;
        elseif($cp == 0x7b1) return true;
        elseif(0x7c0 <= $cp && $cp <= 0x7ea) return true;
        elseif(0x7f4 <= $cp && $cp <= 0x7f5) return true;
        elseif($cp == 0x7fa) return true;
        elseif(0x800 <= $cp && $cp <= 0x815) return true;
        elseif($cp == 0x81a) return true;
        elseif($cp == 0x824) return true;
        elseif($cp == 0x828) return true;
        elseif(0x830 <= $cp && $cp <= 0x83e) return true;
        elseif(0x840 <= $cp && $cp <= 0x858) return true;
        elseif($cp == 0x85e) return true;
        elseif($cp == 0x200f) return true;
        elseif($cp == 0xfb1d) return true;
        elseif(0xfb1f <= $cp && $cp <= 0xfb28) return true;
        elseif(0xfb2a <= $cp && $cp <= 0xfb36) return true;
        elseif(0xfb38 <= $cp && $cp <= 0xfb3c) return true;
        elseif($cp == 0xfb3e) return true;
        elseif(0xfb40 <= $cp && $cp <= 0xfb41) return true;
        elseif(0xfb43 <= $cp && $cp <= 0xfb44) return true;
        elseif(0xfb46 <= $cp && $cp <= 0xfbc1) return true;
        elseif(0xfbd3 <= $cp && $cp <= 0xfd3d) return true;
        elseif(0xfd50 <= $cp && $cp <= 0xfd8f) return true;
        elseif(0xfd92 <= $cp && $cp <= 0xfdc7) return true;
        elseif(0xfdf0 <= $cp && $cp <= 0xfdfc) return true;
        elseif(0xfe70 <= $cp && $cp <= 0xfe74) return true;
        elseif(0xfe76 <= $cp && $cp <= 0xfefc) return true;
        elseif(0x10800 <= $cp && $cp <= 0x10805) return true;
        elseif($cp == 0x10808) return true;
        elseif(0x1080a <= $cp && $cp <= 0x10835) return true;
        elseif(0x10837 <= $cp && $cp <= 0x10838) return true;
        elseif($cp == 0x1083c) return true;
        elseif(0x1083f <= $cp && $cp <= 0x10855) return true;
        elseif(0x10857 <= $cp && $cp <= 0x1085f) return true;
        elseif(0x10900 <= $cp && $cp <= 0x1091b) return true;
        elseif(0x10920 <= $cp && $cp <= 0x10939) return true;
        elseif($cp == 0x1093f) return true;
        elseif($cp == 0x10a00) return true;
        elseif(0x10a10 <= $cp && $cp <= 0x10a13) return true;
        elseif(0x10a15 <= $cp && $cp <= 0x10a17) return true;
        elseif(0x10a19 <= $cp && $cp <= 0x10a33) return true;
        elseif(0x10a40 <= $cp && $cp <= 0x10a47) return true;
        elseif(0x10a50 <= $cp && $cp <= 0x10a58) return true;
        elseif(0x10a60 <= $cp && $cp <= 0x10a7f) return true;
        elseif(0x10b00 <= $cp && $cp <= 0x10b35) return true;
        elseif(0x10b40 <= $cp && $cp <= 0x10b55) return true;
        elseif(0x10b58 <= $cp && $cp <= 0x10b72) return true;
        elseif(0x10b78 <= $cp && $cp <= 0x10b7f) return true;
        elseif(0x10c00 <= $cp && $cp <= 0x10c48) return true;
        return false;
    }

    /**
     * Checks if current character is LTR.
     *
     * Checks whether current character is LTR, understand _Left To Right_, 
     * like you can see into English, French, Dutch and many others.
     *
     * This is the opposite of `\Malenki\Bah\C::_rtl()` method.
     *
     * This method is runtime par of some magic getters, these have the same 
     * name as RTL version, but with left in place of right and vice versa ;-)
     * 
     * Example:
     *
     *     $c = new C('ش');
     *     var_dump($c->ltr); // false
     *     var_dump($c->is_ltr); // false
     *     var_dump($c->left_to_right); // false
     *     var_dump($c->is_left_to_right); // false
     *
     *     $c = new C('a');
     *     var_dump($c->ltr); // true
     *     var_dump($c->is_ltr); // true
     *     var_dump($c->left_to_right); // true
     *     var_dump($c->is_left_to_right); // true
     * 
     * @see C::_rtl() Its opposite test
     * @see C::$ltr Main magic getter way to call it
     * @see C::$is_ltr Another magic getter way
     * @see C::$left_to_right Another magic getter way
     * @see C::$is_left_to_right Another magic getter way
     *
     * @return boolean
     */
    protected function _ltr()
    {
        return !$this->_rtl();
    }




    /**
     * Converts character as string into string context. 
     * 
     * This return internal value of the character, as a string, while it is 
     * used into  string context.
     *
     * Example:
     *
     *     $c = new C('a');
     *     echo $c; // 'a'
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->value;
    }
}

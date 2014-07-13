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
 * @package Malenki\Bah
 * @license MIT
 * @property-read Malenki\Bah\A $bytes A collection of Malenki\Bah\N objects
 *
 * @todo http://en.wikipedia.org/wiki/Mapping_of_Unicode_characters
 * @todo http://en.wikipedia.org/wiki/Basic_Multilingual_Plane#Basic_Multilingual_Plane
 * @todo http://www.unicode.org/roadmaps/
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

    protected $bytes = null;

    protected $bool_is_surrogate = false; // due to PHP issue about \p{Cs}…

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
        if ($name == 'bytes') {
            if (is_null($this->bytes)) {
                $i = 0;
                $a = new A();

                while ($i < strlen($this)) {
                    $a->add(new N(ord($this->value{$i})));
                    $i++;
                }

                $this->bytes = $a;
            }

            return $this->bytes;
        }

        if($name == 'to_s'){
            return new S($this->value);
        }


        if($name == 'to_n'){
            if(!is_numeric($this->value)){
                throw new \RuntimeException(
                    'Cannot cast C object to N object if characters does not stand for integer.'
                );
            }

            return new N((integer) $this->value);
        }


        if (in_array($name, array('string', 'str', 'integer', 'int', 'upper', 'lower', 'block', 'trans', 'unicode', 'rtl', 'ltr', 'family'))) {
            $name = '_'.$name;

            return $this->$name();
        }

        if($name == 'is_rtl' || $name == 'right_to_left' || $name == 'is_right_to_left'){
            return $this->_rtl();
        }

        if($name == 'is_ltr' || $name == 'left_to_right' || $name == 'is_left_to_right'){
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

    protected function _string()
    {
        return (string) $this->value;
    }

    protected function _str()
    {
        return $this->_string();
    }

    protected function _integer()
    {
        if(!is_numeric($this->value)){
            throw new \RuntimeException(
                'Cannot cast C object to primitive integer if characters does not stand for integer.'
            );
        }

        return (integer) $this->value;
    }

    protected function _int()
    {
        return $this->_integer();
    }

    protected function _trans()
    {
        if (!extension_loaded('intl')) {
            throw new \RuntimeException('Missing Intl extension. This is required to use ' . __CLASS__ . '::trans');
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

    protected function _upper()
    {
        return new self(mb_convert_case($this, MB_CASE_UPPER, C::ENCODING));
        // return new self(mb_strtoupper($this, c::ENCODING));
    }

    protected function _lower()
    {
        return new self(mb_convert_case($this, MB_CASE_LOWER, C::ENCODING));
        //return new self(mb_strtolower($this, c::ENCODING));
    }

    protected function _isLetter()
    {
        return (boolean) preg_match("/^\p{L}+$/ui", $this->value);
    }

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
        return (boolean) preg_match("/^\p{Cf}+$/ui", $this->value);
    }

    protected function _isUnassigned()
    {
        return (boolean) preg_match("/^\p{Cn}+$/ui", $this->value);
    }

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

    protected function _isMark()
    {
        return (boolean) preg_match("/^\p{M}+$/ui", $this->value);
    }

    protected function _isSeparator()
    {
        return (boolean) preg_match("/^\p{Z}+$/ui", $this->value);
    }

    protected function _isPunctuation()
    {
        return (boolean) preg_match("/^\p{P}+$/ui", $this->value);
    }

    protected function _isSymbol()
    {
        return (boolean) preg_match("/^\p{S}+$/ui", $this->value);
    }

    /**
     * Tests whether current character is in lower case.
     *
     * @return boolean
     */
    protected function _isLowerCase()
    {
        return mb_strtolower($this->value, C::ENCODING) === $this->value;
    }

    /**
     * Tests whether current character is in upper case.
     *
     * @return boolean
     */
    protected function _isUpperCase()
    {
        return mb_strtoupper($this->value, C::ENCODING) === $this->value;
    }


    protected function _isAscii()
    {
        return (boolean) preg_match('/^([\x00-\x7F])*$/', $this->value);
    }


    /**
     * Tests whether the current character has other cases or not.
     *
     * @return boolean
     */
    protected function _hasCase()
    {
        return !($this->_isLowerCase() && $this->_isUpperCase());
    }

    protected function _block()
    {
        $int_code = $this->_unicode()->value;
        $out = null;

        foreach (self::$arr_blocks as $b) {
            if ($int_code >= $b['start'] && $int_code <= $b['end']) {
                $out = new S($b['name']);
                break;
            }
        }

        if ($out) {
            return $out;
        }

        throw new \Exception('Invalid character, it is unavailable in any unicode block.');
    }


    protected function _family()
    {
        $arr = array();
        $int_code = $this->_unicode()->value;

        foreach (self::$arr_blocks as $b) {
            if ($int_code >= $b['start'] && $int_code <= $b['end']) {
                $arr = range($b['start'], $b['end']);

                foreach ($arr as $k => $v) {
                    if (version_compare(PHP_VERSION, '5.4.0', '>=')) {
                        $arr[$k] = new self(html_entity_decode('&#'.$v.';', ENT_XML1, 'UTF-8'));
                    } else {
                        $arr[$k] = new self(html_entity_decode('&#'.$v.';', ENT_COMPAT | ENT_HTML401, 'UTF-8'));
                    }
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
     * @return N
     */
    protected function _unicode()
    {
        $str_unicode = '';

        $this->__get('bytes');
        $this->bytes->rewind();
        foreach ($this->bytes as $k => $src) {

            if (is_string($src)) {
                $str_bin = (string) decbin(hexdec($src));
            } else {
                $str_bin = (string) decbin($src->value);
            }

            if (count($this->bytes) > 1) {
                if ($k == 0) {
                    $str_unicode .= substr($str_bin, count($this->bytes) + 1);
                } else {
                    $str_unicode .= substr($str_bin, 2);
                }
            } else {
                $str_unicode .= substr($str_bin, 0);
            }
        }

        return new N(bindec($str_unicode));
    }

    
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

    protected function _ltr()
    {
        return !$this->_rtl();
    }

    public function __toString()
    {
        return (string) $this->value;
    }
}

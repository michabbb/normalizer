<?php

//
// NormalizerTest - PHP Unit Testing
//

use Ejz\Normalizer;

class NormalizerTest extends PHPUnit_Framework_TestCase {
    public function testNormalizerEn() {
        $str = "Hello, world!";
        $this -> assertEquals(Normalizer::go($str, 'en'), "hello world");
        //
        $str = " \t Hello, world! 123 \n ";
        $this -> assertEquals(Normalizer::go($str, 'en'), "hello world 123");
    }
    public function testNormalizerRu() {
        $str = "Привет, мир!";
        $this -> assertEquals(Normalizer::go($str, 'ru'), "привет мир");
        //
        $str = " \t Привет, мир! 123 world \n ";
        $this -> assertEquals(Normalizer::go($str, 'ru'), "привет мир 123");
        $this -> assertEquals(Normalizer::go($str, 'ruen'), "привет мир 123 world");
        $this -> assertEquals(Normalizer::go($str, 'enru'), "привет мир 123 world");
        $this -> assertEquals(Normalizer::go($str, 'enru,hyphen'), "привет-мир-123-world");
    }
    public function testNormalizerTrim() {
        $str = " \t \n Привет, мир! \t \n ";
        $this -> assertEquals(Normalizer::go($str, array('trim')), "Привет, мир!");
    }
    public function testNormalizerWhiteSpace() {
        $str = " \t \n Привет \t \n мир! \t \n ";
        $this -> assertEquals(Normalizer::go($str, array('whitespace')), "Привет мир!");
    }
    public function testNormalizerLatin() {
        $str = "привет мир";
        $this -> assertEquals(Normalizer::go($str, array('latinru')), "privet mir");
        //
        $str = "щука ямка хрен";
        $this -> assertEquals(Normalizer::go($str, array('latinru')), "shchuka iamka khren");
        //
        $str = "Màl Śir";
        $this -> assertEquals(Normalizer::go($str, array('latin')), "Mal Sir");
    }
}

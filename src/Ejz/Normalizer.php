<?php

namespace Ejz;

class Normalizer {
    public static function go($str, $chain = array()) {
        if(is_string($chain)) $chain = explode(',', $chain);
        foreach($chain as $_)
            if(is_callable($_ = array(get_class(), "go{$_}")))
                $str = call_user_func($_, $str);
            else trigger_error('INVALID CHAIN', E_USER_WARNING);
        return $str;
    }
    public static function goEn($str) {
        $str = strtolower($str);
        $str = preg_replace("|[^a-z0-9]|", ' ', $str);
        $str = preg_replace('|\s+|', ' ', $str);
        $str = trim($str);
        return $str;
    }
    private static function privateRu($str, $en) {
        $str = mb_strtolower($str, "utf8");
        $table = array("ё" => "е");
        $str = strtr($str, $table);
        if($en) $regex = "|[^a-z0-9а-я]|u";
        else $regex = "|[^0-9а-я]|u";
        $str = preg_replace($regex, ' ', $str);
        $str = preg_replace('|\s+|', ' ', $str);
        $str = trim($str);
        return $str;
    }
    public static function goRu($str) {
        return self::privateRu($str, false);
    }
    public static function goEnRu($str) {
        return self::privateRu($str, true);
    }
    public static function goRuEn($str) {
        return self::privateRu($str, true);
    }
    public static function goHyphen($str) {
        $str = str_replace(' ', '-', $str);
        return $str;
    }
    public static function goTrim($str) {
        $bom = pack('H*','EFBBBF');
        $str = preg_replace("~^\s*\x{00a0}~siu", ' ', $str);
        $str = preg_replace("~\x{00a0}\s*$~siu", ' ', $str);
        $str = preg_replace("/^({$bom})+/", '', $str);
        $str = trim($str);
        return $str;
    }
    public static function goWhiteSpace($str) {
        $bom = pack('H*','EFBBBF');
        $str = preg_replace("~\x{00a0}~siu", ' ', $str);
        $str = preg_replace("/^({$bom})+/", '', $str);
        $str = preg_replace('|\s+|', ' ', $str);
        $str = trim($str);
        return $str;
    }
    public static function goLatinRu($str) {
        static $table = array(
            "А" => "A", "а" => "a",
            "Б" => "B", "б" => "b",
            "В" => "V", "в" => "v",  
            "Г" => "G", "г" => "g",
            "Д" => "D", "д" => "d",
            "Е" => "E", "е" => "e",
            "Ё" => "E", "ё" => "e",
            "Ж" => "Zh", "ж" => "zh",
            "З" => "Z", "з" => "z",
            "И" => "I", "и" => "i",
            "Й" => "I", "й" => "i",
            "К" => "K", "к" => "k",
            "Л" => "L", "л" => "l",
            "М" => "M", "м" => "m",
            "Н" => "N", "н" => "n",
            "О" => "O", "о" => "o",
            "П" => "P", "п" => "p",
            "Р" => "R", "р" => "r",
            "С" => "S", "с" => "s",
            "Т" => "T", "т" => "t",
            "У" => "U", "у" => "u",
            "Ф" => "F", "ф" => "f",
            "Х" => "Kh", "х" => "kh",
            "Ц" => "Tc", "ц" => "tc",
            "Ч" => "Ch", "ч" => "ch",
            "Ш" => "Sh", "ш" => "sh",
            "Щ" => "Shch", "щ" => "shch",
            "Ъ" => "", "ъ" => "",
            "Ы" => "Y", "ы" => "y",
            "Ь" => "", "ь" => "",
            "Э" => "E", "э" => "e",
            "Ю" => "Iu", "ю" => "iu",
            "Я" => "Ia", "я" => "ia",
            // украинский
            'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
            'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',
        );
        return strtr($str, $table);
    }
    public static function goLatin($str) {
        static $table = array(
            '`' => "'",
            'İ' => 'I',
            '¡' => '!',
            '¿' => '?',
            'ß' => 'ss',
            'ẞ' => 'SS',
            'À' => 'A',
            'à' => 'a',
            'Á' => 'A',
            'á' => 'a',
            'Â' => 'A',
            'â' => 'a',
            'Ã' => 'A',
            'ã' => 'a',
            'Ä' => 'A',
            'ä' => 'a',
            'Ä' => 'Ae',
            'ä' => 'ae',
            'Å' => 'A',
            'å' => 'a',
            'Æ' => 'A',
            'æ' => 'a',
            'Æ' => 'AE',
            'æ' => 'ae',
            'ç' => 'c',
            'Ç' => 'C',
            'È' => 'E',
            'è' => 'e',
            'É' => 'E',
            'é' => 'e',
            'Ê' => 'E',
            'ê' => 'e',
            'Ë' => 'E',
            'ë' => 'e',
            'Ì' => 'I',
            'ì' => 'i',
            'Í' => 'I',
            'í' => 'i',
            'Î' => 'I',
            'î' => 'i',
            'Ï' => 'I',
            'ï' => 'i',
            'Ð' => 'D',
            'ð' => 'd',
            'ð' => 'o',
            'Ñ' => 'N',
            'ñ' => 'n',
            'Ò' => 'O',
            'ò' => 'o',
            'Ó' => 'O',
            'ó' => 'o',
            'Ô' => 'O',
            'ô' => 'o',
            'Õ' => 'O',
            'õ' => 'o',
            'ö' => 'o',
            'Ö' => 'O',
            'Ö' => 'Oe',
            'ö' => 'oe',
            'Ø' => 'O',
            'ø' => 'o',
            'Ù' => 'U',
            'ù' => 'u',
            'Ú' => 'U',
            'ú' => 'u',
            'Û' => 'U',
            'û' => 'u',
            'Ü' => 'U',
            'ü' => 'u',
            'Ü' => 'Ue',
            'ü' => 'ue',
            'Ý' => 'Y',
            'ý' => 'y',
            'Þ' => 'B',
            'þ' => 'b',
            'Þ' => 'TH',
            'þ' => 'th',
            'ÿ' => 'y',
            'Ÿ' => 'Y',
            'ā' => 'a',
            'Ā' => 'A',
            'Ă' => 'A',
            'ă' => 'a',
            'ą' => 'a',
            'Ą' => 'A',
            'ć' => 'c',
            'Ć' => 'C',
            'Ĉ' => 'C',
            'ĉ' => 'c',
            'Ċ' => 'C',
            'ċ' => 'c',
            'č' => 'c',
            'Č' => 'C',
            'ď' => 'd',
            'Ď' => 'D',
            'Đ' => 'D',
            'đ' => 'd',
            'đ' => 'dj',
            'Đ' => 'Dj',
            'ē' => 'e',
            'Ē' => 'E',
            'Ĕ' => 'E',
            'ĕ' => 'e',
            'ė' => 'e',
            'Ė' => 'E',
            'ę' => 'e',
            'Ę' => 'e',
            'Ę' => 'E',
            'ě' => 'e',
            'Ě' => 'E',
            'Ĝ' => 'G',
            'ĝ' => 'g',
            'ğ' => 'g',
            'Ğ' => 'G',
            'Ġ' => 'G',
            'ġ' => 'g',
            'ģ' => 'g',
            'Ģ' => 'G',
            'Ĥ' => 'H',
            'ĥ' => 'h',
            'Ħ' => 'H',
            'ħ' => 'h',
            'Ĩ' => 'I',
            'ĩ' => 'i',
            'ī' => 'i',
            'Ī' => 'i',
            'Ī' => 'I',
            'Ĭ' => 'I',
            'ĭ' => 'i',
            'į' => 'i',
            'Į' => 'I',
            'ı' => 'i',
            'Ĵ' => 'J',
            'ĵ' => 'j',
            'ķ' => 'k',
            'Ķ' => 'k',
            'Ķ' => 'K',
            'ĸ' => 'k',
            'Ĺ' => 'L',
            'ĺ' => 'l',
            'ļ' => 'l',
            'Ļ' => 'L',
            'Ľ' => 'L',
            'ľ' => 'l',
            'Ŀ' => 'L',
            'ŀ' => 'l',
            'ł' => 'l',
            'Ł' => 'L',
            'ń' => 'n',
            'Ń' => 'N',
            'ņ' => 'n',
            'Ņ' => 'N',
            'ň' => 'n',
            'Ň' => 'N',
            'ŉ' => 'n',
            'Ŋ' => 'N',
            'ŋ' => 'n',
            'Ō' => 'O',
            'ō' => 'o',
            'Ŏ' => 'O',
            'ŏ' => 'o',
            'Ő' => 'O',
            'ő' => 'o',
            'Œ' => 'O',
            'œ' => 'o',
            'Ŕ' => 'R',
            'ŕ' => 'r',
            'ŗ' => 'r',
            'ř' => 'r',
            'Ř' => 'R',
            'ś' => 's',
            'Ś' => 'S',
            'Ŝ' => 'S',
            'ŝ' => 's',
            'ş' => 's',
            'Ş' => 'S',
            'š' => 's',
            'Š' => 'S',
            'Ţ' => 'T',
            'ţ' => 't',
            'ť' => 't',
            'Ť' => 'T',
            'Ŧ' => 'T',
            'ŧ' => 't',
            'Ũ' => 'U',
            'ũ' => 'u',
            'ū' => 'u',
            'Ū' => 'u',
            'Ū' => 'U',
            'Ŭ' => 'U',
            'ŭ' => 'u',
            'ů' => 'u',
            'Ů' => 'U',
            'Ű' => 'U',
            'ű' => 'u',
            'ų' => 'u',
            'Ų' => 'U',
            'Ŵ' => 'W',
            'ŵ' => 'w',
            'Ŷ' => 'Y',
            'ŷ' => 'y',
            'ź' => 'z',
            'Ź' => 'Z',
            'ż' => 'z',
            'Ż' => 'Z',
            'ž' => 'z',
            'Ž' => 'Z',
            'Ơ' => 'O',
            'ơ' => 'o',
            'Ư' => 'U',
            'ư' => 'u',
            'Ǽ' => 'A',
            'ǽ' => 'a',
            'Ș' => 'S',
            'ș' => 's',
            'Ț' => 'T',
            'ț' => 't',
            'ə' => 'e',
            'Ə' => 'E',
            'ΐ' => 'i',
            'ά' => 'a',
            'Ά' => 'A',
            'έ' => 'e',
            'Έ' => 'E',
            'ή' => 'h',
            'Ή' => 'H',
            'ί' => 'i',
            'Ί' => 'I',
            'ΰ' => 'y',
            'α' => 'a',
            'Α' => 'A',
            'β' => 'b',
            'Β' => 'B',
            'γ' => 'g',
            'Γ' => 'G',
            'δ' => 'd',
            'Δ' => 'D',
            'ε' => 'e',
            'Ε' => 'E',
            'ζ' => 'z',
            'Ζ' => 'Z',
            'η' => 'h',
            'Η' => 'H',
            'θ' => '8',
            'Θ' => '8',
            'ι' => 'i',
            'Ι' => 'I',
            'κ' => 'k',
            'Κ' => 'K',
            'λ' => 'l',
            'Λ' => 'L',
            'μ' => 'm',
            'Μ' => 'M',
            'ν' => 'n',
            'Ν' => 'N',
            'ξ' => '3',
            'Ξ' => '3',
            'ο' => 'o',
            'Ο' => 'O',
            'π' => 'p',
            'Π' => 'P',
            'ρ' => 'r',
            'Ρ' => 'R',
            'ς' => 's',
            'σ' => 's',
            'Σ' => 'S',
            'τ' => 't',
            'Τ' => 'T',
            'υ' => 'y',
            'Υ' => 'Y',
            'φ' => 'f',
            'Φ' => 'F',
            'χ' => 'x',
            'Χ' => 'X',
            'ψ' => 'ps',
            'Ψ' => 'PS',
            'ω' => 'w',
            'Ω' => 'W',
            'ϊ' => 'i',
            'Ϊ' => 'I',
            'ϋ' => 'y',
            'Ϋ' => 'Y',
            'ό' => 'o',
            'Ό' => 'O',
            'ύ' => 'y',
            'Ύ' => 'Y',
            'ώ' => 'w',
            'Ώ' => 'W',
            'ђ' => 'dj',
            'Ђ' => 'Dj',
            'ј' => 'j',
            'Ј' => 'j',
            'љ' => 'lj',
            'Љ' => 'Lj',
            'њ' => 'nj',
            'Њ' => 'Nj',
            'ћ' => 'c',
            'Ћ' => 'C',
            'џ' => 'dz',
            'Џ' => 'Dz',
            'أ' => 'a',
            'ب' => 'b',
            'ت' => 't',
            'ث' => 'th',
            'ج' => 'g',
            'ح' => 'h',
            'خ' => 'kh',
            'د' => 'd',
            'ذ' => 'th',
            'ر' => 'r',
            'ز' => 'z',
            'س' => 's',
            'ش' => 'sh',
            'ص' => 's',
            'ض' => 'd',
            'ط' => 't',
            'ظ' => 'th',
            'ع' => 'aa',
            'غ' => 'gh',
            'ف' => 'f',
            'ق' => 'k',
            'ك' => 'k',
            'ل' => 'l',
            'م' => 'm',
            'ن' => 'n',
            'ه' => 'h',
            'و' => 'o',
            'ي' => 'y',
            'Ẁ' => 'W',
            'ẁ' => 'w',
            'Ẃ' => 'W',
            'ẃ' => 'w',
            'Ẅ' => 'W',
            'ẅ' => 'w',
            'Ạ' => 'A',
            'ạ' => 'a',
            'Ả' => 'A',
            'ả' => 'a',
            'Ấ' => 'A',
            'ấ' => 'a',
            'Ầ' => 'A',
            'ầ' => 'a',
            'Ẩ' => 'A',
            'ẩ' => 'a',
            'Ẫ' => 'A',
            'ẫ' => 'a',
            'Ậ' => 'A',
            'ậ' => 'a',
            'Ắ' => 'A',
            'ắ' => 'a',
            'Ằ' => 'A',
            'ằ' => 'a',
            'Ẳ' => 'A',
            'ẳ' => 'a',
            'Ẵ' => 'A',
            'ẵ' => 'a',
            'Ặ' => 'A',
            'ặ' => 'a',
            'Ẹ' => 'E',
            'ẹ' => 'e',
            'Ẻ' => 'E',
            'ẻ' => 'e',
            'Ẽ' => 'E',
            'ẽ' => 'e',
            'Ế' => 'E',
            'ế' => 'e',
            'Ề' => 'E',
            'ề' => 'e',
            'Ể' => 'E',
            'ể' => 'e',
            'Ễ' => 'E',
            'ễ' => 'e',
            'Ệ' => 'E',
            'ệ' => 'e',
            'Ỉ' => 'I',
            'ỉ' => 'i',
            'Ị' => 'I',
            'ị' => 'i',
            'Ọ' => 'O',
            'ọ' => 'o',
            'Ỏ' => 'O',
            'ỏ' => 'o',
            'Ố' => 'O',
            'ố' => 'o',
            'Ồ' => 'O',
            'ồ' => 'o',
            'Ổ' => 'O',
            'ổ' => 'o',
            'Ỗ' => 'O',
            'ỗ' => 'o',
            'Ộ' => 'O',
            'ộ' => 'o',
            'Ớ' => 'O',
            'ớ' => 'o',
            'Ờ' => 'O',
            'ờ' => 'o',
            'Ở' => 'O',
            'ở' => 'o',
            'Ỡ' => 'O',
            'ỡ' => 'o',
            'Ợ' => 'O',
            'ợ' => 'o',
            'Ụ' => 'U',
            'ụ' => 'u',
            'Ủ' => 'U',
            'ủ' => 'u',
            'Ứ' => 'U',
            'ứ' => 'u',
            'Ừ' => 'U',
            'ừ' => 'u',
            'Ử' => 'U',
            'ử' => 'u',
            'Ữ' => 'U',
            'ữ' => 'u',
            'Ự' => 'U',
            'ự' => 'u',
            'Ỳ' => 'Y',
            'ỳ' => 'y',
            'Ỵ' => 'Y',
            'ỵ' => 'y',
            'Ỷ' => 'Y',
            'ỷ' => 'y',
            'Ỹ' => 'Y',
            'ỹ' => 'y',
            '–' => '-',
            '—' => '-',
            '‘' => "'",
            '’' => "'",
            '“' => '"',
            '”' => '"',
            '•' => '-',
            '…' => '...',
        );
        return strtr($str, $table);
    }
}
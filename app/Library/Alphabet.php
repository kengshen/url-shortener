<?php

namespace App\Library;

class Alphabet
{
    public static $alphabets = 'bcdfghjklmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ123456789';

    public static function encode($num)
    {
        if ($num === 0) {
            return self::$alphabets[0];
        }

        $arr = [];
        $length = strlen(self::$alphabets);

        while ($num > 0) {
            array_push($arr, self::$alphabets[($num % $length)]);
            $num = (int)($num / $length);
        }

        // reverse the characters so when decode it starts from 51^0 to 51^n
        return implode(array_reverse($arr));
    }

    public static function decode($str)
    {
        $num = 0;
        $length = strlen(self::$alphabets);

        for ($i = 0; $i < strlen($str); $i++) {
            $num = ($num * $length) + strpos(self::$alphabets, $str[$i]);
        }

        return $num;
    }
}
<?php

namespace App\Utils;

use Random\RandomException;

class FakerVietnamese
{
    const FILE_PATH_FOLDER     = 'faker';
    const FOLDER_NAME         = 'name';
    const FILE_FIRST_NAME_1    = 'firstname_1.txt';
    const FILE_FIRST_NAME_2    = 'firstname_2.txt';
    const FILE_LAST_NAME       = 'lastname.txt';
    const FILE_MID_NAME        = 'midname.txt';
    const FOLDER_PHONE         = 'phone';
    const FILE_MOBILE_PHONE    = 'mobile.txt';
    const FILE_PHONE_CODE_CITY = 'code_cities.txt';
    const FILE_PHONE_FIX       = 'tele.txt';

    public function __construct() {}

    /*
    * read file
    */
    protected static function readFile($file_path, $permission = 'r') : array
    {
        $content_arrs = [];
        $file = fopen( public_path(self::FILE_PATH_FOLDER.'/'.$file_path), $permission);

        while ($line = fgets($file)) {
            $content_arrs[] = $line;
        }

        fclose($file);

        return  $content_arrs;
    }

    /**
     * @param array $items
     * @param int $num
     * @param bool $array
     * @param string $glue
     * @return string | array
     */
    public static function array_rand(array $items, int $num = 1, bool $array = false, string $glue = ',') : array | string
    {
        $return_value = false;
        if($num > 1) {
            for($i = 0; $i < $num; $i++) {
                $return_value[] = $items[array_rand($items)];
            }

            if($array) {
                return $return_value;
            }
            return implode($glue, $return_value);
        }
        return mb_convert_encoding(trim($items[array_rand($items)]), "UTF-8");
    }

    /**
     * @param int $word
     * @return string
     */
    public static function firstName(int $word = 1): string
    {
        $file_name = self::FILE_FIRST_NAME_1;
        if($word == 2) {
            $file_name = self::FILE_FIRST_NAME_2;
        }

        $items = self::readFile(self::FOLDER_NAME.'/'.$file_name);

        return self::array_rand($items);
    }

    /**
     * @return string
     */
    public static function midName(): string
    {
        $items = self::readFile(self::FOLDER_NAME.'/'.self::FILE_MID_NAME);
        return self::array_rand($items);
    }

    /**
     * @return string
     */
    public static function lastName() : string
    {
        $items = self::readFile(self::FOLDER_NAME.'/'.self::FILE_LAST_NAME);
        return self::array_rand($items);
    }

    /**
     * @param int $word
     * @return string
     */
    public static function fullName(int $word = 3) : string
    {
        $word_number = 3;
        if($word == 4) {
            $word_number = 4;
        }

        return self::lastname().' '.self::midname().' '.self::firstName($word_number - 2);
    }

    /**
     * rand() or mt_rand()
     * @return int
     */
    public static function int(): int
    {
        return mt_rand();
    }

    /**
     * @return int
     */
    public static function maxInt(): int
    {
        return mt_getrandmax();
    }

    /**
     * @param int $min
     * @param int $max
     * @return int
     */
    public static function numberBetween(int $min = 0, int $max = 100000): int
    {
        if($max >= $min)
            return mt_rand($min, $max);

        return $max;
    }

    /**
     * @param int $min
     * @param int $max
     * @param int $decimals
     * @return float
     */
    public static function float(int $min = 0, int $max = 100, int $decimals = 2) : float
    {
        $scale = pow(10, $decimals);

        return mt_rand($min * $scale, $max * $scale) / $scale;
    }

    /**
     * @param false $string
     * @return bool|string
     */
    public static function boolean(false $string = false): bool|string
    {
        $value = (bool)mt_rand(0,1);
        if($string){
            return $value ? 'true':'false';
        }
        return $value;
    }

    /**
     * @param string $symbol
     * @return string
     */
    public static function date(string $symbol = '/'): string
    {
        return self::day() . $symbol . self::month() . $symbol . self::year();
    }

    /**
     * @param int $min
     * @return int
     */
    public static function year(int $min = 1950) : int
    {
        $max = date("Y");
        if($min <= $max){
            return  mt_rand($min, $max);
        }
        return $max;
    }

    /**
     * @return int|string
     */
    public static function month(): int|string
    {
        $month = mt_rand(1, 12);
        if($month < 10)
            $month = '0'.$month;
        return $month;
    }

    /**
     * @return int|string
     */
    public static function day(): int|string
    {
        $day = mt_rand(1, 28);
        if($day < 10)
            $day = '0'.$day;
        return $day;
    }

    /**
     * @param int $length
     * @param string|null $prefix
     * @param string|null $postfix
     * @return string
     * @throws RandomException
     */
    public static function generateOrderNo(
        int  $length = 6,
        string $prefix = null,
        string $postfix = null): string
    {
        $token          = "";
        $codeAlphabet   = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet  .= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet  .= "0123456789";
        $max            = strlen($codeAlphabet);

        $length = ($length - (strlen($prefix) + strlen($postfix)));

        if($length > 0) {
            for ($i = 0; $i < $length; $i++) {
                $token .= $codeAlphabet[random_int(0, $max - 1)];
            }
        }

        return $prefix.$token.$postfix;
    }

    /**
     * @return string
     */
    public static function mobilePhone(): string
    {
        return self::prefixPhone(self::FILE_MOBILE_PHONE).self::postfixPhone();
    }

    /**
     * @param int $numbers
     * @return string
     */
    public static function fixedLineNumber(int $numbers = 12): string
    {
        return self::prefixPhone(self::FILE_PHONE_FIX).self::postfixPhone($numbers - 4);
    }

    /**
     * @param int $numbers
     * @return string
     */
    public static function cityPhone(int $numbers = 12): string
    {
        return self::prefixPhone(self::FILE_PHONE_CODE_CITY).self::postfixPhone($numbers - 4);
    }

    private static function prefixPhone($file_name): string
    {
        $items = self::readfile(self::FOLDER_PHONE.'/'.$file_name);
        return self::array_rand($items);
    }

    private static function postfixPhone($count = 7): string
    {
        $postfix = '';
        $numbers = '0123456789';
        for ($i = 0; $i < $count; $i++) {
            $postfix .= $numbers[mt_rand(0, $count - 1)];
        }

        return $postfix;
    }

    /*---END PHONE*/
}

<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class StringHelper
{
    /**
     * Slug
     *
     * @param string $str
     * @return string
     */
    public static function slug($str)
    {
        return Str::slug($str);
    }

    /**
     * Trim string space
     *
     * @param string $str
     * @return string
     */
    public static function trimSpace($str)
    {
        if (!$str || !is_string($str)) {
            return '';
        }

        return trim(preg_replace('!\s+!', ' ', $str));
    }

    /**
     * Unique Code
     *
     * @param $limit
     * @return false|string
     */
    public static function uniqueCode($limit)
    {
        return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
    }

    public static function createToken($length = 64)
    {
        return strtoupper(Str::random($length));
    }

    /**
     * Content break line and entity encode
     *
     * @param $str
     * @return string
     */
    public static function formatContent($str)
    {
        return nl2br(htmlentities($str));
    }

    /**
     * Convert money
     *
     * @param $value
     * @return string
     */
    public static function formatMoney($value)
    {
        return number_format($value, 0, '', ',');
    }
}

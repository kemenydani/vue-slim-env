<?php
/**
 * Created by PhpStorm.
 * User: DANI
 * Date: 2017. 09. 24.
 * Time: 10:29
 */

namespace core;


class Hash
{
    public static function make($string, $salt = '')
    {
        return hash('sha256', $string . $salt);
    }
    public static function salt($length)
    {
        return random_bytes($length);
    }
    public static function unique()
    {
        return self::make(uniqid());
    }
}
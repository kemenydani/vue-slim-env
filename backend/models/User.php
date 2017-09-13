<?php

namespace models;

use core\Model as Model;

class User extends Model
{
    public static $_UNIQUE = 'id';

    public static function auth()
    {

    }

    public static function login()
    {

    }

    public static function verify_password($password, $prediction)
    {
        //return password_verify($prediction, $password);
    }

}
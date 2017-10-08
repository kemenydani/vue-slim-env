<?php
namespace core;

use core\Session as Session;
use core\Cookie as Cookie;

use models\User as User;

class Auth
{
    /*
    const AUTHENTICABLES = [
        'User' => User::class,
        'Admin' => Admin::class
    ];

    public static function __callStatic($name, $arguments)
    {
        if(self::isAuthenticable($name))
        {
            self::auth(static::AUTHENTICABLES[$name], $arguments);
        }
    }
    */

    public static function user()
    {
        if(Session::exists('userId'))
        {
            return User::find(Session::get('userId'));
        }
        else if(Cookie::exists('user'))
        {
            $User = User::find(Cookie::get('user'), 'remember_token');

            if($User)
            {
                $User->login($User->getPassword(), true);
            }

            return $User;
        }
        return false;
    }

}

<?php
namespace core;

use core\Session as Session;
use core\Cookie as Cookie;
use models\User as User;

class Auth
{
    public static function user()
    {
        if(Session::exists('userId'))
        {
            return User::find(Session::get('userId'));
        }
        // If there is no session, maybe the user just entered the page and has an unexpired remember_token
        else if(Cookie::exists('user'))
        {
            $User = User::find(Cookie::get('user'), 'remember_token');
            /**
             * If we find the user who has this remember token, do the login process
             * The login process will create a session, so on the next auth() call we will have the session
             */
            if($User)
            {
                $User->login($User->getUsername(), $User->getPassword(), true);
            }
            // If there is no session and no cookie containing a remember_token, return false, user is unauthorized
            return $User;
        }
        return false;
    }

}
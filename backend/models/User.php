<?php

namespace models;

use core\Model as Model;
use core\Session as Session;
use core\Cookie as Cookie;
use core\Hash as Hash;

class User extends Model
{
    public static $_UNIQUE = 'id';

    public static function auth()
    {
        // If the session exists return the user having that id
        if(Session::exists('userId'))
        {
            return self::find(Session::get('userId'));
        }
        // If there is no session, maybe the user just entered the page and has an unexpired remember_token
        else if(Cookie::exists('user'))
        {
            $user = self::find(Cookie::get('user'), 'remember_token');
            /**
             * If we find the user who has this remember token, do the login process
             * The login process will create a session, so on the next auth() call we will have the session
             */
            if($user)
            {
                $user->login($user->getUsername(), $user->getPassword(), true);
            }
            // If there is no session and no cookie containing a remember_token, return false, user is unauthorized
            return $user;
        }
        return false;
    }

    public function logout()
    {
        Session::delete('userId');
        Cookie::delete('user');
    }

    public static function login($username, $password, $remember = false)
    {
        $user = self::find($username, 'username');

        if($user)
        {
            // TODO: do proper validation
            if($user->getPassword() === $password)
            {
                if($remember){

                    $remember_token = Hash::unique();

                    if(!$user->getRememberToken())
                    {
                        $user->setRememberToken($remember_token);
                        $user->save();
                    }
                    else
                    {
                        $remember_token = $user->getRememberToken();
                    }

                    Session::put('userId', $user->getId());
                    Cookie::put('user', $remember_token, 604800);
                }
                return true;
            }
        }
        return false;
    }

    public static function verify_password($password, $prediction)
    {
        //return password_verify($prediction, $password);
    }

}
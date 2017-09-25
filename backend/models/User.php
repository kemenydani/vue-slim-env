<?php

namespace models;

use core\Model as Model;
use core\Session as Session;
use core\Cookie as Cookie;
use core\Hash as Hash;

class User extends Model
{
    public static $_UNIQUE = 'id';

    public function logout()
    {
        Session::delete('userId');
        Cookie::delete('user');
    }

    public function signIn($password, $remember = false)
    {
        if(password_verify($password , $this->getPassword()))
        {
            if($remember){

                $remember_token = Hash::unique();

                if(!$this->getRememberToken())
                {
                    $this->setRememberToken($remember_token);
                    $this->save();
                }
                else
                {
                    $remember_token = $this->getRememberToken();
                }

                Session::put('userId', $this->getId());
                Cookie::put('user', $remember_token, 604800);
            }
            return $this;
        }
        return false;
    }
/*
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
*/
    public static function verify_password($password, $prediction)
    {
        //return password_verify($prediction, $password);
    }

}
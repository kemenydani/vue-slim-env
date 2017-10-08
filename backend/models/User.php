<?php

namespace models;

use core\Model as Model;
use core\Session as Session;
use core\Cookie as Cookie;
use core\Hash as Hash;

class User extends Model
{
    public function logout()
    {
        Session::delete('userId');
        Cookie::delete('user');
    }

    public function login($password, $remember = false)
    {
        if($password)
        {
            // TODO: do proper validation
            if($this->getPassword() === $password)
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
                    Cookie::put('user', $remember_token, 604800);
                }
                Session::put('userId', $this->getId());
                return true;
            }
        }
        return false;
    }

    public static function hasRole($role)
    {

    }

    public static function verify_password($password, $prediction)
    {
        //return password_verify($prediction, $password);
    }

}
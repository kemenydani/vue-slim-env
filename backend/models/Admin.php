<?php

namespace models;

use core\Model as Model;
use core\Session as Session;
use core\Cookie as Cookie;
use core\Hash as Hash;
use core\Auth as Auth;

class Admin extends Model
{
    public static $_UNIQUE = 'id';

    public function logout()
    {
        Session::delete('adminId');
        Cookie::delete('admin');
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

                    Cookie::put('admin', $remember_token, 604800);
                }
                Session::put('adminId', $this->getId());
                return true;
            }
        }
        return false;
    }

    public static function hasRole($role)
    {

    }

}
<?php

namespace models;



trait UserValidation
{

    protected static $_RULES = [
        'username' => 'required|min:5|max:30|unique'
    ];

    public static function getRulesFor($propName){
        if(self::hasRulesFor($propName)){
            return self::$_RULES[$propName];
        }
        return null;
    }

    public static function hasRulesFor($propName){
        return array_key_exists($propName, self::$_RULES) ? true : false;
    }
}
<?php

namespace core;

use core\DB as DB;

abstract class Model extends \ReflectionClass {

    const DEFAULT_UNIQUE_KEY = 'id';

    private $props = [];
    private $changeLog = [];

    public function __call($methodName, $arguments){

        $propName = strtolower(substr($methodName, 3));

        switch(substr($methodName, 0, 3)){
            case 'get' :
                return $this->getProperty($propName);
            case 'set' :
                $this->setProperty($propName, $arguments[0]);
                break;
        }
    }

    public function __construct()
    {
        parent::__construct(static::class);
    }
    //KEEP
    public function __set($propName, $propValue)
    {

        $this->setProperty($propName, $propValue);

        if(!$this->loggedAsChanged($propName))
        {
            $this->logAsChanged($propName);
        }
    }
    //KEEP
    public function __get($propName)
    {
        if($this->hasProperty($propName))
        {
            return $this->getProperty($propName);
        }
        return null;
    }
    //KEEP


    public function setProperty($name, $value){
        $this->props[$name] = $value;
    }
    //KEEP
    public function getProperty($propName)
    {
        if($this->hasProperty($propName))
        {
            return $this->props[$propName];
        }
        return null;
    }

    /*
    //KEEP
    public function loggedAsChanged($propName)
    {
        return in_array($propName, $this->changeLog);
    }
    //KEEP
    public function logAsChanged($propName){
        $this->changeLog[] = $propName;
    }
    //KEEP
    public function hasProperty($propName)
    {
        return array_key_exists($propName, $this->props) ? true : false;
    }
    //KEEP
    public function hasChanges()
    {
        return !empty($this->changeLog) ? true : false;
    }
    //KEEP
    public function clearChangeLog()
    {
        $this->changeLog = [];
    }
    //KEEP
    public function getChangedProps(){

        $changedProps = [];

        foreach($this->changeLog as $propName)
        {
            $changedProps[$propName] = $this->props[$propName];
        }
        return $changedProps;
    }
    //KEEP
    public function exitsInDB()
    {
        //TODO: check if id is not empty because it may happen that I will predefine all props without value, and this will fail
        return $this->getProperty(self::getUniqueKey()) ? true : false;
    }
    //KEEP
    public static function create($props = [])
    {

        $model = new static();

        foreach($props as $propName => $propValue)
        {
            $model->setProperty($propName, $propValue);
        }
        return $model;
    }
    //KEEP
    public function save()
    {
        if($this->hasChanges())
        {
            if($this->exitsInDB())
            {
                $db_model_id = DB::instance()->update(self::getTableName(), $this->getChangedProps(), self::getUniqueKey());
            }
            else
            {
                $db_model_id = DB::instance()->insert(self::getTableName(), $this->getChangedProps());
            }

            if($db_model_id)
            {
                if(!array_key_exists(self::getUniqueKey(), $this->props))
                {
                    $this->props[self::getUniqueKey()] = $model_id;
                }
                $this->clearChangeLog();
                return $db_model_id;
            }
            return false;
        }
    }


    public static function getTableName()
    {
        $ChildClass = (new \ReflectionClass(static::class));
        return $ChildClass->hasConstant('DB_TABLE') ? $ChildClass->getConstant('DB_TABLE') : strtolower($ChildClass->getShortName());
    }

    public static function getUniqueKey()
    {
        $ChildClass = (new \ReflectionClass(static::class));
        return $ChildClass->hasConstant('UNIQUE_KEY') ? $ChildClass->getConstant('UNIQUE_KEY') : self::DEFAULT_UNIQUE_KEY;
    }

    public static function find($id){

        $query = DB::instance()->query("SELECT * FROM " .self::getTableName()." WHERE ".self::getUniqueKey()." = ".$id." LIMIT 1");

        $model = new static();

        $result = $query->fetch(\PDO::FETCH_OBJ);

        if(!$result) return false;

        foreach($result as $property => $value){
            $model->$property = $value;
        }
        return $model;
    }

    public static function get($params = [], $limit = null, $order = []){

        $where_str = "";

        if(!empty($params)){

            $where_str .= "WHERE ";

            foreach($params as $param){
                $where_str .=  $param . " AND ";
            }
            $where_str = substr($where_str, 0, -4);
        }

        $order_str = "";

        if(!empty($order)){

            $order_str .= "ORDER BY ";

            foreach($order as $order_item){
                $order_str .=  $order_item . ", ";
            }
            $order_str = substr($order_str, 0, -2);
        }

        $limit_str = isset($limit) ? " LIMIT " . $limit : "";

        $sql = DB::instance()->query("SELECT * FROM ".static::DB_TABLE." {$where_str} {$order_str} {$limit_str}");

        if($limit == 1){
            $result = $sql->fetch(\PDO::FETCH_ASSOC);
        } else {
            $result = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $result;
    }
*/
}
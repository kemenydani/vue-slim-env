<?php

namespace core;

use core\DB as DB;

abstract class Model {

    const DEFAULT_UNIQUE_KEY = 'id';

    protected $props = [];
    protected $changeLog = [];

    public function __call($methodName, $arguments)
    {

        $propName = strtolower(substr($methodName, 3));

        $action = substr($methodName, 0, 3);

        if($action === 'get'){
            return $this->getProperty($propName);
        }
        if($action === 'set'){
            $this->setProperty($propName, $arguments[0]);
        }
    }

    public function setProperty($propName, $propValue, $silent = false)
    {
        $this->props[$propName] = $propValue;

        if(!$this->loggedAsChanged($propName) && !$silent)
        {
            $this->logAsChanged($propName);
        }
    }

    public function getProperty($propName)
    {
        if($this->hasProperty($propName))
        {
            return $this->props[$propName];
        }
        return null;
    }

    public function getProperties()
    {
        return isset($this->props) && !empty($this->props) ? $this->props : [];
    }

    public function loggedAsChanged($propName)
    {
        return in_array($propName, $this->changeLog);
    }

    public function logAsChanged($propName){
        $this->changeLog[] = $propName;
    }

    public function hasChanges()
    {
        return !empty($this->changeLog) ? true : false;
    }

    public function clearChangeLog()
    {
        $this->changeLog = [];
    }

    public function getChangedProps()
    {

        $changedProps = [];

        foreach($this->changeLog as $propName)
        {
            $changedProps[$propName] = $this->props[$propName];
        }
        return $changedProps;
    }

    public static function create($props = [])
    {

        $model = new static();

        foreach($props as $propName => $propValue)
        {
            $model->setProperty($propName, $propValue, true);
        }
        return $model;
    }

    public function hasProperty($propName)
    {
        return array_key_exists($propName, $this->props) ? true : false;
    }

    public static function all()
    {
        $rows = DB::instance()->all(self::getTableName());

        if(!$rows) return false;

        $models = [];

        foreach($rows as $row){
            $models[] = self::create($row);
        }
        return $models;
    }

    public static function toJSON($model){
        return json_encode($model->getProperties(), true);
    }

    public static function allJSON(){

        $models = self::all();

        $modelPropCollection = [];

        foreach($models as $model){
            $modelPropCollection[] = $model->getProperties();
        }

        return json_encode($modelPropCollection, true);
    }

    static function find($uniqueKey)
    {
        $result = DB::instance()->find(self::getTableName(), self::getUniqueKey(), $uniqueKey);

        if($result){
            return self::create($result);
        }
        return null;
    }

    public static function getTableName()
    {
        $ChildClass = (new \ReflectionClass(static::class));
        return $ChildClass->hasConstant('DB_TABLE') ? $ChildClass->getConstant('DB_TABLE') : strtolower($ChildClass->getShortName());
    }

    public static function getUniqueKey()
    {
        return static::$_UNIQUE ? static::$_UNIQUE : self::DEFAULT_UNIQUE_KEY;
        //$ChildClass = (new \ReflectionClass(static::class));
        //return $ChildClass->hasConstant('UNIQUE_KEY') ? $ChildClass->getConstant('UNIQUE_KEY') : self::DEFAULT_UNIQUE_KEY;
    }

/*

    //KEEP
    public function exitsInDB()
    {
        //TODO: check if id is not empty because it may happen that I will predefine all props without value, and this will fail
        return $this->getProperty(self::getUniqueKey()) ? true : false;
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
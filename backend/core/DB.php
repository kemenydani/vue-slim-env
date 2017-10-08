<?php

namespace Core;

class DB extends \PDO{
	
	public static $_instance;

	const _PREFIX_= '_xyz_';

	public static function instance(){
		if(self::$_instance === null){
            self::$_instance = new DB('mysql:host=localhost;dbname=engine-dev', 'root', '');
			self::$_instance->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
			self::$_instance->exec("set names utf8");
		}
		return self::$_instance;
	}

	public static function insert($table, $params){

	    $table = DB::_PREFIX_ . $table;

	    $params = (array)$params;

        $names = implode(',', array_keys($params));
        $questionMarks = join(",", array_pad([], count($params), "?"));

        $stmt = DB::instance()->prepare("INSERT INTO {$table} ({$names}) VALUES ({$questionMarks})");

        $current_bind = 1;

        foreach($params as $param => $value){
            $stmt->bindValue($current_bind, $value);
            $current_bind++;
        }

        if($stmt->execute()){
            return DB::instance()->lastInsertId();
        }

        return false;
    }

    public function all($table, $where = null){
        // TODO: where params build
        $table = DB::_PREFIX_ . $table;

        $query = DB::instance()->query("SELECT * FROM " . $table);

        $rows = $query->fetchAll(\PDO::FETCH_OBJ);

        if($rows){
            return $rows;
        }
        return false;
    }

    public function find($table, $column, $value)
    {
        $table = DB::_PREFIX_ . $table;

        $stmt = DB::instance()->prepare("SELECT * FROM {$table} WHERE ".$column." = ? LIMIT 1");
        $stmt->bindValue(1, $value);

        if($stmt->execute()){
            return $stmt->fetch(\PDO::FETCH_OBJ);
        }
        return false;
    }

    public static function update($table, $params, $key, $id){

        $table = DB::_PREFIX_ . $table;

        //var_dump($table, $params, $key); die();

        $params = (array)$params;
        //$id = $params[$key];
        //unset($params[$key]);

        $names = "";

        foreach($params as $param => $value){
            $names .= "`" . $param . "` = ?,";
        }

        $names = substr($names, 0, -1);

        $stmt = DB::instance()->prepare("UPDATE {$table} SET {$names} WHERE ".$key." = ? ");
        //TODO: update not executes
        $current_bind = 1;

        foreach($params as $param => $value){
            $stmt->bindValue($current_bind, $value);
            $current_bind++;
        }

        $stmt->bindValue($current_bind, $id);

        if($stmt->execute()){
            return $id;
        }
        return false;
    }

    public static function patch($table, $param, $key){

    }

}
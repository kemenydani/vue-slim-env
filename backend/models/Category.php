<?php

namespace models;

use \core\Model as Model;

class Category extends Model
{

    const DB_TABLE = "xyz_categories";

    public static function get_name($id){
        return Model::instance()->query("SELECT category_name FROM ".Category::DB_TABLE." WHERE category_id = {$id} LIMIT 1")->fetch(\PDO::FETCH_ASSOC)['category_name'];
    }

    public static function get_short($id){
        return Model::instance()->query("SELECT category_short FROM ".Category::DB_TABLE." WHERE category_id = {$id} LIMIT 1")->fetch(\PDO::FETCH_ASSOC)['category_short'];
    }
}
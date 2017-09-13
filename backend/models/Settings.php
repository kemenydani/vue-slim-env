<?php
/**
 * Created by PhpStorm.
 * User: DANI
 * Date: 2017. 09. 02.
 * Time: 18:03
 */

namespace models;

use \core\DB as DB;

class Settings
{

    public static function get_about(){
        $about = DB::instance()->query("SELECT * FROM xyz_about LIMIT 1");
        return $about->fetch(\PDO::FETCH_ASSOC);
    }

}
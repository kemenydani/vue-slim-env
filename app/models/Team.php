<?php

namespace models;

use \core\Model as Model;
use \models\Member as Member;

class Team extends Model
{

    const DB_TABLE = "xyz_teams";

    public static function get_members($where = [], $limit = null, $order = []){
        return Member::get($where, $limit, $order);
    }

}
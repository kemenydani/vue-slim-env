<?php
/**
 * Created by PhpStorm.
 * User: DANI
 * Date: 2017. 09. 02.
 * Time: 17:40
 */

namespace models;

use \core\Model as Model;
use \core\Storage as Storage;

class Gallery extends Model
{

    const DB_TABLE = "xyz_gallery";

    public static function find_gallery($params = []){

        $where_str = "";

        if(!empty($params)){

            $where_str .= "WHERE ";

            foreach($params as $param){
                $where_str .=  $param . " AND ";
            }
            $where_str = substr($where_str, 0, -4);
        }

        $result1 = Gallery::instance()->query("SELECT * FROM ".Gallery::DB_TABLE." {$where_str}");
        $item = $result1->fetch(\PDO::FETCH_ASSOC);

        $item['images'] = [];

        $folder = Storage::upload_dir(true) . '/files/' . $item['folder'];

        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(slash($folder), \RecursiveDirectoryIterator::SKIP_DOTS), \RecursiveIteratorIterator::SELF_FIRST );
        $iterator->setMaxDepth(0);
        $images = [];
        foreach ( $iterator as $part ) {
            if($part->isFile()){
                $images[] = Storage::upload_dir() . '/files/' . $item['folder'] . '/' . $part->getFilename();
            }
        }
        $item['images'] = $images;




        return $item;
    }

}
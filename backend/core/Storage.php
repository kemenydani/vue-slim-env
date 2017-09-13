<?php

namespace core;

class Storage
{

    const ROOT = "/app/storage";

    const UPLOAD_DIR  = Storage::ROOT . '/uploads';
    const COMPILE_DIR = Storage::ROOT . '/compile';
    const CACHE_DIR   = Storage::ROOT . '/cache';

    public static function root_dir(){
        return Storage::ROOT;
    }

    public static function upload_dir($from_doc_root = false){
        return $from_doc_root ? $_SERVER['DOCUMENT_ROOT'] . Storage::UPLOAD_DIR : Storage::UPLOAD_DIR;
    }

    public static function compile_dir(){
        return $_SERVER['DOCUMENT_ROOT'] . '/' . Storage::COMPILE_DIR;
    }

    public static function cache_dir(){
        return $_SERVER['DOCUMENT_ROOT'] . '/' . Storage::CACHE_DIR;
    }

}
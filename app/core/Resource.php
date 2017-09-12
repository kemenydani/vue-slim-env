<?php

namespace core;

class Resource
{

    const ROOT = "/resources";

    const ASSET_DIR  = Resource::ROOT . '/assets';
    const TEMPLATE_DIR = Resource::ROOT . '/templates';
    const CSS_DIR   = Resource::ASSET_DIR . '/css';
    const JS_DIR   = Resource::ASSET_DIR . '/js';
    const PLUGIN_DIR   = Resource::ASSET_DIR . '/plugins';
    const DRAWABLE_DIR   = Resource::ASSET_DIR . '/drawable';

    public static function drawable_dir(){
        return Resource::DRAWABLE_DIR;
    }

    public static function css_dir(){
        return Resource::CSS_DIR;
    }

}
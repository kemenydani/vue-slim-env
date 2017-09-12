<?php

namespace core;

use core\Storage as Storage;

class View extends \Smarty {

    // Smarty setup
    const _CACHING_ENABLED_ = false;
    const _TEMPLATE_DIR_ = '../resources/templates/';
    const _COMPILE_DIR_ = '../storage/compile';
    const _CACHE_DIR_ = '../storage/cache';

    // Template globals

    const _TEMPLATE_GLOBALS_ = [
        'base' => BASE,
        'assets' => BASE . 'resources/assets/',

        'files' => BASE . 'storage/uploads/files/',
        'thumbs' => BASE . 'storage/uploads/thumbs/',

        'js' => BASE . 'assets/js/',
        'css' =>  BASE . 'assets/css/',
        'plugins' => BASE . 'assets/plugins/',

        'drawable' => BASE . 'assets/drawable/',
        'image' => BASE . 'assets/drawable/image/',
        'svg' => BASE . 'assets/drawable/svg/',
    ];

    /**
     * Class references of the models
     * Benefit: Easy data access directly from the template
     */
    const _MODELS_ = [
        'Article' => \models\Article::class,
        'Team' => \models\Team::class,
        'Sponsor' => \models\Sponsor::class,
        'Advertisement' => \models\Advertisement::class,
        'Product' => \models\Product::class,
        'Gallery' => \models\Gallery::class,
        'Settings' => \models\Settings::class,
        'Match' => \models\Match::class,
        'Category' => \models\Category::class,
        'Stream' => \models\Stream::class,
        'Comment' => \models\Comment::class
    ];

    const _HELPERS_ = [
        'Language' => \core\Language::class,
        'Storage' => \core\Storage::class,
        'Resource' => \core\Resource::class
    ];

    public static $_instance = null;

    public function __construct(){
        parent::__construct();
    }

    public static function instance(){
        if(self::$_instance === null){

            self::$_instance = new View();

            self::$_instance->setTemplateDir(static::_TEMPLATE_DIR_);
            self::$_instance->setCompileDir(Storage::compile_dir());
            self::$_instance->setCacheDir(Storage::cache_dir());
            self::$_instance->caching = static::_CACHING_ENABLED_;

            self::$_instance->assign(static::_MODELS_);
            self::$_instance->assign(static::_HELPERS_);
            self::$_instance->assign(static::_TEMPLATE_GLOBALS_);

            self::$_instance->assign('location', $_GET['url']);

            self::$_instance->assign('controller', \core\Router::$current_controller);
            self::$_instance->assign('user', $user = (new \controllers\User())->check_session());
        }
        return self::$_instance;
    }

}
<?php
/**
 * Class Loader: load the instance according to the given class name
 *
 * 使用了单例模式，必须Loader::get_instance()来获取对象。
 */
require_once 'TPP.php';
class TPP_Loader
{
    static private $_root_dir = '';
    static private $_instance = NULL;

    private function __construct() {}

    private function  __clone() {}

    /**
     * get the unique instance of class Loader
     * @return TPP_Loader|null
     */
    static public function get_instance() {
        if (is_null(self::$_instance) || !isset(self::$_instance)) {
            self::$_instance = new self();
            self::$_root_dir = str_replace("\\", "/", dirname(__DIR__));  //the end letter is not '/'
        }
        return self::$_instance;
    }

    /**
     * get the root dir of this web app
     * @return string
     */
    private  function root_dir() {
        return self::$_root_dir;
    }

    /**
     * get the instance according to the given name of a core class
     * @param $class_name
     * @return mixed
     * @throws Exception
     */
    public function load_core_class($class_name) {   
        if (is_readable($this->root_dir() . '/Corelib/' . $class_name . '.php') === false) {
            throw new Exception("core class file ".$class_name.".php  not exist or not readable");
        } 
        else {
            require_once $this->root_dir() . '/Corelib/' . $class_name . '.php';
            $class = new $class_name();
            return $class;
        }
    }

    /**
     * get the instance according to the given name of a user defined class
     * @param $class_name
     * @return mixed
     * @throws Exception
     */
    public function load_user_class($class_name) {
        if (is_readable($this->root_dir() . '/Userlib/' . $class_name . '.php') === false) {
            throw new Exception("user class file ".$class_name.".php  not exist or not readable");
        }
        else {
            require_once $this->root_dir() . '/Userlib/' . $class_name . '.php';
            $class = new $class_name();
            return $class;
        }
    }

    /**
     * get the instance according to the given name of a controller class, should only be used by /index.php.
     * @param $class_name
     * @return mixed
     * @throws Exception
     */
    public function load_controller($class_name) {
        if (is_readable($this->root_dir() . '/Controller/' . $class_name . '.php') === false) {
            throw new Exception("controller file ".$class_name.".php  not exist or not readable");
        }
        else {
            require_once $this->root_dir() . '/Controller/' . $class_name . '.php';
            $class = new $class_name();
            return $class;
        }
    }
}
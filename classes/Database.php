<?php
require_once __DIR__."/Config.php";
require_once __DIR__."/Traits.php";
abstract class Database {

    const DB_HOST = Config::DB_HOST;
    const DB_PORT = Config::DB_PORT;
    const DB_NAME = Config::DB_NAME;
    const DB_USER = Config::DB_USER;
    const DB_PASS = Config::DB_PASS;

    protected $pdo;

    private static $instances = array();

    protected function __construct() {
        $dsn = "mysql:host=".self::DB_HOST.";port=".self::DB_PORT.";dbname=".self::DB_NAME;
        $this->pdo = new PDO($dsn, self::DB_USER, self::DB_PASS);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    protected function __clone() {

    }

    protected function __wakeup() {

    }

    public static function getInstance() {
        $class = get_called_class();
        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new static;
        }
        return self::$instances[$class];
    }

    public function __toString() {
        $str = "Database connection: host - ".self::DB_HOST.", port - ".self::DB_PORT.", db name - ".self::DB_NAME;
        $class = get_called_class();
        $str .= "<br>Instance of ".$class;
        return $str;
    }

    public function getInstances() {
        return self::$instances;
    }
}



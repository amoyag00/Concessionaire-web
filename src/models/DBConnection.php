<?php
namespace Models;
class DBConnection{
    private static $connection;
    const DB_SERVER = 'localhost';
    const DB_USERNAME = 'root';
    const DB_PASSWORD = '';
    const DB_NAME = 'HERKSDB';
    public static function getConnection(){
        if(!isset(self::$connection)){
            self::$connection=new \mysqli(self::DB_SERVER,self::DB_USERNAME,self::DB_PASSWORD,self::DB_NAME);
            if(self::$connection->connect_errno){
                die("Connection error" . self::$connection->connect_error);
            }
        }
        return self::$connection;
    }
}

?>


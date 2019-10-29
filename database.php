<?php

  class Database {
    static public $connection = "";
    public function open(){
      return new \PDO("mysql:host=127.0.0.1; dbname=test; charset=utf8", 'root','');
    }
  }

?>
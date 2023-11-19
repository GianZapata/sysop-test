<?php

namespace Model;

use PDO;

class Connection {
   private static $instance = null;

   public $db;

   private function __construct() {
      $this->db = new PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASS']);
      $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
   }

   public static function getInstance() {
      if (self::$instance == null) {
         self::$instance = new Connection();
      }
      return self::$instance;
   }

   public function getDB() {
      return $this->db;
   }
}
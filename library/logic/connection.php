<?php
require_once ('db_config.php');
include('install.php');

class Connection
{
     private static $instance; 
     public $connection; 

     public function __construct()
     {
          try {
               // Create connection to MySQL
               $dsn = "mysql:host=" . DB_HOST . ";charset=utf8mb4";
               $this->connection = new PDO($dsn, DB_USER, DB_PASS, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
               ]);

          } catch (PDOException $e) {
               showConnectionError($e->getMessage());
          }
     }

     public static function getInstance()
     {
          if (!isset(self::$instance)) {
               self::$instance = new Connection();
          }
          return self::$instance;
     }

     public static function insert_character($name, $color, $species, $fame_level, $photo)
     {
          $connection = self::getInstance()->connection;
          $sql = "INSERT INTO characters (name, color, species, fame_level, photo) VALUES (:name, :color, :species, :fame_level, :photo)";
          $stmt = $connection->prepare($sql);
          $stmt->execute(['name' => $name, 'color' => $color, 'species' => $species, 'fame_level' => $fame_level, 'photo' => $photo]);
          return $connection->lastInsertId();
     }

     public static function get_characters()
     {
          $connection = self::getInstance()->connection;
          $sql = "SELECT * FROM characters";
          $stmt = $connection->query($sql);
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     public static function get_character_by_id($id)
     {
          $connection = self::getInstance()->connection;
          $sql = "SELECT * FROM characters WHERE id = :id LIMIT 1";
          $stmt = $connection->prepare($sql);
          $stmt->execute(['id' => $id]);
          return $stmt->fetch(PDO::FETCH_OBJ);
     }

     public static function update_character($name, $color, $species, $fame_level, $photo)
     {
          $connection = self::getInstance()->connection;
          $sql = "UPDATE characters SET name = :name, color = :color, species = :species, fame_level = :fame_level, photo = :photo WHERE id = :id";
          $stmt = $connection->prepare($sql);
          $stmt->execute(['name' => $name, 'color' => $color, 'species' => $species, 'fame_level' => $fame_level, 'photo' => $photo]);
          return $stmt->rowCount();
     }

     public static function delete_character($id)
     {
          $connection = self::getInstance()->connection;
          $sql = "DELETE FROM characters WHERE id = :id";
          $stmt = $connection->prepare($sql);
          $stmt->execute(['id' => $id]);
          return $stmt->rowCount() > 0;
     }
}
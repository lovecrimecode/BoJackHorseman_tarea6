<?php
require('db_config');

class Connection {

     private static $instance;   // Almacena la única instancia de la conexión
     public $connection;         // Mantiene la conexión activa con MySQL

     public function __construct() {
     try {
        $this->connection = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
     } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            exit;
        }
}
    public function __destruct()
    {
            $this->connection = null; // Cierra la conexión al destruir el objeto
    }

     public static function getInstance()
     {
          if (!isset(self::$instance)) {
               self::$instance = new Connection();
          }
          return self::$instance;
     }    

     //CREATE
     public static function insert_character($id, $name, $color, $species, $fame_level, $photo) {
          // Implement insert_character function here
          $connection = self::getInstance()->connection;
          $sql = "INSERT INTO characters (name, color, species, fame_level, photo) VALUES (:name, :color, :species, :fame_level, :photo)";
          $stmt = $connection->prepare($sql);
          $stmt->execute(['id' => $id, 'name' => $name, 'color' => $color, 'species' => $species, 'fame_level' => $fame_level, 'photo' => $photo]);
          return $connection->lastInsertId();
     }
     
     //READ ALL
     public static function get_characters(){
          // Implement get_characters function here
          $connection = self::getInstance()->connection;
          $sql = "SELECT * FROM characters";
          $stmt = $connection->query($sql);
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     //READ ONE
     public static function get_character_by_id($id){
          // Implement get_character function here
          $connection = self::getInstance()->connection;
          $sql = "SELECT * FROM characters WHERE id = :id";
          $stmt = $connection->prepare($sql);
          $stmt->execute(['id' => $id]);
          return $stmt->rowCount();
     }

     //UPDATE
     public static function update_character($id, $name, $color, $species, $fame_level, $photo)
     {
          $connection = self::getInstance()->connection;
          $sql = "UPDATE characters SET name = :name, color = :color, species = :species, fame_level = :fame_level, photo = :photo WHERE id = :id";
          $stmt = $connection->prepare($sql);
          $stmt->execute(['id' => $id, 'name' => $name, 'color' => $color, 'species' => $species, 'fame_level' => $fame_level, 'photo' => $photo]);
          return $stmt->rowCount();
     }


     //DELETE
     public static function delete_character ($id) {
          $connection = self::getInstance()->connection;
          $sql = "DELETE FROM characters WHERE id = :id";
          $stmt = $connection->prepare($sql);
          return $stmt->execute(['id' => $id]);
     }

     public static function exec($sql, $params = [])
     {
          $connection = self::getInstance()->connection;
          $stmt = $connection->prepare($sql);
          $stmt->execute($params);
          return $stmt->rowCount();
     }
}
?>
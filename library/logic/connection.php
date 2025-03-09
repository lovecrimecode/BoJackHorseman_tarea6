<?php
     require_once 'db_config.php';

class Connection
{
     private static $instance; // La única instancia de la conexión
     public $connection; // Conexión activa con MySQL

     public function __construct()
     {
          // Validar si las constantes están definidas antes de usarlas
          if (!defined('DB_HOST') || !defined('DB_USER') || !defined('DB_NAME')) {
               header("Location: install.php");
               exit;
          }

          // Validar si los datos de conexión están vacíos
          if (empty(DB_HOST) || empty(DB_USER)) {
               header("Location: install.php");
               exit;
          }

          try {
               // Crear conexión a MySQL
               $dsn = "mysql:host=" . DB_HOST . ";charset=utf8mb4";
               $this->connection = new PDO($dsn, DB_USER, DB_PASS, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
               ]);

               // Si DB_NAME está definido, intentar usarlo
               if (defined('DB_NAME') && !empty(DB_NAME)) {
                    $stmt = $this->connection->query("SHOW DATABASES LIKE '" . DB_NAME . "'");
                    if ($stmt->rowCount() == 0) {
                         header("Location: install.php" . DB_NAME);
                         exit;
                    }
                    $this->connection->exec("USE " . DB_NAME);
               }
          } catch (PDOException $e) {
               die("<p style='color: red;'>❌ Error en la conexión: " . $e->getMessage() . "</p>");
          }
     }

     public static function getInstance()
     {
          if (!isset(self::$instance)) {
               self::$instance = new Connection();
          }
          return self::$instance;
     }

     // Métodos CRUD (insertar, leer, actualizar, eliminar)
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
?>
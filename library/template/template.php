<?php 
class Template {
     static $instance = null;
     static public function apply_template() {
          if (self::$instance === null) {
               self::$instance = new Template();
          }
          return self::$instance;
     }

     public function __construct() {
          require("template/header.php");
     }
     public function __destruct() {
          require("template/footer.php");
     }
}
?>
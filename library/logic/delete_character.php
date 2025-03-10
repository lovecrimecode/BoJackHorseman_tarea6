<?php
require_once ('connection.php'); // Ajusta la ruta según tu estructura

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
     $id = $_GET['id'];

     if (Connection::delete_character($id)) {
          header("Location: ../../index.php?msg=deleted");
     } else {
          header("Location: ../../index.php?msg=error");
     }
     exit;
} else {
     header("Location: ../../index.php?msg=invalid");
     exit;
}

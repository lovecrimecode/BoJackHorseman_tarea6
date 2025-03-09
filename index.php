<?php
// Verificar si db_config.php existe antes de incluirlo
if (!file_exists('library/logic/db_config.php')) {
     header("Location: library/logic/install.php");
     exit;
}
else if (!file_exists('db_config.php')) {
     echo "Redirecting to install.php";
     header("Location: install.php");
     exit;
}
// Incluir los archivos necesarios
require('library/template/template.php');
require_once 'library/logic/db_config.php';
require_once 'library/logic/connection.php';

// Aplicar el template
Template::apply_template();

// Obtener la lista de personajes
$characters = Connection::get_characters();
?>

<div class="container mt-4">
     <h1 class="text-center mb-3">LISTA DE PERSONAJES</h1>
     <?php
     // Verificar si hay personajes
     if ($characters) {
          show_table($characters); // Llamar a la función para mostrar la tabla
     } else {
          echo "<p class='text-center'>No hay personajes disponibles.</p>";
     }
     ?>
</div> 
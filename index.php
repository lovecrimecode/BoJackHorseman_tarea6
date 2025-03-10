<?php
if (!file_exists('library/logic/db_config.php')) {
     header("Location: library/logic/install.php");
     exit;
}

require ('library/template/template.php');
require_once ('library/logic/db_config.php');
require_once ('library/logic/connection.php');

Template::apply_template();

$characters = Connection::get_characters();
?>

<div class="container mt-4">
     <h1 class="text-center mb-3">LISTA DE PERSONAJES</h1>
     <?php
     if ($characters) {
          show_table($characters);
     } else {
          echo "<p class='text-center'>No hay personajes disponibles.</p>";
     }
     ?>
</div> 
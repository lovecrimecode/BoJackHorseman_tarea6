<?php
require('library/motor.php');
require('library/template/template.php');

Template::apply_template();

$message = '';
$character = null;

// Obtener el personaje si hay un ID en la URL (modo edición)
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
     $id = $_GET['id'];

     $character = Connection::get_character_by_id($id);
     if (!$character) {
          $message = "Personaje no encontrado.";
     }

}

// Procesar formulario (Crear o Editar)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     $id = $_POST['id'] ?? '';

     // Definir las variables correctamente
     $name = $_POST['name'] ?? '';
     $color = $_POST['color'] ?? '';
     $species = $_POST['species'] ?? '';
     $fame_level = $_POST['fame_level'] ?? '';
     $photo = $_POST['photo'] ?? '';

     if (!empty($id) && is_numeric($id)) {
          // Buscar el personaje antes de actualizar
          $character = Connection::get_character_by_id($id);
          if ($character) {
               Connection::update_character($id, $name, $color, $species, $fame_level, $photo);
               $message = "Personaje actualizado correctamente.";
          }
     } else {
          // Insertar un nuevo personaje
          Connection::insert_character($name, $color, $species, $fame_level, $photo);
          $message = "Personaje creado correctamente.";
     }
}
?>

<div class="container mt-4">
     <h1 class='page-title'>Formulario de registro</h1>
     <h3>Ingresa los datos del personaje</h3>

     <div class="form-group mt-4">
          <form class='form-horizontal' id='registerForm' name='registerForm' method='post' action=''>
               <input type='hidden' name='id' value='<?= $character->id ?? '' ?>'>

               <label for='name'>Nombre</label>
               <input class='form-control' type='text' name='name' id='name' value='<?= $character->name ?? '' ?>' required autofocus>
               <br>

               <label for='color'>Color</label>
               <input class='form-control' type='text' name='color' id='color' value='<?= $character->color ?? '' ?>' required>
               <br>

               <label for='species'>Especie</label>
               <input class='form-control' type='text' name='species' id='species' value='<?= $character->species ?? '' ?>' required>
               <br>

               <label for='fame_level'>Nivel de fama</label>
               <input class='form-control' type='number' name='fame_level' id='fame_level' value='<?= $character->fame_level ?? '' ?>' required min='1' max='10'>
               <br>

               <label for='photo'>URL de la foto</label>
               <input class='form-control' type='text' name='photo' id='photo' value='<?= $character->photo ?? '' ?>' required>

               <br>
               <button type='submit' class='btn btn-outline-warning'>Guardar</button>
          </form>
     </div>
</div>

<script>
     document.addEventListener("DOMContentLoaded", function() {
          let message = "<?= $message ?? '' ?>";
          if (message) {
               alert(message);
               window.location.href = "index.php";
          }
     });
</script>
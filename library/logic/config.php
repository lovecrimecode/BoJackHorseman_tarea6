<?php
require('./templates/templates.php');
Template::apply_template();
// Verificar si el archivo de configuración existe
if (file_exists('db_config.php')) {
     // Si no existe, mostrar el formulario para crear el archivo
     require_once 'db_config.php';
     } else {
          define('DB_HOST', '');
          define('DB_USER', '');
          define('DB_PASS', '');
          define('DB_NAME', '');

          header('Location: install.php');
          exit;
     }

// Incluir configuración y verificar conexión

require_once 'connection.php';

try {
     // Intentar la conexión
     $connection = new Connection();
} catch (Exception $e) {
     // Si hay error de conexión, mostrar la razón y permitir edición
     $error_message = $e->getMessage();
     $show_form = true;
}
?>

<!-- <!DOCTYPE html>
<html lang="es">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Asistente de Configuración</title>
</head>

<body> -->
     <?php if (isset($show_form) && $show_form): ?>
          <h1>Configuración de la Base de Datos</h1>
          <p style="color: red;">❌ Hubo un error de conexión: <?php echo $error_message; ?></p>
          <p>Por favor, revisa los valores de configuración en el archivo <strong>db_config.php</strong>.</p>
          <form action="config.php" method="POST">
               <label for="db_host">Host: </label>
               <input type="text" name="db_host" value="<?php echo DB_HOST; ?>" required><br>

               <label for="db_user">Usuario: </label>
               <input type="text" name="db_user" value="<?php echo DB_USER; ?>" required><br>

               <label for="db_pass">Contraseña: </label>
               <input type="password" name="db_pass" value="<?php echo DB_PASS; ?>"><br>

               <label for="db_name">Base de Datos: </label>
               <input type="text" name="db_name" value="<?php echo DB_NAME; ?>" required><br>

               <input type="submit" name="save_config" value="Guardar Configuración">
          </form>
     <?php else: ?>
          <h1>¡Conexión exitosa!</h1>
          <p>La conexión a la base de datos se ha realizado correctamente. El sistema está listo para usar.</p>
     <?php endif; ?>
<!-- </body>

</html> -->
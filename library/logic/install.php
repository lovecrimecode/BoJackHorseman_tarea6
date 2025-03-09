<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_config'])) {
     // Guardar los valores del formulario en el archivo db_config.php
     $db_host = $_POST['db_host'];
     $db_user = $_POST['db_user'];
     $db_pass = $_POST['db_pass'];
     $db_name = $_POST['db_name'];

     $config_content = "<?php\n";
     $config_content .= "if (!defined('DB_HOST')) define('DB_HOST', '$db_host');\n";
     $config_content .= "if (!defined('DB_USER')) define('DB_USER', '$db_user');\n";
     $config_content .= "if (!defined('DB_PASS')) define('DB_PASS', '$db_pass');\n";
     $config_content .= "define('DB_NAME', '$db_name');\n";
     $config_content .= "?>";

     file_put_contents('db_config.php', $config_content);

     echo "<p>La configuración ha sido guardada. Redirigiendo...</p>";
     header("Location: ../../../index.php");
     exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Asistente de Instalación</title>
</head>

<body>
     <h1>Bienvenido al Asistente de Instalación</h1>
     <p>No se encuentra el archivo de configuración. Por favor, ingresa los detalles de tu base de datos.</p>
     <form action="install.php" method="POST">
          <label for="db_host">Host: </label>
          <input type="text" name="db_host" required><br>

          <label for="db_user">Usuario: </label>
          <input type="text" name="db_user" required><br>

          <label for="db_pass">Contraseña: </label>
          <input type="password" name="db_pass"><br>

          <label for="db_name">Base de Datos: </label>
          <input type="text" name="db_name" required><br>

          <input type="submit" name="save_config" value="Guardar Configuración">
     </form>
</body>

</html>
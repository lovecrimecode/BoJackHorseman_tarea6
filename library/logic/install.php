<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

$showNavBar = false;

if (file_exists('db_config.php')) {
     require_once('db_config.php');
     try {
          Connection::getInstance();
     } catch (PDOException $e) {
          showConnectionError($e->getMessage());
          exit;
     }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_config'])) {
     $db_host = $_POST['db_host'];
     $db_user = $_POST['db_user'];
     $db_pass = $_POST['db_pass'];
     $db_name = $_POST['db_name'];

     // Create the configuration content
     $config_content = "<?php\n";
     $config_content .= "define('DB_HOST', '$db_host');\n";
     $config_content .= "define('DB_USER', '$db_user');\n";
     $config_content .= "define('DB_PASS', '$db_pass');\n";
     $config_content .= "define('DB_NAME', '$db_name');\n";
     $config_content .= "?>";

     if (file_put_contents('db_config.php', $config_content) !== false) {
          echo "<p>La configuración ha sido guardada. Intenta conectarte nuevamente.</p>";
          try {
               Connection::getInstance();
          } catch (PDOException $e) {
               showConnectionError($e->getMessage());
               exit;
          }
          header("Location: ../../index.php");
          exit;
     } else {
          echo "<p style='color: red;'>Error al guardar la configuración.</p>";
     }
}

function renderInstallForm()
{
     echo '
 <div id="install-form" class="container mt-5">
          <form action="install.php" method="POST" class="needs-validation" novalidate>
               <div class="form-group">
                    <label for="db_host">Host: </label>
                    <input type="text" name="db_host" class="form-control" required>
               </div>

               <div class="form-group">
                    <label for="db_user">Usuario: </label>
                    <input type="text" name="db_user" class="form-control" required>
               </div>

               <div class="form-group">
                    <label for="db_pass">Contraseña: </label>
                    <input type="password" name="db_pass" class="form-control">
               </div>

               <div class="form-group">
                    <label for="db_name">Base de Datos: </label>
                    <input type="text" name="db_name" class="form-control" required>
               </div>

               <button type="submit" name="save_config" class="btn btn-primary">Guardar Configuración</button>
          </form>
     </div>';
}

function showConnectionError($errorMessage)
{
     echo '<p style="color: red;">❌ Hubo un error de conexión: ' . $errorMessage . '</p>';
     echo '<p>Por favor, revisa los valores de configuración a continuación:</p>';
     renderInstallForm();
     exit;
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Asistente de Instalación</title>
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
     <style>
          body {
               padding-top: 20px;
          }

          .container {
               max-width: 600px;
          }
     </style>
</head>

<body>
     <div class="container">
          <h1 class="text-center">Bienvenido al Asistente de Instalación</h1>
     </div>
</body>

</html>
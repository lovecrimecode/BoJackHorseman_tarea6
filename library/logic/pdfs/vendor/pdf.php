<?php
require 'vendor/autoload.php'; // Asegúrate de haber instalado DomPDF con Composer
require 'db_config.php';
require 'components.php';

use Dompdf\Dompdf;
use Dompdf\Options;

if (isset($_GET['id'])) {
     $id = intval($_GET['id']);
     $stmt = $conn->prepare("SELECT * FROM characters WHERE id = ?");
     $stmt->bind_param("i", $id);
     $stmt->execute();
     $result = $stmt->get_result();

     if ($result->num_rows > 0) {
          $character = $result->fetch_all(MYSQLI_ASSOC);

          // Generar HTML con la tabla
          ob_start(); // Iniciar buffer de salida
          show_table($character);
          $html = ob_get_clean(); // Obtener el HTML generado

          // Configuración de DomPDF
          $options = new Options();
          $options->set('isHtml5ParserEnabled', true);
          $options->set('defaultFont', 'Helvetica');

          $dompdf = new Dompdf($options);
          $dompdf->loadHtml($html);
          $dompdf->setPaper('A4', 'portrait');
          $dompdf->render();
          $dompdf->stream("character_{$id}.pdf", array("Attachment" => 1));
     } else {
          echo "Personaje no encontrado.";
     }
} else {
     echo "ID no especificado.";
}
?>
<?php
require 'vendor/autoload.php'; // Asegúrate de haber instalado DomPDF con Composer
require_once __DIR__ . '/../connection.php';
require __DIR__ . '/../components.php';

use Dompdf\Dompdf;
use Dompdf\Options;

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $connection = Connection::getInstance()->connection;

    $stmt = $connection->prepare("SELECT * FROM characters WHERE id = ?");
    $stmt->execute([$id]);
    $character = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($character) {
        // Generar HTML con la información del personaje
        $html = show_character_pdf($character);

        if (empty($html)) {
            die("⚠️ Error: El HTML está vacío. Verifica la función show_character_pdf().");
        }
       //echo $html; exit;

        // Configuración de DomPDF
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('defaultFont', 'Helvetica');
        $options->set('isRemoteEnabled', true); // Permite cargar imágenes externas
        $options->set('debugKeepTemp', true);  // Guarda archivos temporales para depuración
        $options->set('isPhpEnabled', true);   // Permite código PHP en el HTML
        $options->set('isFontSubsettingEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait'); // Formato horizontal

        $dompdf->render();

        // Limpiar buffer de salida (Solo si hay contenido en el buffer)
        if (ob_get_length()) {
            ob_end_clean();
        }

        $dompdf->stream("character_{$id}.pdf", ["Attachment" => true]);  // Descarga automática
    } else {
        echo "Personaje no encontrado.";
    }
} else {
    echo "ID no especificado.";
}
?>
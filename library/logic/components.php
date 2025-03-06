<?php
function show_table($rows)
{
     if (empty($rows)) {
          echo "<p>No hay registros para mostrar</p>";
          return;
     }

     echo "<table class='table table-striped table-bordered'>";
     echo "<thead class='table-dark'><tr>";

     // Obtener los encabezados desde la primera fila
     $row = $rows[0];
     foreach ($row as $column => $value) {
          echo "<th>" . htmlspecialchars($column) . "</th>";
     }
     echo "<th>Acción</th>"; // Nueva columna para el botón de PDF
     echo "</tr></thead>";

     echo "<tbody>";
     foreach ($rows as $row) {
          echo "<tr>";
          foreach ($row as $column => $value) {
               if ($column === "foto") {
                    echo "<td><img src='" . htmlspecialchars($value) . "' class='img-fluid' width='100'></td>";
               } else {
                    echo "<td>" . htmlspecialchars($value) . "</td>";
               }
          }
          // Agregar botón de descarga de PDF
          echo "<td><a href='pdf.php?id=" . $row['id'] . "' target='_blank' class='btn btn-primary'>Descargar PDF</a></td>";
          echo "</tr>";
     }
     echo "</tbody></table>";
}
?>
<?php
function show_table($rows)
{
     if (empty($rows)) {
          echo "<p>No hay registros para mostrar, agrega un personaje.</p>";
          return;
     }

     $headers = [
          'id' => 'ID',
          'name' => 'Nombre',
          'color' => 'Color',
          'species' => 'Especie',
          'fame_level' => 'Nivel de fama',
          'photo' => 'Foto'
     ];

     echo "<table class='table table-striped table-bordered'>";
     echo "<thead class='table-dark'><tr>";

     // Obtener los encabezados desde la primera fila
     $row = $rows[0];
     foreach ($row as $column => $value) {
          $header_name = $headers[$column] ?? ucfirst($column);
          echo "<th>" . htmlspecialchars($header_name) . "</th>";
     }
     echo "<th>Editar</th>
     <th>Descargar PDF</th>
     <th>Borrar</th>"; // Nueva columna para el botón de PDF
     echo "</tr></thead>";

     echo "<tbody>";
     foreach ($rows as $row) {
          echo "<tr>";
          foreach ($row as $column => $value) {
               if ($column === "photo") {
                    echo "<td><img src='" . htmlspecialchars($value) . "' class='img-fluid' width='100'></td>";
               } else {
                    echo "<td>" . htmlspecialchars($value) . "</td>";
               }
          }
          echo "<td> <a href='register.php' class='btn btn-outline-warning'>✏️</a></td>
          <td><a href='./library/logic/pdfs/pdf.php?id=" . $row['id'] . "' target='_blank' class='btn btn-outline-primary'>📂</a></td>
           <td>
          <a href='./library/logic/delete_character.php?id=" . $row['id'] . "' 
             class='btn btn-outline-danger' 
             onclick='return confirm(\"¿Estás seguro de que quieres eliminar este personaje?\")'>❌
          </a>
      </td
      ></tr>";
     }
     echo "</tbody></table>";
}

function show_character_pdf($character)
{
     if (empty($character)) {
          return "<p>No hay registros disponibles.</p>";
     }

     $char = $character; // Tomar el primer (y único) personaje

     // Verificar si la imagen es válida
     $imageTag = "";
     if (!empty($char['photo'])) {
          $imagePath = htmlspecialchars($char['photo']);
          $imageTag = "<img src='{$imagePath}' style='width:400px; height:auto; display:block; margin:20px auto; border-radius: 10px; border: 4px solid #D35400;'>";
     }

     $html = "
<style>
    .card {
    font-family: 'Arial', sans-serif;
    color: #eee;
        border: 8px solid #D35400;
        text-align: center;
        background-color: #222;
        padding: 40px;
        padding-top: 200px;
        padding-bottom: 160px;
        width: 160%;
        max-width: auto;
        max-height:auto;
        margin: auto;
        border-radius: 15px;
    }
    h1 {
        font-size: 36px;
        color: #F39C12;
        text-shadow: 3px 3px 5px rgba(0,0,0,0.5);
    }
    .details {
        text-align: left;
        font-size: 20px;
        margin-top: 20px;
        padding: 10px;
    }
    .details p {
        margin: 10px 0;
    }
    .highlight {
        font-weight: bold;
        color: #E74C3C;
    }
</style>
<div class='card'>
    {$imageTag}
    <h1>{$char['name']}</h1>
    <div class='details'>
        <p><span class='highlight'>Color:</span> <span style='color: {$char['color']}'>{$char['color']}</span></p>
        <p><span class='highlight'>Especie:</span> {$char['species']}</p>
        <p><span class='highlight'>Nivel de Fama:</span> {$char['fame_level']}</p>
    </div>
</div>";

     return $html;
}

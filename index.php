<?php
require('library/template/template.php');
Template::apply_template();
?>

<div class="container mt-4">
     <h2 class="text-center mb-3">LISTA DE PERSONAJES</h2>

     <table class="table table-striped table-bordered">
          <thead class="table-dark">
               <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Color</th>
                    <th>Especie</th>
                    <th>Famosidad</th>
                    <th>Foto</th>
               </tr>
          </thead>
          <tbody>
               <tr>
                    <td>1</td>
                    <td>BoJack Horseman</td>
                    <td>Marrón</td>
                    <td>Caballo</td>
                    <td>Actor de TV</td>
                    <td><img src="bojack.jpg" alt="BoJack Horseman" class="img-fluid" width="100"></td>
               </tr>
               <tr>
                    <td>2</td>
                    <td>Princess Carolyn</td>
                    <td>Rosa</td>
                    <td>Gato</td>
                    <td>Agente de talentos</td>
                    <td><img src="princess.jpg" alt="Princess Carolyn" class="img-fluid" width="100"></td>
               </tr>
               <!-- Más filas con personajes -->
          </tbody>
     </table>
</div>
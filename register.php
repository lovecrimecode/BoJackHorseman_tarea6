<?php
require('library/motor.php');
?>

<h1 class='page-title'>Formulario de registro</h1>
<h3>Ingresa los datos del personaje</h3>

<form class='form-horizontal' id='registerForm' name='registerForm' action='save.php' method='post>
     <label for='name'>Nombre</label>
     <input type='text' name='name' id='name'>

     <label for='color'>Color</label>
     <input type='text' name='color' id='color'>

     <label for='species'>Especie</label>
     <input type='text' name='species' id='species'>

     <label for='profession'>Fama</label>
     <input type='int' name='fame' id='fame>

     <label for='photo'>Foto</label>
     <input type='text' name='photo' id='photo'>
</form>
<button type='submit' class='btn btn-primary'>Guardar</button>
<!---mostrar una notification de que se guardo el personaje en la base de datos + un boton que al presionarlo lleve a la pagina principal>--->

<script>

</script>
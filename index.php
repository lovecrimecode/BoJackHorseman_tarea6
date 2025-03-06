<?php
require('library/template/template.php');
require('library/motor.php');

Template::apply_template();

$result = get_characters();
$characters = $result->fetch_all(MYSQLI_ASSOC);
?>

<div class="container mt-4">
     <h2 class="text-center mb-3">LISTA DE PERSONAJES</h2>
     <?php show_table($characters); ?>
</div>
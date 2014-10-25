<center>
<h2>Administradores registrados</h2>
<?php
//Consulta de todos los administradores
require 'conexion.php';
$alumnos = LIGA('proyectofinal.administrador');

$cols = array(
              'Nombre' =>'@[nombre_admin]',
              'Código' => '@[clave_admin]',
              );
HTML::tabla($alumnos,false,$cols,false);
require '../html/regresaBuscar.html'; 
?>
</center>
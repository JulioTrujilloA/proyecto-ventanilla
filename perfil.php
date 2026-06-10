<?php
session_start();
if (isset($_SESSION['nombre_admin'])) {

require 'php/conexion.php';
require 'php/cabeceraInicio.php';

echo '<header>';
require 'html/header.html';
require 'php/nombreBienv.php';
echo '</header>';

echo '<section>';
echo '<div id="bod">';
require 'php/cuerpoPerfil.php';
echo '</div>';
echo '</section>';

echo '<footer>';
require 'html/footer.html';
echo '</footer>';

require 'php/pieliga.php';

} else {
	require 'php/error.php';
}
?>

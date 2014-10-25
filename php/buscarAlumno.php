<?php 
session_start();
error_reporting(E_ALL ^ E_NOTICE);
if(isset($_SESSION['nombre_admin'])){
	
require 'conexion.php';
require 'cabeceraInicio.php';

echo '<header>';
require 'header.php';
require 'nombreBienv.php';
echo'</header>';

echo'<section>';

echo'<div id="bod">';
require "cuerpoBuscaAlumno.php";
echo '</div>';
  
echo '</section>';

echo '<footer>';
require '../html/footer.html';
echo '</footer>';

require 'pieliga.php';

}else
{
	require 'error.php';}
?>

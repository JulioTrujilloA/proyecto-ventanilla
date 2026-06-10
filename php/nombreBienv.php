<div id="bienve">
<?php 
//session_start();
if(isset($_SESSION['nombre_admin']))
if(!is_file('buscarAlumno.php'))
echo'<h1> <span id="nombreAdmins">'.$_SESSION['nombre_admin'].'</span> <a id="salir" href="php/salirAdmin.php"> Salir</a></h1>';
else
echo'<h1> <span id="nombreAdmins">'.$_SESSION['nombre_admin'].'</span> <a id="salir" href="salirAdmin.php"> Salir</a></h1>';
?>
</div>
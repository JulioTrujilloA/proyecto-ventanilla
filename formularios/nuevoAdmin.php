<h2 align="center">Inserta un nuevo administrador para manejar el sistema</h2>
<?php
/**** Inserta un nuevo administrador del sistema ****/

// Se realiza la conexión con la base de datos
require '../php/conexion.php';

// Elegimos una tabla a la cual modificaremos sus campos visualmente
$administrador = LIGA('proyectofinal.administrador');

// Mediante LIGA.php elegimos las columnas necesarias que se verán en el formulario
$cols = array(
			  'Código' => '<input type="text" name="clave_admin" style="text-transform: uppercase;" required />',
              'Nombre' => '<input type="text" name="nombre_admin" required />',
              'Contraseña' => '<input type="password" name="password_admin" required />',
			  '' => '<input type="date" hidden="true" />'
			  );

// Y también elegimos las propiedades del formulario
$props = array('form'  => 'action="php/insertaAdmin.php" method="POST" id="formAdmin"',
               'legend' => 'style="color:black"',
               'submit' => '<button>Registrar</button>',
			   'reset'=>'<button hidden="true">Reset</button>');
			   
// Una vez terminadas las tareas anteriores hacemos uso de la función forma de LIGA.php
HTML::forma($administrador,false,$cols,$props );
include('../php/regresa.php');
?>

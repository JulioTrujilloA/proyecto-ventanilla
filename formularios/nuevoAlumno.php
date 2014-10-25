<h2 align="center">Registro de un nuevo estudiante</h2>
<?php
// Inserta un nuevo alumno
include('../php/conexion.php');
$alumnos = LIGA('proyectofinal.alumno');


$selector_sede = LIGA('sede');
$selector_estatus_al = LIGA('estatus_alumno');
$selector_carreras = LIGA('carrera');


$propSede = array('select' => array('name'=>'sede_alumno', 'id'=>'selector_sede', 'style'=>'text-transform: uppercase;'),
               // Se agrega un title y value a todos los option
               'option' => 'title="¡Seleccióname!" value="@[0]"');
			   
$propEstatus = array('select' => array('name'=>'estatus_alumno', 'id'=>'selector_estatus','style'=>'text-transform: uppercase;'),
               // Se agrega un title y value a todos los option
               'option' => 'title="¡Seleccióname!" value="@[0]"');

$propC = array('select' => array('name'=>'carrera_alumno', 'id'=>'selector_carrera','style'=>'text-transform: uppercase;'),
               // Se agrega un title y value a todos los option
               'option' => 'title="¡Seleccióname!" value="@[0]"');
			   
$cols = array(
			  'Código' => '<input name="codigo_alumno" size="9" maxlength="9" style="text-transform: uppercase;" required />',
              'Nombre' => '<input name="nombre_alumno" size="30" maxlength="30" style="text-transform: uppercase;" required />',              'Sede' => HTML::selector($selector_sede,'descripcion_sede',$propSede),
			  'Estatus' =>HTML::selector($selector_estatus_al,'descripcion_estatus',$propEstatus),
              'Carrera' => HTML::selector($selector_carreras,'descripcion_carrera',$propC));

$props = array('form'  => 'action="php/insertaAlumno.php" method="POST" id="formAlumno"',
               'legend' => 'style="color:black"',
               'submit' => '<button>Agregar</button>',
			   'reset'=>'<button hidden="true">Reset</button>');
			   
HTML::forma($alumnos,false,$cols,$props );
include('../php/regresa.php');
?>
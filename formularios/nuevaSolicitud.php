<h2 align="center">Escribe una nueva solicitud</h2>
<?php
/****** Inserta una solicitud nueva en el sistema  ******/

// Se realiza la conexión con la base de datos
require '../php/conexion.php';

// Consulta con LIGA.php para saber a qué tabla insertar los datos
$solicitud = LIGA('proyectofinal.solicitud');

// Selector de tabla para hacer un listado con ella: selecciona el documento (kardex, constancia, etc)
$selector_documento = LIGA('servicio');
$propD = array('select' => array('name'=>'id_servicio', 'id'=>'selector_documento', 'style'=>'text-transform: uppercase;'),
               'option' => 'title="¡Seleccióname!" value="@[0]"');
			   
// Selector de tabla para hacer un listado con ella: selecciona el estatus para el documento
$selector_estatus_doc = LIGA('estatus_documento');
$propE = array('select' => array('name'=>'estatus_doc', 'id'=>'selector_estatus_documento', 'style'=>'text-transform: uppercase;'), 'option' => 'title="¡Seleccióname!" value="@[0]"');

$claveAdmin = $_SESSION['clave_admin'];			
// Selector de tabla para hacer un listado con ella
$selector_administrador = LIGA('select clave_admin,nombre_admin from administrador where clave_admin='.$claveAdmin.'');
$propA = array('select' => array('name'=>'administrador', 'id'=>'selector_administrador', 'style'=>'text-transform: uppercase;'),
               'option' => 'title="¡Seleccióname!" value="'.$claveAdmin.'"');

$cols = array(
			  'Código' => '<input name="cod_alumno_sltud" style="text-transform: uppercase;" required />',
			  'Documento' => HTML::selector($selector_documento,'descripcion_servicio',$propD),
			  'Estatus de Servicio' => HTML::selector($selector_estatus_doc,'descripcion_doc',$propE),        
			  'Administrador'=> HTML::selector($selector_administrador,'nombre_admin',$propA)
			  );

$props = array('form'  => 'action="php/insertaSolicitud.php" method="POST" id="formSolicitud"',
               'legend' => 'style="color:black"',
               'submit' => '<button>Agregar</button>',
			   'reset'=> '<button hidden="true">Reset</button>');
			   
HTML::forma($solicitud,false,$cols,$props);
include('../php/regresa.php');
?>
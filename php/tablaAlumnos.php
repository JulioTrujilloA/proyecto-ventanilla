<center>
<h2>Escribe el nombre o código del alumno</h2>
<?php 
error_reporting(E_ALL ^ E_NOTICE);
echo '<label>Buscar: <input id="buscaAlum" /></label>';
require '../html/regresaBuscar.html'; 
//Consulta de todos los alumnos
include('conexion.php');

$pagi = $_GET['pagi']; 
$contar_pagi = (strlen($pagi));    // Contamos el numero de caracteres
$numer_reg = 10;  // Numero de registros por pagina

$alumnado = LIGA('proyectofinal.alumno');
$numero_registros0 = $alumnado->numReg();

############################################## 
// ----------------------------- Pagina anterior 
$prim_reg_an = $numer_reg - $pagi; 
$prim_reg_ant = abs($prim_reg_an);        // Tomamos el valor absoluto 

if ($pagi != 0)  
{  
$pag_anterior = '<a href="buscar.php?pagi='.$prim_reg_ant.'">Pagina anterior</a>'; 
} 
// ----------------------------- Pagina siguiente 
$prim_reg_sigu = $numer_reg + $pagi; 

if ($pagi < $numero_registros0 - ($numer_reg - 1))  
{  
$pag_siguiente = '<a href="buscar.php?pagi='.$prim_reg_sigu.'">Pagina siguiente</a>'; 
} 
// ----------------------------- Separador 
if ($pagi != 0 and $pagi < $numero_registros0 - ($numer_reg - 1))  
{  
$separador = '|'; 
} 
// Creamos la barra de navegacion 

$pagi_navegacion = ''.$pag_anterior.' '.$separador.' '.$pag_siguiente.''; 

// ----------------------------- 
############################################## 

if ($contar_pagi > 0)  
{  
// Si recibimos un valor por la variable $page ejecutamos esta consulta 
$alumnos = LIGA('select * from alumno order by nombre_alumno limit '.$pagi.','.$numer_reg.'');
$carrera = LIGA('select clave_carrera,descripcion_carrera from proyectofinal.carrera');
$estatus = LIGA('proyectofinal.estatus_alumno');
$sede = LIGA('proyectofinal.sede');

$cols = array(
              'Nombre de Alumno' =>'@[nombre_alumno]',
              'Código' => '@[codigo_alumno]',
              'Carrera' => '@[carrera_alumno]',
			  'Estatus' => '@[estatus_alumno]',
              'Sede' => '@[sede_alumno]'
              );
			  
$joins = array('carrera_alumno' => $carrera,
			   'estatus_alumno' => $estatus,
			   'sede_alumno' => $sede
			   );
echo '<div id="tabla_alumnos">';
HTML::tabla($alumnos,'Alumnos registrados',$cols,false,$joins);
echo '</div>';
echo '<p align="center">'.$pagi_navegacion.'</p> ';
}else{
	// Si NO recibimos un valor por la variable $page ejecutamos esta consulta 

$alumnos = LIGA('select * from alumno order by nombre_alumno limit 0,$numer_reg');
$carrera = LIGA('select clave_carrera,descripcion_carrera from proyectofinal.carrera');
$estatus = LIGA('proyectofinal.estatus_alumno');
$sede = LIGA('proyectofinal.sede');

$cols = array(
              'Nombre de Alumno' =>'@[nombre_alumno]',
              'Código' => '@[codigo_alumno]',
              'Carrera' => '@[carrera_alumno]',
			  'Estatus' => '@[estatus_alumno]',
              'Sede' => '@[sede_alumno]'
              );
			  
$joins = array('carrera_alumno' => $carrera,
			   'estatus_alumno' => $estatus,
			   'sede_alumno' => $sede
			   );
echo '<div id="tabla_alumnos">';
HTML::tabla($alumnos,'Alumnos registrados',$cols,false,$joins);
echo '</div>';
echo '<p align="center">'.$pagi_navegacion.'</p> ';
}
?>
</center>
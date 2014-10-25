<script language="javascript">
function confirmDel()
{
  var agree=confirm("¿Realmente desea eliminarlo? ");
  if (agree) return true ;
  return false;
}

function confirmCh()
{
  var agree=confirm("Error, ya está ");
  if (agree) return true ;
  return false;
}
</script>
<center>
<h2>Solicitudes registradas</h2>
<?php 
echo '<label>Buscar: <input id="buscaSoli" /></label><br />';

//Consulta de todos los alumnos
include('conexion.php');
$solicitudes = LIGA('proyectofinal.solicitud');



//'Cambio estatus' => HTML::selector($selector_estatus_doc,'descripcion_doc',$propE)

$cols = array(
              'Nombre' =>'@[cod_alumno_sltud]',
              'Documento' => '@[id_servicio]',
              'Estatus' => '@[estatus_doc]',
			  'Administrador' => '@[administrador]',
			  'Cambio estatus' => '<a href="php/cambiar.php?id=@[id_sltud]&valor=1&estatus=@[estatus_doc]" target="_parent"><button class="btn4">Pedido</button>
			  					   <a href="php/cambiar.php?id=@[id_sltud]&valor=2&estatus=@[estatus_doc]" target="_parent"><button class="btn4">Firmado</button>
		  						   <a href="php/cambiar.php?id=@[id_sltud]&valor=3&estatus=@[estatus_doc]" target="_parent"><button class="btn4">Entregado</button>',
			  'Eliminar' => '<a id="eliminaSoli" onclick="return confirmDel();" href="php/eliminar.php?id=@[id_sltud]">Eliminar</a>'
              );

$joins = array( 'id_servicio' => LIGA('select id_servicio,descripcion_servicio from proyectofinal.servicio'),
				'estatus_doc' => array('1' => 'PEDIDO', '2' => 'FIRMADO', '3' => 'ENTREGADO'),
				'administrador' => LIGA('select clave_admin,nombre_admin from proyectofinal.administrador'),
				'cod_alumno_sltud' => LIGA('select codigo_alumno,nombre_alumno from proyectofinal.alumno')
				);	  

echo '<br />';
echo '<div id="tabla_solicitudes">';
HTML::tabla($solicitudes,'Solicitudes registradas',$cols,false,$joins);
echo '</div>';
require '../html/regresaBuscar.html'; 
?>
</center>

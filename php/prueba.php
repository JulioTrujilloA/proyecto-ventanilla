<!doctype html>
<html>  
<head>  
<TITLE>Muestra los resultados paginados de una consulta MySQL.</TITLE>  
</head>  

<body>  
<div align='center'>  
  <table border='1' cellpadding='0' cellspacing='0' width='600' bgcolor='#F6F6F6' bordercolor='#FFFFFF'>  
    <tr>  
      <td width='150' style='font-weight: bold'>ID</td>  
      <td width='150' style='font-weight: bold'>NOMBRE</td>  
      <td width='150' style='font-weight: bold'>E-MAIL.</td>  
      <td width='150' style='font-weight: bold'></td>  
    </tr>  
<?php  

$pagi = $_GET['pagi']; 

$contar_pagi = (strlen($pagi));    // Contamos el numero de caracteres 

// Numero de registros por pagina 

$numer_reg = 10; 

include('conexion.php');  

$nombre_tabla = $tabla_db1; 

// Contamos los registros totales 

    $query0 = "select * from alumno";     // Esta linea hace la consulta 
    $result0 = mysql_query($query0);  
    $numero_registros0 = mysql_num_rows($result0);  

############################################## 
// ----------------------------- Pagina anterior 
$prim_reg_an = $numer_reg - $pagi; 
$prim_reg_ant = abs($prim_reg_an);// Tomamos el valor absoluto 

if ($pagi <> 0)  
{  
$pag_anterior = "<a href='prueba.php?pagi=$prim_reg_ant'>Pagina anterior</a>"; 
} 
// ----------------------------- Pagina siguiente 
$prim_reg_sigu = $numer_reg + $pagi; 

if ($pagi < $numero_registros0 - ($numer_reg - 1))  
{  
$pag_siguiente = "<a href='prueba.php?pagi=$prim_reg_sigu'>Pagina siguiente</a>"; 
} 
// ----------------------------- Separador 
if ($pagi <> 0 and $pagi < $numero_registros0 - ($numer_reg - 1))  
{  
$separador = "|"; 
} 
// Creamos la barra de navegacion 

$pagi_navegacion = "$pag_anterior $separador $pag_siguiente"; 

// ----------------------------- 
############################################## 

if ($contar_pagi > 0)  
{  
// Si recibimos un valor por la variable $page ejecutamos esta consulta 

    $query = "select * from $nombre_tabla LIMIT $pagi,$numer_reg"; 
}  
else  
{  
// Si NO recibimos un valor por la variable $page ejecutamos esta consulta 

    $query = "select * from $nombre_tabla LIMIT 0,$numer_reg"; 
}  

    $result = mysql_query($query);  
    $numero_registros = mysql_num_rows($result);  

    while ($registro = mysql_fetch_array($result)){  
echo "  
    <tr>  
      <td width='150'>".$registro['id']."</td>  
      <td width='150'>".$registro['nombre']."</td>  
      <td width='150'>".$registro['email']."</td>  
      <td width='150'></td>  

    </tr>  
";  
}  
include('cierra_conexion.php');  
echo " 
   </table>  
</div> 

<div align='center'>  
  <table border='0' cellpadding='0' cellspacing='0' width='600'> 
    <tr>  
      <td width='600' colspan='4'>&nbsp;</td>  
    </tr> 
    <tr>  
      <td width='600' colspan='4'><p align='right'>Registros: $numero_registros de un total de $numero_registros0</td>  
    </tr> 
   </table>  
</div> 

<p align='center'>$pagi_navegacion</p> 
"; 
?>  
</body>  

</html> 
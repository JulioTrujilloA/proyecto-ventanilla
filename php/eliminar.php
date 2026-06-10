<?php
require '../LIGA3/LIGA.php';
BD('localhost', 'root', '','proyectofinal');
$liga = LIGA('proyectofinal.solicitud');
$id=$_GET['id'];

$resp = $liga->eliminar($id);

if($resp>0){
echo '<script language="javascript">
alert("Datos eliminados");
self.location="../buscar.php";
</script>';
}else{
echo '<script language="javascript">
alert("Ocurrió un error, vuelve a intentarlo.");
self.location="../buscar.php";
</script>';
}
?>

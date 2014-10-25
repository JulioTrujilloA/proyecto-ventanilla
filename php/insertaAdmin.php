<?php
require '../LIGA3/LIGA.php';
BD('localhost', 'root', '123','proyectofinal');
$liga = LIGA('proyectofinal.administrador');
$resp = $liga->insertar($_POST); // $_POST si viene de formulario

if($resp>0){
echo '<script language="javascript">
alert("Datos agregados correctamente.");
self.location="../inicio.php";
</script>';
}else{
echo '<script language="javascript">
alert("Ocurrió un error, vuelve a intentarlo.");
self.location="../inicio.php";
</script>';
}

?>
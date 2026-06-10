<?php
require '../LIGA3/LIGA.php';
BD('localhost', 'root', '','proyectofinal');
$liga = LIGA('proyectofinal.administrador');

$datos = $_POST;
// Hashear la contraseña (consistente con el login que usa password_verify)
if (!empty($datos['password_admin'])) {
    $datos['password_admin'] = password_hash($datos['password_admin'], PASSWORD_DEFAULT);
}
// Fecha de inscripción actual (columna NOT NULL que el formulario no captura)
$datos['fecha_inscr_admin'] = date('Y-m-d H:i:s');

$resp = $liga->insertar($datos); // $datos derivado de $_POST

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
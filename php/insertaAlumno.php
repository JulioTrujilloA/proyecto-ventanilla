<?php
require '../LIGA3/LIGA.php';
BD('localhost', 'root', '');
$liga = LIGA('proyectofinal.alumno');

$datos = $_POST;
// Fecha de inscripción actual (columna NOT NULL que el formulario no captura)
$datos['fecha_inscr_alumno'] = date('Y-m-d H:i:s');

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
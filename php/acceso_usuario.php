<?php
session_start();
// Conexi�n con la base de datos
include('conexion.php');
include('pieliga.php');
//Recibir los datos ingresados en el formulario
$codigo = $_POST['codigo'];
$password = $_POST['password'];
//Consultar si los datos est�n guardados en la base de datos
$liga = LIGA('proyectofinal.administrador');
$q = array('clave_admin'=>''.$codigo.'',
	    'password_admin'=>''.$password.'');
$result = $liga->buscar($q);
if($result){
	//Definimos las variables de sesi�n y redirigimos a la p�gina de usuario
	 $_SESSION['nombre_admin'] = $result[0]['nombre_admin'];
	 $_SESSION['clave_admin'] = $result[0]['clave_admin'];
         echo '<script language="javascript"> location.href="../inicio.php" </script>';
}else{
	echo '<script language="javascript">
	alert("Escribiste mal un dato");
	self.location="../index.php"</script>';
        
}?>
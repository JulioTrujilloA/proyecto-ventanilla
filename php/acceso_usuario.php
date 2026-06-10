<?php
session_start();
// Conexión con la base de datos
include('conexion.php');

// Recibir los datos ingresados en el formulario
$codigo   = $_POST['codigo']   ?? '';
$password = $_POST['password'] ?? '';

// Buscar al administrador por su clave (buscar() filtra en PHP, no es inyectable)
$liga = LIGA('proyectofinal.administrador');
$result = $liga->buscar(array('clave_admin' => $codigo));

// Validar la contraseña con password_verify() contra el hash almacenado
if ($result && password_verify($password, $result[0]['password_admin'])) {
    // Credenciales correctas: definir variables de sesión y entrar
    $_SESSION['nombre_admin'] = $result[0]['nombre_admin'];
    $_SESSION['clave_admin']  = $result[0]['clave_admin'];
    echo '<script language="javascript"> location.href="../inicio.php" </script>';
} else {
    // Credenciales incorrectas
    echo '<script language="javascript">
    alert("Escribiste mal un dato");
    self.location="../index.php"</script>';
}
?>

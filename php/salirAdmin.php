<?php 
session_start();
if (isset($_SESSION['nombre_admin']))
		session_destroy();

echo '<script language="javascript">self.location="../index.php"</script>';
?>
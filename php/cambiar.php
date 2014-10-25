<?php

require '../LIGA3/LIGA.php';
BD('localhost', 'root', '123', 'proyectofinal');
$liga = LIGA('proyectofinal.solicitud');
$id = $_GET['id'];
$valor = $_GET['valor'];
$estatus = $_GET['estatus'];
$fecha_actual = date("Y-m-d H:i:s");

if(($valor==1 && $estatus=="PEDIDO") || ($valor==2 && $estatus=="FIRMADO") || ($valor==3 && $estatus=="ENTREGADO")){
	echo '<script language="javascript">
alert("Error: mismo estatus para el documento.");
self.location="../buscar.php";
</script>';
echo $estatus;
echo $valor;
	
}else{

if ( $valor == 1 ) {
    $registro = array('estatus_doc' => $valor, 'fecha_pedido' => $fecha_actual);
    $resp = $liga->modificar(array($id => $registro));

    if ($resp > 0) {
        echo '<script language="javascript">
alert("Datos modificados");
self.location="../buscar.php";
</script>';
    } else {
        echo '<script language="javascript">
alert("Ocurrió un error, vuelve a intentarlo.");
self.location="../buscar.php";
</script>';
    }
}else{
	if ($valor == 2) {
    $registro = array('estatus_doc' => $valor, 'fecha_firmado' => $fecha_actual);
    $resp = $liga->modificar(array($id => $registro));

    if ($resp > 0) {
        echo '<script language="javascript">
alert("Datos modificados");
self.location="../buscar.php";
</script>';
    } else {
        echo '<script language="javascript">
alert("Ocurrió un error, vuelve a intentarlo.");
self.location="../buscar.php";
</script>';
    }
	}else{
		if ($valor == 3) {
    $registro = array('estatus_doc' => $valor, 'fecha_entregado' => $fecha_actual);
    $resp = $liga->modificar(array($id => $registro));

    if ($resp > 0) {
        echo '<script language="javascript">
alert("Datos modificados");
self.location="../buscar.php";
</script>';
    } else {
        echo '<script language="javascript">
alert("Ocurrió un error, vuelve a intentarlo.");
self.location="../buscar.php";
</script>';
    }
		}
	}
}
	
}
?>

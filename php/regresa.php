<?php
if(is_file("inicio.php")){
	echo '<div id="regresa" style="width:100%; text-align:right;">
<a href="inicio.php" target="_parent"><button class="btn3">Regresar</button></a>
</div>';
}else{
	if(is_file("buscar.php")){
		echo '<div id="regresaBuscar" style="width:100%; text-align:right;">
<a href="buscar.php" target="_parent"><button class="btn3">Cancelar</button></a>
</div>
';
}else{
	echo '<div id="regresaUn" style="width:100%; text-align:right;">
<a href="inicio.php" target="_parent"><button class="btn3">Cancelar</button></a>
</div>
';
	}
}
?>
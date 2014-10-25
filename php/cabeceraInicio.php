<?php
if(is_file('buscarAlumno.php')){
$conf = array(
    'title' => 'Ventanilla Activos',
    'description' => 'Sistema de Ventanilla Activo para solicitudes de documentos oficiales',
    'css' => array('../estilos/styleinit.css', '../LIGA3/LIGA.css')
);
HTML::cabeceras($conf);
}else{$conf = array(
    'title' => 'Ventanilla Activos',
    'description' => 'Sistema de Ventanilla Activo para solicitudes de documentos oficiales',
    'css' => array('estilos/styleinit.css', 'LIGA3/LIGA.css')
);
HTML::cabeceras($conf);
}
?>
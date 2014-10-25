<?php
    // Se carga el archivo principal de la librería HTML2PDF
    require_once('../html2pdf/html2pdf.class.php');

    ob_start(); # No borre ésto
    require '../LIGA3/LIGA.php';
    BD("localhost", "root", "123", "proyectofinal");
    echo '<page id="pagpdf">';
	echo '	<div align="center">
				<img src="../estilos/pictures/controlE.png"/>
			</div>
			<div>
				<h1 align="center">Reporte de Solicitudes</h1>
			</div>
			<br />';

    $solicitud = LIGA('	select * from solicitud
						inner join alumno,administrador,estatus_documento,servicio
						where 
						solicitud.id_servicio=servicio.id_servicio
						and cod_alumno_sltud=codigo_alumno
						and administrador=clave_admin
						and estatus_doc=id_doc
						order by
						cod_alumno_sltud');
    
	$cols = array('Código alumno'=>'@[cod_alumno_sltud]',
				  'Nombre alumno'=>'@[nombre_alumno]',
				  'Documento'=>'@[descripcion_servicio]',
				  'Administrador'=>'@[nombre_admin]',
				  'Fecha Pedido' =>'@[fecha_pedido]',
				  'Fecha Firmado' =>'@[fecha_firmado]',
				  'Fecha Entregado' =>'@[fecha_entregado]');
			 
			  
    $props = array('id'=>'class="id"',
	               'table'=>'style="align:center; border-collapse:collapse" align="center"',
				   'th'=>'style="border:2px solid red; text-align:center"',
				   'td'=>'style="border:1px solid gray"');


	echo '<div>';
    HTML::tabla($solicitud,false,$cols,$props,array('descripcion_servicio'=>LIGA('servicio')));
	echo '<br />';
	$hora = new DateTime();
	$hora->setTimezone(new DateTimeZone('America/Mexico_City'));
	echo '<div style="text-align:right; width:90%;">';
	echo $hora->format("Y-m-d H:i:s");
	echo '</div>';
	echo '</div>';
    echo '</page>';
    $contenido = ob_get_clean(); # No borre ésto
    try {
        // Se invoca la librería con D para hoja vertical (L horizontal), tamaño carta (Letter) e idioma español para los textos de la librería
        $html2pdf = new HTML2PDF('L', 'Legal', 'es');

        // Permisos permitidos: print=imprimir, modify=modificar, copy=copiar texto, annot-forms=uso de formularios
        // Segundo parámetro es una contraseña de apertura del documento
        // Tercer parámetro es una contraseña para proteger el documento de los permisos denegados
        $html2pdf->pdf->SetProtection(array('print','copy'),false,sha1('ContraseñaGENIAL'));

        // Propiedades del documento, coloque aquí sus datos o puede descartar ésta parte
        $html2pdf->pdf->SetAuthor('Control Escolar');
        $html2pdf->pdf->SetTitle('Reporte');
        $html2pdf->pdf->SetSubject('Solicitudes Registradas');
        $html2pdf->pdf->SetKeywords('documento,html2pdf,ajax,liga');

        // Se parsea el código generado hacia TCPDF
        $html2pdf->writeHTML($contenido);

        // Se envía el documento al navegador (I), con D forza la descarga
        $html2pdf->Output('Reporte.pdf','I');
    } catch(HTML2PDF_exception $e) {
        // Manejador de alguna excepción, si no tiene experiencia en ésto no lo modifique
        echo $e;
        exit;
    }
?>
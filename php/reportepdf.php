<?php
    // Reporte de Solicitudes en PDF.
    // Modernización PHP 8.2: se sustituyó la librería vendida tcpdf 5.0.002 (2010)
    // por spipu/html2pdf ^5 (sobre tecnickcom/tcpdf 6) instalada vía Composer.
    use Spipu\Html2Pdf\Html2Pdf;
    use Spipu\Html2Pdf\Exception\Html2PdfException;

    // Autoloader de Composer (vendor/ en la raíz del proyecto)
    require_once('../vendor/autoload.php');

    ob_start(); # No borre ésto
    require '../LIGA3/LIGA.php';
    BD("localhost", "root", "", "proyectofinal");
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
        // L = horizontal (P vertical), tamaño Legal (Oficio) e idioma español
        $html2pdf = new Html2Pdf('L', 'Legal', 'es');

        // Permisos permitidos: print=imprimir, copy=copiar texto.
        // 2º parámetro: contraseña de apertura. 3º: contraseña de permisos.
        $html2pdf->pdf->SetProtection(array('print','copy'), '', sha1('ContraseñaGENIAL'));

        // Propiedades del documento
        $html2pdf->pdf->SetAuthor('Control Escolar');
        $html2pdf->pdf->SetTitle('Reporte');
        $html2pdf->pdf->SetSubject('Solicitudes Registradas');
        $html2pdf->pdf->SetKeywords('documento,html2pdf,ajax,liga');

        // Se parsea el HTML hacia TCPDF
        $html2pdf->writeHTML($contenido);

        // Se envía al navegador (I); usar 'D' para forzar la descarga
        $html2pdf->output('Reporte.pdf', 'I');
    } catch (Html2PdfException $e) {
        // Manejador de excepción de la librería
        echo $e;
        exit;
    }
?>

<?php require 'php/conexion.php'; ?>
<?php require 'php/cabecera.php'; ?>

<header>
    <?php require 'html/header.html'; ?>
</header>

<section>
		<article>
        <?php 		
		if(!isset($_SESSION['nombre_admin']))
		require "html/inicio_sesion.html"; 
		else
		echo '<script language="javascript">
		self.location="inicio.php"</script>';		
		?>
        </article>
</section>

<footer>
    <?php require 'html/footer.html'; ?>
</footer>

<?php require('php/pieliga.php'); ?>
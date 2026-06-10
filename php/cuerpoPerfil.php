<?php
// Fragmento de contenido para perfil.php (se carga dentro de #bod).
// La conexión y la sesión ya están iniciadas por perfil.php.

$clave = $_SESSION['clave_admin'] ?? '';

// Cuenta + perfil en una sola consulta (LEFT JOIN: aparece aunque no haya perfil)
$conn = BD::$conn;
$stmt = $conn->prepare(
    "SELECT a.clave_admin, a.nombre_admin,
            p.domicilio, p.telefono, p.foto
     FROM administrador a
     LEFT JOIN perfil p ON a.clave_admin = p.clave_admin
     WHERE a.clave_admin = ?"
);
$stmt->bind_param('s', $clave);
$stmt->execute();
$datos = $stmt->get_result()->fetch_assoc();

function hp($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
?>
<h2 align="center">Mi perfil</h2>

<?php if (isset($_GET['ok'])): ?>
  <p class="perfil-ok">Perfil guardado correctamente.</p>
<?php elseif (isset($_GET['error'])):
  $errs = array(
    'foto' => 'La foto debe ser una imagen JPG, PNG o GIF de máximo 2 MB.',
    'bd'   => 'No se pudo guardar el perfil. Intente de nuevo.',
  );
  echo '<p class="perfil-err">' . hp($errs[$_GET['error']] ?? 'Ocurrió un error.') . '</p>';
endif; ?>

<div id="cuerpoPerfil">
  <div class="perfil-foto">
    <?php if (!empty($datos['foto'])): ?>
      <img src="<?php echo hp($datos['foto']); ?>" alt="Foto de perfil">
    <?php else: ?>
      <span class="perfil-sinfoto">Sin foto</span>
    <?php endif; ?>
  </div>

  <form action="php/guardar_perfil.php" method="post" enctype="multipart/form-data">
    <p><label>Código</label>
       <input type="text" value="<?php echo hp($datos['clave_admin']); ?>" disabled></p>

    <p><label>Nombre</label>
       <input type="text" value="<?php echo hp($datos['nombre_admin']); ?>" disabled></p>

    <p><label>Domicilio</label>
       <input type="text" name="domicilio" value="<?php echo hp($datos['domicilio']); ?>"></p>

    <p><label>Teléfono</label>
       <input type="text" name="telefono" value="<?php echo hp($datos['telefono']); ?>"></p>

    <p><label>Foto <small>(JPG, PNG o GIF, máx. 2 MB)</small></label>
       <input type="file" name="foto" accept="image/jpeg,image/png,image/gif"></p>

    <p class="perfil-acciones"><button type="submit">Guardar perfil</button></p>
  </form>
</div>

<div id="regresa" style="width:100%; text-align:right;">
  <a href="inicio.php" target="_parent"><button class="btn1">Regresar</button></a>
</div>

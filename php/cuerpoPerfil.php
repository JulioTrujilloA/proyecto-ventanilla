<?php
// Fragmento de contenido para perfil.php (se carga dentro de #bod).
// La conexión y la sesión ya están iniciadas por perfil.php.
// El formulario se construye con el framework LIGA (HTML::forma) a partir
// de los metadatos de la tabla `perfil`.

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

<?php
// Formulario generado por LIGA desde la tabla `perfil`.
$perfil = LIGA('proyectofinal.perfil');

// Valores actuales para prellenar los campos editables (columnas reales)
$vals = array(
    'domicilio' => $datos['domicilio'] ?? '',
    'telefono'  => $datos['telefono']  ?? '',
);

// Columnas del formulario: código/nombre de solo lectura (de administrador),
// domicilio/telefono como campos reales de `perfil`, y foto como input de archivo.
$cols = array(
    'Código'    => '<input type="text" value="' . hp($datos['clave_admin']) . '" disabled />',
    'Nombre'    => '<input type="text" value="' . hp($datos['nombre_admin']) . '" disabled />',
    'domicilio' => 'Domicilio',
    'telefono'  => 'Teléfono',
    'Foto'      => '<input type="file" name="foto" accept="image/jpeg,image/png,image/gif" />',
);

$props = array(
    'form'   => 'action="php/guardar_perfil.php" method="post" enctype="multipart/form-data" id="formPerfil"',
    'submit' => '<button class="btn1">Guardar perfil</button>',
    'reset'  => '',
);

HTML::forma($perfil, 'Datos del administrador', $cols, $props, true, $vals);
?>
</div>

<div id="regresa" style="width:100%; text-align:right;">
  <a href="inicio.php" target="_parent"><button class="btn2">Regresar</button></a>
</div>

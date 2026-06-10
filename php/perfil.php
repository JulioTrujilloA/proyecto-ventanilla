<?php
require __DIR__ . '/conexion.php';

// Guard: solo administradores autenticados
if (empty($_SESSION['clave_admin'])) {
    echo '<script language="javascript">self.location="../index.php"</script>';
    exit;
}

$clave = $_SESSION['clave_admin'];

// Traer cuenta + perfil en una sola consulta (LEFT JOIN: el admin aparece
// aunque todavía no tenga perfil; en ese caso los campos de perfil son NULL)
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

// Helper para no romper el HTML con datos del usuario
function h($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Mi perfil</title>
<style>
  body { font-family: Verdana, Arial, sans-serif; font-size: 13px; max-width: 560px; margin: 30px auto; }
  h2 { text-align: center; }
  label { display: block; margin: 12px 0 4px; font-weight: bold; }
  input[type=text], input[type=file] { width: 100%; padding: 6px; box-sizing: border-box; }
  .foto { text-align: center; margin: 16px 0; }
  .foto img { max-width: 160px; max-height: 160px; border: 1px solid #ccc; border-radius: 6px; }
  .msg-ok { color: green; text-align: center; font-weight: bold; }
  .msg-err { color: red; text-align: center; font-weight: bold; }
  .actions { margin-top: 18px; text-align: center; }
  .links { text-align: center; margin-top: 20px; }
</style>
</head>
<body>

<h2>Mi perfil</h2>

<?php if (isset($_GET['ok'])): ?>
  <p class="msg-ok">Perfil guardado correctamente.</p>
<?php elseif (isset($_GET['error'])):
  $errs = array(
    'foto' => 'La foto debe ser una imagen JPG, PNG o GIF de máximo 2 MB.',
    'bd'   => 'No se pudo guardar el perfil. Intente de nuevo.',
  );
  $e = $_GET['error']; ?>
  <p class="msg-err"><?php echo h($errs[$e] ?? 'Ocurrió un error.'); ?></p>
<?php endif; ?>

<div class="foto">
  <?php if (!empty($datos['foto'])): ?>
    <img src="../<?php echo h($datos['foto']); ?>" alt="Foto de perfil">
  <?php else: ?>
    <p>(Sin foto)</p>
  <?php endif; ?>
</div>

<form action="guardar_perfil.php" method="post" enctype="multipart/form-data">
  <label>Código</label>
  <input type="text" value="<?php echo h($datos['clave_admin']); ?>" disabled>

  <label>Nombre</label>
  <input type="text" value="<?php echo h($datos['nombre_admin']); ?>" disabled>

  <label>Domicilio</label>
  <input type="text" name="domicilio" value="<?php echo h($datos['domicilio']); ?>">

  <label>Teléfono</label>
  <input type="text" name="telefono" value="<?php echo h($datos['telefono']); ?>">

  <label>Foto (JPG, PNG o GIF, máx. 2 MB)</label>
  <input type="file" name="foto" accept="image/jpeg,image/png,image/gif">

  <div class="actions">
    <button type="submit">Guardar perfil</button>
  </div>
</form>

<div class="links">
  <a href="../inicio.php">&larr; Volver</a> &nbsp;|&nbsp;
  <a href="salirAdmin.php">Cerrar sesión</a>
</div>

</body>
</html>

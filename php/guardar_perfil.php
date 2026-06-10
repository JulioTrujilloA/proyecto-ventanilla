<?php
require __DIR__ . '/conexion.php';

// Guard: solo administradores autenticados
if (empty($_SESSION['clave_admin'])) {
    echo '<script language="javascript">self.location="../index.php"</script>';
    exit;
}

$clave     = $_SESSION['clave_admin'];
$domicilio = trim($_POST['domicilio'] ?? '');
$telefono  = trim($_POST['telefono']  ?? '');

// Carpeta de subidas (en la raíz del proyecto, un nivel arriba de /php)
$dirSubidas = __DIR__ . '/../uploads';

// Ruta de foto que se guardará en BD; null = no cambiar la actual
$rutaFoto = null;

// ¿Subieron una foto?
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {

    // Validar tamaño (2 MB) y tipo real por contenido (no por extensión)
    $maxBytes = 2 * 1024 * 1024;
    if ($_FILES['foto']['size'] > $maxBytes) {
        header("Location: perfil.php?error=foto");
        exit;
    }

    $permitidos = array(
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/gif'  => 'gif',
    );
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime  = $finfo->file($_FILES['foto']['tmp_name']);

    if (!isset($permitidos[$mime])) {
        header("Location: perfil.php?error=foto");
        exit;
    }

    // Nombre determinístico por admin → reemplaza la foto anterior
    $ext           = $permitidos[$mime];
    $nombreArchivo = $clave . '.' . $ext;
    $destino       = $dirSubidas . '/' . $nombreArchivo;

    if (!move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
        header("Location: perfil.php?error=bd");
        exit;
    }

    // Ruta relativa a la raíz del proyecto (las páginas en /php le anteponen ../)
    $rutaFoto = 'uploads/' . $nombreArchivo;
}

$conn = BD::$conn;

if ($rutaFoto === null) {
    // Sin foto nueva: no tocar la columna foto
    $stmt = $conn->prepare(
        "INSERT INTO perfil (clave_admin, domicilio, telefono)
         VALUES (?, ?, ?)
         ON DUPLICATE KEY UPDATE domicilio = VALUES(domicilio),
                                 telefono  = VALUES(telefono)"
    );
    $stmt->bind_param('sss', $clave, $domicilio, $telefono);
} else {
    // Con foto nueva: actualizar también la columna foto
    $stmt = $conn->prepare(
        "INSERT INTO perfil (clave_admin, domicilio, telefono, foto)
         VALUES (?, ?, ?, ?)
         ON DUPLICATE KEY UPDATE domicilio = VALUES(domicilio),
                                 telefono  = VALUES(telefono),
                                 foto      = VALUES(foto)"
    );
    $stmt->bind_param('ssss', $clave, $domicilio, $telefono, $rutaFoto);
}

if ($stmt->execute()) {
    header("Location: perfil.php?ok=1");
    exit;
} else {
    header("Location: perfil.php?error=bd");
    exit;
}
?>

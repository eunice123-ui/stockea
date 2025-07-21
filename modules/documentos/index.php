<?php
session_start();
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../../modules/login/login.php");
    exit();
}

$categorias = ['Trabajo', 'Personal', 'Estudios'];
$archivos = glob("../../assets/uploads/*.*");

function getIconForFile($filename) {
  $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
  return match($ext) {
    'pdf' => 'bi bi-file-earmark-pdf',
    'doc', 'docx' => 'bi bi-file-earmark-word',
    'xls', 'xlsx' => 'bi bi-file-earmark-excel',
    'png', 'jpg', 'jpeg', 'gif' => 'bi bi-file-earmark-image',
    'mp4', 'mov', 'avi', 'mkv' => 'bi bi-file-earmark-play',
    'zip', 'rar' => 'bi bi-file-earmark-zip',
    default => 'bi bi-file-earmark-text',
  };
}

function isImage($filePath) {
  $mime = mime_content_type($filePath);
  return str_contains($mime, 'image/');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Gestión de Documentos</title>
  <link rel="stylesheet" href="../../assets/css/documentos.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
  <div class="container">
    <h2>📁 Tus Documentos</h2>
    <a href="../dashboard/dashboard.php" class="btn-back top">← Volver al panel</a>

    <form action="subir.php" method="POST" enctype="multipart/form-data" class="upload-form">
      <input type="file" name="archivo[]" multiple required>
      <select name="categoria" required>
        <option value="">Categoría</option>
        <?php foreach ($categorias as $cat): ?>
          <option value="<?= $cat ?>"><?= $cat ?></option>
        <?php endforeach; ?>
      </select>
      <button type="submit">Subir</button>
    </form>

    <div class="tabs">
      <?php foreach ($categorias as $cat): ?>
        <button class="tab-button" onclick="showCategory('<?= $cat ?>')"><?= $cat ?></button>
      <?php endforeach; ?>
    </div>

    <?php foreach ($categorias as $categoria): ?>
      <h3 class="cat-title"><?= $categoria ?></h3>
      <div class="docs-list docs-group" data-cat="<?= $categoria ?>" style="<?= $categoria === 'Trabajo' ? '' : 'display:none;' ?>">
        <?php foreach ($archivos as $archivo): ?>
          <?php
            $nombre = basename($archivo);
            if (str_starts_with($nombre, $categoria . '_')):
              $icon = getIconForFile($nombre);
              $esImagen = isImage($archivo);
              $extension = pathinfo($nombre, PATHINFO_EXTENSION);
          ?>
          <div class="doc-card <?= strtolower($categoria) ?>">
            <?php if ($esImagen): ?>
              <img src="<?= $archivo ?>" class="thumb" alt="Imagen">
            <?php else: ?>
              <i class="<?= $icon ?>"></i>
            <?php endif; ?>
            <span><?= $nombre ?></span>
            <div class="actions">
              <a href="<?= $archivo ?>" download><i class="bi bi-download" title="Descargar"></i></a>
              <a href="editar.php?file=<?= urlencode($nombre) ?>"><i class="bi bi-pencil" title="Renombrar"></i></a>
              <a href="eliminar.php?file=<?= urlencode($nombre) ?>" onclick="return confirm('¿Eliminar este documento?')"><i class="bi bi-trash" title="Eliminar"></i></a>
              <a href="<?= $archivo ?>" target="_blank"><i class="bi bi-eye" title="Ver"></i></a>
            </div>
          </div>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
    <?php endforeach; ?>

    
  </div>

  <script>
    function showCategory(cat) {
      document.querySelectorAll('.docs-group').forEach(group => {
        group.style.display = group.dataset.cat === cat ? 'grid' : 'none';
      });
      document.querySelectorAll('.cat-title').forEach(title => {
        title.style.display = title.textContent === cat ? 'block' : 'none';
      });
    }
  </script>
</body>
</html>

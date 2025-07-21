<?php
session_start();
require '../../includes/db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login/login.php"); 
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// Recupera valores desde BD si la sesión no los tiene
if (!isset($_SESSION['usuario_foto']) || !isset($_SESSION['usuario_nombre'])) {
    $datos = $conn->query("SELECT nombre, foto FROM usuarios WHERE id = $usuario_id")->fetch_assoc();
    $_SESSION['usuario_nombre'] = $datos['nombre'] ?? 'Usuario';
    $_SESSION['usuario_foto'] = $datos['foto'] ?? 'default.png';
}

$nombre = $_SESSION['usuario_nombre'];
$foto = $_SESSION['usuario_foto'] ?? 'default.png';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Control - Stockea</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- CSS personalizado -->
    <link rel="stylesheet" href="../../assets/css/dashboard.css?v=1.0">
</head>
<body class="<?= 'theme-' . ($_SESSION['tema'] ?? 'claro') ?>">

<div class="d-flex flex-column min-vh-100">
    <div class="d-flex flex-grow-1">
        <!-- Sidebar -->
        <div class="sidebar d-flex flex-column justify-content-between">
            <div>
                <div class="text-center mb-4">
                    <img src="/STOCKEA/assets/uploads/<?= htmlspecialchars($foto) ?>" alt="Foto de perfil" width="100" height="100" class="rounded-circle">
                    <h6 class="mt-2"><?= htmlspecialchars($nombre) ?></h6>
                    <hr class="divider-sidebar">
                </div>

                <a href="../notas/index.php" class="text-decoration-none">
                    <div class="card-menu text-center mb-3">
                        <i class="bi bi-journal-text fs-3 text-success"></i>
                        <div class="menu-text mt-1">Notas</div>
                    </div>
                </a>

                <a href="../documentos/index.php" class="text-decoration-none">
                    <div class="card-menu text-center mb-3">
                        <i class="bi bi-folder2-open fs-3 text-primary"></i>
                        <div class="menu-text mt-1">Documentos</div>
                    </div>
                </a>

                <a href="../calendario/index.php" class="text-decoration-none">
                    <div class="card-menu text-center mb-3">
                        <i class="bi bi-calendar-event fs-3 text-warning"></i>
                        <div class="menu-text mt-1">Calendario</div>
                    </div>
                </a>

                <a href="../configuracion/index.php" class="text-decoration-none">
                    <div class="card-menu text-center mt-4">
                        <i class="bi bi-gear fs-3 text-secondary"></i>
                        <div class="menu-text mt-1">Configuración</div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Contenido principal -->
        <div class="flex-grow-1 p-4">
            <div class="topbar d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center">
                    <i class="bi bi-grid-fill fs-4 me-2 text-success"></i>
                    <span class="fw-bold">Panel de Inventario</span>
                </div>

                <!-- Menú de usuario -->
                <div class="dropdown d-flex align-items-center">
                    <img src="/STOCKEA/assets/uploads/<?= htmlspecialchars($foto) ?>" alt="Foto de perfil" width="40" height="40" class="rounded-circle me-2">
                    <span class="me-2">Hola, <?= htmlspecialchars($nombre) ?></span>
                    <a class="btn btn-link dropdown-toggle text-decoration-none" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle fs-4"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="/STOCKEA/modules/configuracion/perfil.php">
                                <i class="bi bi-person"></i> Perfil
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/STOCKEA/modules/configuracion/cambiar_contrasena.php">
                                <i class="bi bi-lock"></i> Cambiar Contraseña
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="/STOCKEA/modules/logout.php">
                                <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                            </a>
                        </li>
                    </ul>
                </div>
            </div>


            <!-- Bienvenida con logo alineado -->
                <div class="d-flex align-items-center mb-4">
                <img src="../../assets/img/logo.png" alt="Logo" class="logo-grande me-3">
                <div>
                    <h4 class="mb-1">Bienvenido, <?= htmlspecialchars($nombre) ?> 👋</h4>
                    <p class="text-muted small mb-0">Gestiona tu inventario de forma eficiente y visual desde tu panel principal</p>
                </div>
            </div>

            <!-- Tarjetas -->
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                <div class="col">
                    <div class="card-option">
                        <i class="bi bi-cart"></i>
                        <h5 class="mt-2">Registrar Producto</h5>
                        <a href="../productos/crear.php" class="btn btn-sm btn-success mt-2">Registrar</a>
                    </div>
                </div>

                <div class="col">
                    <div class="card-option">
                        <i class="bi bi-box-seam"></i>
                        <h5 class="mt-2">Listado de Productos</h5>
                        <a href="../productos/lista.php" class="btn btn-sm btn-outline-primary mt-2">Ver Productos</a>
                    </div>
                </div>

                <div class="col">
                    <div class="card-option">
                        <i class="bi bi-person-lines-fill"></i>
                        <h5 class="mt-2">Clientes</h5>
                        <a href="../clientes/lista.php" class="btn btn-sm btn-outline-info mt-2">Ver Clientes</a>
                    </div>
                </div>

                <div class="col">
                    <div class="card-option">
                        <i class="bi bi-truck"></i>
                        <h5 class="mt-2">Proveedores</h5>
                        <a href="../proveedores/lista.php" class="btn btn-sm btn-outline-warning mt-2">Ver Proveedores</a>
                    </div>
                </div>

                <div class="col">
                    <div class="card-option">
                        <i class="bi bi-bar-chart"></i>
                        <h5 class="mt-2">Estadísticas</h5>
                        <a href="../estadisticas/index.php" class="btn btn-sm btn-outline-success mt-2">Ver Estadísticas</a>
                    </div>
                </div>

                <div class="col">
                    <div class="card-option">
                        <i class="bi bi-receipt" style="color: #dc3545;"></i>
                        <h5 class="mt-2">Ventas</h5>
                        <a href="../ventas/lista.php" class="btn btn-sm btn-outline-danger mt-2">Ver Ventas</a>
                    </div>
                </div>
            </div>

            <!-- Pie de página -->
            <footer class="footer-main mt-5">
                © <?= date("Y") ?> Stockea. Todos los derechos reservados.
            </footer>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/dashboard.js"></script>

</body>
</html>

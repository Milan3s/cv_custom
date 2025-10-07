<?php
// =========================
// CONFIGURACIÓN Y SESIÓN
// =========================
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // ✅ Aseguramos la sesión activa
}

require_once __DIR__ . "/../config/Rutas.php";
require_once __DIR__ . "/../config/auth.php";
require_once __DIR__ . "/../controllers/ExperienciaController.php";
require_once __DIR__ . "/../controllers/CertificadoController.php";

// =========================
// VERIFICAR AUTENTICACIÓN
// =========================

// Compatibilidad: algunos sistemas guardan sesión en $_SESSION['user'], otros en $_SESSION['usuario_id']
if (isset($_SESSION['user']) && is_array($_SESSION['user']) && isset($_SESSION['user']['id']) && !isset($_SESSION['usuario_id'])) {
    $_SESSION['usuario_id'] = $_SESSION['user']['id'];
}

// Si no hay sesión activa, devolver error
if (empty($_SESSION["usuario_id"])) {
    http_response_code(403);
    echo "No autorizado.";
    exit;
}

// ✅ Usuario autenticado
$usuario_id = (int) $_SESSION["usuario_id"];

// =========================
// PARÁMETROS DE PETICIÓN
// =========================
$tipo = $_GET['tipo'] ?? '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

// =========================
// FUNCIÓN AUXILIAR DE FECHAS
// =========================
function formatearFechaAjaxPrivado($fecha)
{
    if (!$fecha) return "";
    $date = DateTime::createFromFormat("Y-m-d", $fecha);
    return $date ? $date->format("d-m-Y") : $fecha;
}

// =========================
// MANEJO DE TIPOS DE PETICIÓN
// =========================
switch ($tipo) {

    // ============================================
    // 📂 EXPERIENCIAS (paginado privado)
    // ============================================
    case 'Experiencia':
        $ctrl = new ExperienciaController();
        $datos = $ctrl->getPaginadoPrivadoExperiencia($usuario_id, $page, 2);

        if (empty($datos["experiencias"])) {
            echo "<p>No hay experiencias registradas.</p>";
            exit;
        }

        foreach ($datos["experiencias"] as $exp) {
            echo "<div class='exp-item mb-4'>";
            echo "<h5>" . htmlspecialchars($exp->getRol()) . "</h5>";
            echo "<div class='contenedor-linea'><hr class='linea-custom-glob'></div>";
            echo "<p><em>" . htmlspecialchars($exp->getEmpresa()) . "</em>";
            if ($exp->getUbicacion()) {
                echo " (" . htmlspecialchars($exp->getUbicacion()) . ")";
            }
            echo "<br><span>" . formatearFechaAjaxPrivado($exp->getFechaInicio()) . " – " . formatearFechaAjaxPrivado($exp->getFechaFin()) . "</span></p>";

            if ($exp->getDescripcion()) {
                echo strip_tags($exp->getDescripcion(), '<p><br><ul><ol><li><b><strong><i><em><u>');
            }
            echo "</div>";
        }
        break;

    // ============================================
    // 📜 CERTIFICADOS (paginado privado)
    // ============================================
    case 'Certificado':
        $ctrl = new CertificadoController();
        $porPagina = 7; // 👈 Mostrar 7 certificados por página
        $datos = $ctrl->getPaginadoPrivadoCertificado($usuario_id, $page, $porPagina);


        if (empty($datos["certificados"])) {
            echo "<p>No hay certificados registrados.</p>";
            exit;
        }

        echo "<ul class='list-unstyled ps-1'>";
        foreach ($datos["certificados"] as $c) {
            echo "<li class='mb-2'>";
            echo "<strong>" . htmlspecialchars($c->getTitulo()) . "</strong><br>";
            echo "<span>" . htmlspecialchars($c->getEntidad()) . "</span><br>";
            echo "<small>" . formatearFechaAjaxPrivado($c->getFecha()) . "</small>";
            if ($c->getUrl()) {
                echo "<br><a href='" . htmlspecialchars($c->getUrl()) . "' target='_blank'>Ver certificado</a>";
            }
            echo "</li>";
        }
        echo "</ul>";
        break;

    // ============================================
    // 🚫 DEFAULT
    // ============================================
    default:
        http_response_code(400);
        echo "Tipo no válido.";
        break;
}
?>

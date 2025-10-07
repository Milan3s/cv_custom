<?php
require_once __DIR__ . "/../config/Rutas.php";
require_once __DIR__ . "/../controllers/ExperienciaController.php";
require_once __DIR__ . "/../controllers/CertificadoController.php";

$tipo = $_GET['tipo'] ?? '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

function formatearFechaAjax($fecha) {
  if (!$fecha) return "";
  $date = DateTime::createFromFormat("Y-m-d", $fecha);
  return $date ? $date->format("d-m-Y") : $fecha;
}

if ($tipo === 'Experiencia') {
    $ctrl = new ExperienciaController();
    $datos = $ctrl->getPaginadoPublicoExperiencia($page, 2);
    foreach ($datos["experiencias"] as $exp) {
        echo "<div class='exp-item mb-4'>";
        echo "<h5>" . htmlspecialchars($exp->getRol()) . "</h5>";
        echo "<div class='contenedor-linea'><hr class='linea-custom-glob'></div>";
        echo "<p><em>" . htmlspecialchars($exp->getEmpresa()) . "</em>";
        if ($exp->getUbicacion()) echo " (" . htmlspecialchars($exp->getUbicacion()) . ")";
        echo "<br><span>" . formatearFechaAjax($exp->getFechaInicio()) . " – " . formatearFechaAjax($exp->getFechaFin()) . "</span></p>";
        if ($exp->getDescripcion()) echo strip_tags($exp->getDescripcion(), '<p><br><ul><ol><li><b><strong><i><em><u>');
        echo "</div>";
    }

} elseif ($tipo === 'Certificado') {
    $ctrl = new CertificadoController();
    $porPagina = 7; // 👈 Mostrar 7 certificados por página
    $datos = $ctrl->getPaginadoPublicoCertificado($page, $porPagina);

    echo "<ul class='list-unstyled ps-1'>";
    foreach ($datos["certificados"] as $c) {
        echo "<li class='mb-2'><strong>" . htmlspecialchars($c->getTitulo()) . "</strong><br>";
        echo "<span>" . htmlspecialchars($c->getEntidad()) . "</span><br>";
        echo "<small>" . formatearFechaAjax($c->getFecha()) . "</small>";
        if ($c->getUrl()) echo "<br><a href='" . htmlspecialchars($c->getUrl()) . "' target='_blank'>Ver certificado</a>";
        echo "</li>";
    }
    echo "</ul>";
} else {
    http_response_code(400);
    echo "Tipo no válido.";
}

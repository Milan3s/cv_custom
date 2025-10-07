<?php
require_once __DIR__ . "/../../config/Rutas.php";
require_once __DIR__ . "/../../controllers/CertificadoController.php";
require_once __DIR__ . "/../../controllers/SeccionController.php";

header("Content-Type: application/json");

$certificadoController = new CertificadoController();
$certificados = $certificadoController->getAll();

$seccionController = new SeccionController();
$secciones = $seccionController->getSecciones();

// 🔹 Mapa de secciones [id => titulo]
$mapSecciones = [];
foreach ($secciones as $s) {
    $mapSecciones[$s->getId()] = $s->getTitulo();
}

if (!empty($certificados)) {
    $data = [];

    foreach ($certificados as $c) {
        $seccionId = $c->getSeccionId() !== null ? (int) $c->getSeccionId() : null;

        $data[] = [
            "id"         => (int) $c->getId(),
            "usuario_id" => (int) $c->getUsuarioId(),
            "titulo"     => $c->getTitulo(),
            "entidad"    => $c->getEntidad(),
            "fecha"      => $c->getFecha(),
            "url"        => $c->getUrl() ?? "",
            "seccion_id" => $seccionId,
            "seccion"    => ($seccionId !== null && isset($mapSecciones[$seccionId]))
                                ? $mapSecciones[$seccionId]
                                : null,
            "orden"      => (int) $c->getOrden()
        ];
    }

    echo json_encode([
        "status" => "success",
        "data"   => $data
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

} else {
    echo json_encode([
        "status"  => "error",
        "message" => "No se encontraron certificados"
    ], JSON_UNESCAPED_UNICODE);
}

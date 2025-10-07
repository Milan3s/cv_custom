<?php
require_once __DIR__ . "/../../config/Rutas.php";
require_once __DIR__ . "/../../controllers/EducacionController.php";

header("Content-Type: application/json");

$educacionController = new EducacionController();
$educacion = $educacionController->getAll();

if (!empty($educacion)) {
    $data = [];

    foreach ($educacion as $e) {
        $data[] = [
            "id"           => $e->getId(),
            "usuarioId"    => $e->getUsuarioId(),
            "centro"       => $e->getCentro(),
            "titulacion"   => $e->getTitulacion(),
            "ubicacion"    => $e->getUbicacion(),
            "fecha_inicio" => $e->getFechaInicio(),
            "fecha_fin"    => $e->getFechaFin(),
            "descripcion"  => $e->getDescripcion() ?? "",
            "seccion_id"   => $e->getSeccionId() ?? null,
            "orden"        => $e->getOrden()
        ];
    }

    echo json_encode([
        "status" => "success",
        "data"   => $data
    ]);
} else {
    echo json_encode([
        "status"  => "error",
        "message" => "No se encontraron registros de educación"
    ]);
}

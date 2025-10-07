<?php
require_once __DIR__ . "/../../config/Rutas.php";
require_once __DIR__ . "/../../controllers/ExperienciaController.php";

header("Content-Type: application/json");

$expController = new ExperienciaController();
$experiencias = $expController->getAll();

if (!empty($experiencias)) {
    $data = [];

    foreach ($experiencias as $exp) {
        $data[] = [
            "id"          => $exp->getId(),
            "usuario_id"  => $exp->getUsuarioId(),
            "empresa"     => $exp->getEmpresa(),
            "rol"         => $exp->getRol(),
            "ubicacion"   => $exp->getUbicacion(),
            "fecha_inicio"=> $exp->getFechaInicio(),
            "fecha_fin"   => $exp->getFechaFin(),
            "descripcion" => $exp->getDescripcion(),
            "seccion_id"  => $exp->getSeccionId(),
            "orden"       => $exp->getOrden(),
        ];
    }

    echo json_encode([
        "status" => "success",
        "data"   => $data
    ]);
} else {
    echo json_encode([
        "status"  => "error",
        "message" => "No se encontraron experiencias"
    ]);
}

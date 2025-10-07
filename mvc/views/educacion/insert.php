<?php
require_once __DIR__ . "/../../config/Rutas.php";
require_once __DIR__ . "/../../controllers/EducacionController.php";
require_once __DIR__ . "/../../models/EducacionModel.php";

header("Content-Type: application/json");

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode([
            "status"  => "error",
            "message" => "Método inválido"
        ]);
        exit;
    }

    // Recoger datos del formulario
    $titulacion   = $_POST['titulacion']   ?? null;
    $centro       = $_POST['centro']       ?? null;
    $ubicacion    = $_POST['ubicacion']    ?? null;
    $fecha_inicio = $_POST['fecha_inicio'] ?? null;
    $fecha_fin    = $_POST['fecha_fin']    ?? null;
    $orden        = $_POST['orden']        ?? null;

    if (!$titulacion || !$centro || !$ubicacion || !$fecha_inicio || !$fecha_fin) {
        echo json_encode([
            "status"  => "error",
            "message" => "Faltan campos obligatorios"
        ]);
        exit;
    }

    // Crear modelo
    $educacion = new EducacionModel();
    $educacion->setUsuarioId(1); // TODO: usar el usuario de sesión
    $educacion->setTitulacion($titulacion);
    $educacion->setCentro($centro);
    $educacion->setUbicacion($ubicacion);
    $educacion->setFechaInicio($fecha_inicio);
    $educacion->setFechaFin($fecha_fin);
    $educacion->setOrden($orden ?? 1);

    $controller = new EducacionController();
    $newId = $controller->create($educacion);

    if ($newId) {
        echo json_encode([
            "status" => "success",
            "id"     => $newId,
            "message"=> "Educación añadida correctamente"
        ]);
    } else {
        echo json_encode([
            "status"  => "error",
            "message" => "Error al insertar en la base de datos"
        ]);
    }

} catch (Exception $e) {
    echo json_encode([
        "status"  => "error",
        "message" => $e->getMessage()
    ]);
}

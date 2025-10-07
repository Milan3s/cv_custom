<?php
require_once __DIR__ . "/../../config/Rutas.php";
require_once __DIR__ . "/../../controllers/ExperienciaController.php";
require_once __DIR__ . "/../../models/ExperienciaModel.php";

header("Content-Type: application/json");

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(["status" => "error", "msg" => "Método no permitido"]);
        exit;
    }

    // Recoger datos del formulario
    $empresa      = $_POST['empresa'] ?? null;
    $rol          = $_POST['rol'] ?? null;
    $ubicacion    = $_POST['ubicacion'] ?? null;
    $fecha_inicio = $_POST['fecha_inicio'] ?? null;
    $fecha_fin    = $_POST['fecha_fin'] ?? null;
    $descripcion  = $_POST['descripcion'] ?? null;
    $seccion_id   = $_POST['seccion_id'] ?? 1; // por defecto sección 1
    $orden        = $_POST['orden'] ?? 1;

    // Validaciones mínimas
    if (!$empresa || !$rol || !$fecha_inicio || !$fecha_fin) {
        echo json_encode(["status" => "error", "msg" => "Campos obligatorios faltantes"]);
        exit;
    }

    // Crear modelo
    $exp = new ExperienciaModel();
    $exp->setUsuarioId(1); // TODO: cambiar por $_SESSION['usuario_id']
    $exp->setEmpresa($empresa);
    $exp->setRol($rol);
    $exp->setUbicacion($ubicacion);
    $exp->setFechaInicio($fecha_inicio);
    $exp->setFechaFin($fecha_fin);
    $exp->setDescripcion($descripcion);
    $exp->setSeccionId($seccion_id);
    $exp->setOrden($orden);

    $controller = new ExperienciaController();
    $result = $controller->create($exp);

    echo json_encode([
        "status" => $result ? "success" : "error",
        "id" => $result // si create() retorna el ID insertado
    ]);

} catch (Exception $e) {
    echo json_encode(["status" => "error", "msg" => $e->getMessage()]);
}

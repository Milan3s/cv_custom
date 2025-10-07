<?php
require_once __DIR__ . "/../../config/Rutas.php";
require_once __DIR__ . "/../../controllers/ExperienciaController.php";

header("Content-Type: application/json");

// Solo permitir POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "status"  => "error",
        "message" => "Método no permitido"
    ]);
    exit;
}

// Recibir datos (pueden venir en JSON o formulario normal)
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    $data = $_POST; // fallback por si viene como form-data
}

if (empty($data['id'])) {
    echo json_encode([
        "status"  => "error",
        "message" => "ID de experiencia no especificado"
    ]);
    exit;
}

try {
    $id = intval($data['id']);
    $expController = new ExperienciaController();

    $result = $expController->delete($id);

    if ($result) {
        echo json_encode([
            "status"  => "success",
            "message" => "Experiencia eliminada correctamente"
        ]);
    } else {
        echo json_encode([
            "status"  => "error",
            "message" => "No se pudo eliminar la experiencia"
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        "status"  => "error",
        "message" => $e->getMessage()
    ]);
}

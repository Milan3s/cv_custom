<?php
require_once __DIR__ . "/../../config/Rutas.php";
require_once __DIR__ . "/../../controllers/ExperienciaController.php";

header("Content-Type: application/json");

// Solo permitir POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Método no permitido"]);
    exit;
}

// Obtener datos del cuerpo (JSON)
$data = json_decode(file_get_contents("php://input"), true);

if (!$data || empty($data['id'])) {
    echo json_encode(["status" => "error", "message" => "ID de experiencia no especificado"]);
    exit;
}

try {
    $id = $data['id'];
    unset($data['id']); // 👈 quitamos id para no intentar actualizarlo

    $expController = new ExperienciaController();
    $result = $expController->update($id, $data);

    if ($result) {
        echo json_encode([
            "status"  => "success",
            "message" => "Experiencia actualizada correctamente"
        ]);
    } else {
        echo json_encode([
            "status"  => "error",
            "message" => "No se pudo actualizar la experiencia"
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        "status"  => "error",
        "message" => $e->getMessage()
    ]);
}

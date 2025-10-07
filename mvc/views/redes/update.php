<?php
require_once __DIR__ . "/../../config/Rutas.php";
require_once __DIR__ . "/../../controllers/RedesController.php";

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Método no permitido"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || empty($data['id'])) {
    echo json_encode(["status" => "error", "message" => "ID de la red social no especificado"]);
    exit;
}

try {
    $id = $data['id'];
    unset($data['id']); // 👈 quitar ID para no intentar actualizarlo

    $controller = new RedesController();
    $ok = $controller->update($id, $data);

    if ($ok) {
        echo json_encode(["status" => "success"]);
    } else {
        // aunque no cambien los datos, lo tratamos como success
        echo json_encode(["status" => "success", "message" => "Sin cambios"]);
    }
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}

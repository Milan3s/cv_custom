<?php
require_once __DIR__ . "/../../config/Rutas.php";
require_once __DIR__ . "/../../controllers/RedesController.php";

header("Content-Type: application/json");

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(["status" => "error"]);
        exit;
    }

    $id = $_POST['red_id'] ?? null;
    if (!$id) {
        echo json_encode(["status" => "error"]);
        exit;
    }

    $controller = new RedesController();
    $result = $controller->delete($id);

    if ($result) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error"]);
    }
} catch (Exception $e) {
    echo json_encode(["status" => "error"]);
}

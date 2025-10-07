<?php
require_once __DIR__ . "/../../config/Rutas.php";
require_once __DIR__ . "/../../controllers/SeccionController.php";

header("Content-Type: application/json; charset=UTF-8");

try {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        echo json_encode(["status" => "error", "message" => "Método no permitido"]);
        exit;
    }

    $id = $_POST["id"] ?? null;
    if (!$id) {
        echo json_encode(["status" => "error", "message" => "ID inválido"]);
        exit;
    }

    $controller = new SeccionController();
    $result = $controller->eliminarSeccion((int)$id);

    if ($result) {
        echo json_encode(["status" => "success", "message" => "Sección eliminada correctamente"]);
    } else {
        echo json_encode(["status" => "error", "message" => "No se pudo eliminar la sección"]);
    }
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}

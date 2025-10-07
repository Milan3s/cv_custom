<?php
require_once __DIR__ . "/../../config/Rutas.php";
require_once __DIR__ . "/../../controllers/AliasController.php";

header("Content-Type: application/json");

try {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        echo json_encode(["status" => "error", "message" => "Método no permitido"]);
        exit;
    }

    $aliasController = new AliasController();
    $result = $aliasController->eliminarPerfil(1); // ⚡ Usuario fijo por ahora

    if ($result) {
        echo json_encode(["status" => "success", "message" => "Perfil eliminado correctamente"]);
    } else {
        echo json_encode(["status" => "error", "message" => "No se pudo eliminar el perfil"]);
    }

} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}

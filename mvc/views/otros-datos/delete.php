<?php
require_once __DIR__ . "/../../config/Rutas.php";
require_once __DIR__ . "/../../controllers/OtrosDatosController.php";

header("Content-Type: application/json");

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode([
            "status"  => "error",
            "message" => "Método no permitido"
        ]);
        exit;
    }

    // Validar ID recibido
    $id = $_POST['otros_id'] ?? null;
    if (empty($id)) {
        echo json_encode([
            "status"  => "error",
            "message" => "ID de dato de interés no proporcionado"
        ]);
        exit;
    }

    // Ejecutar eliminación
    $controller = new OtrosDatosController();
    $result = $controller->delete($id);

    echo json_encode([
        "status"  => $result ? "success" : "error",
        "message" => $result 
            ? "Dato de interés eliminado correctamente" 
            : "No se pudo eliminar el dato de interés"
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status"  => "error",
        "message" => "Error en el servidor: " . $e->getMessage()
    ]);
}

<?php
require_once __DIR__ . "/../../config/Rutas.php";
require_once __DIR__ . "/../../controllers/HabilidadController.php";

header("Content-Type: application/json");

try {
    // Solo permitimos POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode([
            "status"  => "error",
            "message" => "Método no permitido"
        ]);
        exit;
    }

    // Validar ID recibido
    $id = $_POST['habilidad_id'] ?? null;
    if (empty($id)) {
        echo json_encode([
            "status"  => "error",
            "message" => "⚠ ID de habilidad no proporcionado"
        ]);
        exit;
    }

    // Ejecutar eliminación
    $controller = new HabilidadController();
    $result = $controller->delete($id);

    echo json_encode([
        "status"  => $result ? "success" : "error",
        "message" => $result 
            ? "✅ Habilidad eliminada correctamente" 
            : "❌ No se pudo eliminar la habilidad"
    ]);

} catch (Exception $e) {
    echo json_encode([
        "status"  => "error",
        "message" => "⚠ Error en el servidor: " . $e->getMessage()
    ]);
}

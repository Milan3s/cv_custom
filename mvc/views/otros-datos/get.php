<?php
require_once __DIR__ . "/../../config/Rutas.php";
require_once __DIR__ . "/../../controllers/OtrosDatosController.php";

header("Content-Type: application/json; charset=utf-8");

try {
    $otrosDatosController = new OtrosDatosController();

    // 🔹 Filtrar por usuario logueado (ajusta según cómo guardes la sesión)
    $usuario_id = $_SESSION['usuario_id'] ?? null;
    $otrosDatos = $otrosDatosController->getAll($usuario_id);

    $data = [];
    if (!empty($otrosDatos)) {
        foreach ($otrosDatos as $od) {
            $data[] = [
                "id"          => (int) $od->getId(),
                "usuario_id"  => (int) $od->getUsuarioId(),
                "titulo"      => $od->getTitulo(),
                "descripcion" => $od->getDescripcion() ?? "",
                "orden"       => (int) $od->getOrden()
            ];
        }
    }

    echo json_encode([
        "status" => "success",
        "data"   => $data
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

} catch (Exception $e) {
    echo json_encode([
        "status"  => "error",
        "message" => "⚠ Error en el servidor: " . $e->getMessage(),
        "data"    => []
    ], JSON_UNESCAPED_UNICODE);
}

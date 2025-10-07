<?php
require_once __DIR__ . "/../../config/Rutas.php";
require_once __DIR__ . "/../../controllers/HabilidadController.php";

header("Content-Type: application/json");
session_start();

/**
 * Función auxiliar para loguear en log.txt
 */
function logDebug($mensaje, $data = null) {
    $rutaLog = __DIR__ . "/log.txt";
    $fecha   = date("Y-m-d H:i:s");
    $contenido = "[$fecha] $mensaje";
    if ($data !== null) {
        $contenido .= " → " . print_r($data, true);
    }
    $contenido .= "\n";
    file_put_contents($rutaLog, $contenido, FILE_APPEND);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "status"  => "error",
        "message" => "Método no permitido"
    ]);
    logDebug("update.php → método no permitido", $_SERVER['REQUEST_METHOD']);
    exit;
}

// Recibir datos JSON
$data = json_decode(file_get_contents("php://input"), true);
logDebug("update.php → datos recibidos", $data);

$id          = isset($data['id']) ? (int)$data['id'] : null;
$nombre      = !empty($data['nombre']) ? trim($data['nombre']) : null;
$tipo        = !empty($data['tipo']) ? trim($data['tipo']) : null;
$descripcion = isset($data['descripcion']) ? trim($data['descripcion']) : null;

// 🔹 Manejo seguro de orden y seccion_id
$orden      = isset($data['orden']) && $data['orden'] !== "" ? (int)$data['orden'] : null;
$seccion_id = isset($data['seccion_id']) && $data['seccion_id'] !== "" ? (int)$data['seccion_id'] : null;

// ⚠️ Usuario real desde la sesión
$usuario_id = $_SESSION['usuario_id'] ?? 1;

if (!$id) {
    echo json_encode([
        "status"  => "error",
        "message" => "ID de habilidad requerido"
    ]);
    logDebug("update.php → error: ID de habilidad requerido");
    exit;
}

try {
    $habilidadController = new HabilidadController();
    $payload = [
        "usuario_id"  => $usuario_id,
        "nombre"      => $nombre,
        "tipo"        => $tipo,
        "descripcion" => $descripcion,
        "seccion_id"  => $seccion_id,
        "orden"       => $orden
    ];
    logDebug("update.php → payload enviado a update()", $payload);

    $result = $habilidadController->update($id, $payload);

    echo json_encode([
        "status"  => $result ? "success" : "error",
        "message" => $result 
            ? "✅ Habilidad actualizada correctamente" 
            : "❌ No se pudo actualizar la habilidad"
    ]);

    logDebug("update.php → resultado", ["id"=>$id, "success"=>$result]);

} catch (Exception $e) {
    echo json_encode([
        "status"  => "error",
        "message" => "⚠ Error en el servidor: " . $e->getMessage()
    ]);
    logDebug("update.php → excepción", $e->getMessage());
}

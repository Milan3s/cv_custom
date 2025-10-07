<?php
require_once __DIR__ . "/../../config/Rutas.php";
require_once __DIR__ . "/../../controllers/OtrosDatosController.php";

header("Content-Type: application/json; charset=utf-8");

/**
 * Función auxiliar para loguear en log.txt (DEBUG)
 * 
 * 🔴 Actualmente está comentada para no escribir logs en producción.
 * Descomenta si necesitas depurar el flujo de datos.
 */
/*
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
*/

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "status"  => "error",
        "message" => "Método no permitido"
    ]);
    // logDebug("update.php → método no permitido", $_SERVER['REQUEST_METHOD']);
    exit;
}

// Recibir datos JSON
$data = json_decode(file_get_contents("php://input"), true);
// logDebug("update.php → datos recibidos", $data);

$id          = isset($data['id']) ? (int)$data['id'] : null;
$titulo      = isset($data['titulo']) ? trim($data['titulo']) : null;
$descripcion = isset($data['descripcion']) ? trim($data['descripcion']) : null;
$orden       = isset($data['orden']) && $data['orden'] !== "" ? (int)$data['orden'] : null;
$seccion_id  = isset($data['seccion_id']) && $data['seccion_id'] !== "" ? (int)$data['seccion_id'] : null;

// Usuario: igual que en insert → se pasa en JSON o default=1
$usuario_id  = isset($data['usuario_id']) ? (int)$data['usuario_id'] : 1;

// Validación mínima: ID obligatorio
if (!$id) {
    echo json_encode([
        "status"  => "error",
        "message" => "ID requerido para actualizar"
    ]);
    // logDebug("update.php → error: ID requerido");
    exit;
}

try {
    $controller = new OtrosDatosController();

    $payload = [
        "usuario_id"  => $usuario_id,
        "titulo"      => $titulo,
        "descripcion" => $descripcion,
        "seccion_id"  => $seccion_id,
        "orden"       => $orden
    ];

    // logDebug("update.php → payload enviado a update()", $payload);

    $result = $controller->update($id, $payload);

    echo json_encode([
        "status"  => $result ? "success" : "error",
        "message" => $result 
            ? "✅ Dato de interés actualizado correctamente"
            : "❌ No se pudo actualizar el dato"
    ]);
    // logDebug("update.php → resultado", ["id"=>$id, "success"=>$result]);

} catch (Exception $e) {
    echo json_encode([
        "status"  => "error",
        "message" => "⚠ Error en el servidor: " . $e->getMessage()
    ]);
    // logDebug("update.php → excepción", $e->getMessage());
}

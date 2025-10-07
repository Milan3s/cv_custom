<?php
require_once __DIR__ . "/../../config/Rutas.php";
require_once __DIR__ . "/../../controllers/HabilidadController.php";
require_once __DIR__ . "/../../models/HabilidadModel.php";

header("Content-Type: application/json");
session_start();

/* ==============================
   Función de logging (DEBUG) 
   Descomentar si se necesita
=================================
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

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode([
            "status"  => "error",
            "message" => "Método inválido"
        ]);
        exit;
    }

    // Recoger datos del formulario
    $tipo        = $_POST['tipo']        ?? null;
    $nombre      = $_POST['nombre']      ?? null;
    $descripcion = $_POST['descripcion'] ?? null;

    // 🔹 Orden: si viene vacío lo dejamos null, si no lo casteamos a int
    $orden       = (isset($_POST['orden']) && $_POST['orden'] !== "")
                    ? (int)$_POST['orden']
                    : null;

    // 🔹 Sección: igual, aseguramos null o int
    $seccion_id  = (isset($_POST['seccion_id']) && $_POST['seccion_id'] !== "")
                    ? (int)$_POST['seccion_id']
                    : null;

    // logDebug("insert.php → datos recibidos", $_POST);

    if (!$tipo || !$nombre) {
        echo json_encode([
            "status"  => "error",
            "message" => "Faltan campos obligatorios (tipo y nombre)"
        ]);
        // logDebug("insert.php → error faltan campos obligatorios", ["tipo"=>$tipo,"nombre"=>$nombre]);
        exit;
    }

    // Crear modelo
    $habilidad = new HabilidadModel();
    $habilidad->setUsuarioId($_SESSION['usuario_id'] ?? 1); // 🔹 Usa el usuario en sesión si existe
    $habilidad->setTipo($tipo);
    $habilidad->setNombre($nombre);
    $habilidad->setDescripcion($descripcion);
    $habilidad->setOrden($orden);
    $habilidad->setSeccionId($seccion_id);

    $controller = new HabilidadController();
    $result = $controller->create([
        "usuario_id"  => $habilidad->getUsuarioId(),
        "tipo"        => $habilidad->getTipo(),
        "nombre"      => $habilidad->getNombre(),
        "descripcion" => $habilidad->getDescripcion(),
        "seccion_id"  => $habilidad->getSeccionId(),
        "orden"       => $habilidad->getOrden()
    ]);

    if ($result) {
        echo json_encode([
            "status"  => "success",
            "message" => "✅ Habilidad añadida correctamente"
        ]);
        // logDebug("insert.php → éxito al insertar", [
        //     "nombre" => $nombre,
        //     "tipo"   => $tipo,
        //     "orden"  => $orden,
        //     "seccion_id" => $seccion_id
        // ]);
    } else {
        echo json_encode([
            "status"  => "error",
            "message" => "❌ Error al insertar en la base de datos"
        ]);
        // logDebug("insert.php → fallo en create()", $_POST);
    }

} catch (Exception $e) {
    echo json_encode([
        "status"  => "error",
        "message" => "⚠ " . $e->getMessage()
    ]);
    // logDebug("insert.php → excepción", $e->getMessage());
}

<?php
require_once __DIR__ . "/../../config/Rutas.php";
require_once __DIR__ . "/../../controllers/HabilidadController.php";
require_once __DIR__ . "/../../controllers/SeccionController.php";

header("Content-Type: application/json");

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

$habilidadController = new HabilidadController();
$habilidades = $habilidadController->getAll();

$seccionController = new SeccionController();
$secciones = $seccionController->getSecciones();
$mapSecciones = [];
foreach ($secciones as $s) {
    $mapSecciones[$s->getId()] = $s->getTitulo();
}

$data = [];
if (!empty($habilidades)) {
    foreach ($habilidades as $h) {
        $data[] = [
            "id"          => $h->getId(),
            "usuario_id"  => $h->getUsuarioId(),
            "tipo"        => $h->getTipo(),
            "nombre"      => $h->getNombre(),
            "descripcion" => $h->getDescripcion(),
            "seccion_id"  => $h->getSeccionId(),
            "seccion"     => $h->getSeccionId() !== null && isset($mapSecciones[$h->getSeccionId()])
                                ? $mapSecciones[$h->getSeccionId()]
                                : null,
            "orden"       => $h->getOrden()
        ];
    }

    // 🔎 DEBUG (descomentar si hace falta)
    // logDebug("GET.php → datos enviados al cliente", $data);

    echo json_encode([
        "status" => "success",
        "data"   => $data
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

} else {
    echo json_encode([
        "status"  => "error",
        "message" => "No se encontraron habilidades"
    ]);
}

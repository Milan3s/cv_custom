<?php
require_once __DIR__ . "/../../config/Rutas.php";
require_once __DIR__ . "/../../controllers/CertificadoController.php";
require_once __DIR__ . "/../../models/CertificadoModel.php";

header("Content-Type: application/json");

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode([
            "status"  => "error",
            "message" => "Método inválido"
        ]);
        exit;
    }

    // Recoger datos del formulario
    $titulo     = $_POST['titulo']     ?? null;
    $entidad    = $_POST['entidad']    ?? null;
    $fecha      = $_POST['fecha']      ?? null;
    $url        = !empty($_POST['url']) ? $_POST['url'] : null;
    $seccion_id = !empty($_POST['seccion_id']) ? (int) $_POST['seccion_id'] : null;
    $orden      = $_POST['orden']      ?? 1;

    // Validar obligatorios
    if (!$titulo || !$entidad || !$fecha) {
        echo json_encode([
            "status"  => "error",
            "message" => "Faltan campos obligatorios (título, entidad y fecha)"
        ]);
        exit;
    }

    // Crear modelo
    $certificado = new CertificadoModel();
    $certificado->setUsuarioId(1); // TODO: usar usuario de sesión real
    $certificado->setTitulo($titulo);
    $certificado->setEntidad($entidad);
    $certificado->setFecha($fecha);
    $certificado->setUrl($url);
    $certificado->setSeccionId($seccion_id);
    $certificado->setOrden($orden);

    // Usar el controlador
    $controller = new CertificadoController();
    $newId = $controller->create($certificado);

    if ($newId) {
        echo json_encode([
            "status"  => "success",
            "id"      => (int) $newId,
            "message" => "✅ Certificado añadido correctamente"
        ]);
    } else {
        echo json_encode([
            "status"  => "error",
            "message" => "❌ Error al insertar en la base de datos"
        ]);
    }

} catch (Exception $e) {
    echo json_encode([
        "status"  => "error",
        "message" => "⚠ " . $e->getMessage()
    ]);
}

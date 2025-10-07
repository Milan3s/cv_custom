<?php
require_once __DIR__ . "/../../config/Rutas.php";
require_once __DIR__ . "/../../controllers/OtrosDatosController.php";
require_once __DIR__ . "/../../models/OtrosDatosModel.php";

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
    $titulo      = $_POST['titulo']      ?? null;
    $descripcion = $_POST['descripcion'] ?? null;
    $orden       = $_POST['orden']       ?? 1;
    $seccion_id  = $_POST['seccion_id']  ?? 6; // ⚠️ si siempre va a la sección 6

    if (!$titulo) {
        echo json_encode([
            "status"  => "error",
            "message" => "El campo título es obligatorio"
        ]);
        exit;
    }

    // Crear modelo
    $dato = new OtrosDatosModel(
        null,
        1, // TODO: reemplazar con usuario real de sesión
        $titulo,
        $descripcion,
        $seccion_id,
        $orden
    );

    // Insertar en BD
    $controller = new OtrosDatosController();
    $result = $controller->create(
        $dato->getUsuarioId(),
        $dato->getTitulo(),
        $dato->getDescripcion(),
        $dato->getSeccionId(),
        $dato->getOrden()
    );

    if ($result) {
        echo json_encode([
            "status"  => "success",
            "message" => "✅ Dato de interés añadido correctamente"
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

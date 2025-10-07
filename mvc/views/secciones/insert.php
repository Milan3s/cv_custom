<?php
require_once __DIR__ . "/../../config/Rutas.php";
require_once __DIR__ . "/../../controllers/SeccionController.php";
require_once __DIR__ . "/../../models/SeccionModel.php";

header("Content-Type: application/json; charset=UTF-8");

try {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        echo json_encode(["status" => "error", "message" => "Método no permitido"]);
        exit;
    }

    $datos = [
        "nombre"  => $_POST["nombre"] ?? "",
        "titulo"  => $_POST["titulo"] ?? "",
        "columna" => $_POST["columna"] ?? "izquierda",
        "icono"   => $_POST["icono"] ?? "",
        "orden"   => $_POST["orden"] ?? 1
    ];

    if (empty($datos["nombre"]) || empty($datos["titulo"])) {
        echo json_encode(["status" => "error", "message" => "Faltan campos obligatorios"]);
        exit;
    }

    $controller = new SeccionController();
    $result = $controller->crearSeccion($datos, 1);

    if ($result) {
        echo json_encode(["status" => "success", "message" => "Sección creada correctamente"]);
    } else {
        echo json_encode(["status" => "error", "message" => "No se pudo crear la sección"]);
    }
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}

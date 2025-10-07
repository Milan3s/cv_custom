<?php
require_once __DIR__ . "/../../config/Rutas.php";
require_once __DIR__ . "/../../controllers/SeccionController.php";

header("Content-Type: application/json; charset=UTF-8");

try {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        echo json_encode(["status" => "error", "message" => "Método no permitido"]);
        exit;
    }

    $id = $_POST["id"] ?? null;
    if (!$id) {
        echo json_encode(["status" => "error", "message" => "ID inválido"]);
        exit;
    }

    $datos = [];
    if (isset($_POST["titulo"]))  $datos["titulo"]  = $_POST["titulo"];
    if (isset($_POST["columna"])) $datos["columna"] = $_POST["columna"];
    if (isset($_POST["icono"]))   $datos["icono"]   = $_POST["icono"];
    if (isset($_POST["orden"]))   $datos["orden"]   = $_POST["orden"];

    $controller = new SeccionController();
    $result = $controller->actualizarSeccion($id, $datos);

    if ($result) {
        echo json_encode(["status" => "success", "message" => "Sección actualizada correctamente"]);
    } else {
        echo json_encode(["status" => "error", "message" => "No se pudo actualizar la sección"]);
    }
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}

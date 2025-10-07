<?php
require_once __DIR__ . "/../../config/Rutas.php";
require_once __DIR__ . "/../../controllers/EducacionController.php";

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || empty($data['id'])) {
    echo json_encode(["status" => "error"]);
    exit;
}

try {
    $id = $data['id'];
    unset($data['id']); // no se actualiza el id

    // 🔹 Caso especial: centro + ubicación unificados
    if (isset($data['centro_ubicacion'])) {
        $valor = trim($data['centro_ubicacion']);

        // Separar en centro y ubicación usando el guion como separador
        $partes = explode("-", $valor, 2);
        $centro = trim($partes[0]);
        $ubicacion = isset($partes[1]) ? trim($partes[1]) : "";

        // Reemplazar en $data
        unset($data['centro_ubicacion']);
        $data['centro'] = $centro;
        $data['ubicacion'] = $ubicacion;
    }

    $educacionController = new EducacionController();
    $result = $educacionController->update($id, $data);

    echo json_encode(["status" => $result ? "success" : "error"]);

} catch (Exception $e) {
    echo json_encode(["status" => "error"]);
}

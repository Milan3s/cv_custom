<?php
require_once __DIR__ . "/../../config/Rutas.php";
require_once __DIR__ . "/../../controllers/AliasController.php";

header("Content-Type: application/json");

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(["status" => "error", "message" => "Método no permitido"]);
        exit;
    }

    $aliasController = new AliasController();
    $data = $_POST;

    // 📸 Si viene la foto
    if (!empty($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $foto = $_FILES['foto'];
        $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif'];
        $extension = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));

        if (!in_array($extension, $extensionesPermitidas)) {
            echo json_encode(["status" => "error", "message" => "Formato de imagen no permitido"]);
            exit;
        }

        $nuevoNombre = "perfil_" . time() . "." . $extension;
        $rutaDestino = IMG_PATH . $nuevoNombre;

        if (move_uploaded_file($foto['tmp_name'], $rutaDestino)) {
            $data['foto'] = $nuevoNombre;
        } else {
            echo json_encode(["status" => "error", "message" => "No se pudo subir la foto"]);
            exit;
        }
    }

    // ⚡ Insertar perfil
    $result = $aliasController->crearPerfil($data);

    echo json_encode([
        "status"  => $result ? "success" : "error",
        "message" => $result ? "Perfil insertado correctamente" : "No se pudo insertar el perfil"
    ]);

} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}

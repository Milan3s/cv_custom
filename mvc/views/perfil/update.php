<?php
require_once __DIR__ . "/../../config/Rutas.php";
require_once __DIR__ . "/../../controllers/AliasController.php";

header("Content-Type: application/json");

$aliasController = new AliasController();

try {
    /* ==============================
       📌 Caso 1 → Subida de foto
    ============================== */
    if (!empty($_FILES['foto'])) {
        $foto = $_FILES['foto'];

        $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif'];
        $extension = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));
        if (!in_array($extension, $extensionesPermitidas)) {
            echo json_encode([
                "status" => "error",
                "message" => "Formato de archivo no permitido"
            ]);
            exit;
        }

        $nuevoNombre = "perfil_" . time() . "." . $extension;
        $rutaDestino = IMG_PATH . $nuevoNombre;

        if (move_uploaded_file($foto['tmp_name'], $rutaDestino)) {
            if (method_exists($aliasController, "actualizarPerfil")) {
                $result = $aliasController->actualizarPerfil(["foto" => $nuevoNombre]);
            } else {
                throw new Exception("El método actualizarPerfil no está definido en AliasController");
            }

            echo json_encode([
                "status"  => $result ? "success" : "error",
                "message" => $result ? "Foto actualizada correctamente" : "Error al actualizar la foto en la BD",
                "foto"    => $result ? $nuevoNombre : null
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "No se pudo subir la foto"
            ]);
        }
        exit;
    }

    /* ==============================
       📌 Caso 2 → Datos de perfil
    ============================== */
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(["status" => "error", "message" => "Método no permitido"]);
        exit;
    }

    $data = !empty($_POST) ? $_POST : json_decode(file_get_contents("php://input"), true);

    if (!is_array($data)) {
        echo json_encode(["status" => "error", "message" => "No se recibieron datos"]);
        exit;
    }

    $permitidos = [
        "alias", "profesion", "bio",
        "email", "telefono", "direccion", "sitio_web",
        "icono_email", "icono_telefono", "icono_direccion", "foto"
    ];

    $dataFiltrada = [];
    foreach ($permitidos as $campo) {
        if (array_key_exists($campo, $data)) {
            $dataFiltrada[$campo] = $data[$campo];
        }
    }

    if (empty($dataFiltrada)) {
        echo json_encode(["status" => "error", "message" => "No se enviaron campos válidos"]);
        exit;
    }

    // ⚡ Actualización dinámica
    $result = $aliasController->actualizarPerfil($dataFiltrada);

    echo json_encode([
        "status"  => $result ? "success" : "error",
        "message" => $result ? "Perfil actualizado correctamente" : "Error al actualizar perfil"
    ]);

} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}

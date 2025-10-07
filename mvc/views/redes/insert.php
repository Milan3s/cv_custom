<?php
require_once __DIR__ . "/../../config/Rutas.php";
require_once __DIR__ . "/../../controllers/RedesController.php";
require_once __DIR__ . "/../../models/RedesModel.php";

header("Content-Type: application/json");

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(["status" => "error", "message" => "Método no permitido"]);
        exit;
    }

    // Recoger datos del formulario
    $plataforma = $_POST['plataforma'] ?? null;
    $usuario    = $_POST['usuario'] ?? null;
    $url        = $_POST['url'] ?? null;
    $icono      = $_POST['icono'] ?? null;
    $orden      = $_POST['orden'] ?? 1;
    $visible    = 1; // por defecto visible

    if (!$plataforma || !$usuario || !$url) {
        echo json_encode(["status" => "error", "message" => "Faltan campos obligatorios"]);
        exit;
    }

    // Crear modelo
    $red = new RedesModel();
    $red->setUsuarioId(1); // Usuario fijo (o dinámico si tienes login)
    $red->setPlataforma($plataforma);
    $red->setUsuario($usuario);
    $red->setUrl($url);
    $red->setIcono($icono);
    $red->setOrden($orden);
    $red->setVisible($visible);

    $controller = new RedesController();
    $id = $controller->create($red);

    if ($id) {
        echo json_encode([
            "status" => "success",
            "message" => "Red social insertada correctamente",
            "id" => $id
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "No se pudo insertar la red social"]);
    }

} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}

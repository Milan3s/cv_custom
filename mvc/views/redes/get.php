<?php
require_once __DIR__ . "/../../config/Rutas.php";
require_once __DIR__ . "/../../controllers/RedesController.php";

header("Content-Type: application/json; charset=UTF-8");

$redesController = new RedesController();

try {
    // 📌 Caso 1: obtener una red concreta
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id  = intval($_GET['id']);
        $red = $redesController->getById($id);

        if ($red) {
            echo json_encode([
                "status"     => "success",
                "id"         => $red->getId(),
                "usuarioId"  => $red->getUsuarioId(),
                "plataforma" => $red->getPlataforma(),
                "url"        => $red->getUrl(),
                "usuario"    => $red->getUsuario(),
                "icono"      => $red->getIcono(),
                "orden"      => $red->getOrden(),
                "visible"    => $red->getVisible()
            ]);
        } else {
            echo json_encode([
                "status"  => "error",
                "message" => "Red social no encontrada"
            ]);
        }
        exit;
    }

    // 📌 Caso 2: obtener todas las redes
    $redes = $redesController->getAll();

    if (!empty($redes)) {
        $data = [];

        foreach ($redes as $r) {
            $data[] = [
                "id"         => $r->getId(),
                "usuarioId"  => $r->getUsuarioId(),
                "plataforma" => $r->getPlataforma(),
                "url"        => $r->getUrl(),
                "usuario"    => $r->getUsuario(),
                "icono"      => $r->getIcono(),
                "orden"      => $r->getOrden(),
                "visible"    => $r->getVisible()
            ];
        }

        echo json_encode([
            "status" => "success",
            "data"   => $data
        ]);
    } else {
        echo json_encode([
            "status"  => "error",
            "message" => "No se encontraron redes sociales"
        ]);
    }

} catch (Exception $e) {
    echo json_encode([
        "status"  => "error",
        "message" => $e->getMessage()
    ]);
}

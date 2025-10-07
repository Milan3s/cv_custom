<?php
require_once __DIR__ . "/../../config/Rutas.php";
require_once __DIR__ . "/../../controllers/SeccionController.php";

header("Content-Type: application/json; charset=UTF-8");

$controller = new SeccionController();

try {
    if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
        $seccion = $controller->getSeccionById((int)$_GET["id"]);
        if ($seccion) {
            echo json_encode([
                "status" => "success",
                "data"   => [
                    "id"       => $seccion->getId(),
                    "nombre"   => $seccion->getNombre(),
                    "titulo"   => $seccion->getTitulo(),
                    "columna"  => $seccion->getColumna(),
                    "icono"    => $seccion->getIcono(),
                    "orden"    => $seccion->getOrden(),
                    "creadoEn" => $seccion->getCreadoEn()
                ]
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => "Sección no encontrada"]);
        }
        exit;
    }

    $secciones = $controller->getSecciones(1);
    $data = [];

    foreach ($secciones as $s) {
        $data[] = [
            "id"       => $s->getId(),
            "nombre"   => $s->getNombre(),
            "titulo"   => $s->getTitulo(),
            "columna"  => $s->getColumna(),
            "icono"    => $s->getIcono(),
            "orden"    => $s->getOrden(),
            "creadoEn" => $s->getCreadoEn()
        ];
    }

    echo json_encode(["status" => "success", "data" => $data]);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}

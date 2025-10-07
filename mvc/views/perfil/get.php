<?php
require_once __DIR__ . "/../../config/Rutas.php";
require_once __DIR__ . "/../../controllers/AliasController.php";

header("Content-Type: application/json; charset=UTF-8");

try {
    $aliasController = new AliasController();
    $usuario = $aliasController->getPerfil(); // 👈 cambiamos aquí

    if ($usuario) {
        echo json_encode([
            "status" => "success",
            "data" => [
                "alias"            => $usuario->getAlias(),
                "profesion"        => $usuario->getProfesion(),
                "bio"              => $usuario->getBio(),
                "email"            => $usuario->getEmail(),
                "telefono"         => $usuario->getTelefono(),
                "direccion"        => $usuario->getDireccion(),
                "sitio_web"        => $usuario->getSitioWeb(),
                "foto"             => $usuario->getFoto(),
                "icono_email"      => $usuario->getIconoEmail(),
                "icono_telefono"   => $usuario->getIconoTelefono(),
                "icono_direccion"  => $usuario->getIconoDireccion(),
            ]
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "No se encontró perfil"
        ]);
    }
} catch (Throwable $e) {
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}

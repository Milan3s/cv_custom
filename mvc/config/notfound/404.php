<?php
require_once __DIR__ . "/../Rutas.php";
http_response_code(404); // Cabecera HTTP
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 404 - Página no encontrada</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/styles.css">
    <script src="https://kit.fontawesome.com/yourkit.js" crossorigin="anonymous"></script>
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">

    <div class="text-center">
        <h1 class="display-1 text-danger fw-bold">
            <i class="fas fa-exclamation-triangle"></i> 404
        </h1>
        <h2 class="mb-3">¡Oops! Esta página no existe</h2>
        <p class="text-muted">La URL que intentaste acceder no existe o fue movida.</p>
        <a href="<?= BASE_URL ?>index.php" class="btn btn-primary mt-3">
            <i class="fas fa-home"></i> Volver al inicio
        </a>
    </div>

</body>
</html>

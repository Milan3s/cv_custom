<?php
require_once __DIR__ . "/../config/Rutas.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include BASE_PATH . "partials/header.php"; ?>
    <title>Acceso Restringido</title>
    <style>
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
        }
        .restricted-box {
            max-width: 500px;
        }
    </style>
</head>
<body>

    <div class="restricted-box text-center">
        <div class="alert alert-warning shadow-sm p-4" role="alert">
            <h2 class="mb-3">
                <i class="fas fa-lock"></i> ¡Oops!
            </h2>
            <p class="lead">Este área está restringida.<br> Solo para usuarios registrados.</p>
            <a href="<?= BASE_URL ?>views/acceder/login.php" class="btn btn-primary mt-3">
                <i class="fas fa-sign-in-alt"></i> Ir al Login
            </a>
        </div>
    </div>

</body>
</html>

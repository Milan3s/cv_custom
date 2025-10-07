<?php
session_start();
session_destroy();

require_once __DIR__ . "/../../config/Rutas.php";

// Redirige correctamente al login dentro de mvc/views/acceder/
header("Location: " . BASE_URL . "mvc/views/acceder/login.php");
exit;
?>

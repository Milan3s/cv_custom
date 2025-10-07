<?php
// Detectar entorno automáticamente
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";

// =========================
// CONFIGURACIÓN SEGÚN ENTORNO
// =========================
if (strpos($host, 'localhost') !== false) {
    // 🔹 Entorno local
    define("BASE_URL", $https . "localhost/cv_custom/");
} else {
    // 🔹 Entorno de producción (alias Apache /curriculum/)
    define("BASE_URL", "https://dmilanes.es/curriculum/");
}

// =========================
// RUTAS BASE DEL SISTEMA
// =========================
define("BASE_PATH", __DIR__ . "/../");
define("IMG_URL", BASE_URL . "assets/img/");
define("IMG_PATH", realpath(__DIR__ . "/../../assets/img/") . "/");
define("DASHBOARD_URL", BASE_URL . "mvc/index.php");

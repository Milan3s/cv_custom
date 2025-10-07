<?php
// Incluir rutas del sistema
require_once __DIR__ . "/../config/Rutas.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Panel Administrativo - CV Resumen</title>
    <meta name="description" content="Panel administrativo de CV Resumen. Gestiona contenido, experiencia y proyectos del currículum de David Milanés.">

    <!-- Open Graph -->
    <meta property="og:title" content="Panel Administrativo - CV Resumen">
    <meta property="og:description" content="Gestiona el contenido y la información profesional de David Milanés desde el panel de administración.">
    <meta property="og:image" content="<?= BASE_URL ?>assets/img/perfil.jpg">
    <meta property="og:url" content="<?= DASHBOARD_URL ?>">
    <meta property="og:type" content="website">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/bootstrap.css">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/fontawesome/css/all.css">

    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/styles.css">
</head>
<body class="d-flex flex-column min-vh-100">

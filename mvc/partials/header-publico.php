<?php
// Incluir rutas del sistema
require_once __DIR__ . "/../config/Rutas.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>CV Resumen - David Milanés</title>
    <meta name="description" content="Currículum online de David Milanés, desarrollador de software con experiencia en aplicaciones web modernas.">
    
    <!-- Open Graph (para WhatsApp, Facebook, LinkedIn) -->
    <meta property="og:title" content="CV Resumen - David Milanés">
    <meta property="og:description" content="Consulta mi currículum online y conoce mi experiencia, habilidades y proyectos.">
    <meta property="og:image" content="<?= BASE_URL ?>assets/img/perfil.jpg">
    <meta property="og:url" content="<?= BASE_URL ?>index.php">
    <meta property="og:type" content="website">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/bootstrap.css">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/fontawesome/css/all.css">

    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/styles.css">
</head>
<body class="d-flex flex-column min-vh-100">

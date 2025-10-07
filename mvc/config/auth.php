<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function requireLogin() {
    if (empty($_SESSION['user'])) {
        header("Location: " . BASE_URL . "mvc/views/acceder/login.php");
        exit;
    }
}

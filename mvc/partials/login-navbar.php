<?php
// Incluir la configuración de rutas
require_once __DIR__ . "/../config/Rutas.php";

?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="<?= BASE_URL ?>index.php">
      <i class="fas fa-id-card me-2"></i> Zona Backend
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto"> 
        <li class="nav-item">
          <a class="nav-link" href="<?= BASE_URL ?>mvc/views/acceder/login.php">
            <i class="fas fa-user"></i> Acceder
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="<?= BASE_URL ?>mvc/views/acceder/register.php">
            <i class="fas fa-user"></i> Registrarse
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

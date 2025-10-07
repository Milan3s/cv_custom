<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="<?= BASE_URL ?>index.php">
      <i class="fas fa-id-card me-2"></i>  Zona Backend
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      </ul>

      <!-- Usuario logueado -->
      <?php if (!empty($_SESSION["user"])): ?>
        <span class="navbar-text text-white me-3">
          <i class="fas fa-user"></i> <?= htmlspecialchars($_SESSION["user"]) ?>
        </span>
        <a href="<?= BASE_URL ?>mvc/views/acceder/logout.php" class="btn btn-outline-light btn-sm">Salir</a>
      <?php else: ?>
        <span class="navbar-text text-white me-3">
          <i class="fas fa-user"></i> Invitado
        </span>
        <a href="<?= BASE_URL ?>mvc/views/acceder/login.php" class="btn btn-outline-light btn-sm">Login</a>
      <?php endif; ?>
    </div>
  </div>
</nav>

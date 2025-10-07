<?php
require_once __DIR__ . "/../../controllers/UserController.php";

$controller = new UserController();
$msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre   = trim($_POST["nombre"] ?? "");
    $email    = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($controller->register($nombre, $email, $password)) {
        $msg = '<div class="alert alert-success text-center">
                    <i class="fas fa-check-circle"></i> Registro exitoso. Ahora puedes iniciar sesión.
                </div>';
    } else {
        $msg = '<div class="alert alert-danger text-center">
                    <i class="fas fa-exclamation-triangle"></i> Error al registrar el usuario.
                </div>';
    }
}
?>


<?php include __DIR__ . "/../../partials/header.php"; ?>
<?php include __DIR__ . "/../../partials/login-navbar.php"; ?>

<main class="flex-fill d-flex align-items-center">
  <div class="container">
    <h2 class="text-center mb-4">Registro</h2>

    <div class="row justify-content-center">
      <div class="col-11 col-sm-8 col-md-3">
        <div class="card shadow-sm">
          <div class="card-body">
            <form method="POST" novalidate>
              
              <!-- Nombre -->
              <div class="mb-3">
                <label class="form-label">Nombre</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                  <input type="text" name="nombre" class="form-control" required>
                </div>
              </div>

              <!-- Email -->
              <div class="mb-3">
                <label class="form-label">Email</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                  <input type="email" name="email" class="form-control" required>
                </div>
              </div>

              <!-- Contraseña -->
              <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-lock"></i></span>
                  <input type="password" name="password" class="form-control" required>
                </div>
              </div>

              <button type="submit" class="btn btn-success w-100">
                <i class="fas fa-user-plus"></i> Registrarse
              </button>
            </form>

            <?php if (!empty($msg)) : ?>
              <div class="alert alert-info mt-3 mb-0 text-center" role="alert">
                <?= $msg ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<?php include __DIR__ . "/../../partials/footer.php"; ?>

<?php
require_once __DIR__ . "/../../controllers/UserController.php";
require_once __DIR__ . "/../../config/Rutas.php";

if (session_status() === PHP_SESSION_NONE) session_start();

$controller = new UserController();
$msg = "";

// Solo procesamos si viene del formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre   = trim($_POST["nombre"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($user = $controller->login($nombre, $password)) {
        // Guardamos el nombre de usuario en la sesión
        $_SESSION["user"] = $user->getNombre();  

        header("Location: " . DASHBOARD_URL);
        exit;
    } else {
        $msg = "Usuario o contraseña incorrectos.";
    }
}
?>



<?php include BASE_PATH . "partials/header.php"; ?>
<?php include BASE_PATH . "partials/login-navbar.php"; ?>

<!-- main ocupa la altura restante y centra el contenido -->
<main class="flex-fill d-flex align-items-center">
  <div class="container">
    <h2 class="text-center mb-4">Iniciar Sesión</h2>

    <div class="row justify-content-center">
      <!-- Ancho compacto: col-md-3 -->
      <div class="col-11 col-sm-8 col-md-3">
        <div class="card shadow-sm">
          <div class="card-body">
            <form method="POST" novalidate>
              
              <!-- Usuario -->
              <div class="mb-3">
                <label class="form-label">Nombre de usuario</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                  <input type="text" name="nombre" class="form-control" required>
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

              <!-- Botón -->
              <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-sign-in-alt"></i> Entrar
              </button>
            </form>

            <?php if (!empty($msg)) : ?>
              <div class="alert alert-danger mt-3 mb-0 text-center" role="alert">
                <?= $msg ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>



<?php include BASE_PATH . "partials/footer.php"; ?>

<?php
// =========================
// CARGA DE CONFIGURACIONES
// =========================
require_once __DIR__ . "/config/Rutas.php"; 
require_once __DIR__ . "/config/auth.php";

// =========================
// CONTROLADORES
// =========================
require_once __DIR__ . "/controllers/AliasController.php";
require_once __DIR__ . "/controllers/RedesController.php";
require_once __DIR__ . "/controllers/EducacionController.php";
require_once __DIR__ . "/controllers/ExperienciaController.php";
require_once __DIR__ . "/controllers/HabilidadController.php";
require_once __DIR__ . "/controllers/CertificadoController.php";
require_once __DIR__ . "/controllers/OtrosDatosController.php";
require_once __DIR__ . "/controllers/SeccionController.php"; 

// =========================
// AUTENTICACIÓN
// =========================
requireLogin();

// =======================================
// Compatibilidad de sesión (para login simple)
// =======================================
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Si solo existe $_SESSION['user'] como string, generamos un ID ficticio temporal
if (!isset($_SESSION['usuario_id'])) {
    if (isset($_SESSION['user']) && !is_array($_SESSION['user'])) {
        // Si el sistema no usa IDs, creamos un valor fijo para el usuario actual
        $_SESSION['usuario_id'] = 1; // 🔹 puedes cambiar este número si tienes un ID real en BD
    } elseif (isset($_SESSION['user']['id'])) {
        $_SESSION['usuario_id'] = $_SESSION['user']['id'];
    }
}

// Validar sesión
if (empty($_SESSION['usuario_id'])) {
    header("Location: ../login.php");
    exit;
}

$usuario_id = (int) $_SESSION['usuario_id'];


// =========================
// OBTENCIÓN DE DATOS
// =========================
$aliasController = new AliasController();
$perfil = $aliasController->getPerfil();

$redesController = new RedesController();
$redes = $redesController->getAll();

$educacionController = new EducacionController();
$educacion = $educacionController->getAll();

$experienciaController = new ExperienciaController();
$certificadoController = new CertificadoController();

$porPaginaExp = 2;
$porPaginaCert = 7;

// Paginación inicial (página 1)
$datosExperiencias = $experienciaController->getPaginadoPrivadoExperiencia($_SESSION['usuario_id'], 1, $porPaginaExp);
$experiencias = $datosExperiencias["experiencias"];
$totalPaginasExperiencias = $datosExperiencias["total_paginas"];

$datosCertificados = $certificadoController->getPaginadoPrivadoCertificado($_SESSION['usuario_id'], 1, $porPaginaCert);
$certificados = $datosCertificados["certificados"];
$totalPaginasCertificados = $datosCertificados["total_paginas"];

$habilidadController = new HabilidadController();
$habilidades = $habilidadController->getAll();

$otrosDatosController = new OtrosDatosController();
$otrosDatos = $otrosDatosController->getAll();

$seccionController = new SeccionController();
$secciones = $seccionController->getSecciones();

// =========================
// FUNCIONES AUXILIARES
// =========================
function formatearFecha($fecha) {
  if (!$fecha) return "";
  $date = DateTime::createFromFormat("Y-m-d", $fecha);
  return $date ? $date->format("d-m-Y") : $fecha;
}
function renderHTML($contenido) {
  return strip_tags($contenido, '<p><br><ul><ol><li><b><strong><i><em><u>');
}
?>

<?php include BASE_PATH . "partials/navbar.php"; ?>
<?php include BASE_PATH . "partials/header-publico.php"; ?>

<div class="a4 d-flex">

  <!-- ========================= -->
  <!-- COLUMNA IZQUIERDA -->
  <!-- ========================= -->
  <div class="left-column p-4">

    <!-- Perfil -->
    <div id="perfil-card" class="mb-4 text-center">
      <form id="form-foto" method="POST" enctype="multipart/form-data">
        <label for="input-foto" style="cursor: pointer;">
          <?php if ($perfil && $perfil->getFoto()): ?>
            <img src="<?= IMG_URL . htmlspecialchars($perfil->getFoto()); ?>" alt="Foto" class="img-fluid mb-3" style="max-width:140px;" id="foto-perfil">
          <?php else: ?>
            <img src="<?= IMG_URL ?>dmilanes.png" alt="Foto por defecto" class="img-fluid mb-3" style="max-width:140px;" id="foto-perfil">
          <?php endif; ?>
        </label>
        <input type="file" id="input-foto" name="foto" accept="image/*" style="display: none;">
      </form>

      <h3 class="fw-bold mb-1"><?= htmlspecialchars($perfil?->getAlias() ?? '') ?></h3>
      <p class="text-muted mb-3"><?= htmlspecialchars($perfil?->getProfesion() ?? '') ?></p>

      <div class="text-center mb-3">

        <!-- Botón para imprimir -->
        <button type="button" class="btn btn-outline-secondary" onclick="window.print()">
          <i class="fas fa-print me-2"></i> Imprimir CV
        </button>
      </div>

      <ul class="list-unstyled text-start mb-4">
        <?php if ($perfil && $perfil->getDireccion()): ?>
          <li><i class="fas fa-map-marker-alt me-2"></i><?= htmlspecialchars($perfil->getDireccion()); ?></li>
        <?php endif; ?>
        <?php if ($perfil && $perfil->getEmail()): ?>
          <li><i class="fas fa-envelope me-2"></i><?= htmlspecialchars($perfil->getEmail()); ?></li>
        <?php endif; ?>
        <?php if ($perfil && $perfil->getTelefono()): ?>
          <li><i class="fas fa-phone me-2"></i><?= htmlspecialchars($perfil->getTelefono()); ?></li>
        <?php endif; ?>
      </ul>
    </div>

    <!-- Redes Sociales -->
    <h4 class="section-title">
      REDES SOCIALES 
      <i class="fas fa-plus text-primary ms-2" id="estilo-crud" data-bs-toggle="modal" data-bs-target="#insertRedSocialModal"></i>
      <i class="fas fa-pencil-alt text-success ms-2" id="estilo-crud" data-bs-toggle="modal" data-bs-target="#editRedSocialModal"></i>
      <i class="fas fa-times text-danger ms-2" id="estilo-crud" data-bs-toggle="modal" data-bs-target="#deleteRedSocialModal"></i>
    </h4>
    <div class="contenedor-redes mb-4">
      <?php foreach ($redes as $r): ?>
        <a href="<?= htmlspecialchars($r->getUrl()); ?>" target="_blank" class="red-social">
          <i class="<?= htmlspecialchars($r->getIcono()); ?> fs-3"></i>
          <span><?= htmlspecialchars($r->getPlataforma()); ?></span>
        </a>
      <?php endforeach; ?>
    </div>

    <!-- Perfil / Bio -->
    <h4 class="section-title">
      PERFIL
      <i class="fas fa-plus text-primary ms-2" id="estilo-crud" data-bs-toggle="modal" data-bs-target="#insertPerfilModal"></i>
      <i class="fas fa-pen text-success ms-2" id="estilo-crud" data-bs-toggle="modal" data-bs-target="#editPerfilModal"></i>
      <i class="fas fa-times text-danger ms-2" id="estilo-crud" data-bs-toggle="modal" data-bs-target="#deletePerfilModal"></i>
    </h4>
    <p><?= nl2br(htmlspecialchars($perfil->getBio() ?? "")); ?></p>

    <!-- Educación -->
    <h4 class="section-title">
      EDUCACIÓN
      <i class="fas fa-plus text-primary ms-2" id="estilo-crud" data-bs-toggle="modal" data-bs-target="#insertEducacionModal"></i>
      <i class="fas fa-pen text-success ms-2" id="estilo-crud" data-bs-toggle="modal" data-bs-target="#editEducacionModal"></i>
      <i class="fas fa-times text-danger ms-2" id="estilo-crud" data-bs-toggle="modal" data-bs-target="#deleteEducacionModal"></i>
    </h4>
    <ul class="list-unstyled text-start">
      <?php foreach ($educacion as $e): ?>
        <li class="mb-2">
          <strong><?= htmlspecialchars($e->getTitulacion()); ?></strong><br>
          <?= htmlspecialchars($e->getCentro()); ?> - <?= htmlspecialchars($e->getUbicacion()); ?><br>
          <small><?= formatearFecha($e->getFechaInicio()); ?> → <?= formatearFecha($e->getFechaFin()); ?></small>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>

  <!-- ========================= -->
  <!-- COLUMNA DERECHA -->
  <!-- ========================= -->
  <div class="right-column p-3">
    <section class="cv-tabs">
      <div class="tabs-nav d-none d-md-flex" role="tablist">
        <button class="tab-btn active" aria-controls="tab-exp"><i class="fas fa-briefcase"></i> Experiencia</button>
        <button class="tab-btn" aria-controls="tab-hab"><i class="fas fa-layer-group"></i> Habilidades</button>
        <button class="tab-btn" aria-controls="tab-cert"><i class="fas fa-award"></i> Certificados</button>
        <button class="tab-btn" aria-controls="tab-otros"><i class="fas fa-info-circle"></i> Otros datos</button>
      </div>

      <div class="tabs-panels">

        <!-- =================== -->
        <!-- TAB EXPERIENCIA -->
        <!-- =================== -->
        <div class="tab-panel active" id="tab-exp">
          <h3 class="section-title">
            <i class="fas fa-briefcase"></i> EXPERIENCIA
            <i class="fas fa-plus text-primary ms-2" id="estilo-crud" data-bs-toggle="modal" data-bs-target="#insertExperienciaModal"></i>
            <i class="fas fa-pencil-alt text-success ms-2" id="estilo-crud" data-bs-toggle="modal" data-bs-target="#editExperienciaModal"></i>
            <i class="fas fa-times text-danger ms-2" id="estilo-crud" data-bs-toggle="modal" data-bs-target="#deleteExperienciaModal"></i>
          </h3>

          <div id="contenedor-experiencia">
            <?php foreach ($experiencias as $exp): ?>
              <div class="exp-item mb-4">
                <h5><?= htmlspecialchars($exp->getRol()); ?></h5>
                <div class="contenedor-linea"><hr class="linea-custom-glob"></div>
                <p><em><?= htmlspecialchars($exp->getEmpresa()); ?></em>
                  <?= $exp->getUbicacion() ? " (" . htmlspecialchars($exp->getUbicacion()) . ")" : "" ?><br>
                  <span><?= formatearFecha($exp->getFechaInicio()); ?> – <?= formatearFecha($exp->getFechaFin()); ?></span>
                </p>
                <?= $exp->getDescripcion() ? renderHTML($exp->getDescripcion()) : "" ?>
              </div>
            <?php endforeach; ?>
          </div>

          <div class="paginacion text-center mt-4" data-total="<?= $totalPaginasExperiencias ?>" data-tipo="Experiencia">
            <button class="btn-paginacion primero">&lt;&lt; Primero</button>
            <button class="btn-paginacion anterior">&lt; Anterior</button>
            <span class="paginacion-contador">1 / <?= $totalPaginasExperiencias ?></span>
            <button class="btn-paginacion siguiente">Siguiente &gt;</button>
            <button class="btn-paginacion ultimo">Último &gt;&gt;</button>
          </div>
        </div>
        <!-- =================== -->
        <!-- TAB HABILIDADES -->
        <!-- =================== -->
        <div class="tab-panel" id="tab-hab">
          <h3 class="section-title">
            <i class="fas fa-layer-group"></i> HABILIDADES
            <i class="fas fa-plus text-primary ms-2" id="estilo-crud" data-bs-toggle="modal" data-bs-target="#insertHabilidadModal"></i>
            <i class="fas fa-pencil-alt text-success ms-2" id="estilo-crud" data-bs-toggle="modal" data-bs-target="#editHabilidadModal"></i>
            <i class="fas fa-times text-danger ms-2" id="estilo-crud" data-bs-toggle="modal" data-bs-target="#deleteHabilidadModal"></i>
          </h3>

          <?php if (!empty($habilidades)): ?>
            <div class="row mt-3">
              <?php 
              $agrupadas = [];
              foreach ($habilidades as $h) {
                $agrupadas[$h->getTipo()][] = $h;
              }
              foreach ($agrupadas as $tipo => $lista): 
                $titulo = ucfirst(str_replace("_", " ", $tipo));
              ?>
                <div class="col-md-6 col-lg-4 mb-4">
                  <h5 class="subtitulo-habilidad"><?= htmlspecialchars($titulo) ?></h5>
                  <hr class="section-divider">
                  <ul class="list-unstyled">
                    <?php foreach ($lista as $h): ?>
                      <li>
                        <strong><?= htmlspecialchars($h->getNombre()); ?></strong>
                        <?php if ($h->getDescripcion()): ?>
                          <small class="text-muted"> - <?= htmlspecialchars($h->getDescripcion()); ?></small>
                        <?php endif; ?>
                      </li>
                    <?php endforeach; ?>
                  </ul>
                </div>
              <?php endforeach; ?>
            </div>
          <?php else: ?>
            <p>No hay habilidades registradas.</p>
          <?php endif; ?>
        </div>

        <!-- =================== -->
        <!-- TAB CERTIFICADOS -->
        <!-- =================== -->
        <div class="tab-panel" id="tab-cert">
          <h3 class="section-title">
            <i class="fas fa-award"></i> CERTIFICADOS
            <i class="fas fa-plus text-primary ms-2" id="estilo-crud" data-bs-toggle="modal" data-bs-target="#insertCertificadoModal"></i>
            <i class="fas fa-pencil-alt text-success ms-2" id="estilo-crud" data-bs-toggle="modal" data-bs-target="#editCertificadoModal"></i>
            <i class="fas fa-times text-danger ms-2" id="estilo-crud" data-bs-toggle="modal" data-bs-target="#deleteCertificadoModal"></i>
          </h3>

          <div id="contenedor-certificados">
            <ul class="list-unstyled ps-1 mt-3">
              <?php foreach ($certificados as $c): ?>
                <li class="mb-2">
                  <strong><?= htmlspecialchars($c->getTitulo()); ?></strong><br>
                  <span><?= htmlspecialchars($c->getEntidad()); ?></span><br>
                  <small><?= formatearFecha($c->getFecha()); ?></small>
                  <?php if ($c->getUrl()): ?>
                    <br><a href="<?= htmlspecialchars($c->getUrl()); ?>" target="_blank">Ver certificado</a>
                  <?php endif; ?>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>

          <div class="paginacion text-center mt-4" data-total="<?= $totalPaginasCertificados ?>" data-tipo="Certificado">
            <button class="btn-paginacion primero">&lt;&lt; Primero</button>
            <button class="btn-paginacion anterior">&lt; Anterior</button>
            <span class="paginacion-contador">1 / <?= $totalPaginasCertificados ?></span>
            <button class="btn-paginacion siguiente">Siguiente &gt;</button>
            <button class="btn-paginacion ultimo">Último &gt;&gt;</button>
          </div>
        </div>

        <!-- =================== -->
        <!-- TAB OTROS DATOS -->
        <!-- =================== -->
        <div class="tab-panel" id="tab-otros">
          <h3 class="section-title">
            <i class="fas fa-info-circle"></i> OTROS DATOS
            <i class="fas fa-plus text-primary ms-2" id="estilo-crud" data-bs-toggle="modal" data-bs-target="#insertOtrosModal"></i>
            <i class="fas fa-pencil-alt text-success ms-2" id="estilo-crud" data-bs-toggle="modal" data-bs-target="#editOtrosModal"></i>
            <i class="fas fa-times text-danger ms-2" id="estilo-crud" data-bs-toggle="modal" data-bs-target="#deleteOtrosModal"></i>
          </h3>

          <div class="otros-datos-list mt-3">
            <?php if (!empty($otrosDatos)): ?>
              <?php foreach ($otrosDatos as $o): ?>
                <p class="mb-2">
                  <i class="fas fa-check text-success me-2"></i>
                  <strong><?= htmlspecialchars($o->getTitulo()); ?></strong>
                  <?php if (!empty($o->getDescripcion())): ?>
                    <span class="text-muted">: <?= htmlspecialchars($o->getDescripcion()); ?></span>
                  <?php endif; ?>
                </p>
              <?php endforeach; ?>
            <?php else: ?>
              <p>No hay otros datos registrados.</p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>

<!-- ========================= -->
<!-- NAVBAR MÓVIL -->
<!-- ========================= -->
<nav class="mobile-nav d-md-none">
  <a href="#top" class="active"><i class="fas fa-home"></i><span>Inicio</span></a>
  <a href="#tab-exp"><i class="fas fa-briefcase"></i><span>Experiencia</span></a>
  <a href="#tab-hab"><i class="fas fa-layer-group"></i><span>Habilidades</span></a>
  <a href="#tab-cert"><i class="fas fa-award"></i><span>Certificados</span></a>
  <a href="#tab-otros"><i class="fas fa-info-circle"></i><span>Otros</span></a>
</nav>
<script>
document.addEventListener("DOMContentLoaded", () => {
  // =====================
  // 🔹 Paginación Privada AJAX
  // =====================
  const paginadores = document.querySelectorAll(".paginacion");
  paginadores.forEach(p => {
    const tipo = p.dataset.tipo;
    let pagina = 1;
    const total = parseInt(p.dataset.total);
    const contenedor = tipo === "Experiencia"
      ? document.getElementById("contenedor-experiencia")
      : document.getElementById("contenedor-certificados");
    const contador = p.querySelector(".paginacion-contador");

    const actualizar = (nueva) => {
      fetch(`ajax/paginacion_privado.php?tipo=${tipo}&page=${nueva}`)
        .then(res => res.text())
        .then(html => {
          contenedor.innerHTML = html;
          pagina = nueva;
          contador.textContent = `${pagina} / ${total}`;
        })
        .catch(err => console.error("Error en la paginación:", err));
    };

    p.querySelector(".primero").onclick = () => { if (pagina > 1) actualizar(1); };
    p.querySelector(".anterior").onclick = () => { if (pagina > 1) actualizar(pagina - 1); };
    p.querySelector(".siguiente").onclick = () => { if (pagina < total) actualizar(pagina + 1); };
    p.querySelector(".ultimo").onclick = () => { if (pagina < total) actualizar(total); };
  });

  // =====================
  // 🔹 Tabs (Pestañas)
  // =====================
  const tabButtons = document.querySelectorAll(".cv-tabs .tab-btn");
  const tabPanels = document.querySelectorAll(".cv-tabs .tab-panel");
  const navLinks = document.querySelectorAll(".mobile-nav a");
  const tabKey = "activeTabPrivado";

  function activateTab(tabId, save = true) {
    tabButtons.forEach(btn => btn.classList.remove("active"));
    tabPanels.forEach(panel => panel.classList.remove("active"));
    const activeBtn = document.querySelector(`[aria-controls="${tabId}"]`);
    const activePanel = document.getElementById(tabId);
    if (activeBtn) activeBtn.classList.add("active");
    if (activePanel) activePanel.classList.add("active");
    if (save) localStorage.setItem(tabKey, tabId);
  }

  const savedTab = localStorage.getItem(tabKey);
  if (savedTab && document.getElementById(savedTab)) {
    activateTab(savedTab, false);
  } else {
    activateTab(tabButtons[0].getAttribute("aria-controls"), false);
  }

  tabButtons.forEach(btn =>
    btn.addEventListener("click", () => activateTab(btn.getAttribute("aria-controls")))
  );

  navLinks.forEach(link => {
    link.addEventListener("click", e => {
      e.preventDefault();
      const target = document.querySelector(link.getAttribute("href"));
      if (target) target.scrollIntoView({ behavior: "smooth", block: "start" });
    });
  });

  // =====================
  // 🔹 Gestión de Modal de Secciones
  // =====================
  const seccionModal = document.getElementById("modalSeccion");
  if (seccionModal) {
    const modalTitle = seccionModal.querySelector(".modal-title");
    const modalDesc = seccionModal.querySelector(".modal-desc");
    const form = seccionModal.querySelector("form");
    const hiddenNombre = form.querySelector("input[name='nombre']");
    const hiddenAccion = form.querySelector("input[name='accion']");
    const campoSelect = seccionModal.querySelector("#campoSelect");
    const campoTitulo = seccionModal.querySelector("#campoTitulo");
    const campoIcono = seccionModal.querySelector("#campoIcono");

    let modalInstance = null;

    document.querySelectorAll(".open-seccion-modal").forEach(btn => {
      btn.addEventListener("click", () => {
        const seccion = btn.dataset.seccion;
        const accion = btn.dataset.action;
        hiddenNombre.value = seccion;
        hiddenAccion.value = accion;

        campoSelect.classList.add("d-none");
        campoTitulo.classList.add("d-none");
        campoIcono.classList.add("d-none");

        if (accion === "insert") {
          modalTitle.innerHTML = `<i class="fas fa-plus-circle me-2"></i> Añadir Sección (${seccion})`;
          modalDesc.innerHTML = `Crea una nueva sección para <strong>${seccion}</strong>.`;
          form.setAttribute("action", "views/secciones/insert.php");
          campoTitulo.classList.remove("d-none");
          campoIcono.classList.remove("d-none");
        } else if (accion === "edit") {
          modalTitle.innerHTML = `<i class="fas fa-edit me-2"></i> Editar Sección (${seccion})`;
          modalDesc.innerHTML = `Selecciona la sección de <strong>${seccion}</strong> que deseas modificar.`;
          form.setAttribute("action", "views/secciones/update.php");
          campoSelect.classList.remove("d-none");
          campoTitulo.classList.remove("d-none");
          campoIcono.classList.remove("d-none");
        } else if (accion === "delete") {
          modalTitle.innerHTML = `<i class="fas fa-trash-alt text-danger me-2"></i> Eliminar Sección (${seccion})`;
          modalDesc.innerHTML = `Selecciona la sección de <strong>${seccion}</strong> que deseas eliminar.<br><strong>Esta acción no se puede deshacer.</strong>`;
          form.setAttribute("action", "views/secciones/delete.php");
          campoSelect.classList.remove("d-none");
        }

        if (!modalInstance) {
          modalInstance = new bootstrap.Modal(seccionModal);
        }
        modalInstance.show();
      });
    });

    seccionModal.addEventListener("hidden.bs.modal", () => {
      modalInstance = null;
    });
  }
});
</script>

<!-- ========================= -->
<!-- 🔹 INCLUSIÓN DE MODALES -->
<!-- ========================= -->
<script>const IMG_URL = "<?= IMG_URL ?>";</script>
<?php include BASE_PATH . "views/redes/modal.php"; ?> 
<?php include BASE_PATH . "views/perfil/modal.php"; ?> 
<?php include BASE_PATH . "views/educacion/modal.php"; ?> 
<?php include BASE_PATH . "views/experiencia/modal.php"; ?> 
<?php include BASE_PATH . "views/habilidades/modal.php"; ?> 
<?php include BASE_PATH . "views/certificados/modal.php"; ?> 
<?php include BASE_PATH . "views/otros-datos/modal.php"; ?> 
<?php include BASE_PATH . "views/secciones/modal.php"; ?> 
<?php include BASE_PATH . "partials/footer.php"; ?>

<!-- ========================= -->
<!-- 🔹 SCRIPTS INDIVIDUALES -->
<!-- ========================= -->
<script src="views/perfil/perfil.js"></script>
<script src="views/redes/redes.js"></script>
<script src="views/educacion/educacion.js"></script>
<script src="views/experiencia/experiencia.js"></script>
<script src="views/habilidades/habilidades.js"></script>
<script src="views/certificados/certificados.js"></script>
<script src="views/otros-datos/otros-datos.js"></script>
<script src="views/secciones/secciones.js"></script>
</body>
</html>

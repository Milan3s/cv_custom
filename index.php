<?php
// =========================
// CONFIGURACIONES Y CONTROLADORES
// =========================
require_once __DIR__ . "/mvc/config/Rutas.php";
require_once __DIR__ . "/mvc/controllers/AliasController.php";
require_once __DIR__ . "/mvc/controllers/RedesController.php";
require_once __DIR__ . "/mvc/controllers/EducacionController.php";
require_once __DIR__ . "/mvc/controllers/ExperienciaController.php";
require_once __DIR__ . "/mvc/controllers/HabilidadController.php";
require_once __DIR__ . "/mvc/controllers/CertificadoController.php";
require_once __DIR__ . "/mvc/controllers/OtrosDatosController.php";

// =========================
// OBTENCIÓN DE DATOS PÚBLICOS
// =========================
$aliasController = new AliasController();
$perfil = $aliasController->getPerfil();

$redesController = new RedesController();
$redes = $redesController->getAll();

$educacionController = new EducacionController();
$educacion = $educacionController->getAll();

// --- Paginación inicial (sin GET, página 1) ---
$experienciaController = new ExperienciaController();
$certificadoController = new CertificadoController();
$porPaginaExp = 2;
$porPaginaCert = 7;

$datosExperiencias = $experienciaController->getPaginadoPublicoExperiencia(1, $porPaginaExp);
$experiencias = $datosExperiencias["experiencias"];
$totalPaginasExperiencias = $datosExperiencias["total_paginas"];

$datosCertificados = $certificadoController->getPaginadoPublicoCertificado(1, $porPaginaCert);
$certificados = $datosCertificados["certificados"];
$totalPaginasCertificados = $datosCertificados["total_paginas"];

$habilidadController = new HabilidadController();
$habilidades = $habilidadController->getAll();

$otrosDatosController = new OtrosDatosController();
$otrosDatos = $otrosDatosController->getAll();

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

<?php include BASE_PATH . "partials/header-publico.php"; ?>  
<body id="top">

  <!-- ========================= -->
  <!-- CONTENEDOR PRINCIPAL A4 -->
  <!-- ========================= -->
  <div class="a4 d-flex">

    <!-- ========================= -->
    <!-- COLUMNA IZQUIERDA -->
    <!-- ========================= -->
    <div class="left-column p-4 d-flex flex-column align-custom">

      <!-- 🔹 Foto + Nombre + Profesión -->
      <section class="perfil-section">
        <?php if ($perfil && $perfil->getFoto()): ?>
          <img src="<?= BASE_URL ?>assets/img/<?= htmlspecialchars($perfil->getFoto()) ?>"
            alt="Foto de perfil" class="img-fluid mb-3" style="max-width:140px;">
        <?php else: ?>
          <img src="<?= IMG_URL ?>dmilanes.png" alt="Foto por defecto" class="img-fluid mb-3" style="max-width:140px;">
        <?php endif; ?>

        <h3 class="fw-bold mb-1"><?= htmlspecialchars($perfil?->getAlias() ?? "Nombre Apellido") ?></h3>
        <p class="text-muted mb-3"><?= htmlspecialchars($perfil?->getProfesion() ?? "Profesión") ?></p>

       <div class="text-center mb-3 d-flex justify-content-center flex-wrap gap-2">
       <!-- Botón para imprimir -->
        <button type="button" class="btn btn-outline-secondary" onclick="window.print()">
          <i class="fas fa-print me-2"></i> Imprimir CV
        </button>
      </div>

      </section>

      <!-- 🔹 Contacto -->
      <section class="contacto-section">
        <ul class="list-unstyled mb-4">
          <?php if ($perfil?->getDireccion()): ?>
            <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i><?= htmlspecialchars($perfil->getDireccion()) ?></li>
          <?php endif; ?>
          <?php if ($perfil?->getEmail()): ?>
            <li class="mb-2"><i class="fas fa-envelope me-2"></i><?= htmlspecialchars($perfil->getEmail()) ?></li>
          <?php endif; ?>
          <?php if ($perfil?->getTelefono()): ?>
            <li><i class="fas fa-phone me-2"></i><?= htmlspecialchars($perfil->getTelefono()) ?></li>
          <?php endif; ?>
        </ul>
      </section>

      <!-- 🔹 Redes Sociales -->
      <?php if (!empty($redes)): ?>
        <section class="redes-section">
          <h4 class="section-title-front">REDES SOCIALES</h4>
          <div class="contenedor-redes mb-4">
            <?php foreach ($redes as $r): ?>
              <?php if ($r->getVisible()): ?>
                <a href="<?= htmlspecialchars($r->getUrl()); ?>" target="_blank" class="red-social">
                  <i class="<?= htmlspecialchars($r->getIcono()); ?> fs-3"></i>
                  <span><?= htmlspecialchars($r->getPlataforma()); ?></span>
                </a>
              <?php endif; ?>
            <?php endforeach; ?>
          </div>
        </section>
      <?php endif; ?>

      <!-- 🔹 Perfil/Bio -->
      <?php if ($perfil?->getBio()): ?>
        <section class="bio-section">
          <h4 class="section-title-front"><span>PERFIL</span></h4>
          <p><?= nl2br(htmlspecialchars($perfil->getBio())) ?></p>
        </section>
      <?php endif; ?>

      <!-- 🔹 Educación -->
      <?php if (!empty($educacion)): ?>
        <section class="educacion-section">
          <h4 class="section-title-front">EDUCACIÓN</h4>
          <ul class="list-unstyled mb-0 ps-1">
            <?php foreach ($educacion as $e): ?>
              <li>
                <strong><?= htmlspecialchars($e->getTitulacion()); ?></strong><br>
                <span><?= htmlspecialchars($e->getCentro()); ?></span><br>
                <small><?= formatearFecha($e->getFechaInicio()); ?> - <?= formatearFecha($e->getFechaFin()); ?></small>
              </li>
            <?php endforeach; ?>
          </ul>
        </section>
      <?php endif; ?>
    </div>

    <!-- ========================= -->
    <!-- COLUMNA DERECHA -->
    <!-- ========================= -->
    <div class="right-column p-3">
      <section class="cv-tabs" aria-label="Secciones del CV">
        
        <!-- Tabs -->
        <div class="tabs-nav d-none d-md-flex" role="tablist">
          <button class="tab-btn active" role="tab" aria-controls="tab-exp"><i class="fas fa-briefcase"></i> Experiencia</button>
          <button class="tab-btn" role="tab" aria-controls="tab-hab"><i class="fas fa-layer-group"></i> Habilidades</button>
          <button class="tab-btn" role="tab" aria-controls="tab-cert"><i class="fas fa-award"></i> Certificados</button>
          <button class="tab-btn" role="tab" aria-controls="tab-otros"><i class="fas fa-info-circle"></i> Otros datos</button>
        </div>

        <!-- Paneles -->
        <div class="tabs-panels">

          <!-- 🔹 Experiencia -->
          <section class="seccion-experiencia">
            <div class="tab-panel active" id="tab-exp" role="tabpanel">
              <h3 class="section-title-front"><i class="fas fa-briefcase"></i> Experiencia</h3>
              <div id="contenedor-experiencia">
                <?php foreach ($experiencias as $exp): ?>
                  <div class="exp-item mb-4">
                    <h5><?= htmlspecialchars($exp->getRol()); ?></h5>
                    <div class="contenedor-linea"><hr class="linea-custom-glob"></div>
                    <p>
                      <em><?= htmlspecialchars($exp->getEmpresa()); ?></em>
                      <?= $exp->getUbicacion() ? "(" . htmlspecialchars($exp->getUbicacion()) . ")" : "" ?><br>
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
          </section>

          <!-- 🔹 Habilidades -->
          <section class="seccion-habilidades">
            <div class="tab-panel" id="tab-hab" role="tabpanel">
              <h3 class="section-title-front"><i class="fas fa-layer-group me-2"></i> Habilidades</h3>
              <?php if (!empty($habilidades)): ?>
                <div class="row">
                  <?php 
                  $agrupadas = [];
                  foreach ($habilidades as $h) $agrupadas[$h->getTipo()][] = $h;
                  foreach ($agrupadas as $tipo => $lista): ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                      <h5 class="subtitulo-habilidad"><?= ucfirst(str_replace("_", " ", $tipo)) ?><hr class="section-divider"></h5>
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
          </section>

          <!-- 🔹 Certificados -->
          <section class="seccion-certificados">
            <div class="tab-panel" id="tab-cert" role="tabpanel">
              <h3 class="section-title-front"><i class="fas fa-award"></i> Certificados</h3>
              <div id="contenedor-certificados">
                <ul class="list-unstyled ps-1">
                  <?php foreach ($certificados as $c): ?>
                    <li class="mb-2">
                      <strong><?= htmlspecialchars($c->getTitulo()); ?></strong><br>
                      <span><?= htmlspecialchars($c->getEntidad()); ?></span><br>
                      <small><?= formatearFecha($c->getFecha()); ?></small>
                      <?php if ($c->getUrl()): ?><br><a href="<?= htmlspecialchars($c->getUrl()); ?>" target="_blank">Ver certificado</a><?php endif; ?>
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
          </section>

          <!-- 🔹 Otros datos -->
          <section class="seccion-otros">
            <div class="tab-panel" id="tab-otros" role="tabpanel">
              <h3 class="section-title-front"><i class="fas fa-info-circle"></i> Otros datos</h3>
              <?php if (!empty($otrosDatos)): ?>
                <?php foreach ($otrosDatos as $dato): ?>
                  <p class="mb-2">
                    <i class="fas fa-check text-success me-2"></i>
                    <strong><?= htmlspecialchars($dato->getTitulo()); ?></strong>
                    <?php if ($dato->getDescripcion()): ?>
                      <span class="text-muted">: <?= htmlspecialchars($dato->getDescripcion()); ?></span>
                    <?php endif; ?>
                  </p>
                <?php endforeach; ?>
              <?php else: ?>
                <p>No hay otros datos registrados.</p>
              <?php endif; ?>
            </div>
          </section>
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

  <!-- ========================= -->
  <!-- SCRIPT -->
  <!-- ========================= -->
  <script>
document.addEventListener("DOMContentLoaded", () => {
  const paginadores = document.querySelectorAll(".paginacion");
  paginadores.forEach(p => {
    const tipo = p.dataset.tipo;
    let pagina = 1;
    const total = parseInt(p.dataset.total);
    const contenedor = tipo === "Experiencia" ? document.getElementById("contenedor-experiencia") : document.getElementById("contenedor-certificados");
    const contador = p.querySelector(".paginacion-contador");

    const actualizar = (nueva) => {
      fetch(`mvc/ajax/paginacion.php?tipo=${tipo}&page=${nueva}`)
        .then(res => res.text())
        .then(html => {
          contenedor.innerHTML = html;
          pagina = nueva;
          contador.textContent = `${pagina} / ${total}`;
        });
    };
    p.querySelector(".primero").onclick = () => { if (pagina > 1) actualizar(1); };
    p.querySelector(".anterior").onclick = () => { if (pagina > 1) actualizar(pagina - 1); };
    p.querySelector(".siguiente").onclick = () => { if (pagina < total) actualizar(pagina + 1); };
    p.querySelector(".ultimo").onclick = () => { if (pagina < total) actualizar(total); };
  });

  // Tabs
  const tabButtons = document.querySelectorAll(".cv-tabs .tab-btn");
  const tabPanels = document.querySelectorAll(".cv-tabs .tab-panel");
  const navLinks = document.querySelectorAll(".mobile-nav a");
  const savedTab = localStorage.getItem("activeTab") || "tab-exp";
  activateTab(savedTab);

  function activateTab(tabId) {
    tabButtons.forEach(b => b.classList.remove("active"));
    tabPanels.forEach(p => p.classList.remove("active"));
    const btn = document.querySelector(`[aria-controls="${tabId}"]`);
    const panel = document.getElementById(tabId);
    if (btn) btn.classList.add("active");
    if (panel) panel.classList.add("active");
    localStorage.setItem("activeTab", tabId);
  }

  tabButtons.forEach(btn => btn.addEventListener("click", () => activateTab(btn.getAttribute("aria-controls"))));

  navLinks.forEach(link => {
    link.addEventListener("click", e => {
      e.preventDefault();
      const t = document.querySelector(link.getAttribute("href"));
      if (t) {
        t.scrollIntoView({ behavior: "smooth", block: "start" });
        activateTab(t.id);
      }
    });
  });
});
</script>

<?php include BASE_PATH . "partials/footer.php"; ?>
</body>
</html>

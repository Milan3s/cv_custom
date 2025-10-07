<!-- =============================== -->
<!-- MODAL ÚNICO PARA CRUD SECCIONES -->
<!-- =============================== -->
<div class="modal fade" id="modalSeccion" tabindex="-1" aria-hidden="true" 
     data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg border-0">

      <!-- HEADER -->
      <div class="modal-header">
        <h5 class="modal-title text-dark">
          <!-- 🟢 Se rellena dinámicamente con JS -->
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <!-- FORMULARIO -->
      <form method="POST" action="">
        <div class="modal-body">
          
          <!-- Descripción dinámica -->
          <p class="text-muted mb-3 modal-desc">
            <i class="fas fa-info-circle me-2"></i>
            Aquí aparecerá la descripción según la acción.
          </p>

          <!-- Campos ocultos -->
          <input type="hidden" name="nombre">
          <input type="hidden" name="accion">

          <!-- ========== SELECT (Editar / Eliminar) ========== -->
          <div id="campoSelect" class="mb-3 d-none">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-network-wired"></i></span>
              <select class="form-select" name="seccion_id">
                <option value="">-- Selecciona sección --</option>
                <?php foreach ($secciones as $s): ?>
                  <option value="<?= $s->getId(); ?>" 
                          data-titulo="<?= htmlspecialchars($s->getTitulo()); ?>" 
                          data-icono="<?= htmlspecialchars($s->getIcono()); ?>"
                          data-nombre="<?= htmlspecialchars($s->getNombre()); ?>">
                    <?= htmlspecialchars($s->getTitulo()); ?> (<?= htmlspecialchars($s->getNombre()); ?>)
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <!-- ========== TÍTULO (Insertar / Editar) ========== -->
          <div id="campoTitulo" class="mb-3 d-none">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-heading"></i></span>
              <input type="text" class="form-control" name="titulo" placeholder="Ej: Mi Experiencia Profesional">
            </div>
          </div>

          <!-- ========== ICONO (Insertar / Editar) ========== -->
          <div id="campoIcono" class="mb-3 d-none">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-icons"></i></span>
              <input type="text" class="form-control" name="icono" placeholder="fas fa-briefcase">
            </div>
            <small class="text-muted">Usa clases de FontAwesome (ej: <code>fas fa-briefcase</code>).</small>
          </div>

        </div>

        <!-- FOOTER -->
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i> Cancelar
          </button>
          <button type="submit" class="btn btn-outline-primary btn-accion">
            <i class="fas fa-save me-1"></i> Guardar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const seccionModal = document.getElementById("modalSeccion");

    // 🔄 Al cerrar, resetear formulario y ocultar campos dinámicos
    seccionModal.addEventListener("hidden.bs.modal", () => {
      const form = seccionModal.querySelector("form");
      if (form) form.reset();

      // Ocultar campos condicionales para que no queden abiertos
      ["#campoSelect", "#campoTitulo", "#campoIcono"].forEach(sel => {
        const el = seccionModal.querySelector(sel);
        if (el) el.classList.add("d-none");
      });

      // Reset botón principal
      const btnAccion = seccionModal.querySelector(".btn-accion");
      if (btnAccion) {
        btnAccion.className = "btn btn-outline-primary btn-accion";
        btnAccion.innerHTML = '<i class="fas fa-save me-1"></i> Guardar';
      }

      // Reset título y descripción
      const modalTitle = seccionModal.querySelector(".modal-title");
      const modalDesc  = seccionModal.querySelector(".modal-desc");
      if (modalTitle) modalTitle.textContent = "";
      if (modalDesc) modalDesc.textContent  = "";
    });
  });
</script>

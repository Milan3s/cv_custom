<?php
require_once __DIR__ . "/../../controllers/ExperienciaController.php";
require_once __DIR__ . "/../../controllers/SeccionController.php";

// Cargamos todas las experiencias (sin paginado)
$experienciaController = new ExperienciaController();
$experiencias = $experienciaController->getAll();

// También necesitamos las secciones si no existen
if (!isset($secciones)) {
  $seccionController = new SeccionController();
  $secciones = $seccionController->getSecciones();
}
?>

<!-- =============================== -->
<!-- Modal Insertar Experiencia -->
<!-- =============================== -->
<div class="modal fade" id="insertExperienciaModal" tabindex="-1" aria-labelledby="insertExperienciaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content shadow-lg border-0">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="insertExperienciaModalLabel">
          <i class="fas fa-briefcase me-2"></i>Añadir Experiencia
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <form id="insertExperienciaForm" method="POST" action="views/experiencia/insert.php">
        <div class="modal-body">

          <!-- Select Sección -->
          <div class="mb-3">
            <label for="seccion_id" class="form-label fw-bold">Selecciona la sección</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-layer-group"></i></span>
              <select class="form-select" id="seccion_id" name="seccion_id" required>
                <option value="">-- Selecciona sección --</option>
                <?php foreach ($secciones as $sec): ?>
                  <option value="<?= $sec->getId(); ?>">
                    <?= htmlspecialchars($sec->getTitulo()); ?> (<?= htmlspecialchars($sec->getNombre()); ?>)
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <!-- Rol -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
              <input type="text" class="form-control" id="rol" name="rol" placeholder="Rol (Ej: Desarrollador de Software)" required>
            </div>
          </div>

          <!-- Empresa -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-building"></i></span>
              <input type="text" class="form-control" id="empresa" name="empresa" placeholder="Empresa (Ej: NTTData)" required>
            </div>
          </div>

          <!-- Ubicación -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
              <input type="text" class="form-control" id="ubicacion" name="ubicacion" placeholder="Ubicación (Ej: Madrid)">
            </div>
          </div>

          <!-- Fechas -->
          <div class="row">
            <div class="col mb-3">
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
              </div>
            </div>
            <div class="col mb-3">
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
              </div>
            </div>
          </div>

          <!-- Descripción -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-align-left"></i></span>
              <textarea class="form-control" id="descripcion" name="descripcion" rows="4" placeholder="Describe las funciones realizadas"></textarea>
            </div>
          </div>

          <!-- Orden -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-sort-numeric-down"></i></span>
              <input type="number" class="form-control" id="orden" name="orden" min="1" value="1">
            </div>
            <small class="text-muted">Número para ordenar las experiencias (menor número se muestra primero).</small>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i>Cancelar
          </button>
          <button type="submit" class="btn btn-outline-primary">
            <i class="fas fa-save me-1"></i>Guardar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- =============================== -->
<!-- Modal Editar Experiencia -->
<!-- =============================== -->
<div class="modal fade" id="editExperienciaModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content shadow-lg border-0">
      <div class="modal-header">
        <h5 class="modal-title text-dark">
          <i class="fas fa-edit me-2"></i>Editar Experiencia
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <form id="editExperienciaForm" method="POST" action="views/experiencia/update.php">
        <div class="modal-body">

          <!-- Select experiencia -->
          <div class="mb-3">
            <label for="exp_select" class="form-label fw-bold">Selecciona experiencia</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-list"></i></span>
              <select class="form-select" id="exp_select" required>
                <option value="">-- Selecciona experiencia --</option>
                <?php foreach ($experiencias as $exp): ?>
                  <option value="<?= $exp->getId(); ?>"
                          data-seccion="<?= $exp->getSeccionId(); ?>"
                          data-rol="<?= htmlspecialchars($exp->getRol()); ?>"
                          data-empresa="<?= htmlspecialchars($exp->getEmpresa()); ?>"
                          data-ubicacion="<?= htmlspecialchars($exp->getUbicacion()); ?>"
                          data-fecha-inicio="<?= $exp->getFechaInicio(); ?>"
                          data-fecha-fin="<?= $exp->getFechaFin(); ?>"
                          data-descripcion="<?= htmlspecialchars($exp->getDescripcion()); ?>"
                          data-orden="<?= $exp->getOrden(); ?>">
                    <?= htmlspecialchars($exp->getRol()); ?> - <?= htmlspecialchars($exp->getEmpresa()); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <input type="hidden" id="exp-id" name="id">

          <!-- Select Sección -->
          <div class="mb-3">
            <label for="exp-seccion" class="form-label fw-bold">Sección</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-layer-group"></i></span>
              <select class="form-select" id="exp-seccion" name="seccion_id" required>
                <?php foreach ($secciones as $sec): ?>
                  <option value="<?= $sec->getId(); ?>"><?= htmlspecialchars($sec->getTitulo()); ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <!-- Rol -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
              <input type="text" class="form-control" id="exp-rol" name="rol" required>
            </div>
          </div>

          <!-- Empresa -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-building"></i></span>
              <input type="text" class="form-control" id="exp-empresa" name="empresa" required>
            </div>
          </div>

          <!-- Ubicación -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
              <input type="text" class="form-control" id="exp-ubicacion" name="ubicacion">
            </div>
          </div>

          <!-- Fechas -->
          <div class="row mb-3">
            <div class="col">
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                <input type="date" class="form-control" id="exp-fecha-inicio" name="fecha_inicio" required>
              </div>
            </div>
            <div class="col">
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                <input type="date" class="form-control" id="exp-fecha-fin" name="fecha_fin" required>
              </div>
            </div>
          </div>

          <!-- Descripción -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-align-left"></i></span>
              <textarea class="form-control" id="exp-descripcion" name="descripcion" rows="4"></textarea>
            </div>
          </div>

          <!-- Orden -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-sort-numeric-down"></i></span>
              <input type="number" class="form-control" id="exp-orden" name="orden" min="1">
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i>Cancelar
          </button>
          <button type="submit" class="btn btn-outline-success">
            <i class="fas fa-save me-1"></i>Actualizar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- =============================== -->
<!-- Modal Eliminar Experiencia -->
<!-- =============================== -->
<div class="modal fade" id="deleteExperienciaModal" tabindex="-1" aria-labelledby="deleteExperienciaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg border-0">
      <div class="modal-header">
        <h5 class="modal-title text-dark">
          <i class="fas fa-trash-alt me-2"></i>Eliminar Experiencia
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <form id="deleteExperienciaForm" method="POST" action="views/experiencia/delete.php">
        <div class="modal-body">
          <p class="text-muted mb-3">Selecciona la experiencia que deseas eliminar:</p>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
            <select class="form-select" id="exp_id" name="id" required>
              <option value="">-- Selecciona experiencia --</option>
              <?php foreach ($experiencias as $exp): ?>
                <option value="<?= $exp->getId(); ?>">
                  <?= htmlspecialchars($exp->getRol()); ?> - <?= htmlspecialchars($exp->getEmpresa()); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i>Cancelar
          </button>
          <button type="submit" class="btn btn-outline-danger">
            <i class="fas fa-trash-alt me-1"></i>Eliminar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- =============================== -->
<!-- Modal Confirmación -->
<!-- =============================== -->
<div class="modal fade" id="modalConfirmExperiencia" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center shadow-lg border-0 p-4" style="pointer-events: none;">
      <div class="modal-body">
        <i id="modalConfirmExperienciaIcon" class="fas fa-check-circle text-success fa-3x mb-3"></i>
        <h5 id="modalConfirmExperienciaMsg">Operación realizada correctamente</h5>
      </div>
    </div>
  </div>
</div>

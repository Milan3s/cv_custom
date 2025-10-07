<?php 
require_once __DIR__ . "/../../controllers/SeccionController.php"; 
$seccionController = new SeccionController();
$secciones = $seccionController->getSecciones();
?>

<!-- ========================
     MODAL INSERTAR OTROS DATOS
========================= -->
<div class="modal fade" id="insertOtrosModal" tabindex="-1" aria-labelledby="insertOtrosModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content shadow-lg border-0">

      <div class="modal-header">
        <h5 class="modal-title text-dark" id="insertOtrosModalLabel">
          <i class="fas fa-plus-circle me-2"></i> Añadir Otro Dato de Interés
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <form id="insertOtrosForm" method="POST" action="views/otros-datos/insert.php">
        <div class="modal-body">
          <p class="text-muted mb-3">
            <i class="fas fa-info-circle me-2 text-primary"></i>
            Rellena los campos para añadir un nuevo dato de interés.
          </p>

          <!-- Sección -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-folder-open"></i></span>
              <select class="form-select" id="insert-seccion_id" name="seccion_id" required>
                <option value="">-- Selecciona Sección --</option>
                <?php foreach ($secciones as $sec): ?>
                  <option value="<?= (int)$sec->getId(); ?>">
                    <?= htmlspecialchars($sec->getTitulo()); ?> (<?= htmlspecialchars($sec->getNombre()); ?>)
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <!-- Título -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-tag"></i></span>
              <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Ej: Disponibilidad inmediata" required>
            </div>
          </div>

          <!-- Descripción -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-align-left"></i></span>
              <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Ej: Disponible para incorporación inmediata"></textarea>
            </div>
          </div>

          <!-- Orden -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-sort-numeric-down"></i></span>
              <input type="number" class="form-control" id="orden" name="orden" placeholder="Ej: 1" min="1" required>
            </div>
            <small class="text-muted">El número determina el orden en que se mostrarán.</small>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i> Cancelar
          </button>
          <button type="submit" class="btn btn-outline-primary">
            <i class="fas fa-save me-1"></i> Guardar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- ========================
     MODAL EDITAR OTROS DATOS
========================= -->
<div class="modal fade" id="editOtrosModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content shadow-lg border-0">

      <div class="modal-header">
        <h5 class="modal-title text-dark">
          <i class="fas fa-edit me-2"></i> Editar Dato de Interés
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <form id="editOtrosForm" method="POST" action="views/otros-datos/update.php">
        <div class="modal-body">
          <p class="text-muted mb-3">
            <i class="fas fa-info-circle me-2 text-primary"></i>
            Selecciona un dato de interés y modifica los campos necesarios.
          </p>

          <!-- Seleccionar dato -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-list"></i></span>
              <select id="otros_select" class="form-select" name="id" required>
                <option value="">-- Selecciona Dato --</option>
                <?php foreach ($otrosDatos as $d): ?>
                  <option value="<?= $d->getId(); ?>">
                    <?= htmlspecialchars($d->getTitulo()); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <!-- Campo oculto para usuario -->
          <input type="hidden" name="usuario_id" id="edit-usuario_id" value="<?= $_SESSION['usuario_id'] ?? 1; ?>">

          <!-- Sección -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-folder-open"></i></span>
              <select class="form-select" id="edit-seccion_id" name="seccion_id">
                <option value="">-- Selecciona Sección --</option>
                <?php foreach ($secciones as $sec): ?>
                  <option value="<?= (int)$sec->getId(); ?>">
                    <?= htmlspecialchars($sec->getTitulo()); ?> (<?= htmlspecialchars($sec->getNombre()); ?>)
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <!-- Título -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-tag"></i></span>
              <input type="text" class="form-control" id="edit-titulo-otros" name="titulo" placeholder="Título">
            </div>
          </div>

          <!-- Descripción -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-align-left"></i></span>
              <textarea class="form-control" id="edit-descripcion-otros" name="descripcion" placeholder="Descripción"></textarea>
            </div>
          </div>

          <!-- Orden -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-sort-numeric-down"></i></span>
              <input type="number" class="form-control" id="edit-orden-otros" name="orden" min="1" placeholder="Orden (ej: 1)">
            </div>
            <small class="text-muted">Puedes modificar el orden para reubicar este dato.</small>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i> Cancelar
          </button>
          <button type="submit" class="btn btn-outline-success">
            <i class="fas fa-save me-1"></i> Guardar Cambios
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- ========================
     MODAL ELIMINAR OTROS DATOS
========================= -->
<div class="modal fade" id="deleteOtrosModal" tabindex="-1" aria-labelledby="deleteOtrosModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg border-0">

      <div class="modal-header">
        <h5 class="modal-title text-dark" id="deleteOtrosModalLabel">
          <i class="fas fa-trash-alt me-2 text-danger"></i> Eliminar Dato de Interés
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <form id="deleteOtrosForm" method="POST" action="views/otros-datos/delete.php">
        <div class="modal-body">
          <p class="text-muted mb-3">
            <i class="fas fa-info-circle me-2 text-primary"></i>
            Selecciona el dato que deseas eliminar.
          </p>

          <!-- Select dinámico -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-tag"></i></span>
              <select class="form-select" id="otros_id" name="otros_id" required>
                <option value="">-- Selecciona un dato --</option>
                <?php foreach ($otrosDatos as $d): ?>
                  <option value="<?= $d->getId(); ?>">
                    <?= htmlspecialchars($d->getTitulo()); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i> Cancelar
          </button>
          <button type="submit" class="btn btn-outline-danger">
            <i class="fas fa-trash me-1"></i> Eliminar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- ========================
     MODAL CONFIRMACIÓN GENÉRICO
========================= -->
<div class="modal fade" id="modalConfirmOtros" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center border-0 shadow-lg">
      <div class="modal-body">
        <!-- Icono dinámico -->
        <i id="modalConfirmOtrosIcon" class="fas fa-check-circle fa-3x mb-3 text-success"></i>
        <!-- Mensaje dinámico -->
        <h5 id="modalConfirmOtrosMsg">Operación realizada correctamente</h5>
      </div>
      <div class="modal-footer justify-content-center">
        <button class="btn btn-outline-primary" data-bs-dismiss="modal">
          <i class="fas fa-check me-1"></i> OK
        </button>
      </div>
    </div>
  </div>
</div>

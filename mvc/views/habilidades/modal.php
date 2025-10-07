<?php 
require_once __DIR__ . "/../../controllers/HabilidadController.php";

$habController = new HabilidadController();
$tipos = $habController->getTipos(); // 🔹 Trae ENUM dinámico de la DB
?>

<!-- ========================
     MODAL INSERTAR HABILIDAD
========================= -->
<div class="modal fade" id="insertHabilidadModal" tabindex="-1" aria-labelledby="insertHabilidadModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content shadow-lg border-0">

      <div class="modal-header">
        <h5 class="modal-title text-dark" id="insertHabilidadModalLabel">
          <i class="fas fa-plus-circle me-2"></i> Añadir Habilidad
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <form id="insertHabilidadForm" method="POST" action="views/habilidades/insert.php">
        <div class="modal-body">
          <p class="text-muted mb-3">
            <i class="fas fa-info-circle me-2 text-primary"></i>
            Rellena los campos para añadir una nueva habilidad.
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

          <!-- Nombre -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-cogs"></i></span>
              <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ej: PHP, HTML, Comunicación" required>
            </div>
          </div>

          <!-- Tipo (dinámico ENUM) -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-layer-group"></i></span>
              <select class="form-select" id="tipo" name="tipo" required>
                <option value="">-- Selecciona tipo --</option>
                <?php foreach ($tipos as $t): ?>
                  <option value="<?= $t; ?>"><?= ucfirst(str_replace('_',' ',$t)); ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <!-- Descripción -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-align-left"></i></span>
              <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Breve descripción de la habilidad"></textarea>
            </div>
          </div>

          <!-- Orden -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-sort-numeric-down"></i></span>
              <input type="number" class="form-control" id="orden" name="orden" placeholder="Ej: 1" min="1" step="1" required>
            </div>
            <small class="text-muted">El número determina el orden en que se mostrarán (menor número se muestra primero).</small>
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
     MODAL EDITAR HABILIDAD
========================= -->
<div class="modal fade" id="editHabilidadModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content shadow-lg border-0">

      <div class="modal-header">
        <h5 class="modal-title text-dark">
          <i class="fas fa-edit me-2"></i> Editar Habilidad
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <form id="editHabilidadForm" method="POST" action="views/habilidades/update.php">
        <div class="modal-body">
          <p class="text-muted mb-3">
            <i class="fas fa-info-circle me-2 text-primary"></i>
            Selecciona una habilidad y modifica los campos necesarios.
          </p>

          <!-- Hidden para valores internos -->
          <input type="hidden" id="edit-id" name="id">
          <input type="hidden" id="edit-usuario_id" name="usuario_id">

          <!-- Seleccionar habilidad -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-list"></i></span>
              <select id="habilidad_select" class="form-select">
                <option value="">-- Selecciona Habilidad --</option>
                <?php foreach ($habilidades as $h): ?>
                  <option value="<?= (int)$h->getId(); ?>">
                    <?= htmlspecialchars($h->getNombre()); ?> (<?= htmlspecialchars($h->getTipo()); ?>)
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

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

          <!-- Nombre -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-cogs"></i></span>
              <input type="text" class="form-control" id="edit-nombre" name="nombre" placeholder="Nombre">
            </div>
          </div>

          <!-- Tipo -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-layer-group"></i></span>
              <select class="form-select" id="edit-tipo" name="tipo">
                <option value="">-- Selecciona tipo --</option>
                <?php foreach ($tipos as $t): ?>
                  <option value="<?= $t; ?>"><?= ucfirst(str_replace('_',' ',$t)); ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <!-- Descripción -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-align-left"></i></span>
              <textarea class="form-control" id="edit-descripcion" name="descripcion" placeholder="Descripción"></textarea>
            </div>
          </div>

          <!-- Orden -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-sort-numeric-down"></i></span>
              <input type="number" class="form-control" id="edit-orden" name="orden" min="1" step="1" placeholder="Orden (ej: 1)">
            </div>
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
     MODAL ELIMINAR HABILIDAD
========================= -->
<div class="modal fade" id="deleteHabilidadModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg border-0">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">
          <i class="fas fa-exclamation-triangle me-2"></i> Confirmar eliminación
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <form id="deleteHabilidadForm" method="POST" action="views/habilidades/delete.php">
        <div class="modal-body text-center">
          <p class="mb-3">¿Estás seguro de que quieres eliminar esta habilidad?</p>

          <div class="mb-3">
            <select class="form-select" id="delete-habilidad-id" name="habilidad_id" required>
              <option value="">-- Selecciona Habilidad --</option>
              <?php foreach ($habilidades as $h): ?>
                <option value="<?= (int)$h->getId(); ?>">
                  <?= htmlspecialchars($h->getNombre()); ?> (<?= htmlspecialchars($h->getTipo()); ?>)
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <p class="text-danger small">Esta acción no se puede deshacer.</p>
        </div>

        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i> Cancelar
          </button>
          <button type="submit" class="btn btn-outline-danger">
            <i class="fas fa-trash-alt me-1"></i> Eliminar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>




<!-- ========================
     MODAL CONFIRMACIÓN
========================= -->
<div class="modal fade" id="modalConfirmHabilidad" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center border-0 shadow-lg">
      <div class="modal-body">
        <!-- Icono dinámico -->
        <i id="modalConfirmHabilidadIcon" class="fas fa-check-circle fa-3x mb-3 text-success"></i>
        <!-- Mensaje dinámico -->
        <h5 id="modalConfirmHabilidadMsg">Operación realizada correctamente</h5>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">
          <i class="fas fa-check me-1"></i> OK
        </button>
      </div>
    </div>
  </div>
</div>

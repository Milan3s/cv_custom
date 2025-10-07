<!-- Modal Insertar Educación -->
<div class="modal fade" id="insertEducacionModal" tabindex="-1" aria-labelledby="insertEducacionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content shadow-lg border-0">

      <div class="modal-header">
        <h5 class="modal-title text-dark" id="insertEducacionModalLabel">
          <i class="fas fa-graduation-cap me-2"></i> Añadir Educación
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <form id="insertEducacionForm" method="POST" action="views/educacion/insert.php">
        <div class="modal-body">

          <p class="text-muted mb-3">
            <i class="fas fa-info-circle me-2 text-primary"></i>
            Rellena los campos para añadir una nueva titulación o formación académica.
          </p>

          <!-- Titulación -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-certificate"></i></span>
              <input type="text" class="form-control" id="titulacion" name="titulacion" placeholder="Ej: Desarrollo de Aplicaciones Web" required>
            </div>
          </div>

          <!-- Centro -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-school"></i></span>
              <input type="text" class="form-control" id="centro" name="centro" placeholder="Ej: I.E.S. Alfonso X" required>
            </div>
          </div>

          <!-- Ubicación -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
              <input type="text" class="form-control" id="ubicacion" name="ubicacion" placeholder="Ej: Murcia" required>
            </div>
          </div>

          <!-- Fechas -->
          <div class="row">
            <div class="col-md-6 mb-3">
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
              </div>
            </div>
          </div>

          <!-- Orden -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-sort-numeric-down"></i></span>
              <input type="number" class="form-control" id="orden" name="orden" placeholder="Ej: 1" min="1" required>
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

<!-- Modal Editar Educación -->
<div class="modal fade" id="editEducacionModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content shadow-lg border-0">

      <div class="modal-header">
        <h5 class="modal-title text-dark">
          <i class="fas fa-edit me-2"></i> Editar Educación
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <form id="editEducacionForm" method="POST" action="views/educacion/update.php">
        <div class="modal-body">

          <p class="text-muted mb-3">
            <i class="fas fa-info-circle me-2 text-primary"></i>
            Selecciona un registro de educación y modifica los campos necesarios.
          </p>

          <!-- Seleccionar educación -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-list"></i></span>
              <select id="educacion_select" class="form-select" name="id" required>
                <option value="">-- Selecciona Educación --</option>
                <?php foreach ($educacion as $e): ?>
                  <option value="<?= $e->getId(); ?>">
                    <?= htmlspecialchars($e->getTitulacion()); ?> (<?= htmlspecialchars($e->getCentro()); ?>)
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <!-- Titulación -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-certificate"></i></span>
              <input type="text" class="form-control" id="edit-titulacion" name="titulacion" placeholder="Titulación">
            </div>
          </div>

          <!-- Centro -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-school"></i></span>
              <input type="text" class="form-control" id="edit-centro" name="centro" placeholder="Centro">
            </div>
          </div>

          <!-- Ubicación -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
              <input type="text" class="form-control" id="edit-ubicacion" name="ubicacion" placeholder="Ubicación">
            </div>
          </div>

          <!-- Fechas -->
          <div class="row">
            <div class="col-md-6 mb-3">
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                <input type="date" class="form-control" id="edit-fecha-inicio" name="fecha_inicio">
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                <input type="date" class="form-control" id="edit-fecha-fin" name="fecha_fin">
              </div>
            </div>
          </div>

          <!-- Orden -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-sort-numeric-down"></i></span>
              <input type="number" class="form-control" id="edit-orden" name="orden" min="1" placeholder="Orden (ej: 1)">
            </div>
            <small class="text-muted">Menor número se mostrará primero en la lista.</small>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i> Cancelar
          </button>
          <button type="submit" class="btn btn-outline-success">
            <i class="fas fa-save me-1"></i> Guardar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Eliminar Educación -->
<div class="modal fade" id="deleteEducacionModal" tabindex="-1" aria-labelledby="deleteEducacionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg border-0">

      <div class="modal-header">
        <h5 class="modal-title text-dark" id="deleteEducacionModalLabel">
          <i class="fas fa-trash-alt me-2 text-danger"></i> Eliminar Educación
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <form id="deleteEducacionForm" method="POST" action="views/educacion/delete.php">
        <div class="modal-body">
          <p class="text-muted mb-3">
            <i class="fas fa-info-circle me-2 text-primary"></i>
            Selecciona la titulación que deseas eliminar de tu historial académico.
          </p>

          <!-- Select dinámico -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
              <select class="form-select" id="educacion_id" name="educacion_id" required>
                <option value="">-- Selecciona una titulación --</option>
                <?php foreach ($educacion as $e): ?>
                  <option value="<?= $e->getId(); ?>">
                    <?= htmlspecialchars($e->getTitulacion()); ?> (<?= htmlspecialchars($e->getCentro()); ?>)
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

<!-- Modal Confirmación Genérico -->
<div class="modal fade" id="modalConfirmEducacion" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center">
      <div class="modal-body">
        <!-- Icono dinámico -->
        <i id="modalConfirmEducacionIcon" class="fas fa-check-circle fa-3x mb-3 text-success"></i>
        <!-- Mensaje dinámico -->
        <h5 id="modalConfirmEducacionMsg">Operación realizada correctamente</h5>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success" data-bs-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>

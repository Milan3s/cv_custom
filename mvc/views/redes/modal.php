<!-- Modal Insertar Red Social -->
<div class="modal fade" id="insertRedSocialModal" tabindex="-1" aria-labelledby="insertRedSocialModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg border-0">

      <div class="modal-header">
        <h5 class="modal-title text-dark" id="insertRedSocialModalLabel">
          <i class="fas fa-plus-circle me-2"></i> Añadir Red Social
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <form id="insertRedSocialForm" method="POST" action="views/redes/insert.php">
        <div class="modal-body">

          <p class="text-muted mb-3">
            <i class="fas fa-info-circle me-2"></i>
            Rellena los campos para añadir una red social a tu perfil.
          </p>

          <!-- Plataforma -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-globe"></i></span>
              <input type="text" class="form-control" id="plataforma" name="plataforma" placeholder="Ej: LinkedIn" required>
            </div>
          </div>

          <!-- Usuario -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-user"></i></span>
              <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Ej: dmilanes" required>
            </div>
          </div>

          <!-- URL -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-link"></i></span>
              <input type="url" class="form-control" id="url" name="url" placeholder="https://..." required>
            </div>
          </div>

          <!-- Icono -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-icons"></i></span>
              <input type="text" class="form-control" id="icono" name="icono" placeholder="Ej: fab fa-linkedin">
              <span class="input-group-text"><i id="iconPreviewInsert"></i></span>
            </div>
            <small class="text-muted">Usa clases de FontAwesome (ejemplo: <code>fab fa-linkedin</code>).</small>
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



<!-- Modal Editar Red Social -->
<div class="modal fade" id="editRedSocialModal" tabindex="-1" aria-labelledby="editRedSocialModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg border-0">

      <div class="modal-header">
        <h5 class="modal-title text-dark" id="editRedSocialModalLabel">
          <i class="fas fa-edit me-2"></i> Editar Red Social
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body">

        <p class="text-muted mb-3">
          <i class="fas fa-info-circle me-2"></i>
          Selecciona la red social que deseas modificar y actualiza los campos necesarios.
        </p>

        <!-- Select con todas las redes -->
        <div class="mb-3">
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-network-wired"></i></span>
            <select id="select-red" class="form-select" required>
              <option value="">-- Selecciona una red --</option>
              <?php foreach ($redes as $r): ?>
                <option 
                  value="<?= $r->getId(); ?>"
                  data-icono="<?= htmlspecialchars($r->getIcono()); ?>"
                  data-plataforma="<?= htmlspecialchars($r->getPlataforma()); ?>"
                  data-usuario="<?= htmlspecialchars($r->getUsuario()); ?>"
                  data-url="<?= htmlspecialchars($r->getUrl()); ?>"
                >
                  <?= htmlspecialchars($r->getPlataforma()); ?> (<?= htmlspecialchars($r->getUsuario()); ?>)
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <!-- Campos a editar -->
        <input type="hidden" id="red-id">

        <!-- Icono -->
        <div class="mb-3">
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-icons"></i></span>
            <input type="text" class="form-control" id="red-icono" placeholder="Ej: fab fa-twitter">
            <span class="input-group-text"><i id="preview-red-icono" class="fas fa-question-circle"></i></span>
          </div>
          <small class="text-muted">Clases de FontAwesome, ej: <code>fab fa-twitter</code></small>
        </div>

        <!-- Plataforma -->
        <div class="mb-3">
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-globe"></i></span>
            <input type="text" class="form-control" id="red-plataforma" placeholder="Ej: Twitter">
          </div>
        </div>

        <!-- Usuario -->
        <div class="mb-3">
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-user"></i></span>
            <input type="text" class="form-control" id="red-usuario" placeholder="Ej: dmilanes">
          </div>
        </div>

        <!-- URL -->
        <div class="mb-3">
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-link"></i></span>
            <input type="url" class="form-control" id="red-url" placeholder="https://...">
          </div>
        </div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
          <i class="fas fa-times me-1"></i> Cancelar
        </button>
        <button type="button" class="btn btn-outline-success" id="guardar-red">
          <i class="fas fa-save me-1"></i> Guardar
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Eliminar Red Social -->
<div class="modal fade" id="deleteRedSocialModal" tabindex="-1" aria-labelledby="deleteRedSocialModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg border-0">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="deleteRedSocialModalLabel">
          <i class="fas fa-trash-alt text-danger me-2"></i> Eliminar Red Social
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <form id="deleteRedForm" method="POST" action="views/redes/delete.php">
        <div class="modal-body">

          <p class="text-muted mb-3">
            <i class="fas fa-info-circle me-2 text-secondary"></i>
            Selecciona la red social que deseas eliminar de tu perfil. 
            <strong>Esta acción no se puede deshacer.</strong>
          </p>

          <!-- Select dinámico -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-network-wired"></i></span>
              <select class="form-select" id="red_id" name="red_id" required>
                <option value="">-- Selecciona una red --</option>
                <?php foreach ($redes as $r): ?>
                  <option value="<?= $r->getId(); ?>">
                    <?= htmlspecialchars($r->getPlataforma()); ?> (<?= htmlspecialchars($r->getUsuario()); ?>)
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
            <i class="fas fa-trash-alt me-1"></i> Eliminar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Confirmación (unificado para todas las operaciones en redes) -->
<div class="modal fade" id="modalConfirmRed" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center">
      <div class="modal-body">
        <i class="fas fa-check-circle text-success fa-3x mb-3"></i>
        <h5 id="modalConfirmRedMsg">Operación realizada correctamente</h5>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success" data-bs-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>

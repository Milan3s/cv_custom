<?php
require_once __DIR__ . "/../../controllers/CertificadoController.php";
require_once __DIR__ . "/../../controllers/SeccionController.php";

// Cargar todos los certificados (sin paginación)
$certificadoController = new CertificadoController();
$certificados = $certificadoController->getAll();

// Cargar secciones si no están definidas
if (!isset($secciones)) {
  $seccionController = new SeccionController();
  $secciones = $seccionController->getSecciones();
}
?>

<!-- Modal Insertar Certificado -->
<div class="modal fade" id="insertCertificadoModal" tabindex="-1" aria-labelledby="insertCertificadoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content shadow-lg border-0">

      <div class="modal-header">
        <h5 class="modal-title text-dark" id="insertCertificadoModalLabel">
          <i class="fas fa-plus-circle me-2"></i> Añadir Certificado
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <form id="insertCertificadoForm" method="POST" action="views/certificados/insert.php">
        <div class="modal-body">
          <p class="text-muted mb-3">
            <i class="fas fa-info-circle me-2 text-primary"></i>
            Rellena los campos para añadir un nuevo certificado.
          </p>

          <!-- Sección -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-folder"></i></span>
              <select id="seccion_id" name="seccion_id" class="form-select">
                <option value="">-- Selecciona Sección (opcional) --</option>
                <?php foreach ($secciones as $s): ?>
                  <option value="<?= $s->getId(); ?>"><?= htmlspecialchars($s->getNombre()); ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <!-- Título -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-certificate"></i></span>
              <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Ej: Git y GitHub" required>
            </div>
          </div>

          <!-- Entidad -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-university"></i></span>
              <input type="text" class="form-control" id="entidad" name="entidad" placeholder="Ej: Udemy, Instituto" required>
            </div>
          </div>

          <!-- Fecha -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
              <input type="date" class="form-control" id="fecha" name="fecha" required>
            </div>
          </div>

          <!-- URL -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-link"></i></span>
              <input type="url" class="form-control" id="url" name="url" placeholder="Enlace al certificado (opcional)">
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

<!-- Modal Editar Certificado -->
<div class="modal fade" id="editCertificadoModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content shadow-lg border-0">

      <div class="modal-header">
        <h5 class="modal-title text-dark">
          <i class="fas fa-edit me-2"></i> Editar Certificado
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <form id="editCertificadoForm" method="POST" action="views/certificados/update.php">
        <div class="modal-body">
          <p class="text-muted mb-3">
            <i class="fas fa-info-circle me-2 text-primary"></i>
            Selecciona un certificado y modifica los campos necesarios.
          </p>

          <!-- Seleccionar certificado -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-list"></i></span>
              <select id="certificado_select" class="form-select" name="id" required>
                <option value="">-- Selecciona Certificado --</option>
                <?php foreach ($certificados as $c): ?>
                  <option value="<?= $c->getId(); ?>">
                    <?= htmlspecialchars($c->getTitulo()); ?> (<?= htmlspecialchars($c->getEntidad()); ?>)
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <!-- Hidden: usuario -->
          <input type="hidden" name="usuario_id" value="<?= $_SESSION['usuario_id'] ?? 1; ?>">

          <!-- Sección -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-folder"></i></span>
              <select id="edit-seccion_id" name="seccion_id" class="form-select">
                <option value="">-- Selecciona Sección (opcional) --</option>
                <?php foreach ($secciones as $s): ?>
                  <option value="<?= $s->getId(); ?>"><?= htmlspecialchars($s->getNombre()); ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <!-- Título -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-certificate"></i></span>
              <input type="text" class="form-control" id="edit-titulo" name="titulo" placeholder="Título">
            </div>
          </div>

          <!-- Entidad -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-university"></i></span>
              <input type="text" class="form-control" id="edit-entidad" name="entidad" placeholder="Entidad">
            </div>
          </div>

          <!-- Fecha -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
              <input type="date" class="form-control" id="edit-fecha" name="fecha">
            </div>
          </div>

          <!-- URL -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-link"></i></span>
              <input type="url" class="form-control" id="edit-url" name="url" placeholder="Enlace al certificado">
            </div>
          </div>

          <!-- Orden -->
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-sort-numeric-down"></i></span>
              <input type="number" class="form-control" id="edit-orden" name="orden" min="1" placeholder="Orden (ej: 1)">
            </div>
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

<!-- Modal Eliminar Certificado -->
<div class="modal fade" id="deleteCertificadoModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg border-0">
      <div class="modal-header">
        <h5 class="modal-title text-dark">
          <i class="fas fa-trash-alt text-danger me-2"></i> Eliminar Certificado
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <form id="deleteCertificadoForm" method="POST" action="views/certificados/delete.php">
        <div class="modal-body">
          <p class="text-muted">Selecciona el certificado que deseas eliminar:</p>
          <div class="mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="fas fa-list"></i></span>
              <select id="certificado_delete_select" name="certificado_id" class="form-select" required>
                <option value="">-- Selecciona Certificado --</option>
                <?php foreach ($certificados as $c): ?>
                  <option value="<?= $c->getId(); ?>">
                    <?= htmlspecialchars($c->getTitulo()); ?> (<?= htmlspecialchars($c->getEntidad()); ?>)
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


<!-- Modal Confirmación Genérico (OK/KO) -->
<div class="modal fade" id="modalConfirmCertificado" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center">
      <div class="modal-body">
        <i id="modalConfirmCertificadoIcon" class="fas fa-check-circle fa-3x mb-3 text-success"></i>
        <h5 id="modalConfirmCertificadoMsg">Operación realizada correctamente</h5>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success" data-bs-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Confirmación Acción (Aceptar / Cancelar) -->
<div class="modal fade" id="modalConfirmAction" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg border-0 text-center">
      <div class="modal-header">
        <h5 class="modal-title text-dark">
          <i class="fas fa-question-circle text-warning me-2"></i> Confirmar Acción
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p id="modalConfirmActionMsg" class="mb-0">
          ¿Estás seguro de realizar esta acción?
        </p>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="fas fa-times me-1"></i> Cancelar
        </button>
        <button type="button" class="btn btn-danger" id="modalConfirmActionOk">
          <i class="fas fa-check me-1"></i> Aceptar
        </button>
      </div>
    </div>
  </div>
</div>

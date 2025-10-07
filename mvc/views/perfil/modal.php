<!-- Modal Insertar Perfil -->
<div class="modal fade" id="insertPerfilModal" tabindex="-1" aria-labelledby="insertPerfilModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow-lg border-0">
      <div class="modal-header">
        <h5 class="modal-title text-dark">
          <i class="fas fa-user-plus me-2"></i>Añadir Perfil
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <form id="insertPerfilForm" method="POST" action="views/perfil/insert.php" enctype="multipart/form-data">
        <div class="modal-body">

          <!-- Texto introductorio -->
          <p class="mb-4 text-muted">
            <i class="fas fa-info-circle me-2"></i>Rellena los campos para insertar un nuevo perfil en tu currículum.
          </p>

          <div class="row g-3">
            <!-- Columna izquierda -->
            <div class="col-md-6">

              <!-- Foto -->
              <div class="mb-3 text-center">
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-camera"></i></span>
                  <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                </div>
                <div class="mt-3">
                  <img id="preview-foto" src="" alt="Previsualización" class="img-thumbnail d-none" style="max-width: 150px; height:auto;">
                </div>
              </div>

              <!-- Alias -->
              <div class="mb-3">
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                  <input type="text" class="form-control" id="alias" name="alias" placeholder="Nombre / Alias (Ej: David Milanés)" required>
                </div>
              </div>

              <!-- Profesión -->
              <div class="mb-3">
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                  <input type="text" class="form-control" id="profesion" name="profesion" placeholder="Profesión / Rol (Ej: Desarrollador Fullstack)" required>
                </div>
              </div>

              <!-- Bio -->
              <div class="mb-3">
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-align-left"></i></span>
                  <textarea class="form-control" id="bio" name="bio" rows="4" placeholder="Escribe una breve descripción..." required></textarea>
                </div>
              </div>

              <!-- Sitio web -->
              <div class="mb-3">
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-globe"></i></span>
                  <input type="url" class="form-control" id="sitio_web" name="sitio_web" placeholder="https://miweb.com">
                </div>
              </div>

            </div>

            <!-- Columna derecha -->
            <div class="col-md-6">

              <!-- Email -->
              <div class="mb-3">
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                  <input type="email" class="form-control" id="email" name="email" placeholder="ejemplo@correo.com">
                </div>
              </div>

              <!-- Icono correo -->
              <div class="mb-3">
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-icons"></i></span>
                  <input type="text" class="form-control" id="icono_email" name="icono_email" placeholder="fas fa-envelope">
                  <span class="input-group-text"><i id="preview_icono_email"></i></span>
                </div>
              </div>

              <!-- Teléfono -->
              <div class="mb-3">
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-phone"></i></span>
                  <input type="text" class="form-control" id="telefono" name="telefono" placeholder="+34 600 000 000">
                </div>
              </div>

              <!-- Icono teléfono -->
              <div class="mb-3">
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-icons"></i></span>
                  <input type="text" class="form-control" id="icono_telefono" name="icono_telefono" placeholder="fas fa-phone">
                  <span class="input-group-text"><i id="preview_icono_telefono"></i></span>
                </div>
              </div>

              <!-- Dirección -->
              <div class="mb-3">
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                  <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Ciudad, País">
                </div>
              </div>

              <!-- Icono dirección -->
              <div class="mb-3">
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-icons"></i></span>
                  <input type="text" class="form-control" id="icono_direccion" name="icono_direccion" placeholder="fas fa-map-marker-alt">
                  <span class="input-group-text"><i id="preview_icono_direccion"></i></span>
                </div>
              </div>

            </div>
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

<!-- Modal Editar Perfil -->
<div class="modal fade" id="editPerfilModal" tabindex="-1" aria-labelledby="editPerfilModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow-lg border-0">

      <div class="modal-header">
        <h5 class="modal-title text-dark" id="editPerfilModalLabel">
          <i class="fas fa-user-edit me-2"></i> Editar Perfil
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body">
        <p class="mb-3 text-muted">
          <i class="fas fa-info-circle me-2"></i>Selecciona el campo del perfil que deseas editar y modifica su valor.
        </p>

        <!-- Selección de campo -->
        <div class="mb-3">
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-tasks"></i></span>
            <select id="selectPerfilCampo" class="form-select" required>
              <option value="alias">Nombre / Alias</option>
              <option value="profesion">Profesión / Rol</option>
              <option value="bio">Descripción / Bio</option>
              <option value="email">Correo electrónico</option>
              <option value="telefono">Teléfono</option>
              <option value="direccion">Dirección</option>
              <option value="sitio_web">Sitio web</option>
              <option value="foto">Foto</option>
            </select>
          </div>
        </div>

        <!-- Campo dinámico -->
        <div id="perfil-edit-field" class="mt-3">
          <!-- Se llena con JS -->
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-outline-secondary" data-bs-dismiss="modal">
          <i class="fas fa-times me-1"></i>Cancelar
        </button>
        <button class="btn btn-outline-success" id="guardarPerfil">
          <i class="fas fa-save me-1"></i>Guardar
        </button>
      </div>

    </div>
  </div>
</div>




<!-- Modal Eliminar Perfil -->
<div class="modal fade" id="deletePerfilModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Eliminar Perfil</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <p>⚠️ Esta acción vaciará los datos del perfil (alias, profesión, bio, email, teléfono, dirección).  
        ¿Quieres continuar?</p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button class="btn btn-danger" id="confirmDeletePerfil">Eliminar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Confirmación Perfil -->
<div class="modal fade" id="modalConfirmPerfil" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center">
      <div class="modal-body">
        <i class="fas fa-check-circle text-success fa-3x mb-3"></i>
        <h5 id="modalConfirmPerfilMsg">Operación realizada correctamente</h5>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success" data-bs-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>


document.addEventListener("DOMContentLoaded", () => {

  /* ==============================
     MODAL DE CONFIRMACIÓN
  ============================== */
  function showConfirmPerfil(msg = "Operación realizada correctamente", type = "success", reload = false) {
    const modalEl = document.getElementById("modalConfirmPerfil");
    const msgEl   = document.getElementById("modalConfirmPerfilMsg");
    const iconEl  = document.getElementById("modalConfirmPerfilIcon");

    if (msgEl) msgEl.textContent = msg;
    if (iconEl) {
      iconEl.className =
        type === "success"
          ? "fas fa-check-circle fa-3x mb-3 text-success"
          : "fas fa-times-circle fa-3x mb-3 text-danger";
    }

    const modal = new bootstrap.Modal(modalEl);
    modal.show();

    if (reload && type === "success") {
      modalEl.addEventListener("hidden.bs.modal", () => location.reload(), { once: true });
    }
  }

  function closeModal(modalId) {
    const modalEl = document.getElementById(modalId);
    if (!modalEl) return;

    const instance = bootstrap.Modal.getInstance(modalEl);
    if (instance) instance.hide();
  }

  /* ==============================
     INSERTAR PERFIL
  ============================== */
  const insertPerfilForm = document.getElementById("insertPerfilForm");
  const insertPerfilModal = document.getElementById("insertPerfilModal");

  if (insertPerfilForm) {
    insertPerfilForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const formData = new FormData(insertPerfilForm);

      try {
        const res = await fetch("views/perfil/insert.php", { method: "POST", body: formData });
        const data = await res.json();

        if (data.status === "success") {
          closeModal("insertPerfilModal");
          showConfirmPerfil("Perfil añadido correctamente", "success", true);
        } else {
          showConfirmPerfil(data.message || "Error al insertar", "error");
        }
      } catch {
        showConfirmPerfil("Error de conexión con el servidor", "error");
      }
    });
  }

  /* ==============================
     PREVISUALIZAR ICONOS EN INSERT
  ============================== */
  function setupIconPreview(inputId, previewId) {
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);

    if (input && preview) {
      input.addEventListener("input", () => {
        preview.className = input.value.trim() || "fas fa-question-circle";
      });
    }
  }
  setupIconPreview("icono_email", "preview_icono_email");
  setupIconPreview("icono_telefono", "preview_icono_telefono");
  setupIconPreview("icono_direccion", "preview_icono_direccion");

  /* ==============================
     EDITAR PERFIL
  ============================== */
  const selectCampo = document.getElementById("selectPerfilCampo");
  const editFieldContainer = document.getElementById("perfil-edit-field");

  let perfilData = {};
  const editPerfilModal = document.getElementById("editPerfilModal");

  if (editPerfilModal) {
    editPerfilModal.addEventListener("show.bs.modal", async () => {
      try {
        const res = await fetch("views/perfil/get.php");
        const data = await res.json();

        if (data.status === "success") {
          perfilData = data.data;
          if (selectCampo) selectCampo.dispatchEvent(new Event("change"));
        } else {
          perfilData = {};
          showConfirmPerfil("No se pudo cargar el perfil", "error");
        }
      } catch {
        showConfirmPerfil("Error al obtener los datos del perfil", "error");
      }
    });
  }

  if (selectCampo) {
    selectCampo.addEventListener("change", () => {
      const campo = selectCampo.value;
      editFieldContainer.innerHTML = "";
      if (!campo) return;

      if (campo === "bio") {
        editFieldContainer.innerHTML = `
          <label class="form-label"><i class="fas fa-align-left me-2"></i> Nuevo valor</label>
          <textarea id="perfilInput" class="form-control" rows="5" required>${perfilData.bio ?? ""}</textarea>
        `;
      } else if (campo === "foto") {
        editFieldContainer.innerHTML = `
          <label class="form-label"><i class="fas fa-camera me-2"></i> Nueva foto</label>
          <input type="file" id="perfilInput" name="foto" class="form-control" accept="image/*" required>
          <div class="mt-3">
            <img id="preview-foto-edit" src="${perfilData.foto ? IMG_URL + perfilData.foto : ""}" 
                 class="img-thumbnail ${perfilData.foto ? "" : "d-none"}" style="max-width:150px;">
          </div>
        `;
        const inputFile = editFieldContainer.querySelector("#perfilInput");
        const preview = editFieldContainer.querySelector("#preview-foto-edit");
        inputFile.addEventListener("change", () => {
          if (inputFile.files && inputFile.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
              preview.src = e.target.result;
              preview.classList.remove("d-none");
            };
            reader.readAsDataURL(inputFile.files[0]);
          }
        });
      } else if (campo === "email" || campo === "telefono" || campo === "direccion") {
        const iconField = "icono_" + campo;
        editFieldContainer.innerHTML = `
          <div class="row g-2">
            <div class="col-md-8">
              <label class="form-label"><i class="fas fa-edit me-2"></i> Nuevo valor</label>
              <textarea id="perfilInput" class="form-control" rows="2" required>${perfilData[campo] ?? ""}</textarea>
            </div>
            <div class="col-md-4">
              <label class="form-label"><i class="fas fa-icons me-2"></i> Icono</label>
              <div class="input-group">
                <input type="text" id="perfilIcon" class="form-control" value="${perfilData[iconField] ?? ""}">
                <span class="input-group-text"><i id="iconPreview" class="${perfilData[iconField] ?? ""}"></i></span>
              </div>
            </div>
          </div>
        `;
        const iconInput = editFieldContainer.querySelector("#perfilIcon");
        const iconPreview = editFieldContainer.querySelector("#iconPreview");
        iconInput.addEventListener("input", () => {
          iconPreview.className = iconInput.value.trim();
        });
      } else {
        editFieldContainer.innerHTML = `
          <label class="form-label"><i class="fas fa-edit me-2"></i> Nuevo valor</label>
          <textarea id="perfilInput" class="form-control" rows="2" required>${perfilData[campo] ?? ""}</textarea>
        `;
      }
    });
  }

  const guardarPerfilBtn = document.getElementById("guardarPerfil");
  if (guardarPerfilBtn) {
    guardarPerfilBtn.addEventListener("click", async () => {
      const campo = selectCampo.value;
      if (!campo) return showConfirmPerfil("Selecciona un campo antes de guardar", "error");

      const formData = new FormData();
      if (campo === "foto") {
        const inputFile = document.getElementById("perfilInput");
        if (!inputFile.files.length) {
          showConfirmPerfil("Selecciona una foto", "error");
          return;
        }
        formData.append("foto", inputFile.files[0]);
      } else if (["email", "telefono", "direccion"].includes(campo)) {
        formData.append(campo, document.getElementById("perfilInput").value.trim());
        formData.append("icono_" + campo, document.getElementById("perfilIcon").value.trim());
      } else {
        formData.append(campo, document.getElementById("perfilInput").value.trim());
      }

      try {
        const res = await fetch("views/perfil/update.php", { method: "POST", body: formData });
        const data = await res.json();

        if (data.status === "success") {
          closeModal("editPerfilModal");
          showConfirmPerfil("Perfil actualizado correctamente", "success", true);
        } else {
          showConfirmPerfil(data.message || "Error al actualizar", "error");
        }
      } catch {
        showConfirmPerfil("Error de conexión con el servidor", "error");
      }
    });
  }

  /* ==============================
     ELIMINAR PERFIL
  ============================== */
  const deletePerfilBtn = document.getElementById("confirmDeletePerfil");
  if (deletePerfilBtn) {
    deletePerfilBtn.addEventListener("click", async () => {
      try {
        const res = await fetch("views/perfil/delete.php", { method: "POST" });
        const data = await res.json();

        if (data.status === "success") {
          closeModal("deletePerfilModal");
          showConfirmPerfil("Perfil eliminado correctamente", "success", true);
        } else {
          showConfirmPerfil(data.message || "Error al eliminar", "error");
        }
      } catch {
        showConfirmPerfil("Error de conexión con el servidor", "error");
      }
    });
  }

  /* ==============================
     PREVISUALIZAR FOTO EN EL INSERT
  ============================== */
  const inputFotoModal = document.getElementById("foto");
  const previewFoto = document.getElementById("preview-foto");

  if (inputFotoModal && previewFoto) {
    inputFotoModal.addEventListener("change", () => {
      if (inputFotoModal.files && inputFotoModal.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
          previewFoto.src = e.target.result;
          previewFoto.classList.remove("d-none");
        };
        reader.readAsDataURL(inputFotoModal.files[0]);
      } else {
        previewFoto.src = "";
        previewFoto.classList.add("d-none");
      }
    });
  }
});

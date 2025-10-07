document.addEventListener("DOMContentLoaded", () => {

  /* ==============================
     Mostrar modal de confirmación
  ============================== */
  function showConfirm(msg = "Operación realizada correctamente") {
    const modalEl = document.getElementById("modalConfirmRed");
    document.getElementById("modalConfirmRedMsg").textContent = msg;

    const modal = new bootstrap.Modal(modalEl);
    modal.show();

    setTimeout(() => {
      const instance = bootstrap.Modal.getInstance(modalEl);
      if (instance) instance.hide();
    }, 5000);
  }

  /* ==============================
     INSERTAR red social
  ============================== */
  const insertForm = document.getElementById("insertRedSocialForm");
  if (insertForm) {
    const iconoInput = insertForm.querySelector("#icono");
    const previewIcon = document.getElementById("iconPreviewInsert");

    // Previsualizar icono
    if (iconoInput && previewIcon) {
      iconoInput.addEventListener("input", () => {
        previewIcon.className = iconoInput.value.trim();
      });
    }

    // Enviar formulario insertar
    insertForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const formData = new FormData(insertForm);

      try {
        const res = await fetch("views/redes/insert.php", {
          method: "POST",
          body: formData
        });
        const data = await res.json();

        if (data.status === "success") {
          bootstrap.Modal.getInstance(document.getElementById("insertRedSocialModal")).hide();
          insertForm.reset();
          previewIcon.className = "";
          showConfirm("Nueva red social añadida correctamente");

          // Añadir al DOM
          const container = document.querySelector(".social-icons");
          if (container) {
            const newItem = document.createElement("div");
            newItem.className = "social-item text-center";
            newItem.dataset.id = data.id;
            newItem.dataset.icono = formData.get("icono");
            newItem.dataset.plataforma = formData.get("plataforma");
            newItem.dataset.usuario = formData.get("usuario");
            newItem.dataset.url = formData.get("url");

            newItem.innerHTML = `
              <a href="${formData.get("url")}" target="_blank" 
                 class="text-dark d-flex flex-column align-items-center text-center px-2">
                <i class="${formData.get("icono")} fs-3 mb-1"></i>
                <span>${formData.get("plataforma")}</span>
              </a>
            `;
            container.appendChild(newItem);
          }

          // Añadir al select del modal editar
          const selectRed = document.getElementById("select-red");
          if (selectRed) {
            const opt = document.createElement("option");
            opt.value = data.id;
            opt.dataset.icono = formData.get("icono");
            opt.dataset.plataforma = formData.get("plataforma");
            opt.dataset.usuario = formData.get("usuario");
            opt.dataset.url = formData.get("url");
            opt.textContent = formData.get("plataforma");
            selectRed.appendChild(opt);
          }

        } else {
          showConfirm("⚠ Error al insertar red social");
        }
      } catch {
        showConfirm("❌ Error al insertar red social");
      }
    });
  }

  /* ==============================
     EDITAR red social
  ============================== */
  const modalRedEl = document.getElementById("editRedSocialModal");
  if (modalRedEl) {
    const modal = new bootstrap.Modal(modalRedEl);

    const selectRed = document.getElementById("select-red");
    const idInput = document.getElementById("red-id");
    const iconoInput = document.getElementById("red-icono");
    const iconoPreview = document.getElementById("preview-red-icono");
    const plataformaInput = document.getElementById("red-plataforma");
    const usuarioInput = document.getElementById("red-usuario");
    const urlInput = document.getElementById("red-url");

    // Cargar datos en el formulario desde <option>
    async function cargarDatos(option) {
      if (!option || !option.value) {
        //console.log("⚠ No se seleccionó ninguna opción válida");
        idInput.value = "";
        iconoInput.value = "";
        plataformaInput.value = "";
        usuarioInput.value = "";
        urlInput.value = "";
        iconoPreview.className = "fas fa-question-circle";
        return;
      }

      //console.log("✅ Opción seleccionada:", option);
      idInput.value = option.value;
      iconoInput.value = option.dataset.icono || "";
      plataformaInput.value = option.dataset.plataforma || "";
      usuarioInput.value = option.dataset.usuario || "";
      urlInput.value = option.dataset.url || "";
      iconoPreview.className = option.dataset.icono || "fas fa-question-circle";
    }

    // Cuando el usuario cambie de red
    if (selectRed) {
      selectRed.addEventListener("change", () => {
        const selected = selectRed.options[selectRed.selectedIndex];
        //console.log("🔄 Evento change → selectedIndex:", selectRed.selectedIndex);
        cargarDatos(selected);
      });
    }

    // Previsualizar icono en tiempo real
    if (iconoInput) {
      iconoInput.addEventListener("input", () => {
        //console.log("✏ Input icono cambiado →", iconoInput.value.trim());
        iconoPreview.className = iconoInput.value.trim() || "fas fa-question-circle";
      });
    }

    // Guardar cambios
    document.getElementById("guardar-red").addEventListener("click", async () => {
      const id = idInput.value;
      const newIcono = iconoInput.value.trim();
      const newPlataforma = plataformaInput.value.trim();
      const newUsuario = usuarioInput.value.trim();
      const newUrl = urlInput.value.trim();

      //console.log("💾 Guardando cambios:", { id, newIcono, newPlataforma, newUsuario, newUrl });

      if (!id) return showConfirm("⚠ Selecciona una red social válida");

      try {
        const res = await fetch("views/redes/update.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ id, icono: newIcono, plataforma: newPlataforma, usuario: newUsuario, url: newUrl })
        });
        const data = await res.json();

        //console.log("📥 Respuesta update.php:", data);

        if (data.status === "success") {
          // 🔄 1. Actualizar en la lista lateral (.social-item)
          const item = document.querySelector(`.social-item[data-id="${id}"]`);
          if (item) {
            item.dataset.icono = newIcono;
            item.dataset.plataforma = newPlataforma;
            item.dataset.usuario = newUsuario;
            item.dataset.url = newUrl;

            const link = item.querySelector("a");
            if (link) link.href = newUrl;

            const icon = item.querySelector("i");
            if (icon) icon.className = `${newIcono} fs-3 mb-1`;

            const span = item.querySelector("span");
            if (span) span.textContent = newPlataforma;
          }

          // 🔄 2. Actualizar también en el <select>
          const opt = document.querySelector(`#select-red option[value="${id}"]`);
          if (opt) {
            opt.dataset.icono = newIcono;
            opt.dataset.plataforma = newPlataforma;
            opt.dataset.usuario = newUsuario;
            opt.dataset.url = newUrl;
            opt.textContent = `${newPlataforma} (${newUsuario})`;
          }

          modal.hide();
          showConfirm("Red social actualizada correctamente");
        } else {
          showConfirm("⚠ Error al actualizar red social");
        }
      } catch (err) {
        //console.error("❌ Error de conexión al update.php:", err);
        showConfirm("❌ Error de conexión");
      }
    });
  }

  /* ==============================
     ELIMINAR red social
  ============================== */
  const deleteForm = document.getElementById("deleteRedForm");
  if (deleteForm) {
    deleteForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const formData = new FormData(deleteForm);

      try {
        const res = await fetch("views/redes/delete.php", {
          method: "POST",
          body: formData
        });
        const data = await res.json();

        if (data.status === "success") {
          bootstrap.Modal.getInstance(document.getElementById("deleteRedSocialModal")).hide();

          // Quitar del DOM
          const item = document.querySelector(`.social-item[data-id="${formData.get("red_id")}"]`);
          if (item) item.remove();

          // Quitar del select
          const opt = document.querySelector(`#select-red option[value="${formData.get("red_id")}"]`);
          if (opt) opt.remove();

          showConfirm("Red social borrada correctamente");
        } else {
          showConfirm("⚠ No se pudo borrar la red social");
        }
      } catch {
        showConfirm("❌ Error al borrar red social");
      }
    });
  }

});

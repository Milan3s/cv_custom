document.addEventListener("DOMContentLoaded", () => {
  /* ==============================
     Función para loguear en servidor
  ============================== */
  async function logToFile(mensaje, data = null) {
    try {
      await fetch("views/habilidades/log.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ mensaje, data })
      });
    } catch (err) {
      console.error("❌ Error escribiendo en log.txt:", err);
    }
  }

  /* ==============================
     Mantener Tab activa tras refresh
  ============================== */
  const tabKey = "activeTab";
  const savedTab = localStorage.getItem(tabKey);
  if (savedTab) {
    const el = document.querySelector(`[data-bs-target="${savedTab}"]`);
    if (el) new bootstrap.Tab(el).show();
  }

  document.querySelectorAll('button[data-bs-toggle="tab"], a[data-bs-toggle="tab"]').forEach(el => {
    el.addEventListener("shown.bs.tab", e => {
      const target = e.target.getAttribute("data-bs-target");
      if (target) localStorage.setItem(tabKey, target);
    });
  });

  /* ==============================
     MODAL CONFIRM GENÉRICO (OK/KO)
  ============================== */
  function showConfirm(msg = "Operación realizada correctamente", type = "success", reload = false) {
    const modalEl = document.getElementById("modalConfirmHabilidad");
    const msgEl   = document.getElementById("modalConfirmHabilidadMsg");
    const iconEl  = document.getElementById("modalConfirmHabilidadIcon");

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

  /* ==============================
     REFRESCAR LISTA HABILIDADES
  ============================== */
  async function refreshHabilidades() {
    try {
      const res = await fetch("views/habilidades/get.php");
      const data = await res.json();

      console.log("DEBUG refreshHabilidades → datos recibidos:", data);
      logToFile("refreshHabilidades", data);

      if (data.status === "success") {
        const cont = document.querySelector("#hab-list");
        if (!cont) return;

        let html = `<div class="row">`;
        const tiposUnicos = [...new Set(data.data.map(h => h.tipo))];

        tiposUnicos.forEach(tipo => {
          const filtradas = data.data.filter(h => h.tipo === tipo);

          if (filtradas.length > 0) {
            const label = tipo ? tipo.charAt(0).toUpperCase() + tipo.slice(1).replace("_"," ") : "Otros";
            html += `
              <div class="col-md-4 mb-4">
                <h5 class="fw-bold border-bottom pb-1 mb-3">${label}</h5>
                <ul class="skills-grid">
                  ${filtradas.map(h => `
                    <li>
                      <strong>${h.nombre}</strong>
                      ${h.descripcion ? `<br><small class="text-muted">${h.descripcion}</small>` : ""}
                    </li>
                  `).join("")}
                </ul>
              </div>`;
          }
        });

        html += `</div>`;
        cont.innerHTML = html;
      }
    } catch (err) {
      console.error("❌ Error al refrescar habilidades:", err);
      logToFile("❌ Error al refrescar habilidades", err);
    }
  }

  /* ==============================
     INSERTAR HABILIDAD
  ============================== */
  const insertForm = document.getElementById("insertHabilidadForm");
  if (insertForm) {
    insertForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const formData = new FormData(insertForm);

      console.log("DEBUG insert → datos enviados:", Object.fromEntries(formData.entries()));
      logToFile("insert → datos enviados", Object.fromEntries(formData.entries()));

      try {
        const res = await fetch("views/habilidades/insert.php", { method: "POST", body: formData });
        const data = await res.json();

        if (data.status === "success") {
          bootstrap.Modal.getInstance(document.getElementById("insertHabilidadModal")).hide();
          insertForm.reset();
          showConfirm("✅ Habilidad añadida correctamente", "success", true);
        } else {
          showConfirm(data.message || "❌ Error al insertar habilidad", "error");
        }
      } catch (err) {
        console.error("❌ Error de conexión en insert:", err);
        logToFile("❌ Error de conexión en insert", err);
        showConfirm("❌ Error de conexión con el servidor", "error");
      }
    });
  }

  /* ==============================
     EDITAR HABILIDAD
  ============================== */
  const editModal = document.getElementById("editHabilidadModal");
  if (editModal) {
    const editForm = editModal.querySelector("#editHabilidadForm");
    const selectHab = editModal.querySelector("#habilidad_select");
    const nombreInput = editModal.querySelector("#edit-nombre");
    const descripcionInput = editModal.querySelector("#edit-descripcion");
    const ordenInput = editModal.querySelector("#edit-orden");
    const selectSeccion = editModal.querySelector("#edit-seccion_id");
    const selectTipo = editModal.querySelector("#edit-tipo");

    let listaHabilidades = [];

    // Al abrir modal → cargar lista
    editModal.addEventListener("show.bs.modal", async () => {
      try {
        const res = await fetch("views/habilidades/get.php");
        const data = await res.json();

        if (data.status === "success") {
          listaHabilidades = data.data;
          selectHab.innerHTML = `<option value="">-- Selecciona Habilidad --</option>`;
          listaHabilidades.forEach(h => {
            selectHab.innerHTML += `<option value="${h.id}">${h.nombre} (${h.tipo})</option>`;
          });
        }
      } catch (err) {
        console.error("❌ Error cargando habilidades:", err);
      }
    });

    // Al seleccionar habilidad → pintar todos los campos
    selectHab.addEventListener("change", () => {
      const hab = listaHabilidades.find(h => h.id == selectHab.value);
      if (!hab) return;

      console.log("DEBUG edit → habilidad seleccionada:", hab);
      logToFile("edit → habilidad seleccionada", hab);

      nombreInput.value = hab.nombre || "";
      descripcionInput.value = hab.descripcion || "";
      ordenInput.value = hab.orden !== null ? String(hab.orden) : "";
      if (selectSeccion) selectSeccion.value = hab.seccion_id || "";
      if (selectTipo) selectTipo.value = hab.tipo || "";

      // Si hay inputs ocultos para id/usuario
      const hiddenId = editForm.querySelector("input[name='id']");
      if (hiddenId) hiddenId.value = hab.id;
      const hiddenUsuario = editForm.querySelector("input[name='usuario_id']");
      if (hiddenUsuario) hiddenUsuario.value = hab.usuario_id;
    });

    // Submit edición
    editForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const id = selectHab.value;
      if (!id) return showConfirm("⚠️ Selecciona primero una habilidad", "error");

      const newData = {
        id,
        usuario_id: editForm.querySelector("input[name='usuario_id']")?.value || null,
        nombre: nombreInput.value.trim(),
        tipo: selectTipo.value,
        descripcion: descripcionInput.value.trim(),
        orden: ordenInput.value.trim() || null,
        seccion_id: selectSeccion.value || null
      };

      console.log("DEBUG edit → datos enviados a update.php:", newData);
      logToFile("edit → datos enviados a update.php", newData);

      try {
        const res = await fetch("views/habilidades/update.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(newData)
        });
        const data = await res.json();

        if (data.status === "success") {
          bootstrap.Modal.getInstance(editModal).hide();
          showConfirm("✅ Habilidad actualizada correctamente", "success", true);
        } else {
          showConfirm(data.message || "❌ No se pudo actualizar la habilidad", "error");
        }
      } catch (err) {
        console.error("❌ Error de conexión en update:", err);
        showConfirm("❌ Error de conexión con el servidor", "error");
      }
    });
  }

  /* ==============================
     ELIMINAR HABILIDAD
  ============================== */
  const deleteForm = document.getElementById("deleteHabilidadForm");
  if (deleteForm) {
    deleteForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const formData = new FormData(deleteForm);

      try {
        const res = await fetch("views/habilidades/delete.php", { method: "POST", body: formData });
        const data = await res.json();

        if (data.status === "success") {
          bootstrap.Modal.getInstance(document.getElementById("deleteHabilidadModal")).hide();
          showConfirm("✅ Habilidad eliminada correctamente", "success", true);
        } else {
          showConfirm(data.message || "❌ No se pudo eliminar la habilidad", "error");
        }
      } catch (err) {
        console.error("❌ Error de conexión en delete:", err);
        showConfirm("❌ Error de conexión con el servidor", "error");
      }
    });
  }
});

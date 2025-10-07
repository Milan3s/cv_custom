document.addEventListener("DOMContentLoaded", () => {
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
     MODAL CONFIRMACIÓN GENÉRICO
  ============================== */
  function showConfirm(msg = "Operación realizada correctamente", type = "success", reload = false) {
    const modalEl = document.getElementById("modalConfirmOtros");
    const msgEl   = document.getElementById("modalConfirmOtrosMsg");
    const iconEl  = document.getElementById("modalConfirmOtrosIcon");

    if (msgEl) msgEl.textContent = msg;
    if (iconEl) {
      iconEl.className =
        type === "success"
          ? "fas fa-check-circle fa-3x mb-3 text-success"
          : "fas fa-times-circle fa-3x mb-3 text-danger";
    }

    const modal = new bootstrap.Modal(modalEl);
    modal.show();

    // 🔹 Siempre recargar al cerrar, si reload está activo
    if (reload) {
      modalEl.addEventListener("hidden.bs.modal", () => location.reload(), { once: true });
    }
  }

  /* ==============================
     REFRESCAR LISTA OTROS DATOS
  ============================== */
  async function refreshOtros() {
    try {
      const res = await fetch("views/otros-datos/get.php");
      const data = await res.json();

      if (data.status === "success") {
        const cont = document.querySelector("#otros-list");
        if (!cont) return;

        let html = `<ul class="list-group">`;
        data.data.forEach(d => {
          html += `
            <li class="list-group-item">
              <strong>${d.titulo}</strong>
              ${d.descripcion ? `<br><small class="text-muted">${d.descripcion}</small>` : ""}
            </li>`;
        });
        html += `</ul>`;

        cont.innerHTML = html;
      }
    } catch (err) {
      console.error("❌ Error al refrescar otros datos:", err);
    }
  }

  /* ==============================
     INSERTAR OTRO DATO
  ============================== */
  const insertOtrosForm = document.getElementById("insertOtrosForm");
  if (insertOtrosForm) {
    insertOtrosForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const formData = new FormData(insertOtrosForm);

      try {
        const res = await fetch("views/otros-datos/insert.php", { method: "POST", body: formData });
        const data = await res.json();

        if (data.status === "success") {
          bootstrap.Modal.getInstance(document.getElementById("insertOtrosModal")).hide();
          insertOtrosForm.reset();
          showConfirm("✅ Dato añadido correctamente", "success", true); // 🔹 reload
        } else {
          showConfirm(data.message || "❌ Error al insertar", "error", true);
        }
      } catch {
        showConfirm("❌ Error de conexión con el servidor", "error", true);
      }
    });
  }

  /* ==============================
     EDITAR OTRO DATO
  ============================== */
  const editOtrosForm = document.getElementById("editOtrosForm");
  const selectOtros   = document.getElementById("otros_select");
  const selectSeccion = document.getElementById("edit-seccion_id"); // 🔹 referencia directa

  if (editOtrosForm && selectOtros) {
    let listaOtros = [];

    document.getElementById("editOtrosModal").addEventListener("show.bs.modal", async () => {
      try {
        const res = await fetch("views/otros-datos/get.php");
        const data = await res.json();
        if (data.status === "success") {
          listaOtros = data.data;
          selectOtros.innerHTML = `<option value="">-- Selecciona Dato --</option>`;
          listaOtros.forEach(d => {
            selectOtros.innerHTML += `<option value="${d.id}">${d.titulo}</option>`;
          });
        }
      } catch {
        showConfirm("❌ No se pudieron cargar los datos", "error", true);
      }
    });

    selectOtros.addEventListener("change", () => {
      const dato = listaOtros.find(d => d.id == selectOtros.value);
      if (!dato) return;
      document.getElementById("edit-titulo-otros").value      = dato.titulo || "";
      document.getElementById("edit-descripcion-otros").value = dato.descripcion || "";
      document.getElementById("edit-orden-otros").value       = dato.orden || "";

      // 🔹 Forzar seteo correcto de seccion_id
      if (selectSeccion) {
        if ([...selectSeccion.options].some(opt => opt.value == dato.seccion_id)) {
          selectSeccion.value = dato.seccion_id;
        } else {
          selectSeccion.value = "";
        }
      }
    });

    editOtrosForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const id = selectOtros.value;
      if (!id) return showConfirm("⚠️ Selecciona primero un dato", "error", true);

      const newData = {
        id,
        titulo: document.getElementById("edit-titulo-otros").value.trim(),
        descripcion: document.getElementById("edit-descripcion-otros").value.trim(),
        orden: document.getElementById("edit-orden-otros").value.trim() || null,
        seccion_id: selectSeccion ? (selectSeccion.value || null) : null
      };

      try {
        const res = await fetch("views/otros-datos/update.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(newData)
        });
        const data = await res.json();

        if (data.status === "success") {
          bootstrap.Modal.getInstance(document.getElementById("editOtrosModal")).hide();
          showConfirm("✅ Dato actualizado correctamente", "success", true);
        } else {
          showConfirm(data.message || "❌ No se pudo actualizar", "error", true);
        }
      } catch {
        showConfirm("❌ Error de conexión con el servidor", "error", true);
      }
    });
  }

  /* ==============================
     ELIMINAR OTRO DATO
  ============================== */
  const deleteOtrosForm = document.getElementById("deleteOtrosForm");
  if (deleteOtrosForm) {
    deleteOtrosForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const formData = new FormData(deleteOtrosForm);

      try {
        const res = await fetch("views/otros-datos/delete.php", { method: "POST", body: formData });
        const data = await res.json();

        if (data.status === "success") {
          bootstrap.Modal.getInstance(document.getElementById("deleteOtrosModal")).hide();
          showConfirm("✅ Dato eliminado correctamente", "success", true);
        } else {
          showConfirm(data.message || "❌ No se pudo eliminar", "error", true);
        }
      } catch {
        showConfirm("❌ Error de conexión con el servidor", "error", true);
      }
    });
  }
});

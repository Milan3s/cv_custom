document.addEventListener("DOMContentLoaded", () => {

  /* ==============================
     MODAL CONFIRMACIÓN
  ============================== */
  function showConfirm(msg = "Operación realizada correctamente", type = "success", reload = false) {
    const modalEl = document.getElementById("modalConfirmExperiencia");
    const msgEl   = document.getElementById("modalConfirmExperienciaMsg");
    const iconEl  = document.getElementById("modalConfirmExperienciaIcon");

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
     INSERTAR EXPERIENCIA
  ============================== */
  const insertForm = document.getElementById("insertExperienciaForm");
  if (insertForm) {
    insertForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const formData = new FormData(insertForm);

      try {
        const res = await fetch("views/experiencia/insert.php", {
          method: "POST",
          body: formData
        });
        const data = await res.json();

        if (data.status === "success") {
          bootstrap.Modal.getInstance(document.getElementById("insertExperienciaModal")).hide();
          insertForm.reset();
          showConfirm("✅ Experiencia añadida correctamente", "success", true);
        } else {
          showConfirm(data.message || "❌ Error al insertar experiencia", "error");
        }
      } catch (err) {
        console.error("Error al insertar experiencia:", err);
        showConfirm("❌ Error de conexión con el servidor", "error");
      }
    });
  }

  /* ==============================
     EDITAR EXPERIENCIA
  ============================== */
  const selectExp = document.getElementById("exp_select");
  const selectSeccion = document.getElementById("exp-seccion");

  if (selectExp) {
    selectExp.addEventListener("change", () => {
      const option = selectExp.options[selectExp.selectedIndex];
      if (!option.value) return;

      // Rellenar inputs desde los data-*
      document.getElementById("exp-id").value = option.value;
      document.getElementById("exp-rol").value = option.dataset.rol || "";
      document.getElementById("exp-empresa").value = option.dataset.empresa || "";
      document.getElementById("exp-ubicacion").value = option.dataset.ubicacion || "";
      document.getElementById("exp-fecha-inicio").value = option.dataset.fechaInicio || "";
      document.getElementById("exp-fecha-fin").value = option.dataset.fechaFin || "";
      document.getElementById("exp-descripcion").value = option.dataset.descripcion || "";
      document.getElementById("exp-orden").value = option.dataset.orden || 1;

      // 👇 También seleccionamos la sección correcta
      if (selectSeccion) {
        selectSeccion.value = option.dataset.seccion || "";
      }
    });
  }

  // Cuando cambie la sección, actualizamos el dataset del option seleccionado
  if (selectSeccion && selectExp) {
    selectSeccion.addEventListener("change", () => {
      const option = selectExp.options[selectExp.selectedIndex];
      if (option) {
        option.dataset.seccion = selectSeccion.value;
      }
    });
  }

  const editForm = document.getElementById("editExperienciaForm");
  if (editForm) {
    editForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const expId = document.getElementById("exp-id").value;
      if (!expId) return showConfirm("⚠️ Debes seleccionar una experiencia", "error");

      const payload = {
        id: expId,
        rol: document.getElementById("exp-rol").value,
        empresa: document.getElementById("exp-empresa").value,
        ubicacion: document.getElementById("exp-ubicacion").value,
        fecha_inicio: document.getElementById("exp-fecha-inicio").value,
        fecha_fin: document.getElementById("exp-fecha-fin").value,
        descripcion: document.getElementById("exp-descripcion").value,
        orden: document.getElementById("exp-orden").value,
        seccion_id: selectSeccion ? selectSeccion.value : null
      };

      try {
        const res = await fetch("views/experiencia/update.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(payload)
        });
        const result = await res.json();

        if (result.status === "success") {
          bootstrap.Modal.getInstance(document.getElementById("editExperienciaModal")).hide();
          showConfirm("✅ Experiencia actualizada correctamente", "success", true);
        } else {
          showConfirm(result.message || "❌ Error al actualizar", "error");
        }
      } catch (err) {
        console.error("Error actualizando experiencia:", err);
        showConfirm("❌ Error de conexión con el servidor", "error");
      }
    });
  }

  /* ==============================
     ELIMINAR EXPERIENCIA
  ============================== */
  const deleteForm = document.getElementById("deleteExperienciaForm");
  if (deleteForm) {
    deleteForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const expId = document.getElementById("exp_id").value;
      if (!expId) return showConfirm("⚠️ Debes seleccionar una experiencia para eliminar", "error");

      try {
        const res = await fetch("views/experiencia/delete.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ id: expId })
        });
        const data = await res.json();

        if (data.status === "success") {
          bootstrap.Modal.getInstance(document.getElementById("deleteExperienciaModal")).hide();
          showConfirm("✅ Experiencia eliminada correctamente", "success", true);
        } else {
          showConfirm(data.message || "❌ No se pudo eliminar", "error");
        }
      } catch (err) {
        console.error("Error eliminando experiencia:", err);
        showConfirm("❌ Error de conexión con el servidor", "error");
      }
    });
  }
});

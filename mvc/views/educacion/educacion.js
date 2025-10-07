document.addEventListener("DOMContentLoaded", () => {
  /* ==============================
     Modal de confirmación genérico
  ============================== */
  function showConfirm(msg = "Operación realizada correctamente", type = "success") {
    const modalEl = document.getElementById("modalConfirmEducacion");
    const msgEl = document.getElementById("modalConfirmEducacionMsg");
    const iconEl = document.getElementById("modalConfirmEducacionIcon");

    if (msgEl) msgEl.textContent = msg;

    // Cambiar icono según tipo
    if (iconEl) {
      if (type === "success") {
        iconEl.className = "fas fa-check-circle fa-3x mb-3 text-success";
      } else {
        iconEl.className = "fas fa-times-circle fa-3x mb-3 text-danger";
      }
    }

    const modal = new bootstrap.Modal(modalEl);
    modal.show();
  }

  /* ==============================
     INSERT
  ============================== */
  const insertForm = document.getElementById("insertEducacionForm");
  if (insertForm) {
    insertForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const formData = new FormData(insertForm);

      try {
        const res = await fetch("views/educacion/insert.php", {
          method: "POST",
          body: formData
        });
        const data = await res.json();

        if (data.status === "success") {
          bootstrap.Modal.getInstance(document.getElementById("insertEducacionModal")).hide();
          insertForm.reset();
          showConfirm(data.message || "✅ Nueva educación añadida correctamente", "success");

          // 🚀 Refrescar después de insertar
          setTimeout(() => location.reload(), 1200);
        } else {
          showConfirm(data.message || "⚠ Error al insertar", "error");
        }
      } catch (err) {
        console.error("Insert error:", err);
        showConfirm("❌ Error de conexión al insertar", "error");
      }
    });
  }

  /* ==============================
     EDIT
  ============================== */
  const editEducacionModal = document.getElementById("editEducacionModal");
  if (editEducacionModal) {
    const selectEdu = editEducacionModal.querySelector("#educacion_select");
    const titulacionInput = editEducacionModal.querySelector("#edit-titulacion");
    const centroInput = editEducacionModal.querySelector("#edit-centro");
    const ubicacionInput = editEducacionModal.querySelector("#edit-ubicacion");
    const fechaInicioInput = editEducacionModal.querySelector("#edit-fecha-inicio");
    const fechaFinInput = editEducacionModal.querySelector("#edit-fecha-fin");
    const ordenInput = editEducacionModal.querySelector("#edit-orden");

    let listaEducacion = [];

    editEducacionModal.addEventListener("show.bs.modal", async () => {
      try {
        const res = await fetch("views/educacion/get.php");
        const data = await res.json();

        if (data.status === "success") {
          listaEducacion = data.data;
          selectEdu.innerHTML = `<option value="">-- Selecciona una titulación --</option>`;
          listaEducacion.forEach(e => {
            selectEdu.innerHTML += `<option value="${e.id}">${e.titulacion} (${e.centro})</option>`;
          });
        } else {
          selectEdu.innerHTML = `<option value="">⚠ No hay registros</option>`;
        }
      } catch (err) {
        console.error("Error cargando educación:", err);
        selectEdu.innerHTML = `<option value="">⚠ Error de conexión</option>`;
      }
    });

    selectEdu.addEventListener("change", () => {
      const id = selectEdu.value;
      const edu = listaEducacion.find(e => e.id == id);
      if (!edu) return;

      titulacionInput.value = edu.titulacion || "";
      centroInput.value = edu.centro || "";
      ubicacionInput.value = edu.ubicacion || "";
      fechaInicioInput.value = edu.fecha_inicio || "";
      fechaFinInput.value = edu.fecha_fin || "";
      ordenInput.value = edu.orden || "";
    });

    const editForm = editEducacionModal.querySelector("#editEducacionForm");
    editForm.addEventListener("submit", async (e) => {
      e.preventDefault();

      const id = selectEdu.value;
      if (!id) {
        showConfirm("⚠ Selecciona primero un registro", "error");
        return;
      }

      const newData = {
        id,
        titulacion: titulacionInput.value.trim(),
        centro: centroInput.value.trim(),
        ubicacion: ubicacionInput.value.trim(),
        fecha_inicio: fechaInicioInput.value,
        fecha_fin: fechaFinInput.value,
        orden: ordenInput.value.trim()
      };

      try {
        const res = await fetch("views/educacion/update.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(newData)
        });
        const data = await res.json();

        if (data.status === "success") {
          bootstrap.Modal.getInstance(editEducacionModal).hide();
          showConfirm(data.message || "✅ Educación actualizada correctamente", "success");

          // 🚀 Refrescar después de editar
          setTimeout(() => location.reload(), 1200);
        } else {
          showConfirm(data.message || "❌ Error al actualizar educación", "error");
        }
      } catch (err) {
        console.error("Update error:", err);
        showConfirm("❌ Error de conexión con el servidor", "error");
      }
    });
  }

  /* ==============================
     DELETE
  ============================== */
  const deleteForm = document.getElementById("deleteEducacionForm");
  if (deleteForm) {
    deleteForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const formData = new FormData(deleteForm);

      try {
        const res = await fetch("views/educacion/delete.php", {
          method: "POST",
          body: formData
        });
        const data = await res.json();

        if (data.status === "success") {
          bootstrap.Modal.getInstance(document.getElementById("deleteEducacionModal")).hide();
          showConfirm(data.message || "✅ Registro de educación borrado correctamente", "success");

          // 🚀 Refrescar después de borrar
          setTimeout(() => location.reload(), 1200);
        } else {
          showConfirm(data.message || "⚠ No se pudo borrar el registro", "error");
        }
      } catch (err) {
        console.error("Delete error:", err);
        showConfirm("❌ Error de conexión al borrar", "error");
      }
    });
  }
});

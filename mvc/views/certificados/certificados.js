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
     MODAL CONFIRM GENÉRICO (OK/KO)
  ============================== */
  function showConfirm(msg = "Operación realizada correctamente", type = "success") {
    const modalEl = document.getElementById("modalConfirmCertificado");
    if (!modalEl) {
      alert(msg);
      return;
    }

    const msgEl  = document.getElementById("modalConfirmCertificadoMsg");
    const iconEl = document.getElementById("modalConfirmCertificadoIcon");

    if (msgEl) msgEl.textContent = msg;
    if (iconEl) {
      iconEl.className =
        type === "success"
          ? "fas fa-check-circle fa-3x mb-3 text-success"
          : "fas fa-times-circle fa-3x mb-3 text-danger";
    }

    const modal = new bootstrap.Modal(modalEl);
    modal.show();
  }

  /* ==============================
     MODAL CONFIRMACIÓN (Aceptar / Cancelar)
  ============================== */
  function showConfirmAction(msg, onConfirm) {
    const modalEl = document.getElementById("modalConfirmAction");
    const msgEl   = document.getElementById("modalConfirmActionMsg");
    const okBtn   = document.getElementById("modalConfirmActionOk");

    if (msgEl) msgEl.textContent = msg || "¿Estás seguro de realizar esta acción?";

    const modal = new bootstrap.Modal(modalEl);
    modal.show();

    okBtn.onclick = () => {
      modal.hide();
      if (typeof onConfirm === "function") onConfirm();
    };
  }

  /* ==============================
     REFRESCAR LISTA CERTIFICADOS
  ============================== */
  async function refreshCertificados() {
    try {
      const res = await fetch("views/certificados/get.php");
      const data = await res.json();

      if (data.status === "success") {
        const cont = document.querySelector("#cert-list");
        if (!cont) return;

        let html = `<ul class="list-unstyled">`;
        data.data.forEach(c => {
          html += `
            <li class="mb-3">
              <strong>${c.titulo}</strong><br>
              <span>${c.entidad} (${c.fecha})</span><br>
              ${c.url ? `<a href="${c.url}" target="_blank">Ver certificado</a>` : ""}
            </li>`;
        });
        html += `</ul>`;
        cont.innerHTML = html;
      }
    } catch (err) {
      console.error("❌ Error al refrescar certificados:", err);
    }
  }

  /* ==============================
     INSERTAR CERTIFICADO
  ============================== */
  const insertCertForm = document.getElementById("insertCertificadoForm");
  if (insertCertForm) {
    insertCertForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const formData = new FormData(insertCertForm);

      try {
        const res = await fetch("views/certificados/insert.php", { method: "POST", body: formData });
        const data = await res.json();

        if (data.status === "success") {
          bootstrap.Modal.getInstance(document.getElementById("insertCertificadoModal")).hide();
          insertCertForm.reset();
          await refreshCertificados(); // 🔄 refrescar lista
          showConfirm("✅ Certificado añadido correctamente", "success");
        } else {
          showConfirm(data.message || "❌ Error al insertar certificado", "error");
        }
      } catch (err) {
        console.error("❌ Error de conexión en insert:", err);
        showConfirm("❌ Error de conexión con el servidor", "error");
      }
    });
  }

  /* ==============================
     EDITAR CERTIFICADO
  ============================== */
  const editModal = document.getElementById("editCertificadoModal");
  if (editModal) {
    const editForm      = editModal.querySelector("#editCertificadoForm");
    const selectCert    = editModal.querySelector("#certificado_select");
    const tituloInput   = editModal.querySelector("#edit-titulo");
    const entidadInput  = editModal.querySelector("#edit-entidad");
    const fechaInput    = editModal.querySelector("#edit-fecha");
    const urlInput      = editModal.querySelector("#edit-url");
    const ordenInput    = editModal.querySelector("#edit-orden");
    const seccionSelect = editModal.querySelector("#edit-seccion_id");

    let listaCertificados = [];

    // Al abrir modal → cargar lista
    editModal.addEventListener("show.bs.modal", async () => {
      try {
        const res = await fetch("views/certificados/get.php");
        const data = await res.json();

        if (data.status === "success") {
          listaCertificados = data.data;
          selectCert.innerHTML = `<option value="">-- Selecciona Certificado --</option>`;
          listaCertificados.forEach(c => {
            selectCert.innerHTML += `<option value="${c.id}">${c.titulo} (${c.entidad})</option>`;
          });
        }
      } catch (err) {
        console.error("❌ Error cargando certificados:", err);
      }
    });

    // Al seleccionar certificado → rellenar campos
    selectCert.addEventListener("change", () => {
      const cert = listaCertificados.find(c => c.id == selectCert.value);
      if (!cert) return;

      tituloInput.value   = cert.titulo   || "";
      entidadInput.value  = cert.entidad  || "";
      fechaInput.value    = cert.fecha    || "";
      urlInput.value      = cert.url      || "";
      ordenInput.value    = cert.orden !== null ? String(cert.orden) : "";
      if (seccionSelect) seccionSelect.value = cert.seccion_id || "";

      const hiddenId = editForm.querySelector("input[name='id']");
      if (hiddenId) hiddenId.value = cert.id;
      const hiddenUsuario = editForm.querySelector("input[name='usuario_id']");
      if (hiddenUsuario) hiddenUsuario.value = cert.usuario_id;
    });

    // Submit edición
    editForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const id = selectCert.value;
      if (!id) return showConfirm("⚠️ Selecciona primero un certificado", "error");

      const newData = {
        id,
        usuario_id: editForm.querySelector("input[name='usuario_id']")?.value || null,
        titulo: tituloInput.value.trim(),
        entidad: entidadInput.value.trim(),
        fecha: fechaInput.value.trim(),
        url: urlInput.value.trim() || null,
        orden: ordenInput.value.trim() || null,
        seccion_id: seccionSelect.value || null
      };

      try {
        const res = await fetch("views/certificados/update.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(newData)
        });
        const data = await res.json();

        if (data.status === "success") {
          bootstrap.Modal.getInstance(editModal).hide();
          await refreshCertificados(); // 🔄 refrescar lista
          showConfirm("✅ Certificado actualizado correctamente", "success");
        } else {
          showConfirm(data.message || "❌ No se pudo actualizar el certificado", "error");
        }
      } catch (err) {
        console.error("❌ Error de conexión en update:", err);
        showConfirm("❌ Error de conexión con el servidor", "error");
      }
    });
  }

  /* ==============================
     ELIMINAR CERTIFICADO (con confirmación previa)
  ============================== */
  const deleteForm = document.getElementById("deleteCertificadoForm");
  if (deleteForm) {
    deleteForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const formData = new FormData(deleteForm);

      showConfirmAction("¿Seguro que deseas eliminar este certificado?", async () => {
        try {
          const res = await fetch("views/certificados/delete.php", { method: "POST", body: formData });
          const data = await res.json();

          if (data.status === "success") {
            bootstrap.Modal.getInstance(document.getElementById("deleteCertificadoModal")).hide();
            await refreshCertificados(); // 🔄 refrescar lista
            showConfirm("✅ Certificado eliminado correctamente", "success");
          } else {
            showConfirm(data.message || "❌ No se pudo eliminar el certificado", "error");
          }
        } catch (err) {
          console.error("❌ Error de conexión en delete:", err);
          showConfirm("❌ Error de conexión con el servidor", "error");
        }
      });
    });
  }

  // 🔄 Cargar lista al inicio
  refreshCertificados();
});
